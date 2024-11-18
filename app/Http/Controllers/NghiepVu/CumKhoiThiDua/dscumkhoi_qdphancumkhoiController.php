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
use App\Model\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi;
use App\Model\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi_canhan;
use App\Model\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi_hogiadinh;
use App\Model\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi_tapthe;
use App\Model\View\view_dscumkhoi;
use App\Model\View\viewdiabandonvi;
use Illuminate\Support\Facades\Session;

class dscumkhoi_qdphancumkhoiController extends Controller
{
    public static $url = '/CumKhoiThiDua/QDPhanCumKhoi/';
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
        $inputs['url_cumkhoi'] = '/CumKhoiThiDua/CumKhoi/';
        $model = dscumkhoi_qdphancumkhoi::all();
        $m_chitiet = dscumkhoi::all();
        foreach ($model as $ct) {
            $ct->sodonvi = $m_chitiet->where('maqdphancumkhoi', $ct->maqdphancumkhoi)->count();
        }
        return view('NghiepVu.CumKhoiThiDua.QDPhanCumKhoi.ThongTin')
            ->with('model', $model)
            ->with('a_capdo', getPhamViApDung())
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Danh sách quyết định phân cụm, khối thi đua');
    }


    public function ThayDoi(Request $request)
    {
        if (!chkPhanQuyen('dscumkhoithidua', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dscumkhoithidua')->with('tenphanquyen', 'thaydoi');
        }
        $inputs = $request->all();
        $inputs['maqdphancumkhoi'] = $inputs['maqdphancumkhoi'] ?? null;

        $model = dscumkhoi_qdphancumkhoi::where('maqdphancumkhoi', $inputs['maqdphancumkhoi'])->first();
        if ($model == null) {
            $model = new dscumkhoi_qdphancumkhoi();
            $model->maqdphancumkhoi = getdate()[0];
        }
       
        return view('NghiepVu.CumKhoiThiDua.QDPhanCumKhoi.ThayDoi')
            ->with('model', $model)
            ->with('pageTitle', 'Thông tin phân cụm, khối thi đua');
    }

    public function LuuCumKhoi(Request $request)
    {
        if (!chkPhanQuyen('dscumkhoithidua', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dscumkhoithidua')->with('tenphanquyen', 'thaydoi');
        }
        $inputs = $request->all();
        if (isset($inputs['ipf1'])) {
            $filedk = $request->file('ipf1');
            $inputs['ipf1'] = $inputs['macumkhoi'] . '_qd.' . $filedk->getClientOriginalExtension();
            $filedk->move(public_path() . '/data/quyetdinh/', $inputs['ipf1']);
        }

        $model = dscumkhoi_qdphancumkhoi::where('maqdphancumkhoi', $inputs['maqdphancumkhoi'])->first();
        if ($model == null) {
            dscumkhoi_qdphancumkhoi::create($inputs);
        } else {
            $model->update($inputs);
        }
        return redirect(static::$url . 'ThongTin');
    }

    public function Xoa(Request $request)
    {
        if (!chkPhanQuyen('dscumkhoithidua', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dscumkhoithidua')->with('tenphanquyen', 'thaydoi');
        }
        $inputs = $request->all();
        $model = dscumkhoi_qdphancumkhoi::findorfail($inputs['id']);
        //Xoá danh sách cụm khối
        $a_cumkhoi = array_column(dscumkhoi::where('maqdphancumkhoi', $model->maqdphancumkhoi)->get()->toarray(), 'macumkhoi');
        if (count($a_cumkhoi) > 0) {
            //Xoá hồ sơ khen thưởng
            $a_hoso = array_column(dshosotdktcumkhoi::wherein('macumkhoi', $a_cumkhoi)->get()->toarray(), 'mahosotdkt');
            if (count($a_hoso) > 0) {
                dshosotdktcumkhoi_canhan::wherein('mahosotdkt', $a_hoso)->delete();
                dshosotdktcumkhoi_tapthe::wherein('mahosotdkt', $a_hoso)->delete();
                dshosotdktcumkhoi_hogiadinh::wherein('mahosotdkt', $a_hoso)->delete();
            }

            dscumkhoi::where('maqdphancumkhoi', $model->maqdphancumkhoi)->delete();
            dscumkhoi_chitiet::wherein('macumkhoi', $a_cumkhoi)->delete();
        }
        $model->delete();
        return redirect(static::$url . 'ThongTin');
    }

    public function TaiLieuDinhKem(Request $request)
    {
        $result = array(
            'status' => 'fail',
            'message' => 'error',
        );

        $inputs = $request->all();
        $model = dscumkhoi_qdphancumkhoi::where('maqdphancumkhoi', $inputs['mahs'])->first();
        $result['message'] = '<div class="modal-body" id = "dinh_kem" >';

        if ($model->ipf1 != '') {
            $result['message'] .= '<div class="form-group row">';
            $result['message'] .= '<label class="col-3 col-form-label font-weight-bold" >Quyết định:</label>';
            $result['message'] .= '<div class="col-9 form-control"><a target = "_blank" href = "' . url('/data/quyetdinh/' . $model->ipf1) . '">' . $model->ipf1 . '</a ></div>';
            $result['message'] .= '</div>';
        }

        // if ($model->ipf2 != '') {
        //     $result['message'] .= '<div class="form-group row">';
        //     $result['message'] .= '<label class="col-3 col-form-label font-weight-bold" >Tài liệu khác</label>';
        //     $result['message'] .= '<div class="col-9 form-control"><a target = "_blank" href = "' . url('/data/tailieukhac/' . $model->ipf2) . '">' . $model->ipf2 . '</a ></div>';
        //     $result['message'] .= '</div>';
        // }
        $result['message'] .= '</div>';
        $result['status'] = 'success';

        die(json_encode($result));
    }
}
