<?php

namespace App\Http\Controllers\VanBan;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\DanhMuc\dmdanhhieuthidua;
use App\Model\DanhMuc\dmdanhhieuthidua_tieuchuan;
use App\Model\VanBan\dsvanbanphaply;
use Illuminate\Support\Facades\Session;

class dsvanbanphaplyController extends Controller
{
    public function ThongTin(Request $request)
    {
        if (Session::has('admin')) {
            if (!chkPhanQuyen()) {
                return view('errors.noperm');
            }            
            $inputs = $request->all();
            $inputs['url'] = '/QuanLyVanBan/VanBanPhapLy';
            $model = dsvanbanphaply::all();
            //dd($model);
            return view('VanBan.TaiLieu.ThongTin')
                ->with('model', $model)
                ->with('inputs', $inputs)
                ->with('pageTitle', 'Danh sách văn bản pháp lý');
        } else
            return view('errors.notlogin');
    }

    public function LuuHoSo(Request $request)
    {
        if (Session::has('admin')) {
            //tài khoản SSA; tài khoản quản trị + có phân quyền
            if (!chkPhanQuyen()) {
                return view('errors.noperm');
            }
            $inputs = $request->all();
            $model = dsvanbanphaply::where('mavanban', $inputs['mavanban'])->first();
            if (isset($inputs['ipf1'])) {
                $filedk = $request->file('ipf1');
                $inputs['ipf1'] =$inputs['mavanban'].'1.'. $filedk->getClientOriginalExtension();
                $filedk->move(public_path() . '/data/vanban/', $inputs['ipf1']);
            }
            if ($model == null) {
                dsvanbanphaply::create($inputs);
            } else {
                $model->update($inputs);
            }

            return redirect('/QuanLyVanBan/VanBanPhapLy/ThongTin');
        } else
            return view('errors.notlogin');
    }

    public function XoaHoSo(Request $request)
    {
        if (Session::has('admin')) {
            //tài khoản SSA; tài khoản quản trị + có phân quyền
            if (!chkPhanQuyen()) {
                return view('errors.noperm');
            }
            $inputs = $request->all();
            //dd($inputs);
            dsvanbanphaply::findorfail($inputs['id'])->delete();
            return redirect('/QuanLyVanBan/VanBanPhapLy/ThongTin');
        } else
            return view('errors.notlogin');
    }

    public function Them()
    {
        if (Session::has('admin')) {
            $model = new dsvanbanphaply();
            $model->mavanban = getdate()[0];

            return view('VanBan.TaiLieu.ThayDoi')
                ->with('model', $model)
                ->with('pageTitle', 'Thông tin văn bản pháp lý');
        } else
            return view('errors.notlogin');
    }

    public function ThayDoi(Request $request)
    {
        if (Session::has('admin')) {
            if (!chkPhanQuyen()) {
                return view('errors.noperm');
            }
            $inputs = $request->all();
            $model = dsvanbanphaply::where('mavanban', $inputs['mavanban'])->first();
           
            return view('VanBan.TaiLieu.ThayDoi')
            ->with('model', $model)
            ->with('pageTitle', 'Thông tin văn bản pháp lý');
        } else
            return view('errors.notlogin');
    }

    public function show_dinhkem(Request $request)
    {
        $result = array(
            'status' => 'fail',
            'message' => 'error',
        );

        $inputs = $request->all();

        $model = dsvanbanphaply::where('mavanban',$inputs['mahs'])->first();
        //dd($model);
        $result['message'] ='<div class="modal-body" id = "dinh_kem" >';
        if (isset($model->ipf1)) {
            $result['message'] .= '<div class="form-group row" ><div class="col-md-12" >';
            $result['message'] .= '<label class="control-label" > File đính kèm 1: </label >';
            $result['message'] .= '<a target = "_blank" class="ml-10" href = "' . url('/data/vanban/' . $model->ipf1) . '">' . $model->ipf1 . '</a >';
            $result['message'] .= '</div ></div >';
        }
        if (isset($model->ipf2)) {
            $result['message'] .= '<div class="form-group row" ><div class="col-md-12" >';
            $result['message'] .= '<label class="control-label" > File đính kèm 2 </label >';
            $result['message'] .= '<p ><a target = "_blank" href = "' . url('/data/vanban/' . $model->ipf2) . '">' . $model->ipf2 . '</a >';
            $result['message'] .= '</div ></div >';
        }
        if (isset($model->ipf3)) {
            $result['message'] .= '<div class="form-group row" ><div class="col-md-12" >';
            $result['message'] .= '<label class="control-label" > File đính kèm 3 </label >';
            $result['message'] .= '<a target = "_blank" class="ml-10" href = "' . url('/data/vanban/' . $model->ipf3) . '">' . $model->ipf3 . '</a >';
            $result['message'] .= '</div ></div >';
        }
        if (isset($model->ipf4)) {
            $result['message'] .= '<div class="form-group row" ><div class="col-md-12" >';
            $result['message'] .= '<label class="control-label" > File đính kèm 4 </label >';
            $result['message'] .= '<a target = "_blank" class="ml-10" href = "' . url('/data/vanban/' . $model->ipf4) . '">' . $model->ipf4 . '</a >';
            $result['message'] .= '</div ></div >';
        }
        if (isset($model->ipf5)) {
            $result['message'] .= '<div class="form-group row" ><div class="col-md-12" >';
            $result['message'] .= '<label class="control-label" > File đính kèm 5 </label >';
            $result['message'] .= '<a target = "_blank" class="ml-10" href = "' . url('/data/vanban/' . $model->ipf5) . '">' . $model->ipf5 . '</a >';
            $result['message'] .= '</div ></div >';
        }
        $result['message'] .='</div>';
        $result['status'] = 'success';

        die(json_encode($result));
    }
}
