<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\CampaignCompletion;
use Illuminate\Http\Request;

class ReciprocityController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $completedIds = CampaignCompletion::where('user_id', $user->id)->pluck('campaign_id')->toArray();
        $tasks = Campaign::with('user')
            ->where('campaign_type', 'Reciprocity')
            ->where('user_id', '!=', $user->id)
            ->where('remaining_slots', '>', 0)
            ->whereNotIn('id', $completedIds)
            ->get();

        return view('reciprocity.index', compact('user', 'tasks'));
    }

    public function complete(Request $request, Campaign $campaign)
    {
        $user = $request->user();
        $alreadyDone = CampaignCompletion::where('campaign_id', $campaign->id)->where('user_id', $user->id)->exists();

        if ($alreadyDone) return back()->with('error', 'Already completed this task.');

        CampaignCompletion::create(['campaign_id' => $campaign->id, 'user_id' => $user->id]);
        $campaign->decrement('remaining_slots');
        $user->increment('points', 10);
        $user->update(['visibility_score' => min(100, $user->visibility_score + 2), 'engagement_rate' => min(100, $user->engagement_rate + 0.5)]);

        return back()->with('success', '+10 points earned! Visibility increased.');
    }

    public function ignore(Request $request, Campaign $campaign)
    {
        $user = $request->user();
        $user->increment('warnings');
        $user->update(['points' => max(0, $user->points - 50), 'visibility_score' => max(0, $user->visibility_score - 10), 'engagement_rate' => max(0, $user->engagement_rate - 2)]);
        return back()->with('warning', 'Task ignored. -50 points penalty applied.');
    }

    public function appeal(Request $request)
    {
        return back()->with('success', 'Appeal sent to support@wetaract.com. We will review within 24-48 hours.');
    }
}
