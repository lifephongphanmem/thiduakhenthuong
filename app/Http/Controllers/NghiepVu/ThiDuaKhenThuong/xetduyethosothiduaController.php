<?php

namespace App\Http\Controllers\NghiepVu\ThiDuaKhenThuong;


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
use App\Model\DanhMuc\duthaoquyetdinh;
use App\Model\HeThong\trangthaihoso;
use App\Model\NghiepVu\DangKyDanhHieu\dshosodangkyphongtraothidua;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothamgiaphongtraotd;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothamgiaphongtraotd_canhan;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothamgiaphongtraotd_tapthe;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_canhan;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_tapthe;
use App\Model\NghiepVu\ThiDuaKhenThuong\dsphongtraothidua;
use App\Model\NghiepVu\ThiDuaKhenThuong\dsphongtraothidua_khenthuong;
use App\Model\NghiepVu\ThiDuaKhenThuong\dsphongtraothidua_tieuchuan;
use App\Model\View\viewdiabandonvi;
use App\Model\View\viewdonvi_dsphongtrao;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class xetduyethosothiduaController extends Controller
{
    public static $url = '/XetDuyetHoSoThiDua/';
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
        if (!chkPhanQuyen('xdhosothidua', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'xdhosothidua')->with('tenphanquyen', 'danhsach');
        }

        $inputs = $request->all();
        $inputs['url_hs'] = '/HoSoThiDua/';
        $inputs['url_xd'] = '/XetDuyetHoSoThiDua/';
        $inputs['url_qd'] = '/KhenThuongHoSoThiDua/';
        $m_donvi = getDonVi(session('admin')->capdo, 'xdhosothidua', null, 'MODEL');
        $m_diaban = dsdiaban::wherein('madiaban', array_column($m_donvi->toarray(), 'madiaban'))->get();
        $inputs['nam'] = $inputs['nam'] ?? 'ALL';
        $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;
        $donvi = $m_donvi->where('madonvi', $inputs['madonvi'])->first();
        //lấy hết phong trào cấp tỉnh
        $model = viewdonvi_dsphongtrao::wherein('phamviapdung', ['T', 'TW'])->orderby('tungay')->get();
        switch ($donvi->capdo) {
            case 'X': {
                    //đơn vị cấp xã => chỉ các phong trào trong huyện, xã
                    $model_xa = viewdonvi_dsphongtrao::wherein('madiaban', [$donvi->madiaban, $donvi->madiabanQL])->orderby('tungay')->get();
                    break;
                }
            case 'H': {
                    //đơn vị cấp huyện =>chỉ các phong trào trong huyện
                    $model_xa = viewdonvi_dsphongtrao::where('madiaban', $donvi->madiaban)->orderby('tungay')->get();
                    break;
                }
            case 'T': {
                    //Phong trào theo SBN
                    $model_xa = viewdonvi_dsphongtrao::where('phamviapdung', 'SBN')->orderby('tungay')->get();
                    break;
                }
        }
        foreach ($model_xa as $ct) {
            $model->add($ct);
        }
        //kết quả        
        $inputs['phamviapdung'] = $inputs['phamviapdung'] ?? 'ALL';
        if ($inputs['phamviapdung'] != 'ALL') {
            $model = $model->where('phamviapdung', $inputs['phamviapdung']);
        }
        $ngayhientai = date('Y-m-d');
        $m_hoso = dshosothamgiaphongtraotd::wherein('trangthai', ['CD', 'DD', 'CXKT', 'DKT', 'DXKT'])->where('madonvi_nhan', $inputs['madonvi'])->get();
        $m_khenthuong = dshosothiduakhenthuong::where('madonvi', $inputs['madonvi'])->get();

        //$m_trangthai_phongtrao = trangthaihoso::where('phanloai', 'dsphongtraothidua')->orderby('thoigian', 'desc')->get();
        //dd($ngayhientai);
        foreach ($model as $ct) {
            $this->KiemTraPhongTrao($ct, $ngayhientai);
            $hoso = $m_hoso->where('maphongtraotd', $ct->maphongtraotd);
            $ct->sohoso = $hoso == null ? 0 : $hoso->count();

            $khenthuong = $m_khenthuong->where('maphongtraotd', $ct->maphongtraotd)->first();
            $ct->mahosotdkt = $khenthuong->mahosotdkt ?? '-1';
            $ct->trangthaikt = $khenthuong->trangthai ?? 'CXD';
            $ct->noidungkt = $khenthuong->noidung ?? '';
            $ct->madonvinhankt = $khenthuong->madonvi_nhan_xd ?? '';

            $ct->soluongkhenthuong = dshosothiduakhenthuong_canhan::where('mahosotdkt', $ct->mahosotdkt)->where('ketqua', '1')->count()
                + dshosothiduakhenthuong_tapthe::where('mahosotdkt', $ct->mahosotdkt)->where('ketqua', '1')->count();

            //gán để ko in hồ sơ mahosothamgiapt
            $ct->mahosothamgiapt = '-1';
        }
        //dd($model);
        return view('NghiepVu.ThiDuaKhenThuong.XetDuyetHoSo.ThongTin')
            ->with('inputs', $inputs)
            ->with('model', $model->sortby('tungay'))
            ->with('a_phongtraotd', array_column($model->toarray(), 'noidung', 'maphongtraotd'))
            ->with('m_donvi', $m_donvi)
            ->with('m_diaban', $m_diaban)
            ->with('a_trangthaihoso', getTrangThaiTDKT())
            ->with('a_phamvi', getPhamViPhongTrao())
            ->with('a_donviql', getDonViQuanLyDiaBan($donvi))
            ->with('a_dsdonvi', array_column(dsdonvi::all()->toArray(), 'tendonvi', 'madonvi'))
            ->with('pageTitle', 'Xét duyệt hồ sơ thi đua');
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
        if (!chkPhanQuyen('xdhosothidua', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'xdhosothidua')->with('tenphanquyen', 'thaydoi');
        }
        $inputs = $request->all();
        $chk = dshosothiduakhenthuong::where('maphongtraotd', $inputs['maphongtraotd'])
            ->where('madonvi', $inputs['madonvi'])->first();
        $m_phongtrao = dsphongtraothidua::where('maphongtraotd', $inputs['maphongtraotd'])->first();
        //Lấy danh sách cán bộ đề nghị khen thưởng rồi thêm vào hosothiduakhenthuong
        //Chuyển trạng thái hồ sơ tham gia
        //chuyển trang thái phong trào

        if ($chk == null) {
            //Lấy danh sách hồ sơ theo phong trào; theo địa bàn,; theo đơn vi nhận
            $m_hosokt = dshosothamgiaphongtraotd::where('maphongtraotd', $inputs['maphongtraotd'])
                ->wherein('mahosothamgiapt', function ($qr) use ($inputs) {
                    $qr->select('mahosothamgiapt')->from('dshosothamgiaphongtraotd')
                        ->wherein('trangthai', ['DD', 'CXKT'])
                        ->where('madonvi_nhan', $inputs['madonvi'])->get();
                })->get();
            //dd($m_hosokt);
            $inputs['mahosotdkt'] = (string)getdate()[0];
            $inputs['maloaihinhkt'] = $m_phongtrao->maloaihinhkt;

            $a_canhan = [];
            $a_tapthe = [];
            $inputs['trangthai'] = 'DD';
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
                        'mahinhthuckt' => $canhan->mahinhthuckt,
                        'madanhhieutd' => $canhan->madanhhieutd,
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
                        'madanhhieutd' => $tapthe->madanhhieutd,
                        'mahinhthuckt' => $tapthe->mahinhthuckt,
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
            //$m_phongtrao->trangthai = 'DXKT';
            //$m_phongtrao->save();
        }
        return redirect(static::$url . 'XetKT?mahosotdkt=' . $inputs['mahosotdkt']);
    }

    public function LuuKT(Request $request)
    {
        if (!chkPhanQuyen('xdhosothidua', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'xdhosothidua')->with('tenphanquyen', 'thaydoi');
        }
        $inputs = $request->all();
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        if (isset($inputs['totrinh'])) {
            $filedk = $request->file('totrinh');
            $inputs['totrinh'] = $model->mahosotdkt . '_' . $filedk->getClientOriginalExtension();
            $filedk->move(public_path() . '/data/totrinh/', $inputs['totrinh']);
        }
        if (isset($inputs['qdkt'])) {
            $filedk = $request->file('qdkt');
            $inputs['qdkt'] = $model->mahosotdkt . '_' . $filedk->getClientOriginalExtension();
            $filedk->move(public_path() . '/data/qdkt/', $inputs['qdkt']);
        }
        if (isset($inputs['bienban'])) {
            $filedk = $request->file('bienban');
            $inputs['bienban'] = $model->mahosotdkt . '_' . $filedk->getClientOriginalExtension();
            $filedk->move(public_path() . '/data/bienban/', $inputs['bienban']);
        }
        if (isset($inputs['tailieukhac'])) {
            $filedk = $request->file('tailieukhac');
            $inputs['tailieukhac'] = $model->mahosotdkt . '_' . $filedk->getClientOriginalExtension();
            $filedk->move(public_path() . '/data/tailieukhac/', $inputs['tailieukhac']);
        }
        $model->update($inputs);
        return redirect(static::$url . 'ThongTin?madonvi=' . $model->madonvi);
    }

    public function XetKT(Request $request)
    {
        if (!chkPhanQuyen('xdhosothidua', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'xdhosothidua')->with('tenphanquyen', 'danhsach');
        }
        $inputs = $request->all();
        $inputs['url_hs'] = '/XetDuyetHoSoThiDua/';
        $inputs['url_qd'] = '/XetDuyetHoSoThiDua/';
        $inputs['maloaihinhkt'] = session('chucnang')['dshosothidua']['maloaihinhkt'] ?? 'ALL';
        $inputs['mahinhthuckt'] = session('chucnang')['dshosothidua']['mahinhthuckt'] ?? 'ALL';
        $model =  dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $m_phongtrao = dsphongtraothidua::where('maphongtraotd', $model->maphongtraotd)->first();
        $m_danhhieu = dsphongtraothidua_khenthuong::where('maphongtraotd', $model->maphongtraotd)->get();
        $m_tieuchuan = dsphongtraothidua_tieuchuan::where('maphongtraotd', $model->maphongtraotd)->get();
        $model->tenphongtrao = $m_phongtrao->noidung;
        $model_canhan = dshosothiduakhenthuong_canhan::where('mahosotdkt', $model->mahosotdkt)->get();
        $model_tapthe = dshosothiduakhenthuong_tapthe::where('mahosotdkt', $model->mahosotdkt)->get();
        $m_danhhieu = dmdanhhieuthidua::all();

        $a_tapthe = array_column(dmnhomphanloai_chitiet::wherein('manhomphanloai', ['TAPTHE', 'HOGIADINH'])->get()->toarray(), 'tenphanloai', 'maphanloai');
        $a_canhan = array_column(dmnhomphanloai_chitiet::wherein('manhomphanloai', ['CANHAN'])->get()->toarray(), 'tenphanloai', 'maphanloai');
        return view('NghiepVu.ThiDuaKhenThuong.XetDuyetHoSo.XetKT')
            ->with('model', $model)
            ->with('m_danhhieu', $m_danhhieu)
            ->with('m_tieuchuan', $m_tieuchuan)
            ->with('model_canhan', $model_canhan)
            ->with('model_tapthe', $model_tapthe)
            ->with('a_tapthe', $a_tapthe)
            ->with('a_canhan', $a_canhan)
            ->with('m_phongtrao', $m_phongtrao)
            ->with('a_donvi', array_column(viewdiabandonvi::all()->toArray(), 'tendonvi', 'madonvi'))
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('a_hinhthuckt', array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
            ->with('a_danhhieutd', array_column(dmdanhhieuthidua::all()->toArray(), 'tendanhhieutd', 'madanhhieutd'))
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Kết quả phong trào thi đua');
    }

    public function XoaHoSoKT(Request $request)
    {
        if (!chkPhanQuyen('xdhosothidua', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'xdhosothidua');
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
            ->with('a_danhhieu', array_column(dmdanhhieuthidua::all()->toArray(), 'tendanhhieutd', 'madanhhieutd'))
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('a_hinhthuckt', array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Thông tin hồ sơ đề nghị khen thưởng');
    }

    public function DanhSach(Request $request)
    {
        if (!chkPhanQuyen('xdhosothidua', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'xdhosothidua')->with('tenphanquyen', 'danhsach');
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
        foreach ($model as $chitiet) {
            $chitiet->nhanhoso = $m_phongtrao->nhanhoso;
            $chitiet->mahosodk = $m_hoso_dangky->where('madonvi', $chitiet->madonvi)->first()->mahosodk ?? null;
            getDonViChuyen($inputs['madonvi'], $chitiet);
        }
        //dd($model);
        return view('NghiepVu.ThiDuaKhenThuong.XetDuyetHoSo.DanhSach')
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

    public function TraLai(Request $request)
    {
        if (!chkPhanQuyen('xdhosothidua', 'hoanthanh')) {
            return view('errors.noperm')->with('machucnang', 'xdhosothidua')->with('tenphanquyen', 'hoanthanh');
        }
        $inputs = $request->all();
        $inputs = $request->all();
        $thoigian = date('Y-m-d H:i:s');
        $model = dshosothamgiaphongtraotd::where('mahosothamgiapt', $inputs['mahoso'])->first();
        $m_nhatky = dshosothamgiaphongtraotd::where('mahosothamgiapt', $inputs['mahoso'])->first();
        //lấy thông tin lưu nhật ký
        getDonViChuyen($inputs['madonvi'], $m_nhatky);
        trangthaihoso::create([
            'mahoso' => $inputs['mahoso'], 'trangthai' => 'BTL',
            'thoigian' => $thoigian, 'lydo' => $inputs['lydo'],
            'madonvi_nhan' => $m_nhatky->madonvi_hoso, 'madonvi' => $m_nhatky->madonvi_nhan_hoso
        ]);
        //Gán lại trạng thái cho hồ sơ
        setNhanHoSo($inputs['madonvi'], $model, ['trangthai' => 'BTL', 'thoigian' => $thoigian, 'lydo' => $inputs['lydo'], 'madonvi_nhan' => '']);
        setTraLaiHoSo_Nhan($inputs['madonvi'], $model, ['trangthai' => '', 'thoigian' => '', 'lydo' => '', 'madonvi_nhan' => '', 'madonvi' => '']);
        //dd($model);
        $model->save();

        $m_hoso = dshosothamgiaphongtraotd::where('mahosothamgiapt', $inputs['mahoso'])->first();

        return redirect('/XetDuyetHoSoThiDua/DanhSach?maphongtraotd=' . $m_hoso->maphongtraotd . '&madonvi=' . $inputs['madonvi']);
    }

    public function NhanHoSo(Request $request)
    {
        if (!chkPhanQuyen('xdhosothidua', 'hoanthanh')) {
            return view('errors.noperm')->with('machucnang', 'xdhosothidua')->with('tenphanquyen', 'hoanthanh');
        }
        $inputs = $request->all();
        $thoigian = date('Y-m-d H:i:s');
        $model = dshosothamgiaphongtraotd::where('mahosothamgiapt', $inputs['mahoso'])->first();
        $m_donvi = viewdiabandonvi::where('madonvi', $inputs['madonvi_nhan'])->first();
        $model->trangthai = 'DD';
        setNhanHoSo($inputs['madonvi_nhan'], $model, ['trangthai' => $model->trangthai]);
        setChuyenHoSo($m_donvi->capdo, $model, ['madonvi' => $inputs['madonvi_nhan'], 'thoigian' => $thoigian, 'trangthai' => $model->trangthai]);
        $model->save();

        return redirect('/XetDuyetHoSoThiDua/DanhSach?maphongtraotd=' . $model->maphongtraotd . '&madonvi=' . $inputs['madonvi_nhan']);
    }

    public function ChuyenHoSo(Request $request)
    {
        if (!chkPhanQuyen('xdhosokhenthuongnienhan', 'hoanthanh')) {
            return view('errors.noperm')->with('machucnang', 'xdhosokhenthuongnienhan')->with('tenphanquyen', 'hoanthanh');
        }
        $inputs = $request->all();
        $thoigian = date('Y-m-d H:i:s');
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahoso'])->first();
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
        getDuThaoKhenThuong($model);
        $model->save();

        trangthaihoso::create([
            'mahoso' => $inputs['mahoso'],
            'phanloai' => 'dshosothiduakhenthuong',
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
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $inputs['madonvi'] = $model->madonvi;
        if ($model->thongtinquyetdinh == '') {
            $thongtinquyetdinh = duthaoquyetdinh::all()->first()->codehtml ?? '';
            //noidung
            $thongtinquyetdinh = str_replace('[noidung]', $model->noidung, $thongtinquyetdinh);
            //chucvunguoiky
            $thongtinquyetdinh = str_replace('[chucvunguoiky]', $model->chucvunguoiky, $thongtinquyetdinh);
            //hotennguoiky
            $thongtinquyetdinh = str_replace('[hotennguoiky]',  $model->hotennguoiky, $thongtinquyetdinh);

            $m_canhan = dshosothiduakhenthuong_canhan::where('mahosotdkt', $model->mahosotdkt)->where('ketqua', '1')->orderby('stt')->get();
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
            $m_tapthe = dshosothiduakhenthuong_tapthe::where('mahosotdkt', $model->mahosotdkt)->where('ketqua', '1')->orderby('stt')->get();
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
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
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
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $a_duthao = array_column(duthaoquyetdinh
            ::all()->toArray(), 'noidung', 'maduthao');
        $inputs['maduthao'] = $inputs['maduthao'] ?? array_key_first($a_duthao);
        $thongtinquyetdinh = duthaoquyetdinh::where('maduthao', $inputs['maduthao'])->first()->codehtml ?? '';
        //noidung
        $thongtinquyetdinh = str_replace('[noidung]', $model->noidung, $thongtinquyetdinh);
        //chucvunguoiky
        $thongtinquyetdinh = str_replace('[chucvunguoiky]', $model->chucvunguoiky, $thongtinquyetdinh);
        //hotennguoiky
        $thongtinquyetdinh = str_replace('[hotennguoiky]',  $model->hotennguoiky, $thongtinquyetdinh);

        $m_canhan = dshosothiduakhenthuong_canhan::where('mahosotdkt', $model->mahosotdkt)->where('ketqua', '1')->orderby('stt')->get();
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
        $m_tapthe = dshosothiduakhenthuong_tapthe::where('mahosotdkt', $model->mahosotdkt)->where('ketqua', '1')->orderby('stt')->get();
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
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
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

        $model = dshosothiduakhenthuong_canhan::where('mahosotdkt', $inputs['mahosotdkt'])->get();

        $this->htmlCaNhan($result, $model);
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

    public function NhanExcelCaNhan(Request $request)
    {
        $inputs = $request->all();
        //dd($inputs);
        //$model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
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
                'mahinhthuckt' => $data[$i][$inputs['mahinhthuckt']] ?? $inputs['mahinhthuckt_md'],
                'maphanloaicanbo' => $data[$i][$inputs['maphanloaicanbo']] ?? $inputs['maphanloaicanbo_md'],
                'madanhhieutd' => $data[$i][$inputs['madanhhieutd']] ?? $inputs['madanhhieutd_md'],
                "gioitinh" => $data[$i][$inputs['madanhhieutd']] ?? 'NAM',
                'ngaysinh' => $data[$i][$inputs['ngaysinh']] ?? null,
                'chucvu' => $data[$i][$inputs['chucvu']] ?? '',
                'tenphongban' => $data[$i][$inputs['tenphongban']] ?? '',
                'tencoquan' => $data[$i][$inputs['tencoquan']] ?? '',
                'ketqua' => '1',
            );
        }

        dshosothiduakhenthuong_canhan::insert($a_dm);
        File::Delete($path);

        return redirect(static::$url . 'Sua?mahosotdkt=' . $inputs['mahosotdkt']);
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

        $model = dshosothiduakhenthuong_tapthe::where('mahosotdkt', $inputs['mahosotdkt'])->get();


        $this->htmlTapThe($result, $model);
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

        $m_tapthe = dshosothiduakhenthuong_tapthe::where('mahosotdkt', $model->mahosotdkt)->get();
        $this->htmlTapThe($result, $m_tapthe);
        return response()->json($result);
    }

    public function NhanExcelTapThe(Request $request)
    {
        $inputs = $request->all();
        //dd($inputs);
        //$model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
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
                'mahinhthuckt' => $data[$i][$inputs['mahinhthuckt']] ?? $inputs['mahinhthuckt_md'],
                'maphanloaitapthe' => $data[$i][$inputs['maphanloaitapthe']] ?? $inputs['maphanloaitapthe_md'],
                'madanhhieutd' => $data[$i][$inputs['madanhhieutd']] ?? $inputs['madanhhieutd_md'],
                'ketqua' => '1',
            );
        }
        dshosothiduakhenthuong_tapthe::insert($a_dm);
        File::Delete($path);

        return redirect(static::$url . 'Sua?mahosotdkt=' . $inputs['mahosotdkt']);
    }

    function htmlTapThe(&$result, $model)
    {
        if (isset($model)) {
            $a_hinhthuckt = array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt');
            $a_danhhieutd = array_column(dmdanhhieuthidua::all()->toArray(), 'tendanhhieutd', 'madanhhieutd');
            $a_tapthe = array_column(dmnhomphanloai_chitiet::all()->toarray(), 'tenphanloai', 'maphanloai');

            $result['message'] = '<div class="row" id="dskhenthuongtapthe">';
            $result['message'] .= '<div class="col-md-12">';
            $result['message'] .= '<table id="sample_4" class="table table-striped table-bordered table-hover">';
            $result['message'] .= '<thead>';
            $result['message'] .= '<tr class="text-center">';
            $result['message'] .= '<th width="5%">STT</th>';
            $result['message'] .= '<th>Tên tập thể</th>';
            $result['message'] .= '<th>Phân loại<br>tập thể</th>';
            $result['message'] .= '<th>Hình thức<br>khen thưởng</th>';
            $result['message'] .= '<th>Danh hiệu<br>thi đua</th>';
            $result['message'] .= '<th>Kết quả<br>khen thưởng</th>';
            $result['message'] .= '<th width="15%">Thao tác</th>';
            $result['message'] .= '</tr>';
            $result['message'] .= '</thead>';
            $result['message'] .= '<tbody>';
            $i = 1;
            foreach ($model as $tt) {
                $result['message'] .= '<tr class="odd gradeX">';
                $result['message'] .= '<td class="text-center">' . $i++ . '</td>';
                $result['message'] .= '<td>' . $tt->tentapthe . '</td>';
                $result['message'] .= '<td>' . ($a_tapthe[$tt->maphanloaitapthe] ?? '') . '</td>';
                $result['message'] .= '<td class="text-center">' . ($a_hinhthuckt[$tt->mahinhthuckt] ?? '') . '</td>';
                $result['message'] .= '<td class="text-center">' . ($a_danhhieutd[$tt->madanhhieutd] ?? '') . '</td>';
                if ($tt->ketqua == '1')
                    $result['message'] .= '<td class="text-center"><button class="btn btn-sm btn-clean btn-icon">
                    <i class="icon-lg la fa-check text-primary icon-2x"></i></button></td>';
                else
                    $result['message'] .= '<td class="text-center"><button class="btn btn-sm btn-clean btn-icon">
                    <i class="icon-lg la fa-times-circle text-danger icon-2x"></i></button></td>';
                $result['message'] .= '<td class="text-center"><button title="Sửa thông tin" type="button" onclick="getTapThe(' . $tt->id . ')"  class="btn btn-sm btn-clean btn-icon"
                                                                    data-target="#modal-create-tapthe" data-toggle="modal"><i class="icon-lg la fa-edit text-primary icon-2x"></i></button>';
                $result['message'] .= '<button title="Xóa" type="button" onclick="delKhenThuong(' . $tt->id . ', &#39;/KhenThuongCongHien/HoSo/XoaTapThe&#39;, &#39;TAPTHE&#39;)" class="btn btn-sm btn-clean btn-icon" data-target="#modal-delete-khenthuong" data-toggle="modal">
                                                                    <i class="icon-lg la fa-trash text-danger icon-2x"></i></button>';

                $result['message'] .= '</td>';
                $result['message'] .= '</tr>';
            }
            $result['message'] .= '</tbody>';
            $result['message'] .= '</table>';
            $result['message'] .= '</div>';
            $result['message'] .= '</div>';

            $result['status'] = 'success';
        }
    }

    function htmlCaNhan(&$result, $model)
    {
        if (isset($model)) {
            $a_hinhthuckt = array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt');
            $a_danhhieutd = array_column(dmdanhhieuthidua::all()->toArray(), 'tendanhhieutd', 'madanhhieutd');
            $a_tapthe = array_column(dmnhomphanloai_chitiet::all()->toarray(), 'tenphanloai', 'maphanloai');

            $result['message'] = '<div class="row" id="dskhenthuongcanhan">';
            $result['message'] .= '<div class="col-md-12">';
            $result['message'] .= '<table id="sample_3" class="table table-striped table-bordered table-hover">';
            $result['message'] .= '<thead>';
            $result['message'] .= '<tr class="text-center">';
            $result['message'] .= '<th width="2%">STT</th>';
            $result['message'] .= '<th>Tên đối tượng</th>';
            $result['message'] .= '<th width="8%">Ngày sinh</th>';
            $result['message'] .= '<th width="5%">Giới</br>tính</th>';
            $result['message'] .= '<th width="15%">Phân loại cán bộ</th>';
            $result['message'] .= '<th>Thông tin công tác</th>';
            $result['message'] .= '<th>Hình thức<br>khen thưởng</th>';
            $result['message'] .= '<th>Danh hiệu<br>thi đua</th>';
            $result['message'] .= '<th>Kết quả<br>khen thưởng</th>';
            $result['message'] .= '<th width="10%">Thao tác</th>';
            $result['message'] .= '</tr>';
            $result['message'] .= '</thead>';
            $result['message'] .= '<tbody>';
            $i = 1;
            foreach ($model as $tt) {
                $result['message'] .= '<tr class="odd gradeX">';
                $result['message'] .= '<td class="text-center">' . $i++ . '</td>';
                $result['message'] .= '<td>' . $tt->tendoituong . '</td>';
                $result['message'] .= '<td class="text-center">' . getDayVn($tt->ngaysinh) . '</td>';
                $result['message'] .= '<td>' . $tt->gioitinh . '</td>';
                $result['message'] .= '<td>' . ($a_tapthe[$tt->maphanloaicanbo] ?? '') . '</td>';
                $result['message'] .= '<td class="text-center">' . $tt->chucvu . ',' . $tt->tenphongban . ',' . $tt->tencoquan . '</td>';
                $result['message'] .= '<td class="text-center"> ' . ($a_hinhthuckt[$tt->mahinhthuckt] ?? '') . '</td>';
                $result['message'] .= '<td class="text-center"> ' . ($a_danhhieutd[$tt->madanhhieutd] ?? '') . '</td>';
                if ($tt->ketqua == '1')
                    $result['message'] .= '<td class="text-center"><button class="btn btn-sm btn-clean btn-icon">
                <i class="icon-lg la fa-check text-primary icon-2x"></i></button></td>';
                else
                    $result['message'] .= '<td class="text-center"><button class="btn btn-sm btn-clean btn-icon">
                <i class="icon-lg la fa-times-circle text-danger icon-2x"></i></button></td>';
                $result['message'] .= '<td class="text-center"><button title="Sửa thông tin" type="button" onclick="getCaNhan(' . $tt->id . ')"  class="btn btn-sm btn-clean btn-icon"
                                                                    data-target="#modal-create" data-toggle="modal"><i class="icon-lg la fa-edit text-primary icon-2x"></i></button>';
                $result['message'] .= '<button title="Xóa" type="button" onclick="delKhenThuong(' . $tt->id . ', &#39;/KhenThuongCongHien/HoSo/XoaCaNhan&#39;, &#39;CANHAN&#39;)" class="btn btn-sm btn-clean btn-icon" data-target="#modal-delete-khenthuong" data-toggle="modal">
                                                                    <i class="icon-lg la fa-trash text-danger icon-2x"></i></button>';

                $result['message'] .= '</td>';
                $result['message'] .= '</tr>';
            }
            $result['message'] .= '</tbody>';
            $result['message'] .= '</table>';
            $result['message'] .= '</div>';
            $result['message'] .= '</div>';


            $result['status'] = 'success';
        }
    }

    public function TaiLieuDinhKem(Request $request)
    {
        $result = array(
            'status' => 'fail',
            'message' => 'error',
        );

        $inputs = $request->all();
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahs'])->first();
        $result['message'] = '<div class="modal-body" id = "dinh_kem" >';
        if ($model->totrinh != '') {
            $result['message'] .= '<div class="form-group row">';
            $result['message'] .= '<label class="col-3 col-form-label font-weight-bold" >Tờ trình:</label>';
            $result['message'] .= '<div class="col-9 form-control"><a target = "_blank" href = "' . url('/data/totrinh/' . $model->totrinh) . '">' . $model->totrinh . '</a ></div>';
            $result['message'] .= '</div>';
        }
        if ($model->qdkt != '') {
            $result['message'] .= '<div class="form-group row">';
            $result['message'] .= '<label class="col-3 col-form-label font-weight-bold" >Quyết định khen thưởng:</label>';
            $result['message'] .= '<div class="col-9 form-control"><a target = "_blank" href = "' . url('/data/qdkt/' . $model->qdkt) . '">' . $model->qdkt . '</a ></div>';
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
}
