@extends('customer.layouts.app')

@section('title', 'Đăng Ký Tài Khoản Khách Hàng - HEEL BOUTIQUE')

@section('content')
<div class="container my-5" style="max-width: 520px;">
    <div class="card card-boutique p-4 p-md-5 shadow-sm border-0">
        
        <div class="text-center mb-4">
            <span class="fs-1 d-block mb-2">👠</span>
            <h2 class="fw-bold text-dark mb-1" style="font-family:'Playfair Display', serif;">Đăng Ký Tài Khoản</h2>
            <p class="text-muted small mb-0">Tạo tài khoản khách hàng để mua sắm dễ dàng tại HEEL BOUTIQUE</p>
        </div>

        @if (session('success'))
            <div class="alert alert-success border-0 bg-success bg-opacity-10 text-success p-3 rounded-3 small mb-3">
                <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger border-0 bg-danger bg-opacity-10 text-danger p-3 rounded-3 small mb-3">
                <i class="fas fa-exclamation-triangle me-1"></i> {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger border-0 bg-danger bg-opacity-10 text-danger p-3 rounded-3 small mb-3">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf

            <div class="mb-3 text-start">
                <label for="name" class="form-label fw-semibold text-dark small mb-1">Họ và Tên <span class="text-danger">*</span></label>
                <input type="text" name="name" id="name" class="form-control py-2 px-3 rounded-3 bg-light border-slate text-dark" value="{{ old('name') }}" placeholder="Nhập họ và tên..." required>
            </div>

            <div class="mb-3 text-start">
                <label for="email" class="form-label fw-semibold text-dark small mb-1">Địa chỉ Email <span class="text-danger">*</span></label>
                <input type="email" name="email" id="email" class="form-control py-2 px-3 rounded-3 bg-light border-slate text-dark" value="{{ old('email') }}" placeholder="name@example.com" required>
            </div>

            <div class="mb-3 text-start">
                <label for="phone" class="form-label fw-semibold text-dark small mb-1">Số Điện Thoại</label>
                <input type="text" name="phone" id="phone" class="form-control py-2 px-3 rounded-3 bg-light border-slate text-dark" value="{{ old('phone') }}" placeholder="0912345678">
            </div>

            <div class="mb-3 text-start">
                <label for="password" class="form-label fw-semibold text-dark small mb-1">Mật khẩu (Tối thiểu 6 ký tự) <span class="text-danger">*</span></label>
                <input type="password" name="password" id="password" class="form-control py-2 px-3 rounded-3 bg-light border-slate text-dark" placeholder="••••••••" required>
            </div>

            <div class="mb-4 text-start">
                <label for="password_confirmation" class="form-label fw-semibold text-dark small mb-1">Xác nhận mật khẩu <span class="text-danger">*</span></label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control py-2 px-3 rounded-3 bg-light border-slate text-dark" placeholder="••••••••" required>
            </div>

            <button type="submit" class="btn btn-rose-gold w-100 py-3 rounded-3 fw-bold text-uppercase shadow-sm mb-3">
                🚀 Đăng Ký Tài Khoản Khách Hàng
            </button>
        </form>

        <div class="text-center text-muted small mt-2">
            Đã có tài khoản? <a href="{{ route('login') }}" class="text-dark fw-bold text-decoration-none ms-1">Đăng nhập ngay</a>
        </div>

    </div>
</div>
@endsection
