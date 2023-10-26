<?php

namespace App\Http\Controllers\NghiepVu\CumKhoiThiDua;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\NghiepVu\_DungChung\dungchung_nghiepvuController;
use App\Http\Controllers\NghiepVu\_DungChung\dungchung_nhanexcelController;
use App\Model\DanhMuc\dmdanhhieuthidua;
use App\Model\DanhMuc\dmhinhthuckhenthuong;
use App\Model\DanhMuc\dmloaihinhkhenthuong;
use App\Model\DanhMuc\dmnhomphanloai_chitiet;
use App\Model\DanhMuc\dsdiaban;
use App\Model\DanhMuc\dsdonvi;
use App\Model\DanhMuc\duthaoquyetdinh;
use App\Model\HeThong\trangthaihoso;
use App\Model\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi;
use App\Model\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi_canhan;
use App\Model\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi_tailieu;
use App\Model\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi_tapthe;
use App\Model\NghiepVu\CumKhoiThiDua\dshosothamgiathiduacumkhoi;
use App\Model\NghiepVu\CumKhoiThiDua\dshosothamgiathiduacumkhoi_canhan;
use App\Model\NghiepVu\CumKhoiThiDua\dshosothamgiathiduacumkhoi_tapthe;
use App\Model\NghiepVu\CumKhoiThiDua\dsphongtraothiduacumkhoi;
use App\Model\NghiepVu\CumKhoiThiDua\dsphongtraothiduacumkhoi_tieuchuan;
use App\Model\NghiepVu\DangKyDanhHieu\dshosodangkyphongtraothidua;
use App\Model\View\view_dsphongtrao_cumkhoi;
use App\Model\View\viewdiabandonvi;
use App\Model\View\viewdonvi_dsphongtrao;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class dshosodenghikhenthuongthiduacumkhoiController extends Controller
{
    public static $url = '/CumKhoiThiDua/DeNghiThiDua/';
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
        if (!chkPhanQuyen('dshosodenghikhenthuongthiduacumkhoi', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'dshosodenghikhenthuongthiduacumkhoi')->with('tenphanquyen', 'danhsach');
        }

        $inputs = $request->all();
        $inputs['url_hs'] = '/CumKhoiThiDua/ThamGiaThiDua/';
        $inputs['url_xd'] = static::$url;
        $inputs['url_qd'] = '/CumKhoiThiDua/PheDuyetThiDua/';

        $inputs['phanloaikhenthuong'] = 'KHENTHUONG';
        $inputs['phanloaihoso'] = 'KHENTHUONG';

        $m_donvi = getDonVi(session('admin')->capdo);
        // $m_donvi = getDonVi(session('admin')->capdo, 'dshosodenghikhenthuongthiduacumkhoi', null, 'MODEL');
        $m_diaban = dsdiaban::wherein('madiaban', array_column($m_donvi->toarray(), 'madiaban'))->get();
        $inputs['nam'] = $inputs['nam'] ?? 'ALL';
        $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;
        $donvi = $m_donvi->where('madonvi', $inputs['madonvi'])->first();
        //lấy hết phong trào cấp tỉnh
        $model = view_dsphongtrao_cumkhoi::orderby('tungay')->get();

        $ngayhientai = date('Y-m-d');
        $m_hoso = dshosothamgiathiduacumkhoi::wherein('trangthai', ['CD', 'DD', 'CXKT', 'DKT', 'DXKT'])->where('madonvi_nhan', $inputs['madonvi'])->get();

        $m_khenthuong = dshosotdktcumkhoi::where('madonvi', $inputs['madonvi'])->get();

        foreach ($model as $ct) {
            $this->KiemTraPhongTrao($ct, $ngayhientai);
            $hoso = $m_hoso->where('maphongtraotd', $ct->maphongtraotd);
            $ct->sohoso = $hoso == null ? 0 : $hoso->count();

            $khenthuong = $m_khenthuong->where('maphongtraotd', $ct->maphongtraotd)->first();
            $ct->mahosotdkt = $khenthuong->mahosotdkt ?? '-1';
            $ct->trangthaikt = $khenthuong->trangthai ?? 'CXD';
            $ct->noidungkt = $khenthuong->noidung ?? '';
            $ct->madonvinhankt = $khenthuong->madonvi_nhan_xd ?? '';

            $ct->soluongkhenthuong = dshosotdktcumkhoi_canhan::where('mahosotdkt', $ct->mahosotdkt)->where('ketqua', '1')->count()
                + dshosotdktcumkhoi_tapthe::where('mahosotdkt', $ct->mahosotdkt)->where('ketqua', '1')->count();

            //gán để ko in hồ sơ mahosothamgiapt
            $ct->mahosothamgiapt = '-1';
        }
        $inputs['trangthai'] = session('chucnang')['dshosodenghikhenthuongthiduacumkhoi']['trangthai'] ?? 'CC';
        $inputs['trangthai'] = $inputs['trangthai'] == 'ALL' ? 'CC' : $inputs['trangthai'];
        
        $a_donviql = getDonViXetDuyetDiaBan_Tam($donvi);
        //dd($a_donviql);    
        //$a_donviql = getDonViXetDuyetDiaBan($donvi);
        //dd($model);
        return view('NghiepVu.CumKhoiThiDua.PhongTraoThiDua.XetDuyetHoSo.ThongTin')
            ->with('inputs', $inputs)
            ->with('model', $model->sortby('tungay'))
            ->with('a_phongtraotd', array_column($model->toarray(), 'noidung', 'maphongtraotd'))
            ->with('m_donvi', $m_donvi)
            ->with('m_diaban', $m_diaban)
            ->with('a_trangthaihoso', getTrangThaiTDKT())
            ->with('a_phamvi', getPhamViPhongTrao())
            ->with('a_donviql', $a_donviql)
            ->with('a_dsdonvi', array_column(dsdonvi::all()->toArray(), 'tendonvi', 'madonvi'))
            ->with('pageTitle', 'Hồ sơ đề nghị khen thưởng thi đua');
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

    public function ThemKT(Request $request)
    {
        if (!chkPhanQuyen('dshosodenghikhenthuongthiduacumkhoi', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dshosodenghikhenthuongthiduacumkhoi')->with('tenphanquyen', 'thaydoi');
        }
        $inputs = $request->all();
        $chk = dshosotdktcumkhoi::where('maphongtraotd', $inputs['maphongtraotd'])
            ->where('phanloai', 'KHENTHUONG')
            ->where('madonvi', $inputs['madonvi'])->first();
        $m_phongtrao = dsphongtraothiduacumkhoi::where('maphongtraotd', $inputs['maphongtraotd'])->first();
        //Lấy danh sách cán bộ đề nghị khen thưởng rồi thêm vào hosothiduakhenthuong
        //Chuyển trạng thái hồ sơ tham gia
        //chuyển trang thái phong trào
        //dd($chk);
        if ($chk == null) {
            //Lấy danh sách hồ sơ theo phong trào; theo địa bàn,; theo đơn vi nhận
            $m_hosokt = dshosothamgiathiduacumkhoi::where('maphongtraotd', $inputs['maphongtraotd'])
                ->wherein('mahoso', function ($qr) use ($inputs) {
                    $qr->select('mahoso')->from('dshosothamgiathiduacumkhoi')
                        ->wherein('trangthai', ['DD', 'CXKT'])
                        ->where('madonvi_nhan', $inputs['madonvi'])->get();
                })->get();
            //dd($m_hosokt);
            $inputs['mahosotdkt'] = (string)getdate()[0];
            $inputs['maloaihinhkt'] = $m_phongtrao->maloaihinhkt;

            $a_canhan = [];
            $a_tapthe = [];
            $inputs['trangthai'] = session('chucnang')['dshosodenghikhenthuongthiduacumkhoi']['trangthai'] ?? 'DD';
            setThongTinHoSo($inputs);
            $inputs['phanloai'] = 'KHENTHUONG';
            foreach ($m_hosokt as $hoso) {
                //Khen thưởng cá nhân
                foreach (dshosothamgiathiduacumkhoi_canhan::where('mahoso', $hoso->mahoso)->get() as $canhan) {
                    $a_canhan[] = [
                        'mahosotdkt' => $inputs['mahosotdkt'],
                        'maccvc' => $canhan->maccvc,
                        'socancuoc' => $canhan->socancuoc,
                        'tendoituong' => $canhan->tendoituong,
                        'ngaysinh' => $canhan->ngaysinh,
                        'gioitinh' => $canhan->gioitinh,
                        'chucvu' => $canhan->chucvu,
                        'diachi' => $canhan->diachi,
                        'tencoquan' => $canhan->tencoquan,
                        'tenphongban' => $canhan->tenphongban,
                        'maphanloaicanbo' => $canhan->maphanloaicanbo,
                        'madanhhieukhenthuong' => $canhan->madanhhieukhenthuong,
                        'ketqua' => '1',
                    ];
                }

                //Khen thưởng tập thể
                foreach (dshosothamgiathiduacumkhoi_tapthe::where('mahoso', $hoso->mahoso)->get() as $tapthe) {
                    $a_tapthe[] = [
                        'mahosotdkt' => $inputs['mahosotdkt'],
                        'maphanloaitapthe' => $tapthe->maphanloaitapthe,
                        'tentapthe' => $tapthe->tentapthe,
                        'ghichu' => $tapthe->ghichu,
                        'madanhhieukhenthuong' => $tapthe->madanhhieukhenthuong,
                        'ketqua' => '1',
                    ];
                }

                //Lưu trạng thái
                //$hoso->mahosotdkt = $inputs['mahosotdkt'];
                $thoigian = date('Y-m-d H:i:s');
                setTrangThaiHoSo($inputs['madonvi'], $hoso, ['madonvi' => $inputs['madonvi'], 'thoigian' => $thoigian, 'trangthai' => $inputs['trangthai']]);
                setTrangThaiHoSo($hoso->madonvi, $hoso, ['trangthai' => $inputs['trangthai']]);
                $hoso->save();
            }
            // if (isset($inputs['totrinh'])) {
            //     $filedk = $request->file('totrinh');
            //     $inputs['totrinh'] = $inputs['mahosotdkt'] . '_totrinh.' . $filedk->getClientOriginalExtension();
            //     $filedk->move(public_path() . '/data/totrinh/', $inputs['totrinh']);
            // }

            dshosotdktcumkhoi::create($inputs);
            foreach (array_chunk($a_canhan, 100) as $data) {
                dshosotdktcumkhoi_canhan::insert($data);
            }
            foreach (array_chunk($a_tapthe, 100) as $data) {
                dshosotdktcumkhoi_tapthe::insert($data);
            }
            //$m_phongtrao->trangthai = 'DXKT';
            //$m_phongtrao->save();
        }
        return redirect(static::$url . 'XetKT?mahosotdkt=' . $inputs['mahosotdkt']);
    }

    public function LuuKT(Request $request)
    {
        if (!chkPhanQuyen('dshosodenghikhenthuongthiduacumkhoi', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dshosodenghikhenthuongthiduacumkhoi')->with('tenphanquyen', 'thaydoi');
        }
        $inputs = $request->all();
        $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        if (isset($inputs['totrinh'])) {
            $filedk = $request->file('totrinh');
            $inputs['totrinh'] = $model->mahosotdkt . '_totrinh' . $filedk->getClientOriginalExtension();
            $filedk->move(public_path() . '/data/totrinh/', $inputs['totrinh']);
        }
        if (isset($inputs['baocao'])) {
            $filedk = $request->file('baocao');
            $inputs['baocao'] = $model->mahosotdkt . '_baocao' . $filedk->getClientOriginalExtension();
            $filedk->move(public_path() . '/data/baocao/', $inputs['baocao']);
        }
        if (isset($inputs['bienban'])) {
            $filedk = $request->file('bienban');
            $inputs['bienban'] = $model->mahosotdkt . '_bienban' . $filedk->getClientOriginalExtension();
            $filedk->move(public_path() . '/data/bienban/', $inputs['bienban']);
        }
        if (isset($inputs['tailieukhac'])) {
            $filedk = $request->file('tailieukhac');
            $inputs['tailieukhac'] = $model->mahosotdkt . '_tailieukhac' . $filedk->getClientOriginalExtension();
            $filedk->move(public_path() . '/data/tailieukhac/', $inputs['tailieukhac']);
        }
        $model->update($inputs);
        return redirect(static::$url . 'ThongTin?madonvi=' . $model->madonvi);
    }

    public function XetKT(Request $request)
    {
        if (!chkPhanQuyen('dshosodenghikhenthuongthiduacumkhoi', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'dshosodenghikhenthuongthiduacumkhoi')->with('tenphanquyen', 'danhsach');
        }
        $inputs = $request->all();
        $inputs['url'] = static::$url;
        $inputs['url_hs'] = '/CumKhoiThiDua/ThamGiaThiDua/';
        $inputs['url_xd'] = static::$url;
        $inputs['url_qd'] = '/CumKhoiThiDua/PheDuyetThiDua/';

        $inputs['maloaihinhkt'] = session('chucnang')['dshosothidua']['maloaihinhkt'] ?? 'ALL';
        $inputs['phanloaihoso'] = 'dshosotdktcumkhoi';

        $model =  dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $model_tapthe =  dshosotdktcumkhoi_tapthe::where('mahosotdkt', $model->mahosotdkt)->get();
        $model_canhan =  dshosotdktcumkhoi_canhan::where('mahosotdkt', $model->mahosotdkt)->get();

        $model_tailieu =  dshosotdktcumkhoi_tailieu::where('mahosotdkt', $model->mahosotdkt)->get();
        $donvi = viewdiabandonvi::where('madonvi', $model->madonvi)->first();
        $a_dhkt_canhan = getDanhHieuKhenThuong($donvi->capdo);
        $a_dhkt_tapthe = getDanhHieuKhenThuong($donvi->capdo, 'TAPTHE');
        $a_dhkt_hogiadinh = getDanhHieuKhenThuong($donvi->capdo, 'HOGIADINH');

        $m_phongtrao = dsphongtraothiduacumkhoi::where('maphongtraotd', $model->maphongtraotd)->first();
        $m_tieuchuan = dsphongtraothiduacumkhoi_tieuchuan::where('maphongtraotd', $model->maphongtraotd)->get();
        $model->tenphongtrao = $m_phongtrao->noidung;
        $a_tapthe = array_column(dmnhomphanloai_chitiet::wherein('manhomphanloai', ['TAPTHE'])->get()->toarray(), 'tenphanloai', 'maphanloai');
        $a_hogiadinh = array_column(dmnhomphanloai_chitiet::wherein('manhomphanloai', ['HOGIADINH'])->get()->toarray(), 'tenphanloai', 'maphanloai');
        $a_canhan = array_column(dmnhomphanloai_chitiet::wherein('manhomphanloai', ['CANHAN'])->get()->toarray(), 'tenphanloai', 'maphanloai');

        return view('NghiepVu.CumKhoiThiDua.PhongTraoThiDua.XetDuyetHoSo.XetKT')
            ->with('model', $model)
            ->with('model_tapthe', $model_tapthe)
            ->with('model_canhan', $model_canhan)
            // ->with('model_hogiadinh', $model_hogiadinh)
            ->with('model_tailieu', $model_tailieu)
            ->with('a_pltailieu', getPhanLoaiTaiLieuDK())
            ->with('a_donvi', array_column(dsdonvi::all()->toArray(), 'tendonvi', 'madonvi'))
            ->with('m_tieuchuan', $m_tieuchuan)
            ->with('a_dhkt_canhan',  $a_dhkt_canhan)
            ->with('a_dhkt_tapthe',  $a_dhkt_tapthe)
            ->with('a_dhkt_hogiadinh', $a_dhkt_hogiadinh)
            ->with('a_tapthe', $a_tapthe)
            ->with('a_canhan', $a_canhan)
            ->with('a_hogiadinh', $a_hogiadinh)
            ->with('m_phongtrao', $m_phongtrao)
            ->with('a_donvi', array_column(viewdiabandonvi::all()->toArray(), 'tendonvi', 'madonvi'))
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Hồ sơ đề nghị khen thưởng phong trào thi đua');
    }

    public function XoaHoSoKT(Request $request)
    {
        if (!chkPhanQuyen('dshosodenghikhenthuongthiduacumkhoi', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dshosodenghikhenthuongthiduacumkhoi');
        }
        $inputs = $request->all();
        $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        dshosotdktcumkhoi_canhan::where('mahosotdkt', $model->mahosotdkt)->delete();
        dshosotdktcumkhoi_tapthe::where('mahosotdkt', $model->mahosotdkt)->delete();
        dshosothamgiathiduacumkhoi::where('mahosotdkt', $model->mahosotdkt)->update(['trangthai' => 'DD', 'mahosotdkt' => null]);
        $model->delete();
        return redirect(static::$url . 'ThongTin?madonvi=' . $model->madonvi);
    }

    public function XemHoSoKT(Request $request)
    {
        $inputs = $request->all();
        $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $model_canhan = dshosotdktcumkhoi_canhan::where('mahosotdkt', $model->mahosotdkt)->get();
        $model_tapthe = dshosotdktcumkhoi_tapthe::where('mahosotdkt', $model->mahosotdkt)->get();
        $a_phanloaidt = array_column(dmnhomphanloai_chitiet::all()->toarray(), 'tenphanloai', 'maphanloai');
        $m_donvi = dsdonvi::where('madonvi', $model->madonvi)->first();

        return view('NghiepVu.CumKhoiThiDua.PhongTraoThiDua.XetDuyetHoSo.XemKT')
            ->with('model', $model)
            ->with('model_canhan', $model_canhan)
            ->with('model_tapthe', $model_tapthe)
            ->with('m_donvi', $m_donvi)
            ->with('a_phanloaidt', $a_phanloaidt)
            ->with('a_dhkt', getDanhHieuKhenThuong('ALL'))
            //->with('a_danhhieu', array_column(dmdanhhieuthidua::all()->toArray(), 'tendanhhieutd', 'madanhhieutd'))
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            //->with('a_hinhthuckt', array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Thông tin hồ sơ đề nghị khen thưởng');
    }

    public function DanhSach(Request $request)
    {
        if (!chkPhanQuyen('dshosodenghikhenthuongthiduacumkhoi', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'dshosodenghikhenthuongthiduacumkhoi')->with('tenphanquyen', 'danhsach');
        }
        $inputs = $request->all();
        $inputs['url_hs'] = '/CumKhoiThiDua/ThamGiaThiDua/';
        $inputs['url_xd'] = static::$url;
        $inputs['url_qd'] = '/CumKhoiThiDua/PheDuyetThiDua/';

        $m_phongtrao = dsphongtraothiduacumkhoi::where('maphongtraotd', $inputs['maphongtraotd'])->first();

        $ngayhientai = date('Y-m-d');
        $this->KiemTraPhongTrao($m_phongtrao, $ngayhientai);
        $model = dshosothamgiathiduacumkhoi::where('maphongtraotd', $inputs['maphongtraotd'])
            ->wherein('mahoso', function ($qr) use ($inputs) {
                $qr->select('mahoso')->from('dshosothamgiathiduacumkhoi')
                    ->where('madonvi_nhan', $inputs['madonvi'])
                    ->orwhere('madonvi_xd', $inputs['madonvi'])
                    ->orwhere('madonvi_kt', $inputs['madonvi'])->get();
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

        return view('NghiepVu.CumKhoiThiDua.PhongTraoThiDua.XetDuyetHoSo.DanhSach')
            ->with('inputs', $inputs)
            ->with('model', $model)
            ->with('m_phongtrao', $m_phongtrao)
            ->with('a_donvi', array_column(dsdonvi::all()->toArray(), 'tendonvi', 'madonvi'))
            ->with('pageTitle', 'Danh sách hồ sơ đăng ký thi đua');
    }

    public function XemDanhSach(Request $request)
    {
        $inputs = $request->all();
        $m_dangky = dsphongtraothiduacumkhoi::where('maphongtraotd', $inputs['maphongtraotd'])->first();
        $donvi = viewdiabandonvi::where('madonvi', $inputs['madonvi'])->first();
        // $model = dshosothamgiathiduacumkhoi::where('maphongtraotd',$inputs['maphongtraotd'])
        // ->wherein('mahosothamgiapt',function($qr){
        //     $qr->select('mahoso')->from('trangthaihoso')->wherein('trangthai',['CD','DD'])->where('phanloai','dshosothamgiathiduacumkhoi')->get();
        // })->get();
        //$m_trangthai = trangthaihoso::wherein('trangthai', ['CD', 'DD'])->where('phanloai', 'dshosothamgiathiduacumkhoi')->orderby('thoigian', 'desc')->get();
        $model = dshosothamgiathiduacumkhoi::where('maphongtraotd', $inputs['maphongtraotd'])
            ->wherein('mahoso', function ($qr) use ($inputs) {
                $qr->select('mahoso')->from('dshosothamgiathiduacumkhoi')
                    ->where('madonvi_nhan', $inputs['madonvi'])
                    ->orwhere('madonvi_nhan_h', $inputs['madonvi'])
                    ->orwhere('madonvi_nhan_t', $inputs['madonvi'])->get();
            })->get();
        foreach ($model as $chitiet) {
            $chitiet->chuyentiephoso = false;
            if ($m_dangky->phamviapdung == 'TOANTINH' && $donvi->capdo == 'H')
                $chitiet->chuyentiephoso = true;
            getDonViChuyen($inputs['madonvi'], $chitiet);
            //$chitiet->trangthai = $donvi->capdo == 'H' ? $chitiet->trangthai_h : $chitiet->trangthai_t;
        }
        //dd($model);
        $m_donvi = getDonVi(session('admin')->capdo);

        return view('NghiepVu.CumKhoiThiDua.PhongTraoThiDua.XetDuyetHoSo.Xem')
            ->with('inputs', $inputs)
            ->with('model', $model)
            ->with('m_dangky', $m_dangky)
            ->with('a_donvi', array_column($m_donvi->toArray(), 'tendonvi', 'madonvi'))
            ->with('a_donviql', getDonViQuanLyTinh()) //chưa lọc hết (chỉ chuyển lên cấp Tỉnh)
            ->with('pageTitle', 'Danh sách hồ sơ đăng ký thi đua');
    }

    public function TraLai(Request $request)
    {
        if (!chkPhanQuyen('dshosodenghikhenthuongthiduacumkhoi', 'hoanthanh')) {
            return view('errors.noperm')->with('machucnang', 'dshosodenghikhenthuongthiduacumkhoi')->with('tenphanquyen', 'hoanthanh');
        }
        $inputs = $request->all();
        $inputs = $request->all();
        $thoigian = date('Y-m-d H:i:s');
        $model = dshosothamgiathiduacumkhoi::where('mahoso', $inputs['mahoso'])->first();
        $m_nhatky = dshosothamgiathiduacumkhoi::where('mahoso', $inputs['mahoso'])->first();
        //lấy thông tin lưu nhật ký
        getDonViChuyen($inputs['madonvi'], $m_nhatky);
        trangthaihoso::create([
            'mahoso' => $inputs['mahoso'], 'trangthai' => 'BTL',
            'thoigian' => $thoigian, 'lydo' => $inputs['lydo'],
            'madonvi_nhan' => $m_nhatky->madonvi_hoso, 'madonvi' => $m_nhatky->madonvi_nhan_hoso
        ]);

        $model->lydo = $inputs['lydo'];
        $model->trangthai = 'BTL';
        $model->trangthai_xd = null;
        $model->thoigian_xd = null;
        $model->madonvi_xd = null;
        $model->save();

        $m_hoso = dshosothamgiathiduacumkhoi::where('mahoso', $inputs['mahoso'])->first();

        return redirect(static::$url . 'DanhSach?maphongtraotd=' . $m_hoso->maphongtraotd . '&madonvi=' . $inputs['madonvi']);
    }

    public function NhanHoSo(Request $request)
    {
        if (!chkPhanQuyen('dshosodenghikhenthuongthiduacumkhoi', 'hoanthanh')) {
            return view('errors.noperm')->with('machucnang', 'dshosodenghikhenthuongthiduacumkhoi')->with('tenphanquyen', 'hoanthanh');
        }
        $inputs = $request->all();
        $thoigian = date('Y-m-d H:i:s');
        $model = dshosothamgiathiduacumkhoi::where('mahoso', $inputs['mahoso'])->first();
        //$m_donvi = viewdiabandonvi::where('madonvi', $inputs['madonvi_nhan'])->first();
        $model->trangthai = 'DD';
        $model->trangthai_xd = $model->trangthai;
        $model->thoigian_xd = $thoigian;

        //setNhanHoSo($inputs['madonvi_nhan'], $model, ['trangthai' => $model->trangthai]);
        //dd($model);
        //setChuyenHoSo($m_donvi->capdo, $model, ['madonvi' => $inputs['madonvi_nhan'], 'thoigian' => $thoigian, 'trangthai' => $model->trangthai]);
        $model->save();

        return redirect('/CumKhoiThiDua/DeNghiThiDua/DanhSach?maphongtraotd=' . $model->maphongtraotd . '&madonvi=' . $inputs['madonvi_nhan']);
    }

    public function ChuyenHoSo(Request $request)
    {
        if (!chkPhanQuyen('dshosodenghikhenthuongthiduacumkhoi', 'hoanthanh')) {
            return view('errors.noperm')->with('machucnang', 'xdhosokhenthuongnienhan')->with('tenphanquyen', 'hoanthanh');
        }
        $inputs = $request->all();
        $thoigian = date('Y-m-d H:i:s');
        $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahoso'])->first();
        //Kiểm tra phong trào xem đơn vị tiếp nhận có quản lý không (phong trào cấp H thì đơn vị cấp Tỉnh ko nhìn thấy)        
        $phamviapdung = dsphongtraothiduacumkhoi::where('maphongtraotd', $model->maphongtraotd)->first()->phamviapdung ?? 'PHAMVI';
        $capdo = viewdiabandonvi::where('madonvi', $inputs['madonvi_nhan'])->first()->capdo ?? 'CAPDO';
        switch ($phamviapdung) {
            case 'X': {
                    if ($phamviapdung != $capdo) {
                        return view('errors.404')
                            ->with('message', 'Phong trào thi đua không thuộc phạm vi quản lý của đơn vị tiếp nhận<br>nên đơn vị không thể xét khen thưởng.')
                            ->with('url', '/XetDuyetHoSoThiDua/ThongTin?madonvi=' . $model->madonvi);
                    }
                    break;
                }
            case 'H': {
                    if (!in_array($capdo, ['X', 'H'])) {
                        return view('errors.404')
                            ->with('message', 'Phong trào thi đua không thuộc phạm vi quản lý của đơn vị tiếp nhận<br>nên đơn vị không thể xét khen thưởng.')
                            ->with('url', '/XetDuyetHoSoThiDua/ThongTin?madonvi=' . $model->madonvi);
                    }
                    break;
                }
            case 'SBN': {
                    if (!in_array($capdo, ['T'])) {
                        return view('errors.404')
                            ->with('message', 'Phong trào thi đua không thuộc phạm vi quản lý của đơn vị tiếp nhận<br>nên đơn vị không thể xét khen thưởng.')
                            ->with('url', '/XetDuyetHoSoThiDua/ThongTin?madonvi=' . $model->madonvi);
                    }
                    break;
                }
            default: {
                    // return view('errors.404')
                    //     ->with('message', 'Phong trào thi đua không thuộc phạm vi quản lý của đơn vị tiếp nhận<br>nên đơn vị không thể xét khen thưởng.')
                    //     ->with('url', '/XetDuyetHoSoThiDua/ThongTin?madonvi=' . $model->madonvi);
                }
        }

        //gán lại trạng thái hồ sơ để theo dõi
        $model->madonvi_xd = $model->madonvi; //do đơn vị tạo hồ sơ ở bước xét duyệt
        $model->trangthai = 'CXKT';
        $model->trangthai_xd = $model->trangthai;
        $model->thoigian_xd = $thoigian;
        $model->madonvi_nhan_xd = $inputs['madonvi_nhan'];

        $model->madonvi_kt = $inputs['madonvi_nhan'];
        $model->trangthai_kt = $model->trangthai;
        $model->thoigian_kt = $thoigian;
        //Gán mặc định quyết định
        getTaoQuyetDinhKT($model);
        $model->save();

        trangthaihoso::create([
            'mahoso' => $inputs['mahoso'],
            'phanloai' => 'dshosotdktcumkhoi',
            'trangthai' => $model->trangthai,
            'thoigian' => $thoigian,
            'madonvi_nhan' => $inputs['madonvi_nhan'],
            'madonvi' => $inputs['madonvi'],
            'thongtin' => 'Trình đề nghị khen thưởng.',
        ]);
        //setTrangThaiHoSo($inputs['madonvi'], $model, ['thoigian' => $thoigian, 'trangthai' => $model->trangthai]);
        //setChuyenHoSo($m_donvi->capdo, $model, ['madonvi' => $inputs['madonvi_nhan'], 'thoigian' => $thoigian, 'trangthai' => $model->trangthai]);
        //dd($model);

        return redirect(static::$url . 'ThongTin?madonvi=' . $inputs['madonvi']);
    }

    public function QuyetDinh(Request $request)
    {
        $inputs = $request->all();
        $inputs['url'] = static::$url;
        $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $inputs['madonvi'] = $model->madonvi;
        if ($model->thongtinquyetdinh == '') {
            $thongtinquyetdinh = duthaoquyetdinh::all()->first()->codehtml ?? '';
            //noidung
            $thongtinquyetdinh = str_replace('[noidung]', $model->noidung, $thongtinquyetdinh);
            // //chucvunguoiky
            // $thongtinquyetdinh = str_replace('[chucvunguoiky]', $model->chucvunguoiky, $thongtinquyetdinh);
            // //hotennguoiky
            // $thongtinquyetdinh = str_replace('[hotennguoiky]',  $model->hotennguoiky, $thongtinquyetdinh);

            $m_canhan = dshosotdktcumkhoi_canhan::where('mahosotdkt', $model->mahosotdkt)->where('ketqua', '1')->orderby('stt')->get();
            if ($m_canhan->count() > 0) {
                $s_canhan = '';
                $i = 1;
                foreach ($m_canhan as $canhan) {
                    $s_canhan .= '<p style=&#34;margin-left:40px;&#34;>' .
                        ($i++) . '. ' . $canhan->tendoituong .
                        ($canhan->chucvu == '' ? '' : ('; ' . $canhan->chucvu)) .
                        ($canhan->tencoquan == '' ? '' : ('; ' . $canhan->tencoquan)) .
                        '</p>';
                    //dd($s_canhan);
                }
                //dd($s_canhan);
                // $thongtinquyetdinh = str_replace('<p style=&#34;margin-left:25px;&#34;>[khenthuongcanhan]</p>',  $s_canhan, $thongtinquyetdinh);
                $thongtinquyetdinh = str_replace('[khenthuongcanhan]',  $s_canhan, $thongtinquyetdinh);
            }

            //Tập thể
            $m_tapthe = dshosotdktcumkhoi_tapthe::where('mahosotdkt', $model->mahosotdkt)->where('ketqua', '1')->orderby('stt')->get();
            if ($m_tapthe->count() > 0) {
                $s_tapthe = '';
                $i = 1;
                foreach ($m_tapthe as $chitiet) {
                    $s_tapthe .= '<p style=&#34;margin-left:40px;&#34;>' .
                        ($i++) . '. ' . $chitiet->tentapthe .
                        '</p>';
                }
                $thongtinquyetdinh = str_replace('[khenthuongtapthe]',  $s_tapthe, $thongtinquyetdinh);
            }
            $model->thongtinquyetdinh = $thongtinquyetdinh;
        }
        //dd($inputs);
        $a_duthao = array_column(duthaoquyetdinh::all()->toArray(), 'noidung', 'maduthao');
        $inputs['maduthao'] = $inputs['maduthao'] ?? array_key_first($a_duthao);
        return view('BaoCao.DonVi.QuyetDinh.MauChung')
            ->with('model', $model)
            ->with('a_duthao', $a_duthao)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Quyết định khen thưởng');
    }

    public function InQuyetDinh(Request $request)
    {
        $inputs = $request->all();
        $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        // if ($model->thongtinquyetdinh == '') {
        //     $model->thongtinquyetdinh = getQuyetDinhCKE('QUYETDINH');
        // }
        $model->thongtinquyetdinh = str_replace('<p>[sangtrangmoi]</p>', '<div class=&#34;sangtrangmoi&#34;></div>', $model->thongtinquyetdinh);
        //dd($model);
        return view('BaoCao.DonVi.XemQuyetDinh')
            ->with('model', $model)
            ->with('pageTitle', 'Quyết định khen thưởng');
    }

    public function DuThaoQuyetDinh(Request $request)
    {
        $inputs = $request->all();
        $inputs['url'] = static::$url;
        $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $inputs['madonvi'] = $model->madonvi;
        $a_duthao = array_column(duthaoquyetdinh
            ::all()->toArray(), 'noidung', 'maduthao');
        $inputs['maduthao'] = $inputs['maduthao'] ?? array_key_first($a_duthao);
        $thongtinquyetdinh = duthaoquyetdinh::where('maduthao', $inputs['maduthao'])->first()->codehtml ?? '';
        //noidung
        $thongtinquyetdinh = str_replace('[noidung]', $model->noidung, $thongtinquyetdinh);

        $m_canhan = dshosotdktcumkhoi_canhan::where('mahosotdkt', $model->mahosotdkt)->where('ketqua', '1')->orderby('stt')->get();
        if ($m_canhan->count() > 0) {
            $s_canhan = '';
            $i = 1;
            foreach ($m_canhan as $canhan) {
                $s_canhan .= '<p style=&#34;margin-left:40px;&#34;>' .
                    ($i++) . '. ' . $canhan->tendoituong .
                    ($canhan->chucvu == '' ? '' : ('; ' . $canhan->chucvu)) .
                    ($canhan->tencoquan == '' ? '' : ('; ' . $canhan->tencoquan)) .
                    '</p>';
                //dd($s_canhan);
            }
            //dd($s_canhan);
            // $thongtinquyetdinh = str_replace('<p style=&#34;margin-left:25px;&#34;>[khenthuongcanhan]</p>',  $s_canhan, $thongtinquyetdinh);
            $thongtinquyetdinh = str_replace('[khenthuongcanhan]',  $s_canhan, $thongtinquyetdinh);
        }

        //Tập thể
        $m_tapthe = dshosotdktcumkhoi_tapthe::where('mahosotdkt', $model->mahosotdkt)->where('ketqua', '1')->orderby('stt')->get();
        if ($m_tapthe->count() > 0) {
            $s_tapthe = '';
            $i = 1;
            foreach ($m_tapthe as $chitiet) {
                $s_tapthe .= '<p style=&#34;margin-left:40px;&#34;>' .
                    ($i++) . '. ' . $chitiet->tentapthe .
                    '</p>';
            }
            $thongtinquyetdinh = str_replace('[khenthuongtapthe]',  $s_tapthe, $thongtinquyetdinh);
        }
        $model->thongtinquyetdinh = $thongtinquyetdinh;

        return view('BaoCao.DonVi.QuyetDinh.MauChung')
            ->with('model', $model)
            ->with('a_duthao', $a_duthao)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Quyết định khen thưởng');
    }

    public function LuuQuyetDinh(Request $request)
    {
        $inputs = $request->all();
        //dd($inputs);
        $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $model->thongtinquyetdinh = $inputs['thongtinquyetdinh'];
        $model->save();
        return redirect(static::$url . 'ThongTin?madonvi=' . $model->madonvi_xd);
    }

    public function LayLyDo(Request $request)
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

        $inputs = $request->all();
        $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $model->lydo = $model->lydo_xd;
        die(json_encode($model));
    }

    public function ThemCaNhan(Request $request)
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

        $inputs = $request->all();
        //$id =  $inputs['id'];       
        $model = dshosotdktcumkhoi_canhan::where('id', $inputs['id'])->first();
        unset($inputs['id']);
        if ($model == null) {
            dshosotdktcumkhoi_canhan::create($inputs);
        } else
            $model->update($inputs);
        // return response()->json($inputs['id']);

        $danhsach = dshosotdktcumkhoi_canhan::where('mahosotdkt', $inputs['mahosotdkt'])->get();
        $dungchung = new dungchung_nghiepvuController();
        $dungchung->htmlCaNhan($result, $danhsach, static::$url, true, $inputs['maloaihinhkt']);
        return response()->json($result);
    }

    public function XoaCaNhan(Request $request)
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
        $inputs = $request->all();
        $model = dshosotdktcumkhoi_canhan::findorfail($inputs['id']);
        $model->delete();

        $m_tapthe = dshosotdktcumkhoi_canhan::where('mahosotdkt', $model->mahosotdkt)->get();
        $this->htmlCaNhan($result, $m_tapthe);
        return response()->json($result);
    }

    public function NhanExcelCaNhan(Request $request)
    {
        $inputs = $request->all();
        //dd($inputs);
        //$model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $filename = $inputs['mahosotdkt'] . '_' . getdate()[0];
        $request->file('fexcel')->move(public_path() . '/data/uploads/', $filename . '.xlsx');
        $path = public_path() . '/data/uploads/' . $filename . '.xlsx';
        $data = [];

        Excel::load($path, function ($reader) use (&$data, $inputs) {
            $obj = $reader->getExcel();
            $sheet = $obj->getSheet(0);
            $data = $sheet->toArray(null, true, true, true); // giữ lại tiêu đề A=>'val';
        });
        $a_dm = array();

        for ($i = $inputs['tudong']; $i <= $inputs['dendong']; $i++) {
            if (!isset($data[$i][$inputs['tendoituong']])) {
                continue;
            }
            $a_dm[] = array(
                'mahosotdkt' => $inputs['mahosotdkt'],
                'tendoituong' => $data[$i][$inputs['tendoituong']] ?? '',
                'madanhhieukhenthuong' => $data[$i][$inputs['madanhhieukhenthuong']] ?? $inputs['madanhhieukhenthuong_md'],
                'maphanloaicanbo' => $data[$i][$inputs['maphanloaicanbo']] ?? $inputs['maphanloaicanbo_md'],
                // 'madanhhieutd' => $data[$i][$inputs['madanhhieutd']] ?? $inputs['madanhhieutd_md'],
                'gioitinh' => $data[$i][$inputs['gioitinh']] ?? 'NAM',
                'ngaysinh' => $data[$i][$inputs['ngaysinh']] ?? null,
                'chucvu' => $data[$i][$inputs['chucvu']] ?? '',
                'tenphongban' => $data[$i][$inputs['tenphongban']] ?? '',
                'tencoquan' => $data[$i][$inputs['tencoquan']] ?? '',
                'ketqua' => '1',
            );
        }

        dshosotdktcumkhoi_canhan::insert($a_dm);
        File::Delete($path);

        return redirect(static::$url . 'XetKT?mahosotdkt=' . $inputs['mahosotdkt']);
    }

    public function LayTapThe(Request $request)
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

        $inputs = $request->all();
        $model = dshosotdktcumkhoi_tapthe::findorfail($inputs['id']);
        die(json_encode($model));
    }

    public function LayCaNhan(Request $request)
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

        $inputs = $request->all();
        $model = dshosotdktcumkhoi_canhan::findorfail($inputs['id']);
        die(json_encode($model));
    }

    public function ThemTapThe(Request $request)
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

        $inputs = $request->all();
        //$id =  $inputs['id'];       
        $model = dshosotdktcumkhoi_tapthe::where('id', $inputs['id'])->first();
        unset($inputs['id']);
        if ($model == null) {
            dshosotdktcumkhoi_tapthe::create($inputs);
        } else
            $model->update($inputs);
        // return response()->json($inputs['id']);

        $danhsach = dshosotdktcumkhoi_tapthe::where('mahosotdkt', $inputs['mahosotdkt'])->get();
        $dungchung = new dungchung_nghiepvuController();
        $dungchung->htmlTapThe($result, $danhsach, static::$url, true, $inputs['maloaihinhkt']);
        return response()->json($result);
        //return die(json_encode($result));
    }

    public function XoaTapThe(Request $request)
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
        $inputs = $request->all();
        $model = dshosotdktcumkhoi_tapthe::findorfail($inputs['id']);
        $model->delete();

        $danhsach = dshosotdktcumkhoi_tapthe::where('mahosotdkt', $model->mahosotdkt)->get();
        $dungchung = new dungchung_nghiepvuController();
        $dungchung->htmlTapThe($result, $danhsach, static::$url, true, $inputs['maloaihinhkt']);

        return response()->json($result);
    }

    public function NhanExcelTapThe(Request $request)
    {
        $inputs = $request->all();
        //dd($inputs);
        //$model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $filename = $inputs['mahosotdkt'] . '_' . getdate()[0];
        $request->file('fexcel')->move(public_path() . '/data/uploads/', $filename . '.xlsx');
        $path = public_path() . '/data/uploads/' . $filename . '.xlsx';
        $data = [];

        Excel::load($path, function ($reader) use (&$data, $inputs) {
            $obj = $reader->getExcel();
            $sheet = $obj->getSheet(0);
            $data = $sheet->toArray(null, true, true, true); // giữ lại tiêu đề A=>'val';
        });
        $a_dm = array();

        for ($i = $inputs['tudong']; $i <= $inputs['dendong']; $i++) {
            if (!isset($data[$i][$inputs['tentapthe']])) {
                continue;
            }
            $a_dm[] = array(
                'mahosotdkt' => $inputs['mahosotdkt'],
                'tentapthe' => $data[$i][$inputs['tentapthe']] ?? '',
                // 'mahinhthuckt' => $data[$i][$inputs['mahinhthuckt']] ?? $inputs['mahinhthuckt_md'],
                'maphanloaitapthe' => $data[$i][$inputs['maphanloaitapthe']] ?? $inputs['maphanloaitapthe_md'],
                'madanhhieukhenthuong' => $data[$i][$inputs['madanhhieukhenthuong']] ?? $inputs['madanhhieukhenthuong_md'],
                'ketqua' => '1',
            );
        }
        dshosotdktcumkhoi_tapthe::insert($a_dm);
        File::Delete($path);

        return redirect(static::$url . 'XetKT?mahosotdkt=' . $inputs['mahosotdkt']);
    }

    public function TaiLieuDinhKem(Request $request)
    {
        $result = array(
            'status' => 'fail',
            'message' => 'error',
        );

        $inputs = $request->all();
        $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahs'])->first();
        $result['message'] = '<div class="modal-body" id = "dinh_kem" >';
        if ($model->totrinh != '') {
            $result['message'] .= '<div class="form-group row">';
            $result['message'] .= '<label class="col-3 col-form-label font-weight-bold" >Tờ trình:</label>';
            $result['message'] .= '<div class="col-9 form-control"><a target = "_blank" href = "' . url('/data/totrinh/' . $model->totrinh) . '">' . $model->totrinh . '</a ></div>';
            $result['message'] .= '</div>';
        }
        if ($model->baocao != '') {
            $result['message'] .= '<div class="form-group row">';
            $result['message'] .= '<label class="col-3 col-form-label font-weight-bold" >Báo cáo thành tích:</label>';
            $result['message'] .= '<div class="col-9 form-control"><a target = "_blank" href = "' . url('/data/baocao/' . $model->baocao) . '">' . $model->baocao . '</a ></div>';
            $result['message'] .= '</div>';
        }
        if ($model->bienban != '') {
            $result['message'] .= '<div class="form-group row">';
            $result['message'] .= '<label class="col-3 col-form-label font-weight-bold" >Biên bản cuộc họp</label>';
            $result['message'] .= '<div class="col-9 form-control"><a target = "_blank" href = "' . url('/data/bienban/' . $model->bienban) . '">' . $model->bienban . '</a ></div>';
            $result['message'] .= '</div>';
        }
        if ($model->tailieukhac != '') {
            $result['message'] .= '<div class="form-group row">';
            $result['message'] .= '<label class="col-3 col-form-label font-weight-bold" >Tài liệu khác</label>';
            $result['message'] .= '<div class="col-9 form-control"><a target = "_blank" href = "' . url('/data/tailieukhac/' . $model->tailieukhac) . '">' . $model->tailieukhac . '</a ></div>';
            $result['message'] .= '</div>';
        }
        $result['message'] .= '</div>';
        $result['status'] = 'success';

        die(json_encode($result));
    }


    public function GanKhenThuong(Request $request)
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
        $inputs = $request->all();
        //dd($inputs);
        if ($inputs['phanloai'] == 'TAPTHE') {
            dshosotdktcumkhoi_tapthe::where('mahosotdkt', $inputs['mahosotdkt'])->update(['ketqua' => $inputs['ketqua'], 'noidungkhenthuong' => $inputs['noidungkhenthuong']]);
            $danhsach = dshosotdktcumkhoi_tapthe::where('mahosotdkt', $inputs['mahosotdkt'])->get();
            $dungchung = new dungchung_nghiepvuController();
            $dungchung->htmlTapThe($result, $danhsach, static::$url, true, $inputs['maloaihinhkt']);
        } else {
            dshosotdktcumkhoi_canhan::where('mahosotdkt', $inputs['mahosotdkt'])->update(['ketqua' => $inputs['ketqua'], 'noidungkhenthuong' => $inputs['noidungkhenthuong']]);
            $danhsach = dshosotdktcumkhoi_canhan::where('mahosotdkt', $inputs['mahosotdkt'])->get();
            $dungchung = new dungchung_nghiepvuController();
            $dungchung->htmlCaNhan($result, $danhsach, static::$url, true, $inputs['maloaihinhkt']);
        }

        return response()->json($result);
    }

    public function ToTrinhHoSo(Request $request)
    {
        $inputs = $request->all();
        $inputs['url'] = static::$url;
        $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $inputs['madonvi'] = $model->madonvi;
        $inputs['maduthao'] = $inputs['maduthao'] ?? 'ALL';
        getTaoDuThaoToTrinhHoSo($model, $inputs['maduthao']);
        $a_duthao = array_column(duthaoquyetdinh::wherein('phanloai', ['TOTRINHHOSO'])->get()->toArray(), 'noidung', 'maduthao');

        $inputs['maduthao'] = $inputs['maduthao'] ?? array_key_first($a_duthao);
        return view('BaoCao.DonVi.QuyetDinh.MauChungToTrinh')
            ->with('model', $model)
            ->with('a_duthao', $a_duthao)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Dự thảo tờ trình khen thưởng');
    }

    public function LuuToTrinhHoSo(Request $request)
    {
        $inputs = $request->all();
        $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $model->thongtintotrinhhoso = $inputs['thongtintotrinhhoso'];
        $model->save();
        return redirect(static::$url . 'ThongTin?madonvi=' . $model->madonvi);
    }

    public function InToTrinhHoSo(Request $request)
    {
        $inputs = $request->all();
        $model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        getTaoDuThaoToTrinhHoSo($model);
        $model->thongtinquyetdinh = $model->thongtintotrinhhoso;
        $model->thongtinquyetdinh = str_replace('<p>[sangtrangmoi]</p>', '<div class=&#34;sangtrangmoi&#34;></div>', $model->thongtinquyetdinh);
        //dd($model);
        return view('BaoCao.DonVi.XemQuyetDinh')
            ->with('model', $model)
            ->with('pageTitle', 'Tờ trình khen thưởng');
    }

    public function NhanExcel(Request $request)
    {
        $dungchung = new dungchung_nhanexcelController();
        $dungchung->NhanExcelKhenThuong($request);
        return redirect(static::$url . 'XetKT?mahosotdkt=' . $request->all()['mahoso']);
    }
}
