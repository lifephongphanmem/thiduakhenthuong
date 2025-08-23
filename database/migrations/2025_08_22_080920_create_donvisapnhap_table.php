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
        Schema::create('donvisapnhap', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('madonvi_sapnhap', 50);
            $table->string('madonvi_bisapnhap');
            $table->boolean('phanloai')->default(0);
            $table->date('ngaysapnhap');
            $table->string('ghichu')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donvisapnhap');
    }
};
