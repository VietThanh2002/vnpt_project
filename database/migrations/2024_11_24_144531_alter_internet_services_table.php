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
        Schema::table('internet_services', function (Blueprint $table) {
            $table->string('slug')->after('service_name')->nullable();
            $table->string('short_des')->nullable()->after('price');
            $table->string('image')->nullable()->after('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('internet_services', function (Blueprint $table) {
            $table->dropColumn('slug');
            $table->dropColumn('short_des');
            $table->dropColumn('image');
        });
    }
};
