<?php

namespace App\Model\NghiepVu\KhenCao;

use Illuminate\Database\Eloquent\Model;

class dshosokhencao_khenthuong extends Model
{
    protected $table = 'dshosokhencao_khenthuong';
    protected $fillable = [
        'id',
        'mahosokt',
            'mahosotdkt',//lưu trữ sau cần dùng
            'madanhhieutd',
            'mahinhthuckt',
            'noidungkhenthuong',//cá nhân, tập thể
            'phanloai',//cá nhân, tập thể
            'madoituong',
            'maccvc',
            'tendoituong',
            'ngaysinh',
            'gioitinh',
            'chucvu',
            'lanhdao',
            //Thông tin tập thể
            'matapthe',
            'tentapthe',
            'ghichu',//
            //Kết quả đánh giá
            'ketqua',
            'lydo',
             //Đề tài, sáng kiến
             'tensangkien',//tên đề tài, sáng kiến
             'donvicongnhan',
             'thoigiancongnhan',
             'thanhtichdatduoc',
             'filedk',
            'madonvi',//phục vụ lấy dữ liệu
    ];
}
