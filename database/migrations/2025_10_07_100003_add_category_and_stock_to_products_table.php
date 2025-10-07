<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable()->after('id')->constrained()->onDelete('set null');
            $table->string('brand')->nullable()->after('name');
            $table->enum('gender', ['men', 'women', 'unisex'])->default('unisex')->after('brand');
            $table->integer('stock')->default(0)->after('price');
            $table->boolean('is_active')->default(true)->after('stock');
            $table->string('sku')->unique()->nullable()->after('is_active');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn(['category_id', 'brand', 'gender', 'stock', 'is_active', 'sku']);
        });
    }
};
