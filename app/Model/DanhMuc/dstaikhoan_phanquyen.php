<?php

namespace App\Model\DanhMuc;

use Illuminate\Database\Eloquent\Model;

class dstaikhoan_phanquyen extends Model
{
    protected $table = 'dstaikhoan_phanquyen';
    protected $fillable = [
        'id',
        'tendangnhap',
        'machucnang',
        'phanquyen', //phân quyền chung để lọc
        'danhsach', //phân quyền; nếu 2 chức năng còn lại true => mặc định true
        'thaydoi',
        'hoanthanh',
        'tiepnhan',
        'xuly',
        'ghichu',
    ];
}
