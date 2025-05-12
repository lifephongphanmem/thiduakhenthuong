<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class UpđateViewDscumkhoi20250210View extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //        
        DB::statement("
        CREATE OR ALTER VIEW [dbo].[view_dscumkhoi]
        AS
        SELECT dbo.dscumkhoi.macumkhoi, dbo.dscumkhoi.tencumkhoi, dbo.dscumkhoi.ngaythanhlap, dbo.dscumkhoi.capdo, dbo.dscumkhoi.madonviql, dbo.dscumkhoi_chitiet.madonvi, dbo.dscumkhoi.phamvi, 
            dbo.dscumkhoi_chitiet.phanloai, dbo.dsdonvi.tendonvi, dbo.dsdonvi.madiaban, dbo.dscumkhoi_qdphancumkhoi.maqdphancumkhoi, dbo.dscumkhoi_qdphancumkhoi.soqd, dbo.dscumkhoi_qdphancumkhoi.dvbanhanh, 
            dbo.dscumkhoi_qdphancumkhoi.ngayqd
        FROM dbo.dscumkhoi INNER JOIN
            dbo.dscumkhoi_chitiet ON dbo.dscumkhoi.macumkhoi = dbo.dscumkhoi_chitiet.macumkhoi INNER JOIN
            dbo.dsdonvi ON dbo.dscumkhoi_chitiet.madonvi = dbo.dsdonvi.madonvi INNER JOIN
            dbo.dscumkhoi_qdphancumkhoi ON dbo.dscumkhoi.maqdphancumkhoi = dbo.dscumkhoi_qdphancumkhoi.maqdphancumkhoi
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {        
        DB::statement("
        CREATE OR ALTER VIEW [dbo].[view_dscumkhoi]
        AS
        SELECT dbo.dscumkhoi.macumkhoi, dbo.dscumkhoi.tencumkhoi, dbo.dscumkhoi.ngaythanhlap, dbo.dscumkhoi.capdo, dbo.dscumkhoi.madonviql, dbo.dscumkhoi_chitiet.madonvi, dbo.dscumkhoi.phamvi, 
            dbo.dscumkhoi_chitiet.phanloai, dbo.dsdonvi.tendonvi, dbo.dsdonvi.madiaban
        FROM dbo.dscumkhoi INNER JOIN
            dbo.dscumkhoi_chitiet ON dbo.dscumkhoi.macumkhoi = dbo.dscumkhoi_chitiet.macumkhoi INNER JOIN
            dbo.dsdonvi ON dbo.dscumkhoi_chitiet.madonvi = dbo.dsdonvi.madonvi
        ");
    }
}
