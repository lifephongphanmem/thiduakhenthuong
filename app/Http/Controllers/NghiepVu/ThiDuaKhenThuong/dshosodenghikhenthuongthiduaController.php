<?php

namespace App\Http\Controllers\NghiepVu\ThiDuaKhenThuong;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\NghiepVu\_DungChung\dungchung_nghiepvuController;
use App\Http\Controllers\NghiepVu\_DungChung\dungchung_nhanexcelController;
use App\Model\DanhMuc\dmloaihinhkhenthuong;
use App\Model\DanhMuc\dmnhomphanloai_chitiet;
use App\Model\DanhMuc\dsdiaban;
use App\Model\DanhMuc\dsdonvi;
use App\Model\HeThong\trangthaihoso;
use App\Model\NghiepVu\DangKyDanhHieu\dshosodangkyphongtraothidua;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothamgiaphongtraotd;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothamgiaphongtraotd_canhan;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothamgiaphongtraotd_tapthe;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_canhan;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_hogiadinh;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_tailieu;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_tapthe;
use App\Model\NghiepVu\ThiDuaKhenThuong\dsphongtraothidua;
use App\Model\NghiepVu\ThiDuaKhenThuong\dsphongtraothidua_khenthuong;
use App\Model\NghiepVu\ThiDuaKhenThuong\dsphongtraothidua_tieuchuan;
use App\Model\View\viewdiabandonvi;
use App\Model\View\viewdonvi_dsphongtrao;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class dshosodenghikhenthuongthiduaController extends Controller
{
    public static $url = '/HoSoDeNghiKhenThuongThiDua/';
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
        if (!chkPhanQuyen('dshosodenghikhenthuongthidua', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'dshosodenghikhenthuongthidua')->with('tenphanquyen', 'danhsach');
        }

        $inputs = $request->all();
        $inputs['url_dk'] = '/HoSoThiDua/';
        $inputs['url_hs'] = '/HoSoDeNghiKhenThuongThiDua/';
        $inputs['url_xd'] = '/XetDuyetHoSoThiDua/';
        $inputs['url_qd'] = '/KhenThuongHoSoThiDua/';
        $inputs['phanloaikhenthuong'] = 'KHENTHUONG';
        $inputs['phanloaihoso'] = 'dshosothiduakhenthuong';

        $m_donvi = getDonVi(session('admin')->capdo, 'dshosodenghikhenthuongthidua', null, 'MODEL');
        $m_diaban = dsdiaban::wherein('madiaban', array_column($m_donvi->toarray(), 'madiaban'))->get();
        $inputs['nam'] = $inputs['nam'] ?? 'ALL';
        $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;

        $donvi = $m_donvi->where('madonvi', $inputs['madonvi'])->first();

        //Lọc danh sách phong trao
        /*
        1. Xã: Đơn vị + Huyện quản lý
        2. Huyện: Đơn vị + Tỉnh
        3. Sở ban nganh: Đơn vị + Tỉnh
        4. Tỉnh: Tỉnh
        */

        switch ($donvi->capdo) {
            case 'X': {
                    //Xã: Đơn vị + Huyện quản lý
                    $model = viewdonvi_dsphongtrao::wherein('madiaban', [$donvi->madiaban, $donvi->madiabanQL])->orderby('tungay')->get();
                    break;
                }
            case 'H': {
                    //Huyện: Đơn vị + Tỉnh
                    $model = viewdonvi_dsphongtrao::where('madiaban', $donvi->madiaban)
                        ->orwherein('phamviapdung', ['T', 'TW'])
                        ->orderby('tungay')->get();
                    break;
                }
            case 'T': {
                    //Sở ban nganh: Đơn vị + Tỉnh
                    $model = viewdonvi_dsphongtrao::where('madonvi', $inputs['madonvi'])
                        ->orwherein('phamviapdung', ['T', 'TW'])
                        ->orderby('tungay')->get();
                    break;
                }
        }
        // dd($model);    
        //kết quả        
        $inputs['phamviapdung'] = $inputs['phamviapdung'] ?? 'ALL';
        if ($inputs['phamviapdung'] != 'ALL') {
            $model = $model->where('phamviapdung', $inputs['phamviapdung']);
        }
        $ngayhientai = date('Y-m-d');
        $m_hosothamgia = dshosothamgiaphongtraotd::wherein('trangthai', ['CD', 'DD', 'CXKT', 'DKT', 'DXKT'])
            ->wherein('maphongtraotd', array_column($model->toarray(), 'maphongtraotd'))
            ->where('madonvi_nhan', $inputs['madonvi'])->get();
        $m_hoso = dshosothiduakhenthuong::where('madonvi', $inputs['madonvi'])
            ->wherein('maphongtraotd', array_column($model->toarray(), 'maphongtraotd'))->get();
        $a_trangthai = array_unique(array_column($m_hoso->toarray(), 'trangthai'));

        foreach ($model as $ct) {
            KiemTraPhongTrao($ct, $ngayhientai);
            $khenthuong = $m_hoso->where('maphongtraotd', $ct->maphongtraotd);
            foreach ($a_trangthai as $trangthai) {
                $ct->$trangthai = $khenthuong->where('trangthai', $trangthai)->count();
            }
            $ct->sohosodenghi = $khenthuong->count();
            $ct->sohosothamgia = $m_hosothamgia->where('maphongtraotd', $ct->maphongtraotd)->count();
        }

        $inputs['trangthai'] = session('chucnang')['dshosodenghikhenthuongthidua']['trangthai'] ?? 'CC';
        $inputs['trangthai'] = $inputs['trangthai'] == 'ALL' ? 'CC' : $inputs['trangthai'];
        $a_donviql = getDonViXetDuyetDiaBan($donvi);

        return view('NghiepVu.ThiDuaKhenThuong.HoSoDeNghiKhenThuongPhongTrao.ThongTin')
            ->with('inputs', $inputs)
            ->with('model', $model->sortby('tungay'))
            ->with('a_phongtraotd', array_column($model->toarray(), 'noidung', 'maphongtraotd'))
            ->with('m_donvi', $m_donvi)
            ->with('m_diaban', $m_diaban)
            ->with('a_trangthai_hoso', $a_trangthai)
            ->with('a_trangthaihoso', getTrangThaiTDKT())
            ->with('a_trangthai', getTrangThaiHoSo())
            ->with('a_phamvi', getPhamViPhongTrao())
            // ->with('a_donviql', $a_donviql)
            ->with('a_dsdonvi', array_column(dsdonvi::all()->toArray(), 'tendonvi', 'madonvi'))
            ->with('pageTitle', 'Hồ sơ đề nghị khen thưởng thi đua');
    }

    public function DanhSach(Request $request)
    {
        if (!chkPhanQuyen('dshosodenghikhenthuongthidua', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'dshosodenghikhenthuongthidua')->with('tenphanquyen', 'danhsach');
        }
        $inputs = $request->all();
        $inputs['trangthai'] = session('chucnang')['dshosodenghikhenthuongthidua']['trangthai'] ?? 'CC';
        $inputs['trangthai'] = $inputs['trangthai'] != 'ALL' ? $inputs['trangthai'] : 'CC';
        $inputs['url_hs'] = '/HoSoDeNghiKhenThuongThiDua/';
        $inputs['url_xd'] = '/XetDuyetHoSoThiDua/';
        $inputs['url_qd'] = '/KhenThuongHoSoThiDua/';
        $inputs['phanloaikhenthuong'] = 'KHENTHUONG';
        $inputs['phanloaihoso'] = 'dshosothiduakhenthuong';

        $m_phongtrao = dsphongtraothidua::where('maphongtraotd', $inputs['maphongtraotd'])->first();
        $ngayhientai = date('Y-m-d');
        //Kiểm tra phong trào        
        KiemTraPhongTrao($m_phongtrao, $ngayhientai);

        $donvi = dsdonvi::where('madonvi', $inputs['madonvi'])->first();
        $model = dshosothiduakhenthuong::where('maphongtraotd', $inputs['maphongtraotd'])
            ->where('madonvi', $inputs['madonvi'])->get();

        $model_hoso = dshosothamgiaphongtraotd::wherein('trangthai', ['CD', 'DD', 'CXKT', 'DKT', 'DXKT'])
            ->where('maphongtraotd', $inputs['maphongtraotd'])
            ->where('madonvi_nhan', $inputs['madonvi'])->get();

        foreach ($model as $key => $hoso) {
            $hoso->soluongkhenthuong = dshosothiduakhenthuong_canhan::where('mahosotdkt', $hoso->mahosotdkt)->count()
                + dshosothiduakhenthuong_tapthe::where('mahosotdkt', $hoso->mahosotdkt)->count();
            //Gán lại trạng thái hồ sơ
            // $hoso->madonvi_hoso = $hoso->madonvi_xd;
            // $hoso->trangthai_hoso = $hoso->trangthai_xd;
            // $hoso->thoigian_hoso = $hoso->thoigian_xd;
            // $hoso->lydo_hoso = $hoso->lydo_xd;
            // $hoso->madonvi_nhan_hoso = $hoso->madonvi_nhan_xd;
        }
        //dd($m_phongtrao);
        //getDonViXetDuyetDiaBan()
        return view('NghiepVu.ThiDuaKhenThuong.HoSoDeNghiKhenThuongPhongTrao.DanhSach')
            ->with('inputs', $inputs)
            ->with('model', $model)
            ->with('model_hoso', $model_hoso)
            ->with('a_phanloaihs', getPhanLoaiHoSo('KHENTHUONG'))
            ->with('m_phongtrao', $m_phongtrao)
            ->with('a_donviql', getDonViXetDuyetPhongTrao($donvi, $m_phongtrao))
            ->with('a_donvinganh', getDonViQuanLyNganh($donvi))
            ->with('a_donvi', array_column(dsdonvi::all()->toArray(), 'tendonvi', 'madonvi'))
            ->with('pageTitle', 'Danh sách hồ sơ đăng ký thi đua');
    }

    public function ThemKT(Request $request)
    {
        if (!chkPhanQuyen('dshosodenghikhenthuongthidua', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dshosodenghikhenthuongthidua')->with('tenphanquyen', 'thaydoi');
        }
        $inputs = $request->all();        
        $m_phongtrao = dsphongtraothidua::where('maphongtraotd', $inputs['maphongtraotd'])->first();

        //Lấy danh sách hồ sơ theo phong trào; theo địa bàn,; theo đơn vi nhận
        $a_hoso = array_keys($inputs['hoso'] ?? []);
        $m_hosokt = dshosothamgiaphongtraotd::wherein('mahosothamgiapt', $a_hoso)->get();

        //dd($m_hosokt);
        $inputs['mahosotdkt'] = (string)getdate()[0];
        $inputs['maloaihinhkt'] = $m_phongtrao->maloaihinhkt;

        $a_canhan = [];
        $a_tapthe = [];
        $inputs['trangthai'] = session('chucnang')['dshosodenghikhenthuongthidua']['trangthai'] ?? 'CC';
        setThongTinHoSo($inputs);
        $inputs['phanloai'] = 'KHENTHUONG';
        foreach ($m_hosokt as $hoso) {
            //Khen thưởng cá nhân
            foreach (dshosothamgiaphongtraotd_canhan::where('mahosothamgiapt', $hoso->mahosothamgiapt)->get() as $canhan) {
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
            foreach (dshosothamgiaphongtraotd_tapthe::where('mahosothamgiapt', $hoso->mahosothamgiapt)->get() as $tapthe) {
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
            $hoso->mahosotdkt = $inputs['mahosotdkt'];
            $thoigian = date('Y-m-d H:i:s');
            setTrangThaiHoSo($inputs['madonvi'], $hoso, ['madonvi' => $inputs['madonvi'], 'thoigian' => $thoigian, 'trangthai' => $inputs['trangthai']]);
            setTrangThaiHoSo($hoso->madonvi, $hoso, ['trangthai' => $inputs['trangthai']]);
            $hoso->save();
        }


        dshosothiduakhenthuong::create($inputs);
        foreach (array_chunk($a_canhan, 100) as $data) {
            dshosothiduakhenthuong_canhan::insert($data);
        }
        foreach (array_chunk($a_tapthe, 100) as $data) {
            dshosothiduakhenthuong_tapthe::insert($data);
        }

        //Lưu trạng thái
        trangthaihoso::create([
            'mahoso' => $inputs['mahosotdkt'],
            'phanloai' => 'dshosothiduakhenthuong',
            'trangthai' => $inputs['trangthai'],
            'thoigian' => $inputs['ngayhoso'],
            'madonvi' => $inputs['madonvi'],
            'thongtin' => 'Tạo mới hồ sơ đề nghị khen thưởng.',
            'tendangnhap' => session('admin')->tendangnhap,
        ]);

        return redirect(static::$url . 'Sua?mahosotdkt=' . $inputs['mahosotdkt']);
    }

    public function LuuKT(Request $request)
    {
        if (!chkPhanQuyen('dshosodenghikhenthuongthidua', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dshosodenghikhenthuongthidua')->with('tenphanquyen', 'thaydoi');
        }
        $inputs = $request->all();
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        // if (isset($inputs['totrinh'])) {
        //     $filedk = $request->file('totrinh');
        //     $inputs['totrinh'] = $model->mahosotdkt . '_totrinh' . $filedk->getClientOriginalExtension();
        //     $filedk->move(public_path() . '/data/totrinh/', $inputs['totrinh']);
        // }
        // if (isset($inputs['baocao'])) {
        //     $filedk = $request->file('baocao');
        //     $inputs['baocao'] = $model->mahosotdkt . '_baocao' . $filedk->getClientOriginalExtension();
        //     $filedk->move(public_path() . '/data/baocao/', $inputs['baocao']);
        // }
        // if (isset($inputs['bienban'])) {
        //     $filedk = $request->file('bienban');
        //     $inputs['bienban'] = $model->mahosotdkt . '_bienban' . $filedk->getClientOriginalExtension();
        //     $filedk->move(public_path() . '/data/bienban/', $inputs['bienban']);
        // }
        // if (isset($inputs['tailieukhac'])) {
        //     $filedk = $request->file('tailieukhac');
        //     $inputs['tailieukhac'] = $model->mahosotdkt . '_tailieukhac' . $filedk->getClientOriginalExtension();
        //     $filedk->move(public_path() . '/data/tailieukhac/', $inputs['tailieukhac']);
        // }
        $model->update($inputs);
        return redirect(static::$url . 'DanhSach?madonvi=' . $model->madonvi . '&maphongtraotd=' . $model->maphongtraotd);
    }

    public function Sua(Request $request)
    {
        if (!chkPhanQuyen('dshosodenghikhenthuongthidua', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'dshosodenghikhenthuongthidua')->with('tenphanquyen', 'danhsach');
        }
        $inputs = $request->all();
        $inputs['url'] = '/HoSoDeNghiKhenThuongThiDua/';
        $inputs['url_hs'] = '/HoSoDeNghiKhenThuongThiDua/';
        $inputs['url_xd'] = '/XetDuyetHoSoThiDua/';
        $inputs['url_qd'] = '/KhenThuongHoSoThiDua/';
        $inputs['maloaihinhkt'] = session('chucnang')['dshosothidua']['maloaihinhkt'] ?? 'ALL';
        $inputs['phanloaihoso'] = 'dshosothiduakhenthuong';

        $model =  dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $model_tapthe =  dshosothiduakhenthuong_tapthe::where('mahosotdkt', $model->mahosotdkt)->get();
        $model_canhan =  dshosothiduakhenthuong_canhan::where('mahosotdkt', $model->mahosotdkt)->get();
        $model_hogiadinh =  dshosothiduakhenthuong_hogiadinh::where('mahosotdkt', $model->mahosotdkt)->get();
        $model_tailieu =  dshosothiduakhenthuong_tailieu::where('mahosotdkt', $model->mahosotdkt)->get();
        // $donvi = viewdiabandonvi::where('madonvi', $model->madonvi)->first();
        // $a_dhkt_canhan = getDanhHieuKhenThuong($donvi->capdo);
        // $a_dhkt_tapthe = getDanhHieuKhenThuong($donvi->capdo, 'TAPTHE');
        // $a_dhkt_hogiadinh = getDanhHieuKhenThuong($donvi->capdo, 'HOGIADINH');

        $a_dhkt_canhan = getDanhHieuKhenThuong('ALL');
        $a_dhkt_tapthe = getDanhHieuKhenThuong('ALL', 'TAPTHE');
        $a_dhkt_hogiadinh = getDanhHieuKhenThuong('ALL', 'HOGIADINH');

        $m_phongtrao = dsphongtraothidua::where('maphongtraotd', $model->maphongtraotd)->first();
        $m_tieuchuan = dsphongtraothidua_tieuchuan::where('maphongtraotd', $model->maphongtraotd)->get();
        $model->tenphongtrao = $m_phongtrao->noidung;
        $a_tapthe = array_column(dmnhomphanloai_chitiet::wherein('manhomphanloai', ['TAPTHE'])->get()->toarray(), 'tenphanloai', 'maphanloai');
        $a_hogiadinh = array_column(dmnhomphanloai_chitiet::wherein('manhomphanloai', ['HOGIADINH'])->get()->toarray(), 'tenphanloai', 'maphanloai');
        $a_canhan = array_column(dmnhomphanloai_chitiet::wherein('manhomphanloai', ['CANHAN'])->get()->toarray(), 'tenphanloai', 'maphanloai');

        return view('NghiepVu.ThiDuaKhenThuong.HoSoDeNghiKhenThuongPhongTrao.XetKT')
            ->with('model', $model)
            ->with('model_tapthe', $model_tapthe)
            ->with('model_canhan', $model_canhan)
            ->with('model_hogiadinh', $model_hogiadinh)
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
        if (!chkPhanQuyen('dshosodenghikhenthuongthidua', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dshosodenghikhenthuongthidua');
        }
        $inputs = $request->all();
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        dshosothiduakhenthuong_canhan::where('mahosotdkt', $model->mahosotdkt)->delete();
        dshosothiduakhenthuong_tapthe::where('mahosotdkt', $model->mahosotdkt)->delete();
        dshosothamgiaphongtraotd::where('mahosotdkt', $model->mahosotdkt)->update(['trangthai' => 'DD', 'mahosotdkt' => null]);
        $model->delete();
        return redirect(static::$url . 'ThongTin?madonvi=' . $model->madonvi);
    }

    public function XemHoSoKT(Request $request)
    {
        $inputs = $request->all();
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $model_canhan = dshosothiduakhenthuong_canhan::where('mahosotdkt', $model->mahosotdkt)->get();
        $model_tapthe = dshosothiduakhenthuong_tapthe::where('mahosotdkt', $model->mahosotdkt)->get();
        $a_phanloaidt = array_column(dmnhomphanloai_chitiet::all()->toarray(), 'tenphanloai', 'maphanloai');
        $m_donvi = dsdonvi::where('madonvi', $model->madonvi)->first();

        return view('NghiepVu.ThiDuaKhenThuong.XetDuyetHoSo.XemKT')
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

    public function DanhSachHoSo(Request $request)
    {
        if (!chkPhanQuyen('dshosodenghikhenthuongthidua', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'dshosodenghikhenthuongthidua')->with('tenphanquyen', 'danhsach');
        }
        $inputs = $request->all();
        $m_phongtrao = dsphongtraothidua::where('maphongtraotd', $inputs['maphongtraotd'])->first();

        $ngayhientai = date('Y-m-d');
        KiemTraPhongTrao($m_phongtrao, $ngayhientai);
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

        return view('NghiepVu.ThiDuaKhenThuong.HoSoDeNghiKhenThuongPhongTrao.DanhSachHoSoThamGia')
            ->with('inputs', $inputs)
            ->with('model', $model)
            ->with('m_phongtrao', $m_phongtrao)
            ->with('a_donvi', array_column(dsdonvi::all()->toArray(), 'tendonvi', 'madonvi'))
            ->with('pageTitle', 'Danh sách hồ sơ đăng ký thi đua');
    }

    public function XemDanhSach(Request $request)
    {
        $inputs = $request->all();
        $m_dangky = dsphongtraothidua::where('maphongtraotd', $inputs['maphongtraotd'])->first();
        $donvi = viewdiabandonvi::where('madonvi', $inputs['madonvi'])->first();
        // $model = dshosothamgiaphongtraotd::where('maphongtraotd',$inputs['maphongtraotd'])
        // ->wherein('mahosothamgiapt',function($qr){
        //     $qr->select('mahoso')->from('trangthaihoso')->wherein('trangthai',['CD','DD'])->where('phanloai','dshosothamgiaphongtraotd')->get();
        // })->get();
        //$m_trangthai = trangthaihoso::wherein('trangthai', ['CD', 'DD'])->where('phanloai', 'dshosothamgiaphongtraotd')->orderby('thoigian', 'desc')->get();
        $model = dshosothamgiaphongtraotd::where('maphongtraotd', $inputs['maphongtraotd'])
            ->wherein('mahosothamgiapt', function ($qr) use ($inputs) {
                $qr->select('mahosothamgiapt')->from('dshosothamgiaphongtraotd')
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

        return view('NghiepVu.ThiDuaKhenThuong.XetDuyetHoSo.Xem')
            ->with('inputs', $inputs)
            ->with('model', $model)
            ->with('m_dangky', $m_dangky)
            ->with('a_donvi', array_column($m_donvi->toArray(), 'tendonvi', 'madonvi'))
            ->with('a_donviql', getDonViQuanLyTinh()) //chưa lọc hết (chỉ chuyển lên cấp Tỉnh)
            ->with('pageTitle', 'Danh sách hồ sơ đăng ký thi đua');
    }

    public function ChuyenHoSo(Request $request)
    {
        if (!chkPhanQuyen('dshosodenghikhenthuongthidua', 'hoanthanh')) {
            return view('errors.noperm')->with('machucnang', 'dshosodenghikhenthuongthidua')->with('tenphanquyen', 'hoanthanh');
        }
        $inputs = $request->all();

        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahoso'])->first();
        //Kiểm tra phong trào xem đơn vị tiếp nhận có quản lý không (phong trào cấp H thì đơn vị cấp Tỉnh ko nhìn thấy)        
        $phamviapdung = dsphongtraothidua::where('maphongtraotd', $model->maphongtraotd)->first()->phamviapdung ?? 'PHAMVI';
        $donvi = viewdiabandonvi::where('madonvi', $inputs['madonvi_nhan'])->first();
        $capdo = $donvi->capdo ?? 'CAPDO';
        switch ($phamviapdung) {
            case 'X': {
                    if ($phamviapdung != $capdo) {
                        return view('errors.404')
                            ->with('message', 'Phong trào thi đua không thuộc phạm vi quản lý của đơn vị tiếp nhận<br>nên đơn vị: <b>' . ($donvi->tendonvi ?? '') . '</b> không thể nhận đề nghị xét khen thưởng.')
                            ->with('url', '/XetDuyetHoSoThiDua/ThongTin?madonvi=' . $model->madonvi);
                    }
                    break;
                }
            case 'H': {
                    if (!in_array($capdo, ['X', 'H'])) {
                        return view('errors.404')
                            ->with('message', 'Phong trào thi đua không thuộc phạm vi quản lý của đơn vị tiếp nhận<br>nên đơn vị: <b>' . ($donvi->tendonvi ?? '') . '</b> không thể nhận đề nghị xét khen thưởng.')
                            ->with('url', '/XetDuyetHoSoThiDua/ThongTin?madonvi=' . $model->madonvi);
                    }
                    break;
                }
            case 'SBN': {
                    if (!in_array($capdo, ['T'])) {
                        return view('errors.404')
                            ->with('message', 'Phong trào thi đua không thuộc phạm vi quản lý của đơn vị tiếp nhận<br>nên đơn vị: <b>' . ($donvi->tendonvi ?? '') . ' </b>không thể nhận đề nghị xét khen thưởng.')
                            ->with('url', '/XetDuyetHoSoThiDua/ThongTin?madonvi=' . $model->madonvi);
                    }
                    break;
                }
            case 'T': {
                    if (!in_array($capdo, ['T'])) {
                        return view('errors.404')
                            ->with('message', 'Phong trào thi đua không thuộc phạm vi quản lý của đơn vị tiếp nhận<br>nên đơn vị: <b>' . ($donvi->tendonvi ?? '') . '</b> không thể nhận đề nghị xét khen thưởng.')
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
        //dd($phamviapdung);
        $inputs['trangthai'] = getTrangThaiChuyenHS(session('chucnang')['dshosodenghikhenthuongthidua']['trangthai'] ?? 'CC');
        $inputs['thoigian'] = date('Y-m-d H:i:s');
        $inputs['lydo'] = ''; //Xóa lý do trả lại
        setChuyenDV($model, $inputs);

        return redirect(static::$url . 'DanhSach?madonvi=' . $model->madonvi . '&maphongtraotd=' . $model->maphongtraotd);
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
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
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
        $model = dshosothiduakhenthuong_canhan::where('id', $inputs['id'])->first();
        unset($inputs['id']);
        if ($model == null) {
            dshosothiduakhenthuong_canhan::create($inputs);
        } else
            $model->update($inputs);
        // return response()->json($inputs['id']);

        $danhsach = dshosothiduakhenthuong_canhan::where('mahosotdkt', $inputs['mahosotdkt'])->get();
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
        $model = dshosothiduakhenthuong_canhan::findorfail($inputs['id']);
        $model->delete();

        $m_tapthe = dshosothiduakhenthuong_canhan::where('mahosotdkt', $model->mahosotdkt)->get();
        $this->htmlCaNhan($result, $m_tapthe);
        return response()->json($result);
    }

    // public function NhanExcelCaNhan(Request $request)
    // {
    //     $inputs = $request->all();
    //     //dd($inputs);
    //     //$model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
    //     $filename = $inputs['mahosotdkt'] . '_' . getdate()[0];
    //     $request->file('fexcel')->move(public_path() . '/data/uploads/', $filename . '.xlsx');
    //     $path = public_path() . '/data/uploads/' . $filename . '.xlsx';
    //     $data = [];

    //     Excel::load($path, function ($reader) use (&$data, $inputs) {
    //         $obj = $reader->getExcel();
    //         $sheet = $obj->getSheet(0);
    //         $data = $sheet->toArray(null, true, true, true); // giữ lại tiêu đề A=>'val';
    //     });
    //     $a_dm = array();

    //     for ($i = $inputs['tudong']; $i <= $inputs['dendong']; $i++) {
    //         if (!isset($data[$i][$inputs['tendoituong']])) {
    //             continue;
    //         }
    //         $a_dm[] = array(
    //             'mahosotdkt' => $inputs['mahosotdkt'],
    //             'tendoituong' => $data[$i][$inputs['tendoituong']] ?? '',
    //             'madanhhieukhenthuong' => $data[$i][$inputs['madanhhieukhenthuong']] ?? $inputs['madanhhieukhenthuong_md'],
    //             'maphanloaicanbo' => $data[$i][$inputs['maphanloaicanbo']] ?? $inputs['maphanloaicanbo_md'],
    //             // 'madanhhieutd' => $data[$i][$inputs['madanhhieutd']] ?? $inputs['madanhhieutd_md'],
    //             'gioitinh' => $data[$i][$inputs['gioitinh']] ?? 'NAM',
    //             'ngaysinh' => $data[$i][$inputs['ngaysinh']] ?? null,
    //             'chucvu' => $data[$i][$inputs['chucvu']] ?? '',
    //             'tenphongban' => $data[$i][$inputs['tenphongban']] ?? '',
    //             'tencoquan' => $data[$i][$inputs['tencoquan']] ?? '',
    //             'ketqua' => '1',
    //         );
    //     }

    //     dshosothiduakhenthuong_canhan::insert($a_dm);
    //     File::Delete($path);

    //     return redirect(static::$url . 'XetKT?mahosotdkt=' . $inputs['mahosotdkt']);
    // }

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
        $model = dshosothiduakhenthuong_tapthe::findorfail($inputs['id']);
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
        $model = dshosothiduakhenthuong_canhan::findorfail($inputs['id']);
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
        $model = dshosothiduakhenthuong_tapthe::where('id', $inputs['id'])->first();
        unset($inputs['id']);
        if ($model == null) {
            dshosothiduakhenthuong_tapthe::create($inputs);
        } else
            $model->update($inputs);
        // return response()->json($inputs['id']);

        $danhsach = dshosothiduakhenthuong_tapthe::where('mahosotdkt', $inputs['mahosotdkt'])->get();
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
        $model = dshosothiduakhenthuong_tapthe::findorfail($inputs['id']);
        $model->delete();

        $danhsach = dshosothiduakhenthuong_tapthe::where('mahosotdkt', $model->mahosotdkt)->get();
        $dungchung = new dungchung_nghiepvuController();
        $dungchung->htmlTapThe($result, $danhsach, static::$url, true, $inputs['maloaihinhkt']);

        return response()->json($result);
    }

    // public function NhanExcelTapThe(Request $request)
    // {
    //     $inputs = $request->all();
    //     //dd($inputs);
    //     //$model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
    //     $filename = $inputs['mahosotdkt'] . '_' . getdate()[0];
    //     $request->file('fexcel')->move(public_path() . '/data/uploads/', $filename . '.xlsx');
    //     $path = public_path() . '/data/uploads/' . $filename . '.xlsx';
    //     $data = [];

    //     Excel::load($path, function ($reader) use (&$data, $inputs) {
    //         $obj = $reader->getExcel();
    //         $sheet = $obj->getSheet(0);
    //         $data = $sheet->toArray(null, true, true, true); // giữ lại tiêu đề A=>'val';
    //     });
    //     $a_dm = array();

    //     for ($i = $inputs['tudong']; $i <= $inputs['dendong']; $i++) {
    //         if (!isset($data[$i][$inputs['tentapthe']])) {
    //             continue;
    //         }
    //         $a_dm[] = array(
    //             'mahosotdkt' => $inputs['mahosotdkt'],
    //             'tentapthe' => $data[$i][$inputs['tentapthe']] ?? '',
    //             // 'mahinhthuckt' => $data[$i][$inputs['mahinhthuckt']] ?? $inputs['mahinhthuckt_md'],
    //             'maphanloaitapthe' => $data[$i][$inputs['maphanloaitapthe']] ?? $inputs['maphanloaitapthe_md'],
    //             'madanhhieukhenthuong' => $data[$i][$inputs['madanhhieukhenthuong']] ?? $inputs['madanhhieukhenthuong_md'],
    //             'ketqua' => '1',
    //         );
    //     }
    //     dshosothiduakhenthuong_tapthe::insert($a_dm);
    //     File::Delete($path);

    //     return redirect(static::$url . 'XetKT?mahosotdkt=' . $inputs['mahosotdkt']);
    // }

    // public function TaiLieuDinhKem(Request $request)
    // {
    //     $result = array(
    //         'status' => 'fail',
    //         'message' => 'error',
    //     );

    //     $inputs = $request->all();
    //     $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahs'])->first();
    //     $result['message'] = '<div class="modal-body" id = "dinh_kem" >';
    //     if ($model->totrinh != '') {
    //         $result['message'] .= '<div class="form-group row">';
    //         $result['message'] .= '<label class="col-3 col-form-label font-weight-bold" >Tờ trình:</label>';
    //         $result['message'] .= '<div class="col-9 form-control"><a target = "_blank" href = "' . url('/data/totrinh/' . $model->totrinh) . '">' . $model->totrinh . '</a ></div>';
    //         $result['message'] .= '</div>';
    //     }
    //     if ($model->baocao != '') {
    //         $result['message'] .= '<div class="form-group row">';
    //         $result['message'] .= '<label class="col-3 col-form-label font-weight-bold" >Báo cáo thành tích:</label>';
    //         $result['message'] .= '<div class="col-9 form-control"><a target = "_blank" href = "' . url('/data/baocao/' . $model->baocao) . '">' . $model->baocao . '</a ></div>';
    //         $result['message'] .= '</div>';
    //     }
    //     if ($model->bienban != '') {
    //         $result['message'] .= '<div class="form-group row">';
    //         $result['message'] .= '<label class="col-3 col-form-label font-weight-bold" >Biên bản cuộc họp</label>';
    //         $result['message'] .= '<div class="col-9 form-control"><a target = "_blank" href = "' . url('/data/bienban/' . $model->bienban) . '">' . $model->bienban . '</a ></div>';
    //         $result['message'] .= '</div>';
    //     }
    //     if ($model->tailieukhac != '') {
    //         $result['message'] .= '<div class="form-group row">';
    //         $result['message'] .= '<label class="col-3 col-form-label font-weight-bold" >Tài liệu khác</label>';
    //         $result['message'] .= '<div class="col-9 form-control"><a target = "_blank" href = "' . url('/data/tailieukhac/' . $model->tailieukhac) . '">' . $model->tailieukhac . '</a ></div>';
    //         $result['message'] .= '</div>';
    //     }
    //     $result['message'] .= '</div>';
    //     $result['status'] = 'success';

    //     die(json_encode($result));
    // }

    // public function GanKhenThuong(Request $request)
    // {
    //     $result = array(
    //         'status' => 'fail',
    //         'message' => 'error',
    //     );
    //     if (!Session::has('admin')) {
    //         $result = array(
    //             'status' => 'fail',
    //             'message' => 'permission denied',
    //         );
    //         die(json_encode($result));
    //     }
    //     $inputs = $request->all();
    //     //dd($inputs);
    //     if ($inputs['phanloai'] == 'TAPTHE') {
    //         dshosothiduakhenthuong_tapthe::where('mahosotdkt', $inputs['mahosotdkt'])->update(['ketqua' => $inputs['ketqua'], 'noidungkhenthuong' => $inputs['noidungkhenthuong']]);
    //         $danhsach = dshosothiduakhenthuong_tapthe::where('mahosotdkt', $inputs['mahosotdkt'])->get();
    //         $dungchung = new dungchung_nghiepvuController();
    //         $dungchung->htmlTapThe($result, $danhsach, static::$url, true, $inputs['maloaihinhkt']);
    //     } else {
    //         dshosothiduakhenthuong_canhan::where('mahosotdkt', $inputs['mahosotdkt'])->update(['ketqua' => $inputs['ketqua'], 'noidungkhenthuong' => $inputs['noidungkhenthuong']]);
    //         $danhsach = dshosothiduakhenthuong_canhan::where('mahosotdkt', $inputs['mahosotdkt'])->get();
    //         $dungchung = new dungchung_nghiepvuController();
    //         $dungchung->htmlCaNhan($result, $danhsach, static::$url, true, $inputs['maloaihinhkt']);
    //     }

    //     return response()->json($result);
    // }

    public function NhanExcel(Request $request)
    {
        $dungchung = new dungchung_nhanexcelController();
        $dungchung->NhanExcelKhenThuong($request);
        return redirect(static::$url . 'XetKT?mahosotdkt=' . $request->all()['mahoso']);
    }

    public function XoaHoSo(Request $request)
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
        $model = dshosothiduakhenthuong::findorfail($inputs['id']);
        $model->delete();
        dshosothiduakhenthuong_canhan::where('mahosotdkt', $model->mahosotdkt)->delete();
        dshosothiduakhenthuong_tapthe::where('mahosotdkt', $model->mahosotdkt)->delete();
        dshosothiduakhenthuong_hogiadinh::where('mahosotdkt', $model->mahosotdkt)->delete();
        dshosothiduakhenthuong_tailieu::where('mahosotdkt', $model->mahosotdkt)->delete();
        return redirect(static::$url . 'DanhSach?madonvi=' . $model->madonvi . '&maphongtraotd=' . $model->maphongtraotd);
    }
}
