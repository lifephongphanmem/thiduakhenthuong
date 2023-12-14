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
use App\Model\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi_canhan;
use App\Model\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi_tapthe;
use App\Model\NghiepVu\CumKhoiThiDua\dshosothamgiathiduacumkhoi;
use App\Model\NghiepVu\CumKhoiThiDua\dsphongtraothiduacumkhoi;
use App\Model\View\view_dscumkhoi;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class xetduyethosothamgiathiduacumkhoiController extends Controller
{
    //lấy theo chức năng hồ sơ đề nghị khen thưởng thi đua
    public static $url = '';
    public function __construct()
    {
        static::$url = '/CumKhoiThiDua/XetDuyetThamGiaThiDua/';
        $this->middleware(function ($request, $next) {
            if (!Session::has('admin')) {
                return redirect('/');
            };
            return $next($request);
        });
    }

    public function DanhSach(Request $request)
    {
        if (!chkPhanQuyen('dshosodenghikhenthuongthidua', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'dshosodenghikhenthuongthidua')->with('tenphanquyen', 'danhsach');
        }
        $inputs = $request->all();
        $m_phongtrao = dsphongtraothidua::where('maphongtraotd', $inputs['maphongtraotd'])->first();

        $ngayhientai = date('Y-m-d');
        $this->KiemTraPhongTrao($m_phongtrao, $ngayhientai);
        $model = dshosothamgiaphongtraotd::where('maphongtraotd', $inputs['maphongtraotd'])
            ->wherein('mahosothamgiapt', function ($qr) use ($inputs) {
                $qr->select('mahosothamgiapt')->from('dshosothamgiaphongtraotd')
                    ->where('madonvi_nhan', $inputs['madonvi'])
                    ->orwhere('madonvi_nhan_h', $inputs['madonvi'])
                    ->orwhere('madonvi_nhan_t', $inputs['madonvi'])->get();
            })->get();
        $m_hoso_dangky = dshosodangkyphongtraothidua::all();
        //Kiểm tra phong trào => nếu đã hết hạn thì ko cho thao tác nhận, trả hồ sơ
        //Chỉ có thể trả lại và tiếp nhận hồ sơ do cấp nào khen thưởng cấp đó nên ko để chuyển vượt cấp
        //dd($model);
        foreach ($model as $chitiet) {
            $chitiet->nhanhoso = $m_phongtrao->nhanhoso;
            $chitiet->mahosodk = $m_hoso_dangky->where('madonvi', $chitiet->madonvi)->first()->mahosodk ?? null;
            getDonViChuyen($inputs['madonvi'], $chitiet);
        }

        return view('NghiepVu.ThiDuaKhenThuong.HoSoDeNghiKhenThuongPhongTrao.DanhSach')
            ->with('inputs', $inputs)
            ->with('model', $model)
            ->with('m_phongtrao', $m_phongtrao)
            ->with('a_donvi', array_column(dsdonvi::all()->toArray(), 'tendonvi', 'madonvi'))
            ->with('pageTitle', 'Danh sách hồ sơ đăng ký thi đua');
    }

    public function ThongTin(Request $request)
    {
        if (!chkPhanQuyen('dshosodenghikhenthuongcumkhoi', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'dshosodenghikhenthuongcumkhoi')->with('tenphanquyen', 'danhsach');
        }
        $inputs = $request->all();
        $m_donvi = getDonVi(session('admin')->capdo, 'dshosodenghikhenthuongcumkhoi');
        if ($m_donvi->count() == 0) {
            return view('errors.noperm')->with('machucnang', 'dshosodenghikhenthuongcumkhoi')->with('tenphanquyen', 'danhsach');
        }
        
        $m_phongtrao = dsphongtraothiduacumkhoi::where('maphongtraotd', $inputs['maphongtraotd'])->first();
        $ngayhientai = date('Y-m-d');
        $this->KiemTraPhongTrao($m_phongtrao, $ngayhientai);

        $model = dshosothamgiathiduacumkhoi::where('madonvi_xd', $inputs['madonvi'])
            ->where('maphongtraotd', $inputs['maphongtraotd'])->get();
        
        foreach ($model as $chitiet) {
            $chitiet->nhanhoso = $m_phongtrao->nhanhoso;
            // $chitiet->mahosodk = $m_hoso_dangky->where('madonvi', $chitiet->madonvi)->first()->mahosodk ?? null;
            getDonViChuyen($inputs['madonvi'], $chitiet);
        }

        return view('NghiepVu.CumKhoiThiDua.PhongTraoThiDua.XetDuyetThamGiaThiDua.DanhSach')
            ->with('model', $model)
            ->with('m_phongtrao', $m_phongtrao)
            ->with('a_donvi', array_column(dsdonvi::all()->toArray(), 'tendonvi', 'madonvi'))
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Danh sách hồ sơ khen thưởng của cụm, khối');
    }

    public function TraLai(Request $request)
    {
        if (!chkPhanQuyen('dshosodenghikhenthuongcumkhoi', 'hoanthanh')) {
            return view('errors.noperm')->with('machucnang', 'dshosodenghikhenthuongcumkhoi')->with('tenphanquyen', 'hoanthanh');
        }
        $inputs = $request->all();
        $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahoso'])->first();
        //gán trạng thái hồ sơ để theo dõi
        $inputs['trangthai'] = 'BTL';
        $inputs['thoigian'] = date('Y-m-d H:i:s');
        setTraLaiXD($model, $inputs);
        return redirect(static::$url . 'DanhSach?madonvi=' . $model->madonvi_xd . '&macumkhoi=' . $model->macumkhoi);
    }

    public function NhanHoSo(Request $request)
    {
        if (!chkPhanQuyen('dshosodenghikhenthuongcumkhoi', 'hoanthanh')) {
            return view('errors.noperm')->with('machucnang', 'dshosodenghikhenthuongcumkhoi')->with('tenphanquyen', 'hoanthanh');
        }
        $inputs = $request->all();

        $thoigian = date('Y-m-d H:i:s');
        $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahoso'])->first();
        //gán lại trạng thái hồ sơ để theo dõi
        $model->trangthai = 'DTN';
        $model->trangthai_xd = 'DTN';
        $model->thoigian_xd = $thoigian;
        $model->save();
        trangthaihoso::create([
            'mahoso' => $inputs['mahoso'],
            'phanloai' => 'dshosotdktcumkhoi',
            'trangthai' => $model->trangthai,
            'thoigian' => $thoigian,
            'madonvi' => $model->madonvi_xd,
            'thongtin' => 'Tiếp nhận hồ sơ đề nghị khen thưởng.',
        ]);
        return redirect(static::$url . 'DanhSach?madonvi=' . $model->madonvi_xd . '&macumkhoi=' . $model->macumkhoi);
    }

    function KiemTraPhongTrao(&$phongtrao, $thoigian)
    {
        if ($phongtrao->trangthai == 'CC') {
            $phongtrao->nhanhoso = 'CHUABATDAU';
            if ($phongtrao->tungay < $thoigian && $phongtrao->denngay > $thoigian) {
                $phongtrao->nhanhoso = 'DANGNHAN';
            }
            if (strtotime($phongtrao->denngay) < strtotime($thoigian)) {
                $phongtrao->nhanhoso = 'KETTHUC';
            }
        } else {
            $phongtrao->nhanhoso = 'KETTHUC';
        }
    }
}
