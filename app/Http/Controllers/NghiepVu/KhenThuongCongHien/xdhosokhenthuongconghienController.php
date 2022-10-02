<?php

namespace App\Http\Controllers\NghiepVu\KhenThuongCongHien;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\DanhMuc\dmloaihinhkhenthuong;
use App\Model\DanhMuc\dsdiaban;
use App\Model\DanhMuc\dsdonvi;
use App\Model\HeThong\trangthaihoso;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong;
use App\Model\View\viewdiabandonvi;
use Illuminate\Support\Facades\Session;

class xdhosokhenthuongconghienController extends Controller
{
    public static $url = '';
    public function __construct()
    {
        static::$url = '/KhenThuongCongHien/XetDuyet/';
        $this->middleware(function ($request, $next) {
            if (!Session::has('admin')) {
                return redirect('/');
            };
            return $next($request);
        });
    }

    public function ThongTin(Request $request)
    {
        if (!chkPhanQuyen('xdhosokhenthuongconghien', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'xdhosokhenthuongconghien')->with('tenphanquyen', 'danhsach');
        }

        $inputs = $request->all();
        $inputs['url'] = static::$url;
        $inputs['url_hs'] = '/KhenThuongCongHien/HoSo/';
        $inputs['url_kt'] = '/KhenThuongCongHien/KhenThuong/';
        $m_donvi = getDonVi(session('admin')->capdo, 'xdhosokhenthuongconghien');
        $m_diaban = dsdiaban::wherein('madiaban', array_column($m_donvi->toarray(), 'madiaban'))->get();

        $inputs['nam'] = $inputs['nam'] ?? 'ALL';
        $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;
        //$donvi = $m_donvi->where('madonvi', $inputs['madonvi'])->first();
        //$capdo = $donvi->capdo ?? '';
        //$inputs['maloaihinhkt'] = $inputs['maloaihinhkt'] ?? 'ALL';
        $inputs['maloaihinhkt'] = session('chucnang')['dshosokhenthuongconghien']['maloaihinhkt'] ?? 'ALL';

        $model = dshosothiduakhenthuong::wherein('mahosotdkt', function ($qr) use ($inputs) {
            $qr->select('mahosotdkt')->from('dshosothiduakhenthuong')
                ->where('madonvi_nhan', $inputs['madonvi'])
                ->orwhere('madonvi_nhan_h', $inputs['madonvi'])
                ->orwhere('madonvi_nhan_t', $inputs['madonvi'])->get();
        })->where('phanloai', 'KHENTHUONG');

        if ($inputs['maloaihinhkt'] != 'ALL')
            $model = $model->where('maloaihinhkt', $inputs['maloaihinhkt']);

        $model = $model->orderby('ngayhoso')->get();

        // $m_khenthuong = dshosokhenthuong::wherein('mahosotdkt', array_column($model->toarray(), 'mahosotdkt'))->where('trangthai', 'DKT')->get();
        foreach ($model as $hoso) {
            //$model->mahosokt = $m_khenthuong->where('mahosotdkt', $hoso->mahosotdkt)->first()->mahosokt ?? null;
            getDonViChuyen($inputs['madonvi'], $hoso);
        }
        if (in_array($inputs['maloaihinhkt'], ['', 'ALL', 'all'])) {
            $m_loaihinh = dmloaihinhkhenthuong::all();
        } else {
            $m_loaihinh = dmloaihinhkhenthuong::where('maloaihinhkt', $inputs['maloaihinhkt'])->get();
        }
        return view('NghiepVu.KhenThuongCongHien.XetDuyet.ThongTin')
            ->with('model', $model)
            ->with('a_donvi', array_column(dsdonvi::all()->toArray(), 'tendonvi', 'madonvi'))
            ->with('a_capdo', getPhamViApDung())
            ->with('m_donvi', $m_donvi)
            ->with('m_diaban', $m_diaban)
            ->with('a_donviql', getDonViQuanLyTinh())
            ->with('a_loaihinhkt', array_column($m_loaihinh->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Danh sách hồ sơ khen thưởng theo cống hiến');
    }

    public function TraLai(Request $request)
    {
        if (!chkPhanQuyen('xdhosokhenthuongconghien', 'hoanthanh')) {
            return view('errors.noperm')->with('machucnang', 'xdhosokhenthuongconghien')->with('tenphanquyen', 'hoanthanh');
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
            'madonvi_nhan' => $m_nhatky->madonvi_hoso,
            'madonvi' => $m_nhatky->madonvi_nhan_hoso,
            'thongtin' => 'Trả lại hồ sơ đề nghị khen thưởng.',
        ]);
        //Gán lại trạng thái cho hồ sơ
        setNhanHoSo($inputs['madonvi'], $model, ['trangthai' => 'BTL', 'thoigian' => $thoigian, 'lydo' => $inputs['lydo'], 'madonvi_nhan' => '']);
        setTrangThaiHoSo($inputs['madonvi'], $model, ['trangthai' => '', 'thoigian' => '', 'lydo' => '', 'madonvi_nhan' => '', 'madonvi' => '']);
        //dd($model);
        $model->save();

        return redirect(static::$url . 'ThongTin?madonvi=' . $inputs['madonvi']);
    }

    public function ChuyenHoSo(Request $request)
    {
        if (!chkPhanQuyen('xdhosokhenthuongconghien', 'hoanthanh')) {
            return view('errors.noperm')->with('machucnang', 'xdhosokhenthuongconghien')->with('tenphanquyen', 'hoanthanh');
        }
        $inputs = $request->all();
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

        return redirect(static::$url . 'ThongTin?madonvi=' . $model->madonvi_h);
    }
}
