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
use App\Model\DanhMuc\dsdiaban;
use App\Model\DanhMuc\dsdonvi;
use App\Model\HeThong\hethongchung;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong;
use App\Model\View\view_tdkt_canhan;
use App\Model\View\view_tdkt_detai;
use App\Model\View\viewdiabandonvi;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class APInghiepvuController extends Controller
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

    

    public function getDanhSachHoSo(Request $request)
    {
        $header = $request->headers->all();
        $body = $request->all();
        $apidungchung = new APIthongtinchungController();
        if (!$apidungchung->checkHeader($header)) {
            $a_API = [
                'matrave' => '-1',
                'thongbao' => 'Chuỗi truy cập không hợp lệ hoặc đã hết hạn.',
            ];
            return response()->json($a_API, Response::HTTP_OK);
        }
        //Lấy dữ liệu
        $a_API['Header'] = [
            'Version' => '1.0',
            'Tran_Code' => '',
            'Export_Date' => '',
            'Msg_ID' => '',
            'Path' => $header['host'][0],
        ];
        
        $a_API['Body'] = [];
        $a_API['Security'] = ['Signature' => ''];
        
        $model_khenthuong = dshosothiduakhenthuong::all();       
        $m_donvi = viewdiabandonvi::all();
        $a_kq = [];
        foreach ($model_khenthuong as $hoso) {
            $conHoSo = new APIdungchungController();
            $a_kq[] = $conHoSo->convertDanhSachHoSo($hoso, $m_donvi);
        }
        $a_API['Body'] = $a_kq;
        return response()->json($a_API, Response::HTTP_OK);
    }

    public function HinhThucKhenThuong(Request $request)
    {
        $header = $request->headers->all();
        $body = $request->all();

        if (!$this->checkHeader($header)) {
            $a_API = [
                'matrave' => '-1',
                'thongbao' => 'Chuỗi truy cập không hợp lệ hoặc đã hết hạn.',
            ];
            return response()->json($a_API, Response::HTTP_OK);
        }
        //Lấy dữ liệu
        $a_API['Header'] = [
            'Version' => '1.0',
            'Tran_Code' => '',
            'Export_Date' => '',
            'Msg_ID' => '',
            'Path' => $header['host'][0],
        ];
        $a_API['Body'] = [];
        $a_API['Security'] = ['Signature' => ''];
        $model = dmhinhthuckhenthuong::all();
        $a_kq = [];
        if (isset($body['PhanLoaiKhenThuong'])) {
            $model = $model->where('phanloai', $body['PhanLoaiKhenThuong']);
        }
        foreach ($model as $hoso) {
            $conHoSo = new APIdungchungController();
            $a_kq[] = $conHoSo->convertHinhThucKhenThuong($hoso);
        }
        $a_API['Body'] = $a_kq;

        return response()->json($a_API, Response::HTTP_OK);
    }

    public function PhanLoaiDoiTuong(Request $request)
    {
        $header = $request->headers->all();
        $body = $request->all();

        if (!$this->checkHeader($header)) {
            $a_API = [
                'matrave' => '-1',
                'thongbao' => 'Chuỗi truy cập không hợp lệ hoặc đã hết hạn.',
            ];
            return response()->json($a_API, Response::HTTP_OK);
        }
        //Lấy dữ liệu
        $a_API['Header'] = [
            'Version' => '1.0',
            'Tran_Code' => '',
            'Export_Date' => '',
            'Msg_ID' => '',
            'Path' => $header['host'][0],
        ];
        $a_API['Body'] = [];
        $a_API['Security'] = ['Signature' => ''];
        $model = dmnhomphanloai_chitiet::all();
        $a_kq = [];
        if (isset($body['NhomDoiTuong'])) {
            $model = $model->where('manhomphanloai', $body['NhomDoiTuong']);
        }
        foreach ($model as $hoso) {
            $conHoSo = new APIdungchungController();
            $a_kq[] = $conHoSo->convertPhanLoaiDoiTuong($hoso);
        }
        $a_API['Body'] = $a_kq;

        return response()->json($a_API, Response::HTTP_OK);
    }

    public function DiaBanHanhChinh(Request $request)
    {
        $header = $request->headers->all();
        $body = $request->all();

        if (!$this->checkHeader($header)) {
            $a_API = [
                'matrave' => '-1',
                'thongbao' => 'Chuỗi truy cập không hợp lệ hoặc đã hết hạn.',
            ];
            return response()->json($a_API, Response::HTTP_OK);
        }
        //Lấy dữ liệu
        $a_API['Header'] = [
            'Version' => '1.0',
            'Tran_Code' => '',
            'Export_Date' => '',
            'Msg_ID' => '',
            'Path' => $header['host'][0],
        ];
        $a_API['Body'] = [];
        $a_API['Security'] = ['Signature' => ''];
        $model = dsdiaban::all();
        $a_kq = [];
        if (isset($body['NhomDiaBan'])) {
            $model = $model->where('capdo', $body['NhomDiaBan']);
        }
        foreach ($model as $hoso) {
            $conHoSo = new APIdungchungController();
            $a_kq[] = $conHoSo->convertDiaBanHanhChinh($hoso);
        }
        $a_API['Body'] = $a_kq;

        return response()->json($a_API, Response::HTTP_OK);
    }

    public function DonViSuDung(Request $request)
    {
        $header = $request->headers->all();
        $body = $request->all();

        if (!$this->checkHeader($header)) {
            $a_API = [
                'matrave' => '-1',
                'thongbao' => 'Chuỗi truy cập không hợp lệ hoặc đã hết hạn.',
            ];
            return response()->json($a_API, Response::HTTP_OK);
        }
        //Lấy dữ liệu
        $a_API['Header'] = [
            'Version' => '1.0',
            'Tran_Code' => '',
            'Export_Date' => '',
            'Msg_ID' => '',
            'Path' => $header['host'][0],
        ];
        $a_API['Body'] = [];
        $a_API['Security'] = ['Signature' => ''];
        $model = dsdonvi::all();
        $a_kq = [];
        if (isset($body['MaDiaBan'])) {
            $model = $model->where('madiaban', $body['madiaban']);
        }
        foreach ($model as $hoso) {
            $conHoSo = new APIdungchungController();
            $a_kq[] = $conHoSo->convertDonViSuDung($hoso);
        }
        $a_API['Body'] = $a_kq;

        return response()->json($a_API, Response::HTTP_OK);
    }

    public function LinhVucHoatDong(Request $request)
    {
    }
}
