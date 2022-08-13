<?php

namespace App\Model\NghiepVu\ThiDuaKhenThuong;

use Illuminate\Database\Eloquent\Model;

class dshosothiduakhenthuong_canhan extends Model
{
    protected $table = 'dshosothiduakhenthuong_canhan';
    protected $fillable = [
        'id',
        'stt',
        'mahosotdkt',
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
        'ketqua',
        'mahinhthuckt',
        'madanhhieutd',
        'lydo',
        'noidungkhenthuong', //in trên phôi bằng khen
        'madonvi', //phục vụ lấy dữ liệu 
    ];
}
