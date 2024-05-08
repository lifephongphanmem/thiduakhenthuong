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
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_canhan;
use App\Model\View\view_tdkt_canhan;
use App\Model\View\view_tdkt_detai;
use App\Model\View\view_tdkt_tapthe;
use App\Model\View\viewdiabandonvi;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class APIquanlycanboController extends Controller
{
    public static $url = '/HeThongAPI/QuanLyCanBo/';

    public function TruyenHoSo(Request $request)
    {
        $inputs = $request->all();
        $m_donvi = getDonVi(session('admin')->capdo);; //mặc định để đơn vị tổng hợp sử dụng hệ thống
        $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;
        $inputs['url'] = static::$url;
        // $inputs['url'] = static::$url ;
        //Lấy danh sách hồ sơ theo đơn vị để truyền
        $model = view_tdkt_canhan::where(function($qr)use($inputs){
            $qr->where('madonvi', $inputs['madonvi'])->orwhere('madonvi_xd', $inputs['madonvi'])->orwhere('madonvi_kt', $inputs['madonvi'])->get();
        })->where('trangthai', 'DKT')->get();
        $a_dhkt_canhan = getDanhHieuKhenThuong('ALL');
        $a_canhan = array_column(dmnhomphanloai_chitiet::wherein('manhomphanloai', ['CANHAN'])->get()->toarray(), 'tenphanloai', 'maphanloai');
        // dd($inputs);
        return view('API.QuanLyCanBo.TruyenHoSo')
            ->with('inputs', $inputs)
            ->with('model', $model)
            ->with('a_dhkt_canhan', $a_dhkt_canhan)
            ->with('a_canhan', $a_canhan)
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('a_phanloaihs', getPhanLoaiHoSo())
            ->with('a_donvi', array_column($m_donvi->toArray(), 'tendonvi', 'madonvi'))
            ->with('pageTitle', 'Truyền dữ liệu khen thưởng lên phần mềm quản lý cán bộ');
    }

    public function TaoAPI(Request $request)
    {
        $inputs = $request->all();

        $result = array(
            'status' => 'fail',
            'message' => 'error',
        );

        $inputs = $request->all();

        $machung = 'QuanLyVanBan'; //Sau thiết lập trên hệ thống chung
        $dungchung = new APIdungchungController();
        $result['message'] = $dungchung->taoAPI($inputs['currentUrl'], $inputs['url'], $machung, $inputs['madonvi'], $inputs['mahosotdkt']);
        $result['status'] = 'success';

        return (json_encode($result));
    }

    public function getKhenThuongCaNhan(Request $request)
    {
        $inputs = $request->all();
        $a_API['Header'] = [
            'Version' => '',
            'Tran_Code' => '',
            'Export_Date' => '',
            'Msg_ID' => '',
            'Path' => '',
        ];
        $a_API['Body'] = [];
        $a_API['Security'] = ['Signature' => ''];
        $a_giatri = explode(':', base64_decode($inputs['_token']));

        //Nếu nhóm giá trị nhỏ hơn 3 => lỗi
        if (count($a_giatri) < 3) {
            return response()->json([
                'message' => 'Lỗi đường link API.',
                'code' => '-1'
            ], Response::HTTP_OK);
        }
        // return response()->json($a_giatri, Response::HTTP_OK);
        //Chưa kiểm tra thời hạn của link ở $a_giatri[3]
        $model_khenthuong = view_tdkt_canhan::where('id', $a_giatri[2])->get();
        // return response()->json($model_khenthuong, Response::HTTP_OK);
        if (count($model_khenthuong) < 1) {
            return response()->json([
                'message' => 'Thông tin khen thưởng cá nhân không hợp lệ.',
                'code' => '-1'
            ], Response::HTTP_OK);
        }
        $donvi = viewdiabandonvi::where('madonvi', $a_giatri[1])->first();
        if ($donvi == null) {
            return response()->json([
                'message' => 'Đơn vị khen thưởng không hợp lệ.',
                'code' => '-1'
            ], Response::HTTP_OK);
        }
        $m_donvi = viewdiabandonvi::all();
        $a_kq = [];
        foreach ($model_khenthuong as $hoso) {
            $conHoSo = new APIdungchungController();
            $a_kq[] = $conHoSo->convertCaNhan($hoso, $m_donvi);
        }
        $a_API['Body'] = $a_kq;
        return response()->json($a_API, Response::HTTP_OK);
    }
    public function postKhenThuongCaNhan(Request $request)
    {
    }
}
