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
        Schema::table('orders', function(Blueprint $table) {
            $table->enum('payment_status', ['Chưa thanh toán', 'Đã thanh toán'])->after('grand_total')->default('Chưa thanh toán');
            $table->enum('status', ['Chờ xử lý', 'Đang vận chuyển', 'Đã giao hàng'])->after('payment_status')->default('Chờ xử lý');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function(Blueprint $table) {
            $table->dropColumn('payment_status');
            $table->dropColumn('status');
        });
    }
};
