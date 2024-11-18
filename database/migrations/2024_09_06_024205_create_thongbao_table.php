<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateThongbaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('thongbao', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('mathongbao');
            $table->string('noidung')->nullable();
            $table->string('url')->nullable();
            $table->string('chucnang')->nullable();
            $table->string('trangthai')->default('CHUADOC');
            $table->string('mahs_mapt')->nullable();//Mã hồ sơ hoặc mã phong trào
            $table->string('madonvi_thongbao')->nullable();
            $table->string('madonvi_nhan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('thongbao');
    }
}
