<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $transactions = Transaction::with('items')
            ->where('user_id', $request->user()->id)
            ->latest()
            ->paginate(10);

        return view('web.transactions.index', compact('transactions'));
    }

    public function show(Request $request, Transaction $transaction)
    {
        abort_if($transaction->user_id !== $request->user()->id, 403);

        $transaction->load('items');

        return view('web.transactions.show', compact('transaction'));
    }

    public function pay(Request $request, Transaction $transaction)
    {
        abort_if($transaction->user_id !== $request->user()->id, 403);

        if ($transaction->payment_status !== 'pending') {
            return back()->with('error', 'Transaksi ini sudah diproses.');
        }

        $transaction->update([
            'payment_status' => 'paid',
            'order_status' => 'processed',
        ]);

        return back()->with('success', 'Pembayaran dummy berhasil.');
    }

    public function fail(Request $request, Transaction $transaction)
    {
        abort_if($transaction->user_id !== $request->user()->id, 403);

        if ($transaction->payment_status !== 'pending') {
            return back()->with('error', 'Transaksi ini sudah diproses.');
        }

        $transaction->update([
            'payment_status' => 'failed',
            'order_status' => 'cancelled',
        ]);

        return back()->with('success', 'Pembayaran dummy gagal disimulasikan.');
    }
}