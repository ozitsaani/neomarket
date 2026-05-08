<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CartRequest;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
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
        $carts = Cart::with('product.category')
            ->where('user_id', $request->user()->id)
            ->get();

        $total = $carts->sum('subtotal');

        return $this->success('Data cart berhasil diambil.', [
            'items' => $carts,
            'total' => $total,
        ]);
    }

    public function store(CartRequest $request)
    {
        $product = Product::findOrFail($request->product_id);

        if (!$product->is_active) {
            return $this->error('Produk tidak aktif.');
        }

        if ($request->quantity > $product->stock) {
            return $this->error('Quantity melebihi stok produk.');
        }

        $cart = Cart::where('user_id', $request->user()->id)
            ->where('product_id', $product->id)
            ->first();

        if ($cart) {
            $newQuantity = $cart->quantity + $request->quantity;

            if ($newQuantity > $product->stock) {
                return $this->error('Total quantity cart melebihi stok produk.');
            }

            $cart->update([
                'quantity' => $newQuantity,
            ]);
        } else {
            $cart = Cart::create([
                'user_id' => $request->user()->id,
                'product_id' => $product->id,
                'quantity' => $request->quantity,
            ]);
        }

        $cart->load('product.category');

        return $this->success('Produk berhasil ditambahkan ke cart.', $cart, 201);
    }

    public function update(Request $request, Cart $cart)
    {
        if ($cart->user_id !== $request->user()->id) {
            return $this->error('Akses ditolak.', 403);
        }

        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        if ($validated['quantity'] > $cart->product->stock) {
            return $this->error('Quantity melebihi stok produk.');
        }

        $cart->update([
            'quantity' => $validated['quantity'],
        ]);

        $cart->load('product.category');

        return $this->success('Cart berhasil diperbarui.', $cart);
    }

    public function destroy(Request $request, Cart $cart)
    {
        if ($cart->user_id !== $request->user()->id) {
            return $this->error('Akses ditolak.', 403);
        }

        $cart->delete();

        return $this->success('Item cart berhasil dihapus.');
    }

    public function clear(Request $request)
    {
        Cart::where('user_id', $request->user()->id)->delete();

        return $this->success('Cart berhasil dikosongkan.');
    }
}