<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $carts = Cart::with('product.category')
            ->where('user_id', $request->user()->id)
            ->get();

        $total = $carts->sum('subtotal');

        return view('web.cart.index', compact('carts', 'total'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $product = Product::findOrFail($validated['product_id']);

        if (!$product->is_active) {
            return back()->with('error', 'Produk tidak aktif.');
        }

        if ($validated['quantity'] > $product->stock) {
            return back()->with('error', 'Quantity melebihi stok produk.');
        }

        $cart = Cart::where('user_id', $request->user()->id)
            ->where('product_id', $product->id)
            ->first();

        if ($cart) {
            $newQuantity = $cart->quantity + $validated['quantity'];

            if ($newQuantity > $product->stock) {
                return back()->with('error', 'Total quantity cart melebihi stok produk.');
            }

            $cart->update([
                'quantity' => $newQuantity,
            ]);
        } else {
            Cart::create([
                'user_id' => $request->user()->id,
                'product_id' => $product->id,
                'quantity' => $validated['quantity'],
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambahkan ke cart.');
    }

    public function update(Request $request, Cart $cart)
    {
        abort_if($cart->user_id !== $request->user()->id, 403);

        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        if ($validated['quantity'] > $cart->product->stock) {
            return back()->with('error', 'Quantity melebihi stok produk.');
        }

        $cart->update([
            'quantity' => $validated['quantity'],
        ]);

        return back()->with('success', 'Cart berhasil diperbarui.');
    }

    public function destroy(Request $request, Cart $cart)
    {
        abort_if($cart->user_id !== $request->user()->id, 403);

        $cart->delete();

        return back()->with('success', 'Item cart berhasil dihapus.');
    }

    public function clear(Request $request)
    {
        Cart::where('user_id', $request->user()->id)->delete();

        return back()->with('success', 'Cart berhasil dikosongkan.');
    }
}