<?php

namespace App\Http\Controllers\NghiepVu\KhenThuongCongTrang;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\DanhMuc\dmloaihinhkhenthuong;
use App\Model\DanhMuc\dsdiaban;
use App\Model\DanhMuc\dsdonvi;
use App\Model\HeThong\trangthaihoso;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosokhenthuong;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong;
use App\Model\View\viewdiabandonvi;
use Illuminate\Support\Facades\Session;

class xdhosokhenthuongcongtrangController extends Controller
{
    public static $url = '';
    public function __construct()
    {
        static::$url = '/KhenThuongCongTrang/XetDuyet/';
        $this->middleware(function ($request, $next) {
            if (!Session::has('admin')) {
                return redirect('/');
            };
            return $next($request);
        });
    }
    public function ThongTin(Request $request)
    {
        if (!chkPhanQuyen('xdhosokhenthuongcongtrang', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'xdhosokhenthuongcongtrang')->with('tenphanquyen', 'danhsach');
        }
        $inputs = $request->all();
        $inputs['url_hs'] = '/KhenThuongCongTrang/HoSo/';
        $inputs['url_xd'] = '/KhenThuongCongTrang/XetDuyet/';
        $inputs['url_qd'] = '/KhenThuongCongTrang/KhenThuong/';
        $m_donvi = getDonVi(session('admin')->capdo, 'xdhosokhenthuongcongtrang');
        $m_diaban = dsdiaban::wherein('madiaban', array_column($m_donvi->toarray(), 'madiaban'))->get();

        $inputs['nam'] = $inputs['nam'] ?? 'ALL';
        $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;
        $inputs['maloaihinhkt'] = session('chucnang')['dshosokhenthuongcongtrang']['maloaihinhkt'] ?? 'ALL';       

        $model = dshosothiduakhenthuong::wherein('mahosotdkt', function ($qr) use ($inputs) {
            $qr->select('mahosotdkt')->from('dshosothiduakhenthuong')
                ->where('madonvi_nhan', $inputs['madonvi'])
                ->orwhere('madonvi_nhan_h', $inputs['madonvi'])
                ->orwhere('madonvi_nhan_t', $inputs['madonvi'])->get();
        })->where('maloaihinhkt', $inputs['maloaihinhkt'])->orderby('ngayhoso')->get();

        if (in_array($inputs['maloaihinhkt'], ['', 'ALL', 'all'])) {
            $m_loaihinh = dmloaihinhkhenthuong::all();
        } else {
            $m_loaihinh = dmloaihinhkhenthuong::where('maloaihinhkt', $inputs['maloaihinhkt'])->get();
        }
        foreach ($model as $hoso) {
            getDonViChuyen($inputs['madonvi'], $hoso);
        }
        //dd($model);
        //dd($inputs);
        return view('NghiepVu.KhenThuongCongTrang.XetDuyetHoSo.ThongTin')
            ->with('model', $model)
            ->with('a_donvi', array_column(dsdonvi::all()->toArray(), 'tendonvi', 'madonvi'))
            ->with('a_capdo', getPhamViApDung())
            ->with('m_donvi', $m_donvi)
            ->with('m_diaban', $m_diaban)
            ->with('a_donviql', getDonViQuanLyTinh())
            ->with('a_loaihinhkt', array_column($m_loaihinh->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Danh sách hồ sơ khen thưởng');
    }

    public function TraLai(Request $request)
    {
        if (!chkPhanQuyen('xdhosokhenthuongcongtrang', 'hoanthanh')) {
            return view('errors.noperm')->with('machucnang', 'xdhosokhenthuongcongtrang')->with('tenphanquyen', 'hoanthanh');
        }
        $inputs = $request->all();
        $thoigian = date('Y-m-d H:i:s');
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahoso'])->first();
        $m_nhatky = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahoso'])->first();
        //lấy thông tin lưu nhật ký
        getDonViChuyen($inputs['madonvi'], $m_nhatky);
        trangthaihoso::create([
            'mahoso' => $inputs['mahoso'], 'trangthai' => 'BTL',
            'thoigian' => $thoigian, 'lydo' => $inputs['lydo'],
            'madonvi_nhan' => $m_nhatky->madonvi_hoso, 'madonvi' => $m_nhatky->madonvi_nhan_hoso
        ]);
        //Gán lại trạng thái cho hồ sơ
        setNhanHoSo($inputs['madonvi'], $model, ['trangthai' => 'BTL', 'thoigian' => $thoigian, 'lydo' => $inputs['lydo'], 'madonvi_nhan' => '']);
        setTrangThaiHoSo($inputs['madonvi'], $model, ['trangthai' => '', 'thoigian' => '', 'lydo' => '', 'madonvi_nhan' => '', 'madonvi' => '']);
        $model->save();

        return redirect(static::$url.'ThongTin?madonvi=' . $inputs['madonvi']);
    }

    public function ChuyenHoSo(Request $request)
    {
        if (!chkPhanQuyen('xdhosokhenthuongconghien', 'hoanthanh')) {
            return view('errors.noperm')->with('machucnang', 'xdhosokhenthuongconghien')->with('tenphanquyen', 'hoanthanh');
        }
        $inputs = $request->all();
        //dd($inputs);
        $thoigian = date('Y-m-d H:i:s');
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahoso'])->first();
        $m_donvi = viewdiabandonvi::where('madonvi', $inputs['madonvi_nhan'])->first();
        //gán lại trạng thái hồ sơ để theo dõi
        $model->trangthai = 'CXKT';

        trangthaihoso::create([
            'mahoso' => $inputs['mahoso'], 'trangthai' => 'CXKT',
            'thoigian' => $thoigian,
            'madonvi_nhan' => $inputs['madonvi_nhan'],
            'madonvi' => $inputs['madonvi'],
            'thongtin' => 'Nhận hồ sơ và trình đề nghị khen thưởng.',
        ]);
        setTrangThaiHoSo($inputs['madonvi'], $model, ['thoigian' => $thoigian, 'trangthai' => 'CXKT']);
        setChuyenHoSo($m_donvi->capdo, $model, ['madonvi' => $inputs['madonvi_nhan'], 'thoigian' => $thoigian, 'trangthai' => 'CXKT']);
        //dd($model);
        $model->save();

        return redirect(static::$url . 'ThongTin?madonvi=' . $inputs['madonvi']);
    }
}
