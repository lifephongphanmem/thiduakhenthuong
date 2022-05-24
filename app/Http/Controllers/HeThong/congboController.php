<?php

namespace App\Http\Controllers\HeThong;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\DanhMuc\dsdiaban;
use App\Model\DanhMuc\dsdonvi;
use App\Model\DanhMuc\dstaikhoan;
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
        $model = dsquyetdinhkhenthuong::all();
        return view('CongBo.QuyetDinh')
            ->with('model', $model)
            ->with('inputs', $inputs)
            ->with('a_phamvi',getPhamViApDung())
            ->with('pageTitle', 'Danh sách quyết định khen thưởng');
    }
}
