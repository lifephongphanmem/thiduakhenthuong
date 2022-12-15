<?php

namespace App\Http\Controllers\NghiepVu\KhenThuongDotXuat;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\NghiepVu\_DungChung\dungchung_nghiepvuController;
use App\Model\DanhMuc\dmdanhhieuthidua;
use App\Model\DanhMuc\dmdanhhieuthidua_tieuchuan;
use App\Model\DanhMuc\dmhinhthuckhenthuong;
use App\Model\DanhMuc\dmloaihinhkhenthuong;
use App\Model\DanhMuc\dmnhomphanloai_chitiet;
use App\Model\DanhMuc\dsdiaban;
use App\Model\DanhMuc\dsdonvi;
use App\Model\DanhMuc\duthaoquyetdinh;
use App\Model\HeThong\trangthaihoso;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_chitiet;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_canhan;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_hogiadinh;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_tapthe;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_tieuchuan;
use App\Model\View\viewdiabandonvi;
use Illuminate\Support\Facades\Session;

class qdhosodenghikhenthuongdotxuatController extends Controller
{
    public static $url = '';
    public function __construct()
    {
        static::$url = '/KhenThuongDotXuat/KhenThuong/';
        $this->middleware(function ($request, $next) {
            if (!Session::has('admin')) {
                return redirect('/');
            };
            return $next($request);
        });
    }
    public function ThongTin(Request $request)
    {
        if (!chkPhanQuyen('qdhosodenghikhenthuongdotxuat', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'qdhosodenghikhenthuongdotxuat')->with('tenphanquyen', 'danhsach');
        }
        $inputs = $request->all();
        $inputs['url_hs'] = '/KhenThuongDotXuat/HoSo/';
        $inputs['url_xd'] = '/KhenThuongDotXuat/XetDuyet/';
        $inputs['url_qd'] = '/KhenThuongDotXuat/KhenThuong/';
        $inputs['phanloaikhenthuong'] = 'KHENTHUONG';
        
        $m_donvi = getDonVi(session('admin')->capdo, 'qdhosodenghikhenthuongdotxuat');
        $m_diaban = dsdiaban::wherein('madiaban', array_column($m_donvi->toarray(), 'madiaban'))->get();

        // $m_donvi = viewdiabandonvi::wherein('madonvi', array_column($m_donvi->toarray(), 'madonviQL'))->get();
        $m_loaihinh = dmloaihinhkhenthuong::all();
        $inputs['nam'] = $inputs['nam'] ?? 'ALL';
        $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;
        $inputs['maloaihinhkt'] = session('chucnang')['qdhosodenghikhenthuongdotxuat']['maloaihinhkt'] ?? 'ALL';
        $inputs['tendvcqhienthi'] = $m_donvi->where('madonvi', $inputs['madonvi'])->first()->tendvcqhienthi;
        $inputs['capdo'] = $m_donvi->where('madonvi', $inputs['madonvi'])->first()->capdo;

        $model = dshosothiduakhenthuong::where('madonvi_kt', $inputs['madonvi'])
            ->wherein('phanloai', ['KHENTHUONG', 'KTNGANH'])
            ->wherein('trangthai', ['CXKT', 'DXKT', 'DKT']);

        if ($inputs['maloaihinhkt'] != 'ALL')
            $model = $model->where('maloaihinhkt', $inputs['maloaihinhkt']);

        $inputs['phanloai'] = $inputs['phanloai'] ?? 'ALL';
        if ($inputs['phanloai'] != 'ALL')
            $model = $model->where('phanloai', $inputs['phanloai']);
        $inputs['nam'] = $inputs['nam'] ?? 'ALL';
        if ($inputs['nam'] != 'ALL')
            $model = $model->whereyear('ngayhoso', $inputs['nam']);
        //Lấy hồ sơ
        $model = $model->orderby('ngayhoso')->get();

        $a_diabancumkhoi = getDiaBanCumKhoi(session('admin')->tendangnhap);
        $a_donvidiaban = array_column(viewdiabandonvi::all()->toArray(), 'madiaban', 'madonvi');
        foreach ($model as $key => $hoso) {

            if (count($a_diabancumkhoi) > 0) {
                //đơn vị => đia bàn => lọc điều kiện
                $madiaban = $a_donvidiaban[$hoso->madonvi];
                if (!in_array($madiaban, $a_diabancumkhoi))
                    $model->forget($key);
            }
            $hoso->chinhsua = $hoso->madonvi == $inputs['madonvi'] ? true : false;
            $hoso->soluongkhenthuong = dshosothiduakhenthuong_canhan::where('mahosotdkt', $hoso->mahosotdkt)->where('ketqua', '1')->count()
                + dshosothiduakhenthuong_tapthe::where('mahosotdkt', $hoso->mahosotdkt)->where('ketqua', '1')->count();
            getDonViChuyen($inputs['madonvi'], $hoso);
        }
        $inputs['trangthai'] = session('chucnang')['qdhosodenghikhenthuongdotxuat']['trangthai'] ?? 'CC';
        //dd($model);
        return view('NghiepVu.KhenThuongDotXuat.QuyetDinh.ThongTin')
            ->with('inputs', $inputs)
            ->with('model', $model)
            ->with('m_donvi', $m_donvi)
            ->with('m_diaban', $m_diaban)
            ->with('a_donvi', array_column(dsdonvi::all()->toArray(), 'tendonvi', 'madonvi'))
            ->with('a_loaihinhkt', array_column($m_loaihinh->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('a_phanloaihs', getPhanLoaiHoSo())
            //->with('a_trangthaihoso', getTrangThaiTDKT())
            //->with('a_phamvi', getPhamViPhongTrao())
            ->with('pageTitle', 'Danh sách hồ sơ trình khen thưởng đột xuất');
    }

    public function LuuHoSo(Request $request)
    {
        if (!chkPhanQuyen('qdhosodenghikhenthuongdotxuat', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'qdhosodenghikhenthuongdotxuat')->with('tenphanquyen', 'thaydoi');
        }
        $inputs = $request->all();
        $model = dshosothiduakhenthuong::where('mahosokt', $inputs['mahosokt'])->first();
        if (isset($inputs['totrinh'])) {
            $filedk = $request->file('totrinh');
            $inputs['totrinh'] = $model->mahosokt . '_' . $filedk->getClientOriginalExtension();
            $filedk->move(public_path() . '/data/totrinh/', $inputs['totrinh']);
        }
        if (isset($inputs['qdkt'])) {
            $filedk = $request->file('qdkt');
            $inputs['qdkt'] = $model->mahosokt . '_' . $filedk->getClientOriginalExtension();
            $filedk->move(public_path() . '/data/qdkt/', $inputs['qdkt']);
        }
        if (isset($inputs['bienban'])) {
            $filedk = $request->file('bienban');
            $inputs['bienban'] = $model->mahosokt . '_' . $filedk->getClientOriginalExtension();
            $filedk->move(public_path() . '/data/bienban/', $inputs['bienban']);
        }
        if (isset($inputs['tailieukhac'])) {
            $filedk = $request->file('tailieukhac');
            $inputs['tailieukhac'] = $model->mahosokt . '_' . $filedk->getClientOriginalExtension();
            $filedk->move(public_path() . '/data/tailieukhac/', $inputs['tailieukhac']);
        }
        $model->update($inputs);
        return redirect('/KhenThuongDotXuat/KhenThuong/ThongTin?madonvi=' . $model->madonvi);
    }
   
    public function PheDuyet(Request $request)
    {
        $inputs = $request->all();
        $inputs['url_hs'] = '/KhenThuongDotXuat/HoSo/';
        $inputs['url_xd'] = '/KhenThuongDotXuat/XetDuyet/';
        $inputs['url_qd'] = '/KhenThuongDotXuat/KhenThuong/';
        $inputs['url'] = '/KhenThuongDotXuat/KhenThuong/';
        //$inputs['mahinhthuckt'] = session('chucnang')['qdhosodenghikhenthuongcongtrang']['mahinhthuckt'] ?? 'ALL';
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $model_canhan = dshosothiduakhenthuong_canhan::where('mahosotdkt', $inputs['mahosotdkt'])->get();
        $model_tapthe = dshosothiduakhenthuong_tapthe::where('mahosotdkt', $inputs['mahosotdkt'])->get();
        $model_hogiadinh = dshosothiduakhenthuong_hogiadinh::where('mahosotdkt', $inputs['mahosotdkt'])->get();
        $donvi = viewdiabandonvi::where('madonvi', $model->madonvi)->first();
        $a_dhkt_canhan = getDanhHieuKhenThuong($donvi->capdo);
        $a_dhkt_tapthe = getDanhHieuKhenThuong($donvi->capdo, 'TAPTHE');
        $a_dhkt_hogiadinh = getDanhHieuKhenThuong($donvi->capdo, 'HOGIADINH');

        $model->tendonvi = $donvi->tendonvi;
        $a_tapthe = array_column(dmnhomphanloai_chitiet::wherein('manhomphanloai', ['TAPTHE'])->get()->toarray(), 'tenphanloai', 'maphanloai');
        $a_hogiadinh = array_column(dmnhomphanloai_chitiet::wherein('manhomphanloai', ['HOGIADINH'])->get()->toarray(), 'tenphanloai', 'maphanloai');
        $a_canhan = array_column(dmnhomphanloai_chitiet::wherein('manhomphanloai', ['CANHAN'])->get()->toarray(), 'tenphanloai', 'maphanloai');
                
        //Gán thông tin đơn vị khen thưởng
        $donvi_kt = viewdiabandonvi::where('madonvi', $model->madonvi_kt)->first();

        $model->capkhenthuong =  $donvi_kt->capdo;
        $model->donvikhenthuong =  $donvi_kt->tendonvi;
        $a_donvikt = array_unique(array_merge([$model->donvikhenthuong], getDonViKhenThuong()));

        return view('NghiepVu.KhenThuongDotXuat.QuyetDinh.PheDuyetKT')
            ->with('model', $model)
            ->with('model_canhan', $model_canhan)
            ->with('model_tapthe', $model_tapthe)
            ->with('model_hogiadinh', $model_hogiadinh)
            ->with('a_dhkt_canhan', $a_dhkt_canhan)
            ->with('a_donvikt', $a_donvikt)
            ->with('a_dhkt_tapthe', $a_dhkt_tapthe)
            ->with('a_dhkt_hogiadinh', $a_dhkt_hogiadinh)
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('a_donvi_kt', [$donvi_kt->madonvi => $donvi_kt->tendonvi])
            ->with('a_tapthe', $a_tapthe)
            ->with('a_canhan', $a_canhan)
            ->with('a_hogiadinh', $a_hogiadinh)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Thông tin hồ sơ đề nghị khen thưởng');
    }

    public function LuuPheDuyet(Request $request)
    {
        $inputs = $request->all();
        
        $thoigian = date('Y-m-d H:i:s');
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $model->trangthai = 'DKT';
        //gán trạng thái hồ sơ để theo dõi
        $model->trangthai_xd = $model->trangthai;
        $model->trangthai_kt = $model->trangthai;
        $model->thoigian_kt = $thoigian;

        $model->donvikhenthuong = $inputs['donvikhenthuong'];
        $model->capkhenthuong = $inputs['capkhenthuong'];
        $model->soqd = $inputs['soqd'];
        $model->ngayqd = $inputs['ngayqd'];
        $model->chucvunguoikyqd = $inputs['chucvunguoikyqd'];
        $model->hotennguoikyqd = $inputs['hotennguoikyqd'];
        //dd($model);
        getTaoQuyetDinhKT($model);
        if (isset($inputs['quyetdinh'])) {
            $filedk = $request->file('quyetdinh');
            $inputs['quyetdinh'] = $inputs['mahosotdkt'] . '_quyetdinh.' . $filedk->getClientOriginalExtension();
            $filedk->move(public_path() . '/data/quyetdinh/', $inputs['quyetdinh']);
            $model->quyetdinh = $inputs['quyetdinh'];
        }
        $model->save();
        trangthaihoso::create([
            'mahoso' => $inputs['mahosotdkt'],
            'phanloai' => 'dshosothiduakhenthuong',
            'trangthai' => $model->trangthai,
            'thoigian' => $thoigian,
            'madonvi' => $inputs['madonvi'],
            'thongtin' => 'Phê duyệt đề nghị khen thưởng.',
        ]);
        return redirect(static::$url . 'ThongTin?madonvi=' . $model->madonvi_kt);
    }

    public function HuyPheDuyet(Request $request)
    {
        if (!chkPhanQuyen('qdhosodenghikhenthuongdotxuat', 'hoanthanh')) {
            return view('errors.noperm')
                ->with('machucnang', 'qdhosodenghikhenthuongdotxuat')
                ->with('tenphanquyen', 'hoanthanh');
        }
        $inputs = $request->all();
        $thoigian = date('Y-m-d H:i:s');
        $trangthai = 'CXKT';
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $model->trangthai = $trangthai;
        $model->trangthai_xd = $model->trangthai;
        $model->trangthai_kt = $model->trangthai;
        $model->thoigian_kt = null;

        $model->donvikhenthuong = null;
        $model->capkhenthuong = null;
        $model->soqd = null;
        $model->ngayqd = null;
        $model->chucvunguoikyqd = null;
        $model->hotennguoikyqd = null;
        //dd($model);
        $model->save();
        trangthaihoso::create([
            'mahoso' => $inputs['mahosotdkt'],
            'phanloai' => 'dshosothiduakhenthuong',
            'trangthai' => $model->trangthai,
            'thoigian' => $thoigian,
            'madonvi' => $inputs['madonvi'],
            'thongtin' => 'Phê duyệt đề nghị khen thưởng.',
        ]);
        return redirect(static::$url . 'ThongTin?madonvi=' . $inputs['madonvi']);
    }

    public function TraLai(Request $request)
    {
        if (!chkPhanQuyen('qdhosodenghikhenthuongdotxuat', 'hoanthanh')) {
            return view('errors.noperm')
                ->with('machucnang', 'qdhosodenghikhenthuongdotxuat')
                ->with('tenphanquyen', 'hoanthanh');
        }
        $inputs = $request->all();
        //dd($inputs);
        $thoigian = date('Y-m-d H:i:s');
        $trangthai = 'BTLXD';
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahoso'])->first();
        $madonvi = $model->madonvi_kt;
        //setTrangThaiHoSo($inputs['madonvi'], $model, ['thoigian' => $thoigian, 'trangthai' => $trangthai, 'lydo' => $inputs['lydo']]);
        $model->trangthai = $trangthai; //gán trạng thái hồ sơ để theo dõi           
        //dd($model);
        $model->trangthai_xd = $model->trangthai;
        $model->thoigian_xd = $thoigian;
        $model->lydo_xd = $inputs['lydo'];

        $model->madonvi_nhan_xd = null;

        $model->madonvi_kt = null;
        $model->trangthai_kt = null;
        $model->thoigian_kt = null;

        $model->save();
        trangthaihoso::create([
            'mahoso' => $inputs['mahoso'],
            'phanloai' => 'dshosothiduakhenthuong',
            'trangthai' => $model->trangthai,
            'thoigian' => $thoigian,
            'madonvi' => $inputs['madonvi'],
            'thongtin' => 'Trả lại hồ sơ trình đề nghị khen thưởng.',
        ]);
        return redirect(static::$url . 'ThongTin?madonvi=' . $madonvi);
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


    public function XemQuyetDinh(Request $request)
    {

        $inputs = $request->all();
        $model = dshosothiduakhenthuong::where('mahosokt', $inputs['mahosokt'])->first();
        getTaoQuyetDinhKT($model);
        $model->thongtinquyetdinh = str_replace('<p>[sangtrangmoi]</p>', '<div class=&#34;sangtrangmoi&#34;></div>', $model->thongtinquyetdinh);
        //dd($model);
        return view('BaoCao.DonVi.XemQuyetDinh')
            ->with('model', $model)
            ->with('pageTitle', 'Quyết định khen thưởng');
    }

    public function MacDinhQuyetDinh(Request $request)
    {

        $inputs = $request->all();
        $model = dshosothiduakhenthuong::where('mahosokt', $inputs['mahosokt'])->first();
        getTaoQuyetDinhKT($model);
        //dd($model);
        return view('BaoCao.DonVi.QuyetDinh.DotXuat')
            ->with('model', $model)
            ->with('pageTitle', 'Quyết định khen thưởng đột xuất');
    }

    public function LuuQuyetDinh(Request $request)
    {

        $inputs = $request->all();
        //dd($inputs['thongtinquyetdinh']);
        $model = dshosothiduakhenthuong::where('mahosokt', $inputs['mahosokt'])->first();
        $model->thongtinquyetdinh = $inputs['thongtinquyetdinh'];
        $model->save();
        return redirect('/KhenThuongHoSoThiDua/ThongTin');
    }

    public function XemHoSo(Request $request)
    {
        $inputs = $request->all();
        $model =  dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $model_canhan = dshosothiduakhenthuong_canhan::where('mahosotdkt', $model->mahosotdkt)->get();
        $model_tapthe = dshosothiduakhenthuong_tapthe::where('mahosotdkt', $model->mahosotdkt)->get();
        $a_phanloaidt = array_column(dmnhomphanloai_chitiet::all()->toarray(), 'tenphanloai', 'maphanloai');
        $m_donvi = dsdonvi::where('madonvi', $model->madonvi)->first();
        $a_dhkt = getDanhHieuKhenThuong('ALL');


        return view('NghiepVu.KhenThuongDotXuat.QuyetDinh.Xem')
            ->with('model', $model)
            ->with('model_canhan', $model_canhan)
            ->with('model_tapthe', $model_tapthe)
            ->with('m_donvi', $m_donvi)
            ->with('a_phanloaidt', $a_phanloaidt)
            ->with('a_dhkt', $a_dhkt)
            //->with('a_danhhieu', array_column(dmdanhhieuthidua::all()->toArray(), 'tendanhhieutd', 'madanhhieutd'))
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            //->with('a_hinhthuckt', array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Thông tin hồ sơ khen thưởng');
    }

    public function InPhoi(Request $request)
    {
        $inputs = $request->all();
        $inputs['url_hs'] = '/KhenThuongDotXuat/HoSo/';
        $inputs['url_xd'] = '/KhenThuongDotXuat/XetDuyet/';
        $inputs['url_qd'] = '/KhenThuongDotXuat/KhenThuong/';
        $model =  dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $model_canhan = dshosothiduakhenthuong_canhan::where('mahosotdkt', $model->mahosotdkt)->get();
        $model_tapthe = dshosothiduakhenthuong_tapthe::where('mahosotdkt', $model->mahosotdkt)->get();
        $m_donvi = dsdonvi::where('madonvi', $model->madonvi)->first();
        $a_dhkt = getDanhHieuKhenThuong('ALL');
        $model->tendonvi = $m_donvi->tendonvi;

        return view('NghiepVu._DungChung.InPhoi')
            ->with('model', $model)
            ->with('model_canhan', $model_canhan)
            ->with('model_tapthe', $model_tapthe)
            ->with('m_donvi', $m_donvi)
            ->with('a_dhkt', $a_dhkt)
            //->with('a_danhhieu', array_column(dmdanhhieuthidua::all()->toArray(), 'tendanhhieutd', 'madanhhieutd'))
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            //->with('a_hinhthuckt', array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
            ->with('inputs', $inputs)
            ->with('pageTitle', 'In bằng khen');
    }

    public function InBangKhenCaNhan(Request $request)
    {
        $inputs = $request->all();

        $model = dshosothiduakhenthuong_canhan::where('id', $inputs['id'])->get();
        $m_hoso = dshosothiduakhenthuong::where('mahosotdkt', $model->first()->mahosotdkt)->first();
        foreach ($model as $doituong) {
            $doituong->noidungkhenthuong = catchuoi($doituong->noidungkhenthuong);
        }
        //dd($m_hoso);
        return view('BaoCao.DonVi.InBangKhenCaNhan')
            ->with('model', $model)
            ->with('m_hoso', $m_hoso)
            ->with('pageTitle', 'In bằng khen cá nhân');
    }

    public function InBangKhenTapThe(Request $request)
    {
        $inputs = $request->all();

        $model = dshosothiduakhenthuong_tapthe::where('id', $inputs['id'])->get();
        $m_hoso = dshosothiduakhenthuong::where('mahosotdkt', $model->first()->mahosotdkt)->first();
        foreach ($model as $doituong) {
            $doituong->noidungkhenthuong = catchuoi($doituong->noidungkhenthuong);
        }
        //dd($m_hoso);
        return view('BaoCao.DonVi.InBangKhenTapThe')
            ->with('model', $model)
            ->with('m_hoso', $m_hoso)
            ->with('pageTitle', 'In bằng khen tập thể');
    }

    public function InGiayKhenCaNhan(Request $request)
    {
        $inputs = $request->all();

        $model = dshosothiduakhenthuong_canhan::where('id', $inputs['id'])->get();
        $m_hoso = dshosothiduakhenthuong::where('mahosotdkt', $model->first()->mahosotdkt)->first();
        foreach ($model as $doituong) {
            $doituong->noidungkhenthuong = catchuoi($doituong->noidungkhenthuong);
        }
        //dd($m_hoso);
        return view('BaoCao.DonVi.InGiayKhenCaNhan')
            ->with('model', $model)
            ->with('m_hoso', $m_hoso)
            ->with('pageTitle', 'In bằng khen cá nhân');
    }

    public function InGiayKhenTapThe(Request $request)
    {
        $inputs = $request->all();

        $model = dshosothiduakhenthuong_tapthe::where('id', $inputs['id'])->get();
        $m_hoso = dshosothiduakhenthuong::where('mahosotdkt', $model->first()->mahosotdkt)->first();
        foreach ($model as $doituong) {
            $doituong->noidungkhenthuong = catchuoi($doituong->noidungkhenthuong);
        }
        //dd($m_hoso);
        return view('BaoCao.DonVi.InGiayKhenTapThe')
            ->with('model', $model)
            ->with('m_hoso', $m_hoso)
            ->with('pageTitle', 'In bằng khen tập thể');
    }

    public function NoiDungKhenThuong(Request $request)
    {
        $inputs = $request->all();

        if ($inputs['phanloai'] == 'CANHAN') {
            $model = dshosothiduakhenthuong_canhan::where('id', $inputs['id'])->first();
            $model->noidungkhenthuong = $inputs['noidungkhenthuong'];
            $model->save();
        } else {
            $model = dshosothiduakhenthuong_tapthe::where('id', $inputs['id'])->first();
            $model->noidungkhenthuong = $inputs['noidungkhenthuong'];
            $model->save();
        }
        //dd($m_hoso);
        return redirect(static::$url . 'InPhoi?mahosotdkt=' . $model->mahosotdkt);
    }

    public function ToTrinhPheDuyet(Request $request)
    {
        $inputs = $request->all();
        $inputs['url'] = static::$url;
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $inputs['madonvi'] = $model->madonvi;
        $inputs['maduthao'] = $inputs['maduthao'] ?? 'ALL';
        getTaoDuThaoToTrinhPheDuyet($model, $inputs['maduthao']);
        $a_duthao = array_column(duthaoquyetdinh::wherein('phanloai', ['TOTRINHHOSO'])->get()->toArray(), 'noidung', 'maduthao');

        $inputs['maduthao'] = $inputs['maduthao'] ?? array_key_first($a_duthao);
        return view('BaoCao.DonVi.QuyetDinh.MauChungToTrinhKT')
            ->with('model', $model)
            ->with('a_duthao', $a_duthao)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Dự thảo tờ trình khen thưởng');
    }

    public function LuuToTrinhPheDuyet(Request $request)
    {
        $inputs = $request->all();
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $model->thongtintotrinhdenghi = $inputs['thongtintotrinhdenghi'];
        $model->save();
        return redirect(static::$url . 'ThongTin?madonvi=' . $model->madonvi);
    }

    public function InToTrinhPheDuyet(Request $request)
    {
        $inputs = $request->all();
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        getTaoDuThaoToTrinhPheDuyet($model);
        $model->thongtinquyetdinh = $model->thongtintotrinhdenghi;
        $model->thongtinquyetdinh = str_replace('<p>[sangtrangmoi]</p>', '<div class=&#34;sangtrangmoi&#34;></div>', $model->thongtinquyetdinh);
        //dd($model);
        return view('BaoCao.DonVi.XemQuyetDinh')
            ->with('model', $model)
            ->with('pageTitle', 'Tờ trình khen thưởng');
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
            dshosothiduakhenthuong_tapthe::where('mahosotdkt', $inputs['mahosotdkt'])->update(['ketqua' => $inputs['ketqua'], 'noidungkhenthuong' => $inputs['noidungkhenthuong']]);
            $model = dshosothiduakhenthuong_tapthe::where('mahosotdkt', $inputs['mahosotdkt'])->get();
            $dungchung = new dungchung_nghiepvuController();
            $dungchung->htmlPheDuyetTapThe($result, $model);
        }
        if ($inputs['phanloai'] == 'CANHAN') {
            dshosothiduakhenthuong_canhan::where('mahosotdkt', $inputs['mahosotdkt'])->update(['ketqua' => $inputs['ketqua'], 'noidungkhenthuong' => $inputs['noidungkhenthuong']]);
            $model = dshosothiduakhenthuong_canhan::where('mahosotdkt', $inputs['mahosotdkt'])->get();
            $dungchung = new dungchung_nghiepvuController();
            $dungchung->htmlPheDuyetCaNhan($result, $model);
        }
        if ($inputs['phanloai'] == 'HOGIADINH') {
            dshosothiduakhenthuong_hogiadinh::where('mahosotdkt', $inputs['mahosotdkt'])->update(['ketqua' => $inputs['ketqua'], 'noidungkhenthuong' => $inputs['noidungkhenthuong']]);
            $model = dshosothiduakhenthuong_hogiadinh::where('mahosotdkt', $inputs['mahosotdkt'])->get();
            $dungchung = new dungchung_nghiepvuController();
            $dungchung->htmlPheDuyetHoGiaDinh($result, $model);
        }

        return response()->json($result);
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
        $dungchung = new dungchung_nghiepvuController();
        $dungchung->htmlPheDuyetCaNhan($result, $model);
        return response()->json($result);
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
        $dungchung->htmlPheDuyetTapThe($result, $danhsach);
        return response()->json($result);
        //return die(json_encode($result));
    }

    public function ThemHoGiaDinh(Request $request)
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
        $model = dshosothiduakhenthuong_hogiadinh::where('id', $inputs['id'])->first();
        unset($inputs['id']);
        if ($model == null) {
            dshosothiduakhenthuong_hogiadinh::create($inputs);
        } else
            $model->update($inputs);
        // return response()->json($inputs['id']);

        $danhsach = dshosothiduakhenthuong_hogiadinh::where('mahosotdkt', $inputs['mahosotdkt'])->get();

        $dungchung = new dungchung_nghiepvuController();
        $dungchung->htmlPheDuyetHoGiaDinh($result, $danhsach);
        return response()->json($result);
        //return die(json_encode($result));
    }
}
