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
            $table->double('muckhencanhan')->default(0);
            $table->double('muckhentapthe')->default(0);
           
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
            $table->dropColumn('muckhencanhan');
            $table->dropColumn('muckhentapthe');
        });
    }
}
