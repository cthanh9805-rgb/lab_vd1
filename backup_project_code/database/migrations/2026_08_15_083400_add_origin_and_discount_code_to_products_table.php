<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('origin')->nullable()->after('colors')->comment('Xuất xứ sản phẩm (VD: Ý, Hàn Quốc, Quảng Châu, Việt Nam...)');
            $table->string('discount_code')->nullable()->after('origin')->comment('Mã giảm giá áp dụng (VD: HEEL10, SALE20...)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['origin', 'discount_code']);
        });
    }
};
