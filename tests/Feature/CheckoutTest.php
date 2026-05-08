<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_checkout_cart(): void
    {
        $customer = User::create([
            'name' => 'Customer Test',
            'email' => 'customer-test@example.com',
            'password' => 'password',
            'role' => 'customer',
        ]);

        $category = Category::create([
            'name' => 'Fashion',
            'slug' => 'fashion',
            'description' => 'Kategori produk fashion',
        ]);

        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Sepatu Test',
            'slug' => 'sepatu-test',
            'description' => 'Produk untuk testing checkout',
            'price' => 100000,
            'stock' => 10,
            'image' => null,
            'is_active' => true,
        ]);

        Cart::create([
            'user_id' => $customer->id,
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        Sanctum::actingAs($customer);

        $response = $this->postJson('/api/checkout', [
            'shipping_address' => 'Jl. Testing No. 123, Jakarta Selatan',
            'note' => 'Testing checkout',
        ]);

        $response->assertStatus(201);

        $response->assertJson([
            'success' => true,
            'message' => 'Checkout berhasil.',
        ]);

        $this->assertDatabaseHas('transactions', [
            'user_id' => $customer->id,
            'payment_status' => 'pending',
            'order_status' => 'pending',
        ]);

        $this->assertDatabaseHas('transaction_items', [
            'product_id' => $product->id,
            'product_name' => 'Sepatu Test',
            'quantity' => 2,
        ]);

        $this->assertDatabaseMissing('carts', [
            'user_id' => $customer->id,
            'product_id' => $product->id,
        ]);

        $this->assertEquals(8, $product->fresh()->stock);
    }
}