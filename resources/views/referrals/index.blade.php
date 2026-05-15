@extends('layouts.app')
@section('title', 'Refer & Earn')
@section('page-title', 'Refer & Earn')

@section('content')
<div class="space-y-6 fade-in">
    <div class="glass rounded-3xl p-8 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-fuchsia-600/10 to-indigo-600/5 pointer-events-none"></div>
        <div class="relative grid md:grid-cols-2 gap-8 items-center">
            <div>
                <span class="text-xs font-black text-fuchsia-400 uppercase tracking-widest bg-fuchsia-500/10 border border-fuchsia-500/20 px-3 py-1 rounded-full">Referral Program</span>
                <h2 class="text-3xl font-black text-white mt-4 mb-2">Earn $5 per referral</h2>
                <p class="text-slate-400 text-sm">Invite friends to Wetaract and earn rewards for every active member you bring in.</p>
                <div class="mt-6 flex items-center gap-3">
                    <div class="flex-1 bg-slate-900 border border-slate-700 rounded-xl px-4 py-3">
                        <p class="text-xs text-slate-500 mb-1">Your Referral Code</p>
                        <p class="text-xl font-mono font-black text-fuchsia-400">{{ $user->referral_code ?? 'N/A' }}</p>
                    </div>
                    <button onclick="copyCode('{{ $user->referral_code }}')"
                            class="px-5 py-4 bg-fuchsia-600 hover:bg-fuchsia-500 text-white rounded-xl font-bold text-sm transition-all">Copy</button>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-slate-900/60 rounded-2xl p-5 text-center border border-slate-800">
                    <p class="text-3xl font-black text-white">{{ $user->total_referrals }}</p>
                    <p class="text-xs text-slate-500 mt-1">Total Referrals</p>
                </div>
                <div class="bg-slate-900/60 rounded-2xl p-5 text-center border border-slate-800">
                    <p class="text-3xl font-black text-emerald-400">${{ number_format($user->referral_earnings, 2) }}</p>
                    <p class="text-xs text-slate-500 mt-1">Total Earnings</p>
                </div>
                <div class="bg-slate-900/60 rounded-2xl p-5 text-center border border-slate-800">
                    <p class="text-3xl font-black text-amber-400">${{ number_format($user->referral_pending, 2) }}</p>
                    <p class="text-xs text-slate-500 mt-1">Pending</p>
                </div>
                <div class="bg-slate-900/60 rounded-2xl p-5 text-center border border-slate-800">
                    <p class="text-3xl font-black text-indigo-400">{{ $user->referral_conversion_rate }}</p>
                    <p class="text-xs text-slate-500 mt-1">Conversion Rate</p>
                </div>
            </div>
        </div>
    </div>

    <div class="glass rounded-3xl p-6">
        <h3 class="text-base font-bold text-white mb-4">Share Your Referral Link</h3>
        <div class="flex items-center gap-3 mb-4">
            <input type="text" value="{{ url('/register?ref=' . $user->referral_code) }}" readonly id="referral-link"
                   class="flex-1 bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-slate-300 text-sm font-mono">
            <button onclick="copyLink()" class="px-5 py-3 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl font-bold text-sm transition-all">Copy Link</button>
        </div>
        <div class="flex gap-3 flex-wrap">
            <a href="https://wa.me/?text={{ urlencode('Join Wetaract and earn money! Use my referral code: ' . $user->referral_code . ' or sign up at ' . url('/register?ref=' . $user->referral_code)) }}"
               target="_blank" class="flex items-center gap-2 px-4 py-2.5 bg-green-600 hover:bg-green-500 text-white rounded-xl text-sm font-bold transition-all">WhatsApp</a>
            <a href="https://twitter.com/intent/tweet?text={{ urlencode('Join Wetaract – earn money by engaging on social media! Use my code: ' . $user->referral_code) }}"
               target="_blank" class="flex items-center gap-2 px-4 py-2.5 bg-blue-500 hover:bg-blue-400 text-white rounded-xl text-sm font-bold transition-all">Twitter / X</a>
        </div>
    </div>

    <div class="glass rounded-3xl p-6">
        <h3 class="text-base font-bold text-white mb-6">Referred Members ({{ $referredUsers->count() }})</h3>
        @if($referredUsers->isEmpty())
            <div class="text-center py-12 text-slate-500">
                <p class="text-sm">No referrals yet. Share your code to start earning!</p>
            </div>
        @else
            <div class="space-y-3">
                @foreach ($referredUsers as $referred)
                <div class="flex items-center justify-between p-4 rounded-2xl bg-slate-900/40">
                    <div class="flex items-center gap-3">
                        <img src="{{ $referred->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($referred->name) . '&background=6366f1&color=fff&size=60' }}"
                             alt="{{ $referred->name }}" class="w-10 h-10 rounded-xl object-cover">
                        <div>
                            <p class="text-sm font-bold text-slate-200">{{ $referred->name }}</p>
                            <p class="text-xs text-slate-500">@{{ $referred->username }} · Joined {{ \Carbon\Carbon::parse($referred->created_at)->format('M d, Y') }}</p>
                        </div>
                    </div>
                    <span class="text-[10px] font-black px-2 py-1 rounded-full {{ $referred->membership_status === 'ACTIVE' ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : 'bg-slate-800 text-slate-500' }}">
                        {{ $referred->membership_status === 'ACTIVE' ? 'Active' : 'Inactive' }}
                    </span>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

<script>
function copyCode(code) { navigator.clipboard.writeText(code); alert('Referral code copied: ' + code); }
function copyLink() { const link = document.getElementById('referral-link').value; navigator.clipboard.writeText(link); alert('Referral link copied!'); }
</script>
@endsection
