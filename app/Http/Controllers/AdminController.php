<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Hướng dẫn Lab 03: Hiển thị trang Admin Dashboard
    public function dashboard()
    {
        $stats = [
            'total_products'   => Product::count(),
            'total_categories' => Category::count(),
            'total_users'      => User::count(),
            'total_customers'  => User::where('role', 'customer')->count(),
            'recent_products'  => Product::with('category')->latest()->take(5)->get(),
            'recent_logs'      => ActivityLog::with('user')->latest()->take(5)->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
