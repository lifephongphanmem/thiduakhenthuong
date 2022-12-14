<?php

namespace App\Http\Controllers\NghiepVu\_DungChung;


use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\DanhMuc\dmhinhthuckhenthuong;
use App\Model\DanhMuc\dmloaihinhkhenthuong;
use App\Model\DanhMuc\dmnhomphanloai_chitiet;
use App\Model\DanhMuc\dmtoadoinphoi;
use App\Model\DanhMuc\dsdonvi;
use App\Model\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi;
use App\Model\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi_canhan;
use App\Model\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi_hogiadinh;
use App\Model\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi_tapthe;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothamgiaphongtraotd;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_canhan;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_hogiadinh;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_tapthe;
use App\Model\NghiepVu\ThiDuaKhenThuong\dsphongtraothidua;

class dungchung_inphoi_khenthuongController extends Controller
{

    public function DanhSach(Request $request)
    {
        $inputs = $request->all();
        $model =  dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $model_canhan = dshosothiduakhenthuong_canhan::where('mahosotdkt', $model->mahosotdkt)->get();
        $model_tapthe = dshosothiduakhenthuong_tapthe::where('mahosotdkt', $model->mahosotdkt)->get();
        $m_donvi = dsdonvi::where('madonvi', $model->madonvi)->first();
        $a_dhkt = getDanhHieuKhenThuong('ALL');
        $model->tendonvi = $m_donvi->tendonvi;
        return view('NghiepVu._DungChung.InPhoi')
            ->with('a_dhkt', $a_dhkt)
            ->with('model', $model)
            ->with('model_canhan', $model_canhan)
            ->with('model_tapthe', $model_tapthe)
            ->with('m_donvi', $m_donvi)
            //->with('a_danhhieu', array_column(dmdanhhieuthidua::all()->toArray(), 'tendanhhieutd', 'madanhhieutd'))
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('a_hinhthuckt', array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
            ->with('inputs', $inputs)
            ->with('pageTitle', 'In bằng khen');
    }

    public function InBangKhen(Request $request)
    {
        $inputs = $request->all();
        $inputs['phanloaikhenthuong'] = $inputs['phanloaikhenthuong'] ?? 'KHENTHUONG';
        $inputs['phanloaidoituong'] = $inputs['phanloaidoituong'] ?? 'CANHAN';
        $inputs['phanloaiphoi'] = 'BANGKHEN';
        $tendoituong = '';
        switch ($inputs["phanloaikhenthuong"]) {
            case "KHENTHUONG": {
                    switch ($inputs["phanloaidoituong"]) {
                        case "TAPTHE": {
                                //dd($this->setViTri($inputs));
                                $model = dshosothiduakhenthuong_tapthe::where('id', $inputs['id'])->get();
                                $tendoituong = 'tentapthe';
                                break;
                            }
                        case "CANHAN": {
                                $model = dshosothiduakhenthuong_canhan::where('id', $inputs['id'])->get();
                                $tendoituong = 'tendoituong';
                                break;
                            }
                        case "HOGIADINH": {
                                $model = dshosothiduakhenthuong_hogiadinh::where('id', $inputs['id'])->get();
                                $tendoituong = 'tentapthe';
                                break;
                            }
                    }
                    $m_hoso = dshosothiduakhenthuong::where('mahosotdkt', $model->first()->mahosotdkt)->first();
                    break;
                }
            case "CUMKHOI": {
                    switch ($inputs["phanloaidoituong"]) {
                        case "TAPTHE": {
                                $model = dshosotdktcumkhoi_tapthe::where('id', $inputs['id'])->get();
                                $tendoituong = 'tentapthe';
                                break;
                            }
                        case "CANHAN": {
                                $model = dshosotdktcumkhoi_canhan::where('id', $inputs['id'])->get();
                                $tendoituong = 'tendoituong';
                                break;
                            }
                        case "HOGIADINH": {
                                $model = dshosotdktcumkhoi_hogiadinh::where('id', $inputs['id'])->get();
                                $tendoituong = 'tentapthe';
                                break;
                            }
                    }
                    $m_hoso = dshosotdktcumkhoi::where('mahosotdkt', $model->first()->mahosotdkt)->first();
                    break;
                }
        }

        $m_donvi = dsdonvi::where('madonvi', $m_hoso->madonvi)->first();
        $m_toado = dmtoadoinphoi::where('phanloaikhenthuong', $inputs['phanloaikhenthuong'])
            ->where('phanloaidoituong', $inputs['phanloaidoituong'])
            ->where('phanloaiphoi', $inputs['phanloaiphoi'])
            ->where('madonvi', $m_hoso->madonvi)->first();
            
        foreach ($model as $doituong) {
            $doituong->noidungkhenthuong = catchuoi(($doituong->noidungkhenthuong != '' ? $doituong->noidungkhenthuong : 'Nội dung khen thưởng'), $m_donvi->sochu);
            $doituong->chucvunguoikyqd = $doituong->chucvunguoikyqd != '' ? $doituong->chucvunguoikyqd : ($m_hoso->chucvunguoikyqd != '' ? $m_hoso->chucvunguoikyqd : 'Chức vụ người ký');
            $doituong->hotennguoikyqd = $doituong->hotennguoikyqd != '' ? $doituong->hotennguoikyqd : ($m_hoso->hotennguoikyqd != '' ? $m_hoso->hotennguoikyqd : 'Họ tên người ký');
            $doituong->ngayqd = $doituong->ngayqd != '' ? $doituong->ngayqd : ($m_donvi->diadanh . ', ' . Date2Str($m_hoso->ngayhoso));
            $doituong->tendoituongin = $doituong->tendoituongin != '' ? $doituong->tendoituongin : $doituong->$tendoituong;
            
            $doituong->toado_tendoituongin = $doituong->toado_tendoituongin != '' ? $doituong->toado_tendoituongin : ($m_toado->toado_tendoituongin ?? '');
            $doituong->toado_noidungkhenthuong = $doituong->toado_noidungkhenthuong != '' ? $doituong->toado_noidungkhenthuong : ($m_toado->toado_noidungkhenthuong ?? '');
            $doituong->toado_ngayqd = $doituong->toado_ngayqd != '' ? $doituong->toado_ngayqd : ($m_toado->toado_ngayqd ?? '');
            $doituong->toado_chucvunguoikyqd = $doituong->toado_chucvunguoikyqd != '' ? $doituong->toado_chucvunguoikyqd : ($m_toado->toado_chucvunguoikyqd ?? '');
            $doituong->toado_hotennguoikyqd = $doituong->toado_hotennguoikyqd != '' ? $doituong->toado_hotennguoikyqd : ($m_toado->toado_hotennguoikyqd ?? '');
        }
        //dd($model);
        return view('BaoCao.DonVi.InBangKhenTapThe')
            ->with('model', $model)
            ->with('m_hoso', $m_hoso)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'In bằng khen tập thể');
    }

    public function InGiayKhen(Request $request)
    {
        $inputs = $request->all();
        $inputs['phanloaikhenthuong'] = $inputs['phanloaikhenthuong'] ?? 'KHENTHUONG';
        $inputs['phanloaidoituong'] = $inputs['phanloaidoituong'] ?? 'CANHAN';
        $inputs['phanloaiphoi'] = 'GIAYKHEN';
        $tendoituong = '';
        switch ($inputs["phanloaikhenthuong"]) {
            case "KHENTHUONG": {
                    switch ($inputs["phanloaidoituong"]) {
                        case "TAPTHE": {
                                //dd($this->setViTri($inputs));
                                $model = dshosothiduakhenthuong_tapthe::where('id', $inputs['id'])->get();
                                $tendoituong = 'tentapthe';
                                break;
                            }
                        case "CANHAN": {
                                $model = dshosothiduakhenthuong_canhan::where('id', $inputs['id'])->get();
                                $tendoituong = 'tendoituong';
                                break;
                            }
                        case "HOGIADINH": {
                                $model = dshosothiduakhenthuong_hogiadinh::where('id', $inputs['id'])->get();
                                $tendoituong = 'tentapthe';
                                break;
                            }
                    }
                    $m_hoso = dshosothiduakhenthuong::where('mahosotdkt', $model->first()->mahosotdkt)->first();
                    break;
                }
            case "CUMKHOI": {
                    switch ($inputs["phanloaidoituong"]) {
                        case "TAPTHE": {
                                $model = dshosotdktcumkhoi_tapthe::where('id', $inputs['id'])->get();
                                $tendoituong = 'tentapthe';
                                break;
                            }
                        case "CANHAN": {
                                $model = dshosotdktcumkhoi_canhan::where('id', $inputs['id'])->get();
                                $tendoituong = 'tendoituong';
                                break;
                            }
                        case "HOGIADINH": {
                                $model = dshosotdktcumkhoi_hogiadinh::where('id', $inputs['id'])->get();
                                $tendoituong = 'tentapthe';
                                break;
                            }
                    }
                    $m_hoso = dshosotdktcumkhoi::where('mahosotdkt', $model->first()->mahosotdkt)->first();
                    break;
                }
        }

        $m_donvi = dsdonvi::where('madonvi', $m_hoso->madonvi)->first();
        $m_toado = dmtoadoinphoi::where('phanloaikhenthuong', $inputs['phanloaikhenthuong'])
            ->where('phanloaidoituong', $inputs['phanloaidoituong'])
            ->where('phanloaiphoi', $inputs['phanloaiphoi'])
            ->where('madonvi', $m_hoso->madonvi)->first();
        foreach ($model as $doituong) {
            $doituong->noidungkhenthuong = catchuoi(($doituong->noidungkhenthuong != '' ? $doituong->noidungkhenthuong : 'Nội dung khen thưởng'), $m_donvi->sochu);
            $doituong->chucvunguoikyqd = $doituong->chucvunguoikyqd != '' ? $doituong->chucvunguoikyqd : ($m_hoso->chucvunguoikyqd != '' ? $m_hoso->chucvunguoikyqd : 'Chức vụ người ký');
            $doituong->hotennguoikyqd = $doituong->hotennguoikyqd != '' ? $doituong->hotennguoikyqd : ($m_hoso->hotennguoikyqd != '' ? $m_hoso->hotennguoikyqd : 'Họ tên người ký');
            $doituong->ngayqd = $doituong->ngayqd != '' ? $doituong->ngayqd : ($m_donvi->diadanh . ', ' . Date2Str($m_hoso->ngayhoso));
            $doituong->tendoituongin = $doituong->tendoituongin != '' ? $doituong->tendoituongin : $doituong->$tendoituong;

            $doituong->toado_tendoituongin = $doituong->toado_tendoituongin != '' ? $doituong->toado_tendoituongin : ($m_toado->toado_tendoituongin ?? '');
            $doituong->toado_noidungkhenthuong = $doituong->toado_noidungkhenthuong != '' ? $doituong->toado_noidungkhenthuong : ($m_toado->toado_noidungkhenthuong ?? '');
            $doituong->toado_ngayqd = $doituong->toado_ngayqd != '' ? $doituong->toado_ngayqd : ($m_toado->toado_ngayqd ?? '');
            $doituong->toado_chucvunguoikyqd = $doituong->toado_chucvunguoikyqd != '' ? $doituong->toado_chucvunguoikyqd : ($m_toado->toado_chucvunguoikyqd ?? '');
            $doituong->toado_hotennguoikyqd = $doituong->toado_hotennguoikyqd != '' ? $doituong->toado_hotennguoikyqd : ($m_toado->toado_hotennguoikyqd ?? '');
        }
        //dd($m_hoso);
        return view('BaoCao.DonVi.InGiayKhenTapThe')
            ->with('model', $model)
            ->with('m_hoso', $m_hoso)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'In bằng khen cá nhân');
    }


    // public function NoiDungKhenThuong(Request $request)
    // {
    //     $inputs = $request->all();

    //     if ($inputs['phanloai'] == 'CANHAN') {
    //         $model = dshosothiduakhenthuong_canhan::where('id', $inputs['id'])->first();
    //         $model->noidungkhenthuong = $inputs['noidungkhenthuong'];
    //         $model->save();
    //     } else {
    //         $model = dshosothiduakhenthuong_tapthe::where('id', $inputs['id'])->first();
    //         $model->noidungkhenthuong = $inputs['noidungkhenthuong'];
    //         $model->save();
    //     }
    //     //dd($m_hoso);
    //     return redirect($inputs['url'] . 'InPhoi?mahosotdkt=' . $model->mahosotdkt);
    // }
}
