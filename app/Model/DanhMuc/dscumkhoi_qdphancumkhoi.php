<?php

namespace App\Model\DanhMuc;

use Illuminate\Database\Eloquent\Model;

class dscumkhoi_qdphancumkhoi extends Model
{
    protected $table = 'dscumkhoi_qdphancumkhoi';
    protected $fillable = [
        'id',
        'maqdphancumkhoi',
        'soqd',
        'dvbanhanh',
        'ngayqd',
        'ngayapdung',
        'noidung',
        'ghichu',
        'madonvi',
        'tinhtrang', //Căn cứ để lấy cụm khối theo qd để tạo hồ sơ
        'ipf1',
        'ipf2',
        'ipf3',
        'ipf4',
        'ipf5',
        'capdo',//Chưa dùng
    ];
}
