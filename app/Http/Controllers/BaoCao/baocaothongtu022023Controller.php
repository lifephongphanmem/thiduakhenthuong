<?php

namespace App\Http\Controllers\BaoCao;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\DanhMuc\dmhinhthuckhenthuong;
use App\Model\DanhMuc\dmloaihinhkhenthuong;
use App\Model\DanhMuc\dsdiaban;
use App\Model\DanhMuc\dsdonvi;
use App\Model\NghiepVu\KhenCao\dshosokhencao;
use App\Model\View\view_khencao_canhan;
use App\Model\View\view_khencao_tapthe;
use App\Model\View\view_tdkt_canhan;
use App\Model\View\view_tdkt_tapthe;
use App\Model\View\viewdiabandonvi;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class baocaothongtu022023Controller extends Controller
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

    public function Mau0601(Request $request)
    {
        //lấy phong trào thi đua và phong trao thi đua cụm khối
        $inputs = $request->all();
        $inputs['madiaban'] = $inputs['madiaban'] ?? 'ALL';
        $donvi = viewdiabandonvi::where('madonvi', $inputs['madonvi'])->first();
        $model = getDSPhongTrao($donvi);
        $model = $model->wherein('phamviapdung', ['TW', 'T', 'SBN']);
        $m_donvibc = dsdonvi::where('madonvi', $inputs['madonvi'])->first();
        return view('BaoCao.TT022023.Mau0601')
            ->with('model', $model)
            ->with('m_donvi', $m_donvibc)
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('a_phamvi', getPhamViPhongTrao())
            ->with('a_phanloai', getPhanLoaiPhongTraoThiDua(true))
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Báo cáo tổng hợp phong trào thi đua');
    }

    public function Mau0602(Request $request)
    {
        $inputs = $request->all();
        $inputs['madiaban'] = $inputs['madiaban'] ?? 'ALL';
        $donvi = viewdiabandonvi::where('madonvi', $inputs['madonvi'])->first();
        $model = dshosokhencao::all();
        $model_canhan = view_khencao_canhan::all();
        $model_tapthe = view_khencao_tapthe::all();
        $m_donvibc = dsdonvi::where('madonvi', $inputs['madonvi'])->first();
        return view('BaoCao.TT022023.Mau0601')
            ->with('model', $model)
            ->with('model_canhan', $model_canhan)
            ->with('model_tapthe', $model_tapthe)
            ->with('m_donvi', $m_donvibc)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Báo cáo tổng hợp số lượng khen thưởng cấp nhà nước');
    }

    public function Mau0603(Request $request)
    {
        $inputs = $request->all();
        $inputs['madiaban'] = $inputs['madiaban'] ?? 'ALL';
        $donvi = viewdiabandonvi::where('madonvi', $inputs['madonvi'])->first();
        $model = dshosokhencao::all();
        $model_canhan = view_khencao_canhan::all();
        $model_tapthe = view_khencao_tapthe::all();
        $m_donvibc = dsdonvi::where('madonvi', $inputs['madonvi'])->first();
        return view('BaoCao.TT022023.Mau0603')
            ->with('model', $model)
            ->with('m_donvi', $m_donvibc)
            ->with('model_canhan', $model_canhan)
            ->with('model_tapthe', $model_tapthe)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Báo cáo tổng hợp phong trào thi đua');
    }

    public function Mau0604(Request $request)
    {
        $inputs = $request->all();
        $inputs['madiaban'] = $inputs['madiaban'] ?? 'ALL';
        $donvi = viewdiabandonvi::where('madonvi', $inputs['madonvi'])->first();
        $model = dshosokhencao::all();
        $model_canhan = view_khencao_canhan::all();
        $model_tapthe = view_khencao_tapthe::all();
        $m_donvibc = dsdonvi::where('madonvi', $inputs['madonvi'])->first();
        return view('BaoCao.TT022023.Mau0604')
            ->with('model', $model)
            ->with('m_donvi', $m_donvibc)
            ->with('model_canhan', $model_canhan)
            ->with('model_tapthe', $model_tapthe)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Báo cáo tổng hợp phong trào thi đua');
    }

    public function Mau0605(Request $request)
    {
        $inputs = $request->all();
        $inputs['madiaban'] = $inputs['madiaban'] ?? 'ALL';
        $donvi = viewdiabandonvi::where('madonvi', $inputs['madonvi'])->first();
        $model = dshosokhencao::all();
        $model_canhan = view_khencao_canhan::all();
        $model_tapthe = view_khencao_tapthe::all();
        $m_donvibc = dsdonvi::where('madonvi', $inputs['madonvi'])->first();
        return view('BaoCao.TT022023.Mau0605')
            ->with('model', $model)
            ->with('m_donvi', $m_donvibc)
            ->with('model_canhan', $model_canhan)
            ->with('model_tapthe', $model_tapthe)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Báo cáo tổng hợp phong trào thi đua');
    }
    

    function getMaDiaBan(&$chitiet, $m_phanloai)
    {
        //Truyền vào đơn vị
        //gán madiaban: T, H, X căn cứ theo cấp độ
    }
}
