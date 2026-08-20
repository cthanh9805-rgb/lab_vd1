<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    // Hướng dẫn Lab 03: Hiển thị trang chủ cửa hàng dành cho khách hàng
    public function index(Request $request)
    {
        $query = Product::with('category')->latest();

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->paginate(8)->withQueryString();
        $categories = Category::withCount('products')->get();

        return view('welcome', compact('products', 'categories'));
    }
}
