<?php

namespace App\Model\ThongBao;

use Illuminate\Database\Eloquent\Model;

class thongbao extends Model
{
    protected $table='thongbao';
    protected $fillable=[
        'mathongbao',
        'noidung',
        'url',
        'chucnang',
        'trangthai',
        'mahs_mapt',
        'madonvi_thongbao',
        'madonvi_nhan'
    ];
}
