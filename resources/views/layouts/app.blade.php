<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Wetaract – @yield('title', 'Social Growth Ecosystem')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .glass {
            background: rgba(15,23,42,0.6);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(51,65,85,0.4);
        }
        .glass-hover:hover {
            background: rgba(15,23,42,0.8);
            border-color: rgba(100,116,139,0.3);
        }
        .gradient-text {
            background: linear-gradient(135deg, #6366f1, #d946ef);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .neo-shadow { box-shadow: 0 0 20px rgba(99,102,241,0.4); }
        .sidebar-item-active {
            background: linear-gradient(135deg, rgba(99,102,241,0.15), rgba(217,70,239,0.08));
            border: 1px solid rgba(99,102,241,0.2);
        }
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(99,102,241,0.3); border-radius: 2px; }
        @keyframes fadeIn { from { opacity:0; transform:translateY(10px); } to { opacity:1; transform:translateY(0); } }
        .fade-in { animation: fadeIn 0.3s ease-out; }
    </style>
</head>
<body class="bg-slate-950 text-slate-200 min-h-screen">

<div class="flex h-screen overflow-hidden">
    <div id="sidebar-overlay" class="fixed inset-0 bg-black/60 z-40 lg:hidden hidden" onclick="toggleSidebar()"></div>

    <aside id="sidebar" class="fixed lg:relative inset-y-0 left-0 z-50 w-72 glass border-r border-slate-800/50 transition-transform duration-300 -translate-x-full lg:translate-x-0 flex flex-col">
        <div class="p-8 flex-shrink-0">
            <a href="{{ route('dashboard') }}" class="text-2xl font-extrabold tracking-tighter flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-indigo-600 flex items-center justify-center neo-shadow">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white fill-white" viewBox="0 0 24 24"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
                </div>
                <span class="gradient-text">Wetaract</span>
            </a>
        </div>

        <nav class="flex-1 px-4 space-y-1 overflow-y-auto">
            <p class="px-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-4">Menu</p>
            @php
            $navItems = [
                ['route' => 'dashboard',       'label' => 'Overview',     'pattern' => 'dashboard'],
                ['route' => 'campaigns.create','label' => 'Ad Manager',   'pattern' => 'campaigns.create'],
                ['route' => 'community.index', 'label' => 'Growth Pact',  'pattern' => 'community.*'],
                ['route' => 'campaigns.index', 'label' => 'Campaigns',    'pattern' => 'campaigns.index'],
                ['route' => 'wallet.index',    'label' => 'My Wallet',    'pattern' => 'wallet.*'],
                ['route' => 'referrals.index', 'label' => 'Refer & Earn', 'pattern' => 'referrals.*'],
                ['route' => 'profile.index',   'label' => 'My Profile',   'pattern' => 'profile.*'],
                ['route' => 'membership.index','label' => 'Upgrade',      'pattern' => 'membership.*'],
            ];
            $icons = [
                'dashboard'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>',
                'ad-manager' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>',
                'community'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>',
                'campaigns'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.59 14.37a6 6 0 01-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 006.16-12.12A14.98 14.98 0 009.631 8.41m5.96 5.96a14.926 14.926 0 01-5.841 2.58m-.119-8.54a6 6 0 00-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 00-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 01-2.448-2.448 14.9 14.9 0 01.06-.312m-2.24 2.39a4.493 4.493 0 00-1.757 4.306 4.493 4.493 0 004.306-1.758M16.5 9a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>',
                'wallet'     => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>',
                'referrals'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/>',
                'profile'    => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>',
                'membership' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>',
            ];
            $iconKeys = ['dashboard','ad-manager','community','campaigns','wallet','referrals','profile','membership'];
            @endphp

            @foreach ($navItems as $i => $item)
                @php $isActive = request()->routeIs($item['pattern']); @endphp
                <a href="{{ route($item['route']) }}"
                   class="w-full flex items-center gap-3 px-4 py-3.5 rounded-xl text-sm font-semibold transition-all {{ $isActive ? 'sidebar-item-active text-indigo-400' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-900/40' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 {{ $isActive ? 'text-indigo-400' : 'text-slate-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        {!! $icons[$iconKeys[$i]] !!}
                    </svg>
                    {{ $item['label'] }}
                </a>
            @endforeach
        </nav>

        <div class="p-6 flex-shrink-0 border-t border-slate-800/50">
            <div class="p-4 rounded-2xl bg-indigo-600/10 border border-indigo-500/20 mb-4">
                <p class="text-xs font-bold text-indigo-400 mb-1">WETARACT BALANCE</p>
                <p class="text-lg font-black text-white mb-3">${{ number_format(auth()->user()->wallet_balance, 2) }} <span class="text-xs text-slate-400 font-normal">USD</span></p>
                <a href="{{ route('wallet.index') }}" class="block text-center w-full py-2 bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-bold rounded-lg transition-colors">
                    Withdraw Funds
                </a>
            </div>

            <a href="{{ route('profile.index') }}" class="flex items-center gap-3 p-2 rounded-xl border border-transparent hover:border-slate-800 transition-all">
                <img src="{{ auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=6366f1&color=fff&size=80' }}"
                     alt="Avatar" class="w-10 h-10 rounded-full border-2 border-slate-800 object-cover">
                <div class="overflow-hidden">
                    <p class="text-sm font-bold truncate">{{ auth()->user()->name }}</p>
                    <p class="text-[11px] text-slate-500">{{ auth()->user()->membership_status === 'ACTIVE' ? 'Elite Member' : 'Free Member' }}</p>
                </div>
            </a>

            <form method="POST" action="{{ route('logout') }}" class="mt-2">
                @csrf
                <button type="submit" class="w-full flex items-center gap-2 px-4 py-2.5 text-slate-500 hover:text-rose-400 text-sm font-medium rounded-xl hover:bg-rose-500/5 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Sign Out
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 flex flex-col min-w-0 bg-[#020617] overflow-hidden">
        <header class="h-20 flex-shrink-0 flex items-center justify-between px-6 lg:px-8 border-b border-slate-900/50">
            <div class="flex items-center gap-4">
                <button class="lg:hidden p-2 text-slate-400" onclick="toggleSidebar()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <h2 class="text-xl font-bold text-slate-100">@yield('page-title', 'Overview')</h2>
            </div>
            <div class="flex items-center gap-4 lg:gap-6">
                <div class="hidden md:flex items-center gap-2 bg-slate-900/80 px-4 py-2 rounded-full border border-slate-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                    <span class="text-sm font-bold text-slate-300">${{ number_format(auth()->user()->wallet_balance, 2) }}</span>
                    <span class="text-[10px] text-slate-500 ml-1">USD</span>
                </div>
                <div class="flex items-center gap-3 border-l border-slate-800 pl-4 lg:pl-6">
                    <button class="p-2.5 text-slate-400 hover:bg-slate-900 rounded-full relative transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        <span class="absolute top-2.5 right-2.5 w-2 h-2 bg-rose-500 rounded-full border-2 border-[#020617]"></span>
                    </button>
                    <a href="{{ route('campaigns.create') }}" class="flex items-center gap-2 bg-indigo-600 hover:bg-indigo-500 text-white px-4 lg:px-5 py-2.5 rounded-xl text-sm font-bold shadow-lg shadow-indigo-600/20 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        <span class="hidden sm:inline">Boost Content</span>
                    </a>
                </div>
            </div>
        </header>

        @if (session('success') || session('error') || session('warning') || $errors->any())
        <div class="px-6 lg:px-8 pt-4 space-y-2 flex-shrink-0">
            @if (session('success'))
                <div class="p-4 bg-emerald-500/10 border border-emerald-500/30 rounded-xl text-emerald-400 text-sm font-medium flex items-center gap-2 fade-in">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="p-4 bg-rose-500/10 border border-rose-500/30 rounded-xl text-rose-400 text-sm font-medium flex items-center gap-2 fade-in">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ session('error') }}
                </div>
            @endif
            @if (session('warning'))
                <div class="p-4 bg-amber-500/10 border border-amber-500/30 rounded-xl text-amber-400 text-sm font-medium flex items-center gap-2 fade-in">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    {{ session('warning') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="p-4 bg-rose-500/10 border border-rose-500/30 rounded-xl text-rose-400 text-sm font-medium fade-in">
                    <ul class="space-y-1">
                        @foreach ($errors->all() as $error)
                            <li class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                {{ $error }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
        @endif

        <div class="flex-1 overflow-y-auto p-6 lg:p-8">
            @yield('content')
        </div>
    </main>
</div>

<script>
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('-translate-x-full');
    document.getElementById('sidebar-overlay').classList.toggle('hidden');
}
</script>
</body>
</html>
