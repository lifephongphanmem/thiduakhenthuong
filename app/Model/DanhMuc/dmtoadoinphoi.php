<?php

namespace App\Model\DanhMuc;

use Illuminate\Database\Eloquent\Model;

class dmtoadoinphoi extends Model
{
    protected $table = 'dmtoadoinphoi';
    protected $fillable = [
        'id',
        'phanloaikhenthuong', //Cụm khối; Khen thưởng
        'phanloaidoituong', //Cá nhân, tập thể, hộ gia đình
        'maloaihinhkt',
        'toado_tendoituong',
        'toado_noidungkhenthuong',
        'toado_quyetdinh',
        'toado_ngayqd',
        'toado_chucvunguoikyqd',
        'toado_hotennguoikyqd',
        'toado_donvikhenthuong',
        'toado_sokhenthuong',
    ];
}
