<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MyShop - Cửa Hàng Giày Cao Gót')</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --bg-dark: #0f172a;
            --bg-card: rgba(30, 41, 59, 0.7);
            --border-color: rgba(255, 255, 255, 0.1);
            --accent-cyan: #38bdf8;
            --text-main: #f8fafc;
            --text-sub: #94a3b8;
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-dark);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .navbar-custom {
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-color);
        }
        .navbar-brand {
            font-weight: 700;
            font-size: 1.25rem;
            color: var(--accent-cyan) !important;
        }
        .nav-link {
            color: var(--text-sub) !important;
            font-weight: 500;
            transition: color 0.2s;
        }
        .nav-link:hover, .nav-link.active {
            color: var(--text-main) !important;
        }
        .card-custom {
            background: var(--bg-card);
            backdrop-filter: blur(10px);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            transition: transform 0.25s, box-shadow 0.25s;
        }
        .card-custom:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 30px rgba(56, 189, 248, 0.15);
        }
        footer {
            margin-top: auto;
            border-top: 1px solid var(--border-color);
            padding: 24px 0;
            color: var(--text-sub);
            font-size: 0.875rem;
            text-align: center;
        }
    </style>
    @yield('styles')
</head>
<body>

    <!-- NAVBAR HƯỚNG DẪN LAB 03 -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom sticky-top py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('welcome') }}">
                <span>👠</span> MyShop
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('welcome') ? 'active' : '' }}" href="{{ route('welcome') }}">
                            <i class="fas fa-home me-1"></i> Trang chủ
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('products.show_normal') ? 'active' : '' }}" href="{{ route('welcome') }}">
                            <i class="fas fa-shoe-prints me-1"></i> Sản phẩm
                        </a>
                    </li>
                </ul>

                <ul class="navbar-nav ms-auto align-items-center gap-2">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">
                                <i class="fas fa-user-plus me-1"></i> Đăng ký
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-outline-info text-white btn-sm px-3" href="{{ route('login') }}" style="border-radius: 8px;">
                                <i class="fas fa-sign-in-alt me-1"></i> Đăng nhập
                            </a>
                        </li>
                    @else
                        @if (auth()->user()->hasAdminAccess())
                            <li class="nav-item">
                                <a class="btn btn-warning btn-sm me-2 fw-semibold" href="{{ route('admin.dashboard') }}" style="border-radius: 8px;">
                                    👑 Trang Quản Trị
                                </a>
                            </li>
                        @endif
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center gap-2 text-white" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                <img src="{{ auth()->user()->avatar_url }}" style="width:28px; height:28px; border-radius:50%; object-fit:cover;">
                                <span>{{ auth()->user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end" style="border-color: var(--border-color);">
                                @if (auth()->user()->hasAdminAccess())
                                    <li><a class="dropdown-item" href="{{ route('profile.show') }}"><i class="fas fa-user-circle me-2"></i>Hồ sơ cá nhân</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                @endif
                                <li>
                                    <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt me-2"></i>Đăng xuất
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- CONTENT CONTAINER -->
    <main class="container my-4">
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer>
        <div class="container">
            <p class="mb-0">&copy; {{ date('Y') }} MyShop - Cửa Hàng Giày Cao Gót Sang Trọng. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
