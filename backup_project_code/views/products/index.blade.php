@extends('layouts.admin')

@section('title', 'Quản lý Sản phẩm')

@section('breadcrumb')
    <span>Sản phẩm</span> / Danh sách
@endsection

@section('content')

@if ($message = Session::get('success'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i> {{ $message }}
    </div>
@endif

@if ($message = Session::get('error'))
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-circle"></i> {{ $message }}
    </div>
@endif

<div class="card">
    <div class="card-header">
        <div class="card-title">
            👠 Danh sách Sản phẩm
            <span style="font-size:12px; background:rgba(56,189,248,0.15); color:var(--accent-light); padding:2px 10px; border-radius:20px;">
                {{ $products->total() }} sản phẩm
            </span>
        </div>
        <a href="{{ route('products.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Thêm sản phẩm
        </a>
    </div>

    <div style="overflow-x: auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width:50px;">#</th>
                    <th style="width:60px;">Ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Danh mục</th>
                    <th>Giá</th>
                    <th>Tồn kho</th>
                    <th>Size</th>
                    <th>Màu sắc</th>
                    <th>Trạng thái</th>
                    <th style="width:160px;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                <tr>
                    <td style="color:var(--text-muted);">{{ ($products->currentPage() - 1) * $products->perPage() + $loop->iteration }}</td>
                    <td>
                        @if ($product->image)
                            <img src="{{ \Illuminate\Support\Str::startsWith($product->image, 'http') ? $product->image : asset($product->image) }}"
                                 alt="{{ $product->name }}" class="product-img">
                        @else
                            <div class="product-img-placeholder">
                                <i class="fas fa-image"></i>
                            </div>
                        @endif
                    </td>
                    <td><strong>{{ $product->name }}</strong></td>
                    <td>
                        <span style="background:rgba(56,189,248,0.1); color:var(--accent-light); padding:3px 8px; border-radius:6px; font-size:12px;">
                            {{ $product->category->name ?? '—' }}
                        </span>
                    </td>
                    <td style="color:var(--accent-light); font-weight:600;">
                        {{ number_format($product->price, 0, ',', '.') }}₫
                    </td>
                    <td>
                        <span style="color:{{ $product->stock > 0 ? 'var(--success)' : 'var(--danger)' }}; font-weight:600;">
                            {{ $product->stock }}
                        </span>
                    </td>
                    <td style="font-size:12px; color:var(--text-muted);">
                        {{ $product->sizes ?: '—' }}
                    </td>
                    <td style="font-size:12px; color:var(--text-muted);">
                        {{ $product->colors ?: '—' }}
                    </td>
                    <td>
                        @if ($product->status === 'active')
                            <span class="badge badge-success"><i class="fas fa-circle" style="font-size:6px;"></i> Đang bán</span>
                        @else
                            <span class="badge badge-danger"><i class="fas fa-circle" style="font-size:6px;"></i> Ngừng bán</span>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex; gap:6px; flex-wrap:wrap;">
                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-info-sm">
                                <i class="fas fa-eye"></i> Xem
                            </a>
                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warn-sm">
                                <i class="fas fa-pen"></i> Sửa
                            </a>
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                  style="display:inline;" onsubmit="return confirm('Bạn có chắc muốn xoá sản phẩm này?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger-sm" style="cursor:pointer;">
                                    <i class="fas fa-trash"></i> Xoá
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" style="text-align:center; padding:40px; color:var(--text-muted);">
                        <div style="font-size:40px; margin-bottom:12px;">👠</div>
                        Chưa có sản phẩm nào. <a href="{{ route('products.create') }}" style="color:var(--accent-light);">Thêm ngay!</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($products->hasPages())
    <div style="padding:16px 24px; border-top:1px solid var(--border);">
        {{ $products->links() }}
    </div>
    @endif
</div>

@endsection
