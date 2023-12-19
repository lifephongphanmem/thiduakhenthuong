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
use App\Model\View\viewdiabandonvi;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class APIthongtinchungController extends Controller
{
    public static $url = '/HeThongAPI/XuatDuLieu/';
    public function __construct()
    {
        // $this->middleware(function ($request, $next) {
        //     if (!Session::has('admin')) {
        //         return redirect('/');
        //     };
        //     return $next($request);
        // });
    }

    public function getToKen(Request $request)
    {        
        $inputs = $request->all();        
        $inputs['url'] = static::$url.'/CaNhan';       
        $m_donvi = getDonVi(session('admin')->capdo);
        $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;       

        return view('API.ThongTin')
            ->with('inputs', $inputs)            
            ->with('a_donvi', array_column($m_donvi->toArray(), 'tendonvi', 'madonvi'))
            ->with('pageTitle', 'Tìm kiếm thông tin theo cá nhân');
    }

    public function LoaiHinhKhenThuong(Request $request)
    {}

    public function HinhThucKhenThuong(Request $request)
    {}

    public function PhanLoaiDoiTuong(Request $request)
    {}

    public function DiaBanHanhChinh(Request $request)
    {}

    public function DonViSuDung(Request $request)
    {}

    public function LinhVucHoatDong(Request $request)
    {}   
}
