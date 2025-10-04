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
        Schema::table('orders', function (Blueprint $table) {
            // نعدل عمود الحالة ونضيف canceled
            $table->enum('status', [
                'pending', 'review', 'confirmed', 'shipped', 'delivered', 'canceled'
            ])->default('pending')->change();

            // بيانات إضافية للطلب
            $table->string('full_name')->nullable()->after('status');
            $table->string('phone')->nullable()->after('full_name');
            $table->text('address')->nullable()->after('phone');
            $table->enum('payment_method', ['cash', 'credit_card', 'paypal'])->nullable()->after('address');

            // بيانات الشحن
            $table->decimal('total_price', 10, 2)->nullable()->after('payment_method');
            $table->string('tracking_number')->nullable()->after('total_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // نرجع الstatus زي الأول من غير canceled
            $table->enum('status', [
                'pending', 'confirmed', 'shipped', 'delivered'
            ])->default('pending')->change();

            // نحذف الأعمدة اللي ضفناها
            $table->dropColumn([
                'full_name',
                'phone',
                'address',
                'payment_method',
                'total_price',
                'tracking_number',
            ]);
        });
    }
};
