<?php

namespace App\Model\NghiepVu\CumKhoiThiDua;

use Illuminate\Database\Eloquent\Model;

class dshosogiaouocthidua_tapthe extends Model
{
    protected $table = 'dshosogiaouocthidua_tapthe';
    protected $fillable = [
        'id',
        'stt',
        'mahosodk',
        'maphanloaitapthe', //Tập thể nhà nước; Doanh nghiệp; Hộ gia đình
        //Thông tin tập thể            
        'tentapthe',
        'ghichu',           
        'madanhhieutd',
        'mahinhthuckt',           
        'madonvi',
    ];
}
