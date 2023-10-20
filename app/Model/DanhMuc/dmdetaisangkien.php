<?php

namespace App\Model\DanhMuc;

use Illuminate\Database\Eloquent\Model;

class dmdetaisangkien extends Model
{
    protected $table = 'dmdetaisangkien';
    protected $fillable = [
        'id',
        'madetaisangkien',
        'tendetaisangkien',
        'phanloai',
        'ghichu',        
    ];
}
