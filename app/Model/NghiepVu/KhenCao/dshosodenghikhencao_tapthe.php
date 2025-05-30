<?php

namespace App\Model\NghiepVu\KhenCao;

use Illuminate\Database\Eloquent\Model;

class dshosodenghikhencao_tapthe extends Model
{
    protected $table = 'dshosodenghikhencao_tapthe';
    protected $fillable = [
        'id',
        'stt',
        'mahoso',
        'linhvuchoatdong',
        'maphanloaitapthe', //Tập thể nhà nước; Doanh nghiệp; Hộ gia đình
        //Thông tin tập thể            
        'tentapthe',
        'ghichu', //
        //Kết quả đánh giá
        'ketqua',     
        'madanhhieukhenthuong', //gộp danh hiệu & khen thưởng
        'lydo',
        'noidungkhenthuong', //in trên phôi bằng khen
        'madonvi', //phục vụ lấy dữ liệu
        //in phôi
        'toado_tendoituongin',
        'toado_noidungkhenthuong',
        'toado_quyetdinh',
        'toado_ngayqd',
        'toado_chucvunguoikyqd',
        'toado_hotennguoikyqd',
        'toado_donvikhenthuong',
        'toado_sokhenthuong',
        'tendoituongin',
        'quyetdinh',
        'ngayqd',
        'chucvunguoikyqd',
        'hotennguoikyqd',
        'donvikhenthuong',
        'sokhenthuong',
        'toado_chucvudoituong',
        'chucvudoituong',
        'toado_pldoituong',
        'pldoituong',
        'tencoquan',
        //Thêm các trường số qd khen thưởng do 1 hồ sơ khen thưởng có thể có nhiều qd khen thưởng, nhiều tờ trình khen thưởng
        'soqdkhenthuong',
        'ngayqdkhenthuong',
        'sototrinhkhenthuong',
        'ngaytrinhkhenthuong',
    ];
}
