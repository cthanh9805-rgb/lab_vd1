@extends('layouts.admin')

@section('title', 'Danh mục')

@section('breadcrumb')
    <span>Danh mục</span> / Danh sách
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

<div class="card">
    <div class="card-header">
        <div class="card-title">
            🏷️ Danh sách Danh mục
            <span style="font-size:12px; background:rgba(56,189,248,0.15); color:var(--accent-light); padding:2px 10px; border-radius:20px;">
                {{ count($categories) }} danh mục
            </span>
        </div>
        <a href="{{ route('categories.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Thêm danh mục
        </a>
    </div>

    <div style="overflow-x:auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width:60px;">#</th>
                    <th>Tên danh mục</th>
                    <th>Ngày tạo</th>
                    <th style="width:200px;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $index => $category)
                <tr>
                    <td style="color:var(--text-muted);">{{ $index + 1 }}</td>
                    <td><strong>{{ $category->name }}</strong></td>
                    <td style="color:var(--text-muted); font-size:13px;">
                        {{ $category->created_at->format('d/m/Y H:i') }}
                    </td>
                    <td>
                        <div style="display:flex; gap:6px;">
                            <a href="{{ route('categories.show', $category->id) }}" class="btn btn-info-sm">
                                <i class="fas fa-eye"></i> Xem
                            </a>
                            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warn-sm">
                                <i class="fas fa-pen"></i> Sửa
                            </a>
                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST"
                                  style="display:inline;" onsubmit="return confirm('Xoá danh mục này? Các sản phẩm liên quan cũng sẽ bị xoá!')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger-sm" style="cursor:pointer;">
                                    <i class="fas fa-trash"></i> Xoá
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align:center; padding:40px; color:var(--text-muted);">
                        <div style="font-size:40px; margin-bottom:12px;">🏷️</div>
                        Chưa có danh mục nào. <a href="{{ route('categories.create') }}" style="color:var(--accent-light);">Thêm ngay!</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection