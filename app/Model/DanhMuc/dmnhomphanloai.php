<?php

namespace App\Model\DanhMuc;

use Illuminate\Database\Eloquent\Model;

class dmnhomphanloai extends Model
{
    protected $table = 'dmnhomphanloai';
    protected $fillable = [
        'id',
        'stt',
        'manhomphanloai',        
        'tennhomphanloai',
        'ghichu',
        
    ];
}
