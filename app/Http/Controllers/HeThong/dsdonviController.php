<?php

namespace App\Http\Controllers\HeThong;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Imports\CollectionImport;
use App\Model\DanhMuc\dscumkhoi;
use App\Model\DanhMuc\dscumkhoi_chitiet;
use App\Model\DanhMuc\dscumkhoi_qdphancumkhoi;
use App\Model\DanhMuc\dsdiaban;
use App\Model\DanhMuc\dsdonvi;
use App\Model\DanhMuc\dsnhomtaikhoan;
use App\Model\DanhMuc\dsnhomtaikhoan_phanquyen;
use App\Model\DanhMuc\dstaikhoan;
use App\Model\DanhMuc\dstaikhoan_phanquyen;
use App\Model\HeThong\hethongchung;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class dsdonviController extends Controller
{
    public static $url = '/DonVi/';
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
        if (!chkPhanQuyen('dsdonvi', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'dsdonvi');
        }
        $inputs = $request->all();
        $model = getDiaBan(session('admin')->capdo);
        $m_donvi = dsdonvi::all();
        foreach ($model as $chitiet) {
            $chitiet->sodonvi = $m_donvi->where('madiaban', $chitiet->madiaban)->count();
        }
        $thongtin_sapnhap = hethongchung::first()->sapnhap_giaodien;
        $view = $thongtin_sapnhap == 1 ? 'HeThongChung.DonVi.ThongTin' : 'HeThongChung.DonVi.ThongTin_TruocSapNhap';
        // return view('HeThongChung.DonVi.ThongTin')
        return view($view)
            ->with('model', $model)
            ->with('inputs', $inputs)
            ->with('a_donvi', array_column($m_donvi->toarray(), 'tendonvi', 'madonvi'))
            ->with('pageTitle', 'Danh sách đơn vị');
    }

    public function DanhSach(Request $request)
    {
        if (!chkPhanQuyen('dsdonvi', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'dsdonvi');
        }
        $inputs = $request->all();
        $inputs['url'] = static::$url;
        $inputs['tendiaban'] = dsdiaban::where('madiaban', $inputs['madiaban'])->first()->tendiaban ?? '';
        $m_diaban = dsdiaban::where('madiaban', $inputs['madiaban'])->first();
        $model = dsdonvi::where('madiaban', $inputs['madiaban'])->get();
        $m_taikhoan = dstaikhoan::all();
        foreach ($model as $chitiet) {
            $chitiet->sotaikhoan = $m_taikhoan->where('madonvi', $chitiet->madonvi)->count();
        }
        $a_nhomchucnang = array_column(dsnhomtaikhoan::all()->toArray(), 'tennhomchucnang', 'manhomchucnang');
        $m_cumkhoi_quyetdinh = dscumkhoi_qdphancumkhoi::all();
        $m_cumkhoi_danhsach = dscumkhoi::all();
        return view('HeThongChung.DonVi.DanhSach')
            ->with('model', $model)
            ->with('m_diaban', $m_diaban)
            ->with('a_nhomchucnang', $a_nhomchucnang)
            ->with('m_cumkhoi_quyetdinh', $m_cumkhoi_quyetdinh)
            ->with('m_cumkhoi_danhsach', $m_cumkhoi_danhsach)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Danh sách đơn vị');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (!chkPhanQuyen('dsdonvi', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dsdonvi');
        }
        $inputs = $request->all();
        //$modeldvql = DSDonVi::where('tonghop', '1')->get();
        $model = new dsdonvi();
        $model->madonvi = null;
        $model->madiaban = $inputs['madiaban'];
        return view('HeThongChung.DonVi.Sua')
            ->with('model', $model)
            ->with('pageTitle', 'Tạo mới thông tin đơn vị');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!chkPhanQuyen('dsdonvi', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dsdonvi');
        }
        $inputs = $request->all();
        $model = dsdonvi::where('madonvi', $inputs['madonvi'])->first();
        if ($model == null) {
            $inputs['madonvi'] = (string) getdate()[0];
            dsdonvi::create($inputs);
        } else {
            $model->update($inputs);
        }

        return redirect('/DonVi/DanhSach?madiaban=' . $inputs['madiaban']);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        if (!chkPhanQuyen('dsdonvi', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dsdonvi');
        }
        $inputs = $request->all();
        $model = dsdonvi::where('madonvi', $inputs['madonvi'])->first();
        return view('HeThongChung.DonVi.Sua')
            ->with('model', $model)
            ->with('pageTitle', 'Chỉnh sửa thông tin đơn vị');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if (!chkPhanQuyen('dsdonvi', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dsdonvi');
        }
        $id = $request->all()['id'];
        $model = dsdonvi::findorFail($id);
        //xoá tài khoản
        dstaikhoan::where('madonvi', $model->madonvi)->delete();
        //dd($model);
        $model->delete();
        return redirect('/DonVi/DanhSach?madiaban=' . $model->madiaban);
    }

    public function QuanLy(Request $request)
    {
        if (!chkPhanQuyen('dsdonvi', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dsdonvi');
        }
        $inputs = $request->all();
        //dd($inputs);
        $m_donvi = dsdonvi::where('madiaban', $inputs['madiaban'])->get();
        $model = dsdiaban::where('madiaban', $inputs['madiaban'])->first();
        return view('HeThongChung.DonVi.QuanLy')
            ->with('model', $model)
            ->with('a_donvi', array_column($m_donvi->toarray(), 'tendonvi', 'madonvi'))
            ->with('pageTitle', 'Tạo mới thông tin đơn vị');
    }

    public function LuuQuanLy(Request $request)
    {
        if (!chkPhanQuyen('dsdonvi', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dsdonvi');
        }
        $inputs = $request->all();
        dsdiaban::where('madiaban', $inputs['madiaban'])->first()->update($inputs);
        return redirect('DonVi/ThongTin');
    }

    public function ThongTinDonVi(Request $request)
    {
        $inputs = $request->all();
        //$m_donvi = getDonVi(session('admin')->mad, 'dsdonvi');
        //dd();
        //$a_diaban = array_column($m_donvi->toArray(), 'tendiaban', 'madiaban');
        $inputs['madonvi'] = session('admin')->madonvi;
        $model = dsdonvi::where('madonvi', $inputs['madonvi'])->first();
        $m_donvi = dsdonvi::where('madiaban', $model->madiaban)->get();
        //dd($model);
        return view('HeThongChung.DonVi.ThongTinDonVi')
            ->with('model', $model)
            ->with('m_donvi', $m_donvi)
            ->with('a_diaban', array_column(dsdiaban::where('madiaban', $model->madiaban)->get()->toArray(), 'tendiaban', 'madiaban'))
            ->with('pageTitle', 'Chỉnh sửa thông tin đơn vị');
    }

    public function LuuThongTinDonVi(Request $request)
    {

        $inputs = $request->all();
        //dd($inputs);
        $model = dsdonvi::where('madonvi', $inputs['madonvi'])->first();
        if (isset($inputs['phoi_bangkhen'])) {
            $filedk = $request->file('phoi_bangkhen');
            $inputs['phoi_bangkhen'] = $inputs['madonvi'] . '_bangkhen.' . $filedk->getClientOriginalExtension();
            $filedk->move(public_path() . '/data/uploads/', $inputs['phoi_bangkhen']);
        }
        if (isset($inputs['phoi_giaykhen'])) {
            $filedk = $request->file('phoi_giaykhen');
            $inputs['phoi_giaykhen'] = $inputs['madonvi'] . '_giaykhen.' . $filedk->getClientOriginalExtension();
            $filedk->move(public_path() . '/data/uploads/', $inputs['phoi_giaykhen']);
        }

        if ($model == null) {
            $inputs['madonvi'] = (string) getdate()[0];
            dsdonvi::create($inputs);
        } else {
            $model->update($inputs);
        }



        return redirect('/');
    }

    public function NhanExcel(Request $request)
    {
        $inputs = $request->all();
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
        //Lấy danh sách phân quyền
        $model_phanquyen = dsnhomtaikhoan_phanquyen::where('manhomchucnang', $inputs['manhomchucnang'])->get();

        // $filename = $inputs['madiaban'] . '_' . getdate()[0];
        //$model_diaban = dsdiaban::where('madiaban', $inputs['madiaban'])->first();

        // $request->file('fexcel')->move(public_path() . '/data/uploads/', $filename . '.xlsx');
        // $path = public_path() . '/data/uploads/' . $filename . '.xlsx';
        // $data = [];
        // $inputs['sheet'] = $inputs['sheet'] ?? 1;
        // $sheet = $inputs['sheet'] - 1 < 0 ? 0 : $inputs['sheet'] - 1;
        // Excel::load($path, function ($reader) use (&$data, $sheet) {
        //     $obj = $reader->getExcel();
        //     $sheet = $obj->getSheet($sheet);
        //     $data = $sheet->toArray(null, true, true, true); // giữ lại tiêu đề A=>'val';
        // });

        $dataObj = new CollectionImport();
        $theArray = Excel::toArray($dataObj, $inputs['fexcel']);
        $data = $theArray[0];
        $a_dv = array();
        $a_tk = array();
        $a_ck = [];
        $a_pq = [];
        $ma = getdate()[0];
        $ima = 1;
        $a_taikhoan = array_column(dstaikhoan::all()->toArray(), 'tendangnhap');
        //Kiểm tra dữ liệu
        $thongbao = 'Tài khoản đã có trên hệ thống: ';
        $nhandulieu = true;

        for ($i = ($inputs['tudong'] - 1); $i <= $inputs['dendong']; $i++) {
            if (!isset($data[$i][ColumnName()[$inputs['tendonvi']]])) {
                continue;
            }
            //Gán biến
            $tk = $data[$i][ColumnName()[$inputs['tendangnhap']]] ?? '';
            $matkhau = $data[$i][ColumnName()[$inputs['matkhau']]] ?? getDefaultPass();
            $madv = $ma . $ima++;

            $a_dv[] = array(
                'madiaban' => $inputs['madiaban'],
                'tendonvi' => $data[$i][ColumnName()[$inputs['tendonvi']]] ?? '',
                'madonvi' => $madv,
            );

            //Check tài khoản
            if (in_array($tk, $a_taikhoan)) {
                $thongbao .= $tk . ';';
                $nhandulieu = false;
            } else {
                $a_tk[] = array(
                    'madonvi' => $madv,
                    'manhomchucnang' => $inputs['manhomchucnang'],
                    'tentaikhoan' => $data[$i][ColumnName()[$inputs['tendonvi']]] ?? '',
                    'matkhau' => md5($matkhau),
                    'trangthai' => '1',
                    'tendangnhap' =>  $tk,
                    'gioitinh' => '1',
                );
                foreach ($model_phanquyen as $pq)
                    $a_pq[] = [
                        'tendangnhap' => $tk,
                        'machucnang' => $pq->machucnang,
                        'phanquyen' => $pq->phanquyen,
                        'danhsach' => $pq->danhsach,
                        'thaydoi' => $pq->thaydoi,
                        'hoanthanh' => $pq->hoanthanh,
                        'tiepnhan' => $pq->tiepnhan ?? 0,
                        'xuly' => $pq->xuly ?? 0,
                    ];
                if ($inputs['macumkhoi'] != 'NULL') {
                    $a_ck[] = [
                        'madonvi' => $madv,
                        'macumkhoi' => $inputs['macumkhoi'],
                        'phanloai' => 'THANHVIEN',
                    ];
                }
            }
        }

        if ($nhandulieu) {
            foreach (array_chunk($a_dv, 50) as $data) {
                dsdonvi::insert($data);
            }
            foreach (array_chunk($a_tk, 50) as $data) {
                dstaikhoan::insert($data);
            }
            foreach (array_chunk($a_pq, 50) as $data) {
                dstaikhoan_phanquyen::insert($data);
            }
            dscumkhoi_chitiet::insert($a_ck);
            // File::Delete($path);
        } else {
            return view('errors.403')
                ->with('message', $thongbao)
                ->with('url', '/DiaBan/ThongTin');
        }

        return redirect(static::$url . 'DanhSach?madiaban=' . $inputs['madiaban']);
    }
}
