<?php

namespace App\Model\View;

use Illuminate\Database\Eloquent\Model;

class view_khencao_tapthe extends Model
{
    protected $table = 'view_khencao_tapthe';
    protected $fillable = [        
    ];
}
// CREATE OR ALTER VIEW [dbo].[view_khencao_tapthe]
// AS
// SELECT    dbo.dshosokhencao.ngayhoso, dbo.dshosokhencao.maloaihinhkt, dbo.dshosokhencao.capkhenthuong, dbo.dshosokhencao.trangthai, dbo.dshosokhencao_tapthe.ketqua, dbo.dshosokhencao_tapthe.madanhhieutd, 
//                       dbo.dshosokhencao_tapthe.mahinhthuckt
// FROM         dbo.dshosokhencao INNER JOIN
//                       dbo.dshosokhencao_tapthe ON dbo.dshosokhencao.mahosotdkt = dbo.dshosokhencao_tapthe.mahosotdkt