<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateDshosotdktcumkhoiTapthe0112Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dshosotdktcumkhoi_tapthe', function (Blueprint $table) {
            $table->string('toado_tendoituong')->nullable();
            $table->string('toado_noidungkhenthuong')->nullable();
            $table->string('toado_quyetdinh')->nullable();
            $table->string('toado_ngayqd')->nullable();
            $table->string('toado_chucvunguoikyqd')->nullable();
            $table->string('toado_hotennguoikyqd')->nullable();
            $table->string('toado_donvikhenthuong')->nullable();
            $table->string('toado_sokhenthuong')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dshosotdktcumkhoi_tapthe', function (Blueprint $table) {           
            $table->dropColumn('toado_tendoituong');
            $table->dropColumn('toado_noidungkhenthuong');
            $table->dropColumn('toado_quyetdinh');
            $table->dropColumn('toado_ngayqd');
            $table->dropColumn('toado_chucvunguoikyqd');
            $table->dropColumn('toado_hotennguoikyqd');
            $table->dropColumn('toado_donvikhenthuong');
            $table->dropColumn('toado_sokhenthuong');
        });
    }
}
