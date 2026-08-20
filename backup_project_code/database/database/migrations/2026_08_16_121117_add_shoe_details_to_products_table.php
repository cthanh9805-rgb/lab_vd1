<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->tinyInteger('heel_height')->nullable()->after('variants')->comment('Chiều cao gót (cm)');
            $table->string('material', 100)->nullable()->after('heel_height')->comment('Chất liệu');
            $table->integer('weight')->nullable()->after('material')->comment('Cân nặng (gram)');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['heel_height', 'material', 'weight']);
        });
    }
};
