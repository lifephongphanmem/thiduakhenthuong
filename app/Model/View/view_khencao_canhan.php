<?php

namespace App\Model\View;

use Illuminate\Database\Eloquent\Model;

class view_khencao_canhan extends Model
{
    protected $table = 'view_khencao_canhan';
    protected $fillable = [        
    ];
}
// CREATE OR ALTER VIEW [dbo].[view_khencao_canhan]
// AS
// SELECT        dbo.dshosokhencao.ngayhoso, dbo.dshosokhencao.maloaihinhkt, dbo.dshosokhencao.capkhenthuong, dbo.dshosokhencao_canhan.maphanloaicanbo, dbo.dshosokhencao_canhan.ketqua, 
//                          dbo.dshosokhencao_canhan.mahinhthuckt, dbo.dshosokhencao_canhan.madanhhieutd, dbo.dshosokhencao_canhan.madanhhieukhenthuong, dbo.dsdonvi.madiaban
// FROM            dbo.dshosokhencao INNER JOIN
//                          dbo.dshosokhencao_canhan ON dbo.dshosokhencao.mahosotdkt = dbo.dshosokhencao_canhan.mahosotdkt INNER JOIN
//                          dbo.dsdonvi ON dbo.dshosokhencao.id = dbo.dsdonvi.id AND dbo.dshosokhencao.madonvi = dbo.dsdonvi.madonvi