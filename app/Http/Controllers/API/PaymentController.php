<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class PaymentController extends Controller
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

    public function pay(Request $request, Transaction $transaction)
    {
        if ($transaction->user_id !== $request->user()->id) {
            return $this->error('Akses ditolak. Transaksi bukan milik user ini.', 403);
        }

        if ($transaction->payment_status !== 'pending') {
            return $this->error('Transaksi ini sudah diproses.');
        }

        $transaction->update([
            'payment_status' => 'paid',
            'order_status' => 'processed',
        ]);

        $transaction->load('items');

        return $this->success('Pembayaran dummy berhasil.', $transaction);
    }

    public function fail(Request $request, Transaction $transaction)
    {
        if ($transaction->user_id !== $request->user()->id) {
            return $this->error('Akses ditolak. Transaksi bukan milik user ini.', 403);
        }

        if ($transaction->payment_status !== 'pending') {
            return $this->error('Transaksi ini sudah diproses.');
        }

        $transaction->update([
            'payment_status' => 'failed',
            'order_status' => 'cancelled',
        ]);

        $transaction->load('items');

        return $this->success('Pembayaran dummy gagal.', $transaction);
    }
}