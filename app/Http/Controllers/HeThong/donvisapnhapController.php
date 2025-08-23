<?php

namespace App\Http\Controllers\HeThong;

use App\Http\Controllers\Controller;
use App\Model\DanhMuc\dmloaihinhkhenthuong;
use App\Model\DanhMuc\donvisapnhap;
use App\Model\DanhMuc\dsdonvi;
use App\Model\DanhMuc\dstaikhoan;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_canhan;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_tapthe;
use App\Model\View\viewdiabandonvi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class donvisapnhapController extends Controller
{
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
        $inputs = $request->all();
        $inputs['url_hs'] = '/DonVi/SapNhap/';
        $m_donvi = getDonVi(session('admin')->capdo);
        $a_diaban = array_column($m_donvi->toArray(), 'tendiaban', 'madiaban');
        $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;
        $donvi = $m_donvi->where('madonvi', $inputs['madonvi'])->first();

        $model = donvisapnhap::where('madonvi_sapnhap', $inputs['madonvi'])->get();
        $donvi_sapnhap = donvisapnhap::pluck('madonvi_bisapnhap')->toarray();
        $a_donvi_sapnhap = array_column($m_donvi->wherenotin('madonvi', $donvi_sapnhap)->toarray(), 'tendonvi', 'madonvi');
        $a_donvi = viewdiabandonvi::pluck('tendonvi', 'madonvi')->toarray();
        return view('HeThongChung.DonVi.SapNhapDonVi.ThongTin', compact('inputs', 'm_donvi', 'a_diaban', 'a_donvi', 'a_donvi_sapnhap', 'donvi', 'model'))
            ->with('pageTitle', 'Danh sách đơn vị sáp nhập');
    }
    public function LuuSapNhap(Request $request)
    {
        $inputs = $request->all();

        $donvi = dsdonvi::select('tendonvi')->where('madonvi', $inputs['madonvi'])->first();
        $ds_bisapnhap = $inputs['madonvi_bisapnhap'] ?? [];
        //Kiểm tra xem đơn vị đã sáp nhập với đơn vị nào khác chưa
        $donvi_sapnhap = donvisapnhap::wherein('madonvi_bisapnhap', $ds_bisapnhap)->pluck('madonvi_bisapnhap')->toarray();

        if (count($ds_bisapnhap) > 0) {
            foreach ($ds_bisapnhap as $ct) {
                if (in_array($ct, $donvi_sapnhap)) {
                    continue;
                }
                $data = array(
                    'madonvi_sapnhap' => $inputs['madonvi'],
                    'madonvi_bisapnhap' => $ct,
                    'phanloai' => $inputs['phanloai'],
                    'ngaysapnhap' => $inputs['ngaysapnhap'],
                    'ghichu' => $inputs['noidung']
                );
                donvisapnhap::create($data);
            }

            //Nếu cần khóa tài khoản và donvi
            if ($inputs['khoadonvi'] == 1) {
                dsdonvi::wherein('madonvi', $ds_bisapnhap)->update(
                    [
                        'trangthai' => 'TD',
                        'ngaydung' => $inputs['ngaysapnhap'],
                        'lydo' => 'Sáp nhập với đơn vị ' . ($donvi->tendonvi ?? "")
                    ]
                );
                //dừng tài khoản
                dstaikhoan::wherein('madonvi', $ds_bisapnhap)->update([
                    'trangthai' => 0,
                    'lydo' => 'Dừng do sáp nhập vào đơn vị ' . ($donvi->tendonvi ?? ""),
                ]);
            }
        }

        return redirect('/DonVi/SapNhap/ThongTin?madonvi=' . $inputs['madonvi']);
    }

    public function Xoa(Request $request)
    {
        $inputs = $request->all();
        $model = donvisapnhap::findOrFail($inputs['id']);
        if ($model) {
            //Cập nhật lại trạng thai dsdonvi và dstaikhoan
            dsdonvi::where('madonvi', $model->madonvi_bisapnhap)->update(['trangthai' => null, 'ngaydung' => null]);
            dstaikhoan::where('madonvi', $model->madonvi_bisapnhap)->update(['trangthai' => 1, 'lydo' => null]);
            $model->delete();
        }
        return redirect('/DonVi/SapNhap/ThongTin?madonvi=' . $model->madonvi_sapnhap);
    }

    public function HoSoKT(Request $request)
    {
        $inputs = $request->all();
        $inputs['url'] = '/DonVi/SapNhap/';
        $this->getUrl($inputs['phanloai'], $inputs);
        // $inputs['url_hs'] = '/KhenThuongCongTrang/HoSoKT/';
        // $inputs['url_qd'] = '/KhenThuongCongTrang/HoSoKT/';
        $inputs['phanloaikhenthuong'] = 'KHENTHUONG';
        $inputs['phanloaihoso'] = 'dshosothiduakhenthuong';
        // $inputs['phanloai']=$inputs['phanloai']

        $donvi_sapnhap = donvisapnhap::all();
        $m_donvi = viewdiabandonvi::wherein('madonvi', array_column($donvi_sapnhap->toarray(), 'madonvi_sapnhap'))->get();
        $a_diaban = array_column($m_donvi->toArray(), 'tendiaban', 'madiaban');
        $a_donvi = array_column(dsdonvi::all()->toarray(), 'tendonvi', 'madonvi');
        $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;
        $donvi = $m_donvi->where('madonvi', $inputs['madonvi'])->first();
        $inputs['maloaihinhkt'] = session('chucnang')[$inputs['phanloai']]['maloaihinhkt'] ?? 'ALL';
        $inputs['trangthai'] = session('chucnang')[$inputs['phanloai']]['trangthai'] ?? 'CC';
        $inputs['madonvi_bisapnhap'] = $inputs['madonvi_bisapnhap'] ?? 'ALL';
        $m_donvi_sapnhap = $donvi_sapnhap->where('madonvi_sapnhap', $inputs['madonvi']);
        $a_donvi_sapnhap = viewdiabandonvi::wherein('madonvi', array_column($m_donvi_sapnhap->toarray(), 'madonvi_bisapnhap'))->get();

        // $model = dshosothiduakhenthuong::wherein('madonvi', )
        $model = dshosothiduakhenthuong::where(function ($q) use ($inputs, $a_donvi_sapnhap) {
            if ($inputs['madonvi_bisapnhap'] == 'ALL') {
                $q->wherein('madonvi', array_column($a_donvi_sapnhap->toarray(), 'madonvi'));
            } else {
                $q->where('madonvi', $inputs['madonvi_bisapnhap']);
            }
        })
            ->wherein('phanloai', ['KHENCAOTHUTUONG', 'KHENCAOCHUTICHNUOC', 'KTDONVI'])
            ->where('maloaihinhkt', $inputs['maloaihinhkt'])
            ->where('trangthai', 'DKT');

        $m_loaihinh = dmloaihinhkhenthuong::where('maloaihinhkt', $inputs['maloaihinhkt'])->first();
        $inputs['nam'] = $inputs['nam'] ?? 'ALL';
        if ($inputs['nam'] != 'ALL')
            $model = $model->whereyear('ngayhoso', $inputs['nam']);
        //Lấy hồ sơ
        $model = $model->orderby('ngayhoso')->get();
        $model_canhan = dshosothiduakhenthuong_canhan::wherein('mahosotdkt', array_column($model->toarray(), 'mahosotdkt'))->where('ketqua', '1')->get();
        $model_tapthe = dshosothiduakhenthuong_tapthe::wherein('mahosotdkt', array_column($model->toarray(), 'mahosotdkt'))->where('ketqua', '1')->get();
        foreach ($model as $hoso) {
            $hoso->soluongkhenthuong = $model_canhan->where('mahosotdkt', $hoso->mahosotdkt)->count()
                + $model_tapthe->where('mahosotdkt', $hoso->mahosotdkt)->count();
        }
        return view('HeThongChung.DonVi.SapNhapDonVi.HoSoKT', compact('m_donvi', 'a_diaban', 'donvi', 'a_donvi_sapnhap', 'a_donvi', 'inputs', 'model', 'm_loaihinh'))
            ->with('a_phanloaihs', getPhanLoaiHoSo())
            ->with('pageTitle', 'Danh sách hồ sơ khen thưởng đơn vị bị sáp nhập');
    }
    function getUrl($phanloai, &$inputs)
    {
        switch ($phanloai) {
            case 'dshosokhenthuongcongtrang': {
                    $inputs['url_hs'] = '/KhenThuongCongTrang/HoSoKT/';
                    $inputs['url_qd'] = '/KhenThuongCongTrang/HoSoKT/';
                    break;
                }
            case 'dshosokhenthuongchuyende': {
                    $inputs['url_hs'] = '/KhenThuongChuyenDe/HoSoKT/';
                    $inputs['url_qd'] = '/KhenThuongChuyenDe/HoSoKT/';
                    break;
                }
            case 'dshosokhenthuongconghien': {
                    $inputs['url_hs'] = '/KhenThuongCongHien/HoSoKT/';
                    $inputs['url_qd'] = '/KhenThuongCongHien/HoSoKT/';
                    break;
                }
            case 'dshosokhenthuongdoingoai': {
                    $inputs['url_hs'] = '/KhenThuongDoiNgoai/HoSoKT/';
                    $inputs['url_qd'] = '/KhenThuongDoiNgoai/HoSoKT/';
                    break;
                }
            case 'dshosokhenthuongdotxuat': {
                    $inputs['url_hs'] = '/KhenThuongDotXuat/HoSoKT/';
                    $inputs['url_qd'] = '/KhenThuongDotXuat/HoSoKT/';
                    break;
                }
            case 'dshosokhenthuongkhangchien': {
                    $inputs['url_hs'] = '/KhenThuongKhangChien/HoSoKT/';
                    $inputs['url_qd'] = '/KhenThuongKhangChien/HoSoKT/';
                    break;
                }
            case 'dshosokhenthuongnienhan': {
                    $inputs['url_hs'] = '/KhenThuongNienHan/HoSoKT/';
                    $inputs['url_qd'] = '/KhenThuongNienHan/HoSoKT/';
                    break;
                }
        }
    }
}
