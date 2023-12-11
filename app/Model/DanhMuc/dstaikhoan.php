<?php

namespace App\Model\DanhMuc;

use Illuminate\Database\Eloquent\Model;

class dstaikhoan extends Model
{
    protected $table = 'dstaikhoan';
    protected $fillable = [
        'id',
        'tentaikhoan',
        'tendangnhap',
        'matkhau',
        'madonvi',
        'email',
        'sodienthoai',
        'trangthai',
        'sadmin',
        'ttnguoitao',
        'lydo',
        'solandn',        
        'manhomchucnang',
        'nhaplieu',
        'tonghop',
        'hethong',
        'chucnangkhac',
        'dstaikhoan',
        'phanloai',
    ];
}
