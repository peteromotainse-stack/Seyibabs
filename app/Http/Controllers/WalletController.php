<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WalletController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $transactions = $user->transactions()->paginate(15);
        $totalEarned = $user->transactions()->where('type', 'Earning')->sum('amount');
        $totalSpent  = $user->transactions()->where('type', 'Campaign_Spend')->sum('amount');

        return view('wallet.index', compact('user', 'transactions', 'totalEarned', 'totalSpent'));
    }

    public function deposit(Request $request)
    {
        $validated = $request->validate([
            'amount'  => 'required|numeric|min:1',
            'gateway' => 'required|in:paystack,flutterwave',
        ]);

        $user = $request->user();
        DB::transaction(function () use ($user, $validated) {
            $user->increment('wallet_balance', $validated['amount']);
            Transaction::create([
                'user_id'     => $user->id,
                'type'        => 'Deposit',
                'amount'      => $validated['amount'],
                'description' => 'Deposit via ' . ucfirst($validated['gateway']),
                'status'      => 'Completed',
            ]);
        });

        return back()->with('success', '$' . number_format($validated['amount'], 2) . ' deposited successfully!');
    }

    public function withdraw(Request $request)
    {
        $validated = $request->validate(['amount' => 'required|numeric|min:1']);
        $user = $request->user();

        if ($validated['amount'] > $user->wallet_balance) {
            return back()->withErrors(['amount' => 'Insufficient balance.']);
        }

        DB::transaction(function () use ($user, $validated) {
            $user->decrement('wallet_balance', $validated['amount']);
            $user->increment('total_withdrawn', $validated['amount']);
            Transaction::create([
                'user_id'     => $user->id,
                'type'        => 'Withdrawal',
                'amount'      => $validated['amount'],
                'description' => 'Withdrawal to Bank',
                'status'      => 'Completed',
            ]);
        });

        return back()->with('success', '$' . number_format($validated['amount'], 2) . ' withdrawal initiated!');
    }
}
