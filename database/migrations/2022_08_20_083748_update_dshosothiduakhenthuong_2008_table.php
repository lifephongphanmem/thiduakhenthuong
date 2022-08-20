<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateDshosothiduakhenthuong2008Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hethongchung_chucnang', function (Blueprint $table) {
            $table->string('soqd')->nullable();
            $table->date('ngayqd')->nullable();
            $table->string('donvikhenthuong')->nullable();
            $table->string('capkhenthuong')->nullable();
            $table->string('chucvunguoiky')->nullable();
            $table->string('hotennguoiky')->nullable();
            $table->string('thongtinquyetdinh')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hethongchung_chucnang', function (Blueprint $table) {            
            $table->dropColumn('soqd');
            $table->dropColumn('ngayqd');
            $table->dropColumn('donvikhenthuong');
            $table->dropColumn('capkhenthuong');
            $table->dropColumn('chucvunguoiky');
            $table->dropColumn('hotennguoiky');
            $table->dropColumn('thongtinquyetdinh');
        });
    }
}
