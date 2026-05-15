<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login – Wetaract</title>
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
            <h1 class="text-2xl font-black text-white">Welcome back</h1>
            <p class="text-slate-400 text-sm mt-1">Sign in to your Social Growth Ecosystem</p>
        </div>

        <div class="glass rounded-3xl p-8">
            @if (session('status'))
                <div class="mb-4 p-3 bg-emerald-500/10 border border-emerald-500/30 rounded-xl text-emerald-400 text-sm">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-wide">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email"
                           class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-slate-200 text-sm focus:outline-none focus:border-indigo-500 transition-colors placeholder-slate-600"
                           placeholder="you@example.com">
                    @error('email')<p class="text-rose-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-wide">Password</label>
                    <input type="password" name="password" required autocomplete="current-password"
                           class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-slate-200 text-sm focus:outline-none focus:border-indigo-500 transition-colors"
                           placeholder="••••••••">
                    @error('password')<p class="text-rose-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded text-indigo-600 bg-slate-800 border-slate-600">
                        <span class="text-sm text-slate-400">Remember me</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-indigo-400 hover:text-indigo-300">Forgot password?</a>
                    @endif
                </div>
                <button type="submit" class="w-full py-4 bg-indigo-600 hover:bg-indigo-500 text-white font-black rounded-2xl text-sm transition-all shadow-lg shadow-indigo-600/20">
                    Sign In
                </button>
            </form>

            <p class="text-center text-sm text-slate-500 mt-6">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-indigo-400 hover:text-indigo-300 font-bold">Sign up free</a>
            </p>
        </div>
    </div>
</body>
</html>
