<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDsquyetdinhcumkhoiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dscumkhoi_qdphancumkhoi', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('maqdphancumkhoi')->nullable();
            $table->string('soqd')->nullable();
            $table->string('dvbanhanh')->nullable();
            $table->date('ngayqd')->nullable();
            $table->date('ngayapdung')->nullable();
            $table->text('noidung')->nullable();
            $table->string('ghichu')->nullable();
            $table->string('madonvi')->nullable(30);
            $table->string('tinhtrang')->nullable(); //Căn cứ để lấy cụm khối theo qd để tạo hồ sơ
            $table->string('ipf1')->nullable();
            $table->string('ipf2')->nullable();
            $table->string('ipf3')->nullable();
            $table->string('ipf4')->nullable();
            $table->string('ipf5')->nullable();
            $table->string('capdo')->nullable(); //Chưa dùng
            $table->timestamps();
        });

        Schema::table('dscumkhoi', function (Blueprint $table) {
            $table->string('maqdphancumkhoi')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dscumkhoi_qdphancumkhoi');
        Schema::table('dscumkhoi', function (Blueprint $table) {
            $table->dropColumn('maqdphancumkhoi');
        });
    }
}
