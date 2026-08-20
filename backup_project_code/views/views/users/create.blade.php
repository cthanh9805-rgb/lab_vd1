@extends('layouts.admin')

@section('title', 'Thêm người dùng mới')

@section('breadcrumb')
    <a href="{{ route('users.index') }}" style="color:var(--accent-light); text-decoration:none;">Người dùng</a>
    / <span>Thêm mới</span>
@endsection

@section('content')
<div style="max-width:1100px; margin:0 auto;">

    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:24px;">
        <h1 style="font-size:22px; font-weight:700; color:var(--text-primary);">👤 Thêm Người Dùng Mới</h1>
        <a href="{{ route('users.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Quay lại</a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <div>
                <i class="fas fa-exclamation-triangle"></i>
                <strong>Vui lòng kiểm tra lại thông tin:</strong>
                <ul style="margin:8px 0 0 16px;">
                    @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                </ul>
            </div>
        </div>
    @endif

    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- 2 CỘT MOCKUP 2 --}}
        <div class="grid-2" style="gap:24px; align-items:start;">
            
            {{-- CỘT TRÁI: THÔNG TIN CÁ NHÂN & ĐỊA CHỈ --}}
            <div>
                <div class="card" style="margin-bottom:20px;">
                    <div class="card-header">
                        <div class="card-title"><i class="fas fa-user" style="color:var(--accent);"></i> Thông tin cá nhân</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="form-label">Họ và tên <span>*</span></label>
                            <input type="text" name="name" class="form-control" placeholder="VD: Nguyễn Văn An" value="{{ old('name') }}" required>
                        </div>

                        <div class="grid-2" style="gap:12px;">
                            <div class="form-group">
                                <label class="form-label">Email <span>*</span></label>
                                <input type="email" name="email" class="form-control" placeholder="nguyenvanan@gmail.com" value="{{ old('email') }}" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Số điện thoại</label>
                                <input type="text" name="phone" class="form-control" placeholder="0912345678" value="{{ old('phone') }}">
                            </div>
                        </div>

                        <div class="grid-2" style="gap:12px;">
                            <div class="form-group" style="margin-bottom:0;">
                                <label class="form-label">Mật khẩu <span>*</span></label>
                                <div style="position:relative;">
                                    <input type="password" name="password" id="passInput" class="form-control" placeholder="Tối thiểu 6 ký tự" required style="padding-right:40px;">
                                    <i class="fas fa-eye" id="togglePassBtn" onclick="togglePass('passInput', this)" style="position:absolute; right:12px; top:50%; transform:translateY(-50%); color:var(--text-muted); cursor:pointer;"></i>
                                </div>
                            </div>
                            <div class="form-group" style="margin-bottom:0;">
                                <label class="form-label">Xác nhận mật khẩu <span>*</span></label>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="Nhập lại mật khẩu" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="card-title"><i class="fas fa-map-marker-alt" style="color:var(--accent);"></i> Địa chỉ</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="form-label">Địa chỉ chi tiết</label>
                            <textarea name="address" class="form-control" rows="2" placeholder="Số nhà, tên đường...">{{ old('address') }}</textarea>
                        </div>
                        <div class="form-group" style="margin-bottom:0;">
                            <label class="form-label">Tỉnh / Thành phố</label>
                            <input type="text" name="city" class="form-control" placeholder="VD: TP. Hồ Chí Minh, Hà Nội..." value="{{ old('city') }}">
                        </div>
                    </div>
                </div>
            </div>

            {{-- CỘT PHẢI: VAI TRÒ, AVATAR & TRẠNG THÁI --}}
            <div>
                {{-- VAI TRÒ & QUYỀN HẠN --}}
                <div class="card" style="margin-bottom:20px;">
                    <div class="card-header">
                        <div class="card-title"><i class="fas fa-user-shield" style="color:var(--accent);"></i> Vai trò & Quyền hạn</div>
                    </div>
                    <div class="card-body">
                        <div style="display:flex; flex-direction:column; gap:10px;">
                            <label style="display:flex; align-items:flex-start; gap:12px; padding:10px 12px; border:1px solid var(--border); border-radius:10px; cursor:pointer; background:rgba(255,255,255,0.02);">
                                <input type="radio" name="role" value="customer" {{ old('role', 'customer') === 'customer' ? 'checked' : '' }} style="margin-top:3px;">
                                <div>
                                    <div style="font-weight:600; color:var(--text-primary);">🛍️ Khách hàng (Customer)</div>
                                    <div style="font-size:11px; color:var(--text-muted);">Tài khoản mua hàng thông thường.</div>
                                </div>
                            </label>

                            <label style="display:flex; align-items:flex-start; gap:12px; padding:10px 12px; border:1px solid var(--border); border-radius:10px; cursor:pointer; background:rgba(255,255,255,0.02);">
                                <input type="radio" name="role" value="staff" {{ old('role') === 'staff' ? 'checked' : '' }} style="margin-top:3px;">
                                <div>
                                    <div style="font-weight:600; color:#7dd3fc;">💼 Nhân viên (Staff)</div>
                                    <div style="font-size:11px; color:var(--text-muted);">Quản lý sản phẩm và danh mục, không sửa được người dùng.</div>
                                </div>
                            </label>

                            <label style="display:flex; align-items:flex-start; gap:12px; padding:10px 12px; border:1px solid var(--border); border-radius:10px; cursor:pointer; background:rgba(255,255,255,0.02);">
                                <input type="radio" name="role" value="manager" {{ old('role') === 'manager' ? 'checked' : '' }} style="margin-top:3px;">
                                <div>
                                    <div style="font-weight:600; color:#c084fc;">👔 Quản lý (Manager)</div>
                                    <div style="font-size:11px; color:var(--text-muted);">Quản lý sản phẩm, danh mục và người dùng.</div>
                                </div>
                            </label>

                            <label style="display:flex; align-items:flex-start; gap:12px; padding:10px 12px; border:1px solid var(--border); border-radius:10px; cursor:pointer; background:rgba(255,255,255,0.02);">
                                <input type="radio" name="role" value="admin" {{ old('role') === 'admin' ? 'checked' : '' }} style="margin-top:3px;">
                                <div>
                                    <div style="font-weight:600; color:#fde047;">👑 Quản trị viên (Admin)</div>
                                    <div style="font-size:11px; color:var(--text-muted);">Quyền tối cao nhất của chủ hệ thống.</div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- AVATAR UPLOAD --}}
                <div class="card" style="margin-bottom:20px;">
                    <div class="card-header">
                        <div class="card-title"><i class="fas fa-camera" style="color:var(--accent);"></i> Ảnh đại diện</div>
                    </div>
                    <div class="card-body" style="text-align:center;">
                        <div class="upload-zone" onclick="document.getElementById('avatarInput').click()" style="margin-bottom:12px;">
                            <div class="upload-icon">📸</div>
                            <p><strong>Click chọn ảnh đại diện</strong></p>
                            <p style="font-size:11px; color:var(--text-muted); margin-top:4px;">JPG, PNG, WEBP tối đa 2MB</p>
                        </div>
                        <input type="file" id="avatarInput" name="avatar" accept="image/*" style="display:none;" onchange="previewAvatar(this)">
                        
                        <div id="avatarPreview" style="display:none; margin-top:12px;">
                            <img id="previewImg" src="" style="width:80px; height:80px; border-radius:50%; object-fit:cover; border:2px solid var(--accent);">
                        </div>
                    </div>
                </div>

                {{-- TRẠNG THÁI --}}
                <div class="card">
                    <div class="card-header">
                        <div class="card-title"><i class="fas fa-toggle-on" style="color:var(--accent);"></i> Trạng thái tài khoản</div>
                    </div>
                    <div class="card-body">
                        <input type="hidden" name="status" id="statusValue" value="active">
                        <div class="toggle-group">
                            <input type="checkbox" id="statusToggle" checked
                                   onchange="document.getElementById('statusValue').value=this.checked?'active':'blocked'; document.getElementById('statusLabel').textContent=this.checked?'✅ Hoạt động bình thường':'🔒 Khoá tài khoản'">
                            <label class="toggle-switch" for="statusToggle"></label>
                            <span id="statusLabel" style="font-size:14px; color:var(--text-primary); font-weight:500;">✅ Hoạt động bình thường</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div style="display:flex; gap:12px; margin-top:24px;">
            <button type="submit" class="btn btn-primary" style="padding:12px 32px; font-size:15px;"><i class="fas fa-save"></i> Lưu người dùng</button>
            <a href="{{ route('users.index') }}" class="btn btn-outline" style="padding:12px 24px;">Huỷ</a>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
function togglePass(id, icon) {
    const input = document.getElementById(id);
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

function previewAvatar(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('avatarPreview').style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
