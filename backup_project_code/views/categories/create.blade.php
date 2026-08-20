@extends('layouts.admin')

@section('title', 'Thêm danh mục')

@section('breadcrumb')
    <a href="{{ route('categories.index') }}" style="color:var(--accent-light); text-decoration:none;">Danh mục</a>
    / <span>Thêm mới</span>
@endsection

@section('content')
<div style="max-width:500px;">
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:24px;">
        <h1 style="font-size:22px; font-weight:700; color:var(--text-primary);">🏷️ Thêm Danh Mục Mới</h1>
        <a href="{{ route('categories.index') }}" class="btn btn-outline">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <div>
                <i class="fas fa-exclamation-triangle"></i>
                <strong>Vui lòng kiểm tra lại:</strong>
                <ul style="margin:8px 0 0 16px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <div class="card-title"><i class="fas fa-plus-circle" style="color:var(--accent);"></i> Thông tin danh mục</div>
        </div>
        <div class="card-body">
            <form action="{{ route('categories.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">Tên danh mục <span>*</span></label>
                    <input type="text" name="name" class="form-control"
                           placeholder="VD: Cao Gót Classic, Sandal, Boot..."
                           value="{{ old('name') }}" required>
                </div>
                <div style="display:flex; gap:12px; margin-top:8px;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Lưu danh mục
                    </button>
                    <a href="{{ route('categories.index') }}" class="btn btn-outline">Huỷ</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection