@extends('layouts.app')

@section('title', 'Trang Chủ - MyShop')

@section('content')
<div class="container mt-2">

    <!-- HERO BANNER TỐI GIẢN LAB 03 -->
    <div class="p-4 p-md-5 mb-4 rounded-4 text-body-emphasis" style="background: linear-gradient(135deg, rgba(30,41,59,0.9), rgba(15,23,42,0.9)), url('https://images.unsplash.com/photo-1543163521-1bf539c55dd2?auto=format&fit=crop&w=1200&q=80') center/cover; border: 1px solid var(--border-color); box-shadow: 0 20px 40px rgba(0,0,0,0.4);">
        <div class="col-lg-8 ps-0">
            <h1 class="display-5 fw-bold text-white mb-3">👠 Welcome to Our Store</h1>
            <p class="lead text-light mb-4">Khám phá bộ sưu tập giày cao gót thanh lịch, sang trọng và tôn dáng người phụ nữ Việt Nam. Chất lượng tuyệt hảo - Mua sắm dễ dàng.</p>
        </div>
    </div>

    <!-- THANH LỌC DANH MỤC & TÌM KIẾM -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div class="d-flex gap-2 align-items-center">
            <a href="{{ route('welcome') }}" class="btn btn-sm {{ !request('category_id') ? 'btn-info text-white fw-bold' : 'btn-outline-secondary text-light' }}" style="border-radius:20px;">
                Tất cả sản phẩm
            </a>
            @foreach ($categories as $cat)
                <a href="{{ route('welcome', ['category_id' => $cat->id]) }}" 
                   class="btn btn-sm {{ request('category_id') == $cat->id ? 'btn-info text-white fw-bold' : 'btn-outline-secondary text-light' }}" 
                   style="border-radius:20px;">
                    {{ $cat->name }} <span class="badge bg-dark ms-1">{{ $cat->products_count }}</span>
                </a>
            @endforeach
        </div>

        <form action="{{ route('welcome') }}" method="GET" class="d-flex gap-2">
            <input type="text" name="search" class="form-control form-control-sm bg-dark text-white border-secondary" placeholder="🔍 Tìm kiếm sản phẩm..." value="{{ request('search') }}" style="border-radius:20px; width:220px;">
            <button type="submit" class="btn btn-sm btn-info text-white px-3" style="border-radius:20px;">Tìm</button>
        </form>
    </div>

    <!-- DANH SÁCH SẢN PHẨM (HƯỚNG DẪN LAB 03 - SECTION 7) -->
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4 mb-4">
        @forelse ($products as $product)
            <div class="col">
                <div class="card h-100 card-custom">
                    <!-- Ảnh sản phẩm -->
                    <div style="position:relative; height:200px; overflow:hidden; border-top-left-radius:16px; border-top-right-radius:16px; background:#0f172a;">
                        <img src="{{ $product->primary_image_url }}" class="w-100 h-100" style="object-fit:cover;" alt="{{ $product->name }}">
                        @if ($product->discount_percentage > 0)
                            <span class="badge bg-danger position-absolute top-0 end-0 m-2 px-2 py-1" style="font-size:12px;">
                                -{{ $product->discount_percentage }}%
                            </span>
                        @endif
                    </div>

                    <div class="card-body text-center d-flex flex-column justify-content-between p-3">
                        <div>
                            <h5 class="card-title text-white font-weight-bold mb-2" style="font-size:16px; font-weight:700;">{{ $product->name }}</h5>
                            <p class="card-text text-secondary mb-2" style="font-size:13px; line-height:1.4;">
                                {{ Str::limit($product->description, 60, '...') ?: 'Sản phẩm cao gót chất lượng cao.' }}
                            </p>
                            <p class="card-text text-info mb-1" style="font-size:13px;">
                                Quantity: <strong>{{ $product->stock }}</strong> đôi
                            </p>
                            <p class="card-text text-warning font-weight-bold mb-2" style="font-size:16px; font-weight:700;">
                                Price: {{ number_format($product->price, 0, ',', '.') }}₫
                            </p>
                            <p class="card-text text-muted mb-3" style="font-size:12px;">
                                Category: <span class="badge bg-secondary">{{ optional($product->category)->name ?? 'Chưa xếp loại' }}</span>
                            </p>
                        </div>

                        <a href="{{ route('products.show_normal', $product->id) }}" class="btn btn-info text-white w-100 fw-bold py-2" style="border-radius:10px; font-size:14px;">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <div style="font-size:48px; margin-bottom:12px;">👠</div>
                <h4 class="text-white">Không tìm thấy sản phẩm nào!</h4>
                <p class="text-secondary">Vui lòng thử tìm kiếm bằng từ khoá hoặc danh mục khác.</p>
                <a href="{{ route('welcome') }}" class="btn btn-outline-info mt-2">Xem tất cả sản phẩm</a>
            </div>
        @endforelse
    </div>

    <!-- PHÂN TRANG LAB 03 -->
    <div class="d-flex justify-content-center mt-4">
        {{ $products->links() }}
    </div>

</div>
@endsection
