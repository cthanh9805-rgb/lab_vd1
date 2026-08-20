<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
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

        // Lọc theo Xuất xứ
        if ($request->filled('origin')) {
            $query->where('origin', $request->origin);
        }

        // Lọc theo Trạng thái
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Lọc theo Tồn kho
        if ($request->filled('stock_status')) {
            if ($request->stock_status === 'in_stock') {
                $query->where('stock', '>', 0);
            } elseif ($request->stock_status === 'out_of_stock') {
                $query->where('stock', '<=', 0);
            }
        }

        // Lọc theo khoảng giá
        if ($request->filled('price_from')) {
            $query->where('price', '>=', $request->price_from);
        }
        if ($request->filled('price_to')) {
            $query->where('price', '<=', $request->price_to);
        }

        // Sắp xếp
        $sortField = 'created_at';
        $sortDir = 'desc';
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'price_asc':  $sortField = 'price'; $sortDir = 'asc'; break;
                case 'price_desc': $sortField = 'price'; $sortDir = 'desc'; break;
                case 'name_asc':   $sortField = 'name';  $sortDir = 'asc'; break;
                case 'name_desc':  $sortField = 'name';  $sortDir = 'desc'; break;
                case 'stock_desc': $sortField = 'stock'; $sortDir = 'desc'; break;
                case 'stock_asc':  $sortField = 'stock'; $sortDir = 'asc'; break;
                default:           $sortField = 'created_at'; $sortDir = 'desc'; break;
            }
        }

        $products   = $query->orderBy($sortField, $sortDir)->paginate(10)->withQueryString();
        $categories = Category::all();

        // Thống kê tóm tắt (dùng query gốc không phân trang)
        $statsQuery = Product::query();
        $stats = [
            'total'       => Product::count(),
            'active'      => Product::where('status', 'active')->count(),
            'out_of_stock'=> Product::where('stock', '<=', 0)->count(),
            'avg_price'   => (int) Product::avg('price'),
        ];

        return view('products.index', compact('products', 'categories', 'stats'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'category_id'    => 'required|exists:categories,id',
            'description'    => 'nullable|string',
            'price'          => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'stock'          => 'required|integer|min:0',
            'image'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'gallery.*'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'origin'         => 'nullable|string|max:100',
            'discount_code'  => 'nullable|string|max:50',
            'classification' => 'nullable|string|max:50',
            'heel_height'    => 'nullable|integer|min:0|max:20',
            'material'       => 'nullable|string|max:100',
            'weight'         => 'nullable|integer|min:0',
            'status'         => 'required|in:active,inactive',
        ]);

        $data = $request->only(['name', 'category_id', 'description', 'price', 'original_price', 'stock', 'origin', 'discount_code', 'classification', 'heel_height', 'material', 'weight', 'status']);

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
            $cleanMatrix = []; $sizeTotals = []; $colorTotals = []; $totalStockSum = 0;
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

        // Upload ảnh đại diện
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/products'), $imageName);
            $data['image'] = 'images/products/' . $imageName;
        }

        $product = Product::create($data);

        // Upload Gallery nhiều ảnh
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $index => $file) {
                $galleryName = time() . '_gallery_' . $index . '_' . $file->getClientOriginalName();
                $file->move(public_path('images/products'), $galleryName);
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => 'images/products/' . $galleryName,
                    'sort_order' => $index,
                ]);
            }
        }

        return redirect()->route('products.index')
            ->with('success', 'Sản phẩm đã được thêm thành công! 👠');
    }

    public function show(Product $product)
    {
        $product->load('category', 'images');
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $product->load('images');
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'category_id'    => 'required|exists:categories,id',
            'description'    => 'nullable|string',
            'price'          => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'stock'          => 'required|integer|min:0',
            'image'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'gallery.*'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'origin'         => 'nullable|string|max:100',
            'discount_code'  => 'nullable|string|max:50',
            'classification' => 'nullable|string|max:50',
            'heel_height'    => 'nullable|integer|min:0|max:20',
            'material'       => 'nullable|string|max:100',
            'weight'         => 'nullable|integer|min:0',
            'status'         => 'required|in:active,inactive',
        ]);

        $data = $request->only(['name', 'category_id', 'description', 'price', 'original_price', 'stock', 'origin', 'discount_code', 'classification', 'heel_height', 'material', 'weight', 'status']);

        // Xử lý chuỗi Sizes và Colors
        $data['sizes']  = $request->filled('sizes') ? implode(',', $request->input('sizes')) : null;
        $data['colors'] = $request->filled('colors') ? implode(',', $request->input('colors')) : null;

        // Xử lý Ma trận Biến thể Chi tiết (Màu x Size)
        if ($request->filled('variant_matrix')) {
            $rawMatrix = $request->input('variant_matrix');
            $cleanMatrix = []; $sizeTotals = []; $colorTotals = []; $totalStockSum = 0;
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

        // Upload ảnh đại diện mới
        if ($request->hasFile('image')) {
            if ($product->image && !str_starts_with($product->image, 'http') && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/products'), $imageName);
            $data['image'] = 'images/products/' . $imageName;
        }

        $product->update($data);

        // Xoá ảnh gallery được chọn
        if ($request->filled('delete_images')) {
            $deleteIds = $request->input('delete_images');
            $imagesToDelete = ProductImage::whereIn('id', $deleteIds)->where('product_id', $product->id)->get();
            foreach ($imagesToDelete as $img) {
                if (file_exists(public_path($img->image_path))) {
                    unlink(public_path($img->image_path));
                }
                $img->delete();
            }
        }

        // Upload Gallery mới
        if ($request->hasFile('gallery')) {
            $maxSort = $product->images()->max('sort_order') ?? 0;
            foreach ($request->file('gallery') as $index => $file) {
                $galleryName = time() . '_gallery_' . $index . '_' . $file->getClientOriginalName();
                $file->move(public_path('images/products'), $galleryName);
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => 'images/products/' . $galleryName,
                    'sort_order' => $maxSort + $index + 1,
                ]);
            }
        }

        return redirect()->route('products.index')
            ->with('success', 'Sản phẩm đã được cập nhật thành công! ✨');
    }

    public function destroy(Product $product)
    {
        $product->delete(); // Soft delete → vào thùng rác
        return redirect()->route('products.index')
            ->with('success', 'Sản phẩm đã được chuyển vào thùng rác! 🗑️');
    }

    // ===== THÙNG RÁC =====

    public function trash()
    {
        $products = Product::onlyTrashed()->with('category')->latest('deleted_at')->paginate(10);
        return view('products.trash', compact('products'));
    }

    public function restore($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->restore();
        return redirect()->route('products.trash')
            ->with('success', 'Đã khôi phục sản phẩm "' . $product->name . '" thành công! ♻️');
    }

    public function forceDelete($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);

        // Xoá ảnh đại diện
        if ($product->image && !str_starts_with($product->image, 'http') && file_exists(public_path($product->image))) {
            unlink(public_path($product->image));
        }
        // Xoá gallery
        foreach ($product->images as $img) {
            if (file_exists(public_path($img->image_path))) {
                unlink(public_path($img->image_path));
            }
            $img->delete();
        }

        $product->forceDelete();
        return redirect()->route('products.trash')
            ->with('success', 'Đã xoá vĩnh viễn sản phẩm! 💀');
    }

    // ===== XUẤT EXCEL (CSV) =====

    public function export(Request $request)
    {
        $products = Product::with('category')->orderBy('name')->get();

        $filename = 'san_pham_' . date('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($products) {
            $file = fopen('php://output', 'w');
            // BOM for UTF-8 Excel compatibility
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Header row
            fputcsv($file, [
                'STT', 'Tên sản phẩm', 'Danh mục', 'Phân loại',
                'Giá gốc (₫)', 'Giá bán (₫)', 'Giảm (%)',
                'Tồn kho', 'Xuất xứ', 'Chất liệu', 'Cao gót (cm)', 'Cân nặng (g)',
                'Màu sắc', 'Size', 'Mã giảm giá', 'Trạng thái',
            ]);

            foreach ($products as $i => $p) {
                fputcsv($file, [
                    $i + 1,
                    $p->name,
                    $p->category->name ?? '—',
                    $p->classification ?? '—',
                    $p->original_price ?? '—',
                    $p->price,
                    $p->discount_percent ? ($p->discount_percent . '%') : '—',
                    $p->stock,
                    $p->origin ?? '—',
                    $p->material ?? '—',
                    $p->heel_height ? ($p->heel_height . 'cm') : '—',
                    $p->weight ? ($p->weight . 'g') : '—',
                    $p->colors ?? '—',
                    $p->sizes ?? '—',
                    $p->discount_code ?? '—',
                    $p->status === 'active' ? 'Đang bán' : 'Ngừng bán',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
