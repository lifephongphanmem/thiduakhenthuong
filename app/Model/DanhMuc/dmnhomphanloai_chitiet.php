<?php

namespace App\Model\DanhMuc;

use Illuminate\Database\Eloquent\Model;

class dmnhomphanloai_chitiet extends Model
{
    protected $table = 'dmnhomphanloai_chitiet';
    protected $fillable = [
        'id',
        'stt',
        'manhomphanloai',
        'maphanloai',
        'tenphanloai',
        'ghichu',
        'phamviapdung',
    ];
}
