<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Elektronik',
                'description' => 'Kategori produk elektronik seperti headset, keyboard, dan mouse.',
            ],
            [
                'name' => 'Fashion',
                'description' => 'Kategori produk fashion seperti kaos, sepatu, dan tas.',
            ],
            [
                'name' => 'Makanan',
                'description' => 'Kategori produk makanan dan camilan.',
            ],
            [
                'name' => 'Aksesoris',
                'description' => 'Kategori produk aksesoris harian.',
            ],
            [
                'name' => 'Peralatan Rumah',
                'description' => 'Kategori produk perlengkapan rumah.',
            ],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
            ]);
        }
    }
}