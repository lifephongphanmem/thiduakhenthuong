<?php

namespace App\Http\Controllers\DanhMuc;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\DanhMuc\dmhinhthuckhenthuong;
use Illuminate\Support\Facades\Session;

class dmhinhthuckhenthuongController extends Controller
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
        if (!chkPhanQuyen('dmhinhthuckhenthuong', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'dmhinhthuckhenthuong');
        }
        $model = dmhinhthuckhenthuong::all();
        $a_phamviapdung = getPhamViApDung();
        foreach ($model as $ct) {
            $ct->tenphamviapdung = '';
            foreach (explode(';', $ct->phamviapdung) as $phamvi) {
                $ct->tenphamviapdung .= ($a_phamviapdung[$phamvi] ?? '') . '; ';
            }
        }
        $inputs = $request->all();
        //dd($model);
        return view('DanhMuc.HinhThucKhenThuong.ThongTin')
            ->with('model', $model)
            ->with('inputs', $inputs)
            ->with('a_phanloai', getPhanLoaiHinhThucKT())
            ->with('pageTitle', 'Danh mục loại hình khen thưởng');
    }

    public function store(Request $request)
    {
        //tài khoản SSA; tài khoản quản trị + có phân quyền
        if (!chkPhanQuyen('dmhinhthuckhenthuong', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dmhinhthuckhenthuong');
        }
        $inputs = $request->all();
        $inputs['phamviapdung'] = implode(';', $inputs['phamviapdung']);
        //dd($inputs);
        $model = dmhinhthuckhenthuong::where('mahinhthuckt', $inputs['mahinhthuckt'])->first();
        if ($model == null) {
            $inputs['mahinhthuckt'] = getdate()[0];
            dmhinhthuckhenthuong::create($inputs);
        } else {
            $model->update($inputs);
        }

        return redirect('/HinhThucKhenThuong/ThongTin');
    }

    public function delete(Request $request)
    {
        //tài khoản SSA; tài khoản quản trị + có phân quyền
        if (!chkPhanQuyen('dmhinhthuckhenthuong', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dmhinhthuckhenthuong');
        }
        $inputs = $request->all();
        dmhinhthuckhenthuong::findorfail($inputs['id'])->delete();
        return redirect('/HinhThucKhenThuong/ThongTin');
    }
}
