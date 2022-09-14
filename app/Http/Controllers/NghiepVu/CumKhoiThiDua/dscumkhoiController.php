<?php

namespace App\Http\Controllers\NghiepVu\CumKhoiThiDua;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\DanhMuc\dscumkhoi;
use App\Model\DanhMuc\dscumkhoi_chitiet;
use App\Model\DanhMuc\dsdonvi;
use App\Model\View\viewdiabandonvi;
use Illuminate\Support\Facades\Session;

class dscumkhoiController extends Controller
{
    public static $url = '/CumKhoiThiDua/CumKhoi/';
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

        if (!chkPhanQuyen('dscumkhoithidua', 'danhsach')) {
            return view('errors.noperm')->with('machucang', 'dscumkhoithidua')->with('tenphanquyen', 'danhsach');
        }
        $inputs = $request->all();
        $inputs['url'] = static::$url;
        $model = dscumkhoi::all();
        $m_chitiet = dscumkhoi_chitiet::all();
        foreach ($model as $ct) {
            $ct->sodonvi = $m_chitiet->where('macumkhoi', $ct->macumkhoi)->count();
        }
        //dd($model);
        $m_donvi = getDonVi(session('admin')->capdo);
        return view('NghiepVu.CumKhoiThiDua.DanhSach.ThongTin')
            ->with('model', $model)
            ->with('a_donvi', array_column($m_donvi->toArray(), 'tendonvi', 'madonvi'))
            ->with('a_capdo', getPhamViApDung())
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Danh sách cụm, khối thi đua');
    }

    public function ThayDoi(Request $request)
    {
        if (!chkPhanQuyen('dscumkhoithidua', 'thaydoi')) {
            return view('errors.noperm')->with('machucang', 'dscumkhoithidua')->with('tenphanquyen', 'thaydoi');
        }
        $inputs = $request->all();
        $inputs['macumkhoi'] = $inputs['macumkhoi'] ?? null;

        $model = dscumkhoi::where('macumkhoi', $inputs['macumkhoi'])->first();
        if ($model == null) {
            $model = new dscumkhoi();
            $model->macumkhoi = getdate()[0];
        }
        // $m_donvi = dsdonvi::wherein('madonvi', function ($qr) {
        //     $qr->select('madonviQL')->from('dsdiaban')->get();
        // })->get();
        return view('NghiepVu.CumKhoiThiDua.DanhSach.ThayDoi')
            ->with('model', $model)
            ->with('a_donvi', getDonViQuanLyCumKhoi($model->macumkhoi))
            ->with('pageTitle', 'Thông tin cụm, khối thi đua');
    }

    public function LuuCumKhoi(Request $request)
    {
        if (!chkPhanQuyen('dscumkhoithidua', 'thaydoi')) {
            return view('errors.noperm')->with('machucang', 'dscumkhoithidua')->with('tenphanquyen', 'thaydoi');
        }
        $inputs = $request->all();
        $model = dscumkhoi::where('macumkhoi', $inputs['macumkhoi'])->first();
        if ($model == null) {
            dscumkhoi::create($inputs);
        } else {
            $model->update($inputs);
        }
        return redirect(static::$url . 'ThongTin');
    }


    public function Xoa(Request $request)
    {
        if (!chkPhanQuyen('dscumkhoithidua', 'thaydoi')) {
            return view('errors.noperm')->with('machucang', 'dscumkhoithidua')->with('tenphanquyen', 'thaydoi');
        }
        $inputs = $request->all();
        dscumkhoi::findorfail($inputs['iddelete'])->delete();
        return redirect(static::$url . 'ThongTin');
    }


    public function DanhSach(Request $request)
    {
        $inputs = $request->all();
        $m_cumkhoi = dscumkhoi::where('macumkhoi', $inputs['macumkhoi'])->first();
        $model = dscumkhoi_chitiet::where('macumkhoi', $inputs['macumkhoi'])->get();
        $m_donvi = viewdiabandonvi::where('capdo', $m_cumkhoi->capdo)->get();
        return view('NghiepVu.CumKhoiThiDua.DanhSach.DanhSach')
            ->with('model', $model)
            ->with('m_cumkhoi', $m_cumkhoi)
            ->with('a_donvi', array_column($m_donvi->toArray(), 'tendonvi', 'madonvi'))
            ->with('a_phanloai', getPhanLoaiDonViCumKhoi())
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Thông tin đơn vị trong cụm, khối thi đua');
    }

    public function ThemDonVi(Request $request)
    {

        if (!chkPhanQuyen('dscumkhoithidua', 'thaydoi')) {
            return view('errors.noperm')->with('machucang', 'dscumkhoithidua')->with('tenphanquyen', 'thaydoi');
        }
        $inputs = $request->all();
        $model = dscumkhoi_chitiet::where('madonvi', $inputs['madonvi'])->where('macumkhoi', $inputs['macumkhoi'])->first();
        if ($model == null) {
            dscumkhoi_chitiet::create($inputs);
        } else {
            $model->update($inputs);
        }

        return redirect(static::$url . 'DanhSach?macumkhoi=' . $inputs['macumkhoi']);
    }

    public function XoaDonVi(Request $request)
    {

        if (!chkPhanQuyen('dscumkhoithidua', 'thaydoi')) {
            return view('errors.noperm')->with('machucang', 'dscumkhoithidua')->with('tenphanquyen', 'thaydoi');
        }
        $inputs = $request->all();
        $model = dscumkhoi_chitiet::findorfail($inputs['id']);
        $model->delete();
        return redirect(static::$url . 'DanhSach?macumkhoi=' . $model->macumkhoi);
    }
}
