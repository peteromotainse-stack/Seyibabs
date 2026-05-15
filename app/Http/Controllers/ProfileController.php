<?php

namespace App\Http\Controllers;

use App\Models\SocialHandle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user()->load('socialHandles');
        return view('profile.index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = $request->user();
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'username'  => 'required|string|max:255|unique:users,username,' . $user->id,
            'phone'     => 'nullable|string|max:20',
            'interests' => 'nullable|array',
        ]);

        $user->update($validated);

        foreach (['Instagram','TikTok','Twitter','YouTube','Facebook','Spotify'] as $platform) {
            $key = 'handle_' . strtolower(str_replace(' ', '_', $platform));
            $handle = $request->input($key);
            if ($handle !== null) {
                SocialHandle::updateOrCreate(['user_id' => $user->id, 'platform' => $platform], ['handle' => $handle]);
            }
        }

        return back()->with('success', 'Profile updated successfully!');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required',
            'password'         => 'required|min:8|confirmed',
        ]);

        $user = $request->user();
        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->update(['password' => $validated['password']]);
        return back()->with('success', 'Password updated successfully!');
    }

    public function destroy(Request $request)
    {
        $request->validate(['password' => 'required|current_password']);
        $user = $request->user();
        Auth::logout();
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
