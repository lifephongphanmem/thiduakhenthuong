<?php

namespace App\Http\Controllers\NghiepVu\CumKhoiThiDua;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\DanhMuc\dscumkhoi;
use App\Model\DanhMuc\dscumkhoi_chitiet;
use App\Model\DanhMuc\dscumkhoi_qdphancumkhoi;
use App\Model\DanhMuc\dsdiaban;
use App\Model\DanhMuc\dsdonvi;
use App\Model\DanhMuc\dsquyetdinhcumkhoi;
use App\Model\View\view_dscumkhoi;
use App\Model\View\viewdiabandonvi;
use Illuminate\Support\Facades\Session;

class dscumkhoiController extends Controller
{
    public static $url = '/CumKhoiThiDua/CumKhoi/';
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
        if (!chkPhanQuyen('dscumkhoithidua', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'dscumkhoithidua')->with('tenphanquyen', 'danhsach');
        }
        $inputs = $request->all();
        $inputs['url'] = static::$url;
        $inputs['maqdphancumkhoi'] = $inputs['maqdphancumkhoi'] ?? null;
        $model = dscumkhoi::where('maqdphancumkhoi', $inputs['maqdphancumkhoi'])->get();
        $m_chitiet = dscumkhoi_chitiet::all();
        foreach ($model as $ct) {
            $ct->sodonvi = $m_chitiet->where('macumkhoi', $ct->macumkhoi)->count();
        }
        //dd($inputs);
        $m_donvi = dsdonvi::all();
        return view('NghiepVu.CumKhoiThiDua.DanhSach.ThongTin')
            ->with('model', $model)
            ->with('a_donvi', array_column($m_donvi->toArray(), 'tendonvi', 'madonvi'))
            ->with('a_donviql', array_column($m_chitiet->toArray(), 'tendonvi', 'madonvi'))
            ->with('a_capdo', getPhamViApDung())
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Danh sách cụm, khối thi đua');
    }

    public function ThayDoi(Request $request)
    {
        if (!chkPhanQuyen('dscumkhoithidua', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dscumkhoithidua')->with('tenphanquyen', 'thaydoi');
        }
        $inputs = $request->all();
        //dd($inputs);
        $inputs['macumkhoi'] = $inputs['macumkhoi'] ?? null;

        $model = dscumkhoi::where('macumkhoi', $inputs['macumkhoi'])->first();
        if ($model == null) {
            $model = new dscumkhoi();
            $model->macumkhoi = getdate()[0];
            $model->maqdphancumkhoi = $inputs['maqdphancumkhoi'];
        }
        $model_chitiet = view_dscumkhoi::where('macumkhoi', $model->macumkhoi)->select('tendonvi', 'madonvi')->distinct()->get();
        $a_donviql = array_column($model_chitiet->toarray(), 'tendonvi', 'madonvi');
        $a_donvixd = getDonViXetDuyetCumKhoi();
        $a_donvikt = getDonViPheDuyetCumKhoi();

        // $m_donvi = dsdonvi::wherein('madonvi', function ($qr) {
        //     $qr->select('madonviQL')->from('dsdiaban')->get();
        // })->get();
        return view('NghiepVu.CumKhoiThiDua.DanhSach.ThayDoi')
            ->with('model', $model)
            ->with('a_donvixd', $a_donvixd)
            ->with('a_donviql', $a_donviql)
            ->with('a_donvikt', $a_donvikt)
            ->with('pageTitle', 'Thông tin cụm, khối thi đua');
    }

    public function LuuCumKhoi(Request $request)
    {
        if (!chkPhanQuyen('dscumkhoithidua', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dscumkhoithidua')->with('tenphanquyen', 'thaydoi');
        }
        $inputs = $request->all();
        //dd($inputs);
        if (isset($inputs['ipf1'])) {
            $filedk = $request->file('ipf1');
            $inputs['ipf1'] = $inputs['macumkhoi'] . '_qd.' . $filedk->getClientOriginalExtension();
            $filedk->move(public_path() . '/data/qdkt/', $inputs['ipf1']);
        }

        if (isset($inputs['ipf2'])) {
            $filedk = $request->file('ipf2');
            $inputs['ipf2'] = $inputs['macumkhoi'] . '_tailieukhac.' . $filedk->getClientOriginalExtension();
            $filedk->move(public_path() . '/data/tailieukhac/', $inputs['ipf2']);
        }
        $model = dscumkhoi::where('macumkhoi', $inputs['macumkhoi'])->first();
        if ($model == null) {
            dscumkhoi::create($inputs);
        } else {
            $model->update($inputs);
        }
        return redirect(static::$url . 'ThongTin?maqdphancumkhoi=' . $inputs['maqdphancumkhoi']);
    }

    public function Xoa(Request $request)
    {
        if (!chkPhanQuyen('dscumkhoithidua', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dscumkhoithidua')->with('tenphanquyen', 'thaydoi');
        }
        $inputs = $request->all();
        $model = dscumkhoi::findorfail($inputs['id']);
        $model->delete();
        return redirect(static::$url . 'ThongTin?maqdphancumkhoi=' . $model->maqdphancumkhoi);
    }

    public function DanhSach(Request $request)
    {
        $inputs = $request->all();
        $m_cumkhoi = dscumkhoi::where('macumkhoi', $inputs['macumkhoi'])->first();
        $model = dscumkhoi_chitiet::where('macumkhoi', $inputs['macumkhoi'])->get();
        $m_donvi = dsdonvi::wherenotin('madonvi', function ($qr) use ($m_cumkhoi) {
            $qr->select('madonvi')->from('view_dscumkhoi')->where('maqdphancumkhoi', $m_cumkhoi->maqdphancumkhoi);
        })->get();
        //dd($m_donvi);
        $a_phanloai = array_keys(getPhanLoaiDonViCumKhoi());
        $a_donvi = array_column(dsdonvi::wherein('madonvi', array_column($model->toarray(), 'madonvi'))->get()->toArray(), 'tendonvi', 'madonvi');
        //sap xep lai ket qa
        $model = $model->sortBy(function ($item) use ($a_phanloai) {
            return array_search($item['phanloai'], $a_phanloai);
        })->values();

        return view('NghiepVu.CumKhoiThiDua.DanhSach.DanhSach')
            ->with('model', $model)
            ->with('m_cumkhoi', $m_cumkhoi)
            ->with('m_donvi', $m_donvi)
            ->with('a_donvi', $a_donvi)
            ->with('a_diaban', array_column($m_donvi->toArray(), 'tendiaban', 'madiaban'))
            ->with('a_phanloai', getPhanLoaiDonViCumKhoi())
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Thông tin đơn vị trong cụm, khối thi đua');
    }

    public function ThemDonVi(Request $request)
    {
        if (!chkPhanQuyen('dscumkhoithidua', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dscumkhoithidua')->with('tenphanquyen', 'thaydoi');
        }

        $inputs = $request->all();

        $a_donvi = explode(';', $inputs['a_madonvi']);
        if (count($a_donvi) > 0) {
            $a_ketqua = [];
            foreach ($a_donvi as $donvi) {
                if ($donvi != '')
                    $a_ketqua[] = [
                        'macumkhoi' => $inputs['macumkhoi'],
                        'madonvi' => $donvi,
                        'phanloai' => 'THANHVIEN',
                    ];
            }
            dscumkhoi_chitiet::insert($a_ketqua);
        }       
        return redirect(static::$url . 'DanhSach?macumkhoi=' . $inputs['macumkhoi']);
    }

    public function SuaPhanLoai(Request $request)
    {
        if (!chkPhanQuyen('dscumkhoithidua', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dscumkhoithidua')->with('tenphanquyen', 'thaydoi');
        }

        $inputs = $request->all();       
        $model = dscumkhoi_chitiet::where('madonvi', $inputs['madonvi'])->where('macumkhoi', $inputs['macumkhoi'])->first();        
        if ($model != null) {
            $model->update($inputs);
        }
        if ($inputs['phanloai'] == "TRUONGKHOI") {
            dscumkhoi::where('macumkhoi', $inputs['macumkhoi'])->update(['madonviql' => $inputs['madonvi']]);
        }
        return redirect(static::$url . 'DanhSach?macumkhoi=' . $inputs['macumkhoi']);
    }

    public function XoaDonVi(Request $request)
    {

        if (!chkPhanQuyen('dscumkhoithidua', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dscumkhoithidua')->with('tenphanquyen', 'thaydoi');
        }
        $inputs = $request->all();
        $model = dscumkhoi_chitiet::findorfail($inputs['id']);
        $model->delete();
        return redirect(static::$url . 'DanhSach?macumkhoi=' . $model->macumkhoi);
    }

    public function TaiLieuDinhKem(Request $request)
    {
        $result = array(
            'status' => 'fail',
            'message' => 'error',
        );

        $inputs = $request->all();
        $model = dscumkhoi::where('macumkhoi', $inputs['mahs'])->first();
        $result['message'] = '<div class="modal-body" id = "dinh_kem" >';

        if ($model->ipf1 != '') {
            $result['message'] .= '<div class="form-group row">';
            $result['message'] .= '<label class="col-3 col-form-label font-weight-bold" >Quyết định:</label>';
            $result['message'] .= '<div class="col-9 form-control"><a target = "_blank" href = "' . url('/data/quyetdinh/' . $model->ipf1) . '">' . $model->ipf1 . '</a ></div>';
            $result['message'] .= '</div>';
        }

        if ($model->ipf2 != '') {
            $result['message'] .= '<div class="form-group row">';
            $result['message'] .= '<label class="col-3 col-form-label font-weight-bold" >Tài liệu khác</label>';
            $result['message'] .= '<div class="col-9 form-control"><a target = "_blank" href = "' . url('/data/tailieukhac/' . $model->ipf2) . '">' . $model->ipf2 . '</a ></div>';
            $result['message'] .= '</div>';
        }
        $result['message'] .= '</div>';
        $result['status'] = 'success';

        die(json_encode($result));
    }
}
