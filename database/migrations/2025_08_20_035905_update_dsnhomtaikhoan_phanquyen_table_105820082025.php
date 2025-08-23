<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateDsnhomtaikhoanPhanquyenTable105820082025 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dsnhomtaikhoan_phanquyen', function (Blueprint $table) {
            $table->boolean('tiepnhan')->default(0);
            $table->boolean('xuly')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dsnhomtaikhoan_phanquyen', function (Blueprint $table) {
            $table->dropColumn(['tiepnhan','xuly']);
        });
    }
}
