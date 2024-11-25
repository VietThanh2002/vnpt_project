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
        Schema::create('sim_cards', function (Blueprint $table) {
            $table->id();
            $table->string('sim_number')->unique(); // Số SIM
            $table->enum('type', ['trả trước', 'trả sau']); // Loại SIM (trả trước/trả sau)
            $table->enum('status', ['có sẵn','đặt trước'])->default('có sẵn'); // Tình trạng SIM
            $table->decimal('price', 10, 2); // Giá bán SIM
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sim_cards');
    }
};
