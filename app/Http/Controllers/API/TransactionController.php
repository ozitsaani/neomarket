<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    private function success(string $message, mixed $data = null, int $status = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    private function error(string $message, int $status = 400)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
        ], $status);
    }

    public function index(Request $request)
    {
        $query = Transaction::with('user', 'items')->latest();

        if ($request->user()->role === 'customer') {
            $query->where('user_id', $request->user()->id);
        }

        $transactions = $query->paginate(10);

        return $this->success('Data transaksi berhasil diambil.', $transactions);
    }

    public function show(Request $request, Transaction $transaction)
    {
        if (
            $request->user()->role === 'customer' &&
            $transaction->user_id !== $request->user()->id
        ) {
            return $this->error('Akses ditolak.', 403);
        }

        $transaction->load('user', 'items');

        return $this->success('Detail transaksi berhasil diambil.', $transaction);
    }

    public function updateStatus(Request $request, Transaction $transaction)
    {
        if ($request->user()->role !== 'admin') {
            return $this->error('Akses ditolak.', 403);
        }

        $validated = $request->validate([
            'order_status' => ['required', 'in:pending,processed,completed,cancelled'],
        ]);

        $transaction->update([
            'order_status' => $validated['order_status'],
        ]);

        return $this->success('Status order berhasil diperbarui.', $transaction);
    }
}