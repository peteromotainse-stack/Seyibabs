@extends('layouts.app')
@section('title', 'Campaigns')
@section('page-title', 'Campaigns')

@section('content')
<div class="space-y-6 fade-in">

    <div class="flex items-center justify-between flex-wrap gap-4">
        <div>
            <h2 class="text-2xl font-black text-white">Available Campaigns</h2>
            <p class="text-slate-400 text-sm mt-1">Complete tasks and earn cash or points instantly.</p>
        </div>
        <a href="{{ route('campaigns.create') }}" class="flex items-center gap-2 bg-indigo-600 hover:bg-indigo-500 text-white px-5 py-3 rounded-xl text-sm font-bold shadow-lg shadow-indigo-600/20 transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Create Campaign
        </a>
    </div>

    @if($campaigns->isEmpty())
        <div class="glass rounded-3xl p-16 text-center">
            <p class="text-slate-400 text-lg font-semibold">No campaigns available yet</p>
            <p class="text-slate-600 text-sm mt-2">Be the first to create one!</p>
            <a href="{{ route('campaigns.create') }}" class="inline-flex items-center gap-2 mt-6 bg-indigo-600 hover:bg-indigo-500 text-white px-6 py-3 rounded-xl text-sm font-bold transition-all">Create Campaign</a>
        </div>
    @else
        <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-5">
            @foreach ($campaigns as $campaign)
            @php
                $isCompleted = in_array($campaign->id, $completedIds);
                $progress = $campaign->total_slots > 0 ? (1 - $campaign->remaining_slots / $campaign->total_slots) * 100 : 0;
                $isCash = $campaign->reward_type === 'Cash';
                $userInterests = $user->interests ?? [];
                $creatorInterests = $campaign->creator_interests ?? [];
                $isMatch = count(array_intersect($userInterests, $creatorInterests)) > 0;
                $platformColors = ['Instagram'=>'text-pink-500','TikTok'=>'text-cyan-400','Twitter'=>'text-blue-400','YouTube'=>'text-red-500','Facebook'=>'text-blue-600','Spotify'=>'text-green-500'];
                $platformColor = $platformColors[$campaign->platform] ?? 'text-indigo-400';
                $creatorName = $campaign->user->name ?? 'Unknown';
                $creatorAvatar = $campaign->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($creatorName) . '&background=6366f1&color=fff&size=80';
            @endphp
            <div class="glass rounded-[2rem] p-6 glass-hover relative overflow-hidden {{ $isMatch ? 'ring-1 ring-indigo-500/30' : '' }} {{ $isCash ? 'ring-1 ring-emerald-500/20' : '' }}">
                @if($isCash)
                    <div class="absolute top-0 right-0 bg-emerald-600 text-white text-[8px] font-black px-4 py-1 rounded-bl-xl uppercase tracking-widest">Paid Task</div>
                @endif
                @if($campaign->use_ai)
                    <div class="absolute top-8 right-[-24px] rotate-45 bg-amber-500 text-white text-[7px] font-black px-8 py-0.5 uppercase tracking-widest">AI Advert</div>
                @endif

                <div class="flex justify-between items-start mb-5">
                    <div class="flex items-center gap-3">
                        <div class="relative">
                            <div class="w-12 h-12 rounded-2xl bg-slate-800 border border-slate-700 flex items-center justify-center">
                                <img src="{{ $creatorAvatar }}" alt="{{ $creatorName }}" class="w-10 h-10 rounded-xl object-cover">
                            </div>
                            <div class="absolute -bottom-1 -right-1 bg-slate-900 p-0.5 rounded border border-slate-700">
                                <span class="{{ $platformColor }} text-[10px] font-black">{{ substr($campaign->platform, 0, 2) }}</span>
                            </div>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-white">{{ $creatorName }}</h4>
                            <div class="flex items-center gap-2 mt-0.5">
                                <span class="text-[10px] font-black text-slate-500 uppercase">{{ $campaign->platform }}</span>
                                <span class="w-1 h-1 rounded-full bg-slate-700"></span>
                                <span class="text-[10px] font-black text-indigo-400 uppercase">{{ $campaign->action_type }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="{{ $isCash ? 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20' : 'bg-amber-500/10 text-amber-500 border-amber-500/20' }} text-[10px] font-black px-3 py-1.5 rounded-full border flex items-center gap-1.5">
                        @if($isCash)+${{ number_format($campaign->reward_value, 2) }}
                        @else+{{ number_format($campaign->reward_value) }} pts
                        @endif
                    </div>
                </div>

                <p class="text-sm text-slate-400 mb-4 line-clamp-2 leading-relaxed">{{ $campaign->description }}</p>

                <div class="space-y-2 mb-6">
                    <div class="flex justify-between text-[10px] font-bold uppercase tracking-widest text-slate-500">
                        <span>{{ $isCash ? 'Campaign Reach' : 'Community Progress' }}</span>
                        <span>{{ $campaign->total_slots - $campaign->remaining_slots }} / {{ $campaign->total_slots }}</span>
                    </div>
                    <div class="h-1.5 w-full bg-slate-800/50 rounded-full overflow-hidden">
                        <div class="h-full rounded-full {{ $isCash ? 'bg-gradient-to-r from-emerald-500 to-teal-500' : 'bg-gradient-to-r from-indigo-500 to-purple-500' }}" style="width: {{ $progress }}%"></div>
                    </div>
                </div>

                @if($isCompleted)
                    <div class="flex items-center justify-center gap-2 py-3.5 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-xs font-bold">Completed</div>
                @else
                    <div class="flex gap-3">
                        <a href="{{ $campaign->link }}" target="_blank" rel="noopener noreferrer"
                           class="flex-1 flex items-center justify-center gap-2 bg-slate-800/50 hover:bg-slate-800 text-slate-300 py-3.5 rounded-2xl text-xs font-bold border border-slate-700/50 transition-all">View</a>
                        <form method="POST" action="{{ route('campaigns.complete', $campaign) }}" class="flex-1">
                            @csrf
                            <button type="submit" class="w-full flex items-center justify-center gap-2 {{ $isCash ? 'bg-emerald-600 hover:bg-emerald-500' : 'bg-indigo-600 hover:bg-indigo-500' }} text-white py-3.5 rounded-2xl text-xs font-bold shadow-lg transition-all">
                                {{ $isCash ? 'Claim Reward' : 'Verify Action' }}
                            </button>
                        </form>
                    </div>
                @endif

                <div class="mt-4 pt-3 border-t border-slate-800/30 text-center">
                    <span class="text-[8px] font-black text-slate-500 uppercase tracking-widest">{{ $isCash ? 'Instant Wallet Payout' : 'Mutual Reciprocity Active' }}</span>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
