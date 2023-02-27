<?php

namespace App\Model\View;

use Illuminate\Database\Eloquent\Model;

class view_dstruongcumkhoi extends Model
{
    protected $table = 'view_dstruongcumkhoi';
    protected $fillable = [        
    ];
}
// CREATE OR ALTER VIEW [dbo].[view_dstruongcumkhoi]
// AS
// SELECT        dbo.dstruongcumkhoi_chitiet.macumkhoi, dbo.dstruongcumkhoi_chitiet.madonvi, dbo.dstruongcumkhoi.ngaytu, dbo.dstruongcumkhoi.ngayden
// FROM            dbo.dstruongcumkhoi INNER JOIN
//                          dbo.dstruongcumkhoi_chitiet ON dbo.dstruongcumkhoi.madanhsach = dbo.dstruongcumkhoi_chitiet.madanhsach
// GO
