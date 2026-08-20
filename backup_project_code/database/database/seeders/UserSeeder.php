<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin chính
        User::updateOrCreate(
            ['email' => 'admin@heeladmin.com'],
            [
                'name' => 'Nguyễn Văn Admin',
                'phone' => '0987654321',
                'password' => Hash::make('12345678'),
                'role' => 'admin',
                'address' => '123 Đường Lê Lợi, Phường Bến Nghé',
                'city' => 'TP. Hồ Chí Minh',
                'status' => 'active',
                'last_login_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'manager@heeladmin.com'],
            [
                'name' => 'Trần Thị Quản Lý',
                'phone' => '0912345678',
                'password' => Hash::make('12345678'),
                'role' => 'admin',
                'address' => '45 Nguyễn Huệ',
                'city' => 'TP. Hồ Chí Minh',
                'status' => 'active',
                'last_login_at' => now()->subHours(2),
            ]
        );

        // Khách hàng mẫu
        $customers = [
            [
                'name' => 'Phạm Minh Anh',
                'email' => 'minhanh@gmail.com',
                'phone' => '0971257299',
                'address' => '12 Hàng Bài, Hoàn Kiếm',
                'city' => 'Hà Nội',
                'status' => 'active',
            ],
            [
                'name' => 'Lê Thị Thu Thảo',
                'email' => 'thuthao@gmail.com',
                'phone' => '0971303943',
                'address' => '88 Trần Phú, Hải Châu',
                'city' => 'Đà Nẵng',
                'status' => 'active',
            ],
            [
                'name' => 'Hoàng Ngọc Định',
                'email' => 'ngocdinh@gmail.com',
                'phone' => '0971257342',
                'address' => '56 Nguyễn Văn Cừ',
                'city' => 'Cần Thơ',
                'status' => 'blocked',
            ],
            [
                'name' => 'Đặng Xuân Dạn',
                'email' => 'xuandan@gmail.com',
                'phone' => '0971237543',
                'address' => '102 Điện Biên Phủ',
                'city' => 'TP. Hồ Chí Minh',
                'status' => 'active',
            ],
            [
                'name' => 'Bùi Thu Hà',
                'email' => 'thuha@gmail.com',
                'phone' => '0971332036',
                'address' => '24 Lý Thường Kiệt',
                'city' => 'Hải Phòng',
                'status' => 'active',
            ],
            [
                'name' => 'Ngô Bảo Tiến',
                'email' => 'baotien@gmail.com',
                'phone' => '0971255343',
                'address' => '78 Quang Trung',
                'city' => 'Nha Trang',
                'status' => 'blocked',
            ],
        ];

        foreach ($customers as $c) {
            User::updateOrCreate(
                ['email' => $c['email']],
                array_merge($c, [
                    'password' => Hash::make('12345678'),
                    'role' => 'customer',
                    'created_at' => now()->subDays(rand(1, 30)),
                ])
            );
        }
    }
}
