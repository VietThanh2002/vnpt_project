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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('subtotal');
            $table->integer('shipping');
            $table->string('coupon_code')->nullable();
            $table->integer('discount')->nullable();
            $table->integer('grand_total');

            // thông tin và địa chỉ nhận hàng
            $table->string('name');
            $table->string('email');
            $table->string('mobile');
            $table->string('city');
            $table->string('district');
            $table->string('ward');
            $table->string('address');
            $table->string('notes');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
