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
        Schema::create('internet_services', function (Blueprint $table) {
            $table->id();
            $table->string('service_name'); // Tên gói dịch vụ
            $table->string('speed'); // Tốc độ dịch vụ (ví dụ: 100Mbps, 200Mbps)
            $table->decimal('price', 10, 2); // Giá gói cước
            $table->text('description')->nullable(); // Mô tả chi tiết
            $table->integer('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('internet_services');
    }
};
