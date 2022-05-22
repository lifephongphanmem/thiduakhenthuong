<?php

namespace App\Http\Controllers\HeThong;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\HeThong\hethongchung_chucnang;
use Illuminate\Support\Facades\Session;

class dschucnangController extends Controller
{    
    public function ThongTin()
    {
        if (Session::has('admin')) {
            if(chkPhanQuyen()){
                $model = hethongchung_chucnang::where('capdo','1')->get();
                $m_chucnang = hethongchung_chucnang::all();
                return view('HeThongChung.ChucNang.ThongTin')
                    ->with('model',$model)
                    ->with('m_chucnang',$m_chucnang)
                    ->with('a_chucnanggoc',array_column($m_chucnang->toArray(),'tenchucnang','machucnang'))
                    ->with('pageTitle', 'Danh sách chức năng hệ thống');
            }else{
                return view('errors.perm');
            }

        }else
            return view('errors.404');
    }
    
    public function LuuChucNang(Request $request)
    {
        if (Session::has('admin')) {
            if(!chkPhanQuyen()){                
                return view('errors.perm');
            }
            $inputs = $request->all();
            $model = hethongchung_chucnang::where('machucnang',$inputs['machucnang'])->first();
            if($model == null){
                hethongchung_chucnang::create($inputs);                
            }else{
                $model->update($inputs);
            }
            return redirect('/ChucNang/ThongTin');
        
        }else
            return view('errors.notlogin');
    }

    public function LayChucNang(Request $request)
    {
        $result = array(
            'status' => 'fail',
            'message' => 'error',
        );
        if (!Session::has('admin')) {
            $result = array(
                'status' => 'fail',
                'message' => 'permission denied',
            );
            die(json_encode($result));
        }
        //dd($request);
        $inputs = $request->all();
        $model = hethongchung_chucnang::findorfail($inputs['id']);
        die(json_encode($model));
    }
 }
