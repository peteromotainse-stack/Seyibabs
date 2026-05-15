@extends('layouts.app')
@section('title', 'Growth Pact')
@section('page-title', 'Growth Pact')

@section('content')
<div class="space-y-6 fade-in">
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div>
            <h2 class="text-2xl font-black text-white">Community Members</h2>
            <p class="text-slate-400 text-sm mt-1">Connect and grow together through mutual engagement pacts.</p>
        </div>
        <div class="flex items-center gap-2 bg-slate-900/80 px-4 py-2 rounded-full border border-slate-800">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            <span class="text-sm font-bold text-slate-300">{{ $members->count() }} Members</span>
        </div>
    </div>

    @if($members->isEmpty())
        <div class="glass rounded-3xl p-16 text-center">
            <p class="text-slate-400 text-lg font-semibold">No community members yet</p>
        </div>
    @else
        <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-5">
            @foreach ($members as $member)
            @php
                $isSynced = in_array($member->id, $syncedIds);
                $memberInterests = $member->interests ?? [];
                $currentInterests = $currentUser->interests ?? [];
                $sharedInterests = array_intersect($currentInterests, $memberInterests);
                $handles = $member->socialHandles;
                $avatar = $member->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($member->name) . '&background=6366f1&color=fff&size=80';
                $sc = ['ACTIVE'=>'emerald','PENDING'=>'amber','INACTIVE'=>'slate'][$member->membership_status] ?? 'slate';
                $sl = ['ACTIVE'=>'Elite','PENDING'=>'Pending','INACTIVE'=>'Free'][$member->membership_status] ?? 'Free';
            @endphp
            <div class="glass rounded-[2rem] p-6 glass-hover {{ count($sharedInterests) > 0 ? 'ring-1 ring-indigo-500/20' : '' }}">
                <div class="flex items-start justify-between mb-5">
                    <div class="flex items-center gap-3">
                        <div class="relative">
                            <img src="{{ $avatar }}" alt="{{ $member->name }}" class="w-14 h-14 rounded-2xl object-cover border-2 border-slate-800">
                            @if($member->is_elite_verified)
                                <div class="absolute -top-1 -right-1 w-5 h-5 bg-indigo-600 rounded-full flex items-center justify-center border-2 border-slate-950">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-2.5 h-2.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                </div>
                            @endif
                        </div>
                        <div>
                            <h4 class="font-bold text-white">{{ $member->name }}</h4>
                            <p class="text-xs text-slate-500">@{{ $member->username }}</p>
                            <span class="inline-block mt-1 text-[9px] font-black bg-{{ $sc }}-500/10 text-{{ $sc }}-400 border border-{{ $sc }}-500/20 px-2 py-0.5 rounded-full uppercase">{{ $sl }}</span>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-black text-amber-400">{{ number_format($member->points) }}</p>
                        <p class="text-[10px] text-slate-500">points</p>
                    </div>
                </div>
                @if(!empty($memberInterests))
                <div class="flex flex-wrap gap-1 mb-4">
                    @foreach ($memberInterests as $interest)
                        <span class="text-[8px] font-black px-2 py-0.5 rounded {{ in_array($interest, $currentInterests) ? 'bg-indigo-500/10 text-indigo-400 border border-indigo-500/20' : 'bg-slate-900 text-slate-500 border border-slate-800' }}">{{ $interest }}</span>
                    @endforeach
                </div>
                @endif
                @if($handles->isNotEmpty())
                <div class="flex gap-2 mb-5">
                    @foreach ($handles->take(4) as $handle)
                        <span class="text-[9px] font-bold text-slate-400 bg-slate-900 border border-slate-800 px-2 py-1 rounded-lg">{{ substr($handle->platform, 0, 2) }}</span>
                    @endforeach
                </div>
                @endif
                <div class="grid grid-cols-2 gap-2 mb-5 text-center">
                    <div class="bg-slate-900/40 rounded-xl p-2"><p class="text-xs font-black text-white">{{ number_format($member->followers_count) }}</p><p class="text-[9px] text-slate-500">Followers</p></div>
                    <div class="bg-slate-900/40 rounded-xl p-2"><p class="text-xs font-black text-white">{{ $member->visibility_score }}/100</p><p class="text-[9px] text-slate-500">Visibility</p></div>
                </div>
                @if($isSynced)
                    <div class="w-full py-3 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-xs font-bold text-center flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Synced
                    </div>
                @else
                    <form method="POST" action="{{ route('community.sync', $member) }}">
                        @csrf
                        <button type="submit" class="w-full py-3 rounded-2xl bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-bold transition-all flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                            Sync & Follow
                        </button>
                    </form>
                @endif
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
