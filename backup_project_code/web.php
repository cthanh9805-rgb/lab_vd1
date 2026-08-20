<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes - Đường dẫn ứng dụng
|--------------------------------------------------------------------------
*/

// 1. Trang chủ (Redirect tự động sang danh sách sản phẩm)
Route::get('/', function () {
    return redirect()->route('products.index');
});

// 2. Resource Route cho Danh mục (Categories) - Đầy đủ 7 đường dẫn CRUD
Route::resource('categories', CategoryController::class);

// 3. Resource Route cho Sản phẩm (Products) - Đầy đủ 7 đường dẫn CRUD
Route::resource('products', ProductController::class);
