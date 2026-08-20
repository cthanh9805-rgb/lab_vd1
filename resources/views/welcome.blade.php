@extends('layouts.app')

@section('title', 'HEEL BOUTIQUE - Trang Chủ Cửa Hàng')

@section('content')

<!-- HERO BANNER LIGHT BOUTIQUE (GIỐNG MẪU THIẾT KẾ 100%) -->
<div class="container my-4">
    <div class="rounded-4 overflow-hidden position-relative shadow-sm" style="background: linear-gradient(135deg, #fdfbf7 0%, #f5ece5 100%); border: 1px solid #f1f5f9;">
        <div class="row align-items-center g-0">
            <div class="col-lg-6 p-4 p-md-5 z-1">
                <span class="badge px-3 py-2 rounded-pill bg-dark text-white mb-3 font-monospace" style="font-size:12px; letter-spacing:1px;">BỘ SƯU TẬP MỚI 2026</span>
                <h1 class="display-4 fw-bold mb-3" style="font-family:'Playfair Display', serif; color:#1e293b; line-height:1.2;">
                    SANG TRỌNG TRONG TỪNG BƯỚC CHÂN
                </h1>
                <p class="lead text-muted mb-4" style="font-size:16px;">
                    Khuyến mãi lên đến 30% cho bộ sưu tập Giày Cao Gót Thu Đông Mới Nhất. Tôn vinh vẻ đẹp quý phái của phái đẹp.
                </p>
                <a href="#product-grid" class="btn btn-rose-gold btn-lg px-4 py-3 rounded-3 shadow">
                    Mua Sắm Ngay <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
            <div class="col-lg-6 text-end">
                <img src="https://images.unsplash.com/photo-1543163521-1bf539c55dd2?auto=format&fit=crop&w=1000&q=80" 
                     class="img-fluid w-100" style="max-height:460px; object-fit:cover; border-top-right-radius:16px; border-bottom-right-radius:16px;" alt="Heel Fashion Runway">
            </div>
        </div>
    </div>
</div>

<!-- THANH TAB LỌC NHANH (TẤT CẢ, HÀNG MỚI, BÁN CHẠY, GIẢM GIÁ) -->
<div class="container my-4" id="product-grid">
    <div class="d-flex flex-wrap justify-content-center align-items-center gap-2 mb-4">
        <a href="{{ route('welcome') }}" 
           class="btn btn-sm px-4 py-2 rounded-pill fw-semibold {{ !request('filter') && !request('category_id') ? 'btn-dark' : 'btn-light text-dark border' }}">
            Tất cả
        </a>
        <a href="{{ route('welcome', ['filter' => 'new']) }}" 
           class="btn btn-sm px-4 py-2 rounded-pill fw-semibold {{ request('filter') == 'new' ? 'btn-dark' : 'btn-light text-dark border' }}">
            Hàng mới
        </a>
        <a href="{{ route('welcome', ['filter' => 'best']) }}" 
           class="btn btn-sm px-4 py-2 rounded-pill fw-semibold {{ request('filter') == 'best' ? 'btn-dark' : 'btn-light text-dark border' }}">
            Bán chạy
        </a>
        <a href="{{ route('welcome', ['filter' => 'sale']) }}" 
           class="btn btn-sm px-4 py-2 rounded-pill fw-semibold {{ request('filter') == 'sale' ? 'btn-dark' : 'btn-light text-dark border' }}">
            Giảm giá
        </a>

        @foreach ($categories as $cat)
            <a href="{{ route('welcome', ['category_id' => $cat->id]) }}" 
               class="btn btn-sm px-3 py-2 rounded-pill fw-semibold {{ request('category_id') == $cat->id ? 'btn-dark' : 'btn-light text-dark border' }}">
                {{ $cat->name }}
            </a>
        @endforeach
    </div>

    <!-- TÌM KIẾM -->
    <div class="row justify-content-center mb-4">
        <div class="col-md-6 col-lg-5">
            <form action="{{ route('welcome') }}" method="GET" class="input-group">
                <input type="text" name="search" class="form-control rounded-start-pill border-end-0 px-4 py-2" placeholder="🔍 Tìm tên sản phẩm..." value="{{ request('search') }}">
                <button class="btn btn-dark rounded-end-pill px-4" type="submit">Tìm</button>
            </form>
        </div>
    </div>

    <!-- LƯỚI SẢN PHẨM SHOWCASE (HIỂN THỊ CHUẨN MẪU THIẾT KẾ LIGHT BOUTIQUE) -->
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 mb-5">
        @forelse ($products as $product)
            <div class="col">
                <div class="card card-boutique h-100 position-relative">
                    
                    <!-- BADGE MỚI / GIẢM GIÁ -->
                    <div class="position-absolute top-0 start-0 m-3 z-2">
                        @if ($product->discount_percentage > 0)
                            <span class="badge bg-danger px-2 py-1 rounded-2 shadow-sm">-{{ $product->discount_percentage }}%</span>
                        @else
                            <span class="badge bg-dark px-2 py-1 rounded-2 shadow-sm font-monospace">MỚI</span>
                        @endif
                    </div>

                    <!-- KHUNG ẢNH NỀN SÁNG VỚI NÚT HOVER -->
                    <div class="position-relative overflow-hidden" style="background:#f8fafc; height:240px; border-top-left-radius:16px; border-top-right-radius:16px;">
                        <img src="{{ $product->primary_image_url }}" class="w-100 h-100" style="object-fit:cover; transition:transform 0.4s ease;" alt="{{ $product->name }}">
                    </div>

                    <!-- BODY THÔNG TIN SẢN PHẨM -->
                    <div class="card-body p-3 d-flex flex-column justify-content-between text-start">
                        <div>
                            <h6 class="fw-bold text-dark mb-1 text-truncate" style="font-size:15px;" title="{{ $product->name }}">{{ $product->name }}</h6>
                            
                            <!-- ĐÁNH GIÁ SAO ⭐ -->
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="fw-bold text-dark" style="font-size:15px;">{{ number_format($product->price, 0, ',', '.') }}₫</span>
                                <div class="text-warning" style="font-size:12px;">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                        </div>

                        <!-- NÚT XEM NHANH / THÊM VÀO GIỎ -->
                        <a href="{{ route('products.show_normal', $product->id) }}" 
                           class="btn btn-dark w-100 py-2 rounded-3 text-center text-white text-decoration-none fw-semibold shadow-sm" style="font-size:12px;">
                            Xem nhanh / Thêm vào giỏ hàng
                        </a>
                    </div>

                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <div style="font-size:48px; margin-bottom:12px;">👠</div>
                <h4 class="fw-bold text-dark">Chưa có sản phẩm nào!</h4>
                <p class="text-muted">Vui lòng thử chọn danh mục khác hoặc quay lại sau.</p>
                <a href="{{ route('welcome') }}" class="btn btn-rose-gold mt-2">Xem Tất Cả Sản Phẩm</a>
            </div>
        @endforelse
    </div>

    <!-- PHÂN TRANG -->
    <div class="d-flex justify-content-center mb-5">
        {{ $products->links() }}
    </div>

    <!-- PROMO BANNER BOTTOM (SƯU TẬP GIÀY BỐT THU ĐÔNG - GIẢM 25%) -->
    <div class="rounded-4 p-4 p-md-5 text-center text-dark my-5 position-relative overflow-hidden" 
         style="background: linear-gradient(135deg, #f5ece5 0%, #fdfbf7 100%); border: 1px solid #f1f5f9;">
        <span class="badge bg-dark px-3 py-2 rounded-pill mb-2">ƯU ĐÃI ĐẶC BIỆT</span>
        <h2 class="display-6 fw-bold mb-3" style="font-family:'Playfair Display', serif;">Sưu Tập Giày Bốt Thu Đông - Giảm 25%</h2>
        <p class="text-muted mb-4 max-w-md mx-auto">Áp dụng cho tất cả các đơn hàng giày bốt da thật trong tháng này. Hãy nhanh tay sở hữu đôi giày yêu thích của bạn!</p>
        <a href="{{ route('welcome') }}" class="btn btn-dark btn-lg px-5 py-3 rounded-3 shadow">Khám Phá Ngay</a>
    </div>

</div>

@endsection
