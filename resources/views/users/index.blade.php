@extends('layouts.admin')

@section('title', 'Quản lý Người dùng')

@section('breadcrumb')
    <span>Người dùng</span> / Danh sách
@endsection

@section('content')

@if ($message = Session::get('success'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i> {{ $message }}
    </div>
@endif

@if ($message = Session::get('error'))
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-circle"></i> {{ $message }}
    </div>
@endif

{{-- 4 THẺ THỐNG KÊ (Mockup 1) --}}
<div style="display:grid; grid-template-columns:repeat(4, 1fr); gap:16px; margin-bottom:20px;">
    <div class="card" style="border-left:3px solid var(--accent);">
        <div class="card-body" style="padding:16px; display:flex; align-items:center; gap:14px;">
            <div style="width:44px; height:44px; border-radius:12px; background:rgba(56,189,248,0.12); display:flex; align-items:center; justify-content:center; font-size:20px;">👥</div>
            <div>
                <div style="font-size:22px; font-weight:700; color:var(--accent-light);">{{ $stats['total'] }}</div>
                <div style="font-size:11px; color:var(--text-muted); text-transform:uppercase; letter-spacing:1px;">Tổng người dùng</div>
            </div>
        </div>
    </div>
    <div class="card" style="border-left:3px solid #c084fc;">
        <div class="card-body" style="padding:16px; display:flex; align-items:center; gap:14px;">
            <div style="width:44px; height:44px; border-radius:12px; background:rgba(168,85,247,0.12); display:flex; align-items:center; justify-content:center; font-size:20px;">👑</div>
            <div>
                <div style="font-size:22px; font-weight:700; color:#c084fc;">{{ $stats['admins'] }}</div>
                <div style="font-size:11px; color:var(--text-muted); text-transform:uppercase; letter-spacing:1px;">Admin</div>
            </div>
        </div>
    </div>
    <div class="card" style="border-left:3px solid var(--success);">
        <div class="card-body" style="padding:16px; display:flex; align-items:center; gap:14px;">
            <div style="width:44px; height:44px; border-radius:12px; background:rgba(16,185,129,0.12); display:flex; align-items:center; justify-content:center; font-size:20px;">🛍️</div>
            <div>
                <div style="font-size:22px; font-weight:700; color:var(--success);">{{ $stats['customers'] }}</div>
                <div style="font-size:11px; color:var(--text-muted); text-transform:uppercase; letter-spacing:1px;">Khách hàng</div>
            </div>
        </div>
    </div>
    <div class="card" style="border-left:3px solid var(--danger);">
        <div class="card-body" style="padding:16px; display:flex; align-items:center; gap:14px;">
            <div style="width:44px; height:44px; border-radius:12px; background:rgba(239,68,68,0.12); display:flex; align-items:center; justify-content:center; font-size:20px;">🔒</div>
            <div>
                <div style="font-size:22px; font-weight:700; color:var(--danger);">{{ $stats['blocked'] }}</div>
                <div style="font-size:11px; color:var(--text-muted); text-transform:uppercase; letter-spacing:1px;">Bị khoá</div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header" style="flex-direction:column; align-items:stretch; gap:16px;">
        <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px;">
            <div class="card-title">
                👥 Quản Lý Người Dùng
                <span style="font-size:12px; background:rgba(56,189,248,0.15); color:var(--accent-light); padding:2px 10px; border-radius:20px;">
                    {{ $users->total() }} tài khoản
                </span>
            </div>
            <div style="display:flex; gap:8px;">
                <a href="{{ route('users.export') }}" class="btn btn-outline" style="color:var(--success); border-color:rgba(16,185,129,0.3);">
                    <i class="fas fa-file-csv"></i> Xuất Excel
                </a>
                <a href="{{ route('users.create') }}" class="btn btn-primary">
                    <i class="fas fa-user-plus"></i> Thêm người dùng
                </a>
            </div>
        </div>

        {{-- BỘ LỌC VÀ TÌM KIẾM (Mockup 1) --}}
        <form action="{{ route('users.index') }}" method="GET" style="background:rgba(0,0,0,0.2); padding:12px 16px; border-radius:12px; border:1px solid var(--border);">
            <div style="display:flex; gap:10px; flex-wrap:wrap; align-items:center;">
                <div style="flex:1; min-width:200px;">
                    <input type="text" name="search" class="form-control"
                           placeholder="🔍 Tìm theo tên, email, số điện thoại..."
                           value="{{ request('search') }}" style="padding:8px 14px; font-size:13px;">
                </div>
                <div style="min-width:150px;">
                    <select name="role" class="form-control" style="padding:8px 14px; font-size:13px;">
                        <option value="">-- Vai trò --</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>👑 Quản trị viên</option>
                        <option value="manager" {{ request('role') == 'manager' ? 'selected' : '' }}>👔 Quản lý</option>
                        <option value="staff" {{ request('role') == 'staff' ? 'selected' : '' }}>💼 Nhân viên</option>
                        <option value="customer" {{ request('role') == 'customer' ? 'selected' : '' }}>🛍️ Khách hàng</option>
                    </select>
                </div>
                <div style="min-width:140px;">
                    <select name="status" class="form-control" style="padding:8px 14px; font-size:13px;">
                        <option value="">-- Trạng thái --</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>✅ Hoạt động</option>
                        <option value="blocked" {{ request('status') == 'blocked' ? 'selected' : '' }}>🔒 Bị khoá</option>
                    </select>
                </div>
                <div style="min-width:140px;">
                    <select name="sort" class="form-control" style="padding:8px 14px; font-size:13px;">
                        <option value="">-- Sắp xếp --</option>
                        <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>🔤 Tên A→Z</option>
                        <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>🔤 Tên Z→A</option>
                        <option value="email_asc" {{ request('sort') == 'email_asc' ? 'selected' : '' }}>✉️ Email A→Z</option>
                    </select>
                </div>
                <div style="display:flex; gap:6px;">
                    <button type="submit" class="btn btn-primary" style="padding:8px 16px; font-size:13px;">
                        <i class="fas fa-filter"></i> Lọc
                    </button>
                    @if (request()->hasAny(['search', 'role', 'status', 'sort']))
                        <a href="{{ route('users.index') }}" class="btn btn-outline" style="padding:8px 14px; font-size:13px; color:var(--danger); border-color:rgba(239,68,68,0.3);">
                            <i class="fas fa-times"></i> Xoá lọc
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    {{-- BẢNG DỮ LIỆU (Mockup 1) --}}
    <div style="overflow-x: auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width:40px;">#</th>
                    <th style="width:50px;">Avatar</th>
                    <th style="min-width:160px;">Họ tên</th>
                    <th style="min-width:180px;">Email</th>
                    <th style="white-space:nowrap;">Số điện thoại</th>
                    <th style="white-space:nowrap;">Vai trò</th>
                    <th style="white-space:nowrap;">Trạng thái</th>
                    <th style="white-space:nowrap;">Ngày tạo</th>
                    <th style="width:160px; white-space:nowrap;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $u)
                <tr>
                    <td style="color:var(--text-muted);">{{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}</td>
                    <td>
                        <img src="{{ $u->avatar_url }}" alt="{{ $u->name }}" style="width:38px; height:38px; border-radius:50%; object-fit:cover; border:1px solid var(--border);">
                    </td>
                    <td><strong>{{ $u->name }}</strong></td>
                    <td style="font-size:13px; color:var(--text-secondary);">{{ $u->email }}</td>
                    <td style="font-size:13px; white-space:nowrap; color:var(--text-secondary);">
                        {{ $u->phone ?? '—' }}
                    </td>
                    <td style="white-space:nowrap;">
                        @php $b = $u->role_badge; @endphp
                        <span style="background:{{ $b['bg'] }}; color:{{ $b['color'] }}; border:1px solid {{ $b['border'] }}; padding:4px 12px; border-radius:12px; font-size:12px; font-weight:600;">
                            {{ $b['label'] }}
                        </span>
                    </td>
                    <td style="white-space:nowrap;">
                        @if ($u->status === 'active')
                            <span class="badge badge-success"><i class="fas fa-circle" style="font-size:6px;"></i> Hoạt động</span>
                        @else
                            <span class="badge badge-danger"><i class="fas fa-lock" style="font-size:10px;"></i> Bị khoá</span>
                        @endif
                    </td>
                    <td style="font-size:12px; color:var(--text-muted); white-space:nowrap;">
                        {{ $u->created_at ? $u->created_at->format('d/m/Y') : '—' }}
                    </td>
                    <td style="white-space:nowrap;">
                        <div style="display:flex; gap:6px;">
                            <a href="{{ route('users.show', $u->id) }}" class="btn btn-info-sm" title="Xem chi tiết">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('users.edit', $u->id) }}" class="btn btn-warn-sm" title="Sửa">
                                <i class="fas fa-pen"></i>
                            </a>
                            <form action="{{ route('users.toggleStatus', $u->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-outline" style="padding:5px 8px; font-size:12px; {{ $u->status === 'active' ? 'color:var(--danger); border-color:rgba(239,68,68,0.3);' : 'color:var(--success); border-color:rgba(16,185,129,0.3);' }}"
                                        title="{{ $u->status === 'active' ? 'Khoá tài khoản' : 'Kích hoạt tài khoản' }}">
                                    <i class="fas {{ $u->status === 'active' ? 'fa-lock' : 'fa-unlock' }}"></i>
                                </button>
                            </form>
                            <form action="{{ route('users.destroy', $u->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Bạn có chắc muốn xoá tài khoản này?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger-sm" title="Xoá">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" style="text-align:center; padding:40px; color:var(--text-muted);">
                        <div style="font-size:40px; margin-bottom:12px;">👤</div>
                        Không tìm thấy người dùng nào.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($users->hasPages())
    <div style="padding:16px 24px; border-top:1px solid var(--border);">
        {{ $users->links() }}
    </div>
    @endif
</div>

@endsection
