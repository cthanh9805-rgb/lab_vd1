<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    private function checkPermission()
    {
        if (auth()->user()->isStaff()) {
            return redirect()->route('products.index')
                ->with('error', '⛔ Tài khoản Nhân viên (Staff) không có quyền truy cập hoặc quản lý Người dùng!');
        }
        return null;
    }

    public function index(Request $request)
    {
        if ($redirect = $this->checkPermission()) return $redirect;

        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $sortField = 'created_at';
        $sortDir = 'desc';
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'name_asc':  $sortField = 'name'; $sortDir = 'asc'; break;
                case 'name_desc': $sortField = 'name'; $sortDir = 'desc'; break;
                case 'email_asc': $sortField = 'email'; $sortDir = 'asc'; break;
                default:          $sortField = 'created_at'; $sortDir = 'desc'; break;
            }
        }

        $users = $query->orderBy($sortField, $sortDir)->paginate(10)->withQueryString();

        $stats = [
            'total'     => User::count(),
            'admins'    => User::where('role', 'admin')->count(),
            'managers'  => User::where('role', 'manager')->count(),
            'staff'     => User::where('role', 'staff')->count(),
            'customers' => User::where('role', 'customer')->count(),
            'blocked'   => User::where('status', 'blocked')->count(),
        ];

        return view('users.index', compact('users', 'stats'));
    }

    public function create()
    {
        if ($redirect = $this->checkPermission()) return $redirect;
        return view('users.create');
    }

    public function store(Request $request)
    {
        if ($redirect = $this->checkPermission()) return $redirect;

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users',
            'phone'    => 'nullable|string|max:20',
            'password' => 'required|string|min:6|confirmed',
            'role'     => 'required|in:admin,manager,staff,customer',
            'status'   => 'required|in:active,blocked',
            'address'  => 'nullable|string',
            'city'     => 'nullable|string|max:100',
            'avatar'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // CHỈ QUẢN TRỊ VIÊN MỚI ĐƯỢC TẠO TÀI KHOẢN QUẢN TRỊ VIÊN KHÁC
        if ($request->role === 'admin' && !auth()->user()->isAdmin()) {
            return back()->withInput()->with('error', 'Chỉ Quản trị viên (Admin) mới có quyền tạo tài khoản Quản trị viên khác!');
        }

        $data = $request->only(['name', 'email', 'phone', 'role', 'status', 'address', 'city']);
        $data['password'] = Hash::make($request->password);

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $avatarName = time() . '_' . $avatar->getClientOriginalName();
            $avatar->move(public_path('images/avatars'), $avatarName);
            $data['avatar'] = 'images/avatars/' . $avatarName;
        }

        $user = User::create($data);
        ActivityLog::record('create_user', 'Đã thêm người dùng mới "' . $user->name . '" (' . $user->role . ')');

        return redirect()->route('users.index')
            ->with('success', 'Đã thêm người dùng thành công! 👤');
    }

    public function show(User $user)
    {
        if ($redirect = $this->checkPermission()) return $redirect;
        $user->load('addresses', 'activityLogs');
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        if ($redirect = $this->checkPermission()) return $redirect;

        // Quản lý không được sửa tài khoản Quản trị viên (Admin)
        if ($user->isAdmin() && !auth()->user()->isAdmin()) {
            return redirect()->route('users.index')->with('error', 'Chỉ Quản trị viên mới có quyền chỉnh sửa tài khoản Quản trị viên!');
        }

        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if ($redirect = $this->checkPermission()) return $redirect;

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone'    => 'nullable|string|max:20',
            'password' => 'nullable|string|min:6|confirmed',
            'role'     => 'required|in:admin,manager,staff,customer',
            'status'   => 'required|in:active,blocked',
            'address'  => 'nullable|string',
            'city'     => 'nullable|string|max:100',
            'avatar'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Không cho tự hạ cấp role hoặc khoá tài khoản đang đăng nhập
        if ($user->id === auth()->id()) {
            if (!in_array($request->role, ['admin', 'manager'])) {
                return back()->withInput()->with('error', 'Bạn không thể tự hạ cấp vai trò của chính mình!');
            }
            if ($request->status !== 'active') {
                return back()->withInput()->with('error', 'Bạn không thể tự khoá tài khoản của chính mình!');
            }
        }

        // Quản lý không được sửa hoặc gán vai trò Quản trị viên (Admin)
        if (($user->isAdmin() || $request->role === 'admin') && !auth()->user()->isAdmin()) {
            return back()->withInput()->with('error', 'Chỉ Quản trị viên mới có quyền gán hoặc chỉnh sửa tài khoản Quản trị viên!');
        }

        $data = $request->only(['name', 'email', 'phone', 'role', 'status', 'address', 'city']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('avatar')) {
            if ($user->avatar && !str_starts_with($user->avatar, 'http') && file_exists(public_path($user->avatar))) {
                unlink(public_path($user->avatar));
            }
            $avatar = $request->file('avatar');
            $avatarName = time() . '_' . $avatar->getClientOriginalName();
            $avatar->move(public_path('images/avatars'), $avatarName);
            $data['avatar'] = 'images/avatars/' . $avatarName;
        }

        $user->update($data);
        ActivityLog::record('update_user', 'Đã cập nhật thông tin người dùng "' . $user->name . '"');

        return redirect()->route('users.index')
            ->with('success', 'Cập nhật thông tin người dùng thành công! ✨');
    }

    public function toggleStatus(User $user)
    {
        if ($redirect = $this->checkPermission()) return $redirect;

        if ($user->id === auth()->id()) {
            return back()->with('error', 'Bạn không thể tự khoá tài khoản đang đăng nhập của chính mình!');
        }

        if ($user->isAdmin() && !auth()->user()->isAdmin()) {
            return back()->with('error', 'Chỉ Quản trị viên mới có quyền khoá tài khoản Quản trị viên khác!');
        }

        $newStatus = $user->status === 'active' ? 'blocked' : 'active';
        $user->update(['status' => $newStatus]);

        $actionText = $newStatus === 'active' ? 'kích hoạt' : 'khoá';
        ActivityLog::record('toggle_user_status', 'Đã ' . $actionText . ' tài khoản "' . $user->name . '"');

        $msg = $newStatus === 'active' ? 'Đã kích hoạt tài khoản!' : 'Đã khoá tài khoản!';
        return back()->with('success', $msg);
    }

    public function destroy(User $user)
    {
        if ($redirect = $this->checkPermission()) return $redirect;

        if ($user->id === auth()->id()) {
            return back()->with('error', 'Bạn không thể xoá chính tài khoản đang đăng nhập!');
        }

        if ($user->isAdmin() && !auth()->user()->isAdmin()) {
            return back()->with('error', 'Chỉ Quản trị viên mới có quyền xoá tài khoản Quản trị viên!');
        }

        $userName = $user->name;

        if ($user->avatar && !str_starts_with($user->avatar, 'http') && file_exists(public_path($user->avatar))) {
            unlink(public_path($user->avatar));
        }

        $user->delete();
        ActivityLog::record('delete_user', 'Đã xoá người dùng "' . $userName . '"');

        return redirect()->route('users.index')
            ->with('success', 'Đã xoá người dùng thành công!');
    }

    public function export(Request $request)
    {
        if ($redirect = $this->checkPermission()) return $redirect;

        $users = User::orderBy('name')->get();
        $filename = 'nguoi_dung_' . date('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($users) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($file, [
                'STT', 'Họ tên', 'Email', 'Số điện thoại', 'Vai trò',
                'Địa chỉ', 'Thành phố', 'Trạng thái', 'Ngày tạo', 'Lần đăng nhập cuối'
            ]);

            foreach ($users as $i => $u) {
                fputcsv($file, [
                    $i + 1,
                    $u->name,
                    $u->email,
                    $u->phone ?? '—',
                    $u->role,
                    $u->address ?? '—',
                    $u->city ?? '—',
                    $u->status === 'active' ? 'Hoạt động' : 'Bị khoá',
                    $u->created_at ? $u->created_at->format('d/m/Y H:i') : '—',
                    $u->last_login_at ? $u->last_login_at->format('d/m/Y H:i') : 'Chưa từng',
                ]);
            }

            fclose($file);
        };

        ActivityLog::record('export_users', 'Đã xuất file CSV danh sách người dùng');

        return response()->stream($callback, 200, $headers);
    }
}
