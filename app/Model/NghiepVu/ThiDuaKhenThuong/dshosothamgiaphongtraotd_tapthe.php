<?php

namespace App\Model\NghiepVu\ThiDuaKhenThuong;

use Illuminate\Database\Eloquent\Model;

class dshosothamgiaphongtraotd_tapthe extends Model
{
    protected $table = 'dshosothamgiaphongtraotd_tapthe';
    protected $fillable = [
        'id',
        'stt',
        'mahosothamgiapt',
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