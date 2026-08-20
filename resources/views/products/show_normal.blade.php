@extends('layouts.app')

@section('title', $product->name . ' - MyShop')

@section('content')
<div class="container my-4" style="max-width:900px;">
    
    <div class="card card-custom p-4">
        <div class="row g-4 align-items-center">
            
            <!-- CỘT ẢNH SẢN PHẨM -->
            <div class="col-md-5 text-center">
                <div class="rounded-4 overflow-hidden shadow-lg border border-secondary" style="background:#0f172a; max-height:360px;">
                    <img src="{{ $product->primary_image_url }}" class="img-fluid w-100 h-100" style="object-fit:cover;" alt="{{ $product->name }}">
                </div>
            </div>

            <!-- CỘT THÔNG TIN HƯỚNG DẪN LAB 03 SECTION 8 -->
            <div class="col-md-7">
                <h1 class="text-white fw-bold mb-3" style="font-size:28px;">{{ $product->name }}</h1>
                
                <p class="text-secondary mb-3" style="font-size:15px; line-height:1.6;">
                    {{ $product->description ?: 'Chưa có mô tả chi tiết cho sản phẩm này.' }}
                </p>

                <hr class="border-secondary my-3">

                <div class="mb-3">
                    <p class="text-info mb-1" style="font-size:15px;">
                        Quantity: <strong>{{ $product->stock }}</strong> đôi sẵn có
                    </p>
                    <p class="text-warning fw-bold mb-2" style="font-size:24px;">
                        Price: {{ number_format($product->price, 0, ',', '.') }}₫
                        @if ($product->original_price && $product->original_price > $product->price)
                            <small class="text-decoration-line-through text-muted fs-6 ms-2">{{ number_format($product->original_price, 0, ',', '.') }}₫</small>
                        @endif
                    </p>
                    <p class="text-light mb-3" style="font-size:14px;">
                        Category: <span class="badge bg-secondary fs-6">{{ optional($product->category)->name ?? 'Chưa xếp loại' }}</span>
                    </p>
                </div>

                @if ($product->sizes_list && count($product->sizes_list) > 0)
                    <div class="mb-3">
                        <label class="text-secondary small d-block mb-1">Kích thước (Size):</label>
                        <div class="d-flex gap-2">
                            @foreach ($product->sizes_list as $size)
                                <span class="badge bg-dark border border-secondary text-white px-3 py-2">{{ $size }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="d-flex gap-3 mt-4">
                    <a href="{{ route('welcome') }}" class="btn btn-outline-light px-4 py-2" style="border-radius:10px;">
                        ← Back to list
                    </a>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection
