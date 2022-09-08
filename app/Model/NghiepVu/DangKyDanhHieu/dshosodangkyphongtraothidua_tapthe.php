<?php

namespace App\Model\NghiepVu\DangKyDanhHieu;

use Illuminate\Database\Eloquent\Model;

class dshosodangkyphongtraothidua_tapthe extends Model
{
    protected $table = 'dshosodangkyphongtraothidua_tapthe';
    protected $fillable = [
        'id',
        'stt',
        'mahosodk',
        'maphanloaitapthe', //Tập thể nhà nước; Doanh nghiệp; Hộ gia đình                   
        'tentapthe',
        'ghichu',
        'madanhhieutd',
        'mahinhthuckt',
        'madonvi',
    ];
}
