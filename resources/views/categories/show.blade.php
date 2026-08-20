@extends('layouts.admin')

@section('title', $category->name)

@section('breadcrumb')
    <a href="{{ route('categories.index') }}" style="color:var(--accent-light); text-decoration:none;">Danh mục</a>
    / <span>{{ $category->name }}</span>
@endsection

@section('content')
<div style="max-width:900px;">
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:24px;">
        <h1 style="font-size:22px; font-weight:700; color:var(--text-primary);">🏷️ Chi tiết Danh mục</h1>
        <div style="display:flex; gap:10px;">
            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-primary">
                <i class="fas fa-pen"></i> Sửa
            </a>
            <a href="{{ route('categories.index') }}" class="btn btn-outline">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>

    <div class="card" style="margin-bottom:24px;">
        <div class="card-header">
            <div class="card-title"><i class="fas fa-info-circle" style="color:var(--accent);"></i> Thông tin chung</div>
        </div>
        <div class="card-body">
            <div class="detail-row">
                <div class="detail-label">Tên danh mục</div>
                <div class="detail-value" style="font-size:16px; font-weight:700; color:var(--accent-light);">{{ $category->name }}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Số sản phẩm thuộc nhóm</div>
                <div class="detail-value">
                    <span style="background:rgba(56,189,248,0.15); color:var(--accent-light); padding:4px 12px; border-radius:12px; font-weight:700;">
                        👠 {{ $category->products->count() }} sản phẩm
                    </span>
                </div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Ngày khởi tạo</div>
                <div class="detail-value">{{ $category->created_at->format('d/m/Y H:i') }}</div>
            </div>
        </div>
    </div>

    {{-- Danh sách các sản phẩm thuộc danh mục này --}}
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                👠 Sản phẩm thuộc danh mục "{{ $category->name }}"
            </div>
        </div>
        <div style="overflow-x:auto;">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width:50px;">#</th>
                        <th style="width:50px;">Ảnh</th>
                        <th>Tên sản phẩm</th>
                        <th>Giá</th>
                        <th>Tồn kho</th>
                        <th>Trạng thái</th>
                        <th style="width:100px;">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($category->products as $index => $product)
                    <tr>
                        <td style="color:var(--text-muted);">{{ $index + 1 }}</td>
                        <td>
                            @if ($product->image)
                                <img src="{{ \Illuminate\Support\Str::startsWith($product->image, 'http') ? $product->image : asset($product->image) }}"
                                     alt="{{ $product->name }}" class="product-img" style="width:40px; height:40px;">
                            @else
                                <div class="product-img-placeholder" style="width:40px; height:40px; font-size:14px;">
                                    <i class="fas fa-image"></i>
                                </div>
                            @endif
                        </td>
                        <td><strong>{{ $product->name }}</strong></td>
                        <td style="color:var(--accent-light); font-weight:600;">
                            {{ number_format($product->price, 0, ',', '.') }}₫
                        </td>
                        <td>
                            <span style="color:{{ $product->stock > 0 ? 'var(--success)' : 'var(--danger)' }}; font-weight:600;">
                                {{ $product->stock }}
                            </span>
                        </td>
                        <td>
                            @if ($product->status === 'active')
                                <span class="badge badge-success">Đang bán</span>
                            @else
                                <span class="badge badge-danger">Ngừng bán</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-info-sm">
                                <i class="fas fa-eye"></i> Xem
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align:center; padding:30px; color:var(--text-muted);">
                            Chưa có sản phẩm nào thuộc danh mục này.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection