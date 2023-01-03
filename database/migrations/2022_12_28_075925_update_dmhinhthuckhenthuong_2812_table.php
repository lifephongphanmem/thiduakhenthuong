<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateDmhinhthuckhenthuong2812Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dmhinhthuckhenthuong', function (Blueprint $table) {
            $table->string('doituongapdung')->nullable();
            $table->double('muckhencanhan_nhanuoc')->nullable();
            $table->double('muckhencanhan_tinh')->nullable();
            $table->double('muckhencanhan_huyen')->nullable();
            $table->double('muckhencanhan_xa')->nullable();
            $table->double('muckhentapthe_nhanuoc')->nullable();
            $table->double('muckhentapthe_tinh')->nullable();
            $table->double('muckhentapthe_huyen')->nullable();
            $table->double('muckhentapthe_xa')->nullable();
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dmhinhthuckhenthuong', function (Blueprint $table) {            
            $table->dropColumn('doituongapdung');
            $table->dropColumn('muckhencanhan_nhanuoc');
            $table->dropColumn('muckhencanhan_tinh');
            $table->dropColumn('muckhencanhan_huyen');
            $table->dropColumn('muckhencanhan_xa');
            $table->dropColumn('muckhentapthe_nhanuoc');
            $table->dropColumn('muckhentapthe_tinh');
            $table->dropColumn('muckhentapthe_huyen');
            $table->dropColumn('muckhentapthe_xa');
        });
    }
}
