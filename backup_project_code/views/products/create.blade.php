@extends('layouts.admin')

@section('title', 'Thêm sản phẩm mới')

@section('breadcrumb')
    <a href="{{ route('products.index') }}" style="color:var(--accent-light); text-decoration:none;">Sản phẩm</a>
    / <span>Thêm mới</span>
@endsection

@section('content')
<div style="max-width:900px;">

    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:24px;">
        <h1 style="font-size:22px; font-weight:700; color:var(--text-primary);">
            👠 Thêm Sản Phẩm Mới
        </h1>
        <a href="{{ route('products.index') }}" class="btn btn-outline">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <div>
                <i class="fas fa-exclamation-triangle"></i>
                <strong>Vui lòng kiểm tra lại các trường sau:</strong>
                <ul style="margin:8px 0 0 16px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="grid-2">
            {{-- LEFT COLUMN --}}
            <div>
                <div class="card" style="margin-bottom:20px;">
                    <div class="card-header">
                        <div class="card-title"><i class="fas fa-info-circle" style="color:var(--accent);"></i> Thông tin cơ bản</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="form-label">Tên sản phẩm <span>*</span></label>
                            <input type="text" name="name" class="form-control"
                                   placeholder="VD: Giày Cao Gót Mũi Nhọn Thanh Lịch"
                                   value="{{ old('name') }}" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Danh mục <span>*</span></label>
                            <select name="category_id" class="form-control" required>
                                <option value="">-- Chọn danh mục --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Mô tả sản phẩm</label>
                            <textarea name="description" class="form-control" rows="4"
                                      placeholder="Mô tả chi tiết về sản phẩm...">{{ old('description') }}</textarea>
                        </div>

                        <div class="grid-2" style="gap:12px;">
                            <div class="form-group" style="margin-bottom:0;">
                                <label class="form-label">Giá bán (₫) <span>*</span></label>
                                <div class="input-group">
                                    <input type="number" name="price" class="form-control"
                                           placeholder="850000"
                                           value="{{ old('price') }}" min="0" required>
                                    <div class="input-addon">₫</div>
                                </div>
                            </div>
                            <div class="form-group" style="margin-bottom:0;">
                                <label class="form-label">Tồn kho <span>*</span></label>
                                <input type="number" name="stock" class="form-control"
                                       placeholder="0" value="{{ old('stock', 0) }}" min="0" required>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- SIZES --}}
                <div class="card" style="margin-bottom:20px;">
                    <div class="card-header">
                        <div class="card-title"><i class="fas fa-ruler" style="color:var(--accent);"></i> Size</div>
                    </div>
                    <div class="card-body">
                        <div class="size-chips">
                            @foreach (['35','36','37','38','39','40','41'] as $size)
                            <label>
                                <input type="checkbox" name="sizes[]" value="{{ $size }}"
                                       {{ in_array($size, old('sizes', [])) ? 'checked' : '' }}>
                                <div class="size-chip">{{ $size }}</div>
                            </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- COLORS --}}
                <div class="card">
                    <div class="card-header">
                        <div class="card-title"><i class="fas fa-palette" style="color:var(--accent);"></i> Màu sắc</div>
                    </div>
                    <div class="card-body">
                        <div class="color-swatches">
                            @php
                                $colorList = [
                                    'Đen'  => '#1a1a1a',
                                    'Trắng'=> '#e8e8e8',
                                    'Nude' => '#c4a882',
                                    'Đỏ'   => '#c0392b',
                                    'Hồng' => '#e91e8c',
                                    'Nâu'  => '#7a4f37',
                                    'Bạc'  => '#b0b0b0',
                                    'Vàng' => '#d4a843',
                                ];
                            @endphp
                            @foreach ($colorList as $colorName => $colorHex)
                            <div>
                                <input type="checkbox" name="colors[]" value="{{ $colorName }}"
                                       id="color_{{ $colorName }}"
                                       {{ in_array($colorName, old('colors', [])) ? 'checked' : '' }}>
                                <label for="color_{{ $colorName }}" class="color-swatch-label">
                                    <div class="color-dot" style="background:{{ $colorHex }};"></div>
                                    <span>{{ $colorName }}</span>
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- RIGHT COLUMN --}}
            <div>
                {{-- IMAGE UPLOAD --}}
                <div class="card" style="margin-bottom:20px;">
                    <div class="card-header">
                        <div class="card-title"><i class="fas fa-image" style="color:var(--accent);"></i> Hình ảnh</div>
                    </div>
                    <div class="card-body">
                        <div class="upload-zone" onclick="document.getElementById('imageInput').click()">
                            <div class="upload-icon">📸</div>
                            <p><strong>Click để chọn ảnh</strong></p>
                            <p style="margin-top:4px;">hoặc kéo thả vào đây</p>
                            <p style="margin-top:8px; font-size:11px;">JPG, PNG, WEBP – Tối đa 2MB</p>
                        </div>
                        <input type="file" id="imageInput" name="image" accept="image/*"
                               onchange="previewImage(this)">
                        <div class="image-preview" id="imagePreview">
                            <img id="previewImg" src="" alt="Preview">
                        </div>
                    </div>
                </div>

                {{-- STATUS --}}
                <div class="card">
                    <div class="card-header">
                        <div class="card-title"><i class="fas fa-toggle-on" style="color:var(--accent);"></i> Trạng thái</div>
                    </div>
                    <div class="card-body">
                        <input type="hidden" name="status" id="statusValue" value="active">
                        <div class="toggle-group">
                            <input type="checkbox" id="statusToggle" checked
                                   onchange="document.getElementById('statusValue').value = this.checked ? 'active' : 'inactive'; document.getElementById('statusLabel').textContent = this.checked ? '✅ Đang bán' : '❌ Ngừng bán'">
                            <label class="toggle-switch" for="statusToggle"></label>
                            <span id="statusLabel" style="font-size:14px; color:var(--text-primary); font-weight:500;">
                                ✅ Đang bán
                            </span>
                        </div>
                        <p style="font-size:12px; color:var(--text-muted); margin-top:8px;">
                            Sản phẩm sẽ hiển thị hoặc ẩn trên cửa hàng
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div style="display:flex; gap:12px; margin-top:24px;">
            <button type="submit" class="btn btn-primary" style="padding:12px 32px; font-size:15px;">
                <i class="fas fa-save"></i> Lưu sản phẩm
            </button>
            <a href="{{ route('products.index') }}" class="btn btn-outline" style="padding:12px 24px;">Huỷ</a>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('imagePreview').style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
const uploadZone = document.querySelector('.upload-zone');
uploadZone.addEventListener('dragover', e => { e.preventDefault(); uploadZone.style.borderColor='var(--accent)'; });
uploadZone.addEventListener('dragleave', () => { uploadZone.style.borderColor='var(--border)'; });
uploadZone.addEventListener('drop', e => {
    e.preventDefault();
    const inp = document.getElementById('imageInput');
    inp.files = e.dataTransfer.files;
    previewImage(inp);
    uploadZone.style.borderColor='var(--border)';
});
</script>
@endsection
