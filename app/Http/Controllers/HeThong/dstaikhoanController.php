<?php

namespace App\Http\Controllers\HeThong;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\DanhMuc\dmhinhthuckhenthuong;
use App\Model\DanhMuc\dsdiaban;
use App\Model\DanhMuc\dsdonvi;
use App\Model\DanhMuc\dstaikhoan;
use App\Model\DanhMuc\dstaikhoan_phanquyen;
use App\Model\HeThong\hethongchung_chucnang;
use Illuminate\Support\Facades\Session;

class dstaikhoanController extends Controller
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
        $m_donvi = getDiaBan(session('admin')->capdo);
        $m_diaban = getDonVi(session('admin')->capdo);
        //dd($m_donvi);
        $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;
        $model = dstaikhoan::all();
        foreach ($m_donvi as $donvi) {
            $donvi->sotaikhoan = $model->where('madonvi', $donvi->madonvi)->count();
        }
        return view('HeThongChung.TaiKhoan.ThongTin')
            ->with('model', $model)
            ->with('m_donvi', $m_donvi)
            ->with('m_diaban', $m_diaban)
            ->with('a_nhomtk', [])
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Danh sách tài khoản');
    }

    public function DanhSach(Request $request)
    {
        $inputs = $request->all();
        $m_donvi = getDiaBan(session('admin')->capdo);
        $m_diaban = getDonVi(session('admin')->capdo);
        //dd($m_donvi);
        $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;
        $model = dstaikhoan::where('madonvi', $inputs['madonvi'])->get();
        return view('HeThongChung.TaiKhoan.DanhSach')
            ->with('model', $model)
            ->with('m_donvi', $m_donvi)
            ->with('m_diaban', $m_diaban)
            ->with('a_nhomtk', [])
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Danh sách tài khoản');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (Session::has('admin')) {
            $inputs = $request->all();
            $m_donvi = dsdonvi::all();
            $model = new dstaikhoan();
            $model->madonvi = $inputs['madonvi'];
            return view('HeThongChung.TaiKhoan.Sua')
                //->with('inputs', $inputs)
                ->with('model', $model)
                ->with('a_donvi', array_column($m_donvi->toArray(), 'tendonvi', 'madonvi'))
                ->with('pageTitle', 'Tạo mới thông tin tài khoản');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Session::has('admin')) {
            $inputs = $request->all();
            $inputs['nhaplieu'] = isset($inputs['nhaplieu']) ? 1 : 0;
            $inputs['tonghop'] = isset($inputs['tonghop']) ? 1 : 0;
            $inputs['quantri'] = isset($inputs['quantri']) ? 1 : 0;
            $inputs['tendangnhap'] = chuanhoachuoi($inputs['tendangnhap']);

            $model = dstaikhoan::where('tendangnhap', $inputs['tendangnhap'])->first();
            if ($model == null) {
                $inputs['matkhau'] = md5($inputs['matkhau']);
                dstaikhoan::create($inputs);
            } else {
                if ($inputs['matkhau'] == '')
                    unset($inputs['matkhau']);
                $model->update($inputs);
            }

            return redirect('/TaiKhoan/ThongTin?madonvi=' . $inputs['madonvi']);
        } else {
            return view('errors.notlogin');
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        if (Session::has('admin')) {
            $inputs = $request->all();
            $model = dstaikhoan::where('tendangnhap', $inputs['tendangnhap'])->first();
            $m_donvi = dsdonvi::all();
            return view('HeThongChung.TaiKhoan.Sua')
                ->with('model', $model)
                ->with('a_donvi', array_column($m_donvi->toarray(), 'tendonvi', 'madonvi'))
                ->with('pageTitle', 'Chỉnh sửa thông tin đơn vị');
        } else
            return view('errors.notlogin');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if (Session::has('admin')) {
            $id = $request->all()['id'];
            $model = dstaikhoan::findorFail($id);
            $model->delete();
            return redirect('/TaiKhoan/ThongTin');
        } else
            return view('errors.notlogin');
    }

    //chức năng phân quyền
    public function PhanQuyen(Request $request)
    {
        //1. Cần lọc các chức năng ko sử dụng (sudung==0) dùng hàm đệ quy để lọc từng phần
        //2. kết hợp để gán giá trị phân quyền (0;1;null) null là cho các nhóm ko có nhóm con => từ đó xác định đó là nhóm để gán cho các nhóm con
        //duyệt từng phần tử => nếu count(magoc) > 0 => nhóm có phần tử con
        //dùng biến 'phanquyen' tương tư biến "sudung" để lọc chức năng trong nhóm con
        if (Session::has('admin')) {
            $inputs = $request->all();
            $m_taikhoan = dstaikhoan::where('tendangnhap', $inputs['tendangnhap'])->first();
            $m_phanquyen = dstaikhoan_phanquyen::where('tendangnhap', $inputs['tendangnhap'])->get();
            $model = hethongchung_chucnang::where('capdo', '1')->get();
            $m_chucnang = hethongchung_chucnang::all();
            foreach ($m_chucnang as $chucnang) {
                $phanquyen = $m_phanquyen->where('tendangnhap', $chucnang->tendangnhap)->where('machucnang', $chucnang->machucnang)->first();
                $chucnang->phanquyen = $phanquyen->phanquyen ?? 0;
                $chucnang->danhsach = $phanquyen->danhsach ?? 0;
                $chucnang->thaydoi = $phanquyen->thaydoi ?? 0;
                $chucnang->hoanthanh = $phanquyen->hoanthanh ?? 0;
            }

            return view('HeThongChung.TaiKhoan.PhanQuyen')
                ->with('model', $model)
                ->with('m_chucnang', $m_chucnang)
                ->with('m_taikhoan', $m_taikhoan)
                ->with('pageTitle', 'Chỉnh sửa thông tin đơn vị');
        } else
            return view('errors.notlogin');
    }
}
