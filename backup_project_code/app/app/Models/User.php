<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'avatar',
        'role',
        'address',
        'city',
        'status',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function addresses()
    {
        return $this->hasMany(UserAddress::class);
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    // Quyền hạn
    public function isAdmin(): bool
    {
        return $this->role === 'admin'; // Quản trị viên (Cấp cao nhất)
    }

    public function isManager(): bool
    {
        return $this->role === 'manager'; // Quản lý
    }

    public function isStaff(): bool
    {
        return $this->role === 'staff'; // Nhân viên
    }

    public function isCustomer(): bool
    {
        return $this->role === 'customer'; // Khách hàng
    }

    public function hasAdminAccess(): bool
    {
        return in_array($this->role, ['admin', 'manager', 'staff']) && $this->status === 'active';
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar) {
            return str_starts_with($this->avatar, 'http') ? $this->avatar : asset($this->avatar);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=38bdf8&color=fff';
    }

    public function getRoleBadgeAttribute(): array
    {
        return match ($this->role) {
            'admin'    => ['label' => '👑 Quản trị viên', 'bg' => 'rgba(234,179,8,0.15)',  'color' => '#fde047', 'border' => 'rgba(234,179,8,0.3)'],
            'manager'  => ['label' => '👔 Quản lý',      'bg' => 'rgba(168,85,247,0.15)', 'color' => '#c084fc', 'border' => 'rgba(168,85,247,0.3)'],
            'staff'    => ['label' => '💼 Nhân viên',    'bg' => 'rgba(56,189,248,0.15)',  'color' => '#7dd3fc', 'border' => 'rgba(56,189,248,0.3)'],
            default    => ['label' => '🛍️ Khách hàng',   'bg' => 'rgba(255,255,255,0.06)', 'color' => 'var(--text-secondary)', 'border' => 'var(--border)'],
        };
    }
}
