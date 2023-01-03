<?php

namespace App\Model\DanhMuc;

use Illuminate\Database\Eloquent\Model;

class dmhinhthuckhenthuong extends Model
{
    protected $table = 'dmhinhthuckhenthuong';
    protected $fillable = [
        'id',
        'stt',
        'mahinhthuckt',
        'tenhinhthuckt',
        'phanloai',
        'phamviapdung',
        'ghichu',
        'doituongapdung',
        'muckhencanhan_nhanuoc',
        'muckhencanhan_tinh',
        'muckhencanhan_huyen',
        'muckhencanhan_xa',
        'muckhentapthe_nhanuoc',
        'muckhentapthe_tinh',
        'muckhentapthe_huyen',
        'muckhentapthe_xa',
    ];
}
