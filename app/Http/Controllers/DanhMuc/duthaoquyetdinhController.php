<?php

namespace App\Http\Controllers\DanhMuc;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\DanhMuc\duthaoquyetdinh;
use Illuminate\Support\Facades\Session;

class duthaoquyetdinhController extends Controller
{
    public static $url = '';
    public function __construct()
    {
        static::$url = '/DuThaoQD/';
        $this->middleware(function ($request, $next) {
            if (!Session::has('admin')) {
                return redirect('/');
            };
            return $next($request);
        });
    }

    public function ThongTin(Request $request)
    {
        if (!chkPhanQuyen()) {
            return view('errors.noperm');
        }
        $inputs = $request->all();
        $inputs['url'] = static::$url;
        $model = duthaoquyetdinh::all();
        //dd($model);
        return view('DanhMuc.DuThaoQuyetDinh.ThongTin')
            ->with('model', $model)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Danh mục dự thảo quyết định');
    }


    public function Them(Request $request)
    {
        //tài khoản SSA; tài khoản quản trị + có phân quyền
        if (!chkPhanQuyen()) {
            return view('errors.noperm');
        }
        $inputs = $request->all();
        $model = duthaoquyetdinh::where('maduthao', $inputs['maduthao'])->first();
        if ($model == null) {
            $inputs['maduthao'] = getdate()[0];
            duthaoquyetdinh::create($inputs);
        } else {
            $model->update($inputs);
        }

        return redirect(static::$url . 'ThongTin');
    }


    public function Xoa(Request $request)
    {
        //tài khoản SSA; tài khoản quản trị + có phân quyền
        if (!chkPhanQuyen()) {
            return view('errors.noperm');
        }
        $inputs = $request->all();
        $model = duthaoquyetdinh::findorfail($inputs['id']);
        $model->delete();
        return redirect(static::$url . 'ThongTin');
    }

    public function XemDuThao(Request $request)
    {
        $inputs = $request->all();
        $inputs['url'] = static::$url;
        $model = duthaoquyetdinh::where('maduthao', $inputs['maduthao'])->first();
        //$model->codehtml = getQuyetDinhCKE('QUYETDINH');
        //dd($model);
        return view('DanhMuc.DuThaoQuyetDinh.DuThao')
            ->with('model', $model)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Quyết định khen thưởng');
    }

    public function LuuDuThao(Request $request)
    {
        $inputs = $request->all();
        $model = duthaoquyetdinh::where('maduthao', $inputs['maduthao'])->first();
        $model->codehtml = $inputs['codehtml'];
        $model->save();
        return redirect(static::$url . 'ThongTin');
    }
}
