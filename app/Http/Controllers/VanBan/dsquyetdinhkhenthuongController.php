<?php

namespace App\Http\Controllers\VanBan;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\VanBan\dsquyetdinhkhenthuong;
use App\Model\VanBan\dsvanbanphaply;
use Illuminate\Support\Facades\Session;

class dsquyetdinhkhenthuongController extends Controller
{
    public function ThongTin(Request $request)
    {
        if (Session::has('admin')) {
            if (!chkPhanQuyen()) {
                return view('errors.noperm');
            }            
            $inputs = $request->all();
            $inputs['url'] = '/QuanLyVanBan/KhenThuong';
            $model = dsquyetdinhkhenthuong::all();
            //dd($model);
            return view('VanBan.KhenThuong.ThongTin')
                ->with('model', $model)
                ->with('inputs', $inputs)
                ->with('a_phamvi',getPhamViApDung())
                ->with('pageTitle', 'Danh sách quyết định khen thưởng');
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
            $model = dsquyetdinhkhenthuong::where('maquyetdinh', $inputs['maquyetdinh'])->first();
            if (isset($inputs['ipf1'])) {
                $filedk = $request->file('ipf1');
                $inputs['ipf1'] =$inputs['maquyetdinh'].'1.'. $filedk->getClientOriginalExtension();
                $filedk->move(public_path() . '/data/quyetdinh/', $inputs['ipf1']);
            }
            if ($model == null) {
                dsquyetdinhkhenthuong::create($inputs);
            } else {
                $model->update($inputs);
            }

            return redirect('/QuanLyVanBan/KhenThuong/ThongTin');
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
            dsquyetdinhkhenthuong::findorfail($inputs['id'])->delete();
            return redirect('/QuanLyVanBan/KhenThuong/ThongTin');
        } else
            return view('errors.notlogin');
    }

    public function Them()
    {
        if (Session::has('admin')) {
            $model = new dsvanbanphaply();
            $model->maquyetdinh = getdate()[0];

            return view('VanBan.KhenThuong.ThayDoi')
                ->with('model', $model)
                ->with('pageTitle', 'Thông tin quyết định khen thưởng');
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
            $model = dsquyetdinhkhenthuong::where('maquyetdinh', $inputs['maquyetdinh'])->first();
           
            return view('VanBan.KhenThuong.ThayDoi')
            ->with('model', $model)
            ->with('pageTitle', 'Thông tin quyết định khen thưởng');
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

        $model = dsquyetdinhkhenthuong::where('maquyetdinh',$inputs['mahs'])->first();
        //dd($model);
        $result['message'] ='<div class="modal-body" id = "dinh_kem" >';
        if (isset($model->ipf1)) {
            $result['message'] .= '<div class="form-group row" ><div class="col-md-12" >';
            $result['message'] .= '<label class="control-label" > File đính kèm 1: </label >';
            $result['message'] .= '<a target = "_blank" class="ml-10" href = "' . url('/data/quyetdinh/' . $model->ipf1) . '">' . $model->ipf1 . '</a >';
            $result['message'] .= '</div ></div >';
        }
        if (isset($model->ipf2)) {
            $result['message'] .= '<div class="form-group row" ><div class="col-md-12" >';
            $result['message'] .= '<label class="control-label" > File đính kèm 2 </label >';
            $result['message'] .= '<p ><a target = "_blank" href = "' . url('/data/quyetdinh/' . $model->ipf2) . '">' . $model->ipf2 . '</a >';
            $result['message'] .= '</div ></div >';
        }
        if (isset($model->ipf3)) {
            $result['message'] .= '<div class="form-group row" ><div class="col-md-12" >';
            $result['message'] .= '<label class="control-label" > File đính kèm 3 </label >';
            $result['message'] .= '<a target = "_blank" class="ml-10" href = "' . url('/data/quyetdinh/' . $model->ipf3) . '">' . $model->ipf3 . '</a >';
            $result['message'] .= '</div ></div >';
        }
        if (isset($model->ipf4)) {
            $result['message'] .= '<div class="form-group row" ><div class="col-md-12" >';
            $result['message'] .= '<label class="control-label" > File đính kèm 4 </label >';
            $result['message'] .= '<a target = "_blank" class="ml-10" href = "' . url('/data/quyetdinh/' . $model->ipf4) . '">' . $model->ipf4 . '</a >';
            $result['message'] .= '</div ></div >';
        }
        if (isset($model->ipf5)) {
            $result['message'] .= '<div class="form-group row" ><div class="col-md-12" >';
            $result['message'] .= '<label class="control-label" > File đính kèm 5 </label >';
            $result['message'] .= '<a target = "_blank" class="ml-10" href = "' . url('/data/quyetdinh/' . $model->ipf5) . '">' . $model->ipf5 . '</a >';
            $result['message'] .= '</div ></div >';
        }
        $result['message'] .='</div>';
        $result['status'] = 'success';

        die(json_encode($result));
    }
}
