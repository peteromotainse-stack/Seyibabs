<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user()->load('socialHandles', 'transactions', 'campaigns');
        $recentTransactions = $user->transactions()->take(5)->get();
        $activeCampaigns = $user->campaigns()->where('remaining_slots', '>', 0)->count();
        $totalEarned = $user->transactions()->where('type', 'Earning')->sum('amount');

        return view('dashboard.index', compact('user', 'recentTransactions', 'activeCampaigns', 'totalEarned'));
    }
}
