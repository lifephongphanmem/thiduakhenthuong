<?php

namespace App\Http\Controllers\NghiepVu\KhenThuongDotXuat;


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

class xdhosokhenthuongdotxuatController extends Controller
{
    public static $url = '';
    public function __construct()
    {
        static::$url = '/KhenThuongDotXuat/XetDuyet/';
        $this->middleware(function ($request, $next) {
            if (!Session::has('admin')) {
                return redirect('/');
            };
            return $next($request);
        });
    }
    public function ThongTin(Request $request)
    {
        if (!chkPhanQuyen('xdhosokhenthuongdotxuat', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'xdhosokhenthuongdotxuat')->with('tenphanquyen', 'danhsach');
        }
        $inputs = $request->all();
        $m_donvi = getDonVi(session('admin')->capdo, 'xdhosokhenthuongdotxuat');
        $m_diaban = dsdiaban::wherein('madiaban', array_column($m_donvi->toarray(), 'madiaban'))->get();

        //$m_donvi = viewdiabandonvi::wherein('madonvi', array_column($m_donvi->toarray(), 'madonviQL'))->get();
        $m_loaihinh = dmloaihinhkhenthuong::all();
        $inputs['nam'] = $inputs['nam'] ?? 'ALL';
        $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;
        $donvi = $m_donvi->where('madonvi', $inputs['madonvi'])->first();
        //$capdo = $donvi->capdo ?? '';
        $inputs['maloaihinhkt'] = $inputs['maloaihinhkt'] ?? 'ALL';

        $model = dshosothiduakhenthuong::wherein('mahosotdkt', function ($qr) use ($inputs) {
            $qr->select('mahosotdkt')->from('dshosothiduakhenthuong')
                ->where('madonvi_nhan', $inputs['madonvi'])
                ->orwhere('madonvi_nhan_h', $inputs['madonvi'])
                ->orwhere('madonvi_nhan_t', $inputs['madonvi'])->get();
        })->where('phanloai', 'DOTXUAT');

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

        //$m_khenthuong = dshosokhenthuong::wherein('mahosotdkt', array_column($model->toarray(), 'mahosotdkt'))->where('trangthai', 'DKT')->get();
        foreach ($model as $hoso) {
            //$model->mahosokt = $m_khenthuong->where('mahosotdkt', $hoso->mahosotdkt)->first()->mahosokt ?? null;
            getDonViChuyen($inputs['madonvi'], $hoso);
        }

        return view('NghiepVu.KhenThuongDotXuat.XetDuyet.ThongTin')
            ->with('model', $model)
            ->with('a_donvi', array_column(dsdonvi::all()->toArray(), 'tendonvi', 'madonvi'))
            ->with('a_capdo', getPhamViApDung())
            ->with('m_donvi', $m_donvi)
            ->with('m_diaban', $m_diaban)
            ->with('a_donviql', getDonViQuanLyDiaBan($donvi))
            ->with('a_phanloaihs', getPhanLoaiHoSo())
            ->with('a_loaihinhkt', array_column($m_loaihinh->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Danh sách hồ sơ khen thưởng');
    }

    public function TraLai(Request $request)
    {
        if (!chkPhanQuyen('xdhosokhenthuongdotxuat', 'hoanthanh')) {
            return view('errors.noperm')->with('machucnang', 'xdhosokhenthuongdotxuat')->with('tenphanquyen', 'hoanthanh');
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
        setTraLaiHoSo_Nhan($inputs['madonvi'], $model, ['trangthai' => '', 'thoigian' => '', 'lydo' => '', 'madonvi_nhan' => '', 'madonvi' => '']);
        //dd($model);
        $model->save();

        return redirect('/KhenThuongDotXuat/XetDuyet/ThongTin?madonvi=' . $inputs['madonvi']);
    }

    public function ChuyenHoSo(Request $request)
    {
        if (!chkPhanQuyen('xdhosokhenthuongdotxuat', 'hoanthanh')) {
            return view('errors.noperm')->with('machucnang', 'xdhosokhenthuongdotxuat')->with('tenphanquyen', 'hoanthanh');
        }
        $inputs = $request->all();

        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahoso'])->first();
        $m_donvi = viewdiabandonvi::where('madonvi', $inputs['madonvi_nhan'])->first();
        $model->trangthai_h = 'DD';
        $model->madonvi_nhan_h = $inputs['madonvi_nhan'];
        $model->thoigian_h = date('Y-m-d H:i:s');

        setChuyenHoSo($m_donvi->capdo, $model, ['madonvi' => $inputs['madonvi_nhan'], 'thoigian' => $model->thoigian, 'trangthai' => 'CNXKT']);
        //dd($model);
        $model->save();

        return redirect('/KhenThuongDotXuat/XetDuyet/ThongTin?madonvi=' . $model->madonvi_h);
    }

    //Chưa hoàn thiện
    public function NhanHoSo(Request $request)
    {
        if (!chkPhanQuyen('xdhosokhenthuongdotxuat', 'hoanthanh')) {
            return view('errors.noperm')->with('machucnang', 'xdhosokhenthuongdotxuat')->with('tenphanquyen', 'hoanthanh');
        }
        $inputs = $request->all();
        $thoigian = date('Y-m-d H:i:s');
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahoso'])->first();
        $m_donvi = viewdiabandonvi::where('madonvi', $inputs['madonvi_nhan'])->first();

        setNhanHoSo($inputs['madonvi_nhan'], $model, ['madonvi' => $inputs['madonvi_nhan'], 'thoigian' => $thoigian, 'trangthai' => 'CXKT']);
        setChuyenHoSo($m_donvi->capdo, $model, ['madonvi' => $inputs['madonvi_nhan'], 'thoigian' => $thoigian, 'trangthai' => 'CXKT']);
        //dd($model);
        $model->save();

        return redirect('/KhenThuongDotXuat/XetDuyet/ThongTin?madonvi=' . $inputs['madonvi_nhan']);
    }
}
