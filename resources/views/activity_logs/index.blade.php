@extends('layouts.admin')

@section('title', 'Lịch sử hoạt động')

@section('breadcrumb')
    <span>Công cụ</span> / Lịch sử hoạt động
@endsection

@section('content')
<div style="max-width:1200px; margin:0 auto;">

    <div class="card">
        <div class="card-header" style="flex-direction:column; align-items:stretch; gap:16px;">
            <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px;">
                <div class="card-title">
                    📜 Lịch Sử Hoạt Động Hệ Thống
                    <span style="font-size:12px; background:rgba(56,189,248,0.15); color:var(--accent-light); padding:2px 10px; border-radius:20px;">
                        {{ $logs->total() }} nhật ký
                    </span>
                </div>
            </div>

            {{-- BỘ LỌC --}}
            <form action="{{ route('activity-logs.index') }}" method="GET" style="background:rgba(0,0,0,0.2); padding:12px 16px; border-radius:12px; border:1px solid var(--border);">
                <div style="display:flex; gap:10px; flex-wrap:wrap; align-items:center;">
                    <div style="flex:1; min-width:220px;">
                        <input type="text" name="search" class="form-control"
                               placeholder="🔍 Tìm theo mô tả, tên người thực hiện, email..."
                               value="{{ request('search') }}" style="padding:8px 14px; font-size:13px;">
                    </div>
                    <div style="min-width:160px;">
                        <select name="action" class="form-control" style="padding:8px 14px; font-size:13px;">
                            <option value="">-- Tất cả hành động --</option>
                            <option value="login" {{ request('action') == 'login' ? 'selected' : '' }}>🔑 Đăng nhập</option>
                            <option value="create_product" {{ request('action') == 'create_product' ? 'selected' : '' }}>👠 Tạo sản phẩm</option>
                            <option value="update_product" {{ request('action') == 'update_product' ? 'selected' : '' }}>✏️ Sửa sản phẩm</option>
                            <option value="trash_product" {{ request('action') == 'trash_product' ? 'selected' : '' }}>🗑️ Xoá sản phẩm</option>
                            <option value="create_user" {{ request('action') == 'create_user' ? 'selected' : '' }}>👤 Tạo người dùng</option>
                            <option value="update_user" {{ request('action') == 'update_user' ? 'selected' : '' }}>📝 Sửa người dùng</option>
                        </select>
                    </div>
                    <div style="display:flex; gap:6px;">
                        <button type="submit" class="btn btn-primary" style="padding:8px 16px; font-size:13px;">
                            <i class="fas fa-filter"></i> Lọc
                        </button>
                        @if (request()->hasAny(['search', 'action']))
                            <a href="{{ route('activity-logs.index') }}" class="btn btn-outline" style="padding:8px 14px; font-size:13px; color:var(--danger); border-color:rgba(239,68,68,0.3);">
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
                        <th style="min-width:160px;">Người thực hiện</th>
                        <th style="min-width:140px;">Hành động</th>
                        <th style="min-width:250px;">Mô tả chi tiết</th>
                        <th style="white-space:nowrap;">Địa chỉ IP</th>
                        <th style="white-space:nowrap;">Thời gian</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($logs as $log)
                    <tr>
                        <td style="color:var(--text-muted);">{{ ($logs->currentPage() - 1) * $logs->perPage() + $loop->iteration }}</td>
                        <td>
                            @if ($log->user)
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <img src="{{ $log->user->avatar_url }}" style="width:28px; height:28px; border-radius:50%; object-fit:cover;">
                                    <div>
                                        <strong style="font-size:13px;">{{ $log->user->name }}</strong>
                                        <span style="display:block; font-size:11px; color:var(--text-muted);">{{ $log->user->email }}</span>
                                    </div>
                                </div>
                            @else
                                <span style="color:var(--text-muted);">Hệ thống / Ẩn danh</span>
                            @endif
                        </td>
                        <td style="white-space:nowrap;">
                            <span style="background:rgba(56,189,248,0.12); color:var(--accent-light); border:1px solid rgba(56,189,248,0.25); padding:3px 10px; border-radius:12px; font-size:11px; font-weight:600; font-family:monospace;">
                                {{ $log->action }}
                            </span>
                        </td>
                        <td style="font-size:13px; color:var(--text-primary);">
                            {{ $log->description }}
                        </td>
                        <td style="font-size:12px; font-family:monospace; color:var(--text-muted); white-space:nowrap;">
                            {{ $log->ip_address ?? '127.0.0.1' }}
                        </td>
                        <td style="font-size:12px; color:var(--text-muted); white-space:nowrap;">
                            <i class="fas fa-clock" style="font-size:10px; margin-right:4px;"></i>
                            {{ $log->created_at ? $log->created_at->format('d/m/Y H:i:s') : '—' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align:center; padding:40px; color:var(--text-muted);">
                            <div style="font-size:40px; margin-bottom:12px;">📜</div>
                            Chưa có nhật ký hoạt động nào.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($logs->hasPages())
        <div style="padding:16px 24px; border-top:1px solid var(--border);">
            {{ $logs->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
