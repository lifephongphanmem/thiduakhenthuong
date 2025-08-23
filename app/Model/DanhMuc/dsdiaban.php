<?php

namespace App\Model\DanhMuc;

use Illuminate\Database\Eloquent\Model;

class dsdiaban extends Model
{
    protected $table = 'dsdiaban';
    protected $fillable = [
        'id',
        'madiaban',
        'tendiaban',
        'capdo',
        'phanloai',
        'madonviQL', //Đơn vị phê duyệt khen thưởng
        'madonviKT', //Đơn vị xét duyệt hồ sơ
        'madiabanQL',
        'ghichu',
        'madiabanQLNganh', //Địa bàn quản lý ngành
        'trangthai', //Nếu dừng hđ thì trạng thái sẽ là TD, nếu hđ thì trạng thái sẽ là null
        'ngaydung',
        'lydo'
    ];
}
