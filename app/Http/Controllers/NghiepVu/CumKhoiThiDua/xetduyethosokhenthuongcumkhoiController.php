<?php

namespace App\Http\Controllers\NghiepVu\CumKhoiThiDua;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\DanhMuc\dmloaihinhkhenthuong;
use App\Model\DanhMuc\dscumkhoi;
use App\Model\DanhMuc\dsdiaban;
use App\Model\DanhMuc\dsdonvi;
use App\Model\HeThong\trangthaihoso;
use App\Model\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi;
use App\Model\View\viewdiabandonvi;
use Illuminate\Support\Facades\Session;

class xetduyethosokhenthuongcumkhoiController extends Controller
{
    public static $url = '';
    public function __construct()
    {
        static::$url = '/CumKhoiThiDua/KTCumKhoi/XetDuyet/';
        $this->middleware(function ($request, $next) {
            if (!Session::has('admin')) {
                return redirect('/');
            };
            return $next($request);
        });
    }
    public function ThongTin(Request $request)
    {
        if (!chkPhanQuyen('xdhosokhenthuongcumkhoi', 'danhsach')) {
            return view('errors.noperm')->with('machucang', 'xdhosokhenthuongcumkhoi')->with('tenphanquyen', 'danhsach');
        }
        $inputs = $request->all();
        $inputs['url_hs'] = '/CumKhoiThiDua/KTCumKhoi/HoSo/';
        $inputs['url_xd'] = '/CumKhoiThiDua/KTCumKhoi/XetDuyet/';
        $inputs['url_qd'] = '/CumKhoiThiDua/KTCumKhoi/KhenThuong/';
        $m_donvi = getDonViXetDuyetHoSoCumKhoi(session('admin')->capdo, null, null, 'MODEL');
        $m_diaban = dsdiaban::wherein('madiaban', array_column($m_donvi->toarray(), 'madiaban'))->get();
        $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;
        $inputs['nam'] = $inputs['nam'] ?? 'ALL';
        $m_cumkhoi = dscumkhoi::where('madonviql', $inputs['madonvi'])->get();
        $inputs['macumkhoi'] = $inputs['macumkhoi'] ?? $m_cumkhoi->first()->macumkhoi;        
        //Trường hợp chọn lại đơn vị nhưng mã cụm khối vẫn theo đơn vị cũ
        $inputs['macumkhoi'] = $m_cumkhoi->where('macumkhoi', $inputs['macumkhoi'])->first() != null ? $inputs['macumkhoi'] : $m_cumkhoi->first()->macumkhoi;
        //$donvi = $m_donvi->where('madonvi', $inputs['madonvi'])->first();
        //$capdo = $donvi->capdo ?? '';
        //dd($inputs);

        $model = dshosotdktcumkhoi::where('macumkhoi', $inputs['macumkhoi'])
            ->wherein('mahosotdkt', function ($qr) use ($inputs) {
                $qr->select('mahosotdkt')->from('dshosotdktcumkhoi')
                    ->where('madonvi_nhan', $inputs['madonvi'])
                    ->orwhere('madonvi_nhan_h', $inputs['madonvi'])
                    ->orwhere('madonvi_nhan_t', $inputs['madonvi'])->get();
            })->get();

        foreach ($model as $chitiet) {
            getDonViChuyen($inputs['madonvi'], $chitiet);
            //$chitiet->trangthai = $donvi->capdo == 'H' ? $chitiet->trangthai_h : $chitiet->trangthai_t;
        }
        //dd($model);
        return view('NghiepVu.CumKhoiThiDua.XetDuyetHoSoKhenThuong.ThongTin')
            ->with('inputs', $inputs)
            ->with('model', $model)
            ->with('m_donvi', $m_donvi)
            ->with('m_diaban', $m_diaban)
            ->with('m_cumkhoi', $m_cumkhoi)
            ->with('a_donvi', array_column(dsdonvi::all()->toArray(), 'tendonvi', 'madonvi'))
            ->with('a_donviql', getDonViQuanLyCumKhoi($inputs['macumkhoi']))
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('pageTitle', 'Danh sách hồ sơ thi đua');
    }

    public function TraLai(Request $request)
    {
        $inputs = $request->all();
        $thoigian = date('Y-m-d H:i:s');
        $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahoso'])->first();
        $m_nhatky = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahoso'])->first();
        //lấy thông tin lưu nhật ký
        getDonViChuyen($inputs['madonvi'], $m_nhatky);
        trangthaihoso::create([
            'mahoso' => $inputs['mahoso'], 'trangthai' => 'BTL', 'phanloai' => 'dshosotdktcumkhoi',
            'thoigian' => $thoigian, 'lydo' => $inputs['lydo'],
            'madonvi_nhan' => $m_nhatky->madonvi_hoso, 'madonvi' => $m_nhatky->madonvi_nhan_hoso
        ]);
        //Gán lại trạng thái cho hồ sơ
        setNhanHoSo($inputs['madonvi'], $model, ['trangthai' => 'BTL', 'thoigian' => $thoigian, 'lydo' => $inputs['lydo'], 'madonvi_nhan' => '']);
        setTrangThaiHoSo($inputs['madonvi'], $model, ['trangthai' => '', 'thoigian' => '', 'lydo' => '', 'madonvi_nhan' => '', 'madonvi' => '']);
        //dd($model);
        $model->save();

        return redirect(static::$url . 'ThongTin?madonvi=' . $inputs['madonvi'] . '&macumkhoi=' . $model->macumkhoi);
    }

    public function NhanHoSo(Request $request)
    {
        $inputs = $request->all();
        $thoigian = date('Y-m-d H:i:s');
        $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahoso'])->first();
        $m_donvi = viewdiabandonvi::where('madonvi', $inputs['madonvi_nhan'])->first();

        setNhanHoSo($inputs['madonvi_nhan'], $model, ['madonvi' => $inputs['madonvi_nhan'], 'thoigian' => $thoigian, 'trangthai' => 'CXKT']);
        setChuyenHoSo($m_donvi->capdo, $model, ['madonvi' => $inputs['madonvi_nhan'], 'thoigian' => $thoigian, 'trangthai' => 'CXKT']);
        //dd($model);
        trangthaihoso::create([
            'mahoso' => $inputs['mahoso'],
            'phanloai' => 'dshosotdktcumkhoi',
            'trangthai' => 'CXKT',
            'thoigian' => $thoigian,
            'madonvi_nhan' => $inputs['madonvi_nhan'],
            'madonvi' => $inputs['madonvi'],
            'thongtin' => 'Nhận hồ sơ và trình đề nghị khen thưởng.',
        ]);
        $model->save();

        return redirect(static::$url . 'ThongTin?madonvi=' . $inputs['madonvi_nhan'] . '&macumkhoi=' . $model->macumkhoi);
    }
}
