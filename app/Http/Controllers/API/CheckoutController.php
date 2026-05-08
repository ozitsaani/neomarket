<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckoutRequest;
use App\Models\Cart;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
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

    public function store(CheckoutRequest $request)
    {
        $user = $request->user();

        $carts = Cart::with('product')
            ->where('user_id', $user->id)
            ->get();

        if ($carts->isEmpty()) {
            return $this->error('Cart masih kosong.');
        }

        foreach ($carts as $cart) {
            if (!$cart->product || !$cart->product->is_active) {
                return $this->error('Ada produk yang tidak aktif atau sudah dihapus.');
            }

            if ($cart->quantity > $cart->product->stock) {
                return $this->error('Stok produk ' . $cart->product->name . ' tidak mencukupi.');
            }
        }

        $transaction = DB::transaction(function () use ($request, $user, $carts) {
            $totalPrice = $carts->sum(function ($cart) {
                return $cart->product->price * $cart->quantity;
            });

            $transaction = Transaction::create([
                'user_id' => $user->id,
                'invoice_number' => 'INV-' . now()->format('YmdHis') . '-' . $user->id,
                'total_price' => $totalPrice,
                'payment_status' => 'pending',
                'order_status' => 'pending',
                'shipping_address' => $request->shipping_address,
                'note' => $request->note,
            ]);

            foreach ($carts as $cart) {
                $product = $cart->product;
                $subtotal = $product->price * $cart->quantity;

                $transaction->items()->create([
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $cart->quantity,
                    'subtotal' => $subtotal,
                ]);

                $product->decrement('stock', $cart->quantity);
            }

            Cart::where('user_id', $user->id)->delete();

            return $transaction;
        });

        $transaction->load('items');

        return $this->success('Checkout berhasil.', $transaction, 201);
    }
}