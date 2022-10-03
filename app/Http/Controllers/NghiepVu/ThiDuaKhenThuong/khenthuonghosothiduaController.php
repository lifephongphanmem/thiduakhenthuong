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
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_chitiet;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothamgiaphongtraotd;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothamgiaphongtraotd_canhan;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothamgiaphongtraotd_tapthe;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_canhan;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_khenthuong;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_tapthe;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_tieuchuan;
use App\Model\NghiepVu\ThiDuaKhenThuong\dsphongtraothidua;
use App\Model\NghiepVu\ThiDuaKhenThuong\dsphongtraothidua_khenthuong;
use App\Model\NghiepVu\ThiDuaKhenThuong\dsphongtraothidua_tieuchuan;
use App\Model\View\view_tdkt_canhan;
use App\Model\View\view_tdkt_tapthe;
use App\Model\View\viewdiabandonvi;
use App\Model\View\viewdonvi_dsphongtrao;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class khenthuonghosothiduaController extends Controller
{
    public static $url = '';
    public function __construct()
    {
        static::$url = '/KhenThuongHoSoThiDua/';
        $this->middleware(function ($request, $next) {
            if (!Session::has('admin')) {
                return redirect('/');
            };
            return $next($request);
        });
    }

    public function ThongTin(Request $request)
    {
        if (!chkPhanQuyen('qdhosothidua', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'qdhosothidua')->with('tenphanquyen', 'danhsach');
        }

        $inputs = $request->all();
        $inputs['capdo'] = $request->all();
        $m_donvi = getDonVi(session('admin')->capdo, 'qdhosothidua', null, 'MODEL');
        $m_diaban = dsdiaban::wherein('madiaban', array_column($m_donvi->toarray(), 'madiaban'))->get();
        //$m_donvi = viewdiabandonvi::wherein('madonvi', array_column($m_donvi->toarray(), 'madonviQL'))->get();
        $inputs['nam'] = $inputs['nam'] ?? 'ALL';
        $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;
        $donvi = $m_donvi->where('madonvi', $inputs['madonvi'])->first();
        $inputs['capdo'] = $donvi->capdo;

        $a_phamvi = getPhamViApDungPhongTrao($donvi->capdo ?? 'T');
        $model = viewdonvi_dsphongtrao::wherein('phamviapdung', $a_phamvi)->orderby('tungay')->get();
        $inputs['phamviapdung'] = $inputs['phamviapdung'] ?? 'ALL';
        if ($inputs['phamviapdung'] != 'ALL') {
            $model = $model->where('phamviapdung', $inputs['phamviapdung']);
        }
        //$model = $model->where('trangthai', 'DD');
        $ngayhientai = date('Y-m-d');
        $m_hoso = dshosothamgiaphongtraotd::wherein('trangthai', ['CD', 'DD', 'CXKT'])->get();
        $m_khenthuong = dshosothiduakhenthuong::all();
        foreach ($model as $DangKy) {
            if ($DangKy->trangthai == 'CC') {
                $DangKy->nhanhoso = 'CHUABATDAU';
                if ($DangKy->tungay < $ngayhientai && $DangKy->denngay > $ngayhientai) {
                    $DangKy->nhanhoso = 'DANGNHAN';
                }
                if (strtotime($DangKy->denngay) < strtotime($ngayhientai)) {
                    $DangKy->nhanhoso = 'KETTHUC';
                    $DangKy->trangthai = 'DD';
                }
            }
            // } else {
            //     $DangKy->nhanhoso = 'KETTHUC';
            // }

            $HoSo = $m_hoso->where('maphongtraotd', $DangKy->maphongtraotd);
            $DangKy->sohoso = $HoSo == null ? 0 : $HoSo->count();
            //$khenthuong = $m_khenthuong->where('maphongtraotd', $DangKy->maphongtraotd)->where('madonvi', $inputs['madonvi'])->first();
            $khenthuong = $m_khenthuong->where('maphongtraotd', $DangKy->maphongtraotd)->first();
            $DangKy->mahosotdkt = $khenthuong->mahosotdkt ?? '-1';
        }
        //dd($model);

        return view('NghiepVu.ThiDuaKhenThuong.KhenThuongHoSo.ThongTin')
            ->with('inputs', $inputs)
            ->with('model', $model)
            ->with('m_donvi', $m_donvi)
            ->with('m_diaban', $m_diaban)
            ->with('a_trangthaihoso', getTrangThaiTDKT())
            ->with('a_phamvi', getPhamViPhongTrao())
            ->with('pageTitle', 'Danh sách hồ sơ thi đua');
    }


    public function KhenThuong(Request $request)
    {
        if (!chkPhanQuyen('qdhosothidua', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'qdhosothidua')->with('tenphanquyen', 'thaydoi');
        }
        $inputs = $request->all();
        $chk = dshosothiduakhenthuong::where('maphongtraotd', $inputs['maphongtraotd'])
            ->where('madonvi', $inputs['madonvi'])->first();
        $m_phongtrao = dsphongtraothidua::where('maphongtraotd', $inputs['maphongtraotd'])->first();
        //Lấy danh sách cán bộ đề nghị khen thưởng rồi thêm vào hosothiduakhenthuong
        //Chuyển trạng thái hồ sơ tham gia
        //chuyển trang thái phong trào

        if ($chk == null) {
            //chưa hoàn thiện
            $m_hosokt = dshosothamgiaphongtraotd::where('maphongtraotd', $inputs['maphongtraotd'])
                ->wherein('mahosothamgiapt', function ($qr) {
                    $qr->select('mahosothamgiapt')->from('dshosothamgiaphongtraotd')
                        ->where('trangthai_t', 'CXKT')
                        ->orwhere('trangthai_h', 'CXKT')->get();
                })->get();
            $inputs['mahosotdkt'] = (string)getdate()[0];
            $inputs['maloaihinhkt'] = $m_phongtrao->maloaihinhkt;

            $a_canhan = [];
            $a_tapthe = [];
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
                setTrangThaiHoSo($inputs['madonvi'], $hoso, ['madonvi' => $inputs['madonvi'], 'thoigian' => $thoigian, 'trangthai' => 'DXKT']);
                setTrangThaiHoSo($hoso->madonvi, $hoso, ['trangthai' => 'DXKT']);
                $hoso->save();
            }

            dshosothiduakhenthuong::create($inputs);
            foreach (array_chunk($a_canhan, 100) as $data) {
                dshosothiduakhenthuong_canhan::insert($data);
            }
            foreach (array_chunk($a_tapthe, 100) as $data) {
                dshosothiduakhenthuong_tapthe::insert($data);
            }
            $m_phongtrao->trangthai = 'DXKT';
            $m_phongtrao->save();
        }
        return redirect('KhenThuongHoSoThiDua/DanhSach?mahosotdkt=' . $inputs['mahosotdkt']);
    }

    public function LuuHoSo(Request $request)
    {
        if (!chkPhanQuyen('qdhosothidua', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'qdhosothidua')->with('tenphanquyen', 'thaydoi');
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
        return redirect('/KhenThuongHoSoThiDua/ThongTin?madonvi=' . $model->madonvi);
    }

    public function DanhSach(Request $request)
    {
        if (!chkPhanQuyen('qdhosothidua', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'qdhosothidua')->with('tenphanquyen', 'danhsach');
        }
        $inputs = $request->all();
        $inputs['url_hs'] = '/KhenThuongHoSoThiDua/';
        $inputs['url_qd'] = '/KhenThuongHoSoThiDua/';
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
        return view('NghiepVu.ThiDuaKhenThuong.KhenThuongHoSo.DanhSach')
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

    public function XemHoSo(Request $request)
    {
        $inputs = $request->all();
        $model =  dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $m_phongtrao = dsphongtraothidua::where('maphongtraotd', $model->maphongtraotd ?? null)->first();
        $m_khenthuong = dshosothiduakhenthuong_khenthuong::where('mahosotdkt', $model->mahosotdkt ?? null)->get();
        $m_donvi = dsdonvi::where('madonvi', $model->madonvi ?? null)->first();

        return view('NghiepVu.ThiDuaKhenThuong.KhenThuongHoSo.Xem')
            ->with('model', $model)
            ->with('m_donvi', $m_donvi)
            ->with('model_canhan', $m_khenthuong->where('phanloai', 'CANHAN'))
            ->with('model_tapthe', $m_khenthuong->where('phanloai', 'TAPTHE'))
            ->with('m_phongtrao', $m_phongtrao)
            ->with('a_donvi', array_column(viewdiabandonvi::all()->toArray(), 'tendonvi', 'madonvi'))
            ->with('a_danhhieu', array_column(dmdanhhieuthidua::all()->toArray(), 'tendanhhieutd', 'madanhhieutd'))
            ->with('a_hinhthuckt', array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Kết quả phong trào thi đua');
    }

    //bỏ
    public function HoSo(Request $request)
    {
        if (!chkPhanQuyen('qdhosothidua', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'qdhosothidua')->with('tenphanquyen', 'thaydoi');
        }
        $inputs = $request->all();
        $m_chitiet = dshosothiduakhenthuong_chitiet::where('mahosotdkt', $inputs['mahosotdkt'])->where('mahosotdkt', $inputs['mahosotdkt'])->first();
        if ($inputs['khenthuong'] == 0) {
            dshosothiduakhenthuong_khenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->where('mahosotdkt', $inputs['mahosotdkt'])->delete();
        }
        if ($inputs['khenthuong'] == 1 && $m_chitiet->ketqua == 0) {
            $m_hosotdkt = dshosothiduakhenthuong_khenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->get();
            $a_khenthuong = [];
            foreach ($m_hosotdkt as $khenthuong) {
                $a_khenthuong[] = [
                    'mahosotdkt' => $inputs['mahosotdkt'],
                    'mahosotdkt' => $inputs['mahosotdkt'],
                    'madanhhieutd' => $khenthuong->madanhhieutd,
                    'noidungkhenthuong' => '',
                    'phanloai' => $khenthuong->phanloai,
                    //Thông tin cá nhân 
                    'madoituong' => $khenthuong->madoituong,
                    'maccvc' => $khenthuong->maccvc,
                    'tendoituong' => $khenthuong->tendoituong,
                    'ngaysinh' => $khenthuong->ngaysinh,
                    'gioitinh' => $khenthuong->gioitinh,
                    'chucvu' => $khenthuong->chucvu,
                    'lanhdao' => $khenthuong->lanhdao,
                    //Thông tin tập thể
                    'matapthe' => $khenthuong->matapthe,
                    'tentapthe' => $khenthuong->tentapthe,
                    //Kết quả đánh giá
                    'ketqua' => '1',
                    'mahinhthuckt' => $khenthuong->mahinhthuckt,
                ];
            }
            //dd($a_khenthuong);
            dshosothiduakhenthuong_khenthuong::insert($a_khenthuong);
        }
        $m_chitiet->ketqua = $inputs['khenthuong'];
        $m_chitiet->save();
        //dd($inputs);
        return redirect('KhenThuongHoSoThiDua/DanhSach?mahosotdkt=' . $inputs['mahosotdkt']);
    }

    public function KetQua(Request $request)
    {
        if (!chkPhanQuyen('qdhosothidua', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'qdhosothidua')->with('tenphanquyen', 'thaydoi');
        }
        $inputs = $request->all();
        $inputs = $request->all();
        $model = dshosothiduakhenthuong_khenthuong::findorfail($inputs['id']);
        $model->ketqua = isset($inputs['dieukien']) ? 1 : 0;
        $model->mahinhthuckt = $inputs['mahinhthuckt'];
        $model->save();
        //dd($inputs);
        return redirect('/KhenThuongHoSoThiDua/DanhSach?mahosotdkt=' . $inputs['mahosotdkt']);
    }

    public function InKetQua(Request $request)
    {
        $inputs = $request->all();
        $model = dshosothiduakhenthuong_khenthuong::findorfail($inputs['id']);
        $model->tendanhhieutd = dmdanhhieuthidua::where('madanhhieutd', $model->madanhhieutd)->first()->tendanhhieutd ?? '';
        $model->tenphongtrao = dsphongtraothidua::where('maphongtraotd', $model->maphongtraotd)->first()->tenphongtrao ?? '';
        //dd($model);
        return view('BaoCao.DonVi.InBangKhen')
            ->with('model', $model)
            ->with('pageTitle', 'Danh sách hồ sơ thi đua');
    }

    public function XemQuyetDinh(Request $request)
    {
        $inputs = $request->all();
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        if ($model->thongtinquyetdinh == '') {
            $model->thongtinquyetdinh = getQuyetDinhCKE('QUYETDINH');
        }
        $model->thongtinquyetdinh = str_replace('<p>[sangtrangmoi]</p>', '<div class=&#34;sangtrangmoi&#34;></div>', $model->thongtinquyetdinh);
        $model->tendanhhieutd = dmdanhhieuthidua::where('madanhhieutd', $model->madanhhieutd)->first()->tendanhhieutd ?? '';
        $model->tenphongtrao = dsphongtraothidua::where('maphongtraotd', $model->maphongtraotd)->first()->tenphongtrao ?? '';
        //dd($model);
        return view('BaoCao.DonVi.XemQuyetDinh')
            ->with('model', $model)
            ->with('pageTitle', 'Quyết định khen thưởng');
    }

    public function PheDuyet(Request $request)
    {
        if (!chkPhanQuyen('qdhosothidua', 'hoanthanh')) {
            return view('errors.noperm')->with('machucnang', 'qdhosothidua')->with('tenphanquyen', 'hoanthanh');
        }
        $inputs = $request->all();
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();       
        $model->trangthai = 'DKT';
        dshosothamgiaphongtraotd::where('mahosotdkt', $model->mahosotdkt)->update(['trangthai' => $model->trangthai]);
        dsphongtraothidua::where('maphongtraotd', $model->maphongtraotd)->first()->update(['trangthai' => $model->trangthai]);
        $model->save();
        return redirect('/KhenThuongHoSoThiDua/ThongTin');
    }

    public function HuyPheDuyet(Request $request)
    {
        if (!chkPhanQuyen('qdhosothidua', 'hoanthanh')) {
            return view('errors.noperm')->with('machucnang', 'qdhosothidua')->with('tenphanquyen', 'hoanthanh');
        }
        $inputs = $request->all();
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $model->trangthai = 'DXKT';
        dshosothamgiaphongtraotd::where('mahosotdkt', $model->mahosotdkt)->update(['trangthai' => $model->trangthai]);
        dsphongtraothidua::where('maphongtraotd', $model->maphongtraotd)->first()->update(['trangthai' => $model->trangthai]);
        $model->save();
        return redirect('/KhenThuongHoSoThiDua/ThongTin');
    }

    public function LayTieuChuan(Request $request)
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
        //dd($request);
        $inputs = $request->all();
        //$m_danhhieu = dmdanhhieuthidua::where('madanhhieutd', $inputs['madanhhieutd'])->first();
        //Chưa tối ưu và tìm kiếm trùng đối tượng
        $m_doituong = dshosothiduakhenthuong_khenthuong::findorfail($inputs['id']);
        $m_hoso = dshosothiduakhenthuong::where('mahosotdkt', $m_doituong->mahosotdkt)->first();
        //dd($m_doituong);
        $model = dshosothiduakhenthuong_tieuchuan::where('madoituong', $m_doituong->madoituong)
            ->where('mahosotdkt', $m_doituong->mahosotdkt)->get();

        $model_tieuchuan = dsphongtraothidua_tieuchuan::where('maphongtraotd', $m_hoso->maphongtraotd)->get();

        if (isset($model_tieuchuan)) {

            $result['message'] = '<div class="row" id="dstieuchuan">';

            $result['message'] .= '<div class="col-md-12">';
            $result['message'] .= '<table id="sample_4" class="table table-striped table-bordered table-hover" >';
            $result['message'] .= '<thead>';
            $result['message'] .= '<tr>';
            $result['message'] .= '<th width="2%" style="text-align: center">STT</th>';
            $result['message'] .= '<th style="text-align: center">Tên tiêu chuẩn</th>';
            $result['message'] .= '<th style="text-align: center" width="15%">Bắt buộc</th>';
            $result['message'] .= '<th style="text-align: center" width="15%">Đạt điều kiên</th>';
            $result['message'] .= '<th style="text-align: center" width="10%">Thao tác</th>';
            $result['message'] .= '</tr>';
            $result['message'] .= '</thead>';

            $result['message'] .= '<tbody>';
            $key = 1;
            foreach ($model_tieuchuan as $ct) {
                $ct->dieukien = $model->where('matieuchuandhtd', $ct->matieuchuandhtd)->first()->dieukien ?? 0;
                $result['message'] .= '<tr>';
                $result['message'] .= '<td style="text-align: center">' . $key++ . '</td>';
                $result['message'] .= '<td>' . $ct->tentieuchuandhtd . '</td>';
                $result['message'] .= '<td style="text-align: center">' . $ct->batbuoc . '</td>';
                $result['message'] .= '<td style="text-align: center">' . $ct->dieukien . '</td>';
                $result['message'] .= '<td></td>';
                $result['message'] .= '</tr>';
            }
            $result['message'] .= '</tbody>';
            $result['message'] .= '</table>';
            $result['message'] .= '</div>';
            $result['message'] .= '</div>';
            $result['status'] = 'success';
        }
        die(json_encode($result));
    }

    public function KetThuc(Request $request)
    {
        if (!chkPhanQuyen('qdhosothidua', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'qdhosothidua')->with('tenphanquyen', 'thaydoi');
        }
        $inputs = $request->all();
        //dd($inputs);
        $model = dsphongtraothidua::where('maphongtraotd', $inputs['maphongtraotd'])->first();
        $model->trangthai = 'CXKT';
        $model->thoigian = date('Y-m-d H:i:s');
        $model->save();

        return redirect('/KhenThuongHoSoThiDua/ThongTin');
    }


    public function InBangKhen(Request $request)
    {
        $inputs = $request->all();
        $m_hoso = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();

        $m_hoso->tenphongtrao = dsphongtraothidua::where('maphongtraotd', $m_hoso->maphongtraotd)->first()->noidung;
        $m_hoso->diadanh = dsdonvi::where('madonvi', $m_hoso->madonvi)->first()->diadanh ?? '';
        if ($inputs['tendoituong'] == 'ALL') {
            $model = dshosothiduakhenthuong_khenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->where('phanloai', $inputs['phanloai'])->get();
        } else {
            $model = dshosothiduakhenthuong_khenthuong::where('id', $inputs['tendoituong'])->get();
        }
        $a_danhhieutd = array_column(dmdanhhieuthidua::all()->toArray(), 'tendanhhieutd', 'madanhhieutd');
        foreach ($model as $doituong) {
            $doituong->noidungkhenthuong = catchuoi('Đã đạt danh hiệu ' . strtolower($a_danhhieutd[$doituong->madanhhieutd] ?? '') . ' trong ' . strtolower($m_hoso->tenphongtrao));
            //dd($doituong->noidungkhenthuong);
        }
        //dd($m_hoso);
        return view('BaoCao.DonVi.InBangKhen')
            ->with('model', $model)
            ->with('m_hoso', $m_hoso)
            ->with('pageTitle', 'In bằng khen');
    }

    public function InGiayKhen(Request $request)
    {
        $inputs = $request->all();
        $m_hoso = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();

        $m_hoso->tenphongtrao = dsphongtraothidua::where('maphongtraotd', $m_hoso->maphongtraotd)->first()->noidung;
        $m_hoso->diadanh = dsdonvi::where('madonvi', $m_hoso->madonvi)->first()->diadanh ?? '';
        if ($inputs['tendoituong'] == 'ALL') {
            $model = dshosothiduakhenthuong_khenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->where('phanloai', $inputs['phanloai'])->get();
        } else {
            $model = dshosothiduakhenthuong_khenthuong::where('id', $inputs['tendoituong'])->get();
        }
        $a_danhhieutd = array_column(dmdanhhieuthidua::all()->toArray(), 'tendanhhieutd', 'madanhhieutd');
        foreach ($model as $doituong) {
            $doituong->noidungkhenthuong = catchuoi('Đã đạt danh hiệu ' . strtolower($a_danhhieutd[$doituong->madanhhieutd] ?? '') . ' trong ' . strtolower($m_hoso->tenphongtrao));
            //dd($doituong->noidungkhenthuong);
        }
        //dd($m_hoso);
        return view('BaoCao.DonVi.InGiayKhen')
            ->with('model', $model)
            ->with('m_hoso', $m_hoso)
            ->with('pageTitle', 'In giấy khen');
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

    public function LayDoiTuong(Request $request)
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
            $model = array_column(dshosothiduakhenthuong_tapthe::where('mahosotdkt', $inputs['mahosotdkt'])->get()->toarray(), 'tentapthe', 'id');
        } else {
            $model = array_column(dshosothiduakhenthuong_canhan::where('mahosotdkt', $inputs['mahosotdkt'])->get()->toarray(), 'tendoituong', 'id');
        }
        $result['message'] = '<div class="row" id="doituonginphoi">';
        $result['message'] .= '<div class="col-md-12">';
        $result['message'] .= '<label class="form-control-label">Tên đối tượng</label>';
        $result['message'] .= '<select class="form-control select2_modal" name="tendoituong">';
        $result['message'] .= '<option value="ALL">Tất cả</option>';
        foreach ($model as $key => $val) {
            $result['message'] .= '<option value="' . $key . '">' . $val . '</option>';
        }
        $result['message'] .= '</select>';
        $result['message'] .= '</div>';
        $result['message'] .= '<div>';

        $result['status'] = 'success';
        return response()->json($result);
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

    public function QuyetDinh(Request $request)
    {
        $inputs = $request->all();
        $inputs['url'] = static::$url;
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
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
        //dd($model);
        $a_duthao = array_column(duthaoquyetdinh::all()->toArray(), 'noidung', 'maduthao');
        $inputs['maduthao'] = $inputs['maduthao'] ?? array_key_first($a_duthao);
        return view('BaoCao.DonVi.QuyetDinh.CongTrang')
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
        $a_duthao = array_column(duthaoquyetdinh::all()->toArray(), 'noidung', 'maduthao');
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

        return view('BaoCao.DonVi.QuyetDinh.CongHien')
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
        return redirect(static::$url . 'ThongTin');
    }
}
