<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    private function success(string $message, mixed $data = null, int $status = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    public function index()
    {
        $categories = Category::withCount('products')
            ->latest()
            ->get();

        return $this->success('Data kategori berhasil diambil.', $categories);
    }

    public function store(CategoryRequest $request)
    {
        $category = Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
        ]);

        return $this->success('Kategori berhasil ditambahkan.', $category, 201);
    }

    public function show(Category $category)
    {
        $category->load('products');

        return $this->success('Detail kategori berhasil diambil.', $category);
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
        ]);

        return $this->success('Kategori berhasil diperbarui.', $category);
    }

    public function destroy(Category $category)
    {
        if ($category->products()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori tidak dapat dihapus karena masih memiliki produk.',
            ], 400);
        }

        $category->delete();

        return $this->success('Kategori berhasil dihapus.');
    }
}