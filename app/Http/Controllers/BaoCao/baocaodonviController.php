<?php

namespace App\Http\Controllers\BaoCao;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\DanhMuc\dmdanhhieuthidua;
use App\Model\DanhMuc\dmhinhthuckhenthuong;
use App\Model\DanhMuc\dmloaihinhkhenthuong;
use App\Model\DanhMuc\dmnhomphanloai_chitiet;
use App\Model\DanhMuc\dsdonvi;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_khenthuong;
use App\Model\NghiepVu\ThiDuaKhenThuong\dsphongtraothidua;
use App\Model\View\view_tdkt_canhan;
use App\Model\View\view_tdkt_tapthe;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class baocaodonviController extends Controller
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
        if (!chkPhanQuyen('baocaodonvi', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'baocaodonvi')->with('tenphanquyen', 'danhsach');
        }

        $m_canhan = view_tdkt_canhan::where('trangthai', 'DKT')->get();
        $m_tapthe = view_tdkt_tapthe::where('trangthai', 'DKT')->get();
        $m_phongtrao = dsphongtraothidua::all();
        return view('BaoCao.DonVi.ThongTin')
            ->with('m_canhan', $m_canhan)
            ->with('m_tapthe', $m_tapthe)
            ->with('m_phongtrao', $m_phongtrao)
            ->with('pageTitle', 'Báo cáo theo đơn vị');
    }

    public function CaNhan(Request $request)
    {
        $inputs = $request->all();
        if (!isset($inputs['tendoituong'])) {
            return view('errors.403')
                ->with('message', 'Đối tượng tìm kiếm không được bỏ trống.')
                ->with('url', '/BaoCao/DonVi/ThongTin');
        }
        $m_khenthuong = view_tdkt_canhan::where('tendoituong', 'Like', '%' . $inputs['tendoituong'] . '%')
            ->where('ngayqd', '>=', $inputs['ngaytu'])
            ->where('ngayqd', '<=', $inputs['ngayden'])
            ->get();

        if (count($m_khenthuong) == 0) {
            return view('errors.403')
                ->with('message', 'Không tìm thấy đối tượng phù hợp với yêu cầu.')
                ->with('url', '/BaoCao/DonVi/ThongTin');
        }

        $m_donvi = dsdonvi::where('madonvi', $m_khenthuong->first()->madonvi)->first();

        return view('BaoCao.DonVi.MauChung.CaNhan')
            ->with('inputs', $inputs)
            ->with('model', $m_khenthuong->first())
            ->with('model_khenthuong', $m_khenthuong)
            ->with('m_donvi', $m_donvi)
            ->with('a_danhhieu', array_column(dmdanhhieuthidua::all()->toArray(), 'tendanhhieutd', 'madanhhieutd'))
            ->with('a_hinhthuckt', array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
            ->with('a_canhan', array_column(dmnhomphanloai_chitiet::all()->toarray(), 'tenphanloai', 'maphanloai'))
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('pageTitle', 'Báo cáo theo cá nhân');
    }

    public function TapThe(Request $request)
    {
        $inputs = $request->all();
        if (!isset($inputs['tentapthe'])) {
            return view('errors.403')
                ->with('message', 'Đối tượng tìm kiếm không được bỏ trống.')
                ->with('url', '/BaoCao/DonVi/ThongTin');
        }
        $m_khenthuong = view_tdkt_tapthe::where('tentapthe', 'Like', '%' . $inputs['tentapthe'] . '%')
            ->where('ngayqd', '>=', $inputs['ngaytu'])
            ->where('ngayqd', '<=', $inputs['ngayden'])
            ->get();

        if (count($m_khenthuong) == 0) {
            return view('errors.403')
                ->with('message', 'Không tìm thấy đối tượng phù hợp với yêu cầu.')
                ->with('url', '/BaoCao/DonVi/ThongTin');
        }
        $m_donvi = dsdonvi::where('madonvi', $m_khenthuong->first()->madonvi)->first();
        return view('BaoCao.DonVi.MauChung.TapThe')
            ->with('inputs', $inputs)
            ->with('model', $m_khenthuong->first())
            ->with('model_khenthuong', $m_khenthuong)
            ->with('m_donvi', $m_donvi)
            ->with('a_danhhieu', array_column(dmdanhhieuthidua::all()->toArray(), 'tendanhhieutd', 'madanhhieutd'))
            ->with('a_hinhthuckt', array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
            ->with('a_canhan', array_column(dmnhomphanloai_chitiet::all()->toarray(), 'tenphanloai', 'maphanloai'))
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('pageTitle', 'Báo cáo theo tập thể');
    }

    public function PhongTrao(Request $request)
    {
        $inputs = $request->all();
        $model = DangKyTd::where('kihieudhtd', $inputs['kihieudhtd'])->first();
        $m_donvi = DSDonVi::where('madonvi', $model->madonvi)->first();
        $m_tapthe = LapHoSoTd_KhenThuong::where('kihieudhtd', $inputs['kihieudhtd'])->where('phanloai', 'TAPTHE')->get();
        $m_canhan = LapHoSoTd_KhenThuong::where('kihieudhtd', $inputs['kihieudhtd'])->where('phanloai', 'CANHAN')->get();
        $m_danhhieu = dmdanhhieutd::all();

        return view('reports.DonVi.PhongTrao')
            ->with('inputs', $inputs)
            ->with('model', $model)
            ->with('m_tapthe', $m_tapthe)
            ->with('m_canhan', $m_canhan)
            ->with('m_donvi', $m_donvi)
            ->with('a_danhhieu', array_column($m_danhhieu->toArray(), 'tendanhhieutd', 'madanhhieutd'))
            ->with('a_donvi', array_column(DSDonVi::all()->toArray(), 'tendonvi', 'madonvi'))
            ->with('pageTitle', 'Báo cáo theo phong trào');
    }
}
