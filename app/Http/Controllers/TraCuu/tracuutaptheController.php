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
use App\Model\DanhMuc\dmnhomphanloai_chitiet;
use App\Model\View\view_cumkhoi_canhan;
use App\Model\View\view_cumkhoi_tapthe;
use App\Model\View\view_tdkt_canhan;
use App\Model\View\view_tdkt_detai;
use App\Model\View\view_tdkt_tapthe;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class tracuutaptheController extends Controller
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
        $m_tapthe = view_tdkt_tapthe::all();
        return view('TraCuu.TapThe.ThongTin')
            ->with('m_tapthe', $m_tapthe)
            ->with('a_tapthe', array_column(dmnhomphanloai_chitiet::wherein('manhomphanloai', ['TAPTHE', 'HOGIADINH'])->get()->toarray(), 'tenphanloai', 'maphanloai'))
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('pageTitle', 'Tìm kiếm thông tin theo tập thể');
    }

    public function KetQua(Request $request)
    {
        $inputs = $request->all();
        //Chưa tính trường hợp đơn vị
        $model_khenthuong = view_tdkt_tapthe::where('trangthai', 'DKT');
        $this->TimKiem($model_khenthuong, $inputs);
        return view('TraCuu.TapThe.KetQua')
            ->with('model_khenthuong', $model_khenthuong)
            ->with('inputs', $inputs)
            ->with('a_danhhieu', array_column(dmdanhhieuthidua::all()->toArray(), 'tendanhhieutd', 'madanhhieutd'))
            ->with('a_hinhthuckt', array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
            ->with('a_tapthe', array_column(dmnhomphanloai_chitiet::all()->toarray(), 'tenphanloai', 'maphanloai'))
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('pageTitle', 'Kết quả tìm kiếm');
    }

    public function InKetQua(Request $request)
    {
        $inputs = $request->all();       
        $model_khenthuong = view_tdkt_tapthe::where('trangthai', 'DKT');
        $this->TimKiem($model_khenthuong,$inputs);        
        return view('TraCuu.TapThe.InKetQua')
            ->with('model_khenthuong', $model_khenthuong)  
            ->with('inputs', $inputs)
            ->with('a_danhhieu', array_column(dmdanhhieuthidua::all()->toArray(), 'tendanhhieutd', 'madanhhieutd'))
            ->with('a_hinhthuckt', array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
            ->with('a_tapthe', array_column(dmnhomphanloai_chitiet::all()->toarray(), 'tenphanloai', 'maphanloai'))
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('pageTitle', 'Kết quả tìm kiếm');
    }

    function TimKiem(&$model_khenthuong, $inputs){

        if ($inputs['tentapthe'] != '') {
            $model_khenthuong = $model_khenthuong->where('tentapthe', 'Like', '%' . $inputs['tentapthe'] . '%');
        }
       
        if ($inputs['ngaytu'] != null)
            $model_khenthuong = $model_khenthuong->where('ngayqd', '>=', $inputs['ngaytu']);

        if ($inputs['ngayden'] != null)
            $model_khenthuong = $model_khenthuong->where('ngayqd', '<=', $inputs['ngayden']);
      
        if ($inputs['maphanloaitapthe'] != 'ALL')
            $model_khenthuong = $model_khenthuong->where('maphanloaitapthe', $inputs['maphanloaitapthe']);

        if ($inputs['maloaihinhkt'] != 'ALL')
            $model_khenthuong = $model_khenthuong->where('maloaihinhkt', $inputs['maloaihinhkt']);
        //Lấy kết quả khen thưởng
        $model_khenthuong = $model_khenthuong->get();
    }
}
