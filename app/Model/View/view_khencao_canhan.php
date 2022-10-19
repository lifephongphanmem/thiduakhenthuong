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
// SELECT    dbo.dshosokhencao.ngayhoso, dbo.dshosokhencao.maloaihinhkt, dbo.dshosokhencao.capkhenthuong, dbo.dshosokhencao_canhan.maphanloaicanbo, dbo.dshosokhencao_canhan.ketqua, 
//                       dbo.dshosokhencao_canhan.mahinhthuckt, dbo.dshosokhencao_canhan.madanhhieutd, dbo.dshosokhencao.trangthai
// FROM         dbo.dshosokhencao INNER JOIN
//                       dbo.dshosokhencao_canhan ON dbo.dshosokhencao.mahosotdkt = dbo.dshosokhencao_canhan.mahosotdkt