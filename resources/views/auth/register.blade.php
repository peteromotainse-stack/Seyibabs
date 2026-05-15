<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register – Wetaract</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .glass { background: rgba(15,23,42,0.7); backdrop-filter: blur(20px); border: 1px solid rgba(51,65,85,0.4); }
        .gradient-text { background: linear-gradient(135deg,#6366f1,#d946ef); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; }
        .neo-shadow { box-shadow: 0 0 20px rgba(99,102,241,0.4); }
    </style>
</head>
<body class="bg-slate-950 text-slate-200 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="text-center mb-10">
            <div class="inline-flex items-center gap-3 mb-4">
                <div class="w-12 h-12 rounded-2xl bg-indigo-600 flex items-center justify-center neo-shadow">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white fill-white" viewBox="0 0 24 24"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
                </div>
                <span class="text-3xl font-extrabold gradient-text">Wetaract</span>
            </div>
            <h1 class="text-2xl font-black text-white">Join Wetaract</h1>
            <p class="text-slate-400 text-sm mt-1">Start growing your social presence today</p>
        </div>
        <div class="glass rounded-3xl p-8">
            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-wide">Full Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" required autofocus
                               class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-slate-200 text-sm focus:outline-none focus:border-indigo-500 transition-colors"
                               placeholder="Your Name">
                        @error('name')<p class="text-rose-400 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-wide">Username</label>
                        <input type="text" name="username" value="{{ old('username') }}" required
                               class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-slate-200 text-sm focus:outline-none focus:border-indigo-500 transition-colors"
                               placeholder="username">
                        @error('username')<p class="text-rose-400 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-wide">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-slate-200 text-sm focus:outline-none focus:border-indigo-500 transition-colors"
                           placeholder="you@example.com">
                    @error('email')<p class="text-rose-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-wide">Password</label>
                        <input type="password" name="password" required
                               class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-slate-200 text-sm focus:outline-none focus:border-indigo-500 transition-colors"
                               placeholder="&#x2022;&#x2022;&#x2022;&#x2022;&#x2022;&#x2022;&#x2022;&#x2022;">
                        @error('password')<p class="text-rose-400 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-wide">Confirm</label>
                        <input type="password" name="password_confirmation" required
                               class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-slate-200 text-sm focus:outline-none focus:border-indigo-500 transition-colors"
                               placeholder="&#x2022;&#x2022;&#x2022;&#x2022;&#x2022;&#x2022;&#x2022;&#x2022;">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-wide">Referral Code (Optional)</label>
                    <input type="text" name="referral_code" value="{{ old('referral_code', request('ref')) }}"
                           class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-slate-200 text-sm focus:outline-none focus:border-fuchsia-500 transition-colors placeholder-slate-600 font-mono"
                           placeholder="XXXXXXXX">
                </div>
                <button type="submit" class="w-full py-4 bg-indigo-600 hover:bg-indigo-500 text-white font-black rounded-2xl text-sm transition-all shadow-lg shadow-indigo-600/20">
                    Create Account – It's Free
                </button>
            </form>
            <p class="text-center text-sm text-slate-500 mt-6">
                Already have an account?
                <a href="{{ route('login') }}" class="text-indigo-400 hover:text-indigo-300 font-bold">Sign in</a>
            </p>
        </div>
        <p class="text-center mt-4 text-xs text-slate-500">You'll receive <span class="text-amber-400 font-bold">100 bonus points</span> upon registration!</p>
    </div>
</body>
</html>
