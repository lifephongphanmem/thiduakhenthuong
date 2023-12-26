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
use App\Model\View\view_tdkt_canhan;
use App\Model\View\view_tdkt_detai;
use App\Model\View\viewdiabandonvi;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class APIthongtinchungController extends Controller
{
    public static $url = '/HeThongAPI/XuatDuLieu/';
    public function __construct()
    {
        // $this->middleware(function ($request, $next) {
        //     if (!Session::has('admin')) {
        //         return redirect('/');
        //     };
        //     return $next($request);
        // });
    }

    public function token(Request $request)
    {
        $header = $request->headers->all();

        /*Xử lý: Headers
            1. có chuỗi tdktaccesstoken => ko check lại thời gian
            2. Authorization => dịch ngược chuỗi để lấy thời gian => đưa ra xử lý

            Authorization có dạng: Bearer xxxxxxx
            xxxxx => tendangnhap:chuoiketnoi:thoigianhethan (SSA:TDKTTUYENQUANG:2023-12-26 17:00)

        */
        
        if (!isset($header['tdktaccesstoken'])) {
            $a_API = [
                'matrave' => '-1',
                'thongbao' => 'Chuỗi truy cập không hợp lệ.',
            ];
        } else {
            $a_API = [
                'access_token' => $request->bearerToken(),
                // 'access_token' => $header['tdktaccesstoken'][0],
                'scope' => 'am_application_scope default',
                'token_type' => 'Bearer',
                'expires_in' => '123',
            ];
        }

        return response()->json($a_API, Response::HTTP_OK);
    }

    public function LoaiHinhKhenThuong(Request $request)
    {
    }

    public function HinhThucKhenThuong(Request $request)
    {
    }

    public function PhanLoaiDoiTuong(Request $request)
    {
    }

    public function DiaBanHanhChinh(Request $request)
    {
    }

    public function DonViSuDung(Request $request)
    {
    }

    public function LinhVucHoatDong(Request $request)
    {
    }
}
