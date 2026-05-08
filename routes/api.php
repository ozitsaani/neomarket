<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\CheckoutController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\TransactionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\PaymentController;

Route::get('/test', function () {
    return response()->json([
        'success' => true,
        'message' => 'API NeoMarket berhasil jalan',
        'data' => [
            'app' => 'NeoMarket',
            'theme' => 'Neobrutalism',
        ],
    ]);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Public API
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{category}', [CategoryController::class, 'show']);

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{product}', [ProductController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/transactions', [TransactionController::class, 'index']);
    Route::get('/transactions/{transaction}', [TransactionController::class, 'show']);

    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/check', function () {
            return response()->json([
                'success' => true,
                'message' => 'Berhasil masuk sebagai admin.',
                'data' => [
                    'role' => 'admin',
                ],
            ]);
        });

        Route::post('/categories', [CategoryController::class, 'store']);
        Route::put('/categories/{category}', [CategoryController::class, 'update']);
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);

        Route::post('/products', [ProductController::class, 'store']);
        Route::put('/products/{product}', [ProductController::class, 'update']);
        Route::delete('/products/{product}', [ProductController::class, 'destroy']);

        Route::put('/transactions/{transaction}/status', [TransactionController::class, 'updateStatus']);
    });

    Route::middleware('role:customer')->group(function () {
        Route::get('/customer/check', function () {
            return response()->json([
                'success' => true,
                'message' => 'Berhasil masuk sebagai customer.',
                'data' => [
                    'role' => 'customer',
                ],
            ]);
        });

        Route::get('/cart', [CartController::class, 'index']);
        Route::post('/cart', [CartController::class, 'store']);
        Route::put('/cart/{cart}', [CartController::class, 'update']);
        Route::delete('/cart/{cart}', [CartController::class, 'destroy']);
        Route::delete('/cart', [CartController::class, 'clear']);

        Route::post('/checkout', [CheckoutController::class, 'store']);
        
        Route::post('/transactions/{transaction}/pay', [PaymentController::class, 'pay']);
        Route::post('/transactions/{transaction}/fail-payment', [PaymentController::class, 'fail']);
    });
});