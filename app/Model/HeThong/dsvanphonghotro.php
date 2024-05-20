<?php

namespace App\Model\HeThong;

use Illuminate\Database\Eloquent\Model;

class dsvanphonghotro extends Model
{
    protected $table = 'dsvanphonghotro';
    protected $fillable = [
        'id',
        'maso',
        'vanphong',
        'hoten',
        'chucvu',
        'sdt',
        'skype',
        'facebook',
        'stt',
        'email',
    ];
}
