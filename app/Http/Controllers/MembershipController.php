<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MembershipController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        return view('membership.index', compact('user'));
    }

    public function upgrade(Request $request)
    {
        $user = $request->user();
        $cost = 10.00;

        if ($user->wallet_balance < $cost) {
            return back()->withErrors(['balance' => 'Insufficient balance. Need $10.00 to upgrade.']);
        }

        DB::transaction(function () use ($user, $cost) {
            $user->decrement('wallet_balance', $cost);
            $user->update(['membership_status' => 'ACTIVE', 'is_elite_verified' => true]);
            Transaction::create(['user_id' => $user->id, 'type' => 'Campaign_Spend', 'amount' => $cost, 'description' => 'Elite Membership Upgrade', 'status' => 'Completed']);
        });

        return redirect()->route('dashboard')->with('success', 'Welcome to Elite Membership!');
    }

    public function convertPoints(Request $request)
    {
        $validated = $request->validate(['type' => 'required|in:subscription,visibility']);
        $user = $request->user();

        if ($validated['type'] === 'subscription') {
            if ($user->points < 5000) return back()->withErrors(['points' => 'Insufficient points. Need 5,000 points.']);
            $user->decrement('points', 5000);
            $user->update(['membership_status' => 'ACTIVE']);
            return back()->with('success', 'Subscription activated using 5,000 points!');
        }

        if ($validated['type'] === 'visibility') {
            if ($user->points < 1000) return back()->withErrors(['points' => 'Insufficient points. Need 1,000 points.']);
            $user->decrement('points', 1000);
            $user->update(['visibility_score' => min(100, $user->visibility_score + 20)]);
            return back()->with('success', 'Visibility boosted by 20 points!');
        }
    }
}
