<?php

namespace App\Http\Controllers\API;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\DanhMuc\dmdanhhieuthidua;
use App\Model\DanhMuc\dmhinhthuckhenthuong;
use App\Model\DanhMuc\dmloaihinhkhenthuong;
use App\Model\DanhMuc\dmnhomphanloai_chitiet;
use App\Model\DanhMuc\dsdonvi;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong;
use App\Model\View\view_tdkt_canhan;
use App\Model\View\view_tdkt_detai;
use App\Model\View\view_tdkt_tapthe;
use App\Model\View\viewdiabandonvi;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class APIquanlyvanbanController extends Controller
{
    public static $url = '/HeThongAPI/QuanLyVanBan/';

    public function NhanHoSo(Request $request)
    {
        $inputs = $request->all();
        $m_donvi = getDonVi('SSA'); //mặc định để đơn vị tổng hợp sử dụng hệ thống
        $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;
        $inputs['url'] = static::$url . 'CaNhan';

        return view('API.QuanLyVanBan.NhanHoSo')
            ->with('inputs', $inputs)
            ->with('a_donvi', array_column($m_donvi->toArray(), 'tendonvi', 'madonvi'))
            ->with('pageTitle', 'Nhận hồ sơ từ phần mềm quản lý văn bản');
    }

    public function TruyenHoSo(Request $request)
    {
        $inputs = $request->all();
        $m_donvi = getDonVi(session('admin')->capdo);; //mặc định để đơn vị tổng hợp sử dụng hệ thống
        $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;
        $inputs['url'] = static::$url;
        // $inputs['url'] = static::$url ;
        //Lấy danh sách hồ sơ theo đơn vị để truyền
        $model = dshosothiduakhenthuong::where('madonvi', $inputs['madonvi'])->orwhere('madonvi_xd', $inputs['madonvi'])->orwhere('madonvi_kt', $inputs['madonvi'])->get();
        // dd($inputs);
        return view('API.QuanLyVanBan.TruyenHoSo')
            ->with('inputs', $inputs)
            ->with('model', $model)
            ->with('a_phanloaihs', getPhanLoaiHoSo())            
            ->with('a_donvi', array_column($m_donvi->toArray(), 'tendonvi', 'madonvi'))

            ->with('pageTitle', 'Truyền hồ sơ từ phần mềm quản lý văn bản');
    }

    public function TaoAPI(Request $request)
    {
        $inputs = $request->all();

        $result = array(
            'status' => 'fail',
            'message' => 'error',
        );

        $inputs = $request->all();
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $machung = 'QuanLyVanBan'; //Sau thiết lập trên hệ thống chung
        $result['message'] =$inputs['currentUrl'] . $inputs['url'] . '?_token=' . base64_encode($machung . ':' . $inputs['madonvi'] . ':' . $inputs['mahosotdkt']);
        $result['status'] = 'success';

        return (json_encode($result));
    }


    public function getDanhSachHoSo(Request $request)
    {
    }
    public function postHoSo(Request $request)
    {
    }
    public function getHoSoDeNghi(Request $request)
    {
    }
    public function postHoSoDeNghi(Request $request)
    {
    }
    public function getHoSoXetDuyet(Request $request)
    {
    }
    public function postHoSoXetDuyet(Request $request)
    {
    }
    public function getHoSoPheDuyet(Request $request)
    {
    }
    public function postHoSoPheDuyet(Request $request)
    {
    }

    public function getHoSoKhenThuong(Request $request)
    {
    }
    public function postHoSoKhenThuong(Request $request)
    {
    }
}
