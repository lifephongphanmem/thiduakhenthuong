<?php

namespace App\Model\QuyKhenThuong;

use Illuminate\Database\Eloquent\Model;

class dsquanlyquykhenthuong extends Model
{
    protected $table = 'dsquanlyquykhenthuong';
    protected $fillable = [
        'id',
        'maso',
        'nam',
        'madonvi',
        'tenquy',
        'ghichu',
    ];
}
