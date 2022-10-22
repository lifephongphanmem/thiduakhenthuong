<?php

namespace App\Model\NghiepVu\ThiDuaKhenThuong;

use Illuminate\Database\Eloquent\Model;

class dshosothiduakhenthuong_tapthe extends Model
{
    protected $table = 'dshosothiduakhenthuong_tapthe';
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
        'madanhhieutd',//bỏ
        'mahinhthuckt',//bỏ
        'madanhhieukhenthuong',//gộp danh hiệu & khen thưởng
        'lydo',
        'noidungkhenthuong', //in trên phôi bằng khen
        'madonvi', //phục vụ lấy dữ liệu             
    ];
}
