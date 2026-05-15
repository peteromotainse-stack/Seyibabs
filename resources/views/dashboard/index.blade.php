@extends('layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Overview')

@section('content')
<div class="space-y-8 fade-in">

    {{-- Welcome Banner --}}
    <div class="glass rounded-3xl p-8 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-indigo-600/10 to-fuchsia-600/5 pointer-events-none"></div>
        <div class="relative flex items-center justify-between flex-wrap gap-4">
            <div>
                <p class="text-slate-400 text-sm font-medium mb-1">Welcome back,</p>
                <h1 class="text-3xl font-black text-white">{{ $user->name }} 👋</h1>
                <p class="text-slate-400 mt-2 text-sm">
                    @if($user->membership_status === 'ACTIVE')
                        <span class="inline-flex items-center gap-1.5 bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 rounded-full px-3 py-1 text-xs font-bold">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            Elite Member
                        </span>
                    @else
                        <a href="{{ route('membership.index') }}" class="inline-flex items-center gap-1.5 bg-amber-500/10 text-amber-400 border border-amber-500/20 rounded-full px-3 py-1 text-xs font-bold hover:bg-amber-500/20 transition-colors">
                            Upgrade to Elite →
                        </a>
                    @endif
                </p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('campaigns.index') }}" class="flex items-center gap-2 bg-indigo-600 hover:bg-indigo-500 text-white px-5 py-3 rounded-xl text-sm font-bold transition-all shadow-lg shadow-indigo-600/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    Earn Now
                </a>
                <a href="{{ route('campaigns.create') }}" class="flex items-center gap-2 bg-slate-800 hover:bg-slate-700 text-slate-200 px-5 py-3 rounded-xl text-sm font-bold transition-all border border-slate-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    New Campaign
                </a>
            </div>
        </div>
    </div>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        @php
        $stats = [
            ['label' => 'Wallet Balance', 'value' => '$'.number_format($user->wallet_balance,2), 'sub' => 'Available USD', 'color' => 'emerald', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>'],
            ['label' => 'Points',         'value' => number_format($user->points),           'sub' => 'Total Points',    'color' => 'amber',   'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>'],
            ['label' => 'Visibility',     'value' => $user->visibility_score.'/100',         'sub' => 'Score',           'color' => 'indigo',  'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>'],
            ['label' => 'Engagement',     'value' => number_format($user->engagement_rate,1).'%', 'sub' => 'Rate',       'color' => 'fuchsia', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>'],
        ];
        @endphp
        @foreach ($stats as $stat)
        <div class="glass rounded-2xl p-6 glass-hover">
            <div class="flex items-start justify-between mb-4">
                <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">{{ $stat['label'] }}</p>
                <div class="w-8 h-8 rounded-xl bg-{{ $stat['color'] }}-500/10 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-{{ $stat['color'] }}-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">{!! $stat['icon'] !!}</svg>
                </div>
            </div>
            <p class="text-2xl font-black text-white">{{ $stat['value'] }}</p>
            <p class="text-xs text-slate-500 mt-1">{{ $stat['sub'] }}</p>
        </div>
        @endforeach
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        {{-- Recent Transactions --}}
        <div class="lg:col-span-2 glass rounded-3xl p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-base font-bold text-white">Recent Transactions</h3>
                <a href="{{ route('wallet.index') }}" class="text-xs text-indigo-400 hover:text-indigo-300 font-semibold">View all →</a>
            </div>
            @if($recentTransactions->isEmpty())
                <div class="text-center py-12 text-slate-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mx-auto mb-3 opacity-30" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    <p class="text-sm">No transactions yet</p>
                </div>
            @else
                <div class="space-y-3">
                    @foreach ($recentTransactions as $tx)
                    @php
                        $colors = ['Earning' => 'emerald', 'Deposit' => 'blue', 'Withdrawal' => 'rose', 'Campaign_Spend' => 'amber'];
                        $signs  = ['Earning' => '+', 'Deposit' => '+', 'Withdrawal' => '-', 'Campaign_Spend' => '-'];
                        $c = $colors[$tx->type] ?? 'slate';
                        $s = $signs[$tx->type] ?? '';
                    @endphp
                    <div class="flex items-center justify-between p-4 rounded-2xl bg-slate-900/40 hover:bg-slate-900/60 transition-colors">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-{{ $c }}-500/10 flex items-center justify-center">
                                <span class="text-{{ $c }}-400 text-sm font-black">{{ $s }}</span>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-slate-200">{{ $tx->description }}</p>
                                <p class="text-xs text-slate-500">{{ \Carbon\Carbon::parse($tx->created_at)->format('M d, Y') }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-bold text-{{ $c }}-400">{{ $s }}${{ number_format($tx->amount, 2) }}</p>
                            <span class="text-[10px] bg-{{ $c }}-500/10 text-{{ $c }}-400 px-2 py-0.5 rounded-full">{{ $tx->status }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Quick Stats --}}
        <div class="space-y-4">
            <div class="glass rounded-3xl p-6">
                <h3 class="text-base font-bold text-white mb-4">Quick Stats</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-slate-400">Total Earned</span>
                        <span class="text-sm font-bold text-emerald-400">${{ number_format($totalEarned, 2) }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-slate-400">Total Withdrawn</span>
                        <span class="text-sm font-bold text-slate-300">${{ number_format($user->total_withdrawn, 2) }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-slate-400">Active Campaigns</span>
                        <span class="text-sm font-bold text-indigo-400">{{ $activeCampaigns }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-slate-400">Referral Code</span>
                        <span class="text-sm font-mono font-bold text-fuchsia-400">{{ $user->referral_code ?? 'N/A' }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-slate-400">Warnings</span>
                        <span class="text-sm font-bold {{ $user->warnings > 0 ? 'text-rose-400' : 'text-emerald-400' }}">{{ $user->warnings }}</span>
                    </div>
                </div>
            </div>

            <div class="glass rounded-3xl p-6">
                <h3 class="text-sm font-bold text-white mb-4">Visibility Score</h3>
                <div class="relative h-2 bg-slate-800 rounded-full mb-2">
                    <div class="absolute h-full bg-gradient-to-r from-indigo-500 to-fuchsia-500 rounded-full" style="width: {{ $user->visibility_score }}%"></div>
                </div>
                <div class="flex justify-between text-xs text-slate-500">
                    <span>0</span>
                    <span class="font-bold text-indigo-400">{{ $user->visibility_score }}%</span>
                    <span>100</span>
                </div>
                <a href="{{ route('membership.index') }}" class="mt-4 block text-center text-xs text-indigo-400 hover:text-indigo-300 font-semibold">Boost Visibility →</a>
            </div>
        </div>
    </div>
</div>
@endsection
