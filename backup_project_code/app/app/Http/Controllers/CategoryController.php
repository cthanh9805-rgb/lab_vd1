<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->latest()->get();
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        $category = Category::create($request->only('name'));
        ActivityLog::record('create_category', 'Đã tạo danh mục mới "' . $category->name . '"');

        return redirect()->route('categories.index')
            ->with('success', 'Danh mục đã được tạo thành công! 🏷️');
    }

    public function show(Category $category)
    {
        $category->load('products');
        return view('categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
        ]);

        $category->update($request->only('name'));
        ActivityLog::record('update_category', 'Đã cập nhật danh mục "' . $category->name . '"');

        return redirect()->route('categories.index')
            ->with('success', 'Cập nhật danh mục thành công! ✨');
    }

    public function destroy(Category $category)
    {
        if ($category->products()->count() > 0) {
            return back()->with('error', '⚠️ Danh mục "' . $category->name . '" đang chứa ' . $category->products()->count() . ' sản phẩm. Vui lòng chuyển hoặc xoá hết sản phẩm trước khi xoá danh mục!');
        }

        $catName = $category->name;
        $category->delete();
        ActivityLog::record('delete_category', 'Đã xoá danh mục "' . $catName . '"');

        return redirect()->route('categories.index')
            ->with('success', 'Đã xoá danh mục thành công!');
    }
}
