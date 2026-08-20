@extends('layouts.admin')

@section('title', 'Hồ sơ cá nhân')

@section('breadcrumb')
    <span>Tài khoản</span> / Hồ sơ cá nhân
@endsection

@section('content')
<div style="max-width:1000px; margin:0 auto;">

    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:24px;">
        <h1 style="font-size:22px; font-weight:700; color:var(--text-primary);">👤 Hồ Sơ Cá Nhân & Bảo Mật</h1>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> {{ $message }}
        </div>
    @endif

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

    <div class="grid-2" style="gap:24px; align-items:start;">
        
        {{-- CỘT TRÁI: CẬP NHẬT THÔNG TIN CÁ NHÂN --}}
        <div>
            <div class="card">
                <div class="card-header">
                    <div class="card-title"><i class="fas fa-user-edit" style="color:var(--accent);"></i> Thông tin cá nhân</div>
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div style="text-align:center; margin-bottom:20px;">
                            <img id="profileAvatar" src="{{ $user->avatar_url }}" alt="{{ $user->name }}" style="width:100px; height:100px; border-radius:50%; object-fit:cover; border:3px solid var(--accent); margin-bottom:12px;">
                            <div>
                                <button type="button" class="btn btn-outline" style="font-size:12px; padding:4px 12px;" onclick="document.getElementById('avatarInput').click()">
                                    <i class="fas fa-camera"></i> Đổi ảnh đại diện
                                </button>
                                <input type="file" id="avatarInput" name="avatar" accept="image/*" style="display:none;" onchange="previewProfileAvatar(this)">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Họ và tên <span>*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Email <span>*</span></label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Số điện thoại</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Địa chỉ</label>
                            <textarea name="address" class="form-control" rows="2">{{ old('address', $user->address) }}</textarea>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Tỉnh / Thành phố</label>
                            <input type="text" name="city" class="form-control" value="{{ old('city', $user->city) }}">
                        </div>

                        <button type="submit" class="btn btn-primary" style="width:100%; justify-content:center; padding:10px;">
                            <i class="fas fa-save"></i> Cập nhật thông tin
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- CỘT PHẢI: ĐỔI MẬT KHẨU --}}
        <div>
            <div class="card">
                <div class="card-header">
                    <div class="card-title"><i class="fas fa-lock" style="color:var(--warning);"></i> Đổi mật khẩu</div>
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.password') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label class="form-label">Mật khẩu hiện tại <span>*</span></label>
                            <input type="password" name="current_password" class="form-control" placeholder="••••••••" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Mật khẩu mới <span>*</span></label>
                            <input type="password" name="password" class="form-control" placeholder="Tối thiểu 6 ký tự" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Xác nhận mật khẩu mới <span>*</span></label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Nhập lại mật khẩu mới" required>
                        </div>

                        <button type="submit" class="btn btn-primary" style="width:100%; justify-content:center; padding:10px; background:linear-gradient(135deg, var(--warning), #d97706);">
                            <i class="fas fa-key"></i> Đổi mật khẩu
                        </button>
                    </form>
                </div>
            </div>

            {{-- VAI TRÒ HỆ THỐNG CARD --}}
            <div class="card" style="margin-top:20px;">
                <div class="card-header">
                    <div class="card-title"><i class="fas fa-user-shield" style="color:var(--accent);"></i> Thông tin vai trò</div>
                </div>
                <div class="card-body">
                    @php $badge = $user->role_badge; @endphp
                    <div style="display:flex; align-items:center; justify-content:space-between; padding:12px; background:{{ $badge['bg'] }}; border:1px solid {{ $badge['border'] }}; border-radius:10px;">
                        <span style="font-weight:600; color:{{ $badge['color'] }};">{{ $badge['label'] }}</span>
                        <span style="font-size:11px; color:var(--text-muted);">Đang hoạt động</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function previewProfileAvatar(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('profileAvatar').src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
