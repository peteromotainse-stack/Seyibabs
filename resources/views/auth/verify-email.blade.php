<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email – Wetaract</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>body { font-family: sans-serif; } .glass { background: rgba(15,23,42,0.7); backdrop-filter: blur(20px); border: 1px solid rgba(51,65,85,0.4); }</style>
</head>
<body class="bg-slate-950 text-slate-200 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="glass rounded-3xl p-8 text-center">
            <h1 class="text-xl font-black text-white mb-3">Verify Your Email</h1>
            <p class="text-slate-400 text-sm mb-6">Thanks for signing up! Please verify your email address.</p>
            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 p-3 bg-emerald-500/10 border border-emerald-500/30 rounded-xl text-emerald-400 text-sm">A new verification link has been sent.</div>
            @endif
            <form method="POST" action="{{ route('verification.send') }}" class="mb-4">
                @csrf
                <button type="submit" class="w-full py-3 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-xl text-sm">Resend Verification Email</button>
            </form>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-sm text-slate-500 hover:text-rose-400">Log Out</button>
            </form>
        </div>
    </div>
</body>
</html>
