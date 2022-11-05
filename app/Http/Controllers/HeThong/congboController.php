<?php

namespace App\Http\Controllers\HeThong;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\DanhMuc\dsdiaban;
use App\Model\DanhMuc\dsdonvi;
use App\Model\DanhMuc\dstaikhoan;
use App\Model\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong;
use App\Model\VanBan\dsquyetdinhkhenthuong;
use App\Model\VanBan\dsvanbanphaply;
use Illuminate\Support\Facades\Session;

class congboController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function TrangChu(Request $request)
    {
        $inputs = $request->all();
        $inputs['url'] = '/QuanLyVanBan/VanBanPhapLy';
        //$model = dsvanbanphaply::all();
        return view('CongBo.TrangChu')
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Thi đua khen thưởng');
    }

    public function VanBan(Request $request)
    {
        $inputs = $request->all();
        $inputs['url'] = '/QuanLyVanBan/VanBanPhapLy';
        $model = dsvanbanphaply::all();
        return view('CongBo.VanBan')
            ->with('model', $model)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Danh sách văn bản pháp lý');
    }

    public function QuyetDinh(Request $request)
    {
        $inputs = $request->all();
        $inputs['url'] = '/QuanLyVanBan/VanBanPhapLy';
        $a_donvi = array_column(dsdonvi::all()->toArray(), 'tendonvi', 'madonvi');
        $model = dsquyetdinhkhenthuong::all();
        //Hô sơ khen thưởng
        foreach (dshosothiduakhenthuong::where('trangthai', 'DKT')->get() as $hoso) {
            $hoso->tieude = $hoso->noidung;
            $hoso->maquyetdinh = $hoso->mahosotdkt;
            $hoso->phanloaikhenthuong = 'dshosothiduakhenthuong';
            $model->add($hoso);
        }
        foreach (dshosotdktcumkhoi::where('trangthai', 'DKT')->get() as $hoso) {
            $hoso->tieude = $hoso->noidung;
            $hoso->phanloaikhenthuong = 'dshosotdktcumkhoi';
            $hoso->maquyetdinh = $hoso->mahosotdkt;
            $model->add($hoso);
        }
        //dd($model);
        return view('CongBo.QuyetDinh')
            ->with('model', $model->sortby('ngayqd'))
            ->with('inputs', $inputs)
            ->with('a_phamvi', getPhamViApDung())
            ->with('pageTitle', 'Danh sách quyết định khen thưởng');
    }

    public function TaiLieuQuyetDinh(Request $request)
    {
        $result = array(
            'status' => 'fail',
            'message' => 'error',
        );

        $inputs = $request->all();       
        $inputs['phanloai'] = $inputs['phanloai'] == null ? 'dsquyetdinhkhenthuong' : $inputs['phanloai'];
        switch($inputs['phanloai']){
            case 'dshosothiduakhenthuong':{
                $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['maqd'])->first();
                break;
            }
            case 'dshosotdktcumkhoi':{
                $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['maqd'])->first();
                break;
            }
            default:{
                $model = dsquyetdinhkhenthuong::where('maquyetdinh', $inputs['maqd'])->first();
                $model->qdkt = $model->ipf1;
            }
        }

        $result['message'] = '<div class="modal-body" id = "dinh_kem" >';
        if ($model->totrinh != '') {
            $result['message'] .= '<div class="form-group row">';
            $result['message'] .= '<label class="col-3 col-form-label font-weight-bold" >Tờ trình:</label>';
            $result['message'] .= '<div class="col-9 form-control"><a target = "_blank" href = "' . url('/data/totrinh/' . $model->totrinh) . '">' . $model->totrinh . '</a ></div>';
            $result['message'] .= '</div>';
        }
        if ($model->qdkt != '') {
            $result['message'] .= '<div class="form-group row">';
            $result['message'] .= '<label class="col-3 col-form-label font-weight-bold" >Quyết định khen thưởng:</label>';
            $result['message'] .= '<div class="col-9 form-control"><a target = "_blank" href = "' . url('/data/qdkt/' . $model->qdkt) . '">' . $model->qdkt . '</a ></div>';
            $result['message'] .= '</div>';
        }
        if ($model->bienban != '') {
            $result['message'] .= '<div class="form-group row">';
            $result['message'] .= '<label class="col-3 col-form-label font-weight-bold" >Biên bản cuộc họp</label>';
            $result['message'] .= '<div class="col-9 form-control"><a target = "_blank" href = "' . url('/data/bienban/' . $model->bienban) . '">' . $model->bienban . '</a ></div>';
            $result['message'] .= '</div>';
        }
        if ($model->tailieukhac != '') {
            $result['message'] .= '<div class="form-group row">';
            $result['message'] .= '<label class="col-3 col-form-label font-weight-bold" >Tài liệu khác</label>';
            $result['message'] .= '<div class="col-9 form-control"><a target = "_blank" href = "' . url('/data/tailieukhac/' . $model->tailieukhac) . '">' . $model->tailieukhac . '</a ></div>';
            $result['message'] .= '</div>';
        }
        $result['message'] .= '</div>';
        $result['status'] = 'success';

        die(json_encode($result));
    }
}
