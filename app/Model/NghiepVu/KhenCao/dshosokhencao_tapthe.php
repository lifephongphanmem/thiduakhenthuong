<?php

namespace App\Model\NghiepVu\KhenCao;

use Illuminate\Database\Eloquent\Model;

class dshosokhencao_tapthe extends Model
{
    protected $table = 'dshosokhencao_tapthe';
    protected $fillable = [
        'id',
        'stt',
        'mahosotdkt',
        'maphanloaitapthe', //Tập thể nhà nước; Doanh nghiệp; Hộ gia đình
        //Thông tin tập thể            
        'tentapthe',
        'ghichu', //
        //Kết quả đánh giá
        'ketqua',
        'madanhhieutd',
        'mahinhthuckt',
        'lydo',
        'noidungkhenthuong', //in trên phôi bằng khen
        'madonvi', //phục vụ lấy dữ liệu
    ];
}
