<?php

namespace App\Http\Controllers\BaoCao;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\DanhMuc\dmdanhhieuthidua;
use App\Model\DanhMuc\dsdonvi;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_khenthuong;
use App\Model\NghiepVu\ThiDuaKhenThuong\dsphongtraothidua;
use App\Model\View\view_tdkt_canhan;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class baocaodonviController extends Controller
{
    public function ThongTin(Request $request)
    {
        if (Session::has('admin')) {
            if (!chkPhanQuyen()) {
                return view('errors.noperm');
            }
            $m_canhan = view_tdkt_canhan::all();
            $m_tapthe = view_tdkt_canhan::all();
            $m_phongtrao = dsphongtraothidua::all();
            return view('BaoCao.DonVi.ThongTin')
            ->with('m_canhan', $m_canhan)
            ->with('m_tapthe', $m_tapthe)
            ->with('m_phongtrao', $m_phongtrao)
                ->with('pageTitle', 'Báo cáo theo đơn vị');
        } else
            return view('errors.notlogin');
    }   
    
    public function CaNhan(Request $request)
    {
        if (Session::has('admin')) {
            $inputs = $request->all();
            $model = view_tdkt_canhan::where('madoituong',$inputs['madt'])->first();
            $m_donvi = dsdonvi::where('madonvi',$model->madonvi)->first();
            $m_khenthuong = dshosothiduakhenthuong_khenthuong::where('madoituong',$inputs['madt'])->get();
            //dd($m_khenthuong);
            $m_danhhieu = dmdanhhieuthidua::all();
            $m_phongtrao = dsphongtraothidua::all();
            foreach ($m_khenthuong as $khenthuong) {
                $phongtrao = $m_phongtrao->where('maphongtraotd', $khenthuong->maphongtraotd)->first();
                $khenthuong->noidung = $phongtrao->noidung ?? '';
                $khenthuong->tungay = $phongtrao->tungay ?? '';
                $khenthuong->denngay = $phongtrao->denngay ?? '';
            }
            return view('BaoCao.DonVi.MauChung.CaNhan')
                ->with('inputs', $inputs)
                ->with('model', $model)
                 ->with('m_khenthuong', $model)
                ->with('m_donvi', $m_donvi)
                ->with('a_danhhieu', array_column($m_danhhieu->toArray(), 'tendanhhieutd','madanhhieutd'))
                ->with('pageTitle', 'Báo cáo theo cá nhân');

        } else
            return view('errors.notlogin');
    }

    public function TapThe(Request $request)
    {
        if (Session::has('admin')) {
            $inputs = $request->all();
            $model = qldoituong::where('madonvi',$inputs['madonvi'])->first();
            $m_donvi = DSDonVi::where('madonvi',$model->madonvi)->first();
            $m_khenthuong = LapHoSoTd_KhenThuong::where('madonvi',$inputs['madonvi'])->where('phanloai','TAPTHE')->get();
            $m_danhhieu = dmdanhhieutd::all();
            $m_phongtrao = DangKyTd::all();
            foreach ($m_khenthuong as $khenthuong) {
                $phongtrao = $m_phongtrao->where('kihieudhtd', $khenthuong->kihieudhtd)->first();
                $khenthuong->noidung = $phongtrao->noidung ?? '';
                $khenthuong->tungay = $phongtrao->tungay ?? '';
                $khenthuong->denngay = $phongtrao->denngay ?? '';
            }
            return view('reports.DonVi.TapThe')
                ->with('inputs', $inputs)
                ->with('model', $model)
                ->with('m_khenthuong', $m_khenthuong)
                ->with('m_donvi', $m_donvi)
                ->with('a_danhhieu', array_column($m_danhhieu->toArray(), 'tendanhhieutd','madanhhieutd'))
                ->with('pageTitle', 'Báo cáo theo tập thể');

        } else
            return view('errors.notlogin');
    }

    public function PhongTrao(Request $request)
    {
        if (Session::has('admin')) {
            $inputs = $request->all();
            $model = DangKyTd::where('kihieudhtd',$inputs['kihieudhtd'])->first();
            $m_donvi = DSDonVi::where('madonvi',$model->madonvi)->first();
            $m_tapthe = LapHoSoTd_KhenThuong::where('kihieudhtd',$inputs['kihieudhtd'])->where('phanloai','TAPTHE')->get();
            $m_canhan = LapHoSoTd_KhenThuong::where('kihieudhtd',$inputs['kihieudhtd'])->where('phanloai','CANHAN')->get();
            $m_danhhieu = dmdanhhieutd::all();

            return view('reports.DonVi.PhongTrao')
                ->with('inputs', $inputs)
                ->with('model', $model)
                ->with('m_tapthe', $m_tapthe)
                ->with('m_canhan', $m_canhan)
                ->with('m_donvi', $m_donvi)
                ->with('a_danhhieu', array_column($m_danhhieu->toArray(), 'tendanhhieutd','madanhhieutd'))
                ->with('a_donvi', array_column(DSDonVi::all()->toArray(), 'tendonvi','madonvi'))
                ->with('pageTitle', 'Báo cáo theo phong trào');

        } else
            return view('errors.notlogin');
    }

}
