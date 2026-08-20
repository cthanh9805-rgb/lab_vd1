<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(10);
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status'      => 'required|in:active,inactive',
        ]);

        $data = $request->only(['name', 'category_id', 'description', 'price', 'stock', 'status']);

        // Xử lý sizes
        if ($request->filled('sizes')) {
            $data['sizes'] = implode(',', $request->input('sizes'));
        }

        // Xử lý colors
        if ($request->filled('colors')) {
            $data['colors'] = implode(',', $request->input('colors'));
        }

        // Upload ảnh
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/products'), $imageName);
            $data['image'] = 'images/products/' . $imageName;
        }

        Product::create($data);

        return redirect()->route('products.index')
            ->with('success', 'Sản phẩm đã được thêm thành công! 👠');
    }

    public function show(Product $product)
    {
        $product->load('category');
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status'      => 'required|in:active,inactive',
        ]);

        $data = $request->only(['name', 'category_id', 'description', 'price', 'stock', 'status']);

        // Xử lý sizes
        $data['sizes'] = $request->filled('sizes') ? implode(',', $request->input('sizes')) : null;

        // Xử lý colors
        $data['colors'] = $request->filled('colors') ? implode(',', $request->input('colors')) : null;

        // Upload ảnh mới nếu có
        if ($request->hasFile('image')) {
            // Xoá ảnh cũ (chỉ xoá nếu là file local)
            if ($product->image && !str_starts_with($product->image, 'http') && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/products'), $imageName);
            $data['image'] = 'images/products/' . $imageName;
        }

        $product->update($data);

        return redirect()->route('products.index')
            ->with('success', 'Sản phẩm đã được cập nhật thành công! ✨');
    }

    public function destroy(Product $product)
    {
        // Xoá ảnh khi xoá sản phẩm (chỉ xoá file local)
        if ($product->image && !str_starts_with($product->image, 'http') && file_exists(public_path($product->image))) {
            unlink(public_path($product->image));
        }

        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Sản phẩm đã được xoá thành công!');
    }
}
