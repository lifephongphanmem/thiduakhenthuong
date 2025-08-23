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
        Schema::table('hethongchung', function (Blueprint $table) {
            $table->boolean('sapnhap_giaodien')->default(1);
            $table->decimal('luongcoso', 18, 0)->nullable();
            $table->string('default_pass', 50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hethongchung', function (Blueprint $table) {
            $table->dropColumn(['sapnhap_giaodien','luongcoso','default_pass']);
        });
    }
};
