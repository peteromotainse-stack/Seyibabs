<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\CampaignCompletion;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CampaignController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user()->load('socialHandles');
        $campaigns = Campaign::with('user')
            ->where('remaining_slots', '>', 0)
            ->latest()
            ->get();

        $completedIds = CampaignCompletion::where('user_id', $user->id)
            ->pluck('campaign_id')
            ->toArray();

        return view('campaigns.index', compact('user', 'campaigns', 'completedIds'));
    }

    public function create(Request $request)
    {
        $user = $request->user();
        return view('campaigns.create', compact('user'));
    }

    public function store(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'platform'       => 'required|string',
            'action_type'    => 'required|string',
            'link'           => 'required|url',
            'description'    => 'required|string|max:500',
            'total_slots'    => 'required|integer|min:1',
            'reward_type'    => 'required|in:Points,Cash,Reciprocity',
            'campaign_type'  => 'required|in:Paid,Reciprocity',
            'reward_value'   => 'required|numeric|min:0',
            'budget'         => 'nullable|numeric|min:0',
            'use_ai'         => 'nullable|boolean',
            'target_location'=> 'nullable|string',
        ]);

        if ($validated['campaign_type'] === 'Paid') {
            $budget = $validated['budget'] ?? 0;
            if ($budget > $user->wallet_balance) {
                return back()->withErrors(['budget' => 'Insufficient wallet balance.'])->withInput();
            }
        }

        if ($validated['campaign_type'] === 'Reciprocity' && $user->membership_status !== 'ACTIVE') {
            return back()->withErrors(['campaign_type' => 'Only active members can launch reciprocity campaigns.'])->withInput();
        }

        DB::transaction(function () use ($user, $validated, $request) {
            Campaign::create([
                ...$validated,
                'user_id'          => $user->id,
                'remaining_slots'  => $validated['total_slots'],
                'creator_interests'=> $user->interests ?? [],
                'use_ai'           => $request->boolean('use_ai'),
            ]);

            if ($validated['campaign_type'] === 'Paid' && ($validated['budget'] ?? 0) > 0) {
                $user->decrement('wallet_balance', $validated['budget']);
                Transaction::create([
                    'user_id'     => $user->id,
                    'type'        => 'Campaign_Spend',
                    'amount'      => $validated['budget'],
                    'description' => "Campaign Launch: {$validated['platform']} {$validated['action_type']}",
                    'status'      => 'Completed',
                ]);
            }
        });

        return redirect()->route('campaigns.index')->with('success', 'Campaign launched successfully!');
    }

    public function complete(Request $request, Campaign $campaign)
    {
        $user = $request->user();

        if ($campaign->remaining_slots <= 0) {
            return back()->with('error', 'No slots remaining for this campaign.');
        }

        $alreadyCompleted = CampaignCompletion::where('campaign_id', $campaign->id)
            ->where('user_id', $user->id)
            ->exists();

        if ($alreadyCompleted) {
            return back()->with('error', 'You have already completed this campaign.');
        }

        DB::transaction(function () use ($user, $campaign) {
            CampaignCompletion::create([
                'campaign_id' => $campaign->id,
                'user_id'     => $user->id,
            ]);

            $campaign->decrement('remaining_slots');

            if ($campaign->reward_type === 'Cash') {
                $user->increment('wallet_balance', $campaign->reward_value);
                Transaction::create([
                    'user_id'     => $user->id,
                    'type'        => 'Earning',
                    'amount'      => $campaign->reward_value,
                    'description' => "Campaign Reward: {$campaign->platform} {$campaign->action_type}",
                    'status'      => 'Completed',
                ]);
            } else {
                $user->increment('points', $campaign->reward_value);
            }
        });

        return back()->with('success', 'Campaign completed! Reward credited.');
    }
}
