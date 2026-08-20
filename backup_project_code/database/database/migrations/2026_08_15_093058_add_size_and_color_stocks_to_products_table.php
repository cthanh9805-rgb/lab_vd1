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
            $table->text('size_stocks')->nullable()->after('sizes')->comment('Số lượng tồn kho chi tiết từng size (JSON)');
            $table->text('color_stocks')->nullable()->after('colors')->comment('Số lượng tồn kho chi tiết từng màu (JSON)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['size_stocks', 'color_stocks']);
        });
    }
};
