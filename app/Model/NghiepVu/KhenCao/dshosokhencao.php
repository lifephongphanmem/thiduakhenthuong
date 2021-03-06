<?php

namespace App\Model\NghiepVu\KhenCao;

use Illuminate\Database\Eloquent\Model;

class dshosokhencao extends Model
{
    protected $table = 'dshosokhencao';
    protected $fillable = [
        'id',
        'mahosokt',
            'ngayhoso',
            'noidung',
            'maloaihinhkt',
            'maphongtraotd',
            'donvikhenthuong',
            'capkhenthuong',
            'chucvunguoiky',
            'hotennguoiky',
            'ghichu',
            'phanloai',//Cụm khối, phong trào
            //File đính kèm
            'totrinh', // Tờ trình
            'qdkt', // Quyết định
            'bienban',//biên bản cuộc họp
            'tailieukhac',//tài liệu khác
            //Trạng thái đơn vị
            'madonvi',
            'madonvi_nhan',
            'lydo',
            'thongtin',//chưa dùng
            'trangthai',
            'thoigian',
    ];
}
