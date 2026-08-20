@extends('layouts.admin')

@section('title', $product->name)

@section('breadcrumb')
    <a href="{{ route('products.index') }}" style="color:var(--accent-light); text-decoration:none;">Sản phẩm</a>
    / <span>{{ $product->name }}</span>
@endsection

@section('content')
<div style="max-width:1200px; margin:0 auto;">

    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:24px;">
        <h1 style="font-size:22px; font-weight:700; color:var(--text-primary);">👠 Chi tiết Sản phẩm</h1>
        <div style="display:flex; gap:10px;">
            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary"><i class="fas fa-pen"></i> Sửa</a>
            <a href="{{ route('products.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Quay lại</a>
        </div>
    </div>

    <div class="grid-2" style="gap:24px; align-items:start;">
        {{-- LEFT: Image Gallery + Basic Info --}}
        <div>
            {{-- GALLERY --}}
            <div class="card" style="margin-bottom:20px;">
                <div class="card-body" style="padding:0; overflow:hidden;">
                    @if ($product->image)
                        <img id="mainImage"
                             src="{{ \Illuminate\Support\Str::startsWith($product->image, 'http') ? $product->image : asset($product->image) }}"
                             alt="{{ $product->name }}"
                             style="width:100%; max-height:420px; object-fit:cover; border-radius:16px; display:block; cursor:pointer;">
                    @else
                        <div style="width:100%; height:300px; display:flex; flex-direction:column; align-items:center; justify-content:center; color:var(--text-muted);">
                            <div style="font-size:80px; margin-bottom:16px;">👠</div>
                            <p>Chưa có hình ảnh</p>
                        </div>
                    @endif
                </div>
                {{-- Thumbnail gallery --}}
                @if ($product->images->count() > 0)
                <div style="padding:12px; display:flex; gap:8px; overflow-x:auto; border-top:1px solid var(--border);">
                    @if ($product->image)
                    <div onclick="document.getElementById('mainImage').src='{{ \Illuminate\Support\Str::startsWith($product->image, 'http') ? $product->image : asset($product->image) }}'"
                         style="width:60px; height:60px; border-radius:8px; overflow:hidden; border:2px solid var(--accent); cursor:pointer; flex-shrink:0;">
                        <img src="{{ \Illuminate\Support\Str::startsWith($product->image, 'http') ? $product->image : asset($product->image) }}"
                             style="width:100%; height:100%; object-fit:cover;">
                    </div>
                    @endif
                    @foreach ($product->images as $img)
                    <div onclick="document.getElementById('mainImage').src='{{ asset($img->image_path) }}'"
                         style="width:60px; height:60px; border-radius:8px; overflow:hidden; border:1px solid var(--border); cursor:pointer; flex-shrink:0; transition:border-color 0.2s;"
                         onmouseover="this.style.borderColor='var(--accent)'" onmouseout="this.style.borderColor='var(--border)'">
                        <img src="{{ asset($img->image_path) }}" style="width:100%; height:100%; object-fit:cover;">
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            {{-- BASIC INFO --}}
            <div class="card">
                <div class="card-header">
                    <div class="card-title"><i class="fas fa-info-circle" style="color:var(--accent);"></i> Thông tin cơ bản</div>
                </div>
                <div class="card-body">
                    <div style="margin-bottom:16px;">
                        <h2 style="font-size:20px; font-weight:700; color:var(--text-primary); margin-bottom:8px;">{{ $product->name }}</h2>
                        <div style="display:flex; align-items:center; gap:12px; flex-wrap:wrap;">
                            <div class="price-tag">{{ number_format($product->price, 0, ',', '.') }}₫</div>
                            @if ($product->discount_percent)
                                <span style="font-size:15px; color:var(--text-muted); text-decoration:line-through;">
                                    {{ number_format($product->original_price, 0, ',', '.') }}₫
                                </span>
                                <span style="background:rgba(239,68,68,0.15); color:#f87171; padding:4px 12px; border-radius:12px; font-size:13px; font-weight:700;">
                                    -{{ $product->discount_percent }}% GIẢM
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-label"><i class="fas fa-tag" style="color:var(--accent); margin-right:6px;"></i>Danh mục</div>
                        <div class="detail-value">
                            <span style="background:rgba(56,189,248,0.1); color:var(--accent-light); padding:3px 10px; border-radius:6px; font-size:13px;">{{ $product->category->name ?? '—' }}</span>
                        </div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-label"><i class="fas fa-star" style="color:var(--accent); margin-right:6px;"></i>Phân loại</div>
                        <div class="detail-value">
                            @php
                                $bs = ['Hàng mới'=>['bg'=>'rgba(168,85,247,0.15)','color'=>'#c084fc','icon'=>'✨'],'Bán chạy'=>['bg'=>'rgba(239,68,68,0.15)','color'=>'#f87171','icon'=>'🔥'],'Nổi bật'=>['bg'=>'rgba(245,158,11,0.15)','color'=>'#fbbf24','icon'=>'⭐️'],'Cao cấp'=>['bg'=>'rgba(234,179,8,0.15)','color'=>'#fde047','icon'=>'👑'],'Khuyến mãi'=>['bg'=>'rgba(16,185,129,0.15)','color'=>'#34d399','icon'=>'🏷️']];
                                $s = $bs[$product->classification] ?? null;
                            @endphp
                            @if ($product->classification && $s)
                                <span style="background:{{ $s['bg'] }}; color:{{ $s['color'] }}; padding:4px 12px; border-radius:12px; font-size:13px; font-weight:600;">{{ $s['icon'] }} {{ $product->classification }}</span>
                            @else <span style="color:var(--text-muted);">—</span>
                            @endif
                        </div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-label"><i class="fas fa-boxes" style="color:var(--accent); margin-right:6px;"></i>Tổng tồn kho</div>
                        <div class="detail-value" style="color:{{ $product->stock > 0 ? 'var(--success)' : 'var(--danger)' }}; font-weight:700;">
                            {{ $product->stock }} đôi @if ($product->stock == 0) <span style="font-size:12px;">(Hết hàng)</span> @endif
                        </div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-label"><i class="fas fa-globe" style="color:var(--accent); margin-right:6px;"></i>Xuất xứ</div>
                        <div class="detail-value">
                            @if ($product->origin) <span style="background:rgba(255,255,255,0.06); border:1px solid var(--border); padding:3px 10px; border-radius:6px;">🌐 {{ $product->origin }}</span>
                            @else <span style="color:var(--text-muted);">—</span> @endif
                        </div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-label"><i class="fas fa-ticket-alt" style="color:var(--accent); margin-right:6px;"></i>Mã giảm giá</div>
                        <div class="detail-value">
                            @if ($product->discount_code)
                                <span style="background:rgba(245,158,11,0.15); color:var(--warning); border:1px dashed rgba(245,158,11,0.4); padding:3px 10px; border-radius:6px; font-weight:700; font-family:monospace;">🏷️ {{ $product->discount_code }}</span>
                            @else <span style="color:var(--text-muted);">—</span> @endif
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
                        <div class="detail-value" style="line-height:1.7; color:var(--text-secondary);">{{ $product->description }}</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- RIGHT: Specs + Variant Matrix --}}
        <div>
            {{-- THÔNG SỐ KỸ THUẬT --}}
            @if ($product->heel_height || $product->material || $product->weight)
            <div class="card" style="margin-bottom:20px;">
                <div class="card-header">
                    <div class="card-title"><i class="fas fa-cogs" style="color:var(--accent);"></i> Thông số kỹ thuật</div>
                </div>
                <div class="card-body">
                    <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:12px;">
                        <div style="text-align:center; padding:16px; background:rgba(56,189,248,0.06); border-radius:12px; border:1px solid rgba(56,189,248,0.15);">
                            <div style="font-size:28px; margin-bottom:8px;">📐</div>
                            <div style="font-size:20px; font-weight:700; color:var(--accent-light);">{{ $product->heel_height ?? '—' }}cm</div>
                            <div style="font-size:11px; color:var(--text-muted); margin-top:4px;">Chiều cao gót</div>
                        </div>
                        <div style="text-align:center; padding:16px; background:rgba(168,85,247,0.06); border-radius:12px; border:1px solid rgba(168,85,247,0.15);">
                            <div style="font-size:28px; margin-bottom:8px;">🧵</div>
                            <div style="font-size:14px; font-weight:700; color:#c084fc;">{{ $product->material ?? '—' }}</div>
                            <div style="font-size:11px; color:var(--text-muted); margin-top:4px;">Chất liệu</div>
                        </div>
                        <div style="text-align:center; padding:16px; background:rgba(245,158,11,0.06); border-radius:12px; border:1px solid rgba(245,158,11,0.15);">
                            <div style="font-size:28px; margin-bottom:8px;">⚖️</div>
                            <div style="font-size:20px; font-weight:700; color:var(--warning);">{{ $product->weight ?? '—' }}g</div>
                            <div style="font-size:11px; color:var(--text-muted); margin-top:4px;">Cân nặng</div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            {{-- VARIANT MATRIX --}}
            @php
                $matrix = $product->variants_matrix;
                $colors = $product->colors_array;
                $sizes  = $product->sizes_array;
                $colorHexes = ['Đen'=>'#1a1a1a','Trắng'=>'#e8e8e8','Nude'=>'#c4a882','Đỏ'=>'#c0392b','Hồng'=>'#e91e8c','Nâu'=>'#7a4f37','Bạc'=>'#b0b0b0','Vàng'=>'#d4a843'];
            @endphp

            <div class="card" style="margin-bottom:20px;">
                <div class="card-header">
                    <div class="card-title"><i class="fas fa-table" style="color:var(--accent);"></i> Ma Trận Tồn Kho (Màu × Size)</div>
                </div>
                <div class="card-body" style="padding:16px; overflow-x:auto;">
                    @if (!empty($matrix) && count($colors) > 0 && count($sizes) > 0)
                        <table class="admin-table" style="font-size:12px;">
                            <thead>
                                <tr>
                                    <th>Màu sắc</th>
                                    @foreach ($sizes as $sz) <th style="text-align:center;">Size {{ $sz }}</th> @endforeach
                                    <th style="text-align:center; color:var(--accent-light);">Tổng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $colSums = array_fill_keys($sizes, 0); @endphp
                                @foreach ($colors as $cl)
                                    @php $rowSum = 0; @endphp
                                    <tr>
                                        <td>
                                            <div style="display:flex; align-items:center; gap:8px;">
                                                <div style="width:20px; height:20px; border-radius:50%; background:{{ $colorHexes[$cl] ?? '#888' }}; border:1px solid var(--border);"></div>
                                                <strong>{{ $cl }}</strong>
                                            </div>
                                        </td>
                                        @foreach ($sizes as $sz)
                                            @php $q = $matrix[$cl][$sz] ?? 0; $rowSum += $q; $colSums[$sz] += $q; @endphp
                                            <td style="text-align:center;">
                                                @if ($q > 0)
                                                    <span style="background:rgba(56,189,248,0.15); color:var(--accent-light); padding:2px 8px; border-radius:10px; font-weight:700;">{{ $q }}</span>
                                                @else <span style="color:var(--text-muted); opacity:0.5;">0</span> @endif
                                            </td>
                                        @endforeach
                                        <td style="text-align:center; font-weight:700; color:var(--accent-light);">{{ $rowSum }} đôi</td>
                                    </tr>
                                @endforeach
                                <tr style="background:rgba(56,189,248,0.08); font-weight:700;">
                                    <td style="color:var(--accent-light);">Tổng Size</td>
                                    @foreach ($sizes as $sz)
                                        <td style="text-align:center; color:var(--accent-light);">{{ $colSums[$sz] }}</td>
                                    @endforeach
                                    <td style="text-align:center; color:var(--success); font-size:13px;">{{ $product->stock }} đôi</td>
                                </tr>
                            </tbody>
                        </table>
                    @else
                        <div style="text-align:center; padding:30px; color:var(--text-muted);">Chưa có dữ liệu ma trận biến thể.</div>
                    @endif
                </div>
            </div>

            {{-- ACTION BUTTONS --}}
            <div style="display:flex; gap:10px;">
                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary" style="flex:1; justify-content:center; padding:12px;"><i class="fas fa-pen"></i> Chỉnh sửa</a>
                <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Chuyển vào thùng rác?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger-sm" style="padding:12px 20px; font-size:13px; cursor:pointer;"><i class="fas fa-trash"></i> Xoá</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
