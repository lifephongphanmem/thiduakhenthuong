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
        Schema::table('dsdonvi', function (Blueprint $table) {
            $table->string('lydo')->nullable();
            $table->string('phanloai', 50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dsdonvi', function (Blueprint $table) {
            $table->dropColumn(['lydo','phanloai']);
        });
    }
};
