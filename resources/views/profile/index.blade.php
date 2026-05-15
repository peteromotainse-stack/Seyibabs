@extends('layouts.app')
@section('title', 'My Profile')
@section('page-title', 'My Profile')

@section('content')
<div class="max-w-3xl mx-auto space-y-6 fade-in">

    <div class="glass rounded-3xl p-8 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-indigo-600/5 to-fuchsia-600/5 pointer-events-none"></div>
        <div class="relative flex items-center gap-6 flex-wrap">
            <div class="relative">
                <img src="{{ $user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=6366f1&color=fff&size=120' }}"
                     alt="{{ $user->name }}" class="w-24 h-24 rounded-3xl object-cover border-4 border-slate-800">
                @if($user->is_elite_verified)
                    <div class="absolute -top-2 -right-2 w-8 h-8 bg-indigo-600 rounded-full flex items-center justify-center neo-shadow">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                    </div>
                @endif
            </div>
            <div>
                <h2 class="text-2xl font-black text-white">{{ $user->name }}</h2>
                <p class="text-slate-400">@{{ $user->username }}</p>
                <div class="flex items-center gap-3 mt-2 flex-wrap">
                    <span class="text-xs font-bold px-3 py-1 rounded-full border {{ $user->membership_status === 'ACTIVE' ? 'bg-indigo-500/10 text-indigo-400 border-indigo-500/20' : 'bg-slate-800 text-slate-400 border-slate-700' }}">
                        {{ $user->membership_status === 'ACTIVE' ? '✶ Elite Member' : 'Free Member' }}
                    </span>
                    <span class="text-xs text-slate-500">Joined {{ \Carbon\Carbon::parse($user->created_at)->format('M Y') }}</span>
                </div>
            </div>
            <div class="ml-auto grid grid-cols-3 gap-4 text-center">
                <div><p class="text-xl font-black text-white">{{ number_format($user->followers_count) }}</p><p class="text-xs text-slate-500">Followers</p></div>
                <div><p class="text-xl font-black text-white">{{ number_format($user->following_count) }}</p><p class="text-xs text-slate-500">Following</p></div>
                <div><p class="text-xl font-black text-amber-400">{{ number_format($user->points) }}</p><p class="text-xs text-slate-500">Points</p></div>
            </div>
        </div>
    </div>

    <div class="glass rounded-3xl p-8">
        <h3 class="text-base font-bold text-white mb-6">Edit Profile</h3>
        <form method="POST" action="{{ route('profile.update') }}" class="space-y-5">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-wide">Full Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}"
                           class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-slate-200 text-sm focus:outline-none focus:border-indigo-500 transition-colors">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-wide">Username</label>
                    <input type="text" name="username" value="{{ old('username', $user->username) }}"
                           class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-slate-200 text-sm focus:outline-none focus:border-indigo-500 transition-colors">
                </div>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-wide">Phone</label>
                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="+1 234 567 8900"
                       class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-slate-200 text-sm focus:outline-none focus:border-indigo-500 transition-colors placeholder-slate-600">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-400 mb-3 uppercase tracking-wide">Interests</label>
                <div class="flex flex-wrap gap-2">
                    @php
                    $allInterests = ['Tech','Music','Travel','Gaming','Art','Fashion','Food','Sports','Business','Health','Lifestyle','Beauty','Books','Cooking','Cars','Education','Finance','Photography'];
                    $userInterests = $user->interests ?? [];
                    @endphp
                    @foreach ($allInterests as $interest)
                        <label class="cursor-pointer">
                            <input type="checkbox" name="interests[]" value="{{ $interest }}"
                                   {{ in_array($interest, $userInterests) ? 'checked' : '' }} class="sr-only peer">
                            <span class="inline-block px-3 py-1.5 rounded-xl text-xs font-bold border border-slate-700 text-slate-400 peer-checked:bg-indigo-500/10 peer-checked:text-indigo-400 peer-checked:border-indigo-500/30 transition-all cursor-pointer hover:border-slate-600">
                                {{ $interest }}
                            </span>
                        </label>
                    @endforeach
                </div>
            </div>
            <button type="submit" class="w-full py-4 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-2xl text-sm transition-all shadow-lg shadow-indigo-600/20">Save Changes</button>
        </form>
    </div>

    <div class="glass rounded-3xl p-8">
        <h3 class="text-base font-bold text-white mb-6">Social Media Handles</h3>
        <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
            @csrf
            <input type="hidden" name="name" value="{{ $user->name }}">
            <input type="hidden" name="username" value="{{ $user->username }}">
            @php
            $platforms = ['Instagram','TikTok','Twitter','YouTube','Facebook','Spotify'];
            $handlesMap = $user->socialHandles->pluck('handle', 'platform')->toArray();
            $platformColors = ['Instagram' => 'text-pink-500', 'TikTok' => 'text-cyan-400', 'Twitter' => 'text-blue-400', 'YouTube' => 'text-red-500', 'Facebook' => 'text-blue-600', 'Spotify' => 'text-green-500'];
            @endphp
            <div class="grid grid-cols-2 gap-4">
                @foreach ($platforms as $platform)
                @php $key = 'handle_' . strtolower(str_replace(' ', '_', $platform)); @endphp
                <div>
                    <label class="block text-xs font-bold mb-2 {{ $platformColors[$platform] ?? 'text-slate-400' }} uppercase tracking-wide">{{ $platform }}</label>
                    <input type="text" name="{{ $key }}" value="{{ old($key, $handlesMap[$platform] ?? '') }}"
                           placeholder="@your_handle"
                           class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-slate-200 text-sm focus:outline-none focus:border-indigo-500 transition-colors placeholder-slate-600">
                </div>
                @endforeach
            </div>
            <button type="submit" class="w-full py-4 bg-slate-800 hover:bg-slate-700 text-white font-bold rounded-2xl text-sm transition-all border border-slate-700">Update Social Handles</button>
        </form>
    </div>

    <div class="glass rounded-3xl p-8">
        <h3 class="text-base font-bold text-white mb-6">Change Password</h3>
        <form method="POST" action="{{ route('profile.password') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-wide">Current Password</label>
                <input type="password" name="current_password"
                       class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-slate-200 text-sm focus:outline-none focus:border-indigo-500 transition-colors">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-wide">New Password</label>
                    <input type="password" name="password"
                           class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-slate-200 text-sm focus:outline-none focus:border-indigo-500 transition-colors">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-wide">Confirm Password</label>
                    <input type="password" name="password_confirmation"
                           class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-slate-200 text-sm focus:outline-none focus:border-indigo-500 transition-colors">
                </div>
            </div>
            <button type="submit" class="w-full py-4 bg-rose-600 hover:bg-rose-500 text-white font-bold rounded-2xl text-sm transition-all">Update Password</button>
        </form>
    </div>
</div>
@endsection
