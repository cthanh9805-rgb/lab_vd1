@extends('customer.layouts.app')

@section('title', 'Đăng ký tài khoản - MyShop')

@section('content')
<div style="max-width:480px; margin:40px auto;">
    <div style="background:rgba(15,23,42,0.85); backdrop-filter:blur(16px); border:1px solid rgba(255,255,255,0.1); border-radius:20px; padding:36px; box-shadow:0 20px 50px rgba(0,0,0,0.5);">
        
        <div style="text-align:center; margin-bottom:28px;">
            <div style="font-size:42px; margin-bottom:8px;">✨</div>
            <h2 style="font-size:24px; font-weight:700; color:#f8fafc; margin:0 0 6px 0;">Đăng Ký Tài Khoản</h2>
            <p style="font-size:13px; color:#94a3b8; margin:0;">Tạo tài khoản để trải nghiệm mua sắm tuyệt vời tại MyShop</p>
        </div>

        @if (session('success'))
            <div class="alert alert-success" style="background:rgba(34,197,94,0.15); border:1px solid rgba(34,197,94,0.3); color:#4ade80; padding:12px 16px; border-radius:10px; font-size:13px; margin-bottom:20px;">
                ✅ {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger" style="background:rgba(239,68,68,0.15); border:1px solid rgba(239,68,68,0.3); color:#f87171; padding:12px 16px; border-radius:10px; font-size:13px; margin-bottom:20px;">
                ⚠️ {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger" style="background:rgba(239,68,68,0.15); border:1px solid rgba(239,68,68,0.3); color:#f87171; padding:12px 16px; border-radius:10px; font-size:13px; margin-bottom:20px;">
                <ul style="margin:0; padding-left:18px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf

            <div class="form-group" style="margin-bottom:18px;">
                <label for="name" style="display:block; font-size:13px; font-weight:600; color:#cbd5e1; margin-bottom:6px;">Họ và Tên</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" placeholder="Nhập họ và tên..." required
                       style="width:100%; padding:12px 14px; background:rgba(30,41,59,0.8); border:1px solid rgba(255,255,255,0.12); border-radius:10px; color:#f8fafc; font-size:14px;">
            </div>

            <div class="form-group" style="margin-bottom:18px;">
                <label for="email" style="display:block; font-size:13px; font-weight:600; color:#cbd5e1; margin-bottom:6px;">Địa chỉ Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" placeholder="name@example.com" required
                       style="width:100%; padding:12px 14px; background:rgba(30,41,59,0.8); border:1px solid rgba(255,255,255,0.12); border-radius:10px; color:#f8fafc; font-size:14px;">
            </div>

            <div class="form-group" style="margin-bottom:18px;">
                <label for="phone" style="display:block; font-size:13px; font-weight:600; color:#cbd5e1; margin-bottom:6px;">Số Điện Thoại</label>
                <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone') }}" placeholder="0912345678"
                       style="width:100%; padding:12px 14px; background:rgba(30,41,59,0.8); border:1px solid rgba(255,255,255,0.12); border-radius:10px; color:#f8fafc; font-size:14px;">
            </div>

            <div class="form-group" style="margin-bottom:18px;">
                <label for="password" style="display:block; font-size:13px; font-weight:600; color:#cbd5e1; margin-bottom:6px;">Mật khẩu (Tối thiểu 6 ký tự)</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="••••••••" required
                       style="width:100%; padding:12px 14px; background:rgba(30,41,59,0.8); border:1px solid rgba(255,255,255,0.12); border-radius:10px; color:#f8fafc; font-size:14px;">
            </div>

            <div class="form-group" style="margin-bottom:24px;">
                <label for="password_confirmation" style="display:block; font-size:13px; font-weight:600; color:#cbd5e1; margin-bottom:6px;">Xác nhận mật khẩu</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="••••••••" required
                       style="width:100%; padding:12px 14px; background:rgba(30,41,59,0.8); border:1px solid rgba(255,255,255,0.12); border-radius:10px; color:#f8fafc; font-size:14px;">
            </div>

            <button type="submit" class="btn btn-primary" style="width:100%; padding:12px; background:linear-gradient(135deg, #38bdf8, #0284c7); border:none; border-radius:10px; color:#ffffff; font-weight:700; font-size:15px; cursor:pointer; box-shadow:0 4px 14px rgba(56,189,248,0.4);">
                🚀 Đăng Ký Tài Khoản
            </button>
        </form>

        <div style="text-align:center; margin-top:24px; font-size:13px; color:#94a3b8;">
            Đã có tài khoản? <a href="{{ route('login') }}" style="color:#38bdf8; text-decoration:none; font-weight:600;">Đăng nhập ngay</a>
        </div>

    </div>
</div>
@endsection
