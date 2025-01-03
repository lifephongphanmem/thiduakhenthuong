<?php

namespace App\Http\Controllers\HeThong;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\DanhMuc\dsdonvi;
use App\Model\DanhMuc\dsnhomtaikhoan;
use App\Model\DanhMuc\dsnhomtaikhoan_phanquyen;
use App\Model\DanhMuc\dstaikhoan;
use App\Model\DanhMuc\dstaikhoan_phanquyen;
use App\Model\HeThong\hethongchung_chucnang;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Session;

class dsnhomtaikhoanController extends Controller
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
        if (!chkPhanQuyen('dsnhomtaikhoan', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'dsnhomtaikhoan');
        }

        $inputs = $request->all();
        $model = dsnhomtaikhoan::all();        
        $m_taikhoan = dstaikhoan::all();
        foreach ($model as $ct){
            $ct->soluong = $m_taikhoan->where('manhomchucnang', $ct->manhomchucnang)->count();
        }
        return view('HeThongChung.NhomTaiKhoan.ThongTin')
            ->with('model', $model)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Danh sách nhóm tài khoản');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!chkPhanQuyen('dsnhomtaikhoan', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dsnhomtaikhoan');
        }
        $inputs = $request->all();


        $model = dsnhomtaikhoan::where('manhomchucnang', $inputs['manhomchucnang'])->first();
        if ($model == null) {
            $inputs['manhomchucnang'] = getdate()[0];
            dsnhomtaikhoan::create($inputs);
        } else {

            $model->update($inputs);
        }

        return redirect('/NhomChucNang/ThongTin');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if (!chkPhanQuyen('dsnhomtaikhoan', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dsnhomtaikhoan');
        }
        $id = $request->all()['id'];
        $model = dsnhomtaikhoan::findorFail($id);
        $model->delete();
        return redirect('/NhomChucNang/ThongTin');
    }

    //chức năng phân quyền
    public function PhanQuyen(Request $request)
    {
        //1. Cần lọc các chức năng ko sử dụng (sudung==0) dùng hàm đệ quy để lọc từng phần
        //2. kết hợp để gán giá trị phân quyền (0;1;null) null là cho các nhóm ko có nhóm con => từ đó xác định đó là nhóm để gán cho các nhóm con
        //duyệt từng phần tử => nếu count(magoc) > 0 => nhóm có phần tử con
        //dùng biến 'phanquyen' tương tư biến "sudung" để lọc chức năng trong nhóm con
        if (!chkPhanQuyen('dsnhomtaikhoan', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dstaikhoan');
        }
        $inputs = $request->all();
        $m_nhomtaikhoan = dsnhomtaikhoan::where('manhomchucnang', $inputs['manhomchucnang'])->first();
        $m_nhomphanquyen = dsnhomtaikhoan_phanquyen::where('manhomchucnang', $inputs['manhomchucnang'])->get();
        $m_chucnang = hethongchung_chucnang::where('sudung', '1')->get();
        foreach ($m_chucnang as $chucnang) {
            $phanquyen = $m_nhomphanquyen->where('machucnang', $chucnang->machucnang)->first();
            $chucnang->phanquyen = $phanquyen->phanquyen ?? 0;
            $chucnang->danhsach = $phanquyen->danhsach ?? 0;
            $chucnang->thaydoi = $phanquyen->thaydoi ?? 0;
            $chucnang->hoanthanh = $phanquyen->hoanthanh ?? 0;
            $chucnang->nhomchucnang = $m_chucnang->where('machucnang_goc', $chucnang->machucnang)->count() > 0 ? 1 : 0;
        }
        //dd($m_chucnang);
        return view('HeThongChung.NhomTaiKhoan.PhanQuyen')
            ->with('model', $m_chucnang->where('capdo', '1')->sortby('sapxep'))
            ->with('m_chucnang', $m_chucnang)
            ->with('m_nhomtaikhoan', $m_nhomtaikhoan)
            ->with('pageTitle', 'Phân quyền tài khoản');
    }

    public function LuuPhanQuyen(Request $request)
    {
        if (!chkPhanQuyen('dsnhomtaikhoan', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dstaikhoan');
        }

        $inputs = $request->all();
        $inputs['phanquyen'] = isset($inputs['phanquyen']) ? 1 : 0;
        $inputs['danhsach'] = isset($inputs['danhsach']) ? 1 : 0;
        $inputs['thaydoi'] = isset($inputs['thaydoi']) ? 1 : 0;
        $inputs['hoanthanh'] = isset($inputs['hoanthanh']) ? 1 : 0;
        $inputs['danhsach'] = ($inputs['hoanthanh'] == 1 || $inputs['thaydoi'] == 1) ? 1 : $inputs['danhsach'];
        //dd($inputs);
        $m_chucnang = hethongchung_chucnang::where('sudung', '1')->get();
        $ketqua = new Collection();
        if (isset($inputs['nhomchucnang'])) {
            $this->getChucNang($m_chucnang, $inputs['machucnang'], $ketqua);
        }
        $ketqua->add($m_chucnang->where('machucnang', $inputs['machucnang'])->first());

        foreach ($ketqua as $ct) {
            $chk = dsnhomtaikhoan_phanquyen::where('machucnang', $ct->machucnang)->where('manhomchucnang', $inputs['manhomchucnang'])->first();
            $a_kq = [
                'machucnang' => $ct->machucnang,
                'manhomchucnang' => $inputs['manhomchucnang'],
                'phanquyen' => $inputs['phanquyen'],
                'danhsach' => $inputs['danhsach'],
                'thaydoi' => $inputs['thaydoi'],
                'hoanthanh' => $inputs['hoanthanh'],
            ];
            if ($chk == null) {
                dsnhomtaikhoan_phanquyen::create($a_kq);
            } else {
                $chk->update($a_kq);
            }
        }
        return redirect('/NhomChucNang/PhanQuyen?manhomchucnang=' . $inputs['manhomchucnang']);
    }

    function getChucNang(&$dschucnang, $machucnang_goc, &$ketqua)
    {
        foreach ($dschucnang as $key => $val) {
            if ($val->machucnang_goc == $machucnang_goc) {
                $ketqua->add($val);
                $dschucnang->forget($key);
                $this->getChucNang($dschucnang, $val->machucnang, $ketqua);
            }
        }
    }

    public function DanhSach(Request $request)
    {
        if (!chkPhanQuyen('dsnhomtaikhoan', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'dsnhomtaikhoan');
        }

        $inputs = $request->all();
        $m_nhom = dsnhomtaikhoan::where('manhomchucnang', $inputs['manhomchucnang'])->first();
        $model = dstaikhoan::where('manhomchucnang', $inputs['manhomchucnang'])->get();
        //dd($inputs);
        return view('HeThongChung.NhomTaiKhoan.DanhSach')
            ->with('model', $model)
            ->with('m_nhom', $m_nhom)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Danh sách tài khoản trong nhóm');
    }

    public function ThietLapLai(Request $request)
    {
        if (!chkPhanQuyen('dsnhomtaikhoan', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'dsnhomtaikhoan');
        }

        $inputs = $request->all();

        $model = dstaikhoan::where('manhomchucnang', $inputs['manhomchucnang'])->get();
        $model_phanquyen = dsnhomtaikhoan_phanquyen::where('manhomchucnang', $inputs['manhomchucnang'])->get();


        $a_phanquyen = [];
        foreach ($model as $taikhoan) {
            foreach ($model_phanquyen as $phanquyen) {
                $a_phanquyen[] = [
                    'tendangnhap' => $taikhoan->tendangnhap,
                    'machucnang' => $phanquyen->machucnang,
                    'phanquyen' => $phanquyen->phanquyen,
                    'danhsach' => $phanquyen->danhsach,
                    'thaydoi' => $phanquyen->thaydoi,
                    'hoanthanh' => $phanquyen->hoanthanh,
                ];
            }
        }
        
        foreach (array_chunk(array_column($model->toarray(), 'tendangnhap'), 100) as $data) {
            dstaikhoan_phanquyen::wherein('tendangnhap', $data)->delete();
        }
        foreach (array_chunk($a_phanquyen, 200) as $data) {
            dstaikhoan_phanquyen::insert($data);
        }
        return redirect('/NhomChucNang/DanhSach?manhomchucnang=' . $inputs['manhomchucnang']);
    }
}
