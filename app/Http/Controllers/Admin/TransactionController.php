<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $transactions = Transaction::with('user', 'items')
            ->when($request->search, function ($query) use ($request) {
                $query->where('invoice_number', 'like', '%' . $request->search . '%');
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.transactions.index', compact('transactions'));
    }

    public function show(Transaction $transaction)
    {
        $transaction->load('user', 'items');

        return view('admin.transactions.show', compact('transaction'));
    }

    public function updateStatus(Request $request, Transaction $transaction)
    {
        $validated = $request->validate([
            'order_status' => ['required', 'in:pending,processed,completed,cancelled'],
        ]);

        $transaction->update([
            'order_status' => $validated['order_status'],
        ]);

        return back()->with('success', 'Status order berhasil diperbarui.');
    }
}