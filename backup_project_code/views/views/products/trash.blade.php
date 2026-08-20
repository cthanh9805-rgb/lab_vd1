@extends('layouts.admin')

@section('title', 'Thùng rác')

@section('breadcrumb')
    <a href="{{ route('products.index') }}" style="color:var(--accent-light); text-decoration:none;">Sản phẩm</a>
    / <span>Thùng rác</span>
@endsection

@section('content')

@if ($message = Session::get('success'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i> {{ $message }}
    </div>
@endif

<div class="card">
    <div class="card-header">
        <div class="card-title">
            🗑️ Thùng Rác
            <span style="font-size:12px; background:rgba(239,68,68,0.15); color:var(--danger); padding:2px 10px; border-radius:20px;">
                {{ $products->total() }} sản phẩm
            </span>
        </div>
        <a href="{{ route('products.index') }}" class="btn btn-outline">
            <i class="fas fa-arrow-left"></i> Quay lại danh sách
        </a>
    </div>

    <div style="overflow-x: auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width:40px;">#</th>
                    <th style="width:50px;">Ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Danh mục</th>
                    <th>Giá bán</th>
                    <th>Ngày xoá</th>
                    <th style="width:200px;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                <tr style="opacity:0.8;">
                    <td style="color:var(--text-muted);">{{ ($products->currentPage() - 1) * $products->perPage() + $loop->iteration }}</td>
                    <td>
                        @if ($product->image)
                            <img src="{{ \Illuminate\Support\Str::startsWith($product->image, 'http') ? $product->image : asset($product->image) }}"
                                 alt="{{ $product->name }}" class="product-img" style="opacity:0.6;">
                        @else
                            <div class="product-img-placeholder"><i class="fas fa-image"></i></div>
                        @endif
                    </td>
                    <td>
                        <strong style="text-decoration:line-through; color:var(--text-muted);">{{ $product->name }}</strong>
                    </td>
                    <td>
                        <span style="font-size:12px; color:var(--text-muted);">
                            {{ $product->category->name ?? '—' }}
                        </span>
                    </td>
                    <td style="color:var(--text-muted);">
                        {{ number_format($product->price, 0, ',', '.') }}₫
                    </td>
                    <td style="font-size:12px; color:var(--danger);">
                        <i class="fas fa-trash" style="font-size:10px;"></i>
                        {{ $product->deleted_at->format('d/m/Y H:i') }}
                    </td>
                    <td style="white-space:nowrap;">
                        <div style="display:flex; gap:6px;">
                            <form action="{{ route('products.restore', $product->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-info-sm" style="cursor:pointer; background:rgba(16,185,129,0.12); color:var(--success); border-color:rgba(16,185,129,0.3);">
                                    <i class="fas fa-undo"></i> Khôi phục
                                </button>
                            </form>
                            <form action="{{ route('products.forceDelete', $product->id) }}" method="POST"
                                  style="display:inline;" onsubmit="return confirm('⚠️ XOÁ VĨNH VIỄN sản phẩm này? Hành động này KHÔNG THỂ hoàn tác!')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger-sm" style="cursor:pointer;">
                                    <i class="fas fa-skull-crossbones"></i> Xoá vĩnh viễn
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center; padding:40px; color:var(--text-muted);">
                        <div style="font-size:40px; margin-bottom:12px;">🎉</div>
                        Thùng rác trống! Không có sản phẩm nào bị xoá.
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
