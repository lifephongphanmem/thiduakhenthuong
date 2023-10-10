<?php

namespace App\Http\Controllers\NghiepVu\_DungChung;


use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\DanhMuc\dsdonvi;
use App\Model\DanhMuc\duthaoquyetdinh;
use App\Model\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi_tailieu;
use App\Model\NghiepVu\KhenCao\dshosokhencao_tailieu;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_canhan;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_tailieu;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_tapthe;
use Illuminate\Support\Facades\File;

class dungchung_duthaokhenthuongController extends Controller
{
    public function ToTrinhKhenThuong(Request $request)
    {
    }

    public function QuyetDinhKhenThuong(Request $request)
    {
        $inputs = $request->all();
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $a_duthao = array_column(duthaoquyetdinh::all()->toArray(), 'noidung', 'maduthao');
        $inputs['maduthao'] = $inputs['maduthao'] ?? array_key_first($a_duthao);
        if ($model->thongtinquyetdinh == '') {
            getTaoQuyetDinhKT($model);
        }

        return view('NghiepVu._DungChung.DuThao.QuyetDinhKhenThuong')
            ->with('model', $model)
            ->with('a_duthao', $a_duthao)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Quyết định khen thưởng');
    }

    public function TaoQuyetDinhKhenThuong(Request $request)
    {
        $inputs = $request->all();
        //dd($inputs);
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $model->thongtinquyetdinh = ''; //Gán trống để tạo dự thảo mới
        getTaoDuThaoKT($model, $inputs['maduthao']);
        //Gán các trường thông tin
        getTaoQuyetDinhKT($model);

        $a_duthao = array_column(duthaoquyetdinh::all()->toArray(), 'noidung', 'maduthao');

        return view('NghiepVu._DungChung.DuThao.QuyetDinhKhenThuong')
            ->with('model', $model)
            ->with('a_duthao', $a_duthao)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Quyết định khen thưởng');
    }

    public function LuuQuyetDinhKhenThuong(Request $request)
    {
        $inputs = $request->all();
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $model->thongtinquyetdinh = $inputs['thongtinquyetdinh'];
        $model->save();
        return redirect('DungChung/DuThao/QuyetDinhKhenThuong?mahosotdkt=' . $inputs['mahosotdkt']);
    }

    public function QuyetDinhCumKhoi(Request $request)
    {
        $inputs = $request->all();
        dd();
    }
}
