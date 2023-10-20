<?php

namespace App\Model\DanhMuc;

use Illuminate\Database\Eloquent\Model;

class dmphongtraothidua extends Model
{
    protected $table = 'dmphongtraothidua';
    protected $fillable = [
        'id',
        'maplphongtrao',
        'tenplphongtrao',
        'phanloai',       
        'ghichu',
    ];
}
