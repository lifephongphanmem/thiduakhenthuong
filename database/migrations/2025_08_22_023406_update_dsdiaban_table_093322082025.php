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
        Schema::table('dsdiaban', function (Blueprint $table) {
            $table->string('phanloai')->nullable();
            $table->string('madiabanQLNganh', 50)->nullable();
            $table->string('trangthai', 50)->nullable();
            $table->dateTime('ngaydung')->nullable();
            $table->string('lydo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dsdiaban', function (Blueprint $table) {
            $table->dropColumn(['trangthai', 'ngaydung', 'lydo', 'madiabanQLNganh','phanloai']);
        });
    }
};
