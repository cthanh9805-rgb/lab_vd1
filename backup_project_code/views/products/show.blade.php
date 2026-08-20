@extends('layouts.admin')

@section('title', $product->name)

@section('breadcrumb')
    <a href="{{ route('products.index') }}" style="color:var(--accent-light); text-decoration:none;">Sản phẩm</a>
    / <span>{{ $product->name }}</span>
@endsection

@section('content')
<div style="max-width:800px;">

    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:24px;">
        <h1 style="font-size:22px; font-weight:700; color:var(--text-primary);">👠 Chi tiết Sản phẩm</h1>
        <div style="display:flex; gap:10px;">
            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary">
                <i class="fas fa-pen"></i> Sửa
            </a>
            <a href="{{ route('products.index') }}" class="btn btn-outline">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>

    <div class="grid-2" style="gap:24px;">
        <div>
            <div class="card">
                <div class="card-body" style="padding:0; overflow:hidden;">
                    @if ($product->image)
                        <img src="{{ \Illuminate\Support\Str::startsWith($product->image, 'http') ? $product->image : asset($product->image) }}"
                             alt="{{ $product->name }}"
                             style="width:100%; max-height:380px; object-fit:cover; border-radius:16px; display:block;">
                    @else
                        <div style="width:100%; height:280px; display:flex; flex-direction:column; align-items:center; justify-content:center; color:var(--text-muted);">
                            <div style="font-size:80px; margin-bottom:16px;">👠</div>
                            <p>Chưa có hình ảnh</p>
                        </div>
                    @endif
                </div>
            </div>

            @if ($product->sizes)
            <div class="card" style="margin-top:16px;">
                <div class="card-header">
                    <div class="card-title" style="font-size:14px;"><i class="fas fa-ruler" style="color:var(--accent);"></i> Size có sẵn</div>
                </div>
                <div class="card-body" style="padding:16px;">
                    <div style="display:flex; gap:8px; flex-wrap:wrap;">
                        @foreach ($product->sizes_array as $size)
                            <span style="padding:5px 14px; border-radius:20px; background:rgba(56,189,248,0.15); color:var(--accent-light); border:1px solid rgba(56,189,248,0.3); font-size:13px; font-weight:600;">
                                {{ $size }}
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            @if ($product->colors)
            <div class="card" style="margin-top:16px;">
                <div class="card-header">
                    <div class="card-title" style="font-size:14px;"><i class="fas fa-palette" style="color:var(--accent);"></i> Màu sắc</div>
                </div>
                <div class="card-body" style="padding:16px;">
                    <div style="display:flex; gap:12px; flex-wrap:wrap;">
                        @php
                            $colorMap = ['Đen'=>'#1a1a1a','Trắng'=>'#e8e8e8','Nude'=>'#c4a882',
                                         'Đỏ'=>'#c0392b','Hồng'=>'#e91e8c','Nâu'=>'#7a4f37',
                                         'Bạc'=>'#b0b0b0','Vàng'=>'#d4a843'];
                        @endphp
                        @foreach ($product->colors_array as $color)
                        <div style="text-align:center;">
                            <div style="width:32px; height:32px; border-radius:50%; background:{{ $colorMap[$color] ?? '#888' }}; border:2px solid var(--border); margin:0 auto 4px;"></div>
                            <span style="font-size:11px; color:var(--text-muted);">{{ $color }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>

        <div>
            <div class="card">
                <div class="card-header">
                    <div class="card-title"><i class="fas fa-info-circle" style="color:var(--accent);"></i> Thông tin</div>
                </div>
                <div class="card-body">
                    <div style="margin-bottom:16px;">
                        <h2 style="font-size:20px; font-weight:700; color:var(--text-primary); margin-bottom:8px;">
                            {{ $product->name }}
                        </h2>
                        <div class="price-tag">
                            {{ number_format($product->price, 0, ',', '.') }}₫
                        </div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-label"><i class="fas fa-tag" style="color:var(--accent); margin-right:6px;"></i>Danh mục</div>
                        <div class="detail-value">
                            <span style="background:rgba(56,189,248,0.1); color:var(--accent-light); padding:3px 10px; border-radius:6px; font-size:13px;">
                                {{ $product->category->name ?? '—' }}
                            </span>
                        </div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-label"><i class="fas fa-boxes" style="color:var(--accent); margin-right:6px;"></i>Tồn kho</div>
                        <div class="detail-value" style="color:{{ $product->stock > 0 ? 'var(--success)' : 'var(--danger)' }};">
                            {{ $product->stock }} đôi
                            @if ($product->stock == 0)
                                <span style="font-size:12px;">(Hết hàng)</span>
                            @endif
                        </div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-label"><i class="fas fa-circle" style="color:var(--accent); margin-right:6px;"></i>Trạng thái</div>
                        <div class="detail-value">
                            @if ($product->status === 'active')
                                <span class="badge badge-success"><i class="fas fa-circle" style="font-size:6px;"></i> Đang bán</span>
                            @else
                                <span class="badge badge-danger"><i class="fas fa-circle" style="font-size:6px;"></i> Ngừng bán</span>
                            @endif
                        </div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-label"><i class="fas fa-calendar" style="color:var(--accent); margin-right:6px;"></i>Ngày tạo</div>
                        <div class="detail-value">{{ $product->created_at->format('d/m/Y H:i') }}</div>
                    </div>

                    @if ($product->description)
                    <div class="detail-row" style="flex-direction:column; gap:8px;">
                        <div class="detail-label"><i class="fas fa-align-left" style="color:var(--accent); margin-right:6px;"></i>Mô tả</div>
                        <div class="detail-value" style="line-height:1.7; color:var(--text-secondary);">
                            {{ $product->description }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <div style="display:flex; gap:10px; margin-top:16px;">
                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary" style="flex:1; justify-content:center;">
                    <i class="fas fa-pen"></i> Chỉnh sửa
                </a>
                <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                      onsubmit="return confirm('Xoá sản phẩm này?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger-sm" style="padding:10px 20px; font-size:13px; cursor:pointer;">
                        <i class="fas fa-trash"></i> Xoá
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
