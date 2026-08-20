<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        // Tìm kiếm theo tên
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Lọc theo Danh mục
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Lọc theo Phân loại
        if ($request->filled('classification')) {
            $query->where('classification', $request->classification);
        }

        $products   = $query->latest()->paginate(10)->withQueryString();
        $categories = Category::all();

        return view('products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'category_id'   => 'required|exists:categories,id',
            'description'   => 'nullable|string',
            'price'         => 'required|numeric|min:0',
            'stock'         => 'required|integer|min:0',
            'image'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'origin'        => 'nullable|string|max:100',
            'discount_code' => 'nullable|string|max:50',
            'classification'=> 'nullable|string|max:50',
            'status'        => 'required|in:active,inactive',
        ]);

        // Xử lý chuỗi Sizes và Colors
        if ($request->filled('sizes')) {
            $data['sizes'] = implode(',', $request->input('sizes'));
        }
        if ($request->filled('colors')) {
            $data['colors'] = implode(',', $request->input('colors'));
        }

        // Xử lý Ma trận Biến thể Chi tiết (Màu x Size)
        if ($request->filled('variant_matrix')) {
            $rawMatrix = $request->input('variant_matrix');
            $cleanMatrix = [];
            $sizeTotals = [];
            $colorTotals = [];
            $totalStockSum = 0;

            $selectedColors = $request->input('colors', []);
            $selectedSizes  = $request->input('sizes', []);

            foreach ($selectedColors as $color) {
                if (isset($rawMatrix[$color]) && is_array($rawMatrix[$color])) {
                    foreach ($selectedSizes as $size) {
                        $qty = isset($rawMatrix[$color][$size]) ? (int)$rawMatrix[$color][$size] : 0;
                        $cleanMatrix[$color][$size] = $qty;
                        
                        $sizeTotals[$size]  = ($sizeTotals[$size] ?? 0) + $qty;
                        $colorTotals[$color] = ($colorTotals[$color] ?? 0) + $qty;
                        $totalStockSum += $qty;
                    }
                }
            }

            if (!empty($cleanMatrix)) {
                $data['variants']     = json_encode($cleanMatrix, JSON_UNESCAPED_UNICODE);
                $data['size_stocks']  = json_encode($sizeTotals, JSON_UNESCAPED_UNICODE);
                $data['color_stocks'] = json_encode($colorTotals, JSON_UNESCAPED_UNICODE);
                $data['stock']        = $totalStockSum;
            }
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
            'name'          => 'required|string|max:255',
            'category_id'   => 'required|exists:categories,id',
            'description'   => 'nullable|string',
            'price'         => 'required|numeric|min:0',
            'stock'         => 'required|integer|min:0',
            'image'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'origin'        => 'nullable|string|max:100',
            'discount_code' => 'nullable|string|max:50',
            'classification'=> 'nullable|string|max:50',
            'status'        => 'required|in:active,inactive',
        ]);

        $data = $request->only(['name', 'category_id', 'description', 'price', 'stock', 'origin', 'discount_code', 'classification', 'status']);

        // Xử lý chuỗi Sizes và Colors
        $data['sizes']  = $request->filled('sizes') ? implode(',', $request->input('sizes')) : null;
        $data['colors'] = $request->filled('colors') ? implode(',', $request->input('colors')) : null;

        // Xử lý Ma trận Biến thể Chi tiết (Màu x Size)
        if ($request->filled('variant_matrix')) {
            $rawMatrix = $request->input('variant_matrix');
            $cleanMatrix = [];
            $sizeTotals = [];
            $colorTotals = [];
            $totalStockSum = 0;

            $selectedColors = $request->input('colors', []);
            $selectedSizes  = $request->input('sizes', []);

            foreach ($selectedColors as $color) {
                if (isset($rawMatrix[$color]) && is_array($rawMatrix[$color])) {
                    foreach ($selectedSizes as $size) {
                        $qty = isset($rawMatrix[$color][$size]) ? (int)$rawMatrix[$color][$size] : 0;
                        $cleanMatrix[$color][$size] = $qty;
                        
                        $sizeTotals[$size]  = ($sizeTotals[$size] ?? 0) + $qty;
                        $colorTotals[$color] = ($colorTotals[$color] ?? 0) + $qty;
                        $totalStockSum += $qty;
                    }
                }
            }

            if (!empty($cleanMatrix)) {
                $data['variants']     = json_encode($cleanMatrix, JSON_UNESCAPED_UNICODE);
                $data['size_stocks']  = json_encode($sizeTotals, JSON_UNESCAPED_UNICODE);
                $data['color_stocks'] = json_encode($colorTotals, JSON_UNESCAPED_UNICODE);
                $data['stock']        = $totalStockSum;
            }
        } else {
            $data['variants']     = null;
            $data['size_stocks']  = null;
            $data['color_stocks'] = null;
        }

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
