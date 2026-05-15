@extends('layouts.app')
@section('title', 'Membership')
@section('page-title', 'Upgrade Membership')

@section('content')
<div class="space-y-8 fade-in">

    {{-- Current Status --}}
    <div class="glass rounded-3xl p-8 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-indigo-600/10 to-fuchsia-600/5 pointer-events-none"></div>
        <div class="relative flex items-center justify-between flex-wrap gap-4">
            <div>
                <p class="text-xs font-black text-slate-500 uppercase tracking-widest mb-2">Current Status</p>
                @if($user->membership_status === 'ACTIVE')
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-indigo-600 rounded-2xl flex items-center justify-center neo-shadow">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-black text-white">Elite Member</h3>
                            <p class="text-indigo-400 text-sm font-semibold">All features unlocked</p>
                        </div>
                    </div>
                @else
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-slate-800 rounded-2xl flex items-center justify-center border border-slate-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-black text-white">Free Member</h3>
                            <p class="text-slate-400 text-sm">Upgrade to unlock all features</p>
                        </div>
                    </div>
                @endif
            </div>
            <div class="flex items-center gap-4">
                <div class="text-center">
                    <p class="text-2xl font-black text-amber-400">{{ number_format($user->points) }}</p>
                    <p class="text-xs text-slate-500">Points</p>
                </div>
                <div class="w-px h-12 bg-slate-800"></div>
                <div class="text-center">
                    <p class="text-2xl font-black text-white">${{ number_format($user->wallet_balance, 2) }}</p>
                    <p class="text-xs text-slate-500">Balance</p>
                </div>
            </div>
        </div>
    </div>

    @if($user->membership_status !== 'ACTIVE')
    {{-- Upgrade Plans --}}
    <div class="grid md:grid-cols-2 gap-6">
        {{-- Elite with Cash --}}
        <div class="glass rounded-3xl p-8 border-2 border-indigo-500/30 relative overflow-hidden">
            <div class="absolute top-4 right-4 bg-indigo-600 text-white text-[10px] font-black px-3 py-1 rounded-full uppercase">Popular</div>
            <div class="w-14 h-14 bg-indigo-600 rounded-2xl flex items-center justify-center neo-shadow mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
            </div>
            <h3 class="text-xl font-black text-white mb-1">Elite Membership</h3>
            <p class="text-4xl font-black gradient-text mb-2">$10<span class="text-base text-slate-400 font-normal">/mo</span></p>
            <p class="text-sm text-slate-400 mb-6">Deducted from your Wetaract wallet</p>
            <ul class="space-y-3 mb-8">
                @foreach (['Launch Reciprocity Campaigns','Priority Campaign Placement','Elite Verification Badge','Advanced Analytics','Dedicated Support','Unlimited Campaigns'] as $feature)
                <li class="flex items-center gap-3 text-sm text-slate-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-indigo-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    {{ $feature }}
                </li>
                @endforeach
            </ul>
            <form method="POST" action="{{ route('membership.upgrade') }}">
                @csrf
                <button type="submit" class="w-full py-4 bg-indigo-600 hover:bg-indigo-500 text-white font-black rounded-2xl text-sm transition-all shadow-lg shadow-indigo-600/20 flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    Upgrade Now – $10
                </button>
            </form>
        </div>

        {{-- Points Options --}}
        <div class="space-y-4">
            <div class="glass rounded-3xl p-6">
                <h3 class="text-base font-bold text-white mb-1">Convert Points to Subscription</h3>
                <p class="text-sm text-slate-400 mb-4">Use your earned points to unlock Elite membership</p>
                <div class="flex items-center justify-between mb-4">
                    <span class="text-sm text-slate-300">Required Points</span>
                    <span class="text-lg font-black {{ $user->points >= 5000 ? 'text-emerald-400' : 'text-rose-400' }}">5,000 pts</span>
                </div>
                <div class="h-2 bg-slate-800 rounded-full mb-4">
                    <div class="h-full bg-gradient-to-r from-amber-500 to-amber-400 rounded-full" style="width: {{ min(100, ($user->points / 5000) * 100) }}%"></div>
                </div>
                <p class="text-xs text-slate-500 mb-4">You have {{ number_format($user->points) }} / 5,000 points</p>
                <form method="POST" action="{{ route('membership.convert-points') }}">
                    @csrf
                    <input type="hidden" name="type" value="subscription">
                    <button type="submit" {{ $user->points < 5000 ? 'disabled' : '' }}
                            class="w-full py-3.5 {{ $user->points >= 5000 ? 'bg-amber-600 hover:bg-amber-500' : 'bg-slate-800 cursor-not-allowed opacity-50' }} text-white font-bold rounded-2xl text-sm transition-all">
                        {{ $user->points >= 5000 ? 'Activate with Points' : 'Insufficient Points' }}
                    </button>
                </form>
            </div>

            <div class="glass rounded-3xl p-6">
                <h3 class="text-base font-bold text-white mb-1">Boost Visibility Score</h3>
                <p class="text-sm text-slate-400 mb-4">Convert 1,000 points to +20 visibility score</p>
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-xs text-slate-500">Current Score</p>
                        <p class="text-2xl font-black text-indigo-400">{{ $user->visibility_score }}/100</p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-slate-500">After boost</p>
                        <p class="text-2xl font-black text-white">{{ min(100, $user->visibility_score + 20) }}/100</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('membership.convert-points') }}">
                    @csrf
                    <input type="hidden" name="type" value="visibility">
                    <button type="submit" {{ $user->points < 1000 ? 'disabled' : '' }}
                            class="w-full py-3.5 {{ $user->points >= 1000 ? 'bg-fuchsia-600 hover:bg-fuchsia-500' : 'bg-slate-800 cursor-not-allowed opacity-50' }} text-white font-bold rounded-2xl text-sm transition-all">
                        {{ $user->points >= 1000 ? 'Boost Visibility – 1,000 pts' : 'Need 1,000 points' }}
                    </button>
                </form>
            </div>
        </div>
    </div>
    @else
    {{-- Already Elite --}}
    <div class="glass rounded-3xl p-8 text-center">
        <div class="w-20 h-20 bg-indigo-600 rounded-3xl flex items-center justify-center neo-shadow mx-auto mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
        </div>
        <h3 class="text-2xl font-black text-white mb-2">You're an Elite Member!</h3>
        <p class="text-slate-400 mb-6">You have access to all Wetaract premium features.</p>

        <div class="grid grid-cols-3 gap-4 max-w-md mx-auto mb-8">
            @foreach (['Reciprocity Campaigns' => 'indigo', 'Elite Badge' => 'fuchsia', 'Priority Support' => 'emerald'] as $feature => $color)
            <div class="bg-{{ $color }}-500/10 border border-{{ $color }}-500/20 rounded-2xl p-3">
                <p class="text-xs font-bold text-{{ $color }}-400">{{ $feature }}</p>
            </div>
            @endforeach
        </div>

        {{-- Still allow visibility boost --}}
        <div class="max-w-sm mx-auto">
            <div class="glass rounded-2xl p-5">
                <p class="text-sm font-bold text-white mb-1">Boost Visibility Score</p>
                <p class="text-xs text-slate-400 mb-4">Use 1,000 points for +20 visibility</p>
                <form method="POST" action="{{ route('membership.convert-points') }}">
                    @csrf
                    <input type="hidden" name="type" value="visibility">
                    <button type="submit" {{ $user->points < 1000 ? 'disabled' : '' }}
                            class="w-full py-3 {{ $user->points >= 1000 ? 'bg-fuchsia-600 hover:bg-fuchsia-500' : 'bg-slate-800 opacity-50 cursor-not-allowed' }} text-white font-bold rounded-xl text-sm transition-all">
                        Boost – 1,000 pts (You have {{ number_format($user->points) }})
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
