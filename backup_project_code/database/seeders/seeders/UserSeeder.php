<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Xoá toàn bộ người dùng cũ để làm sạch database
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('user_addresses')->truncate();
        DB::table('users')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 1. Quản trị viên (Admin - 👑 Cấp cao nhất)
        User::create([
            'name' => 'Admin',
            'email' => 'admin@heeladmin.com',
            'phone' => '0987654321',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
            'address' => '123 Đường Lê Lợi, Phường Bến Nghé',
            'city' => 'TP. Hồ Chí Minh',
            'status' => 'active',
            'last_login_at' => now(),
        ]);

        // 2. Quản lý (quanli1 - 👔)
        User::create([
            'name' => 'quanli1',
            'email' => 'quanli1@gmail.com',
            'phone' => '0912345678',
            'password' => Hash::make('12345678'),
            'role' => 'manager',
            'address' => '45 Nguyễn Huệ',
            'city' => 'TP. Hồ Chí Minh',
            'status' => 'active',
            'last_login_at' => now()->subHours(1),
        ]);

        // 3. Nhân viên (nhanvien1 - 💼)
        User::create([
            'name' => 'nhanvien1',
            'email' => 'nhanvien1@gmail.com',
            'phone' => '0123456789',
            'password' => Hash::make('12345678'),
            'role' => 'staff',
            'address' => '88 Võ Văn Tần',
            'city' => 'TP. Hồ Chí Minh',
            'status' => 'active',
            'last_login_at' => now()->subHours(2),
        ]);

        // 4. Khách hàng (khach1 - 🛍️)
        $khach1 = User::create([
            'name' => 'khach1',
            'email' => 'khach1@gmail.com',
            'phone' => '0123456789',
            'password' => Hash::make('12345678'),
            'role' => 'customer',
            'address' => '12 Hàng Bài, Hoàn Kiếm',
            'city' => 'Hà Nội',
            'status' => 'active',
        ]);

        // Sổ địa chỉ cho khach1
        UserAddress::create([
            'user_id' => $khach1->id,
            'recipient_name' => 'khach1 (Nhà riêng)',
            'phone' => '0123456789',
            'address' => '12 Hàng Bài, Hoàn Kiếm',
            'city' => 'Hà Nội',
            'is_default' => true,
        ]);

        UserAddress::create([
            'user_id' => $khach1->id,
            'recipient_name' => 'khach1 (Cơ quan)',
            'phone' => '0123456789',
            'address' => 'Tầng 5, Tòa nhà Văn phòng Centec Tower',
            'city' => 'Hà Nội',
            'is_default' => false,
        ]);
    }
}
