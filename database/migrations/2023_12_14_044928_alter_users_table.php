<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // Hàm callback định nghĩa các thay đổi ở bảng users
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table){

            $table->integer('role')->default(1)->after('email');

        });
    }

    /**
     * Reverse the migrations.
     */
    // hàm này dùng để khôi phục lại trạng thái ban đầu trước khi thêm cột role
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table){
            $table->dropColumn('role');
        });
    }
};
