<?php

namespace App\Http\Controllers\TraCuu;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\DanhMuc\dmdanhhieuthidua;
use App\Model\DanhMuc\dmdanhhieuthidua_tieuchuan;
use App\Model\DanhMuc\dmhinhthuckhenthuong;
use App\Model\DanhMuc\dmloaihinhkhenthuong;
use App\Model\View\view_cumkhoi_canhan;
use App\Model\View\view_cumkhoi_tapthe;
use App\Model\View\view_tdkt_canhan;
use App\Model\View\view_tdkt_tapthe;
use App\Model\View\viewdonvi_dsphongtrao;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class tracuuphongtraoController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Session::has('admin')) {
                return redirect('/');
            };
            return $next($request);
        });
    }
    public function ThongTin(Request $request)
    {
        if (!chkPhanQuyen('timkiemphongtrao', 'danhsach')) {
            return view('errors.noperm')->with('machucang', 'timkiemphongtrao')->with('tenphanquyen', 'danhsach');
        }
        $m_donvi = getDonVi(session('admin')->capdo);
        $m_diaban = getDiaBan(session('admin')->capdo);
        return view('TraCuu.PhongTrao.ThongTin')
            ->with('a_donvi', setArrayAll(array_column($m_donvi->toArray(), 'tendonvi', 'madonvi')))
            ->with('a_diaban', setArrayAll(array_column($m_diaban->toArray(), 'tendiaban', 'madiaban')))
            ->with('a_phamvi', setArrayAll(getPhamViPhongTrao()))
            ->with('a_phanloai', getPhanLoaiPhongTraoThiDua(true))
            ->with('pageTitle', 'Tìm kiếm thông tin phong trào thi đua');
    }

    public function KetQua(Request $request)
    {

        $inputs = $request->all();
        $model = viewdonvi_dsphongtrao::wherein('trangthai', ['CC', 'CXKT', 'DXKT', 'DKT']);
        if ($inputs['madiaban'] != 'ALL')
            $model = $model->where('madiaban', $inputs['madiaban']);
        if ($inputs['madonvi'] != 'ALL')
            $model = $model->where('madonvi', $inputs['madonvi']);
        if ($inputs['phamviapdung'] != 'ALL')
            $model = $model->where('phamviapdung', $inputs['phamviapdung']);
        if ($inputs['phanloai'] != 'ALL')
            $model = $model->where('phanloai', $inputs['phanloai']);
        return view('TraCuu.PhongTrao.KetQua')
            ->with('model', $model->get())
            ->with('a_phamvi', setArrayAll(getPhamViPhongTrao()))
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('a_phanloai', getPhanLoaiPhongTraoThiDua(true))
            ->with('pageTitle', 'Kết quả tìm kiếm phong trào thi đua');
    }
}
