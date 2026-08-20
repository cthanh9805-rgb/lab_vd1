<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') – Giày Cao Gót</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg-main: #0f172a;
            --bg-sidebar: #1e293b;
            --bg-card: #1e293b;
            --bg-input: #0f172a;
            --accent: #38bdf8;
            --accent-light: #7dd3fc;
            --accent-dark: #0284c7;
            --text-primary: #f8fafc;
            --text-secondary: #cbd5e1;
            --text-muted: #64748b;
            --border: #334155;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --info: #38bdf8;
            --sidebar-width: 250px;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-main);
            color: var(--text-primary);
            min-height: 100vh;
            display: flex;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: var(--sidebar-width);
            background: var(--bg-sidebar);
            border-right: 1px solid var(--border);
            min-height: 100vh;
            position: fixed;
            top: 0; left: 0;
            display: flex;
            flex-direction: column;
            z-index: 100;
        }

        .sidebar-logo {
            padding: 24px 20px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sidebar-logo .logo-icon {
            width: 42px; height: 42px;
            background: linear-gradient(135deg, var(--accent), var(--accent-dark));
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px;
            box-shadow: 0 4px 15px rgba(56,189,248,0.35);
        }

        .sidebar-logo .logo-text {
            font-size: 16px;
            font-weight: 700;
            background: linear-gradient(135deg, var(--accent-light), #fff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            line-height: 1.2;
        }
        .sidebar-logo .logo-text small {
            display: block;
            font-size: 10px;
            font-weight: 400;
            -webkit-text-fill-color: var(--text-muted);
        }

        .sidebar-nav { padding: 16px 12px; flex: 1; }

        .nav-section-label {
            font-size: 10px; font-weight: 600; letter-spacing: 1.5px;
            color: var(--text-muted); text-transform: uppercase;
            padding: 0 8px; margin: 16px 0 8px;
        }

        .nav-item {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 12px; border-radius: 10px;
            color: var(--text-secondary); text-decoration: none;
            font-size: 14px; font-weight: 500;
            transition: all 0.2s ease; margin-bottom: 2px;
        }
        .nav-item:hover { background: rgba(56,189,248,0.1); color: var(--accent-light); }
        .nav-item.active {
            background: linear-gradient(135deg, rgba(56,189,248,0.2), rgba(99,102,241,0.15));
            color: var(--accent-light);
            border: 1px solid rgba(56,189,248,0.35);
            box-shadow: 0 0 15px rgba(56,189,248,0.15);
        }
        .nav-item .nav-icon {
            width: 32px; height: 32px; border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: 14px; background: rgba(255,255,255,0.05); flex-shrink: 0;
        }
        .nav-item.active .nav-icon {
            background: linear-gradient(135deg, var(--accent), var(--accent-dark));
            color: #fff;
        }

        .sidebar-footer {
            padding: 16px 20px; border-top: 1px solid var(--border);
            font-size: 12px; color: var(--text-muted); text-align: center;
        }

        /* ===== MAIN ===== */
        .main-content { margin-left: var(--sidebar-width); flex: 1; min-height: 100vh; display: flex; flex-direction: column; }

        .topbar {
            background: rgba(30,41,59,0.85); backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--border); padding: 14px 28px;
            display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 50;
        }
        .topbar-breadcrumb { font-size: 13px; color: var(--text-muted); }
        .topbar-breadcrumb span { color: var(--accent-light); }
        .topbar-right { display: flex; align-items: center; gap: 12px; }

        .content-area { padding: 28px; flex: 1; }

        /* ===== CARDS ===== */
        .card {
            background: var(--bg-card); border: 1px solid var(--border);
            border-radius: 16px; overflow: hidden;
        }
        .card-header {
            padding: 20px 24px; border-bottom: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
        }
        .card-title {
            font-size: 16px; font-weight: 600; color: var(--text-primary);
            display: flex; align-items: center; gap: 10px;
        }
        .card-body { padding: 24px; }

        /* ===== BUTTONS ===== */
        .btn {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 8px 16px; border-radius: 8px; font-size: 13px;
            font-weight: 500; border: none; cursor: pointer;
            text-decoration: none; transition: all 0.2s ease; white-space: nowrap;
        }
        .btn-primary {
            background: linear-gradient(135deg, var(--accent), var(--accent-dark));
            color: #fff; box-shadow: 0 4px 15px rgba(56,189,248,0.3);
        }
        .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(56,189,248,0.45); color: #fff; text-decoration: none; }
        .btn-outline { background: transparent; border: 1px solid var(--border); color: var(--text-secondary); }
        .btn-outline:hover { border-color: var(--accent); color: var(--accent-light); text-decoration: none; }

        .btn-info-sm { background: rgba(56,189,248,0.12); color: var(--info); border: 1px solid rgba(56,189,248,0.3); padding: 5px 10px; font-size: 12px; }
        .btn-info-sm:hover { background: rgba(56,189,248,0.22); color: var(--info); text-decoration: none; }
        .btn-warn-sm { background: rgba(245,158,11,0.12); color: var(--warning); border: 1px solid rgba(245,158,11,0.3); padding: 5px 10px; font-size: 12px; }
        .btn-warn-sm:hover { background: rgba(245,158,11,0.22); color: var(--warning); text-decoration: none; }
        .btn-danger-sm { background: rgba(239,68,68,0.12); color: var(--danger); border: 1px solid rgba(239,68,68,0.3); padding: 5px 10px; font-size: 12px; }
        .btn-danger-sm:hover { background: rgba(239,68,68,0.22); color: var(--danger); text-decoration: none; }

        /* ===== TABLE ===== */
        .admin-table { width: 100%; border-collapse: collapse; font-size: 14px; }
        .admin-table th {
            background: rgba(255,255,255,0.04); padding: 12px 16px;
            text-align: left; font-size: 11px; font-weight: 600;
            letter-spacing: 1px; text-transform: uppercase;
            color: var(--text-muted); border-bottom: 1px solid var(--border);
        }
        .admin-table td {
            padding: 14px 16px; border-bottom: 1px solid rgba(51,65,85,0.5);
            color: var(--text-secondary); vertical-align: middle;
        }
        .admin-table tr:last-child td { border-bottom: none; }
        .admin-table tr:hover td { background: rgba(56,189,248,0.04); }
        .admin-table td strong { color: var(--text-primary); font-weight: 500; }

        /* ===== BADGES ===== */
        .badge { display: inline-flex; align-items: center; gap: 4px; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; }
        .badge-success { background: rgba(16,185,129,0.15); color: var(--success); border: 1px solid rgba(16,185,129,0.3); }
        .badge-danger  { background: rgba(239,68,68,0.15);  color: var(--danger);  border: 1px solid rgba(239,68,68,0.3); }

        /* ===== ALERTS ===== */
        .alert { padding: 14px 18px; border-radius: 10px; font-size: 14px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }
        .alert-success { background: rgba(16,185,129,0.12); border: 1px solid rgba(16,185,129,0.3); color: var(--success); }
        .alert-danger  { background: rgba(239,68,68,0.12);  border: 1px solid rgba(239,68,68,0.3);  color: #f87171; }

        /* ===== FORMS ===== */
        .form-group { margin-bottom: 20px; }
        .form-label { display: block; font-size: 13px; font-weight: 500; color: var(--text-secondary); margin-bottom: 8px; }
        .form-label span { color: var(--danger); margin-left: 2px; }
        .form-control {
            width: 100%; background: var(--bg-input); border: 1px solid var(--border);
            border-radius: 8px; padding: 10px 14px; color: var(--text-primary);
            font-size: 14px; font-family: 'Inter', sans-serif;
            transition: border-color 0.2s, box-shadow 0.2s; outline: none;
        }
        .form-control:focus { border-color: var(--accent); box-shadow: 0 0 0 3px rgba(56,189,248,0.15); }
        .form-control::placeholder { color: var(--text-muted); }
        select.form-control option { background: var(--bg-card); }
        textarea.form-control { resize: vertical; min-height: 90px; }

        .input-group { display: flex; align-items: stretch; }
        .input-group .form-control { border-radius: 8px 0 0 8px; }
        .input-addon {
            background: var(--bg-card); border: 1px solid var(--border);
            border-left: none; border-radius: 0 8px 8px 0;
            padding: 10px 14px; color: var(--accent-light);
            font-weight: 600; font-size: 14px; display: flex; align-items: center;
        }

        /* ===== SIZE CHIPS ===== */
        .size-chips { display: flex; flex-wrap: wrap; gap: 8px; }
        .size-chips input[type=checkbox] { display: none; }
        .size-chip { padding: 6px 14px; border-radius: 20px; border: 1px solid var(--border); font-size: 13px; color: var(--text-secondary); cursor: pointer; transition: all 0.2s; }
        .size-chips input:checked + .size-chip {
            background: linear-gradient(135deg, var(--accent), var(--accent-dark));
            border-color: var(--accent); color: #fff; box-shadow: 0 2px 8px rgba(56,189,248,0.35);
        }

        /* ===== COLOR SWATCHES ===== */
        .color-swatches { display: flex; flex-wrap: wrap; gap: 10px; }
        .color-swatches input[type=checkbox] { display: none; }
        .color-swatch-label { cursor: pointer; text-align: center; }
        .color-dot { width: 32px; height: 32px; border-radius: 50%; border: 2px solid transparent; margin: 0 auto 4px; transition: all 0.2s; }
        .color-swatches input:checked + .color-swatch-label .color-dot { border-color: var(--accent-light); box-shadow: 0 0 0 3px rgba(56,189,248,0.3); }
        .color-swatch-label span { font-size: 11px; color: var(--text-muted); display: block; }

        /* ===== IMAGE UPLOAD ===== */
        .upload-zone {
            border: 2px dashed var(--border); border-radius: 12px;
            padding: 32px 20px; text-align: center; cursor: pointer;
            transition: all 0.3s; background: var(--bg-input);
        }
        .upload-zone:hover { border-color: var(--accent); background: rgba(56,189,248,0.04); }
        .upload-zone .upload-icon { font-size: 36px; color: var(--accent); margin-bottom: 10px; }
        .upload-zone p { color: var(--text-muted); font-size: 13px; }
        .upload-zone strong { color: var(--accent-light); }
        #imageInput { display: none; }
        .image-preview { margin-top: 12px; border-radius: 10px; overflow: hidden; border: 1px solid var(--border); display: none; }
        .image-preview img { width: 100%; max-height: 200px; object-fit: cover; display: block; }

        /* ===== TOGGLE ===== */
        .toggle-group { display: flex; align-items: center; gap: 12px; }
        .toggle-switch { width: 48px; height: 26px; background: var(--bg-input); border: 1px solid var(--border); border-radius: 13px; cursor: pointer; position: relative; transition: background 0.2s; }
        .toggle-switch::after { content: ''; position: absolute; top: 3px; left: 3px; width: 18px; height: 18px; background: var(--text-muted); border-radius: 50%; transition: all 0.2s; }
        #statusToggle:checked + .toggle-switch { background: linear-gradient(135deg, var(--accent), var(--accent-dark)); border-color: var(--accent); }
        #statusToggle:checked + .toggle-switch::after { left: 25px; background: #fff; }
        #statusToggle { display: none; }

        /* ===== PRODUCT IMG ===== */
        .product-img { width: 48px; height: 48px; border-radius: 8px; object-fit: cover; border: 1px solid var(--border); }
        .product-img-placeholder { width: 48px; height: 48px; border-radius: 8px; background: var(--bg-input); border: 1px solid var(--border); display: flex; align-items: center; justify-content: center; color: var(--text-muted); font-size: 18px; }

        /* ===== GRID ===== */
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; }

        /* ===== SHOW PAGE ===== */
        .detail-row { display: flex; gap: 12px; padding: 14px 0; border-bottom: 1px solid var(--border); }
        .detail-row:last-child { border-bottom: none; }
        .detail-label { font-size: 13px; color: var(--text-muted); min-width: 130px; }
        .detail-value { font-size: 14px; color: var(--text-primary); font-weight: 500; }
        .price-tag { font-size: 22px; font-weight: 700; background: linear-gradient(135deg, var(--accent), var(--accent-light)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
    </style>
    @yield('styles')
</head>
<body>

<!-- SIDEBAR -->
<aside class="sidebar">
    <div class="sidebar-logo">
        <div class="logo-icon">👠</div>
        <div class="logo-text">
            Heel Admin
            <small>Giày Cao Gót</small>
        </div>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section-label">Menu chính</div>
        <a href="{{ route('categories.index') }}"
           class="nav-item {{ request()->routeIs('categories.*') ? 'active' : '' }}">
            <div class="nav-icon"><i class="fas fa-tags"></i></div>
            <span>Danh mục</span>
        </a>
        <a href="{{ route('products.index') }}"
           class="nav-item {{ request()->routeIs('products.*') ? 'active' : '' }}">
            <div class="nav-icon">👠</div>
            <span>Sản phẩm</span>
        </a>
    </nav>

    <div class="sidebar-footer">
        &copy; {{ date('Y') }} Heel Admin
    </div>
</aside>

<!-- MAIN -->
<div class="main-content">
    <header class="topbar">
        <div class="topbar-breadcrumb">
            @yield('breadcrumb', '<span>Trang chủ</span>')
        </div>
        <div class="topbar-right">
            <span style="font-size:13px; color:var(--text-muted);">
                <i class="fas fa-circle" style="color:var(--success); font-size:8px;"></i> Online
            </span>
        </div>
    </header>

    <div class="content-area">
        @yield('content')
    </div>
</div>

@yield('scripts')
</body>
</html>
