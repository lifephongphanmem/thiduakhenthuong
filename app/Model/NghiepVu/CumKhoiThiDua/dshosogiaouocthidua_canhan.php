<?php

namespace App\Model\NghiepVu\CumKhoiThiDua;

use Illuminate\Database\Eloquent\Model;

class dshosogiaouocthidua_canhan extends Model
{
    protected $table = 'dshosogiaouocthidua_canhan';
    protected $fillable = [
        'id',
        'mahosodk',
        //Thông tin cá nhân
        'maccvc',
        'socancuoc',
        'tendoituong',
        'ngaysinh',
        'gioitinh',
        'chucvu',
        'diachi',
        'tencoquan',
        'tenphongban',
        'maphanloaicanbo', //phân loại cán bộ           
        'mahinhthuckt',
        'madanhhieutd',
        'madonvi', //phục vụ lấy dữ liệu
    ];
}