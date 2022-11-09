<?php

namespace App\Http\Controllers\HeThong;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\DanhMuc\dsdiaban;
use App\Model\DanhMuc\dsdonvi;
use App\Model\DanhMuc\dsnhomtaikhoan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class dsdiabanController extends Controller
{
    public static $url = '/DiaBan/';
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Session::has('admin')) {
                return redirect('/');
            };
            return $next($request);
        });
    }
    public function index(Request $request)
    {
        if (!chkPhanQuyen('dsdiaban', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'dsdiaban');
        }
        $inputs = $request->all();
        $inputs['url'] = static::$url;
        $model = getDiaBan(session('admin')->capdo); //1649996519
        //dd($model->where('madiabanQL', '1649996519')->toarray());
        $m_donvi = dsdonvi::all();
        foreach ($model as $chitiet) {
            $chitiet->sodonvi = $m_donvi->where('madiaban', $chitiet->madiaban)->count();
        }
        $a_donvi = array_column($m_donvi->toarray(), 'tendonvi', 'madonvi');
        $a_nhomchucnang = array_column(dsnhomtaikhoan::all()->toArray(), 'tennhomchucnang', 'manhomchucnang');
        return view('HeThongChung.DiaBan.ThongTin')
            ->with('model', $model)
            ->with('inputs', $inputs)
            ->with('a_phanloai', getPhanLoaiDonVi_DiaBan())
            ->with('a_diaban', getDiaBan_All(true))
            ->with('a_donvi', $a_donvi)
            ->with('a_nhomchucnang', $a_nhomchucnang)
            ->with('pageTitle', 'Danh sách địa bàn');
    }

    public function modify(Request $request)
    {
        //tài khoản SSA; tài khoản quản trị + có phân quyền
        if (!chkPhanQuyen('dsdiaban', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dsdiaban');
        }

        $inputs = $request->all();
        $model = dsdiaban::where('madiaban', $inputs['madiaban'])->first();

        if ($model == null) {
            $inputs['madiaban'] = getdate()[0];
            dsdiaban::create($inputs);
        } else {
            $model->tendiaban = $inputs['tendiaban'];
            $model->capdo = $inputs['capdo'];
            $model->madonviQL = $inputs['madonviQL'];
            $model->madonviKT = $inputs['madonviKT'];
            $model->madiabanQL = $inputs['madiabanQL'] ?? null;
            $model->save();
        }
        return redirect('/DiaBan/ThongTin');
    }

    public function delete(Request $request)
    {
        //tài khoản SSA; tài khoản quản trị + có phân quyền
        if (!chkPhanQuyen('dsdiaban', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dsdiaban');
        }
        $inputs = $request->all();

        $model = dsdiaban::findorfail($inputs['id']);
        $chk_db = dsdiaban::where('madiabanQL', $model->madiaban)->count();
        $chk_dv = dsdonvi::where('madiaban', $model->madiaban)->count();
        if ($chk_db == 0 && $chk_dv == 0) {
            $model->delete();
        } else {
            return view('errors.403')
                ->with('message', 'Bạn cần xóa hết địa bàn trực thuộc và các đơn vị trong địa bàn.')
                ->with('url', '/DiaBan/ThongTin');
        }

        return redirect('/DiaBan/ThongTin');
    }

    public function LayDonVi(Request $request)
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

        $model = array_column(dsdonvi::where('madiaban', $inputs['madiaban'])->get()->toarray(), 'tendonvi', 'madonvi');
        $result['message'] = '<div id="donviql" class="form-group row">';
        $result['message'] .= '<div class="col-6">';
        $result['message'] .= '<label class="form-control-label">Đơn vị phê duyệt khen thưởng</label>';
        $result['message'] .= '<select class="form-control select2_modal" name="madonviQL">';
        foreach ($model as $key => $val) {
            $result['message'] .= '<option value="' . $key . '">' . $val . '</option>';
        }
        $result['message'] .= '</select>';
        $result['message'] .= '</div>';

        $result['message'] .= '<div class="col-6">';
        $result['message'] .= '<label class="form-control-label">Đơn vị xét duyệt hồ sơ</label>';
        $result['message'] .= '<select class="form-control select2_modal" name="madonviKT">';
        foreach ($model as $key => $val) {
            $result['message'] .= '<option value="' . $key . '">' . $val . '</option>';
        }
        $result['message'] .= '</select>';
        $result['message'] .= '</div>';
        $result['message'] .= '<div>';

        $result['status'] = 'success';
        return response()->json($result);
    }

    public function NhanExcel(Request $request)
    {
        $inputs = $request->all();
        //dd($inputs);
        if (!isset($inputs['manhomchucnang'])) {
            return view('errors.403')
                ->with('message', 'Bạn cần tạo nhóm chức năng trước khi nhận dữ liệu để phân quyền thuận tiện hơn.')
                ->with('url', '/DiaBan/ThongTin');
        }

        if (!isset($inputs['fexcel'])) {
            return view('errors.403')
                ->with('message', 'File Excel không hợp lệ.')
                ->with('url', '/DiaBan/ThongTin');
        }
        //$model = dshosotdktcumkhoi::where('mahosotdkt', $inputs['mahosotdkt'])->first();

        $filename = $inputs['madiaban'] . '_' . getdate()[0];
        $model_diaban = dsdiaban::where('madiaban', $inputs['madiaban'])->first();

        $request->file('fexcel')->move(public_path() . '/data/uploads/', $filename . '.xlsx');
        $path = public_path() . '/data/uploads/' . $filename . '.xlsx';
        $data = [];

        Excel::load($path, function ($reader) use (&$data, $inputs, $path) {
            $obj = $reader->getExcel();
            $sheetCount = $obj->getSheetCount();
            if ($sheetCount < chkDbl($inputs['sheet'])) {
                File::Delete($path);
                dd('File excel chỉ có tối đa ' . $sheetCount . ' sheet dữ liệu.');
            }
            $sheet = $obj->getSheet($inputs['sheet']);
            $data = $sheet->toArray(null, true, true, true); // giữ lại tiêu đề A=>'val';
        });
        $a_dm = array();
        $ma=getdate()[0];
        for ($i = $inputs['tudong']; $i <= $inputs['dendong']; $i++) {
            if (!isset($data[$i][$inputs['tendiaban']])) {
                continue;
            }
            $a_dm[] = array(
                'madiabanQL' => $inputs['madiaban'],
                'tendiaban' => $data[$i][$inputs['tendiaban']] ?? '',
                'tendangnhap' => $data[$i][$inputs['tendangnhap']] ?? '',
                'madiabanQL' => $ma++,
            );
        }
        File::Delete($path);
        dd($a_dm);
        //dsdiaban::insert($a_dm);
        File::Delete($path);

        return redirect(static::$url . 'Sua?mahosotdkt=' . $inputs['mahosotdkt']);
    }
}
