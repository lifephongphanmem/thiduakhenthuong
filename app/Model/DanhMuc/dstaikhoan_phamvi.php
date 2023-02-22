<?php

namespace App\Model\DanhMuc;

use Illuminate\Database\Eloquent\Model;

class dstaikhoan_phamvi extends Model
{
    protected $table = 'dstaikhoan_phamvi';
    protected $fillable = [
        'id',
        'tendangnhap',
        'machucnang',
        'phanloai', 
        'madiabancumkhoi',//bỏ
        'maphamvi',
        'tenphamvi',
        'ghichu',
    ];
}
