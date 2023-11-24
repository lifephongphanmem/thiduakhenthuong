<?php

namespace App\Http\Controllers\NghiepVu\KhenCao;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\NghiepVu\_DungChung\dungchung_nghiepvuController;
use App\Http\Controllers\NghiepVu\_DungChung\dungchung_nhanexcelController;
use App\Model\DanhMuc\dmdanhhieuthidua_tieuchuan;
use App\Model\DanhMuc\dmloaihinhkhenthuong;
use App\Model\DanhMuc\dmnhomphanloai_chitiet;
use App\Model\DanhMuc\dsdiaban;
use App\Model\DanhMuc\dsdonvi;
use App\Model\DanhMuc\duthaoquyetdinh;
use App\Model\HeThong\trangthaihoso;
use App\Model\NghiepVu\KhenCao\dshosodenghikhencao;
use App\Model\NghiepVu\KhenCao\dshosodenghikhencao_canhan;
use App\Model\NghiepVu\KhenCao\dshosodenghikhencao_hogiadinh;
use App\Model\NghiepVu\KhenCao\dshosodenghikhencao_tailieu;
use App\Model\NghiepVu\KhenCao\dshosodenghikhencao_tapthe;
use App\Model\View\viewdiabandonvi;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class dshosodenghikhencaoController extends Controller
{
    public static $url = '';
    public function __construct()
    {
        static::$url = '/KhenCao/HoSoDeNghi/';
        $this->middleware(function ($request, $next) {
            if (!Session::has('admin')) {
                return redirect('/');
            };
            return $next($request);
        });
    }

    public function ThongTin(Request $request)
    {
        if (!chkPhanQuyen('dshosodenghikhencao', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'dshosodenghikhencao')->with('tenphanquyen', 'danhsach');
        }
        $inputs = $request->all();
        $inputs['url_hs'] = static::$url;      
        $inputs['phanloaikhenthuong'] = 'KHENTHUONG';
        $inputs['phanloaihoso'] = 'dshosodenghikhencao';

        $m_donvi = getDonVi(session('admin')->capdo);
        // $m_donvi = getDonVi(session('admin')->capdo, 'dshosodenghikhencao');
        
        $a_diaban = array_column($m_donvi->toArray(), 'tendiaban', 'madiaban');
        $inputs['nam'] = $inputs['nam'] ?? 'ALL';
        $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;
        $donvi = $m_donvi->where('madonvi', $inputs['madonvi'])->first();
        $inputs['maloaihinhkt'] = session('chucnang')['dshosodenghikhencao']['maloaihinhkt'] ?? 'ALL';
        $inputs['trangthai'] = session('chucnang')['dshosodenghikhencao']['trangthai'] ?? 'CC';


        $model = dshosodenghikhencao::where('madonvi', $inputs['madonvi']);
            //->where('maloaihinhkt', $inputs['maloaihinhkt']);

        //->orderby('ngayhoso')->get();

        $inputs['phanloai'] = $inputs['phanloai'] ?? 'ALL';
        if ($inputs['phanloai'] != 'ALL')
            $model = $model->where('phanloai', $inputs['phanloai']);
        $inputs['nam'] = $inputs['nam'] ?? 'ALL';
        if ($inputs['nam'] != 'ALL')
            $model = $model->whereyear('ngayhoso', $inputs['nam']);
        //Lấy hồ sơ
        $model = $model->orderby('ngayhoso')->get();
        $model_canhan = dshosodenghikhencao_canhan::wherein('mahoso', array_column($model->toarray(), 'mahoso'))->where('ketqua', '1')->get();
        $model_tapthe = dshosodenghikhencao_tapthe::wherein('mahoso', array_column($model->toarray(), 'mahoso'))->where('ketqua', '1')->get();
        foreach ($model as $hoso) {
            $hoso->soluongkhenthuong = $model_canhan->where('mahoso', $hoso->mahoso)->count()
                + $model_tapthe->where('mahoso', $hoso->mahoso)->count();
        }

        if (in_array($inputs['maloaihinhkt'], ['', 'ALL', 'all'])) {
            $m_loaihinh = dmloaihinhkhenthuong::all();
        } else {
            $m_loaihinh = dmloaihinhkhenthuong::where('maloaihinhkt', $inputs['maloaihinhkt'])->get();
        }
        $model_hoso = dshosodenghikhencao::where(function ($qr) use ($inputs) {
            $qr->where('madonvi_xd', $inputs['madonvi'])->orwhere('madonvi_kt', $inputs['madonvi']);
        })->get();
        
        return view('NghiepVu.KhenCao.HoSoDeNghi.ThongTin')
            ->with('model', $model)
            ->with('a_donvi', array_column(dsdonvi::all()->toArray(), 'tendonvi', 'madonvi'))
            ->with('a_capdo', getPhamViApDung())
            ->with('model_hoso', $model_hoso)
            ->with('m_donvi', $m_donvi)
            ->with('a_diaban', $a_diaban)
            ->with('a_donviql', getDonViXetDuyetDiaBan($donvi))
            ->with('a_donvinganh', getDonViQuanLyNganh($donvi))
            ->with('a_phanloaihs', getPhanLoaiHoSo('KHENCAO'))
            ->with('a_loaihinhkt', array_column($m_loaihinh->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Danh sách hồ sơ đề nghị khen thưởng chuyên đề');
    }

    public function Them(Request $request)
    {
        if (!chkPhanQuyen('dshosodenghikhencao', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dshosodenghikhencao')->with('tenphanquyen', 'thaydoi');
        }
        $inputs = $request->all();
        $inputs['mahoso'] = (string)getdate()[0];
        $inputs['phanloai'] = 'KHENTHUONG';
       
        //Kiểm tra trạng thái hồ sơ
        setThongTinHoSo($inputs);
        //Lưu nhật ký
        dshosodenghikhencao::create($inputs);
        $trangthai = new trangthaihoso();
        $trangthai->trangthai = $inputs['trangthai'];
        $trangthai->madonvi = $inputs['madonvi'];
        $trangthai->thongtin = "Thêm mới hồ sơ đề nghị khen thưởng";
        $trangthai->phanloai = 'dshosodenghikhencao';
        $trangthai->mahoso = $inputs['mahoso'];
        $trangthai->thoigian = $inputs['ngayhoso'];
        $trangthai->save();

        return redirect(static::$url . 'Sua?mahoso=' . $inputs['mahoso']);
    }

    public function ThayDoi(Request $request)
    {
        if (!chkPhanQuyen('dshosodenghikhencao', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dshosodenghikhencao')->with('tenphanquyen', 'thaydoi');
        }
        $inputs = $request->all();
        $inputs['url'] = static::$url;
        $inputs['url_hs'] = static::$url;
     
        $inputs['phanloaikhenthuong'] = 'KHENTHUONG';
        $inputs['phanloaihoso'] = 'dshosodenghikhencao';

        $model = dshosodenghikhencao::where('mahoso', $inputs['mahoso'])->first();
        $model_canhan = dshosodenghikhencao_canhan::where('mahoso', $model->mahoso)->get();
        $model_tapthe = dshosodenghikhencao_tapthe::where('mahoso', $model->mahoso)->get();
        $model_hogiadinh = dshosodenghikhencao_hogiadinh::where('mahoso', $model->mahoso)->get();
        $model_tailieu = dshosodenghikhencao_tailieu::where('mahoso', $model->mahoso)->get();
        $donvi = viewdiabandonvi::where('madonvi', $model->madonvi)->first();

        //30.03.2023 Hồ sơ đề nghị thì mở hết danh hiệu để chọn do đề nghị là gửi cấp trên 
        $a_dhkt_canhan = getDanhHieuKhenThuong('ALL');
        $a_dhkt_tapthe = getDanhHieuKhenThuong('ALL', 'TAPTHE');
        $a_dhkt_hogiadinh = getDanhHieuKhenThuong('ALL', 'HOGIADINH');

        $model->tendonvi = $donvi->tendonvi;
        $inputs['mahinhthuckt'] = $model->mahinhthuckt;
        $a_tapthe = array_column(dmnhomphanloai_chitiet::wherein('manhomphanloai', ['TAPTHE'])->get()->toarray(), 'tenphanloai', 'maphanloai');
        $a_hogiadinh = array_column(dmnhomphanloai_chitiet::wherein('manhomphanloai', ['HOGIADINH'])->get()->toarray(), 'tenphanloai', 'maphanloai');
        $a_canhan = array_column(dmnhomphanloai_chitiet::wherein('manhomphanloai', ['CANHAN'])->get()->toarray(), 'tenphanloai', 'maphanloai');

        return view('NghiepVu.KhenCao.HoSoDeNghi.ThayDoi')
            ->with('model', $model)
            ->with('model_canhan', $model_canhan)
            ->with('model_tapthe', $model_tapthe)
            ->with('model_hogiadinh', $model_hogiadinh)
            ->with('model_tailieu', $model_tailieu)
            ->with('a_dhkt_canhan', $a_dhkt_canhan)
            ->with('a_dhkt_tapthe', $a_dhkt_tapthe)
            ->with('a_dhkt_hogiadinh', $a_dhkt_hogiadinh)
            ->with('a_pltailieu', getPhanLoaiTaiLieuDK())
            ->with('a_donvi', array_column(dsdonvi::all()->toArray(), 'tendonvi', 'madonvi'))
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('a_canhan', $a_canhan)
            ->with('a_tapthe', $a_tapthe)
            ->with('a_hogiadinh', $a_hogiadinh)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Thông tin hồ sơ đề nghị khen thưởng chuyên đề');
    }

    public function XemHoSo(Request $request)
    {
        $inputs = $request->all();
        $model = dshosodenghikhencao::where('mahoso', $inputs['mahoso'])->first();
        //$model->tenphongtraotd = dsphongtraothidua::where('maphongtraotd', $model->maphongtraotd)->first()->noidung ?? '';
        $model_canhan = dshosodenghikhencao_canhan::where('mahoso', $model->mahoso)->get();
        $model_tapthe = dshosodenghikhencao_tapthe::where('mahoso', $model->mahoso)->get();
        //$model_detai = dshosodenghikhencao_detai::where('mahoso', $model->mahoso)->get();
        $model_hogiadinh = dshosodenghikhencao_hogiadinh::where('mahoso', $model->mahoso)->get();        
        $a_phanloaidt = array_column(dmnhomphanloai_chitiet::all()->toarray(), 'tenphanloai', 'maphanloai');
        $m_donvi = dsdonvi::where('madonvi', $model->madonvi)->first();
        $a_dhkt = getDanhHieuKhenThuong('ALL');

        return view('NghiepVu.KhenThuongChuyenDe.HoSo.Xem')
            ->with('model', $model)
            ->with('model_canhan', $model_canhan)
            ->with('model_tapthe', $model_tapthe)
            ->with('model_hogiadinh', $model_hogiadinh)
            ->with('m_donvi', $m_donvi)
            ->with('a_phanloaidt', $a_phanloaidt)
            ->with('a_dhkt', $a_dhkt)
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Thông tin hồ sơ đề nghị khen thưởng');
    }

    

    public function LuuHoSo(Request $request)
    {

        if (!chkPhanQuyen('dshosodenghikhencao', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dshosodenghikhencao')->with('tenphanquyen', 'thaydoi');
        }
        $inputs = $request->all();        
        dshosodenghikhencao::where('mahoso', $inputs['mahoso'])->first()->update($inputs);

        return redirect(static::$url . 'ThongTin?madonvi=' . $inputs['madonvi']);
    }
   


    public function LayLyDo(Request $request)
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
        $model = dshosodenghikhencao::where('mahoso', $inputs['mahoso'])->first();
        die(json_encode($model));
    }

    public function ChuyenHoSo(Request $request)
    {
        if (!chkPhanQuyen('dshosodenghikhencao', 'hoanthanh')) {
            return view('errors.noperm')->with('machucnang', 'dshosodenghikhencao')->with('tenphanquyen', 'hoanthanh');
        }
        $inputs = $request->all();
        $model = dshosodenghikhencao::where('mahoso', $inputs['mahoso'])->first();        
        //đơn vị sử dụng trạng thái CXKT => hồ sơ chuyển đi sẽ có trạng thái CXKT vì đã có đơn vị khen thưởng trong lúc tạo hồ so
        //đơn vị sử dụng trạng thái CC => hồ sơ chuyển đi sẽ có trạng thái DD để đơn vị xét duyệt chuyển cho đơn vị cấp trên
        // $trangthai = session('chucnang')['dshosodenghikhencao']['trangthai'] ?? 'CC';
        // $inputs['trangthai'] = $trangthai == 'CC' ? 'DD' : 'CXKT';
        $inputs['trangthai'] = getTrangThaiChuyenHS(session('chucnang')['dshosodenghikhencao']['trangthai'] ?? 'CC');
        $inputs['thoigian'] = date('Y-m-d H:i:s');
        $inputs['lydo'] = ''; //Xóa lý do trả lại
        setChuyenDV($model, $inputs);
        return redirect(static::$url . 'ThongTin?madonvi=' . $model->madonvi);
    }

    public function XoaHoSo(Request $request)
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
        $model = dshosodenghikhencao::findorfail($inputs['id']);
        $model->delete();
        return redirect(static::$url . 'ThongTin?madonvi=' . $model->madonvi);
    }

    public function ThemCaNhan(Request $request)
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
        //$id =  $inputs['id'];       
        $model = dshosodenghikhencao_canhan::where('id', $inputs['id'])->first();
        unset($inputs['id']);
        if ($model == null) {
            $inputs['ketqua'] = 1;
            dshosodenghikhencao_canhan::create($inputs);
        } else
            $model->update($inputs);
        // return response()->json($inputs['id']);

        $danhsach = dshosodenghikhencao_canhan::where('mahoso', $inputs['mahoso'])->get();
        $dungchung = new dungchung_nghiepvuController();
        $dungchung->htmlCaNhan($result, $danhsach, static::$url, true, $inputs['maloaihinhkt']);
        return response()->json($result);
    }

    public function LayCaNhan(Request $request)
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
        $model = dshosodenghikhencao_canhan::findorfail($inputs['id']);
        die(json_encode($model));
    }

    public function XoaCaNhan(Request $request)
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
        $model = dshosodenghikhencao_canhan::findorfail($inputs['id']);
        $model->delete();

        $danhsach = dshosodenghikhencao_canhan::where('mahoso', $model->mahoso)->get();
        $dungchung = new dungchung_nghiepvuController();
        $dungchung->htmlCaNhan($result, $danhsach, static::$url, true, $inputs['maloaihinhkt']);

        return response()->json($result);
    }

    public function ThemTapThe(Request $request)
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
        
        $model = dshosodenghikhencao_tapthe::where('id', $inputs['id'])->first();
        unset($inputs['id']);
        if ($model == null) {
            $inputs['ketqua'] = 1;
            // return response()->json($inputs);
            dshosodenghikhencao_tapthe::create($inputs);
        } else
            $model->update($inputs);

        $danhsach = dshosodenghikhencao_tapthe::where('mahoso', $inputs['mahoso'])->get();
        // return response()->json($danhsach);
        $dungchung = new dungchung_nghiepvuController();
        $dungchung->htmlTapThe($result, $danhsach, static::$url, true, $inputs['maloaihinhkt']);

        return response()->json($result);
    }

    public function LayTapThe(Request $request)
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
        $model = dshosodenghikhencao_tapthe::findorfail($inputs['id']);
        die(json_encode($model));
    }

    public function XoaTapThe(Request $request)
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
        $model = dshosodenghikhencao_tapthe::findorfail($inputs['id']);
        $model->delete();

        $danhsach = dshosodenghikhencao_tapthe::where('mahoso', $model->mahoso)->get();
        $dungchung = new dungchung_nghiepvuController();
        $dungchung->htmlTapThe($result, $danhsach, static::$url, true, $inputs['maloaihinhkt']);

        return response()->json($result);
    }    

    public function NhanExcel(Request $request)
    {
        $dungchung = new dungchung_nhanexcelController();
        $dungchung->NhanExcelKhenThuong($request);
        return redirect(static::$url . 'Sua?mahoso=' . $request->all()['mahoso']);
    }

    public function ThemHoGiaDinh(Request $request)
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
        //$id =  $inputs['id'];       
        $model = dshosodenghikhencao_hogiadinh::where('id', $inputs['id'])->first();
        unset($inputs['id']);
        if ($model == null) {
            $inputs['ketqua'] = 1;
            dshosodenghikhencao_hogiadinh::create($inputs);
        } else
            $model->update($inputs);
        // return response()->json($inputs['id']);

        $danhsach = dshosodenghikhencao_hogiadinh::where('mahoso', $inputs['mahoso'])->get();

        $dungchung = new dungchung_nghiepvuController();
        $dungchung->htmlHoGiaDinh($result, $danhsach, static::$url, true, $inputs['maloaihinhkt']);
        return response()->json($result);
    }

    public function LayHoGiaDinh(Request $request)
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
        $model = dshosodenghikhencao_hogiadinh::findorfail($inputs['id']);
        die(json_encode($model));
    }

    public function XoaHoGiaDinh(Request $request)
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
        $model = dshosodenghikhencao_hogiadinh::findorfail($inputs['id']);
        $model->delete();

        $danhsach = dshosodenghikhencao_hogiadinh::where('mahoso', $model->mahoso)->get();
        $dungchung = new dungchung_nghiepvuController();
        $dungchung->htmlHoGiaDinh($result, $danhsach, static::$url, true, $inputs['maloaihinhkt']);
        return response()->json($result);
    }
}
