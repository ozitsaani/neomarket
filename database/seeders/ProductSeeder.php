<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $elektronik = Category::where('name', 'Elektronik')->first();
        $fashion = Category::where('name', 'Fashion')->first();
        $makanan = Category::where('name', 'Makanan')->first();
        $aksesoris = Category::where('name', 'Aksesoris')->first();
        $rumah = Category::where('name', 'Peralatan Rumah')->first();

        $products = [
            [
                'category_id' => $fashion->id,
                'name' => 'Sepatu Sneakers',
                'description' => 'Sepatu sneakers nyaman untuk aktivitas harian.',
                'price' => 250000,
                'stock' => 15,
            ],
            [
                'category_id' => $fashion->id,
                'name' => 'Kaos Oversize',
                'description' => 'Kaos oversize bahan cotton combed yang nyaman.',
                'price' => 120000,
                'stock' => 25,
            ],
            [
                'category_id' => $elektronik->id,
                'name' => 'Headset Bluetooth',
                'description' => 'Headset wireless dengan suara jernih dan baterai tahan lama.',
                'price' => 175000,
                'stock' => 12,
            ],
            [
                'category_id' => $elektronik->id,
                'name' => 'Keyboard Mechanical',
                'description' => 'Keyboard mechanical RGB untuk kerja dan gaming.',
                'price' => 350000,
                'stock' => 10,
            ],
            [
                'category_id' => $elektronik->id,
                'name' => 'Mouse Wireless',
                'description' => 'Mouse wireless ringan dan responsif.',
                'price' => 85000,
                'stock' => 30,
            ],
            [
                'category_id' => $makanan->id,
                'name' => 'Keripik Pedas',
                'description' => 'Camilan keripik pedas level brutal.',
                'price' => 18000,
                'stock' => 50,
            ],
            [
                'category_id' => $aksesoris->id,
                'name' => 'Jam Tangan Digital',
                'description' => 'Jam tangan digital dengan desain modern.',
                'price' => 99000,
                'stock' => 20,
            ],
            [
                'category_id' => $rumah->id,
                'name' => 'Botol Minum',
                'description' => 'Botol minum praktis untuk aktivitas sehari-hari.',
                'price' => 45000,
                'stock' => 40,
            ],
        ];

        foreach ($products as $product) {
            Product::create([
                'category_id' => $product['category_id'],
                'name' => $product['name'],
                'slug' => Str::slug($product['name']),
                'description' => $product['description'],
                'price' => $product['price'],
                'stock' => $product['stock'],
                'image' => null,
                'is_active' => true,
            ]);
        }
    }
}