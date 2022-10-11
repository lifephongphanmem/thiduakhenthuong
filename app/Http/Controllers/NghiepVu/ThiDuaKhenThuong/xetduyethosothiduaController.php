<?php

namespace App\Http\Controllers\NghiepVu\ThiDuaKhenThuong;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\DanhMuc\dsdiaban;
use App\Model\HeThong\trangthaihoso;
use App\Model\NghiepVu\DangKyDanhHieu\dshosodangkyphongtraothidua;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothamgiaphongtraotd;
use App\Model\NghiepVu\ThiDuaKhenThuong\dsphongtraothidua;
use App\Model\View\viewdiabandonvi;
use App\Model\View\viewdonvi_dsphongtrao;
use Illuminate\Support\Facades\Session;

class xetduyethosothiduaController extends Controller
{
    public static $url = '';
    public function __construct()
    {
        static::$url = '/XetDuyetHoSoThiDua/';
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
        $m_donvi = getDonVi(session('admin')->capdo, 'xdhosothidua', null, 'MODEL');
        $m_diaban = dsdiaban::wherein('madiaban', array_column($m_donvi->toarray(), 'madiaban'))->get();
        $inputs['nam'] = $inputs['nam'] ?? 'ALL';
        $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;
        $donvi = $m_donvi->where('madonvi', $inputs['madonvi'])->first();
        //$a_phamvi = getPhamViApDungPhongTrao($donvi->capdo ?? 'T');
        //$model = viewdonvi_dsphongtrao::wherein('phamviapdung', $a_phamvi)->orderby('tungay')->get();
        //lấy hết phong trào cấp tỉnh
        $model = viewdonvi_dsphongtrao::wherein('phamviapdung', ['T','TW'])->orderby('tungay')->get();
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
        $m_hoso = dshosothamgiaphongtraotd::wherein('trangthai', ['CD', 'DD', 'CXKT', 'DKT'])->get();
        //$m_trangthai_phongtrao = trangthaihoso::where('phanloai', 'dsphongtraothidua')->orderby('thoigian', 'desc')->get();
        //dd($ngayhientai);
        foreach ($model as $DangKy) {
            if ($DangKy->trangthai == 'CC') {
                $DangKy->nhanhoso = 'CHUABATDAU';
                if ($DangKy->tungay < $ngayhientai && $DangKy->denngay > $ngayhientai) {
                    $DangKy->nhanhoso = 'DANGNHAN';
                }
                if (strtotime($DangKy->denngay) < strtotime($ngayhientai)) {
                    $DangKy->nhanhoso = 'KETTHUC';
                }
            } else {
                $DangKy->nhanhoso = 'KETTHUC';
            }

            $HoSo = $m_hoso->where('maphongtraotd', $DangKy->maphongtraotd);
            $DangKy->sohoso = $HoSo == null ? 0 : $HoSo->count();
        }
        //dd($m_donvi);

        return view('NghiepVu.ThiDuaKhenThuong.XetDuyetHoSo.ThongTin')
            ->with('inputs', $inputs)
            ->with('model', $model->sortby('tungay'))
            ->with('m_donvi', $m_donvi)
            ->with('m_diaban', $m_diaban)
            ->with('a_trangthaihoso', getTrangThaiTDKT())
            ->with('a_phamvi', getPhamViPhongTrao())
            ->with('pageTitle', 'Danh sách hồ sơ thi đua');
    }

    public function DanhSach(Request $request)
    {
        if (!chkPhanQuyen('xdhosothidua', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'xdhosothidua')->with('tenphanquyen', 'danhsach');
        }
        $inputs = $request->all();
        $m_dangky = dsphongtraothidua::where('maphongtraotd', $inputs['maphongtraotd'])->first();
        $donvi = viewdiabandonvi::where('madonvi', $inputs['madonvi'])->first();

        $model = dshosothamgiaphongtraotd::where('maphongtraotd', $inputs['maphongtraotd'])
            ->wherein('mahosothamgiapt', function ($qr) use ($inputs) {
                $qr->select('mahosothamgiapt')->from('dshosothamgiaphongtraotd')
                    ->where('madonvi_nhan', $inputs['madonvi'])
                    ->orwhere('madonvi_nhan_h', $inputs['madonvi'])
                    ->orwhere('madonvi_nhan_t', $inputs['madonvi'])->get();
            })->get();
        $m_hoso_dangky = dshosodangkyphongtraothidua::all();

        foreach ($model as $chitiet) {
            $chitiet->chuyentiephoso = false;
            if ($m_dangky->phamviapdung == 'TOANTINH' && $donvi->capdo == 'H')
                $chitiet->chuyentiephoso = true;
            $chitiet->mahosodk = $m_hoso_dangky->where('madonvi', $chitiet->madonvi)->first()->mahosodk ?? null;
            getDonViChuyen($inputs['madonvi'], $chitiet);
            //$chitiet->trangthai = $donvi->capdo == 'H' ? $chitiet->trangthai_h : $chitiet->trangthai_t;
        }

        //dd($model);
        $m_donvi = getDonVi(session('admin')->capdo);

        return view('NghiepVu.ThiDuaKhenThuong.XetDuyetHoSo.DanhSach')
            ->with('inputs', $inputs)
            ->with('model', $model)
            ->with('m_dangky', $m_dangky)
            ->with('a_donvi', array_column($m_donvi->toArray(), 'tendonvi', 'madonvi'))
            ->with('a_donviql', getDonViQuanLyTinh()) //chưa lọc hết (chỉ chuyển lên cấp Tỉnh)
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
    //Chưa hoàn thiện
    public function ChuyenHoSo(Request $request)
    {
        if (!chkPhanQuyen('xdhosothidua', 'hoanthanh')) {
            return view('errors.noperm')->with('machucnang', 'xdhosothidua')->with('tenphanquyen', 'hoanthanh');
        }
        $inputs = $request->all();
        //dd($inputs);
        $model = dshosothamgiaphongtraotd::where('mahosothamgiapt', $inputs['mahoso'])->first();
        $m_donvi = viewdiabandonvi::where('madonvi', $inputs['madonvi_nhan'])->first();
        $model->trangthai = 'DD';
        $model->trangthai_h = 'DD';
        $model->madonvi_nhan_h = $inputs['madonvi_nhan'];
        $model->thoigian_h = date('Y-m-d H:i:s');

        setChuyenHoSo($m_donvi->capdo, $model, ['madonvi' => $inputs['madonvi_nhan'], 'thoigian' => $model->thoigian, 'trangthai' => 'CNXKT']);
        //dd($model);
        $model->save();

        return redirect('/XetDuyetHoSoThiDua/DanhSach?maphongtraotd=' . $model->maphongtraotd . '&madonvi=' . $model->madonvi_h);
    }

    //Chưa hoàn thiện
    public function NhanHoSo(Request $request)
    {
        if (!chkPhanQuyen('xdhosothidua', 'hoanthanh')) {
            return view('errors.noperm')->with('machucnang', 'xdhosothidua')->with('tenphanquyen', 'hoanthanh');
        }
        $inputs = $request->all();
        $thoigian = date('Y-m-d H:i:s');
        $model = dshosothamgiaphongtraotd::where('mahosothamgiapt', $inputs['mahoso'])->first();
        $m_donvi = viewdiabandonvi::where('madonvi', $inputs['madonvi_nhan'])->first();
        $model->trangthai = 'CXKT';
        setNhanHoSo($inputs['madonvi_nhan'], $model, ['trangthai' => 'CXKT']);
        setChuyenHoSo($m_donvi->capdo, $model, ['madonvi' => $inputs['madonvi_nhan'], 'thoigian' => $thoigian, 'trangthai' => 'CXKT']);
        $model->save();

        return redirect('/XetDuyetHoSoThiDua/DanhSach?maphongtraotd=' . $model->maphongtraotd . '&madonvi=' . $inputs['madonvi_nhan']);
    }
}
