<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::withCount('products')
            ->orderBy('name')
            ->get();

        $products = Product::with('category')
            ->where('is_active', true)
            ->when($request->search, function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%');
            })
            ->when($request->category_id, function ($query) use ($request) {
                $query->where('category_id', $request->category_id);
            })
            ->latest()
            ->paginate(8)
            ->withQueryString();

        return view('web.home', compact('categories', 'products'));
    }

    public function show(Product $product)
    {
        abort_if(!$product->is_active, 404);

        $product->load('category');

        $relatedProducts = Product::with('category')
            ->where('is_active', true)
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->limit(4)
            ->get();

        return view('web.products.show', compact('product', 'relatedProducts'));
    }
}