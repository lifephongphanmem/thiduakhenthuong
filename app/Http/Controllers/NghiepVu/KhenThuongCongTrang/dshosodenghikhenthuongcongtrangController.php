<?php

namespace App\Http\Controllers\NghiepVu\KhenThuongCongTrang;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\NghiepVu\_DungChung\dungchung_nghiepvuController;
use App\Http\Controllers\NghiepVu\_DungChung\dungchung_nhanexcelController;
use App\Model\DanhMuc\dmloaihinhkhenthuong;
use App\Model\DanhMuc\dmnhomphanloai_chitiet;
use App\Model\DanhMuc\dsdiaban;
use App\Model\DanhMuc\dsdonvi;
use App\Model\DanhMuc\duthaoquyetdinh;
use App\Model\HeThong\trangthaihoso;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_canhan;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_detai;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_hogiadinh;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_khenthuong;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_tapthe;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_tieuchuan;
use App\Model\NghiepVu\ThiDuaKhenThuong\dsphongtraothidua;
use App\Model\View\viewdiabandonvi;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class dshosodenghikhenthuongcongtrangController extends Controller
{
    public static $url = '/KhenThuongCongTrang/HoSo/';
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
        if (!chkPhanQuyen('dshosodenghikhenthuongcongtrang', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'dshosodenghikhenthuongcongtrang')->with('tenphanquyen', 'danhsach');
        }
        $inputs = $request->all();
        $inputs['phanloaikhenthuong'] = 'KHENTHUONG';

        $m_donvi = getDonVi(session('admin')->capdo, 'dshosodenghikhenthuongcongtrang');
        $a_diaban = array_column($m_donvi->toArray(), 'tendiaban', 'madiaban');

        $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;
        $donvi = $m_donvi->where('madonvi', $inputs['madonvi'])->first();
        $inputs['maloaihinhkt'] = session('chucnang')['dshosodenghikhenthuongcongtrang']['maloaihinhkt'] ?? 'ALL';
        $inputs['trangthai'] = session('chucnang')['dshosodenghikhenthuongcongtrang']['trangthai'] ?? 'CC';
        $model = dshosothiduakhenthuong::where('madonvi', $inputs['madonvi'])
            ->wherein('phanloai', ['KHENTHUONG', 'KTNGANH'])
            ->where('maloaihinhkt', $inputs['maloaihinhkt']);
        if (in_array($inputs['maloaihinhkt'], ['', 'ALL', 'all'])) {
            $m_loaihinh = dmloaihinhkhenthuong::all();
        } else {
            $m_loaihinh = dmloaihinhkhenthuong::where('maloaihinhkt', $inputs['maloaihinhkt'])->get();
        }
        $inputs['phanloai'] = $inputs['phanloai'] ?? 'ALL';
        if ($inputs['phanloai'] != 'ALL')
            $model = $model->where('phanloai', $inputs['phanloai']);
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

        //Gán đường dẫn
        if ($inputs['trangthai'] == 'CC') {
            //Đi theo quy trình bình thường
            $inputs['url_hs'] = '/KhenThuongCongTrang/HoSo/';
            $inputs['url_xd'] = '/KhenThuongCongTrang/XetDuyet/';
            $inputs['url_qd'] = '/KhenThuongCongTrang/KhenThuong/';
        } else {
            //Chỉ sử lý ở màn hình "ThongTin"
            $inputs['url_hs'] = '/KhenThuongCongTrang/HoSo/';
            $inputs['url_xd'] = '/KhenThuongCongTrang/HoSo/';
            $inputs['url_qd'] = '/KhenThuongCongTrang/HoSo/';
        }
        //dd($inputs);
        return view('NghiepVu.KhenThuongCongTrang.HoSoKhenThuong.ThongTin')
            ->with('model', $model)
            ->with('a_donvi', array_column(dsdonvi::all()->toArray(), 'tendonvi', 'madonvi'))
            ->with('a_capdo', getPhamViApDung())
            ->with('m_donvi', $m_donvi)
            ->with('a_diaban', $a_diaban)
            ->with('a_donviql', getDonViXetDuyetDiaBan($donvi))
            ->with('a_donvinganh', getDonViQuanLyNganh($donvi))
            //->with('a_phanloaihs', getPhanLoaiHoSo())
            ->with('a_loaihinhkt', array_column($m_loaihinh->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Danh sách hồ sơ khen thưởng theo công trạng');
    }

    public function ThayDoi(Request $request)
    {
        if (!chkPhanQuyen('dshosodenghikhenthuongcongtrang', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dshosodenghikhenthuongcongtrang')->with('tenphanquyen', 'thaydoi');
        }
        $inputs = $request->all();
        $inputs['url'] = '/KhenThuongCongTrang/HoSo/';
        $inputs['url_hs'] = '/KhenThuongCongTrang/HoSo/';
        $inputs['url_xd'] = '/KhenThuongCongTrang/XetDuyet/';
        $inputs['url_qd'] = '/KhenThuongCongTrang/KhenThuong/';
        $inputs['phanloaikhenthuong'] = 'KHENTHUONG';

        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $model_canhan = dshosothiduakhenthuong_canhan::where('mahosotdkt', $model->mahosotdkt)->get();
        $model_tapthe = dshosothiduakhenthuong_tapthe::where('mahosotdkt', $model->mahosotdkt)->get();
        $model_detai = dshosothiduakhenthuong_detai::where('mahosotdkt', $model->mahosotdkt)->get();
        $model_hogiadinh = dshosothiduakhenthuong_hogiadinh::where('mahosotdkt', $model->mahosotdkt)->get();
        $donvi = viewdiabandonvi::where('madonvi', $model->madonvi)->first();

        // $a_dhkt_canhan = getDanhHieuKhenThuong($donvi->capdo);
        // $a_dhkt_tapthe = getDanhHieuKhenThuong($donvi->capdo, 'TAPTHE');
        // $a_dhkt_hogiadinh = getDanhHieuKhenThuong($donvi->capdo, 'HOGIADINH');
        //30.03.2023 Hồ sơ đề nghị thì mở hết danh hiệu để chọn do đề nghị là gửi cấp trên 
        $a_dhkt_canhan = getDanhHieuKhenThuong('ALL');
        $a_dhkt_tapthe = getDanhHieuKhenThuong('ALL', 'TAPTHE');
        $a_dhkt_hogiadinh = getDanhHieuKhenThuong('ALL', 'HOGIADINH');

        $model->tendonvi = $donvi->tendonvi;
        $m_donvi = getDonVi(session('admin')->capdo);
        $m_diaban = dsdiaban::wherein('madiaban', array_column($m_donvi->toarray(), 'madiaban'))->get();
        //$m_danhhieu = dmdanhhieuthidua::all();
        $m_phongtrao = dsphongtraothidua::all();
        //$m_canhan = getDoiTuongKhenThuong($model->madonvi);
        //$m_tapthe = getTapTheKhenThuong($model->madonvi);
        $a_tapthe = array_column(dmnhomphanloai_chitiet::wherein('manhomphanloai', ['TAPTHE'])->get()->toarray(), 'tenphanloai', 'maphanloai');
        $a_hogiadinh = array_column(dmnhomphanloai_chitiet::wherein('manhomphanloai', ['HOGIADINH'])->get()->toarray(), 'tenphanloai', 'maphanloai');
        $a_canhan = array_column(dmnhomphanloai_chitiet::wherein('manhomphanloai', ['CANHAN'])->get()->toarray(), 'tenphanloai', 'maphanloai');

        $inputs['mahinhthuckt'] = $model->mahinhthuckt;
        //dd($model);
        return view('NghiepVu.KhenThuongCongTrang.HoSoKhenThuong.ThayDoi')
            ->with('model', $model)
            ->with('model_canhan', $model_canhan)
            ->with('model_tapthe', $model_tapthe)
            ->with('model_hogiadinh', $model_hogiadinh)
            ->with('model_detai', $model_detai)
            ->with('a_dhkt_canhan', $a_dhkt_canhan)
            ->with('a_dhkt_tapthe', $a_dhkt_tapthe)
            ->with('a_dhkt_hogiadinh', $a_dhkt_hogiadinh)
            ->with('m_donvi', $m_donvi)
            ->with('m_diaban', $m_diaban)
            //->with('m_danhhieu', $m_danhhieu)
            //->with('m_canhan', $m_canhan)
            //->with('m_tapthe', $m_tapthe)
            ->with('m_phongtraotd', $m_phongtrao)
            ->with('a_phongtraotd', array_column($m_phongtrao->toArray(), 'noidung', 'maphongtraotd'))
            //->with('a_danhhieutd', array_column($m_danhhieu->toArray(), 'tendanhhieutd', 'madanhhieutd'))
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            //->with('a_hinhthuckt', array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
            ->with('a_canhan', $a_canhan)
            ->with('a_tapthe', $a_tapthe)
            ->with('a_hogiadinh', $a_hogiadinh)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Thông tin hồ sơ đề nghị khen thưởng');
    }

    public function XemHoSo(Request $request)
    {
        $inputs = $request->all();
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $model->tenphongtraotd = dsphongtraothidua::where('maphongtraotd', $model->maphongtraotd)->first()->noidung ?? '';
        $model_canhan = dshosothiduakhenthuong_canhan::where('mahosotdkt', $model->mahosotdkt)->get();
        $model_tapthe = dshosothiduakhenthuong_tapthe::where('mahosotdkt', $model->mahosotdkt)->get();
        $model_detai = dshosothiduakhenthuong_detai::where('mahosotdkt', $model->mahosotdkt)->get();
        $a_phanloaidt = array_column(dmnhomphanloai_chitiet::all()->toarray(), 'tenphanloai', 'maphanloai');
        $m_donvi = dsdonvi::where('madonvi', $model->madonvi)->first();
        $a_dhkt = getDanhHieuKhenThuong('ALL');
        return view('NghiepVu.KhenThuongCongTrang.HoSoKhenThuong.Xem')
            ->with('model', $model)
            ->with('model_canhan', $model_canhan)
            ->with('model_tapthe', $model_tapthe)
            ->with('model_detai', $model_detai)
            ->with('m_donvi', $m_donvi)
            ->with('a_phanloaidt', $a_phanloaidt)
            ->with('a_dhkt', $a_dhkt)
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            // ->with('a_hinhthuckt', array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Thông tin hồ sơ đề nghị khen thưởng');
    }

    public function Them(Request $request)
    {
        if (!chkPhanQuyen('dshosodenghikhenthuongcongtrang', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dshosodenghikhenthuongcongtrang')->with('tenphanquyen', 'thaydoi');
        }
        $inputs = $request->all();

        $inputs['mahosotdkt'] = (string)getdate()[0];
        $inputs['phanloai'] = 'KHENTHUONG';
        if (isset($inputs['totrinh'])) {
            $filedk = $request->file('totrinh');
            $inputs['totrinh'] = $inputs['mahosotdkt'] . '_totrinh.' . $filedk->getClientOriginalExtension();
            $filedk->move(public_path() . '/data/totrinh/', $inputs['totrinh']);
        }
        //Kiểm tra trạng thái hồ sơ
        setThongTinHoSo($inputs);
        //Lưu nhật ký
        dshosothiduakhenthuong::create($inputs);
        $trangthai = new trangthaihoso();
        $trangthai->trangthai = $inputs['trangthai'];
        $trangthai->madonvi = $inputs['madonvi'];
        $trangthai->thongtin = "Thêm mới hồ sơ đề nghị khen thưởng";
        $trangthai->phanloai = 'dshosothiduakhenthuong';
        $trangthai->mahoso = $inputs['mahosotdkt'];
        $trangthai->thoigian = $inputs['ngayhoso'];
        $trangthai->save();

        return redirect(static::$url . 'Sua?mahosotdkt=' . $inputs['mahosotdkt']);
    }

    public function LuuHoSo(Request $request)
    {

        if (!chkPhanQuyen('dshosodenghikhenthuongcongtrang', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dshosodenghikhenthuongcongtrang')->with('tenphanquyen', 'thaydoi');
        }
        $inputs = $request->all();
        if (isset($inputs['totrinh'])) {
            $filedk = $request->file('totrinh');
            $inputs['totrinh'] = $inputs['mahosotdkt'] . '_totrinh.' . $filedk->getClientOriginalExtension();
            $filedk->move(public_path() . '/data/totrinh/', $inputs['totrinh']);
        }
        if (isset($inputs['baocao'])) {
            $filedk = $request->file('baocao');
            $inputs['baocao'] = $inputs['mahosotdkt'] . '_baocao.' . $filedk->getClientOriginalExtension();
            $filedk->move(public_path() . '/data/baocao/', $inputs['baocao']);
        }
        if (isset($inputs['bienban'])) {
            $filedk = $request->file('bienban');
            $inputs['bienban'] = $inputs['mahosotdkt'] . '_bienban.' . $filedk->getClientOriginalExtension();
            $filedk->move(public_path() . '/data/bienban/', $inputs['bienban']);
        }
        if (isset($inputs['tailieukhac'])) {
            $filedk = $request->file('tailieukhac');
            $inputs['tailieukhac'] = $inputs['mahosotdkt'] . 'tailieukhac.' . $filedk->getClientOriginalExtension();
            $filedk->move(public_path() . '/data/tailieukhac/', $inputs['tailieukhac']);
        }
        //dd($inputs);
        dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first()->update($inputs);

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
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        die(json_encode($model));
    }

    public function ChuyenHoSo(Request $request)
    {
        if (!chkPhanQuyen('dshosodenghikhenthuongcongtrang', 'hoanthanh')) {
            return view('errors.noperm')->with('machucnang', 'dshosodenghikhenthuongcongtrang')->with('tenphanquyen', 'hoanthanh');
        }
        $inputs = $request->all();
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahoso'])->first();
        //đơn vị sử dụng trạng thái CXKT => hồ sơ chuyển đi sẽ có trạng thái CXKT vì đã có đơn vị khen thưởng trong lúc tạo hồ so
        //đơn vị sử dụng trạng thái CC => hồ sơ chuyển đi sẽ có trạng thái DD để đơn vị xét duyệt chuyển cho đơn vị cấp trên
        $trangthai = session('chucnang')['dshosodenghikhenthuongcongtrang']['trangthai'] ?? 'CC';
        $inputs['trangthai'] = $trangthai == 'CC' ? 'DD' : 'CXKT';
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
        $model = dshosothiduakhenthuong::findorfail($inputs['id']);
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
        $model = dshosothiduakhenthuong_canhan::where('id', $inputs['id'])->first();
        unset($inputs['id']);
        if ($model == null) {
            $inputs['ketqua'] = 1;
            dshosothiduakhenthuong_canhan::create($inputs);
        } else
            $model->update($inputs);
        // return response()->json($inputs['id']);

        $model = dshosothiduakhenthuong_canhan::where('mahosotdkt', $inputs['mahosotdkt'])->get();


        $this->htmlCaNhan($result, $model);
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
        $model = dshosothiduakhenthuong_canhan::findorfail($inputs['id']);
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
        $model = dshosothiduakhenthuong_canhan::findorfail($inputs['id']);
        $model->delete();

        $danhsach = dshosothiduakhenthuong_canhan::where('mahosotdkt', $model->mahosotdkt)->get();
        $dungchung = new dungchung_nghiepvuController();
        $dungchung->htmlTapThe($result, $danhsach, static::$url, true, $inputs['maloaihinhkt']);
        return response()->json($result);
    }

    public function NhanExcelCaNhan(Request $request)
    {
        $inputs = $request->all();
        //dd($inputs);
        //$model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $filename = $inputs['mahosotdkt'] . '_' . getdate()[0];
        $request->file('fexcel')->move(public_path() . '/data/uploads/', $filename . '.xlsx');
        $path = public_path() . '/data/uploads/' . $filename . '.xlsx';
        $data = [];

        Excel::load($path, function ($reader) use (&$data, $inputs) {
            $obj = $reader->getExcel();
            $sheet = $obj->getSheet(0);
            $data = $sheet->toArray(null, true, true, true); // giữ lại tiêu đề A=>'val';
        });
        $a_dm = array();

        for ($i = $inputs['tudong']; $i <= $inputs['dendong']; $i++) {
            if (!isset($data[$i][$inputs['tendoituong']])) {
                continue;
            }
            $a_dm[] = array(
                'mahosotdkt' => $inputs['mahosotdkt'],
                'tendoituong' => $data[$i][$inputs['tendoituong']] ?? '',
                'madanhhieukhenthuong' => $data[$i][$inputs['madanhhieukhenthuong']] ?? $inputs['madanhhieukhenthuong_md'],
                'maphanloaicanbo' => $data[$i][$inputs['maphanloaicanbo']] ?? $inputs['maphanloaicanbo_md'],
                // 'madanhhieutd' => $data[$i][$inputs['madanhhieutd']] ?? $inputs['madanhhieutd_md'],
                'gioitinh' => $data[$i][$inputs['gioitinh']] ?? 'NAM',
                'ngaysinh' => $data[$i][$inputs['ngaysinh']] ?? null,
                'chucvu' => $data[$i][$inputs['chucvu']] ?? '',
                'tenphongban' => $data[$i][$inputs['tenphongban']] ?? '',
                'tencoquan' => $data[$i][$inputs['tencoquan']] ?? '',
                'ketqua' => '1',
            );
        }

        dshosothiduakhenthuong_canhan::insert($a_dm);
        File::Delete($path);

        return redirect(static::$url .  'Sua?mahosotdkt=' . $inputs['mahosotdkt']);
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
        $model = dshosothiduakhenthuong_hogiadinh::where('id', $inputs['id'])->first();
        unset($inputs['id']);
        if ($model == null) {
            $inputs['ketqua'] = 1;
            dshosothiduakhenthuong_hogiadinh::create($inputs);
        } else
            $model->update($inputs);

        $danhsach = dshosothiduakhenthuong_hogiadinh::where('mahosotdkt', $inputs['mahosotdkt'])->get();
        $dungchung = new dungchung_nghiepvuController();
        $dungchung->htmlHoGiaDinh($result, $danhsach, static::$url, true, $inputs['maloaihinhkt']);
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
        //$id =  $inputs['id'];       
        $model = dshosothiduakhenthuong_tapthe::where('id', $inputs['id'])->first();
        unset($inputs['id']);
        if ($model == null) {
            $inputs['ketqua'] = 1;
            dshosothiduakhenthuong_tapthe::create($inputs);
        } else
            $model->update($inputs);

        $danhsach = dshosothiduakhenthuong_tapthe::where('mahosotdkt', $inputs['mahosotdkt'])->get();
        $dungchung = new dungchung_nghiepvuController();
        $dungchung->htmlTapThe($result, $danhsach, static::$url, true, $inputs['maloaihinhkt']);
        //$this->htmlTapThe($result, $model);
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
        $model = dshosothiduakhenthuong_tapthe::findorfail($inputs['id']);
        die(json_encode($model));
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
        $model = dshosothiduakhenthuong_hogiadinh::findorfail($inputs['id']);
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
        $model = dshosothiduakhenthuong_hogiadinh::findorfail($inputs['id']);
        $model->delete();

        $danhsach = dshosothiduakhenthuong_tapthe::where('mahosotdkt', $model->mahosotdkt)->get();
        $dungchung = new dungchung_nghiepvuController();
        $dungchung->htmlHoGiaDinh($result, $danhsach, static::$url, true, $inputs['maloaihinhkt']);
        return response()->json($result);
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
        $model = dshosothiduakhenthuong_tapthe::findorfail($inputs['id']);
        $model->delete();

        $m_tapthe = dshosothiduakhenthuong_tapthe::where('mahosotdkt', $model->mahosotdkt)->get();
        $this->htmlTapThe($result, $m_tapthe);
        return response()->json($result);
    }

    public function NhanExcelTapThe(Request $request)
    {
        $inputs = $request->all();
        //dd($inputs);
        //$model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $filename = $inputs['mahosotdkt'] . '_' . getdate()[0];
        $request->file('fexcel')->move(public_path() . '/data/uploads/', $filename . '.xlsx');
        $path = public_path() . '/data/uploads/' . $filename . '.xlsx';
        $data = [];

        Excel::load($path, function ($reader) use (&$data, $inputs) {
            $obj = $reader->getExcel();
            $sheet = $obj->getSheet(0);
            $data = $sheet->toArray(null, true, true, true); // giữ lại tiêu đề A=>'val';
        });
        $a_dm = array();

        for ($i = $inputs['tudong']; $i <= $inputs['dendong']; $i++) {
            if (!isset($data[$i][$inputs['tentapthe']])) {
                continue;
            }
            $a_dm[] = array(
                'mahosotdkt' => $inputs['mahosotdkt'],
                'tentapthe' => $data[$i][$inputs['tentapthe']] ?? '',
                'ketqua' => '1',
                // 'mahinhthuckt' => $data[$i][$inputs['mahinhthuckt']] ?? $inputs['mahinhthuckt_md'],
                'maphanloaitapthe' => $data[$i][$inputs['maphanloaitapthe']] ?? $inputs['maphanloaitapthe_md'],
                'madanhhieukhenthuong' => $data[$i][$inputs['madanhhieukhenthuong']] ?? $inputs['madanhhieukhenthuong_md'],
            );
        }
        dshosothiduakhenthuong_tapthe::insert($a_dm);
        File::Delete($path);

        return redirect(static::$url . 'Sua?mahosotdkt=' . $inputs['mahosotdkt']);
    }

    function htmlTapThe(&$result, $model)
    {
        if (isset($model)) {
            // $a_hinhthuckt = array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt');
            // $a_danhhieutd = array_column(dmdanhhieuthidua::all()->toArray(), 'tendanhhieutd', 'madanhhieutd');
            $a_tapthe = array_column(dmnhomphanloai_chitiet::all()->toarray(), 'tenphanloai', 'maphanloai');
            $a_dhkt = getDanhHieuKhenThuong('ALL');

            $result['message'] = '<div class="row" id="dskhenthuongtapthe">';
            $result['message'] .= '<div class="col-md-12">';
            $result['message'] .= '<table id="sample_4" class="table table-striped table-bordered table-hover">';
            $result['message'] .= '<thead>';
            $result['message'] .= '<tr class="text-center">';
            $result['message'] .= '<th width="5%">STT</th>';
            $result['message'] .= '<th>Tên tập thể</th>';
            $result['message'] .= '<th>Phân loại<br>tập thể</th>';
            $result['message'] .= '<th>Hình thức khen thưởng/<br>Danh hiệu thi đua</th>';
            // $result['message'] .= '<th>Danh hiệu<br>thi đua</th>';
            $result['message'] .= '<th width="10%">Thao tác</th>';
            $result['message'] .= '</tr>';
            $result['message'] .= '</thead>';
            $result['message'] .= '<tbody>';
            $i = 1;
            foreach ($model as $tt) {
                $result['message'] .= '<tr class="odd gradeX">';
                $result['message'] .= '<td class="text-center">' . $i++ . '</td>';
                $result['message'] .= '<td>' . $tt->tentapthe . '</td>';
                $result['message'] .= '<td>' . ($a_tapthe[$tt->maphanloaitapthe] ?? '') . '</td>';
                // $result['message'] .= '<td class="text-center">' . ($a_hinhthuckt[$tt->mahinhthuckt] ?? '') . '</td>';
                // $result['message'] .= '<td class="text-center">' . ($a_danhhieutd[$tt->madanhhieutd] ?? '') . '</td>';
                $result['message'] .= '<td class="text-center"> ' . ($a_dhkt[$tt->madanhhieukhenthuong] ?? '') . '</td>';
                $result['message'] .= '<td class="text-center"><button title="Sửa thông tin" type="button" onclick="getTapThe(' . $tt->id . ')"  class="btn btn-sm btn-clean btn-icon"
                                                                    data-target="#modal-create-tapthe" data-toggle="modal"><i class="icon-lg la fa-edit text-primary"></i></button>';
                $result['message'] .= '<button title="Xóa" type="button" onclick="delKhenThuong(' . $tt->id . ', &#39;' . static::$url . 'XoaTapThe&#39;, &#39;TAPTHE&#39;)" class="btn btn-sm btn-clean btn-icon" data-target="#modal-delete-khenthuong" data-toggle="modal">
                                                                    <i class="icon-lg la fa-trash text-danger"></i></button>';

                $result['message'] .= '</td>';
                $result['message'] .= '</tr>';
            }
            $result['message'] .= '</tbody>';
            $result['message'] .= '</table>';
            $result['message'] .= '</div>';
            $result['message'] .= '</div>';


            $result['status'] = 'success';
        }
    }

    function htmlCaNhan(&$result, $model)
    {
        if (isset($model)) {
            // $a_hinhthuckt = array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt');
            // $a_danhhieutd = array_column(dmdanhhieuthidua::all()->toArray(), 'tendanhhieutd', 'madanhhieutd');
            $a_tapthe = array_column(dmnhomphanloai_chitiet::all()->toarray(), 'tenphanloai', 'maphanloai');
            $a_dhkt = getDanhHieuKhenThuong('ALL');

            $result['message'] = '<div class="row" id="dskhenthuongcanhan">';
            $result['message'] .= '<div class="col-md-12">';
            $result['message'] .= '<table id="sample_3" class="table table-striped table-bordered table-hover">';
            $result['message'] .= '<thead>';
            $result['message'] .= '<tr class="text-center">';
            $result['message'] .= '<th width="2%">STT</th>';
            $result['message'] .= '<th>Tên đối tượng</th>';
            $result['message'] .= '<th width="8%">Ngày sinh</th>';
            $result['message'] .= '<th width="5%">Giới</br>tính</th>';
            $result['message'] .= '<th width="15%">Phân loại cán bộ</th>';
            $result['message'] .= '<th>Thông tin công tác</th>';
            $result['message'] .= '<th>Hình thức khen thưởng/<br>Danh hiệu thi đua</th>';
            // $result['message'] .= '<th>Danh hiệu<br>thi đua</th>';
            $result['message'] .= '<th width="10%">Thao tác</th>';
            $result['message'] .= '</tr>';
            $result['message'] .= '</thead>';
            $result['message'] .= '<tbody>';
            $i = 1;
            foreach ($model as $tt) {
                $result['message'] .= '<tr class="odd gradeX">';
                $result['message'] .= '<td class="text-center">' . $i++ . '</td>';
                $result['message'] .= '<td>' . $tt->tendoituong . '</td>';
                $result['message'] .= '<td class="text-center">' . getDayVn($tt->ngaysinh) . '</td>';
                $result['message'] .= '<td>' . $tt->gioitinh . '</td>';
                $result['message'] .= '<td>' . ($a_tapthe[$tt->maphanloaicanbo] ?? '') . '</td>';
                $result['message'] .= '<td class="text-center">' . $tt->chucvu . ',' . $tt->tenphongban . ',' . $tt->tencoquan . '</td>';
                $result['message'] .= '<td class="text-center"> ' . ($a_dhkt[$tt->madanhhieukhenthuong] ?? '') . '</td>';
                // $result['message'] .= '<td class="text-center"> ' . ($a_danhhieutd[$tt->madanhhieutd] ?? '') . '</td>';

                $result['message'] .= '<td class="text-center"><button title="Sửa thông tin" type="button" onclick="getCaNhan(' . $tt->id . ')"  class="btn btn-sm btn-clean btn-icon"
                                                                    data-target="#modal-create" data-toggle="modal"><i class="icon-lg la fa-edit text-primary"></i></button>';
                $result['message'] .= '<button title="Xóa" type="button" onclick="delKhenThuong(' . $tt->id . ', &#39;' . static::$url . 'XoaCaNhan&#39;, &#39;CANHAN&#39;)" class="btn btn-sm btn-clean btn-icon" data-target="#modal-delete-khenthuong" data-toggle="modal">
                                                                    <i class="icon-lg la fa-trash text-danger"></i></button>';

                $result['message'] .= '</td>';
                $result['message'] .= '</tr>';
            }
            $result['message'] .= '</tbody>';
            $result['message'] .= '</table>';
            $result['message'] .= '</div>';
            $result['message'] .= '</div>';


            $result['status'] = 'success';
        }
    }

    public function ThemDeTai(Request $request)
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
        $model = dshosothiduakhenthuong_detai::where('id', $inputs['id'])->first();
        unset($inputs['id']);
        if ($model == null) {
            dshosothiduakhenthuong_detai::create($inputs);
        } else
            $model->update($inputs);

        $model = dshosothiduakhenthuong_detai::where('mahosotdkt', $inputs['mahosotdkt'])->get();

        $this->htmlDeTai($result, $model);
        return response()->json($result);
    }

    public function LayDeTai(Request $request)
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
        $model = dshosothiduakhenthuong_detai::findorfail($inputs['id']);
        die(json_encode($model));
    }

    public function XoaDeTai(Request $request)
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
        $model = dshosothiduakhenthuong_detai::findorfail($inputs['id']);
        $model->delete();

        $m_tapthe = dshosothiduakhenthuong_detai::where('mahosotdkt', $model->mahosotdkt)->get();
        $this->htmlDeTai($result, $m_tapthe);
        return response()->json($result);
    }

    public function NhanExcelDeTai(Request $request)
    {
        $inputs = $request->all();
        //dd($inputs);
        //$model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $filename = $inputs['mahosotdkt'] . '_' . getdate()[0];
        $request->file('fexcel')->move(public_path() . '/data/uploads/', $filename . '.xlsx');
        $path = public_path() . '/data/uploads/' . $filename . '.xlsx';
        $data = [];

        Excel::load($path, function ($reader) use (&$data, $inputs) {
            $obj = $reader->getExcel();
            $sheet = $obj->getSheet(0);
            $data = $sheet->toArray(null, true, true, true); // giữ lại tiêu đề A=>'val';
        });
        $a_dm = array();

        for ($i = $inputs['tudong']; $i <= $inputs['dendong']; $i++) {
            if (!isset($data[$i][$inputs['tensangkien']])) {
                continue;
            }
            $a_dm[] = array(
                'mahosotdkt' => $inputs['mahosotdkt'],
                'tensangkien' => $data[$i][$inputs['tensangkien']] ?? '',
                'donvicongnhan' => $data[$i][$inputs['donvicongnhan']] ?? '',
                'thoigiancongnhan' => $data[$i][$inputs['thoigiancongnhan']] ?? '',
                'thanhtichdatduoc' => $data[$i][$inputs['thanhtichdatduoc']] ?? '',
                'tendoituong' => $data[$i][$inputs['tendoituong']] ?? '',
                'tencoquan' => $data[$i][$inputs['tencoquan']] ?? '',
                'tenphongban' => $data[$i][$inputs['tenphongban']] ?? '',
            );
        }
        dshosothiduakhenthuong_detai::insert($a_dm);
        File::Delete($path);

        return redirect(static::$url . 'Sua?mahosotdkt=' . $inputs['mahosotdkt']);
    }

    function htmlDeTai(&$result, $model)
    {
        if (isset($model)) {
            $result['message'] = '<div class="row" id="dsdetai">';
            $result['message'] .= '<div class="col-md-12">';
            $result['message'] .= '<table id="sample_5" class="table table-striped table-bordered table-hover">';
            $result['message'] .= '<thead>';
            $result['message'] .= '<tr class="text-center">';
            $result['message'] .= '<th width="5%">STT</th>';
            $result['message'] .= '<th>Tên đề tài, sáng kiến</th>';
            $result['message'] .= '<th>Thông tin tác giả</th>';
            $result['message'] .= '<th width="10%">Thao tác</th>';
            $result['message'] .= '</tr>';
            $result['message'] .= '</thead>';
            $result['message'] .= '<tbody>';
            $i = 1;
            foreach ($model as $tt) {
                $result['message'] .= '<tr class="odd gradeX">';
                $result['message'] .= '<td class="text-center">' . $i++ . '</td>';
                $result['message'] .= '<td>' . $tt->tensangkien . '</td>';
                $result['message'] .= '<td class="text-center">' . $tt->tendoituong . ',' . $tt->tenphongban . ',' . $tt->tencoquan . '</td>';

                $result['message'] .= '<td class="text-center"><button title="Sửa thông tin" type="button" onclick="getDeTai(' . $tt->id . ')"  class="btn btn-sm btn-clean btn-icon"
                                                                    data-target="#modal-detai" data-toggle="modal"><i class="icon-lg la fa-edit text-primary"></i></button>';
                $result['message'] .= '<button title="Xóa" type="button" onclick="delDeTai(' . $tt->id . ', &#39;' . static::$url . 'XoaDeTai&#39;)" class="btn btn-sm btn-clean btn-icon" data-target="#modal-delete-detai" data-toggle="modal">
                                                                    <i class="icon-lg la fa-trash text-danger"></i></button>';

                $result['message'] .= '</td>';
                $result['message'] .= '</tr>';
            }
            $result['message'] .= '</tbody>';
            $result['message'] .= '</table>';
            $result['message'] .= '</div>';
            $result['message'] .= '</div>';


            $result['status'] = 'success';
        }
    }

    public function TaiLieuDinhKem(Request $request)
    {
        $result = array(
            'status' => 'fail',
            'message' => 'error',
        );

        $inputs = $request->all();
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahs'])->first();
        $result['message'] = '<div class="modal-body" id = "dinh_kem" >';
        if ($model->totrinh != '') {
            $result['message'] .= '<div class="form-group row">';
            $result['message'] .= '<label class="col-3 col-form-label font-weight-bold" >Tờ trình:</label>';
            $result['message'] .= '<div class="col-9 form-control"><a target = "_blank" href = "' . url('/data/totrinh/' . $model->totrinh) . '">' . $model->totrinh . '</a ></div>';
            $result['message'] .= '</div>';
        }
        if ($model->bienban != '') {
            $result['message'] .= '<div class="form-group row">';
            $result['message'] .= '<label class="col-3 col-form-label font-weight-bold" >Biên bản cuộc họp:</label>';
            $result['message'] .= '<div class="col-9 form-control"><a target = "_blank" href = "' . url('/data/bienban/' . $model->bienban) . '">' . $model->bienban . '</a ></div>';
            $result['message'] .= '</div>';
        }
        if ($model->baocao != '') {
            $result['message'] .= '<div class="form-group row">';
            $result['message'] .= '<label class="col-3 col-form-label font-weight-bold" >Báo cáo thành tích:</label>';
            $result['message'] .= '<div class="col-9 form-control"><a target = "_blank" href = "' . url('/data/baocao/' . $model->baocao) . '">' . $model->baocao . '</a ></div>';
            $result['message'] .= '</div>';
        }
        if ($model->tailieukhac != '') {
            $result['message'] .= '<div class="form-group row">';
            $result['message'] .= '<label class="col-3 col-form-label font-weight-bold" >Tài liệu khác</label>';
            $result['message'] .= '<div class="col-9 form-control"><a target = "_blank" href = "' . url('/data/tailieukhac/' . $model->tailieukhac) . '">' . $model->tailieukhac . '</a ></div>';
            $result['message'] .= '</div>';
        }
        if ($model->quyetdinh != '') {
            $result['message'] .= '<div class="form-group row">';
            $result['message'] .= '<label class="col-3 col-form-label font-weight-bold" >Quyết định khen thưởng:</label>';
            $result['message'] .= '<div class="col-9 form-control"><a target = "_blank" href = "' . url('/data/quyetdinh/' . $model->quyetdinh) . '">' . $model->tailieukhac . '</a ></div>';
            $result['message'] .= '</div>';
        }
        $result['message'] .= '</div>';
        $result['status'] = 'success';

        die(json_encode($result));
    }

    public function QuyetDinh(Request $request)
    {
        $inputs = $request->all();
        $inputs['url'] = static::$url;
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $inputs['madonvi'] = $model->madonvi;
        getTaoDuThaoKT($model);
        $a_duthao = array_column(duthaoquyetdinh::all()->toArray(), 'noidung', 'maduthao');
        $inputs['maduthao'] = $inputs['maduthao'] ?? array_key_first($a_duthao);
        return view('BaoCao.DonVi.QuyetDinh.MauChung')
            ->with('model', $model)
            ->with('a_duthao', $a_duthao)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Dự thảo quyết định khen thưởng');
    }

    public function DuThaoQuyetDinh(Request $request)
    {
        $inputs = $request->all();
        $inputs['url'] = static::$url;
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $model->thongtinquyetdinh = '';
        $inputs['madonvi'] = $model->madonvi_xd;
        $a_duthao = array_column(duthaoquyetdinh::all()->toArray(), 'noidung', 'maduthao');
        $inputs['maduthao'] = $inputs['maduthao'] ?? array_key_first($a_duthao);
        getTaoDuThaoKT($model, $inputs['maduthao']);

        return view('BaoCao.DonVi.QuyetDinh.MauChung')
            ->with('model', $model)
            ->with('a_duthao', $a_duthao)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Dự thảo quyết định khen thưởng');
    }

    public function LuuQuyetDinh(Request $request)
    {
        $inputs = $request->all();
        //dd($inputs);
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $model->thongtinquyetdinh = $inputs['thongtinquyetdinh'];
        $model->save();
        return redirect(static::$url . 'ThongTin?madonvi=' . $model->madonvi_xd);
    }

    public function PheDuyet(Request $request)
    {
        $inputs = $request->all();
        $inputs['url_hs'] = '/KhenThuongCongTrang/HoSo/';
        $inputs['url_xd'] = '/KhenThuongCongTrang/HoSo/';
        $inputs['url_qd'] = '/KhenThuongCongTrang/HoSo/';
        $inputs['mahinhthuckt'] = session('chucnang')['dshosodenghikhenthuongcongtrang']['mahinhthuckt'] ?? 'ALL';
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $model_canhan = dshosothiduakhenthuong_canhan::where('mahosotdkt', $inputs['mahosotdkt'])->get();
        $model_tapthe = dshosothiduakhenthuong_tapthe::where('mahosotdkt', $inputs['mahosotdkt'])->get();
        $model_detai = dshosothiduakhenthuong_detai::where('mahosotdkt', $inputs['mahosotdkt'])->get();
        $donvi = viewdiabandonvi::where('madonvi', $model->madonvi)->first();
        $a_dhkt_canhan = getDanhHieuKhenThuong($donvi->capdo);
        $a_dhkt_tapthe = getDanhHieuKhenThuong($donvi->capdo, 'TAPTHE');
        $model->tendonvi = $donvi->tendonvi;
        $a_tapthe = array_column(dmnhomphanloai_chitiet::wherein('manhomphanloai', ['TAPTHE', 'HOGIADINH'])->get()->toarray(), 'tenphanloai', 'maphanloai');
        $a_canhan = array_column(dmnhomphanloai_chitiet::wherein('manhomphanloai', ['CANHAN'])->get()->toarray(), 'tenphanloai', 'maphanloai');
        //Gán thông tin đơn vị khen thưởng
        $donvi_kt = viewdiabandonvi::where('madonvi', $model->madonvi_kt)->first();

        $model->capkhenthuong =  $donvi_kt->capdo;
        $model->donvikhenthuong =  $donvi_kt->tendvhienthi;

        return view('NghiepVu.KhenThuongCongTrang.HoSoKhenThuong.PheDuyetKT')
            ->with('model', $model)
            ->with('model_canhan', $model_canhan)
            ->with('model_tapthe', $model_tapthe)
            ->with('model_detai', $model_detai)
            ->with('a_dhkt_canhan', $a_dhkt_canhan)
            ->with('a_dhkt_tapthe', $a_dhkt_tapthe)
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('a_donvi_kt', [$donvi_kt->madonvi => $donvi_kt->tendonvi])
            ->with('a_tapthe', $a_tapthe)
            ->with('a_canhan', $a_canhan)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Thông tin hồ sơ đề nghị khen thưởng');
    }

    public function LuuPheDuyet(Request $request)
    {
        $inputs = $request->all();
        if (isset($inputs['quyetdinh'])) {
            $filedk = $request->file('quyetdinh');
            $inputs['quyetdinh'] = $inputs['mahosotdkt'] . '_quyetdinh.' . $filedk->getClientOriginalExtension();
            $filedk->move(public_path() . '/data/quyetdinh/', $inputs['quyetdinh']);
        }
        $thoigian = date('Y-m-d H:i:s');
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $model->trangthai = 'DKT';
        //gán trạng thái hồ sơ để theo dõi
        $model->trangthai_xd = $model->trangthai;
        $model->trangthai_kt = $model->trangthai;
        $model->thoigian_kt = $thoigian;

        $model->donvikhenthuong = $inputs['donvikhenthuong'];
        $model->capkhenthuong = $inputs['capkhenthuong'];
        $model->soqd = $inputs['soqd'];
        $model->ngayqd = $inputs['ngayqd'];
        $model->chucvunguoikyqd = $inputs['chucvunguoikyqd'];
        $model->hotennguoikyqd = $inputs['hotennguoikyqd'];
        //dd($model);
        getTaoQuyetDinhKT($model);
        $model->save();
        trangthaihoso::create([
            'mahoso' => $inputs['mahosotdkt'],
            'phanloai' => 'dshosothiduakhenthuong',
            'trangthai' => $model->trangthai,
            'thoigian' => $thoigian,
            'madonvi' => $inputs['madonvi'],
            'thongtin' => 'Phê duyệt đề nghị khen thưởng.',
        ]);
        return redirect(static::$url . 'ThongTin?madonvi=' . $model->madonvi);
    }

    public function HuyPheDuyet(Request $request)
    {
        if (!chkPhanQuyen('qdhosodenghikhenthuongcongtrang', 'hoanthanh')) {
            return view('errors.noperm')
                ->with('machucnang', 'qdhosodenghikhenthuongcongtrang')
                ->with('tenphanquyen', 'hoanthanh');
        }
        $inputs = $request->all();
        $thoigian = date('Y-m-d H:i:s');
        $trangthai = 'CXKT';
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();

        $model->trangthai = $trangthai;
        $model->trangthai_xd = $model->trangthai;
        $model->trangthai_kt = $model->trangthai;
        $model->thoigian_kt = null;

        $model->donvikhenthuong = null;
        $model->capkhenthuong = null;
        $model->soqd = null;
        $model->ngayqd = null;
        $model->chucvunguoikyqd = null;
        $model->hotennguoikyqd = null;
        //dd($model);
        $model->save();
        trangthaihoso::create([
            'mahoso' => $inputs['mahosotdkt'],
            'phanloai' => 'dshosothiduakhenthuong',
            'trangthai' => $model->trangthai,
            'thoigian' => $thoigian,
            'madonvi' => $inputs['madonvi'],
            'thongtin' => 'Hủy phê duyệt đề nghị khen thưởng.',
        ]);
        return redirect(static::$url . 'ThongTin?madonvi=' . $model->madonvi);
    }

    public function ToTrinhHoSo(Request $request)
    {
        $inputs = $request->all();
        $inputs['url'] = static::$url;
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $inputs['madonvi'] = $model->madonvi;
        $inputs['maduthao'] = $inputs['maduthao'] ?? 'ALL';
        getTaoDuThaoToTrinhHoSo($model, $inputs['maduthao']);
        $a_duthao = array_column(duthaoquyetdinh::wherein('phanloai', ['TOTRINHHOSO'])->get()->toArray(), 'noidung', 'maduthao');

        $inputs['maduthao'] = $inputs['maduthao'] ?? array_key_first($a_duthao);
        return view('BaoCao.DonVi.QuyetDinh.MauChungToTrinh')
            ->with('model', $model)
            ->with('a_duthao', $a_duthao)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Dự thảo tờ trình khen thưởng');
    }

    public function LuuToTrinhHoSo(Request $request)
    {
        $inputs = $request->all();
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $model->thongtintotrinhhoso = $inputs['thongtintotrinhhoso'];
        $model->save();
        return redirect(static::$url . 'ThongTin?madonvi=' . $model->madonvi);
    }

    public function InToTrinhHoSo(Request $request)
    {
        $inputs = $request->all();
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        getTaoDuThaoToTrinhHoSo($model);
        $model->thongtinquyetdinh = $model->thongtintotrinhhoso;
        $model->thongtinquyetdinh = str_replace('<p>[sangtrangmoi]</p>', '<div class=&#34;sangtrangmoi&#34;></div>', $model->thongtinquyetdinh);
        //dd($model);
        return view('BaoCao.DonVi.XemQuyetDinh')
            ->with('model', $model)
            ->with('pageTitle', 'Tờ trình khen thưởng');
    }

    public function NhanExcel(Request $request)
    {
        $dungchung = new dungchung_nhanexcelController();
        $dungchung->NhanExcelKhenThuong($request);
        return redirect(static::$url . 'Sua?mahosotdkt=' . $request->all()['mahoso']);
    }
}
