<?php

namespace App\Http\Controllers\TraCuu;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\DanhMuc\dmdanhhieuthidua;
use App\Model\DanhMuc\dmhinhthuckhenthuong;
use App\Model\DanhMuc\dmloaihinhkhenthuong;
use App\Model\DanhMuc\dmnhomphanloai_chitiet;
use App\Model\View\view_tdkt_canhan;
use App\Model\View\view_tdkt_detai;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class tracuucanhanController extends Controller
{
    public static $url = '/TraCuu/CaNhan/';
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
        if (!chkPhanQuyen('timkiemcanhan', 'danhsach')) {
            return view('errors.noperm')
                ->with('machucnang', 'timkiemcanhan')
                ->with('tenphanquyen', 'danhsach');
        }
        //B1: xác định đơn vị
        // Nhập liệu => chỉ load địa bàn theo đơn
        //Xét duyêt; Khen thương => load địa bàn và địa bàn trực thuộc
        //B2:
        $inputs = $request->all();
        $inputs['url'] = static::$url;
        $a_canhan = array_column(dmnhomphanloai_chitiet::wherein('manhomphanloai', ['CANHAN'])->get()->toarray(), 'tenphanloai', 'maphanloai');
        $m_donvi = getDonVi(session('admin')->capdo);
        $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;
        $donvi = $m_donvi->where('madonvi', $inputs['madonvi'])->first();
        $m_diaban = getDiaBanTraCuu($donvi);
        $inputs['madiaban'] = $inputs['madiaban'] ?? 'ALL';
       // dd($m_diaban);
        $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;
        //lấy danh sách đơn vị theo địa bàn

        return view('TraCuu.CaNhan.ThongTin')
            ->with('inputs', $inputs)
            ->with('a_canhan', $a_canhan)
            ->with('a_donvi', array_column($m_donvi->toArray(), 'tendonvi', 'madonvi'))
            ->with('a_diaban', array_column($m_diaban->toArray(), 'tendiaban', 'madiaban'))
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('pageTitle', 'Tìm kiếm thông tin theo cá nhân');
    }


    public function KetQua(Request $request)
    {
        $inputs = $request->all();
        //Chưa tính trường hợp đơn vị
        $model_khenthuong = view_tdkt_canhan::where('trangthai', 'DKT');
        $model_detai = view_tdkt_detai::query();
        $this->TimKiem($model_khenthuong, $model_detai, $inputs);
        $a_dhkt = getDanhHieuKhenThuong('ALL');
        return view('TraCuu.CaNhan.KetQua')
            ->with('model_khenthuong', $model_khenthuong)
            ->with('model_detai', $model_detai)
            ->with('a_dhkt', $a_dhkt)
            ->with('phamvi', getPhamViApDung())
            ->with('inputs', $inputs)
            ->with('a_danhhieu', array_column(dmdanhhieuthidua::all()->toArray(), 'tendanhhieutd', 'madanhhieutd'))
            ->with('a_hinhthuckt', array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
            ->with('a_canhan', array_column(dmnhomphanloai_chitiet::all()->toarray(), 'tenphanloai', 'maphanloai'))
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('pageTitle', 'Kết quả tìm kiếm');
    }

    public function InKetQua(Request $request)
    {
        $inputs = $request->all();
        $model_khenthuong = view_tdkt_canhan::where('trangthai', 'DKT');
        $model_detai = view_tdkt_detai::query();
        $this->TimKiem($model_khenthuong, $model_detai, $inputs);
        $a_dhkt = getDanhHieuKhenThuong('ALL');

        return view('TraCuu.CaNhan.InKetQua')
            ->with('model_khenthuong', $model_khenthuong)
            ->with('model_detai', $model_detai)
            ->with('a_dhkt', $a_dhkt)
            ->with('phamvi', getPhamViApDung())
            ->with('inputs', $inputs)
            //->with('a_danhhieu', array_column(dmdanhhieuthidua::all()->toArray(), 'tendanhhieutd', 'madanhhieutd'))
            //->with('a_hinhthuckt', array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
            ->with('a_canhan', array_column(dmnhomphanloai_chitiet::all()->toarray(), 'tenphanloai', 'maphanloai'))
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('pageTitle', 'Kết quả tìm kiếm');
    }

    function TimKiem(&$model_khenthuong, &$model_detai, $inputs)
    {

        if ($inputs['tendoituong'] != '') {
            $model_khenthuong = $model_khenthuong->where('tendoituong', 'Like', '%' . $inputs['tendoituong'] . '%');
        }

        if ($inputs['tenphongban'] != '') {
            $model_khenthuong = $model_khenthuong->where('tenphongban', 'Like', '%' . $inputs['tenphongban'] . '%');
        }

        if ($inputs['tencoquan'] != null && $inputs['tencoquan'] != '')
            $model_khenthuong = $model_khenthuong->where('tencoquan', 'Like', '%' . $inputs['tencoquan'] . '%');

        if ($inputs['ngaytu'] != null)
            $model_khenthuong = $model_khenthuong->where('ngayqd', '>=', $inputs['ngaytu']);

        if ($inputs['ngayden'] != null)
            $model_khenthuong = $model_khenthuong->where('ngayqd', '<=', $inputs['ngayden']);

        if ($inputs['gioitinh'] != 'ALL')
            $model_khenthuong = $model_khenthuong->where('gioitinh', $inputs['gioitinh']);

        if ($inputs['maphanloaicanbo'] != 'ALL')
            $model_khenthuong = $model_khenthuong->where('maphanloaicanbo', $inputs['maphanloaicanbo']);

        if ($inputs['maloaihinhkt'] != 'ALL')
            $model_khenthuong = $model_khenthuong->where('maloaihinhkt', $inputs['maloaihinhkt']);
        //Lấy kết quả khen thưởng
        $model_khenthuong = $model_khenthuong->get();
        //dd($model_khenthuong);
        //Đề tài
        $model_detai = $model_detai->wherein('mahosotdkt', array_unique(array_column($model_khenthuong->toarray(), 'mahosotdkt')));
        if ($inputs['tendoituong'] != null && $inputs['tendoituong'] != '')
            $model_detai = $model_detai->where('tendoituong', 'Like', '%' . $inputs['tendoituong'] . '%');
        //Lấy kết quả đề tài
        $model_detai = $model_detai->get();
    }
}
