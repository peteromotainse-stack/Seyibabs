<?php

namespace App\Http\Controllers;

use App\Models\FollowsPact;
use App\Models\User;
use Illuminate\Http\Request;

class CommunityController extends Controller
{
    public function index(Request $request)
    {
        $currentUser = $request->user();
        $members = User::with('socialHandles')
            ->where('id', '!=', $currentUser->id)
            ->orderByDesc('points')
            ->get();

        $syncedIds = FollowsPact::where('follower_id', $currentUser->id)
            ->pluck('following_id')
            ->toArray();

        return view('community.index', compact('currentUser', 'members', 'syncedIds'));
    }

    public function sync(Request $request, User $member)
    {
        $currentUser = $request->user();

        $exists = FollowsPact::where('follower_id', $currentUser->id)
            ->where('following_id', $member->id)
            ->exists();

        if (!$exists) {
            FollowsPact::create([
                'follower_id'  => $currentUser->id,
                'following_id' => $member->id,
                'platform'     => 'General',
                'is_reciprocal'=> false,
            ]);
            $currentUser->increment('following_count');
            $member->increment('followers_count');
        }

        return back()->with('success', 'Synced with ' . $member->name . '!');
    }
}
