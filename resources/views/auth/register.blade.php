<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký tài khoản – Heel Boutique</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', sans-serif;
            background: #0f172a;
            color: #f8fafc;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px 20px;
            background-image: 
                radial-gradient(at 0% 0%, rgba(56,189,248,0.12) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(168,85,247,0.1) 0px, transparent 50%);
        }

        .auth-card {
            width: 100%;
            max-width: 440px;
            background: rgba(30, 41, 59, 0.85);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 36px 32px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.4);
        }

        .auth-brand {
            text-align: center;
            margin-bottom: 24px;
        }
        .auth-brand .logo-icon {
            width: 56px; height: 56px;
            background: linear-gradient(135deg, #38bdf8, #0284c7);
            border-radius: 16px;
            display: inline-flex; align-items: center; justify-content: center;
            font-size: 26px; margin-bottom: 12px;
            box-shadow: 0 8px 25px rgba(56,189,248,0.35);
        }
        .auth-brand h1 {
            font-size: 22px; font-weight: 700;
            background: linear-gradient(135deg, #7dd3fc, #fff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .auth-brand p {
            font-size: 13px; color: #64748b; margin-top: 4px;
        }

        .form-group { margin-bottom: 16px; }
        .form-label { display: block; font-size: 13px; font-weight: 500; color: #cbd5e1; margin-bottom: 6px; }
        
        .input-icon-wrap { position: relative; }
        .input-icon-wrap i.left-icon {
            position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
            color: #64748b; font-size: 15px;
        }
        .input-icon-wrap i.right-icon {
            position: absolute; right: 14px; top: 50%; transform: translateY(-50%);
            color: #64748b; font-size: 15px; cursor: pointer;
        }
        .form-control {
            width: 100%; background: #0f172a; border: 1px solid #334155;
            border-radius: 10px; padding: 11px 14px 11px 42px; color: #f8fafc;
            font-size: 14px; outline: none; transition: all 0.2s;
        }
        .form-control:focus {
            border-color: #38bdf8; box-shadow: 0 0 0 3px rgba(56,189,248,0.15);
        }

        .btn-submit {
            width: 100%; padding: 12px; border-radius: 10px; border: none;
            background: linear-gradient(135deg, #38bdf8, #0284c7);
            color: #fff; font-size: 15px; font-weight: 600; cursor: pointer;
            box-shadow: 0 4px 20px rgba(56,189,248,0.35); transition: all 0.2s;
            margin-top: 8px;
        }
        .btn-submit:hover {
            transform: translateY(-1px); box-shadow: 0 6px 25px rgba(56,189,248,0.5);
        }

        .alert-error {
            background: rgba(239,68,68,0.15); border: 1px solid rgba(239,68,68,0.3);
            color: #f87171; padding: 12px; border-radius: 10px; font-size: 13px;
            margin-bottom: 20px;
        }
        .alert-success {
            background: rgba(16,185,129,0.15); border: 1px solid rgba(16,185,129,0.3);
            color: #10b981; padding: 12px; border-radius: 10px; font-size: 13px;
            margin-bottom: 20px;
        }

        .footer-note {
            text-align: center; margin-top: 20px; font-size: 12px; color: #64748b;
        }
    </style>
</head>
<body>

<div class="auth-card">
    <div class="auth-brand">
        <div class="logo-icon">👠</div>
        <h1>Tạo Tài Khoản Khách Hàng</h1>
        <p>Trải nghiệm mua sắm tuyệt vời tại Heel Boutique</p>
    </div>

    @if ($errors->any())
        <div class="alert-error">
            <i class="fas fa-exclamation-circle me-1"></i> {{ $errors->first() }}
        </div>
    @endif

    @if (session('success'))
        <div class="alert-success">
            <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('register') }}" method="POST">
        @csrf

        <div class="form-group">
            <label class="form-label">Họ và Tên <span style="color:#ef4444;">*</span></label>
            <div class="input-icon-wrap">
                <i class="fas fa-user left-icon"></i>
                <input type="text" name="name" class="form-control" placeholder="Nhập họ và tên..." value="{{ old('name') }}" required autofocus>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Địa chỉ Email <span style="color:#ef4444;">*</span></label>
            <div class="input-icon-wrap">
                <i class="fas fa-envelope left-icon"></i>
                <input type="email" name="email" class="form-control" placeholder="name@example.com" value="{{ old('email') }}" required>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Số Điện Thoại</label>
            <div class="input-icon-wrap">
                <i class="fas fa-phone left-icon"></i>
                <input type="text" name="phone" class="form-control" placeholder="0912345678" value="{{ old('phone') }}">
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Mật khẩu (Tối thiểu 6 ký tự) <span style="color:#ef4444;">*</span></label>
            <div class="input-icon-wrap">
                <i class="fas fa-lock left-icon"></i>
                <input type="password" name="password" id="passInput" class="form-control" placeholder="••••••••" required>
                <i class="fas fa-eye right-icon" onclick="togglePass('passInput', this)"></i>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Xác nhận mật khẩu <span style="color:#ef4444;">*</span></label>
            <div class="input-icon-wrap">
                <i class="fas fa-lock left-icon"></i>
                <input type="password" name="password_confirmation" id="passConfirmInput" class="form-control" placeholder="••••••••" required>
                <i class="fas fa-eye right-icon" onclick="togglePass('passConfirmInput', this)"></i>
            </div>
        </div>

        <button type="submit" class="btn-submit">
            <i class="fas fa-user-plus" style="margin-right:6px;"></i> Đăng Ký Tài Khoản
        </button>
    </form>

    <div style="text-align:center; margin-top:20px; font-size:13px; color:#94a3b8;">
        Đã có tài khoản? <a href="{{ route('login') }}" style="color:#38bdf8; text-decoration:none; font-weight:600;">Đăng nhập ngay</a>
    </div>

    <div class="footer-note">
        &copy; {{ date('Y') }} Heel Boutique. Bảo mật 256-bit SSL.
    </div>
</div>

<script>
function togglePass(id, icon) {
    const input = document.getElementById(id);
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
</script>
</body>
</html>
