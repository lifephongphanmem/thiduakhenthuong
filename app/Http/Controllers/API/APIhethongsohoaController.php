<?php

namespace App\Http\Controllers\API;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\DanhMuc\dmdanhhieuthidua;
use App\Model\DanhMuc\dmhinhthuckhenthuong;
use App\Model\DanhMuc\dmloaihinhkhenthuong;
use App\Model\DanhMuc\dmnhomphanloai_chitiet;
use App\Model\DanhMuc\dsdonvi;
use App\Model\View\view_tdkt_canhan;
use App\Model\View\view_tdkt_detai;
use App\Model\View\view_tdkt_tapthe;
use App\Model\View\viewdiabandonvi;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class APIhethongsohoaController extends Controller
{
    public static $url = '/HeThongAPI/XuatDuLieu/';

    public function getHoSoKhenThuong(Request $request)
    {
    }
    public function postHoSoKhenThuong(Request $request)
    {
    }
}
