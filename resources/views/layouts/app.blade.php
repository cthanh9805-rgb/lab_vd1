<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'HEEL BOUTIQUE - Giày Cao Gót Nữ Sang Trọng')</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts: Inter & Playfair Display for Luxury Boutique -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,600;0,700;1,400&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --bg-light: #fafafa;
            --bg-white: #ffffff;
            --rose-gold: #c87a6b;
            --rose-gold-dark: #b85d4b;
            --text-dark: #1e293b;
            --text-muted: #64748b;
            --border-light: #f1f5f9;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-light);
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* NAVBAR BOUTIQUE */
        .navbar-boutique {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid #e2e8f0;
            padding: 16px 0;
        }

        .navbar-brand-boutique {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 1.5rem;
            letter-spacing: 2px;
            color: var(--text-dark) !important;
            text-transform: uppercase;
        }

        .nav-link-boutique {
            color: var(--text-dark) !important;
            font-weight: 500;
            font-size: 0.95rem;
            margin: 0 10px;
            transition: color 0.2s;
        }

        .nav-link-boutique:hover, .nav-link-boutique.active {
            color: var(--rose-gold) !important;
        }

        .btn-rose-gold {
            background-color: var(--rose-gold);
            color: #ffffff !important;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            padding: 10px 24px;
            transition: all 0.25s;
            box-shadow: 0 4px 14px rgba(200, 122, 107, 0.3);
        }

        .btn-rose-gold:hover {
            background-color: var(--rose-gold-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(200, 122, 107, 0.4);
        }

        /* CARD SHOWCASE */
        .card-boutique {
            background: #ffffff;
            border: 1px solid #f1f5f9;
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        }

        .card-boutique:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 30px rgba(0,0,0,0.08);
            border-color: #e2e8f0;
        }

        /* FOOTER */
        footer {
            margin-top: auto;
            background: #ffffff;
            border-top: 1px solid #e2e8f0;
            padding: 32px 0 24px 0;
            color: var(--text-muted);
            font-size: 0.875rem;
        }
    </style>
    @yield('styles')
</head>
<body>

    <!-- NAVBAR HEADER HEEL BOUTIQUE -->
    <nav class="navbar navbar-expand-lg navbar-boutique sticky-top">
        <div class="container">
            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarBoutique">
                <i class="fas fa-bars fs-4 text-dark"></i>
            </button>

            <a class="navbar-brand navbar-brand-boutique mx-auto mx-lg-0" href="{{ route('welcome') }}">
                👠 HEEL BOUTIQUE
            </a>

            <div class="collapse navbar-collapse" id="navbarBoutique">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link nav-link-boutique {{ request()->routeIs('welcome') ? 'active' : '' }}" href="{{ route('welcome') }}">Trang Chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-boutique" href="{{ route('welcome') }}">Bộ Sưu Tập</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-boutique" href="{{ route('welcome') }}">Giày Cao Gót</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-boutique" href="{{ route('welcome') }}">Sandal & Bốt</a>
                    </li>
                </ul>
            </div>

            <!-- ACTION ICONS -->
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('welcome') }}" class="text-dark text-decoration-none" title="Tìm kiếm">
                    <i class="fas fa-search fs-5"></i>
                </a>
                <a href="#" class="text-dark text-decoration-none position-relative" title="Giỏ hàng">
                    <i class="fas fa-shopping-bag fs-5"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size:10px;">2</span>
                </a>

                @guest
                    <a href="{{ route('login') }}" class="btn btn-outline-dark btn-sm rounded-3 px-3 ms-2 fw-semibold">Đăng Nhập</a>
                    <a href="{{ route('register') }}" class="btn btn-rose-gold btn-sm rounded-3 px-3 fw-semibold">Đăng Ký</a>
                @else
                    @if (auth()->user()->hasAdminAccess())
                        <a class="btn btn-dark btn-sm rounded-3 px-3 fw-semibold me-2" href="{{ route('admin.dashboard') }}">
                            👑 Trang Quản Trị
                        </a>
                    @endif
                    <div class="dropdown">
                        <a href="#" class="text-dark text-decoration-none dropdown-toggle d-flex align-items-center gap-2" data-bs-toggle="dropdown">
                            <img src="{{ auth()->user()->avatar_url }}" style="width:32px; height:32px; border-radius:50%; object-fit:cover; border:1px solid #cbd5e1;">
                            <span class="fw-semibold text-dark d-none d-md-inline" style="font-size:14px;">{{ auth()->user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2">
                            @if (auth()->user()->hasAdminAccess())
                                <li><a class="dropdown-item" href="{{ route('profile.show') }}"><i class="fas fa-user me-2"></i>Hồ sơ cá nhân</a></li>
                                <li><hr class="dropdown-divider"></li>
                            @endif
                            <li>
                                <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt me-2"></i>Đăng xuất
                                </a>
                            </li>
                        </ul>
                    </div>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @endguest
            </div>
        </div>
    </nav>

    <!-- CONTENT -->
    <main>
        @yield('content')
    </main>

    <!-- FOOTER BOUTIQUE -->
    <footer>
        <div class="container">
            <div class="row g-4 mb-4 text-start">
                <div class="col-md-4">
                    <h5 class="navbar-brand-boutique fs-5 mb-3">HEEL BOUTIQUE</h5>
                    <p class="text-muted small">Thương hiệu giày cao gót sang trọng và quý phái hàng đầu. Tôn vinh vẻ đẹp quyến rũ của phái đẹp Việt Nam.</p>
                </div>
                <div class="col-md-3">
                    <h6 class="fw-bold mb-3">DANH MỤC SẢN PHẨM</h6>
                    <ul class="list-unstyled small text-muted">
                        <li class="mb-2"><a href="{{ route('welcome') }}" class="text-decoration-none text-muted">Giày cao gót mũi nhọn</a></li>
                        <li class="mb-2"><a href="{{ route('welcome') }}" class="text-decoration-none text-muted">Sandal cao gót thanh lịch</a></li>
                        <li class="mb-2"><a href="{{ route('welcome') }}" class="text-decoration-none text-muted">Giày bốt thời trang thu đông</a></li>
                    </ul>
                </div>
                <div class="col-md-5">
                    <h6 class="fw-bold mb-3">ĐĂNG KÝ NHẬN TƯ VẤN</h6>
                    <div class="input-group mb-3">
                        <input type="email" class="form-control rounded-start-3" placeholder="Nhập email của bạn...">
                        <button class="btn btn-rose-gold rounded-end-3" type="button">Đăng Ký</button>
                    </div>
                </div>
            </div>
            <hr class="my-4 text-muted">
            <p class="mb-0 text-center text-muted small">&copy; {{ date('Y') }} HEEL BOUTIQUE. Tất cả quyền được bảo lưu.</p>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
