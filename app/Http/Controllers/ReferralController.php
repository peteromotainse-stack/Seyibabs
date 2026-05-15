<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ReferralController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $referredUsers = User::where('referred_by', $user->referral_code)
            ->select('name', 'username', 'avatar', 'created_at', 'membership_status')
            ->latest()
            ->get();

        return view('referrals.index', compact('user', 'referredUsers'));
    }
}
