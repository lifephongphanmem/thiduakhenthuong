<?php

namespace App\Http\Controllers\TraCuu;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\DanhMuc\dmdanhhieuthidua;
use App\Model\DanhMuc\dmdanhhieuthidua_tieuchuan;
use App\Model\DanhMuc\dmhinhthuckhenthuong;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong;
use App\Model\View\view_cumkhoi_canhan;
use App\Model\View\view_tdkt_canhan;
use App\Model\View\view_tdkt_tapthe;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class tracuucanhanController extends Controller
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
        if (!chkPhanQuyen('timkiemcanhan', 'danhsach')) {
            return view('errors.noperm')
            ->with('machucang', 'timkiemcanhan')
            ->with('tenphanquyen', 'danhsach');
        }
        $inputs = $request->all();
        $model = dshosothiduakhenthuong::query();

        return view('TraCuu.CaNhan.ThongTin')           
            ->with('model', $model)
            ->with('model_danhhieu', $model)
            ->with('model_khenthuong', $model)
            ->with('model_detai', $model)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Tìm kiếm thông tin theo cá nhân');
    }

    public function KetQua(Request $request)
    {
        $inputs = $request->all();
        $model = view_tdkt_canhan::where('tendoituong', 'like', '%' . $inputs['tendoituong'] . '%');
        $m_cumkhoi = view_cumkhoi_canhan::where('tendoituong', 'Like', '%' . $inputs['tendoituong'] . '%');

        $model = $model->get();
        $m_cumkhoi = $m_cumkhoi->get();
        foreach ($m_cumkhoi as $khenthuong) {
            $model->add($khenthuong);
        }
        $detai = new Collection();
        foreach ($model as $chitiet) {
            if (isset($chitiet->tensangkien) && $chitiet->tensangkien != '')
                $detai->add($chitiet);
        }
        $model->first()->tendonvi = getThongTinDonVi($model->first()->madonvi, 'tendonvi');
        return view('TraCuu.CaNhan.KetQua')
            ->with('model', $model->first())
            ->with('khenthuong', $model)
            ->with('detai', $detai)
            ->with('a_danhhieu', array_column(dmdanhhieuthidua::all()->toArray(), 'tendanhhieutd', 'madanhhieutd'))
            ->with('a_hinhthuckt', array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
            ->with('pageTitle', 'Kết quả tìm kiếm');
    }
}
