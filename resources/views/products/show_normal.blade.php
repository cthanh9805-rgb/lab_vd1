@extends('layouts.app')

@section('title', $product->name . ' - HEEL BOUTIQUE')

@section('content')
<div class="container my-5" style="max-width:960px;">
    
    <div class="card card-boutique p-4 p-md-5">
        <div class="row g-4 align-items-center">
            
            <!-- CỘT ẢNH SẢN PHẨM -->
            <div class="col-md-5 text-center">
                <div class="rounded-4 overflow-hidden shadow-sm border" style="background:#f8fafc; max-height:380px;">
                    <img src="{{ $product->primary_image_url }}" class="img-fluid w-100 h-100" style="object-fit:cover;" alt="{{ $product->name }}">
                </div>
            </div>

            <!-- CỘT THÔNG TIN CHI TIẾT SẢN PHẨM -->
            <div class="col-md-7 text-start">
                <span class="badge bg-dark px-3 py-2 rounded-pill font-monospace mb-2">HEEL BOUTIQUE</span>
                
                <h1 class="fw-bold text-dark mb-2" style="font-family:'Playfair Display', serif; font-size:30px;">{{ $product->name }}</h1>
                
                <div class="d-flex align-items-center gap-3 mb-3">
                    <span class="fs-3 fw-bold text-dark">{{ number_format($product->price, 0, ',', '.') }}₫</span>
                    @if ($product->original_price && $product->original_price > $product->price)
                        <span class="text-decoration-line-through text-muted fs-6">{{ number_format($product->original_price, 0, ',', '.') }}₫</span>
                        <span class="badge bg-danger rounded-2">-{{ $product->discount_percentage }}%</span>
                    @endif
                    <div class="text-warning ms-auto" style="font-size:14px;">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                        <span class="text-dark small ms-1">(4.9/5)</span>
                    </div>
                </div>

                <p class="text-muted mb-4" style="font-size:15px; line-height:1.6;">
                    {{ $product->description ?: 'Sản phẩm cao gót thiết kế kiêu sa, chất liệu 100% da thật mềm mại tôn dáng quyến rũ.' }}
                </p>

                <hr class="my-4 text-muted">

                <div class="mb-4">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="fw-semibold text-dark">Tình trạng:</span>
                        <span class="badge bg-success bg-opacity-10 text-success border border-success px-3 py-1">Còn hàng ({{ $product->stock }} đôi)</span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="fw-semibold text-dark">Danh mục:</span>
                        <span class="badge bg-light text-dark border px-3 py-1">{{ optional($product->category)->name ?? 'Chưa xếp loại' }}</span>
                    </div>
                </div>

                @if ($product->sizes_list && count($product->sizes_list) > 0)
                    <div class="mb-4">
                        <label class="fw-semibold text-dark d-block mb-2">Kích thước (Size):</label>
                        <div class="d-flex gap-2">
                            @foreach ($product->sizes_list as $size)
                                <span class="border rounded-2 text-dark px-3 py-2 fw-semibold" style="cursor:pointer; background:#f8fafc;">{{ $size }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="d-flex gap-3 mt-4">
                    <button class="btn btn-rose-gold btn-lg flex-grow-1 rounded-3 py-3 shadow">
                        <i class="fas fa-shopping-bag me-2"></i> Thêm Vào Giỏ Hàng
                    </button>
                    <a href="{{ route('welcome') }}" class="btn btn-outline-dark btn-lg rounded-3 px-4 py-3">
                        ← Quay lại
                    </a>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection
