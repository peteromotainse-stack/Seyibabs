@extends('layouts.app')
@section('title', 'Create Campaign')
@section('page-title', 'Ad Manager')

@section('content')
<div class="max-w-2xl mx-auto fade-in">
    <div class="mb-8">
        <h2 class="text-2xl font-black text-white">Launch a Campaign</h2>
        <p class="text-slate-400 text-sm mt-1">Create paid or reciprocity campaigns to grow your social presence.</p>
    </div>

    <form method="POST" action="{{ route('campaigns.store') }}" class="space-y-6">
        @csrf

        <div class="glass rounded-3xl p-8 space-y-6">
            <h3 class="text-sm font-bold text-slate-400 uppercase tracking-widest">Campaign Type</h3>
            <div class="grid grid-cols-2 gap-4">
                @php $campType = old('campaign_type', 'Paid'); @endphp
                <label class="cursor-pointer">
                    <input type="radio" name="campaign_type" value="Paid" class="sr-only peer" {{ $campType === 'Paid' ? 'checked' : '' }}>
                    <div class="p-5 rounded-2xl border-2 border-slate-700 peer-checked:border-indigo-500 peer-checked:bg-indigo-500/10 transition-all text-center">
                        <p class="font-bold text-white text-sm">Paid Campaign</p>
                        <p class="text-xs text-slate-400 mt-1">Pay users to engage with your content</p>
                    </div>
                </label>
                <label class="cursor-pointer">
                    <input type="radio" name="campaign_type" value="Reciprocity" class="sr-only peer" {{ $campType === 'Reciprocity' ? 'checked' : '' }}>
                    <div class="p-5 rounded-2xl border-2 border-slate-700 peer-checked:border-indigo-500 peer-checked:bg-indigo-500/10 transition-all text-center">
                        <p class="font-bold text-white text-sm">Reciprocity</p>
                        <p class="text-xs text-slate-400 mt-1">Mutual growth pact (Members only)</p>
                    </div>
                </label>
            </div>
        </div>

        <div class="glass rounded-3xl p-8 space-y-5">
            <h3 class="text-sm font-bold text-slate-400 uppercase tracking-widest">Platform & Action</h3>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-wide">Platform</label>
                    <select name="platform" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-slate-200 text-sm focus:outline-none focus:border-indigo-500 transition-colors">
                        @foreach (['Instagram','TikTok','Twitter','YouTube','Facebook','Spotify'] as $p)
                            <option value="{{ $p }}" {{ old('platform') === $p ? 'selected' : '' }}>{{ $p }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-wide">Action Type</label>
                    <select name="action_type" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-slate-200 text-sm focus:outline-none focus:border-indigo-500 transition-colors">
                        @foreach (['Like','Follow','Comment','Share','Stream','View','Repost','Play'] as $a)
                            <option value="{{ $a }}" {{ old('action_type') === $a ? 'selected' : '' }}>{{ $a }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-wide">Content Link</label>
                <input type="url" name="link" value="{{ old('link') }}" placeholder="https://instagram.com/p/your-post"
                       class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-slate-200 text-sm focus:outline-none focus:border-indigo-500 transition-colors placeholder-slate-600">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-wide">Description</label>
                <textarea name="description" rows="3" placeholder="Describe what you want people to do..."
                          class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-slate-200 text-sm focus:outline-none focus:border-indigo-500 transition-colors placeholder-slate-600 resize-none">{{ old('description') }}</textarea>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-wide">Target Location (Optional)</label>
                <input type="text" name="target_location" value="{{ old('target_location', 'Global') }}" placeholder="e.g. USA, Nigeria, Global"
                       class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-slate-200 text-sm focus:outline-none focus:border-indigo-500 transition-colors placeholder-slate-600">
            </div>
        </div>

        <div class="glass rounded-3xl p-8 space-y-5">
            <h3 class="text-sm font-bold text-slate-400 uppercase tracking-widest">Reward & Budget</h3>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-wide">Reward Type</label>
                    <select name="reward_type" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-slate-200 text-sm focus:outline-none focus:border-indigo-500 transition-colors">
                        <option value="Points" {{ old('reward_type','Points') === 'Points' ? 'selected' : '' }}>Points</option>
                        <option value="Cash" {{ old('reward_type') === 'Cash' ? 'selected' : '' }}>Cash (USD)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-wide">Reward Per Person</label>
                    <input type="number" name="reward_value" value="{{ old('reward_value', '50') }}" min="0" step="0.01"
                           class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-slate-200 text-sm focus:outline-none focus:border-indigo-500 transition-colors">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-wide">Total Slots</label>
                    <input type="number" name="total_slots" value="{{ old('total_slots', '100') }}" min="1"
                           class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-slate-200 text-sm focus:outline-none focus:border-indigo-500 transition-colors">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-wide">Total Budget (USD)</label>
                    <input type="number" name="budget" value="{{ old('budget', '0') }}" min="0" step="0.01"
                           class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-slate-200 text-sm focus:outline-none focus:border-indigo-500 transition-colors">
                </div>
            </div>
            <label class="flex items-center gap-3 p-4 rounded-2xl bg-slate-900/50 border border-slate-800 cursor-pointer hover:border-amber-500/30 transition-colors">
                <input type="checkbox" name="use_ai" value="1" {{ old('use_ai') ? 'checked' : '' }} class="w-4 h-4 rounded text-amber-500 bg-slate-800 border-slate-600">
                <div>
                    <p class="text-sm font-bold text-white">Enable AI Advertisement</p>
                    <p class="text-xs text-slate-400">AI optimizes delivery for maximum reach and engagement</p>
                </div>
                <span class="ml-auto text-[10px] bg-amber-500/10 text-amber-400 border border-amber-500/20 px-2 py-1 rounded-full font-black uppercase">AI</span>
            </label>
        </div>

        <div class="flex items-center justify-between p-5 glass rounded-2xl">
            <div>
                <p class="text-xs text-slate-500">Your wallet balance</p>
                <p class="text-lg font-black text-white">${{ number_format($user->wallet_balance, 2) }}</p>
            </div>
            <button type="submit" class="flex items-center gap-2 bg-indigo-600 hover:bg-indigo-500 text-white px-8 py-4 rounded-2xl font-black text-sm shadow-lg shadow-indigo-600/20 transition-all active:scale-95">
                Launch Campaign
            </button>
        </div>
    </form>
</div>
@endsection
