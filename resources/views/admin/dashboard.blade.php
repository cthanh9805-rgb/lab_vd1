@extends('layouts.admin')

@section('title', 'Tổng quan Quản trị - Admin Dashboard')

@section('breadcrumb')
    <span>Trang chủ / Tổng quan Dashboard</span>
@endsection

@section('content')
<div style="max-width:1200px; margin:0 auto;">

    <!-- HERO BANNER DÀNH CHO ADMIN -->
    <div style="background:linear-gradient(135deg, rgba(30,41,59,0.9), rgba(15,23,42,0.9)), url('https://images.unsplash.com/photo-1543163521-1bf539c55dd2?auto=format&fit=crop&w=1200&q=80') center/cover; border:1px solid var(--border); border-radius:18px; padding:32px; margin-bottom:28px; box-shadow:0 10px 30px rgba(0,0,0,0.3);">
        <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:20px;">
            <div>
                <h1 style="font-size:26px; font-weight:700; color:var(--text-primary); margin-bottom:8px;">👋 Chào mừng trở lại, {{ auth()->user()->name }}!</h1>
                <p style="font-size:14px; color:var(--text-muted); margin:0;">Hệ thống đang hoạt động ổn định. Bạn có toàn quyền quản lý sản phẩm, danh mục và người dùng tại đây.</p>
            </div>
            <div style="display:flex; gap:12px;">
                <a href="{{ route('products.create') }}" class="btn btn-primary" style="padding:10px 20px; font-size:14px;"><i class="fas fa-plus"></i> Thêm sản phẩm mới</a>
                <a href="{{ route('welcome') }}" class="btn btn-outline" style="padding:10px 20px; font-size:14px;" target="_blank"><i class="fas fa-external-link-alt"></i> Xem Cửa hàng</a>
            </div>
        </div>
    </div>

    <!-- HÀNG 4 THẺ THỐNG KÊ (KEY METRICS) -->
    <div class="grid-4" style="gap:20px; margin-bottom:28px;">
        <div class="card" style="padding:20px;">
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:12px;">
                <span style="font-size:13px; font-weight:600; color:var(--text-muted);">Sản phẩm</span>
                <div style="width:40px; height:40px; border-radius:10px; background:rgba(56,189,248,0.15); color:var(--accent); display:flex; align-items:center; justify-content:center; font-size:18px;">👠</div>
            </div>
            <div style="font-size:28px; font-weight:700; color:var(--text-primary);">{{ $stats['total_products'] }}</div>
            <div style="font-size:12px; color:var(--text-muted); margin-top:4px;">Tổng số đôi giày đang kinh doanh</div>
        </div>

        <div class="card" style="padding:20px;">
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:12px;">
                <span style="font-size:13px; font-weight:600; color:var(--text-muted);">Danh mục</span>
                <div style="width:40px; height:40px; border-radius:10px; background:rgba(168,85,247,0.15); color:#c084fc; display:flex; align-items:center; justify-content:center; font-size:18px;"><i class="fas fa-tags"></i></div>
            </div>
            <div style="font-size:28px; font-weight:700; color:var(--text-primary);">{{ $stats['total_categories'] }}</div>
            <div style="font-size:12px; color:var(--text-muted); margin-top:4px;">Các nhóm danh mục loại sản phẩm</div>
        </div>

        <div class="card" style="padding:20px;">
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:12px;">
                <span style="font-size:13px; font-weight:600; color:var(--text-muted);">Người dùng</span>
                <div style="width:40px; height:40px; border-radius:10px; background:rgba(34,197,94,0.15); color:#4ade80; display:flex; align-items:center; justify-content:center; font-size:18px;"><i class="fas fa-users"></i></div>
            </div>
            <div style="font-size:28px; font-weight:700; color:var(--text-primary);">{{ $stats['total_users'] }}</div>
            <div style="font-size:12px; color:var(--text-muted); margin-top:4px;">Gồm Admin, Quản lý, Staff, Khách hàng</div>
        </div>

        <div class="card" style="padding:20px;">
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:12px;">
                <span style="font-size:13px; font-weight:600; color:var(--text-muted);">Khách hàng</span>
                <div style="width:40px; height:40px; border-radius:10px; background:rgba(234,179,8,0.15); color:#fde047; display:flex; align-items:center; justify-content:center; font-size:18px;">🛍️</div>
            </div>
            <div style="font-size:28px; font-weight:700; color:var(--text-primary);">{{ $stats['total_customers'] }}</div>
            <div style="font-size:12px; color:var(--text-muted); margin-top:4px;">Số tài khoản khách đăng ký mua hàng</div>
        </div>
    </div>

    <!-- HÀNG BẢNG DANH SÁCH SẢN PHẨM VÀ NHẬT KÝ HOẠT ĐỘNG -->
    <div class="grid-2" style="gap:24px; align-items:start;">
        
        <!-- BẢNG SẢN PHẨM MỚI -->
        <div class="card">
            <div class="card-header" style="display:flex; justify-content:space-between; align-items:center;">
                <div class="card-title"><i class="fas fa-box" style="color:var(--accent);"></i> Sản phẩm mới cập nhật</div>
                <a href="{{ route('products.index') }}" style="font-size:12px; color:var(--accent); text-decoration:none;">Xem tất cả →</a>
            </div>
            <div class="card-body" style="padding:0;">
                <table class="table" style="margin:0;">
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Danh mục</th>
                            <th>Giá</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($stats['recent_products'] as $p)
                            <tr>
                                <td>
                                    <div style="display:flex; align-items:center; gap:10px;">
                                        <img src="{{ $p->primary_image_url }}" style="width:36px; height:36px; border-radius:8px; object-fit:cover;">
                                        <span style="font-weight:600; color:var(--text-primary);">{{ $p->name }}</span>
                                    </div>
                                </td>
                                <td><span class="badge" style="background:rgba(255,255,255,0.06); color:var(--text-muted);">{{ optional($p->category)->name ?? 'Chưa phân loại' }}</span></td>
                                <td style="color:var(--accent); font-weight:600;">{{ number_format($p->price, 0, ',', '.') }}₫</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" style="text-align:center; color:var(--text-muted);">Chưa có sản phẩm nào</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- BẢNG NHẬT KÝ HOẠT ĐỘNG GẦN ĐÂY -->
        <div class="card">
            <div class="card-header" style="display:flex; justify-content:space-between; align-items:center;">
                <div class="card-title"><i class="fas fa-history" style="color:var(--accent);"></i> Nhật ký hoạt động mới nhất</div>
                @if (!auth()->user()->isStaff())
                    <a href="{{ route('activity-logs.index') }}" style="font-size:12px; color:var(--accent); text-decoration:none;">Xem log →</a>
                @endif
            </div>
            <div class="card-body" style="padding:16px;">
                <div style="display:flex; flex-direction:column; gap:12px;">
                    @forelse ($stats['recent_logs'] as $log)
                        <div style="display:flex; align-items:flex-start; gap:10px; padding-bottom:10px; border-bottom:1px solid rgba(255,255,255,0.04);">
                            <div style="width:28px; height:28px; border-radius:50%; background:rgba(56,189,248,0.15); color:var(--accent); display:flex; align-items:center; justify-content:center; font-size:12px; flex-shrink:0;">
                                <i class="fas fa-user"></i>
                            </div>
                            <div style="flex:1;">
                                <div style="font-size:13px; color:var(--text-primary); font-weight:500;">
                                    <strong>{{ optional($log->user)->name ?? 'Hệ thống' }}</strong>: {{ $log->description }}
                                </div>
                                <div style="font-size:11px; color:var(--text-muted); margin-top:2px;">
                                    {{ $log->created_at ? $log->created_at->diffForHumans() : '' }}
                                </div>
                            </div>
                        </div>
                    @empty
                        <div style="text-align:center; color:var(--text-muted); padding:20px 0;">Chưa có nhật ký hoạt động nào.</div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
