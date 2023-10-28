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

class APIketnoiController extends Controller
{
    public static $url = '/HeThongAPI/KetNoi/';
    public function __construct()
    {
        // $this->middleware(function ($request, $next) {
        //     if (!Session::has('admin')) {
        //         return redirect('/');
        //     };
        //     return $next($request);
        // });
    }

    public function QuanLyCanBo(Request $request)
    {        
        $inputs = $request->all();        
        $inputs['url'] = static::$url.'/CaNhan';       
        $m_donvi = getDonVi(session('admin')->capdo);
        $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;       

        return view('API.KetNoi.QuanLyCanBo')
            ->with('inputs', $inputs)            
            ->with('a_donvi', array_column($m_donvi->toArray(), 'tendonvi', 'madonvi'))
            ->with('pageTitle', 'Quản lý kết nối tới phần mềm quản lý cán bộ');
    }

    public function QuanLyVanBan(Request $request)
    {        
        $inputs = $request->all();        
        $inputs['url'] = static::$url.'/CaNhan';       
        $m_donvi = getDonVi(session('admin')->capdo);
        $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;       

        return view('API.KetNoi.QuanLyVanBan')
            ->with('inputs', $inputs)            
            ->with('a_donvi', array_column($m_donvi->toArray(), 'tendonvi', 'madonvi'))
            ->with('pageTitle', 'Quản lý kết nối tới phần mềm quản lý văn bản');
    }

    public function QuanLyLuuTru(Request $request)
    {        
        $inputs = $request->all();        
        $inputs['url'] = static::$url.'/CaNhan';       
        $m_donvi = getDonVi(session('admin')->capdo);
        $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;       

        return view('API.KetNoi.QuanLyLuuTru')
            ->with('inputs', $inputs)            
            ->with('a_donvi', array_column($m_donvi->toArray(), 'tendonvi', 'madonvi'))
            ->with('pageTitle', 'Quản lý kết nối tới phần mềm quản lý lưu trữ');
    }

    public function QuanLyTDKT(Request $request)
    {        
        $inputs = $request->all();        
        $inputs['url'] = static::$url.'/CaNhan';       
        $m_donvi = getDonVi(session('admin')->capdo);
        $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;       

        return view('API.KetNoi.QuanLyTDKT')
            ->with('inputs', $inputs)            
            ->with('a_donvi', array_column($m_donvi->toArray(), 'tendonvi', 'madonvi'))
            ->with('pageTitle', 'Quản lý kết nối tới phần mềm thi đua khen thưởng của Bộ nội vụ');
    }
}
