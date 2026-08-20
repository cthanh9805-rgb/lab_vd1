<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone', 20)->nullable()->after('email');
            $table->string('avatar')->nullable()->after('password');
            $table->enum('role', ['admin', 'customer'])->default('customer')->after('avatar');
            $table->text('address')->nullable()->after('role');
            $table->string('city', 100)->nullable()->after('address');
            $table->enum('status', ['active', 'blocked'])->default('active')->after('city');
            $table->timestamp('last_login_at')->nullable()->after('remember_token');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'avatar', 'role', 'address', 'city', 'status', 'last_login_at']);
        });
    }
};
