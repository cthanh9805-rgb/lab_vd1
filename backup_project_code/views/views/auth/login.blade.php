<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập – Heel Admin</title>
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
            padding: 20px;
            background-image: 
                radial-gradient(at 0% 0%, rgba(56,189,248,0.12) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(168,85,247,0.1) 0px, transparent 50%);
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            background: rgba(30, 41, 59, 0.85);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 36px 32px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.4);
        }

        .login-brand {
            text-align: center;
            margin-bottom: 28px;
        }
        .login-brand .logo-icon {
            width: 56px; height: 56px;
            background: linear-gradient(135deg, #38bdf8, #0284c7);
            border-radius: 16px;
            display: inline-flex; align-items: center; justify-content: center;
            font-size: 26px; margin-bottom: 12px;
            box-shadow: 0 8px 25px rgba(56,189,248,0.35);
        }
        .login-brand h1 {
            font-size: 22px; font-weight: 700;
            background: linear-gradient(135deg, #7dd3fc, #fff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .login-brand p {
            font-size: 13px; color: #64748b; margin-top: 4px;
        }

        .form-group { margin-bottom: 20px; }
        .form-label { display: block; font-size: 13px; font-weight: 500; color: #cbd5e1; margin-bottom: 8px; }
        
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
            border-radius: 10px; padding: 12px 14px 12px 42px; color: #f8fafc;
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
            margin-top: 10px;
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
            text-align: center; margin-top: 24px; font-size: 12px; color: #64748b;
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="login-brand">
        <div class="logo-icon">👠</div>
        <h1>Heel Admin</h1>
        <p>Đăng nhập hệ thống quản trị sản phẩm & khách hàng</p>
    </div>

    @if ($errors->any())
        <div class="alert-error">
            <i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}
        </div>
    @endif

    @if ($message = Session::get('success'))
        <div class="alert-success">
            <i class="fas fa-check-circle"></i> {{ $message }}
        </div>
    @endif

    <form action="{{ route('login.post') }}" method="POST">
        @csrf

        <div class="form-group">
            <label class="form-label">Email đăng nhập</label>
            <div class="input-icon-wrap">
                <i class="fas fa-envelope left-icon"></i>
                <input type="email" name="email" class="form-control" placeholder="admin@heeladmin.com" value="{{ old('email', 'admin@heeladmin.com') }}" required autofocus>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Mật khẩu</label>
            <div class="input-icon-wrap">
                <i class="fas fa-lock left-icon"></i>
                <input type="password" name="password" id="passInput" class="form-control" placeholder="••••••••" value="12345678" required>
                <i class="fas fa-eye right-icon" onclick="togglePass('passInput', this)"></i>
            </div>
        </div>

        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:20px; font-size:13px;">
            <label style="display:flex; align-items:center; gap:8px; cursor:pointer; color:#cbd5e1;">
                <input type="checkbox" name="remember" value="1" checked style="accent-color:#38bdf8;">
                <span>Ghi nhớ đăng nhập</span>
            </label>
            <a href="#" style="color:#7dd3fc; text-decoration:none;" onclick="alert('Vui lòng liên hệ Admin hệ thống để khôi phục mật khẩu.')">Quên mật khẩu?</a>
        </div>

        <button type="submit" class="btn-submit">
            <i class="fas fa-sign-in-alt" style="margin-right:6px;"></i> Đăng Nhập
        </button>
    </form>

    <div class="footer-note">
        &copy; {{ date('Y') }} Heel Admin. Bảo mật 256-bit SSL.
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
