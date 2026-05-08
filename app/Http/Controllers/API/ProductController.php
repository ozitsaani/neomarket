<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    private function success(string $message, mixed $data = null, int $status = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    public function index(Request $request)
    {
        $products = Product::with('category')
            ->when($request->category_id, function ($query) use ($request) {
                $query->where('category_id', $request->category_id);
            })
            ->when($request->search, function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%');
            })
            ->where('is_active', true)
            ->latest()
            ->paginate(10);

        return $this->success('Data produk berhasil diambil.', $products);
    }

    public function store(ProductRequest $request)
    {
        $product = Product::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $request->image,
            'is_active' => $request->boolean('is_active', true),
        ]);

        $product->load('category');

        return $this->success('Produk berhasil ditambahkan.', $product, 201);
    }

    public function show(Product $product)
    {
        $product->load('category');

        return $this->success('Detail produk berhasil diambil.', $product);
    }

    public function update(ProductRequest $request, Product $product)
    {
        $product->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $request->image,
            'is_active' => $request->boolean('is_active', true),
        ]);

        $product->load('category');

        return $this->success('Produk berhasil diperbarui.', $product);
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return $this->success('Produk berhasil dihapus.');
    }
}