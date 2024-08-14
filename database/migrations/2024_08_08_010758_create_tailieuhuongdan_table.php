<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTailieuhuongdanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tailieuhuongdan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('matailieu',50)->nullable();
            $table->string('tentailieu')->nullable();
            $table->string('phanloai')->nullable();
            $table->string('noidung')->nullable();
            $table->string('link1')->nullable();
            $table->string('link2')->nullable();
            $table->string('file')->nullable();
            $table->integer('stt')->nullable();
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
        Schema::dropIfExists('tailieuhuongdan');
    }
}
