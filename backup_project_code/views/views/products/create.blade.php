@extends('layouts.admin')

@section('title', 'Thêm sản phẩm mới')

@section('breadcrumb')
    <a href="{{ route('products.index') }}" style="color:var(--accent-light); text-decoration:none;">Sản phẩm</a>
    / <span>Thêm mới</span>
@endsection

@section('content')
<div style="max-width:1200px; margin:0 auto;">

    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:24px;">
        <h1 style="font-size:22px; font-weight:700; color:var(--text-primary);">👠 Thêm Sản Phẩm Mới</h1>
        <a href="{{ route('products.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Quay lại</a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <div>
                <i class="fas fa-exclamation-triangle"></i>
                <strong>Vui lòng kiểm tra lại:</strong>
                <ul style="margin:8px 0 0 16px;">
                    @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                </ul>
            </div>
        </div>
    @endif

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="grid-2" style="gap:24px; align-items:start;">
            {{-- LEFT COLUMN --}}
            <div>
                {{-- BASIC INFO --}}
                <div class="card" style="margin-bottom:20px;">
                    <div class="card-header">
                        <div class="card-title"><i class="fas fa-info-circle" style="color:var(--accent);"></i> Thông tin cơ bản</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="form-label">Tên sản phẩm <span>*</span></label>
                            <input type="text" name="name" class="form-control" placeholder="VD: Giày Cao Gót Mũi Nhọn Thanh Lịch" value="{{ old('name') }}" required>
                        </div>
                        <div class="grid-2" style="gap:12px;">
                            <div class="form-group">
                                <label class="form-label">Danh mục <span>*</span></label>
                                <select name="category_id" class="form-control" required>
                                    <option value="">-- Chọn danh mục --</option>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Phân loại nhãn</label>
                                <select name="classification" class="form-control">
                                    <option value="">-- Chọn --</option>
                                    @foreach (['Hàng mới'=>'✨ Hàng Mới','Bán chạy'=>'🔥 Bán Chạy','Nổi bật'=>'⭐️ Nổi Bật','Cao cấp'=>'👑 Cao Cấp','Khuyến mãi'=>'🏷️ Khuyến Mãi'] as $v => $l)
                                        <option value="{{ $v }}" {{ old('classification') == $v ? 'selected' : '' }}>{{ $l }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Mô tả sản phẩm</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Mô tả chi tiết...">{{ old('description') }}</textarea>
                        </div>
                        <div class="grid-2" style="gap:12px;">
                            <div class="form-group" style="margin-bottom:0;">
                                <label class="form-label">Giá gốc (₫)</label>
                                <div class="input-group">
                                    <input type="number" name="original_price" class="form-control" placeholder="1.200.000" value="{{ old('original_price') }}" min="0">
                                    <div class="input-addon">₫</div>
                                </div>
                            </div>
                            <div class="form-group" style="margin-bottom:0;">
                                <label class="form-label">Giá bán (₫) <span>*</span></label>
                                <div class="input-group">
                                    <input type="number" name="price" class="form-control" placeholder="850.000" value="{{ old('price') }}" min="0" required>
                                    <div class="input-addon">₫</div>
                                </div>
                            </div>
                        </div>
                        <div style="margin-top:8px;">
                            <label class="form-label">Tổng tồn kho (tự tính từ ma trận)</label>
                            <input type="number" name="stock" id="totalStockInput" class="form-control" value="{{ old('stock', 0) }}" min="0" readonly style="background:rgba(255,255,255,0.05); color:var(--accent-light); font-weight:700;">
                        </div>
                    </div>
                </div>

                {{-- THÔNG SỐ KỸ THUẬT --}}
                <div class="card" style="margin-bottom:20px;">
                    <div class="card-header">
                        <div class="card-title"><i class="fas fa-cogs" style="color:var(--accent);"></i> Thông số kỹ thuật</div>
                    </div>
                    <div class="card-body">
                        <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:12px;">
                            <div class="form-group" style="margin-bottom:0;">
                                <label class="form-label">📐 Cao gót (cm)</label>
                                <input type="number" name="heel_height" class="form-control" placeholder="9" value="{{ old('heel_height') }}" min="0" max="20">
                            </div>
                            <div class="form-group" style="margin-bottom:0;">
                                <label class="form-label">🧵 Chất liệu</label>
                                <select name="material" class="form-control">
                                    <option value="">-- Chọn --</option>
                                    @foreach (['Da thật','Da PU','Da PU cao cấp','Da bóng','Da mịn','Nhung','Vải canvas','Vải canvas + Cói','PVC trong suốt','Vải canvas + Cói thêu'] as $m)
                                        <option value="{{ $m }}" {{ old('material') == $m ? 'selected' : '' }}>{{ $m }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group" style="margin-bottom:0;">
                                <label class="form-label">⚖️ Cân nặng (gram)</label>
                                <input type="number" name="weight" class="form-control" placeholder="350" value="{{ old('weight') }}" min="0">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ORIGIN & DISCOUNT --}}
                <div class="card" style="margin-bottom:20px;">
                    <div class="card-header">
                        <div class="card-title"><i class="fas fa-globe" style="color:var(--accent);"></i> Xuất xứ & Mã giảm giá</div>
                    </div>
                    <div class="card-body">
                        <div class="grid-2" style="gap:12px;">
                            <div class="form-group" style="margin-bottom:0;">
                                <label class="form-label">Xuất xứ</label>
                                <select name="origin" class="form-control">
                                    <option value="">-- Chọn --</option>
                                    @foreach (['Việt Nam','Hàn Quốc','Nhật Bản','Ý (Italy)','Pháp (France)','Quảng Châu (Trung Quốc)','Mỹ (USA)','Anh (UK)','Đức (Germany)','Thái Lan'] as $c)
                                        <option value="{{ $c }}" {{ old('origin') == $c ? 'selected' : '' }}>🌐 {{ $c }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group" style="margin-bottom:0;">
                                <label class="form-label">Mã giảm giá</label>
                                <input type="text" name="discount_code" class="form-control" placeholder="VD: HEEL10..." value="{{ old('discount_code') }}" style="text-transform:uppercase;">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- IMAGE & STATUS --}}
                <div class="card">
                    <div class="card-header">
                        <div class="card-title"><i class="fas fa-image" style="color:var(--accent);"></i> Hình ảnh & Trạng thái</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="form-label">Ảnh đại diện</label>
                            <div class="upload-zone" onclick="document.getElementById('imageInput').click()" style="margin-bottom:12px;">
                                <div class="upload-icon">📸</div>
                                <p><strong>Click để chọn ảnh chính</strong></p>
                                <p style="margin-top:4px; font-size:11px; color:var(--text-muted);">JPG, PNG, WEBP – Tối đa 2MB</p>
                            </div>
                            <input type="file" id="imageInput" name="image" accept="image/*" onchange="previewImage(this)">
                            <div class="image-preview" id="imagePreview"><img id="previewImg" src="" alt="Preview"></div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">🖼️ Gallery (nhiều ảnh)</label>
                            <input type="file" name="gallery[]" multiple accept="image/*"
                                   class="form-control" style="padding:8px;">
                            <p style="font-size:11px; color:var(--text-muted); margin-top:4px;">Chọn tối đa 8 ảnh phụ cho sản phẩm</p>
                        </div>

                        <input type="hidden" name="status" id="statusValue" value="active">
                        <div class="toggle-group">
                            <input type="checkbox" id="statusToggle" checked
                                   onchange="document.getElementById('statusValue').value=this.checked?'active':'inactive'; document.getElementById('statusLabel').textContent=this.checked?'✅ Đang bán':'❌ Ngừng bán'">
                            <label class="toggle-switch" for="statusToggle"></label>
                            <span id="statusLabel" style="font-size:14px; color:var(--text-primary); font-weight:500;">✅ Đang bán</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- RIGHT COLUMN: Size + Color + Matrix --}}
            <div>
                <div class="card" style="margin-bottom:20px;">
                    <div class="card-header">
                        <div class="card-title"><i class="fas fa-ruler" style="color:var(--accent);"></i> 1. Chọn Size
                            <span id="sizeCountBadge" style="font-size:12px; background:rgba(56,189,248,0.15); color:var(--accent-light); padding:2px 8px; border-radius:10px; margin-left:6px;">0 size</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="size-chips">
                            @foreach (['35','36','37','38','39','40','41'] as $sz)
                            <label>
                                <input type="checkbox" name="sizes[]" value="{{ $sz }}" class="size-checkbox"
                                       {{ in_array($sz, old('sizes', ['35','36','37','38','39'])) ? 'checked' : '' }} onchange="renderMatrix()">
                                <div class="size-chip">{{ $sz }}</div>
                            </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="card" style="margin-bottom:20px;">
                    <div class="card-header">
                        <div class="card-title"><i class="fas fa-palette" style="color:var(--accent);"></i> 2. Chọn Màu
                            <span id="colorCountBadge" style="font-size:12px; background:rgba(255,255,255,0.1); color:var(--text-secondary); padding:2px 8px; border-radius:10px; margin-left:6px;">0 màu</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="color-swatches">
                            @php $colorList = ['Đen'=>'#1a1a1a','Trắng'=>'#e8e8e8','Nude'=>'#c4a882','Đỏ'=>'#c0392b','Hồng'=>'#e91e8c','Nâu'=>'#7a4f37','Bạc'=>'#b0b0b0','Vàng'=>'#d4a843']; @endphp
                            @foreach ($colorList as $cn => $ch)
                            <div>
                                <input type="checkbox" name="colors[]" value="{{ $cn }}" class="color-checkbox" id="color_{{ $cn }}"
                                       {{ in_array($cn, old('colors', ['Đen','Nude'])) ? 'checked' : '' }} onchange="renderMatrix()">
                                <label for="color_{{ $cn }}" class="color-swatch-label">
                                    <div class="color-dot" style="background:{{ $ch }};"></div>
                                    <span>{{ $cn }}</span>
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="card-title"><i class="fas fa-table" style="color:var(--accent);"></i> 3. Ma trận Tồn kho (Màu × Size)</div>
                    </div>
                    <div class="card-body" style="padding:16px; overflow-x:auto;">
                        <div id="matrixContainer"></div>
                    </div>
                </div>
            </div>
        </div>

        <div style="display:flex; gap:12px; margin-top:24px;">
            <button type="submit" class="btn btn-primary" style="padding:12px 32px; font-size:15px;"><i class="fas fa-save"></i> Lưu sản phẩm</button>
            <a href="{{ route('products.index') }}" class="btn btn-outline" style="padding:12px 24px;">Huỷ</a>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
const colorHexMap = {'Đen':'#1a1a1a','Trắng':'#e8e8e8','Nude':'#c4a882','Đỏ':'#c0392b','Hồng':'#e91e8c','Nâu':'#7a4f37','Bạc':'#b0b0b0','Vàng':'#d4a843'};

function renderMatrix() {
    const sizes = Array.from(document.querySelectorAll('.size-checkbox:checked')).map(cb => cb.value);
    const colors = Array.from(document.querySelectorAll('.color-checkbox:checked')).map(cb => cb.value);
    document.getElementById('sizeCountBadge').textContent = `${sizes.length} size đã chọn`;
    document.getElementById('colorCountBadge').textContent = `${colors.length} màu đã chọn`;
    const c = document.getElementById('matrixContainer');
    if (!sizes.length || !colors.length) {
        c.innerHTML = '<div style="text-align:center;padding:30px;color:var(--text-muted);">Tích chọn ít nhất 1 Size và 1 Màu!</div>';
        document.getElementById('totalStockInput').value = 0;
        return;
    }
    let h = '<table class="admin-table" style="font-size:12px;"><thead><tr><th style="min-width:100px;">Màu sắc</th>';
    sizes.forEach(s => h += `<th style="text-align:center;min-width:70px;">Size ${s}</th>`);
    h += '<th style="text-align:center;min-width:80px;color:var(--accent-light);">Tổng</th></tr></thead><tbody>';
    colors.forEach(cl => {
        const hex = colorHexMap[cl]||'#888';
        h += `<tr><td><div style="display:flex;align-items:center;gap:6px;"><div style="width:16px;height:16px;border-radius:50%;background:${hex};border:1px solid var(--border);"></div><strong>${cl}</strong></div></td>`;
        sizes.forEach(sz => {
            h += `<td style="text-align:center;padding:6px;"><input type="number" name="variant_matrix[${cl}][${sz}]" class="form-control matrix-cell" data-color="${cl}" data-size="${sz}" value="2" min="0" oninput="calcTotals()" style="width:65px;text-align:center;padding:4px 6px;font-size:12px;margin:0 auto;"></td>`;
        });
        h += `<td style="text-align:center;font-weight:700;color:var(--accent-light);" id="row_${cl}">0</td></tr>`;
    });
    h += '<tr style="background:rgba(56,189,248,0.08);font-weight:700;"><td style="color:var(--accent-light);">Tổng Size</td>';
    sizes.forEach(sz => h += `<td style="text-align:center;color:var(--accent-light);" id="col_${sz}">0</td>`);
    h += '<td style="text-align:center;color:var(--success);font-size:13px;" id="grand">0 đôi</td></tr></tbody></table>';
    c.innerHTML = h; calcTotals();
}

function calcTotals() {
    const sizes = Array.from(document.querySelectorAll('.size-checkbox:checked')).map(cb=>cb.value);
    const colors = Array.from(document.querySelectorAll('.color-checkbox:checked')).map(cb=>cb.value);
    let grand=0; const colT={};
    sizes.forEach(s=>colT[s]=0);
    colors.forEach(cl=>{let r=0; sizes.forEach(sz=>{const v=parseInt(document.querySelector(`.matrix-cell[data-color="${cl}"][data-size="${sz}"]`)?.value)||0;r+=v;colT[sz]+=v;}); const e=document.getElementById(`row_${cl}`);if(e)e.textContent=`${r} đôi`;grand+=r;});
    sizes.forEach(sz=>{const e=document.getElementById(`col_${sz}`);if(e)e.textContent=`${colT[sz]} đôi`;});
    const g=document.getElementById('grand');if(g)g.textContent=`${grand} đôi`;
    document.getElementById('totalStockInput').value=grand;
}

document.addEventListener('DOMContentLoaded',()=>renderMatrix());

function previewImage(input){if(input.files&&input.files[0]){const r=new FileReader();r.onload=e=>{document.getElementById('previewImg').src=e.target.result;document.getElementById('imagePreview').style.display='block';};r.readAsDataURL(input.files[0]);}}
const uz=document.querySelector('.upload-zone');
uz.addEventListener('dragover',e=>{e.preventDefault();uz.style.borderColor='var(--accent)';});
uz.addEventListener('dragleave',()=>{uz.style.borderColor='var(--border)';});
uz.addEventListener('drop',e=>{e.preventDefault();const inp=document.getElementById('imageInput');inp.files=e.dataTransfer.files;previewImage(inp);uz.style.borderColor='var(--border)';});
</script>
@endsection
