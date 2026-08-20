@extends('layouts.admin')

@section('title', 'Hồ sơ: ' . $user->name)

@section('breadcrumb')
    <a href="{{ route('users.index') }}" style="color:var(--accent-light); text-decoration:none;">Người dùng</a>
    / <span>Chi tiết: {{ $user->name }}</span>
@endsection

@section('content')
<div style="max-width:1100px; margin:0 auto;">

    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:24px;">
        <h1 style="font-size:22px; font-weight:700; color:var(--text-primary);">👤 Hồ Sơ Người Dùng</h1>
        <div style="display:flex; gap:10px;">
            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary"><i class="fas fa-pen"></i> Chỉnh sửa</a>
            <a href="{{ route('users.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Quay lại</a>
        </div>
    </div>

    {{-- 2 CỘT MOCKUP 3 --}}
    <div class="grid-2" style="gap:24px; align-items:start;">
        
        {{-- CỘT TRÁI: AVATAR CARD & THÔNG TIN CHI TIẾT --}}
        <div>
            {{-- AVATAR & QUICK ACTIONS CARD --}}
            <div class="card" style="margin-bottom:20px; text-align:center; padding:28px 20px;">
                <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" style="width:110px; height:110px; border-radius:50%; object-fit:cover; border:3px solid var(--accent); margin:0 auto 16px; box-shadow:0 0 20px rgba(56,189,248,0.25);">
                
                <h2 style="font-size:20px; font-weight:700; color:var(--text-primary); margin-bottom:6px;">{{ $user->name }}</h2>
                <p style="font-size:13px; color:var(--text-muted); margin-bottom:12px;">{{ $user->email }}</p>

                <div style="display:flex; justify-content:center; gap:8px; margin-bottom:20px;">
                    @if ($user->role === 'admin')
                        <span style="background:rgba(168,85,247,0.15); color:#c084fc; border:1px solid rgba(168,85,247,0.3); padding:4px 14px; border-radius:12px; font-size:12px; font-weight:600;">
                            👑 Admin
                        </span>
                    @else
                        <span style="background:rgba(56,189,248,0.12); color:var(--accent-light); border:1px solid rgba(56,189,248,0.3); padding:4px 14px; border-radius:12px; font-size:12px; font-weight:600;">
                            🛍️ Khách hàng
                        </span>
                    @endif

                    @if ($user->status === 'active')
                        <span class="badge badge-success"><i class="fas fa-circle" style="font-size:6px;"></i> Hoạt động</span>
                    @else
                        <span class="badge badge-danger"><i class="fas fa-lock" style="font-size:10px;"></i> Bị khoá</span>
                    @endif
                </div>

                <div style="display:flex; justify-content:center; gap:10px;">
                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary" style="padding:8px 20px; font-size:13px;">
                        <i class="fas fa-pen"></i> Chỉnh sửa
                    </a>
                    <form action="{{ route('users.toggleStatus', $user->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-outline" style="padding:8px 16px; font-size:13px; {{ $user->status === 'active' ? 'color:var(--danger); border-color:rgba(239,68,68,0.3);' : 'color:var(--success); border-color:rgba(16,185,129,0.3);' }}">
                            <i class="fas {{ $user->status === 'active' ? 'fa-lock' : 'fa-unlock' }}"></i>
                            {{ $user->status === 'active' ? 'Khoá tài khoản' : 'Kích hoạt' }}
                        </button>
                    </form>
                </div>
            </div>

            {{-- THÔNG TIN CHI TIẾT CARD --}}
            <div class="card" style="margin-bottom:20px;">
                <div class="card-header">
                    <div class="card-title"><i class="fas fa-address-card" style="color:var(--accent);"></i> Thông tin chi tiết</div>
                </div>
                <div class="card-body">
                    <div class="detail-row">
                        <div class="detail-label"><i class="fas fa-user" style="color:var(--accent); margin-right:6px;"></i>Họ và tên</div>
                        <div class="detail-value">{{ $user->name }}</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label"><i class="fas fa-envelope" style="color:var(--accent); margin-right:6px;"></i>Email</div>
                        <div class="detail-value">{{ $user->email }}</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label"><i class="fas fa-phone" style="color:var(--accent); margin-right:6px;"></i>Số điện thoại</div>
                        <div class="detail-value">{{ $user->phone ?? '—' }}</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label"><i class="fas fa-map-marker-alt" style="color:var(--accent); margin-right:6px;"></i>Địa chỉ</div>
                        <div class="detail-value">{{ $user->address ?? '—' }}</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label"><i class="fas fa-city" style="color:var(--accent); margin-right:6px;"></i>Thành phố</div>
                        <div class="detail-value">{{ $user->city ?? '—' }}</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label"><i class="fas fa-calendar" style="color:var(--accent); margin-right:6px;"></i>Ngày tham gia</div>
                        <div class="detail-value">{{ $user->created_at ? $user->created_at->format('d/m/Y H:i') : '—' }}</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label"><i class="fas fa-clock" style="color:var(--accent); margin-right:6px;"></i>Lần đăng nhập cuối</div>
                        <div class="detail-value">{{ $user->last_login_at ? $user->last_login_at->format('d/m/Y H:i') : 'Chưa đăng nhập' }}</div>
                    </div>
                </div>
            </div>

            {{-- SỔ ĐỊA CHỈ GIAO HÀNG --}}
            <div class="card">
                <div class="card-header">
                    <div class="card-title"><i class="fas fa-book" style="color:var(--accent);"></i> Sổ địa chỉ giao hàng</div>
                </div>
                <div class="card-body">
                    @if ($user->addresses->count() > 0)
                        <div style="display:flex; flex-direction:column; gap:10px;">
                            @foreach ($user->addresses as $addr)
                            <div style="padding:12px; border:1px solid var(--border); border-radius:10px; background:rgba(255,255,255,0.02);">
                                <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:4px;">
                                    <strong style="font-size:14px; color:var(--text-primary);">{{ $addr->recipient_name }}</strong>
                                    @if ($addr->is_default)
                                        <span style="font-size:10px; background:rgba(16,185,129,0.15); color:var(--success); padding:2px 8px; border-radius:10px; font-weight:600;">Mặc định</span>
                                    @endif
                                </div>
                                <div style="font-size:12px; color:var(--text-muted); margin-bottom:2px;"><i class="fas fa-phone" style="font-size:10px;"></i> {{ $addr->phone }}</div>
                                <div style="font-size:13px; color:var(--text-secondary);"><i class="fas fa-map-pin" style="font-size:10px;"></i> {{ $addr->address }}, {{ $addr->city }}</div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div style="font-size:13px; color:var(--text-muted); padding:10px 0;">
                            <i class="fas fa-map-marker-alt"></i> {{ $user->address ? $user->address . ', ' . $user->city : 'Chưa có địa chỉ nào trong sổ địa chỉ.' }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- CỘT PHẢI: HOẠT ĐỘNG GẦN ĐÂY & THỐNG KÊ --}}
        <div>
            {{-- THỐNG KÊ CÁ NHÂN --}}
            <div class="card" style="margin-bottom:20px;">
                <div class="card-header">
                    <div class="card-title"><i class="fas fa-chart-pie" style="color:var(--accent);"></i> Thống kê người dùng</div>
                </div>
                <div class="card-body">
                    <div style="display:grid; grid-template-columns:repeat(3, 1fr); gap:12px;">
                        <div style="text-align:center; padding:16px; background:rgba(56,189,248,0.06); border-radius:12px; border:1px solid rgba(56,189,248,0.15);">
                            <div style="font-size:24px; margin-bottom:6px;">📦</div>
                            <div style="font-size:18px; font-weight:700; color:var(--accent-light);">12</div>
                            <div style="font-size:11px; color:var(--text-muted); margin-top:4px;">Tổng đơn hàng</div>
                        </div>
                        <div style="text-align:center; padding:16px; background:rgba(16,185,129,0.06); border-radius:12px; border:1px solid rgba(16,185,129,0.15);">
                            <div style="font-size:24px; margin-bottom:6px;">💰</div>
                            <div style="font-size:15px; font-weight:700; color:var(--success);">8.500.000₫</div>
                            <div style="font-size:11px; color:var(--text-muted); margin-top:4px;">Tổng chi tiêu</div>
                        </div>
                        <div style="text-align:center; padding:16px; background:rgba(245,158,11,0.06); border-radius:12px; border:1px solid rgba(245,158,11,0.15);">
                            <div style="font-size:24px; margin-bottom:6px;">❤️</div>
                            <div style="font-size:18px; font-weight:700; color:var(--warning);">5</div>
                            <div style="font-size:11px; color:var(--text-muted); margin-top:4px;">SP Yêu thích</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TIMELINE HOẠT ĐỘNG GẦN ĐÂY --}}
            <div class="card">
                <div class="card-header">
                    <div class="card-title"><i class="fas fa-history" style="color:var(--accent);"></i> Hoạt động gần đây</div>
                </div>
                <div class="card-body">
                    <div style="display:flex; flex-direction:column; gap:16px; position:relative; padding-left:20px;">
                        <div style="position:absolute; left:6px; top:8px; bottom:8px; width:2px; background:var(--border);"></div>

                        <div style="position:relative;">
                            <div style="position:absolute; left:-20px; top:4px; width:10px; height:10px; border-radius:50%; background:var(--success);"></div>
                            <div style="font-size:13px; font-weight:600; color:var(--text-primary);">Đã đăng nhập vào hệ thống</div>
                            <div style="font-size:11px; color:var(--text-muted);">{{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Vừa xong' }}</div>
                        </div>

                        <div style="position:relative;">
                            <div style="position:absolute; left:-20px; top:4px; width:10px; height:10px; border-radius:50%; background:var(--accent);"></div>
                            <div style="font-size:13px; font-weight:600; color:var(--text-primary);">Đã cập nhật thông tin cá nhân</div>
                            <div style="font-size:11px; color:var(--text-muted);">2 ngày trước</div>
                        </div>

                        <div style="position:relative;">
                            <div style="position:absolute; left:-20px; top:4px; width:10px; height:10px; border-radius:50%; background:var(--warning);"></div>
                            <div style="font-size:13px; font-weight:600; color:var(--text-primary);">Đã đặt đơn hàng #1024 (Giày cao gót da thật)</div>
                            <div style="font-size:11px; color:var(--text-muted);">5 ngày trước</div>
                        </div>

                        <div style="position:relative;">
                            <div style="position:absolute; left:-20px; top:4px; width:10px; height:10px; border-radius:50%; background:#c084fc;"></div>
                            <div style="font-size:13px; font-weight:600; color:var(--text-primary);">Tài khoản được khởi tạo thành công</div>
                            <div style="font-size:11px; color:var(--text-muted);">{{ $user->created_at ? $user->created_at->format('d/m/Y') : 'Chưa rõ' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
