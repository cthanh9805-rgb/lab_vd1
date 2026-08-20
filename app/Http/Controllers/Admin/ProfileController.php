<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function show()
    {
        $user = auth()->user();
        return view('profile.index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone'   => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'city'    => 'nullable|string|max:100',
            'avatar'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->only(['name', 'email', 'phone', 'address', 'city']);

        if ($request->hasFile('avatar')) {
            if ($user->avatar && !str_starts_with($user->avatar, 'http') && file_exists(public_path($user->avatar))) {
                unlink(public_path($user->avatar));
            }
            $avatar = $request->file('avatar');
            $avatarName = time() . '_profile_' . $avatar->getClientOriginalName();
            $avatar->move(public_path('images/avatars'), $avatarName);
            $data['avatar'] = 'images/avatars/' . $avatarName;
        }

        $user->update($data);
        ActivityLog::record('update_profile', 'Đã cập nhật thông tin cá nhân');

        return redirect()->route('profile.show')->with('success', 'Đã cập nhật thông tin cá nhân thành công! ✨');
    }

    public function updatePassword(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'current_password' => 'required|string',
            'password'         => 'required|string|min:6|confirmed',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không chính xác!']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        ActivityLog::record('change_password', 'Đã thay đổi mật khẩu tài khoản');

        return redirect()->route('profile.show')->with('success', 'Đã đổi mật khẩu thành công! 🔐');
    }
}
