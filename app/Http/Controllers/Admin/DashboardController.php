<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalProducts' => Product::count(),
            'totalCategories' => Category::count(),
            'totalTransactions' => Transaction::count(),
            'totalCustomers' => User::where('role', 'customer')->count(),
            'paidTransactions' => Transaction::where('payment_status', 'paid')->count(),
            'pendingTransactions' => Transaction::where('payment_status', 'pending')->count(),
        ]);
    }
}