<?php

namespace App\Model\HeThong;


use Illuminate\Database\Eloquent\Model;

class tailieuhuongdan extends Model
{

    protected $table='tailieuhuongdan';
    protected $fillable=[
        'id',
        'matailieu',
        'tentailieu',
        'phanloai',
        'noidung',
        'link1',
        'link2',
        'file',
        'stt'
    ];
}
