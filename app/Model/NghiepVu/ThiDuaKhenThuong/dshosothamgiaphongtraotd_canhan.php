<?php

namespace App\Model\NghiepVu\ThiDuaKhenThuong;

use Illuminate\Database\Eloquent\Model;

class dshosothamgiaphongtraotd_canhan extends Model
{
    protected $table = 'dshosothamgiaphongtraotd_canhan';
    protected $fillable = [
        'id',
        'stt',
        'mahosothamgiapt',
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
        //Kết quả đánh giá
        'mahinhthuckt',
        'madanhhieutd',
        'madonvi',
    ];
}
