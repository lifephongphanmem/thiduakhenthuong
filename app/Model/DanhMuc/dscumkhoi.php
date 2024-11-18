<?php

namespace App\Model\DanhMuc;

use Illuminate\Database\Eloquent\Model;

class dscumkhoi extends Model
{
    protected $table = 'dscumkhoi';
    protected $fillable = [
        'id',
        'maqdphancumkhoi',
        'macumkhoi',
        'tencumkhoi',
        'ngaythanhlap',
        'capdo',
        'madonviql',
        'madonvixd',
        'madonvikt',
        'ipf1',
        'ipf2',
        'ipf3',
        'ipf4',
        'ipf5',
        'phamvi', //Gán cán bộ quản lý để lọc nếu cần
        'ghichu',
    ];
}
