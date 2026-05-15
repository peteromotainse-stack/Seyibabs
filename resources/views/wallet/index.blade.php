@extends('layouts.app')
@section('title', 'My Wallet')
@section('page-title', 'My Wallet')

@section('content')
<div class="space-y-6 fade-in">

    <div class="grid md:grid-cols-3 gap-4">
        <div class="glass rounded-3xl p-6 relative overflow-hidden md:col-span-1">
            <div class="absolute inset-0 bg-gradient-to-br from-emerald-600/10 to-teal-600/5 pointer-events-none"></div>
            <p class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Available Balance</p>
            <p class="text-4xl font-black text-white">${{ number_format($user->wallet_balance, 2) }}</p>
            <p class="text-sm text-slate-400 mt-1">USD</p>
        </div>
        <div class="glass rounded-3xl p-6">
            <p class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Total Earned</p>
            <p class="text-3xl font-black text-emerald-400">${{ number_format($totalEarned, 2) }}</p>
        </div>
        <div class="glass rounded-3xl p-6">
            <p class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Total Withdrawn</p>
            <p class="text-3xl font-black text-slate-300">${{ number_format($user->total_withdrawn, 2) }}</p>
        </div>
    </div>

    <div class="grid lg:grid-cols-2 gap-6">
        <div class="glass rounded-3xl p-8">
            <h3 class="text-base font-bold text-white mb-6">Deposit Funds</h3>
            <form method="POST" action="{{ route('wallet.deposit') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-wide">Amount (USD)</label>
                    <input type="number" name="amount" placeholder="0.00" min="1" step="0.01"
                           class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-slate-200 text-sm focus:outline-none focus:border-emerald-500 transition-colors placeholder-slate-600">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-wide">Payment Gateway</label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="cursor-pointer">
                            <input type="radio" name="gateway" value="paystack" class="sr-only peer" checked>
                            <div class="p-3 rounded-xl border-2 border-slate-700 peer-checked:border-emerald-500 peer-checked:bg-emerald-500/5 text-center transition-all">
                                <p class="text-sm font-bold text-white">Paystack</p><p class="text-[10px] text-slate-500">Cards & Bank</p>
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="gateway" value="flutterwave" class="sr-only peer">
                            <div class="p-3 rounded-xl border-2 border-slate-700 peer-checked:border-emerald-500 peer-checked:bg-emerald-500/5 text-center transition-all">
                                <p class="text-sm font-bold text-white">Flutterwave</p><p class="text-[10px] text-slate-500">Mobile & Cards</p>
                            </div>
                        </label>
                    </div>
                </div>
                <button type="submit" class="w-full py-4 bg-emerald-600 hover:bg-emerald-500 text-white font-bold rounded-2xl text-sm transition-all shadow-lg shadow-emerald-600/20">Deposit Now</button>
            </form>
        </div>

        <div class="glass rounded-3xl p-8">
            <h3 class="text-base font-bold text-white mb-6">Withdraw Funds</h3>
            <form method="POST" action="{{ route('wallet.withdraw') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-wide">Amount (USD)</label>
                    <input type="number" name="amount" placeholder="0.00" min="1" step="0.01" max="{{ $user->wallet_balance }}"
                           class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-slate-200 text-sm focus:outline-none focus:border-indigo-500 transition-colors placeholder-slate-600">
                    <p class="text-xs text-slate-500 mt-1">Available: ${{ number_format($user->wallet_balance, 2) }}</p>
                </div>
                <div class="p-4 rounded-2xl bg-slate-900/50 border border-slate-800">
                    <p class="text-xs font-bold text-slate-400 mb-1">Bank Details</p>
                    <p class="text-sm text-slate-300">Transfers to your registered bank account</p>
                    <p class="text-xs text-slate-500 mt-1">Processing time: 1-3 business days</p>
                </div>
                <button type="submit" class="w-full py-4 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-2xl text-sm transition-all shadow-lg shadow-indigo-600/20">Withdraw</button>
            </form>
        </div>
    </div>

    <div class="glass rounded-3xl p-6">
        <h3 class="text-base font-bold text-white mb-6">Transaction History</h3>
        @if($transactions->isEmpty())
            <div class="text-center py-12 text-slate-500"><p class="text-sm">No transactions yet</p></div>
        @else
            <div class="space-y-3">
                @foreach ($transactions as $tx)
                @php
                    $colors = ['Earning' => 'emerald', 'Deposit' => 'blue', 'Withdrawal' => 'rose', 'Campaign_Spend' => 'amber'];
                    $signs  = ['Earning' => '+', 'Deposit' => '+', 'Withdrawal' => '-', 'Campaign_Spend' => '-'];
                    $c = $colors[$tx->type] ?? 'slate';
                    $s = $signs[$tx->type] ?? '';
                @endphp
                <div class="flex items-center justify-between p-4 rounded-2xl bg-slate-900/40 hover:bg-slate-900/60 transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-{{ $c }}-500/10 flex items-center justify-center">
                            <span class="text-{{ $c }}-400 font-black">{{ $s }}</span>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-200">{{ $tx->description }}</p>
                            <p class="text-xs text-slate-500">{{ \Carbon\Carbon::parse($tx->created_at)->format('M d, Y · H:i') }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-bold text-{{ $c }}-400">{{ $s }}${{ number_format($tx->amount, 2) }}</p>
                        <span class="text-[10px] bg-{{ $c }}-500/10 text-{{ $c }}-400 px-2 py-0.5 rounded-full">{{ $tx->status }}</span>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="mt-4">{{ $transactions->links() }}</div>
        @endif
    </div>
</div>
@endsection
