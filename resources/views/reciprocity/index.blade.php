@extends('layouts.app')
@section('title', 'Reciprocity Tasks')
@section('page-title', 'Reciprocity Tasks')

@section('content')
<div class="space-y-6 fade-in">
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div>
            <h2 class="text-2xl font-black text-white">Reciprocity Tasks</h2>
            <p class="text-slate-400 text-sm mt-1">Complete community tasks to earn points and boost your visibility.</p>
        </div>
        <div class="flex items-center gap-3">
            <div class="glass px-4 py-2 rounded-xl flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                <span class="text-sm font-bold text-white">{{ number_format($user->points) }} pts</span>
            </div>
            @if($user->warnings > 0)
            <form method="POST" action="{{ route('reciprocity.appeal') }}">@csrf
                <button type="submit" class="flex items-center gap-2 px-4 py-2 bg-rose-600/20 hover:bg-rose-600/30 border border-rose-500/30 text-rose-400 rounded-xl text-sm font-bold transition-all">
                    Appeal Warning ({{ $user->warnings }})
                </button>
            </form>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-3 gap-4">
        <div class="glass rounded-2xl p-5 text-center"><p class="text-2xl font-black text-white">{{ $tasks->count() }}</p><p class="text-xs text-slate-500 mt-1">Pending Tasks</p></div>
        <div class="glass rounded-2xl p-5 text-center"><p class="text-2xl font-black text-indigo-400">{{ $user->visibility_score }}/100</p><p class="text-xs text-slate-500 mt-1">Visibility Score</p></div>
        <div class="glass rounded-2xl p-5 text-center"><p class="text-2xl font-black {{ $user->warnings > 0 ? 'text-rose-400' : 'text-emerald-400' }}">{{ $user->warnings }}</p><p class="text-xs text-slate-500 mt-1">Warnings</p></div>
    </div>

    @if($tasks->isEmpty())
        <div class="glass rounded-3xl p-16 text-center">
            <p class="text-slate-400 text-lg font-semibold">No pending tasks</p>
            <p class="text-slate-600 text-sm mt-2">You've completed all available reciprocity tasks. Check back soon!</p>
        </div>
    @else
        <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-5">
            @foreach ($tasks as $task)
            @php
                $creatorName = $task->user->name ?? 'Unknown';
                $creatorAvatar = $task->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($creatorName) . '&background=6366f1&color=fff&size=80';
            @endphp
            <div class="glass rounded-[2rem] p-6 glass-hover ring-1 ring-indigo-500/20">
                <div class="flex items-start justify-between mb-5">
                    <div class="flex items-center gap-3">
                        <img src="{{ $creatorAvatar }}" alt="{{ $creatorName }}" class="w-12 h-12 rounded-2xl object-cover border border-slate-800">
                        <div>
                            <h4 class="text-sm font-bold text-white">{{ $creatorName }}</h4>
                            <div class="flex items-center gap-2 mt-0.5">
                                <span class="text-[10px] font-black text-slate-500 uppercase">{{ $task->platform }}</span>
                                <span class="w-1 h-1 rounded-full bg-slate-700"></span>
                                <span class="text-[10px] font-black text-indigo-400 uppercase">{{ $task->action_type }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-amber-500/10 text-amber-500 border border-amber-500/20 text-[10px] font-black px-3 py-1.5 rounded-full flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 fill-current" viewBox="0 0 24 24"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
                        +10 pts
                    </div>
                </div>
                <p class="text-sm text-slate-400 mb-5 line-clamp-2 leading-relaxed">{{ $task->description }}</p>
                <div class="space-y-2 mb-6">
                    <div class="flex justify-between text-[10px] font-bold uppercase tracking-widest text-slate-500">
                        <span>Community Progress</span><span>{{ $task->total_slots - $task->remaining_slots }} / {{ $task->total_slots }}</span>
                    </div>
                    <div class="h-1.5 w-full bg-slate-800/50 rounded-full overflow-hidden">
                        @php $progress = $task->total_slots > 0 ? (1 - $task->remaining_slots / $task->total_slots) * 100 : 0; @endphp
                        <div class="h-full bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full" style="width: {{ $progress }}%"></div>
                    </div>
                </div>
                <div class="flex gap-3">
                    <a href="{{ $task->link }}" target="_blank" rel="noopener noreferrer"
                       class="flex-1 flex items-center justify-center gap-2 bg-slate-800/50 hover:bg-slate-800 text-slate-300 py-3.5 rounded-2xl text-xs font-bold border border-slate-700/50 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        Open
                    </a>
                    <form method="POST" action="{{ route('reciprocity.complete', $task) }}" class="flex-1">@csrf
                        <button type="submit" class="w-full flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-500 text-white py-3.5 rounded-2xl text-xs font-bold shadow-lg shadow-indigo-600/20 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Done +10pts
                        </button>
                    </form>
                    <form method="POST" action="{{ route('reciprocity.ignore', $task) }}">@csrf
                        <button type="submit" onclick="return confirm('Ignoring will apply a -50 points penalty. Continue?')" title="Ignore (penalty applies)"
                                class="px-3 py-3.5 rounded-2xl bg-rose-500/10 hover:bg-rose-500/20 border border-rose-500/20 text-rose-400 text-xs font-bold transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </form>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-800/30 flex items-center justify-center gap-2">
                    <span class="text-[8px] font-black text-slate-500 uppercase tracking-widest">Mutual Reciprocity Active</span>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
