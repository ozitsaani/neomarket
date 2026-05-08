<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $carts = Cart::with('product.category')
            ->where('user_id', $request->user()->id)
            ->get();

        if ($carts->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Cart masih kosong.');
        }

        $total = $carts->sum('subtotal');

        return view('web.checkout.index', compact('carts', 'total'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'shipping_address' => ['required', 'string', 'min:10'],
            'note' => ['nullable', 'string'],
        ]);

        $user = $request->user();

        $carts = Cart::with('product')
            ->where('user_id', $user->id)
            ->get();

        if ($carts->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Cart masih kosong.');
        }

        foreach ($carts as $cart) {
            if (!$cart->product || !$cart->product->is_active) {
                return back()->with('error', 'Ada produk yang tidak aktif atau sudah dihapus.');
            }

            if ($cart->quantity > $cart->product->stock) {
                return back()->with('error', 'Stok produk ' . $cart->product->name . ' tidak mencukupi.');
            }
        }

        $transaction = DB::transaction(function () use ($validated, $user, $carts) {
            $totalPrice = $carts->sum(function ($cart) {
                return $cart->product->price * $cart->quantity;
            });

            $transaction = Transaction::create([
                'user_id' => $user->id,
                'invoice_number' => 'INV-' . now()->format('YmdHis') . '-' . $user->id,
                'total_price' => $totalPrice,
                'payment_status' => 'pending',
                'order_status' => 'pending',
                'shipping_address' => $validated['shipping_address'],
                'note' => $validated['note'] ?? null,
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

        return redirect()
            ->route('transactions.show', $transaction)
            ->with('success', 'Checkout berhasil. Silakan lakukan pembayaran dummy.');
    }
}