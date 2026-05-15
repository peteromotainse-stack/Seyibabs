<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Password – Wetaract</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>body { font-family: sans-serif; } .glass { background: rgba(15,23,42,0.7); backdrop-filter: blur(20px); border: 1px solid rgba(51,65,85,0.4); }</style>
</head>
<body class="bg-slate-950 text-slate-200 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="glass rounded-3xl p-8">
            <h1 class="text-xl font-black text-white mb-2">Confirm Password</h1>
            <p class="text-slate-400 text-sm mb-6">This is a secure area. Please confirm your password.</p>
            <form method="POST" action="{{ route('password.confirm') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-wide">Password</label>
                    <input type="password" name="password" required
                           class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-slate-200 text-sm focus:outline-none focus:border-indigo-500">
                    @error('password')<p class="text-rose-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <button type="submit" class="w-full py-4 bg-indigo-600 hover:bg-indigo-500 text-white font-black rounded-2xl text-sm">Confirm</button>
            </form>
        </div>
    </div>
</body>
</html>
