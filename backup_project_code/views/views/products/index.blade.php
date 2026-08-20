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

{{-- THỐNG KÊ TÓM TẮT --}}
<div style="display:grid; grid-template-columns:repeat(4, 1fr); gap:16px; margin-bottom:20px;">
    <div class="card" style="border-left:3px solid var(--accent);">
        <div class="card-body" style="padding:16px; display:flex; align-items:center; gap:14px;">
            <div style="width:44px; height:44px; border-radius:12px; background:rgba(56,189,248,0.12); display:flex; align-items:center; justify-content:center; font-size:20px;">👠</div>
            <div>
                <div style="font-size:22px; font-weight:700; color:var(--accent-light);">{{ $stats['total'] }}</div>
                <div style="font-size:11px; color:var(--text-muted); text-transform:uppercase; letter-spacing:1px;">Tổng SP</div>
            </div>
        </div>
    </div>
    <div class="card" style="border-left:3px solid var(--success);">
        <div class="card-body" style="padding:16px; display:flex; align-items:center; gap:14px;">
            <div style="width:44px; height:44px; border-radius:12px; background:rgba(16,185,129,0.12); display:flex; align-items:center; justify-content:center; font-size:20px;">✅</div>
            <div>
                <div style="font-size:22px; font-weight:700; color:var(--success);">{{ $stats['active'] }}</div>
                <div style="font-size:11px; color:var(--text-muted); text-transform:uppercase; letter-spacing:1px;">Đang bán</div>
            </div>
        </div>
    </div>
    <div class="card" style="border-left:3px solid var(--danger);">
        <div class="card-body" style="padding:16px; display:flex; align-items:center; gap:14px;">
            <div style="width:44px; height:44px; border-radius:12px; background:rgba(239,68,68,0.12); display:flex; align-items:center; justify-content:center; font-size:20px;">📦</div>
            <div>
                <div style="font-size:22px; font-weight:700; color:var(--danger);">{{ $stats['out_of_stock'] }}</div>
                <div style="font-size:11px; color:var(--text-muted); text-transform:uppercase; letter-spacing:1px;">Hết hàng</div>
            </div>
        </div>
    </div>
    <div class="card" style="border-left:3px solid var(--warning);">
        <div class="card-body" style="padding:16px; display:flex; align-items:center; gap:14px;">
            <div style="width:44px; height:44px; border-radius:12px; background:rgba(245,158,11,0.12); display:flex; align-items:center; justify-content:center; font-size:20px;">💰</div>
            <div>
                <div style="font-size:22px; font-weight:700; color:var(--warning);">{{ number_format($stats['avg_price'], 0, ',', '.') }}₫</div>
                <div style="font-size:11px; color:var(--text-muted); text-transform:uppercase; letter-spacing:1px;">Giá TB</div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header" style="flex-direction:column; align-items:stretch; gap:16px;">
        <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px;">
            <div class="card-title">
                👠 Danh sách Sản phẩm
                <span style="font-size:12px; background:rgba(56,189,248,0.15); color:var(--accent-light); padding:2px 10px; border-radius:20px;">
                    {{ $products->total() }} sản phẩm
                </span>
            </div>
            <div style="display:flex; gap:8px;">
                <a href="{{ route('products.export') }}" class="btn btn-outline" style="color:var(--success); border-color:rgba(16,185,129,0.3);">
                    <i class="fas fa-file-csv"></i> Xuất Excel
                </a>
                <a href="{{ route('products.trash') }}" class="btn btn-outline" style="color:var(--danger); border-color:rgba(239,68,68,0.3);">
                    <i class="fas fa-trash-alt"></i> Thùng rác
                </a>
                <a href="{{ route('products.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Thêm sản phẩm
                </a>
            </div>
        </div>

        {{-- BỘ LỌC NÂNG CAO --}}
        <form action="{{ route('products.index') }}" method="GET" style="background:rgba(0,0,0,0.2); padding:14px 16px; border-radius:12px; border:1px solid var(--border);">
            {{-- Hàng 1: Tìm kiếm + Danh mục + Phân loại --}}
            <div style="display:flex; gap:10px; flex-wrap:wrap; align-items:center; margin-bottom:10px;">
                <div style="flex:1; min-width:200px;">
                    <input type="text" name="search" class="form-control"
                           placeholder="🔍 Tìm theo tên sản phẩm..."
                           value="{{ request('search') }}" style="padding:8px 14px; font-size:13px;">
                </div>
                <div style="min-width:160px;">
                    <select name="category_id" class="form-control" style="padding:8px 14px; font-size:13px;">
                        <option value="">-- Tất cả danh mục --</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                🏷️ {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div style="min-width:150px;">
                    <select name="classification" class="form-control" style="padding:8px 14px; font-size:13px;">
                        <option value="">-- Phân loại --</option>
                        @foreach (['Hàng mới' => '✨ Hàng Mới', 'Bán chạy' => '🔥 Bán Chạy', 'Nổi bật' => '⭐️ Nổi Bật', 'Cao cấp' => '👑 Cao Cấp', 'Khuyến mãi' => '🏷️ Khuyến Mãi'] as $val => $lbl)
                            <option value="{{ $val }}" {{ request('classification') == $val ? 'selected' : '' }}>{{ $lbl }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Hàng 2: Khoảng giá + Xuất xứ + Trạng thái + Tồn kho + Sắp xếp --}}
            <div style="display:flex; gap:10px; flex-wrap:wrap; align-items:center;">
                <div style="display:flex; align-items:center; gap:4px; min-width:200px;">
                    <input type="number" name="price_from" class="form-control" placeholder="Giá từ..."
                           value="{{ request('price_from') }}" style="padding:8px 10px; font-size:12px; width:95px;">
                    <span style="color:var(--text-muted); font-size:12px;">→</span>
                    <input type="number" name="price_to" class="form-control" placeholder="Đến..."
                           value="{{ request('price_to') }}" style="padding:8px 10px; font-size:12px; width:95px;">
                </div>
                <div style="min-width:140px;">
                    <select name="origin" class="form-control" style="padding:8px 14px; font-size:12px;">
                        <option value="">-- Xuất xứ --</option>
                        @foreach (['Việt Nam','Hàn Quốc','Nhật Bản','Ý (Italy)','Pháp (France)','Quảng Châu (Trung Quốc)','Mỹ (USA)','Anh (UK)','Đức (Germany)','Thái Lan'] as $c)
                            <option value="{{ $c }}" {{ request('origin') == $c ? 'selected' : '' }}>🌐 {{ $c }}</option>
                        @endforeach
                    </select>
                </div>
                <div style="min-width:120px;">
                    <select name="status" class="form-control" style="padding:8px 14px; font-size:12px;">
                        <option value="">-- Trạng thái --</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>✅ Đang bán</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>❌ Ngừng bán</option>
                    </select>
                </div>
                <div style="min-width:120px;">
                    <select name="stock_status" class="form-control" style="padding:8px 14px; font-size:12px;">
                        <option value="">-- Tồn kho --</option>
                        <option value="in_stock" {{ request('stock_status') == 'in_stock' ? 'selected' : '' }}>📦 Còn hàng</option>
                        <option value="out_of_stock" {{ request('stock_status') == 'out_of_stock' ? 'selected' : '' }}>🚫 Hết hàng</option>
                    </select>
                </div>
                <div style="min-width:140px;">
                    <select name="sort" class="form-control" style="padding:8px 14px; font-size:12px;">
                        <option value="">-- Sắp xếp --</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>💲 Giá tăng dần</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>💲 Giá giảm dần</option>
                        <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>🔤 Tên A→Z</option>
                        <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>🔤 Tên Z→A</option>
                        <option value="stock_desc" {{ request('sort') == 'stock_desc' ? 'selected' : '' }}>📦 Tồn kho giảm</option>
                        <option value="stock_asc" {{ request('sort') == 'stock_asc' ? 'selected' : '' }}>📦 Tồn kho tăng</option>
                    </select>
                </div>
                <div style="display:flex; gap:6px;">
                    <button type="submit" class="btn btn-primary" style="padding:8px 16px; font-size:12px;">
                        <i class="fas fa-filter"></i> Lọc
                    </button>
                    @if (request()->hasAny(['search','category_id','classification','origin','status','stock_status','price_from','price_to','sort']))
                        <a href="{{ route('products.index') }}" class="btn btn-outline" style="padding:8px 14px; font-size:12px; color:var(--danger); border-color:rgba(239,68,68,0.3);">
                            <i class="fas fa-times"></i> Xoá lọc
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    <div style="overflow-x: auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width:40px;">#</th>
                    <th style="width:50px;">Ảnh</th>
                    <th style="min-width:160px;">Tên sản phẩm</th>
                    <th style="white-space:nowrap;">Danh mục</th>
                    <th style="white-space:nowrap;">Phân loại</th>
                    <th style="white-space:nowrap;">Giá bán</th>
                    <th style="white-space:nowrap;">Tồn kho</th>
                    <th style="white-space:nowrap;">Gót</th>
                    <th style="white-space:nowrap;">Chất liệu</th>
                    <th style="white-space:nowrap;">Xuất xứ</th>
                    <th style="white-space:nowrap;">Trạng thái</th>
                    <th style="width:160px; white-space:nowrap;">Thao tác</th>
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
                            <div class="product-img-placeholder"><i class="fas fa-image"></i></div>
                        @endif
                    </td>
                    <td><strong>{{ $product->name }}</strong></td>
                    <td style="white-space:nowrap;">
                        <span style="background:rgba(56,189,248,0.1); color:var(--accent-light); padding:3px 8px; border-radius:6px; font-size:12px;">
                            {{ $product->category->name ?? '—' }}
                        </span>
                    </td>
                    <td style="white-space:nowrap;">
                        @php
                            $badgeStyles = [
                                'Hàng mới'   => ['bg' => 'rgba(168,85,247,0.15)', 'color' => '#c084fc', 'icon' => '✨'],
                                'Bán chạy'   => ['bg' => 'rgba(239,68,68,0.15)',  'color' => '#f87171', 'icon' => '🔥'],
                                'Nổi bật'    => ['bg' => 'rgba(245,158,11,0.15)', 'color' => '#fbbf24', 'icon' => '⭐️'],
                                'Cao cấp'    => ['bg' => 'rgba(234,179,8,0.15)',  'color' => '#fde047', 'icon' => '👑'],
                                'Khuyến mãi' => ['bg' => 'rgba(16,185,129,0.15)', 'color' => '#34d399', 'icon' => '🏷️'],
                            ];
                            $style = $badgeStyles[$product->classification] ?? null;
                        @endphp
                        @if ($product->classification && $style)
                            <span style="background:{{ $style['bg'] }}; color:{{ $style['color'] }}; padding:4px 10px; border-radius:12px; font-size:12px; font-weight:600;">
                                {{ $style['icon'] }} {{ $product->classification }}
                            </span>
                        @else
                            <span style="color:var(--text-muted);">—</span>
                        @endif
                    </td>
                    <td style="white-space:nowrap;">
                        <div>
                            <span style="color:var(--accent-light); font-weight:700; font-size:13px;">
                                {{ number_format($product->price, 0, ',', '.') }}₫
                            </span>
                            @if ($product->discount_percent)
                                <span style="display:block; font-size:11px; color:var(--text-muted); text-decoration:line-through;">
                                    {{ number_format($product->original_price, 0, ',', '.') }}₫
                                </span>
                                <span style="background:rgba(239,68,68,0.15); color:#f87171; padding:1px 6px; border-radius:8px; font-size:10px; font-weight:700;">
                                    -{{ $product->discount_percent }}%
                                </span>
                            @endif
                        </div>
                    </td>
                    <td style="white-space:nowrap;">
                        <span style="color:{{ $product->stock > 0 ? 'var(--success)' : 'var(--danger)' }}; font-weight:600;">
                            {{ $product->stock }}
                        </span>
                    </td>
                    <td style="white-space:nowrap; font-size:12px; color:var(--text-secondary);">
                        @if ($product->heel_height)
                            📐 {{ $product->heel_height }}cm
                        @else —
                        @endif
                    </td>
                    <td style="white-space:nowrap; font-size:12px; color:var(--text-secondary);">
                        {{ $product->material ?? '—' }}
                    </td>
                    <td style="font-size:12px; white-space:nowrap;">
                        @if ($product->origin)
                            <span style="background:rgba(255,255,255,0.06); border:1px solid var(--border); padding:3px 8px; border-radius:6px; color:var(--text-secondary);">
                                🌐 {{ $product->origin }}
                            </span>
                        @else
                            <span style="color:var(--text-muted);">—</span>
                        @endif
                    </td>
                    <td style="white-space:nowrap;">
                        @if ($product->status === 'active')
                            <span class="badge badge-success"><i class="fas fa-circle" style="font-size:6px;"></i> Đang bán</span>
                        @else
                            <span class="badge badge-danger"><i class="fas fa-circle" style="font-size:6px;"></i> Ngừng bán</span>
                        @endif
                    </td>
                    <td style="white-space:nowrap;">
                        <div style="display:flex; gap:6px;">
                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-info-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warn-sm">
                                <i class="fas fa-pen"></i>
                            </a>
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                  style="display:inline;" onsubmit="return confirm('Chuyển sản phẩm này vào thùng rác?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger-sm" style="cursor:pointer;">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="12" style="text-align:center; padding:40px; color:var(--text-muted);">
                        <div style="font-size:40px; margin-bottom:12px;">👠</div>
                        Không tìm thấy sản phẩm nào.
                        @if (request()->hasAny(['search','category_id','classification','origin','status','stock_status','price_from','price_to','sort']))
                            <a href="{{ route('products.index') }}" style="color:var(--accent-light);">Bỏ bộ lọc</a>
                        @endif
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
