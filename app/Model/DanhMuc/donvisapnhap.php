<?php

namespace App\Model\DanhMuc;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class donvisapnhap extends Model
{
    use HasFactory;
    protected $table = "donvisapnhap";
    protected $guarded = ['id'];
}
//phanloai: 0->sáp nhập vào đơn vị mới; 1=> sáp nhập vào đơn vị hiện tại
