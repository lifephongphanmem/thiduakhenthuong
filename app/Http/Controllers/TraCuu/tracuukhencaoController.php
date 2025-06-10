<?php

namespace App\Http\Controllers\TraCuu;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\DanhMuc\dmdanhhieuthidua;
use App\Model\DanhMuc\dmhinhthuckhenthuong;
use App\Model\DanhMuc\dmloaihinhkhenthuong;
use App\Model\DanhMuc\dmnhomphanloai_chitiet;
use App\Model\View\view_khencao_canhan;
use App\Model\View\view_khencao_tapthe;
use App\Model\View\viewdiabandonvi;
use Illuminate\Support\Facades\Session;

class tracuukhencaoController extends Controller
{
    public static $url = '/TraCuu/KhenCao/';
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Session::has('admin')) {
                return redirect('/');
            };
            return $next($request);
        });
    }
    public function ThongTinCaNhan(Request $request)
    {
        if (!chkPhanQuyen('timkiemkhencaocanhan', 'danhsach')) {
            return view('errors.noperm')
                ->with('machucnang', 'timkiemkhencaocanhan')
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

        return view('TraCuu.KhenCao.CaNhan.ThongTin')
            ->with('inputs', $inputs)
            ->with('a_canhan', $a_canhan)
            ->with('a_donvi', array_column($m_donvi->toArray(), 'tendonvi', 'madonvi'))
            ->with('a_diaban', array_column($m_diaban->toArray(), 'tendiaban', 'madiaban'))
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('pageTitle', 'Tìm kiếm thông tin theo cá nhân');
    }
    public function KetQuaCaNhan(Request $request)
    {
        $inputs = $request->all();
        //Chưa tính trường hợp đơn vị

        //Nếu đơn vị quản lý địa bàn => xem đc tất cả
        //Nếu đơn vị nhập liệu => chỉ xem hồ sơ đơn vị gửi
        $model_khenthuong = view_khencao_canhan::where('trangthai', 'DKT');
        // $model_detai = view_tdkt_detai::query();
        $this->TimKiem($model_khenthuong, $inputs);
        $a_dhkt = getDanhHieuKhenThuong('ALL');
        //dd( $model_khenthuong->toarray());
        return view('TraCuu.KhenCao.CaNhan.KetQua')
            ->with('model_khenthuong', $model_khenthuong)
            ->with('a_dhkt', $a_dhkt)
            ->with('phamvi', getPhamViApDung())
            ->with('inputs', $inputs)
            ->with('a_danhhieu', array_column(dmdanhhieuthidua::all()->toArray(), 'tendanhhieutd', 'madanhhieutd'))
            ->with('a_hinhthuckt', array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
            ->with('a_canhan', array_column(dmnhomphanloai_chitiet::all()->toarray(), 'tenphanloai', 'maphanloai'))
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('pageTitle', 'Kết quả tìm kiếm');
    }
    public function InKetQuaCaNhan(Request $request)
    {
        $inputs = $request->all();
        // dd($inputs);
        $model_khenthuong = view_khencao_canhan::where('trangthai', 'DKT');
        // $model_detai = view_tdkt_detai::query();
        $this->TimKiem($model_khenthuong, $inputs);
        $a_dhkt = getDanhHieuKhenThuong('ALL');

        return view('TraCuu.KhenCao.CaNhan.InKetQua')
            ->with('model_khenthuong', $model_khenthuong)
            ->with('a_dhkt', $a_dhkt)
            ->with('phamvi', getPhamViApDung())
            ->with('inputs', $inputs)
            //->with('a_danhhieu', array_column(dmdanhhieuthidua::all()->toArray(), 'tendanhhieutd', 'madanhhieutd'))
            //->with('a_hinhthuckt', array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
            ->with('a_canhan', array_column(dmnhomphanloai_chitiet::all()->toarray(), 'tenphanloai', 'maphanloai'))
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('pageTitle', 'Kết quả tìm kiếm');
    }
    function TimKiem(&$model_khenthuong, $inputs)
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

        //Lọc các kết quả khen thưởng trên địa bàn
        $donvi = viewdiabandonvi::where('madonvi', $inputs['madonvi'])->first();
        //đơn vị Phê duyệt xem đc tất cả dữ liệu
        // if($donvi->madonvi == $donvi->madonviQL){
        if (in_array($donvi->madonvi, [$donvi->madonviQL, $donvi->madonviKT])) {
            $a_diaban = array_column(getDiaBanTraCuu($donvi)->toarray(), 'madiaban');
            // dd($m_diaban);
            if ($inputs['madiaban'] == 'ALL')
                $model_khenthuong = $model_khenthuong->wherein('madiaban', $a_diaban);
            // $model_khenthuong = $model_khenthuong->get();
            else
                $model_khenthuong = $model_khenthuong->where('madiaban', $inputs['madiaban']);
        } else {
            $model_khenthuong = $model_khenthuong->where('madonvi', $inputs['madonvi']);
        }
        //dd($donvi);        

        //Lấy kết quả khen thưởng
        $model_khenthuong = $model_khenthuong->get();
        //dd($a_diaban);
    }
    public function ThongTinTapThe(Request $request)
    {
        if (!chkPhanQuyen('timkiemkhencaotapthe', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'timkiemkhencaotapthe')->with('tenphanquyen', 'danhsach');
        }
        $inputs = $request->all();
        $inputs['url'] = static::$url;
        $m_tapthe = view_khencao_tapthe::all();
        $m_donvi = getDonVi(session('admin')->capdo);
        $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;
        return view('TraCuu.KhenCao.TapThe.ThongTin')
            ->with('m_tapthe', $m_tapthe)
            ->with('a_donvi', array_column($m_donvi->toArray(), 'tendonvi', 'madonvi'))
            ->with('a_tapthe', array_column(dmnhomphanloai_chitiet::wherein('manhomphanloai', ['TAPTHE', 'HOGIADINH'])->get()->toarray(), 'tenphanloai', 'maphanloai'))
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Tìm kiếm thông tin theo tập thể');
    }
    public function KetQuaTapThe(Request $request)
    {
        $inputs = $request->all();
        //Chưa tính trường hợp đơn vị
        $model_khenthuong = view_khencao_tapthe::where('trangthai', 'DKT');
        $this->TimKiemTapThe($model_khenthuong, $inputs);
        $a_dhkt = getDanhHieuKhenThuong('ALL');
        return view('TraCuu.KhenCao.TapThe.KetQua')
            ->with('model_khenthuong', $model_khenthuong)
            ->with('a_dhkt', $a_dhkt)
            ->with('inputs', $inputs)
            ->with('phamvi', getPhamViApDung())
            ->with('a_linhvuc', getLinhVucHoatDong())
            //->with('a_danhhieu', array_column(dmdanhhieuthidua::all()->toArray(), 'tendanhhieutd', 'madanhhieutd'))
            //->with('a_hinhthuckt', array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
            ->with('a_tapthe', array_column(dmnhomphanloai_chitiet::all()->toarray(), 'tenphanloai', 'maphanloai'))
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('pageTitle', 'Kết quả tìm kiếm tập thể');
    }
    public function InKetQuaTapThe(Request $request)
    {
        $inputs = $request->all();
        $model_khenthuong = view_khencao_tapthe::where('trangthai', 'DKT');
        $this->TimKiemTapThe($model_khenthuong, $inputs);
        $a_dhkt = getDanhHieuKhenThuong('ALL');
        return view('TraCuu.KhenCao.TapThe.InKetQua')
            ->with('model_khenthuong', $model_khenthuong)
            ->with('a_dhkt', $a_dhkt)
            ->with('phamvi', getPhamViApDung())
            ->with('inputs', $inputs)
            ->with('a_danhhieu', array_column(dmdanhhieuthidua::all()->toArray(), 'tendanhhieutd', 'madanhhieutd'))
            ->with('a_hinhthuckt', array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
            ->with('a_tapthe', array_column(dmnhomphanloai_chitiet::all()->toarray(), 'tenphanloai', 'maphanloai'))
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('pageTitle', 'Kết quả tìm kiếm tập thể');
    }
    function TimKiemTapThe(&$model_khenthuong, $inputs)
    {
        if ($inputs['tentapthe'] != '') {
            $model_khenthuong = $model_khenthuong->where('tentapthe', 'Like', '%' . $inputs['tentapthe'] . '%');
        }

        if ($inputs['ngaytu'] != null)
            $model_khenthuong = $model_khenthuong->where('ngayqd', '>=', $inputs['ngaytu']);

        if ($inputs['ngayden'] != null)
            $model_khenthuong = $model_khenthuong->where('ngayqd', '<=', $inputs['ngayden']);

        if ($inputs['maphanloaitapthe'] != 'ALL')
            $model_khenthuong = $model_khenthuong->where('maphanloaitapthe', $inputs['maphanloaitapthe']);

        if ($inputs['linhvuchoatdong'] != 'ALL')
            $model_khenthuong = $model_khenthuong->where('linhvuchoatdong', $inputs['linhvuchoatdong']);

        if ($inputs['maloaihinhkt'] != 'ALL')
            $model_khenthuong = $model_khenthuong->where('maloaihinhkt', $inputs['maloaihinhkt']);

        //Lọc các kết quả khen thưởng trên địa bàn
        $donvi = viewdiabandonvi::where('madonvi', $inputs['madonvi'])->first();

        //đơn vị Phê duyệt xem đc tất cả dữ liệu
        // if ($donvi->madonvi == $donvi->madonviQL) {
        if (in_array($donvi->madonvi, [$donvi->madonviQL, $donvi->madonviKT])) {
            $a_diaban = array_column(getDiaBanTraCuu($donvi)->toarray(), 'madiaban');
            $model_khenthuong = $model_khenthuong->wherein('madiaban', $a_diaban);
        } else {
            $model_khenthuong = $model_khenthuong->where('madonvi', $inputs['madonvi']);
        }
        //Lọc các kết quả khen thưởng trên địa bàn
        // $donvi = dsdonvi::where('madonvi', $inputs['madonvi'])->first();
        // $a_diaban = array_column(getDiaBanTraCuu($donvi)->toarray(), 'madiaban');
        // // dd($m_diaban);
        // if ($inputs['madiaban'] == 'ALL')
        //     $model_khenthuong = $model_khenthuong->wherein('madiaban', $a_diaban);
        // else
        //     $model_khenthuong = $model_khenthuong->where('madiaban', $inputs['madiaban']);

        //Lấy kết quả khen thưởng
        $model_khenthuong = $model_khenthuong->get();
    }
}
