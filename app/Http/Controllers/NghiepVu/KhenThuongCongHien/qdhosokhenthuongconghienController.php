<?php

namespace App\Http\Controllers\NghiepVu\KhenThuongCongHien;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\DanhMuc\dmdanhhieuthidua;
use App\Model\DanhMuc\dmdanhhieuthidua_tieuchuan;
use App\Model\DanhMuc\dmhinhthuckhenthuong;
use App\Model\DanhMuc\dmloaihinhkhenthuong;
use App\Model\DanhMuc\dmnhomphanloai_chitiet;
use App\Model\DanhMuc\dsdiaban;
use App\Model\DanhMuc\dsdonvi;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosokhenthuong;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosokhenthuong_chitiet;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosokhenthuong_khenthuong;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_canhan;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_khenthuong;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_tapthe;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_tieuchuan;
use App\Model\View\view_tdkt_canhan;
use App\Model\View\view_tdkt_tapthe;
use App\Model\View\viewdiabandonvi;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class qdhosokhenthuongconghienController extends Controller
{
    public static $url = '';
    public function __construct()
    {
        static::$url = '/KhenThuongCongHien/KhenThuong/';
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
        $inputs['url'] = static::$url;
        $inputs['url_hs'] = '/KhenThuongCongHien/HoSo/';
        if (!chkPhanQuyen()) {
            return view('errors.noperm');
        }
        $m_donvi = getDonViXetDuyetHoSo(session('admin')->capdo, null, null, 'MODEL');
        $m_diaban = getDiaBanXetDuyetHoSo(session('admin')->capdo, null, null, 'MODEL');
        $m_donvi = viewdiabandonvi::wherein('madonvi', array_column($m_donvi->toarray(), 'madonviQL'))->get();

        $inputs['nam'] = $inputs['nam'] ?? 'ALL';
        $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;
        $inputs['maloaihinhkt'] = session('chucnang')['dshosokhenthuongconghien']['maloaihinhkt'] ?? 'ALL';
        $model = dshosothiduakhenthuong::wherein('mahosotdkt', function ($qr) use ($inputs) {
            $qr->select('mahosotdkt')->from('dshosothiduakhenthuong')
                ->where('madonvi_nhan', $inputs['madonvi'])
                ->orwhere('madonvi_nhan_h', $inputs['madonvi'])
                ->orwhere('madonvi_nhan_t', $inputs['madonvi'])->get();
        })->where('phanloai', 'KHENTHUONG')->wherein('trangthai', ['CXKT', 'DXKT', 'DKT']);

        if ($inputs['maloaihinhkt'] != 'ALL')
            $model = $model->where('maloaihinhkt', $inputs['maloaihinhkt']);

        $model = $model->orderby('ngayhoso')->get();
        // $m_khenthuong = dshosokhenthuong::wherein('mahosotdkt', array_column($model->toarray(), 'mahosotdkt'))->where('trangthai', 'DKT')->get();
        foreach ($model as $hoso) {
            //nếu hồ sơ của đơn vị thì để chỉnh sửa (cho trường hợp tự nhập quyết định khen thưởng)
            $hoso->chinhsua = $hoso->madonvi == $inputs['madonvi'] ? true : false;
            getDonViChuyen($inputs['madonvi'], $hoso);
        }
        if (in_array($inputs['maloaihinhkt'], ['', 'ALL', 'all'])) {
            $m_loaihinh = dmloaihinhkhenthuong::all();
        } else {
            $m_loaihinh = dmloaihinhkhenthuong::where('maloaihinhkt', $inputs['maloaihinhkt'])->get();
        }
        //dd($inputs);
        return view('NghiepVu.KhenThuongCongHien.KhenThuong.ThongTin')
            ->with('inputs', $inputs)
            ->with('model', $model)
            ->with('m_donvi', $m_donvi)
            ->with('m_diaban', $m_diaban)
            ->with('a_donvi', array_column(dsdonvi::all()->toArray(), 'tendonvi', 'madonvi'))
            ->with('a_loaihinhkt', array_column($m_loaihinh->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            //->with('a_trangthaihoso', getTrangThaiTDKT())
            //->with('a_phamvi', getPhamViPhongTrao())
            ->with('pageTitle', 'Danh sách hồ sơ trình khen thưởng');
    }

    public function Sua(Request $request)
    {
        if (Session::has('admin')) {
            if (!chkPhanQuyen()) {
                return view('errors.noperm');
            }
            $inputs = $request->all();
            $inputs['url'] = static::$url;
            $inputs['url_hs'] = '/KhenThuongCongHien/HoSo/';
            $inputs['mahinhthuckt'] = session('chucnang')['dshosokhenthuongconghien']['mahinhthuckt'] ?? 'ALL';
            $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
            $model_canhan = dshosothiduakhenthuong_canhan::where('mahosotdkt', $inputs['mahosotdkt'])->get();
            $model_tapthe = dshosothiduakhenthuong_tapthe::where('mahosotdkt', $inputs['mahosotdkt'])->get();
            $model->tendonvi = getThongTinDonVi($model->madonvi, 'tendonvi');
            $m_donvi = getDonVi(session('admin')->capdo);
            $m_diaban = dsdiaban::wherein('madiaban', array_column($m_donvi->toarray(), 'madiaban'))->get();
            $m_danhhieu = dmdanhhieuthidua::all();
            $m_canhan = getDoiTuongKhenThuong($model->madonvi);
            $m_tapthe = getTapTheKhenThuong($model->madonvi);
            $a_tapthe = array_column(dmnhomphanloai_chitiet::wherein('manhomphanloai', ['TAPTHE', 'HOGIADINH'])->get()->toarray(), 'tenphanloai', 'maphanloai');
            $a_canhan = array_column(dmnhomphanloai_chitiet::wherein('manhomphanloai', ['CANHAN'])->get()->toarray(), 'tenphanloai', 'maphanloai');
            return view('NghiepVu.KhenThuongCongHien.KhenThuong.Sua')
                ->with('model', $model)
                ->with('model_canhan', $model_canhan)
                ->with('model_tapthe', $model_tapthe)
                ->with('m_donvi', $m_donvi)
                ->with('m_diaban', $m_diaban)
                ->with('m_canhan', $m_canhan)
                ->with('m_tapthe', $m_tapthe)
                ->with('a_danhhieu', array_column($m_danhhieu->toArray(), 'tendanhhieutd', 'madanhhieutd'))
                ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
                ->with('a_hinhthuckt', array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
                ->with('a_danhhieutd', array_column(dmdanhhieuthidua::all()->toArray(), 'tendanhhieutd', 'madanhhieutd'))
                ->with('a_tapthe', $a_tapthe)
                ->with('a_canhan', $a_canhan)
                ->with('inputs', $inputs)
                ->with('pageTitle', 'Thông tin hồ sơ đề nghị khen thưởng');
        } else
            return view('errors.notlogin');
    }

    public function LuuHoSo(Request $request)
    {
        if (Session::has('admin')) {
            $inputs = $request->all();            
            $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
            if (isset($inputs['totrinh'])) {
                $filedk = $request->file('totrinh');
                $inputs['totrinh'] = $model->mahosotdkt . '_' . $filedk->getClientOriginalExtension();
                $filedk->move(public_path() . '/data/totrinh/', $inputs['totrinh']);
            }
            if (isset($inputs['qdkt'])) {
                $filedk = $request->file('qdkt');
                $inputs['qdkt'] = $model->mahosotdkt . '_' . $filedk->getClientOriginalExtension();
                $filedk->move(public_path() . '/data/qdkt/', $inputs['qdkt']);
            }
            if (isset($inputs['bienban'])) {
                $filedk = $request->file('bienban');
                $inputs['bienban'] = $model->mahosotdkt . '_' . $filedk->getClientOriginalExtension();
                $filedk->move(public_path() . '/data/bienban/', $inputs['bienban']);
            }
            if (isset($inputs['tailieukhac'])) {
                $filedk = $request->file('tailieukhac');
                $inputs['tailieukhac'] = $model->mahosotdkt . '_' . $filedk->getClientOriginalExtension();
                $filedk->move(public_path() . '/data/tailieukhac/', $inputs['tailieukhac']);
            }
            $model->update($inputs);
            return redirect(static::$url.'ThongTin?madonvi=' . $model->madonvi);
        } else
            return view('errors.notlogin');
    }

    public function KhenThuong(Request $request)
    {
        if (Session::has('admin')) {
            $inputs = $request->all();
            $chk = dshosokhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])
                ->where('madonvi', $inputs['madonvi'])->first();

            if ($chk == null) {
                $inputs['mahosokt'] = (string)getdate()[0];
                $khenthuong = new dshosokhenthuong_chitiet();
                $khenthuong->mahosokt = $inputs['mahosokt'];
                $khenthuong->mahosotdkt = $inputs['mahosotdkt'];
                $khenthuong->ketqua = 0;
                $khenthuong->madonvi = $inputs['madonvi'];
                $khenthuong->save();

                dshosokhenthuong::create($inputs);
                $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
                $model->mahosokt = $inputs['mahosokt'];
                $thoigian = date('Y-m-d H:i:s');
                setTrangThaiHoSo($inputs['madonvi'], $model, ['madonvi' => $inputs['madonvi'], 'thoigian' => $thoigian, 'trangthai' => 'DXKT']);
                setTrangThaiHoSo($model->madonvi, $model, ['trangthai' => 'DXKT']);
                $model->save();
            }
            return redirect('/KhenThuongCongTrang/KhenThuong/DanhSach?mahosokt=' . $inputs['mahosokt']);
        } else
            return view('errors.notlogin');
    }

    public function DanhSach(Request $request)
    {
        if (Session::has('admin')) {
            $inputs = $request->all();
            $model =  dshosokhenthuong::where('mahosokt', $inputs['mahosokt'])->first();
            $m_chitiet = dshosokhenthuong_chitiet::where('mahosokt', $model->mahosokt)->get();
            $m_hosokt = dshosothiduakhenthuong::where('mahosotdkt',  $model->mahosotdkt)->get();
            foreach ($m_chitiet as $chitiet) {
                $chitiet->madonvi_kt = $m_hosokt->first()->madonvi;
            }
            $m_khenthuong = dshosokhenthuong_khenthuong::where('mahosokt',  $model->mahosokt)->get();
            foreach ($m_khenthuong as $chitiet) {
                $chitiet->madonvi_kt = $m_hosokt->first()->madonvi;
            }
            $m_danhhieu = dmdanhhieuthidua::all();
            $m_donvi = dsdonvi::all();
            $m_diaban = dsdiaban::all();
            //dd($model);
            return view('NghiepVu.KhenThuongCongTrang.QuyetDinhKhenThuong.DanhSach')
                ->with('model', $model)
                ->with('m_chitiet', $m_chitiet)
                ->with('m_danhhieu', $m_danhhieu)
                ->with('m_donvi', $m_donvi)
                ->with('m_diaban', $m_diaban)
                ->with('model_canhan', $m_khenthuong->where('phanloai', 'CANHAN'))
                ->with('model_tapthe', $m_khenthuong->where('phanloai', 'TAPTHE'))
                ->with('a_hinhthuckt', array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
                ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
                ->with('a_donvi', array_column(viewdiabandonvi::all()->toArray(), 'tendonvi', 'madonvi'))
                ->with('a_danhhieu', array_column($m_danhhieu->toArray(), 'tendanhhieutd', 'madanhhieutd'))
                ->with('inputs', $inputs)
                ->with('pageTitle', 'Thông tin hồ sơ khen thưởng');
        } else
            return view('errors.notlogin');
    }

    public function XemHoSo(Request $request)
    {
        if (Session::has('admin')) {
            $inputs = $request->all();
            $model =  dshosokhenthuong::where('mahosokt', $inputs['mahosokt'])->first();
            $m_chitiet = dshosokhenthuong_chitiet::where('mahosokt', $model->mahosokt)->get();
            $m_hosokt = dshosothiduakhenthuong::where('mahosotdkt',  $model->mahosotdkt)->get();
            foreach ($m_chitiet as $chitiet) {
                $chitiet->madonvi_kt = $m_hosokt->first()->madonvi;
            }
            $m_khenthuong = dshosokhenthuong_khenthuong::where('mahosokt',  $model->mahosokt)->get();
            foreach ($m_khenthuong as $chitiet) {
                $chitiet->madonvi_kt = $m_hosokt->first()->madonvi;
            }
            $m_danhhieu = dmdanhhieuthidua::all();
            $m_donvi = dsdonvi::all();
            $m_diaban = dsdiaban::all();
            //dd($model);
            return view('NghiepVu.KhenThuongCongTrang.QuyetDinhKhenThuong.Xem')
                ->with('model', $model)
                ->with('m_chitiet', $m_chitiet)
                ->with('m_danhhieu', $m_danhhieu)
                ->with('m_donvi', $m_donvi)
                ->with('m_diaban', $m_diaban)
                ->with('model_canhan', $m_khenthuong->where('phanloai', 'CANHAN'))
                ->with('model_tapthe', $m_khenthuong->where('phanloai', 'TAPTHE'))
                ->with('a_hinhthuckt', array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
                ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
                ->with('a_donvi', array_column(viewdiabandonvi::all()->toArray(), 'tendonvi', 'madonvi'))
                ->with('a_danhhieu', array_column($m_danhhieu->toArray(), 'tendanhhieutd', 'madanhhieutd'))
                ->with('inputs', $inputs)
                ->with('pageTitle', 'Thông tin hồ sơ khen thưởng');
        } else
            return view('errors.notlogin');
    }

    public function HoSo(Request $request)
    {
        if (Session::has('admin')) {
            $inputs = $request->all();
            $m_chitiet = dshosokhenthuong_chitiet::where('mahosokt', $inputs['mahosokt'])->where('mahosotdkt', $inputs['mahosotdkt'])->first();
            if ($inputs['khenthuong'] == 0) {
                dshosokhenthuong_khenthuong::where('mahosokt', $inputs['mahosokt'])->where('mahosotdkt', $inputs['mahosotdkt'])->delete();
            }
            if ($inputs['khenthuong'] == 1 && $m_chitiet->ketqua == 0) {
                $m_hosotdkt = dshosothiduakhenthuong_khenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->get();
                $a_khenthuong = [];
                foreach ($m_hosotdkt as $khenthuong) {
                    $a_khenthuong[] = [
                        'mahosokt' => $inputs['mahosokt'],
                        'mahosotdkt' => $inputs['mahosotdkt'],
                        'madanhhieutd' => $khenthuong->madanhhieutd,
                        'noidungkhenthuong' => '',
                        'phanloai' => $khenthuong->phanloai,
                        //Thông tin cá nhân 
                        'madoituong' => $khenthuong->madoituong,
                        'maccvc' => $khenthuong->maccvc,
                        'tendoituong' => $khenthuong->tendoituong,
                        'ngaysinh' => $khenthuong->ngaysinh,
                        'gioitinh' => $khenthuong->gioitinh,
                        'chucvu' => $khenthuong->chucvu,
                        'lanhdao' => $khenthuong->lanhdao,
                        //Thông tin tập thể
                        'matapthe' => $khenthuong->matapthe,
                        'tentapthe' => $khenthuong->tentapthe,
                        //Kết quả đánh giá
                        'ketqua' => '1',
                        'mahinhthuckt' => $khenthuong->mahinhthuckt,
                    ];
                }
                //dd($a_khenthuong);
                dshosokhenthuong_khenthuong::insert($a_khenthuong);
            }
            $m_chitiet->ketqua = $inputs['khenthuong'];
            $m_chitiet->save();
            //dd($inputs);
            return redirect('/KhenThuongCongTrang/KhenThuong/DanhSach?mahosokt=' . $inputs['mahosokt']);
        } else
            return view('errors.notlogin');
    }

    public function KetQua(Request $request)
    {
        if (Session::has('admin')) {
            $inputs = $request->all();
            $model = dshosokhenthuong_khenthuong::findorfail($inputs['id']);
            $model->ketqua = isset($inputs['dieukien']) ? 1 : 0;
            $model->mahinhthuckt = $inputs['mahinhthuckt'];
            $model->save();
            //dd($inputs);
            return redirect('/KhenThuongCongTrang/KhenThuong/DanhSach?mahosokt=' . $model->mahosokt);
        } else
            return view('errors.notlogin');
    }

    public function PheDuyet(Request $request)
    {
        if (Session::has('admin')) {
            $inputs = $request->all();
            $model = dshosokhenthuong::where('mahosokt', $inputs['mahosokt'])->first();
            $donvi = viewdiabandonvi::where('madonvi', $model->madonvi)->first();
            $model->trangthai = 'DKT';
            $model_chitiet = dshosokhenthuong_chitiet::where('mahosokt', $inputs['mahosokt'])->get();
            $m_hosokt = dshosothiduakhenthuong::wherein('mahosotdkt', array_column($model_chitiet->toarray(), 'mahosotdkt'))->get();
            foreach ($m_hosokt as $hoso) {
                $hoso->trangthai = $model->trangthai;
                //khen thương cấp nào thì lưu cấp đó để sau còn thống kê khen thưởng ở các cấp
                setChuyenHoSo($donvi->capdo, $hoso, ['trangthai' => $model->trangthai]);
                //setNhanHoSo();
                $hoso->save();
            }
            $model->save();
            return redirect('/KhenThuongCongTrang/KhenThuong/ThongTin?madonvi=' . $model->madonvi);
        } else
            return view('errors.notlogin');
    }

    public function LayDoiTuong(Request $request)
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
        $m_doituong = dshosokhenthuong_khenthuong::findorfail($inputs['id']);
        $model = dshosothiduakhenthuong_khenthuong::where('madoituong', $m_doituong->madoituong)
            ->where('mahosotdkt', $m_doituong->mahosotdkt)->first();

        die(json_encode($model));
    }

    public function LayTieuChuan(Request $request)
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
        //dd($request);
        $inputs = $request->all();
        //$m_danhhieu = dmdanhhieuthidua::where('madanhhieutd', $inputs['madanhhieutd'])->first();
        //Chưa tối ưu và tìm kiếm trùng đối tượng
        $m_doituong = dshosokhenthuong_khenthuong::findorfail($inputs['id']);
        //dd($m_doituong);
        $model = dshosothiduakhenthuong_tieuchuan::where('madoituong', $m_doituong->madoituong)
            ->where('madanhhieutd', $m_doituong->madanhhieutd)
            ->where('mahosotdkt', $m_doituong->mahosotdkt)->get();

        $model_tieuchuan = dmdanhhieuthidua_tieuchuan::where('madanhhieutd', $m_doituong->madanhhieutd)->get();

        if (isset($model_tieuchuan)) {

            $result['message'] = '<div class="row" id="dstieuchuan">';

            $result['message'] .= '<div class="col-md-12">';
            $result['message'] .= '<table id="sample_4" class="table table-striped table-bordered table-hover" >';
            $result['message'] .= '<thead>';
            $result['message'] .= '<tr>';
            $result['message'] .= '<th width="2%" style="text-align: center">STT</th>';
            $result['message'] .= '<th style="text-align: center">Tên tiêu chuẩn</th>';
            $result['message'] .= '<th style="text-align: center" width="15%">Bắt buộc</th>';
            $result['message'] .= '<th style="text-align: center" width="15%">Đạt điều kiên</th>';
            $result['message'] .= '<th style="text-align: center" width="10%">Thao tác</th>';
            $result['message'] .= '</tr>';
            $result['message'] .= '</thead>';

            $result['message'] .= '<tbody>';
            $key = 1;
            foreach ($model_tieuchuan as $ct) {
                $ct->dieukien = $model->where('matieuchuandhtd', $ct->matieuchuandhtd)->first()->dieukien ?? 0;
                $result['message'] .= '<tr>';
                $result['message'] .= '<td style="text-align: center">' . $key++ . '</td>';
                $result['message'] .= '<td>' . $ct->tentieuchuandhtd . '</td>';
                $result['message'] .= '<td style="text-align: center">' . $ct->batbuoc . '</td>';
                $result['message'] .= '<td style="text-align: center">' . $ct->dieukien . '</td>';
                $result['message'] .= '<td></td>';
                $result['message'] .= '</tr>';
            }
            $result['message'] .= '</tbody>';
            $result['message'] .= '</table>';
            $result['message'] .= '</div>';
            $result['message'] .= '</div>';
            $result['status'] = 'success';
        }
        die(json_encode($result));
    }

    public function QuyetDinh(Request $request)
    {
        if (Session::has('admin')) {
            $inputs = $request->all();
            $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
            if ($model->thongtinquyetdinh == '') {
                $thongtinquyetdinh = getQuyetDinhCKE('QUYETDINH');
                //noidung
                $thongtinquyetdinh = str_replace('<h4 style=&#34;text-align:center;&#34;>[noidung]</h4>', '<h4 style=&#34;text-align:center;&#34;>' . $model->noidung . '</h4>', $thongtinquyetdinh);
                //chucvunguoiky
                $thongtinquyetdinh = str_replace('<p style=&#34;text-align:center;&#34;><strong>[chucvunguoiky]</strong></p>', '<p style=&#34;text-align:center;&#34;><strong>' . $model->chucvunguoiky . '</strong></p>', $thongtinquyetdinh);
                //hotennguoiky
                $thongtinquyetdinh = str_replace('<p style=&#34;text-align:center;&#34;><strong>[hotennguoiky]</strong></p>', '<p style=&#34;text-align:center;&#34;><strong>' . $model->hotennguoiky . '</strong></p>', $thongtinquyetdinh);
                $a_donvi = array_column(dsdonvi::all()->toArray(), 'tendonvi', 'madonvi');
                // $m_canhan = dshosokhenthuong_khenthuong::where('mahosokt',$model->mahosokt)->get();
                $m_canhan = view_tdkt_canhan::where('mahosokt', $model->mahosokt)->get();
                if ($m_canhan->count() > 0) {
                    $s_canhan = '';
                    $i = 1;
                    foreach ($m_canhan as $canhan) {
                        $s_canhan .= '<p style=&#34;margin-left:40px;&#34;>' .
                            ($i++) . '. ' . $canhan->tendoituong .
                            ($canhan->chucvu == '' ? '' : ('; ' . $canhan->chucvu)) .
                            ($canhan->madonvi == '' ? '' : ('; ' . ($a_donvi[$canhan->madonvi] ?? ''))) .
                            '</p>';
                        //dd($s_canhan);
                    }
                    $thongtinquyetdinh = str_replace('<p style=&#34;margin-left:25px;&#34;>[khenthuongcanhan]</p>',  $s_canhan, $thongtinquyetdinh);
                }
                //Tập thể
                $m_tapthe = view_tdkt_tapthe::where('mahosokt', $model->mahosokt)->get();
                if ($m_tapthe->count() > 0) {
                }
                $model->thongtinquyetdinh = $thongtinquyetdinh;
            }
            //dd($model);
            return view('BaoCao.DonVi.QuyetDinh.CongHien')
                ->with('model', $model)
                ->with('inputs', $inputs)
                ->with('pageTitle', 'Quyết định khen thưởng');
        } else
            return view('errors.notlogin');
    }

    public function XemQuyetDinh(Request $request)
    {
        if (Session::has('admin')) {
            $inputs = $request->all();
            $model = dshosokhenthuong::where('mahosokt', $inputs['mahosokt'])->first();
            if ($model->thongtinquyetdinh == '') {
                $model->thongtinquyetdinh = getQuyetDinhCKE('QUYETDINH');
            }
            $model->thongtinquyetdinh = str_replace('<p>[sangtrangmoi]</p>', '<div class=&#34;sangtrangmoi&#34;></div>', $model->thongtinquyetdinh);
            //dd($model);
            return view('BaoCao.DonVi.XemQuyetDinh')
                ->with('model', $model)
                ->with('pageTitle', 'Quyết định khen thưởng');
        } else
            return view('errors.notlogin');
    }

    public function MacDinhQuyetDinh(Request $request)
    {
        if (Session::has('admin')) {
            $inputs = $request->all();
            $model = dshosokhenthuong::where('mahosokt', $inputs['mahosokt'])->first();
            $thongtinquyetdinh = getQuyetDinhCKE('QUYETDINH');
            //noidung
            $thongtinquyetdinh = str_replace('<h4 style=&#34;text-align:center;&#34;>[noidung]</h4>', '<h4 style=&#34;text-align:center;&#34;>' . $model->noidung . '</h4>', $thongtinquyetdinh);
            //chucvunguoiky
            $thongtinquyetdinh = str_replace('<p style=&#34;text-align:center;&#34;><strong>[chucvunguoiky]</strong></p>', '<p style=&#34;text-align:center;&#34;><strong>' . $model->chucvunguoiky . '</strong></p>', $thongtinquyetdinh);
            //hotennguoiky
            $thongtinquyetdinh = str_replace('<p style=&#34;text-align:center;&#34;><strong>[hotennguoiky]</strong></p>', '<p style=&#34;text-align:center;&#34;><strong>' . $model->hotennguoiky . '</strong></p>', $thongtinquyetdinh);
            $a_donvi = array_column(dsdonvi::all()->toArray(), 'tendonvi', 'madonvi');
            // $m_canhan = dshosokhenthuong_khenthuong::where('mahosokt',$model->mahosokt)->get();
            $m_canhan = view_tdkt_canhan::where('mahosokt', $model->mahosokt)->get();
            if ($m_canhan->count() > 0) {
                $s_canhan = '';
                $i = 1;
                foreach ($m_canhan as $canhan) {
                    $s_canhan .= '<p style=&#34;margin-left:40px;&#34;>' .
                        ($i++) . '. ' . $canhan->tendoituong .
                        ($canhan->chucvu == '' ? '' : ('; ' . $canhan->chucvu)) .
                        ($canhan->madonvi == '' ? '' : ('; ' . ($a_donvi[$canhan->madonvi] ?? ''))) .
                        '</p>';
                    //dd($s_canhan);
                }
                $thongtinquyetdinh = str_replace('<p style=&#34;margin-left:25px;&#34;>[khenthuongcanhan]</p>',  $s_canhan, $thongtinquyetdinh);
            }
            //Tập thể
            $m_tapthe = view_tdkt_tapthe::where('mahosokt', $model->mahosokt)->get();
            if ($m_tapthe->count() > 0) {
            }


            $model->thongtinquyetdinh = $thongtinquyetdinh;
            //dd($model);
            return view('BaoCao.DonVi.QuyetDinh.DotXuat')
                ->with('model', $model)
                ->with('pageTitle', 'Quyết định khen thưởng đột xuất');
        } else
            return view('errors.notlogin');
    }

    public function LuuQuyetDinh(Request $request)
    {
        if (Session::has('admin')) {
            $inputs = $request->all();
            //dd($inputs['thongtinquyetdinh']);
            $model = dshosokhenthuong::where('mahosokt', $inputs['mahosokt'])->first();
            $model->thongtinquyetdinh = $inputs['thongtinquyetdinh'];
            $model->save();
            return redirect('/KhenThuongHoSoThiDua/ThongTin');
        } else
            return view('errors.notlogin');
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
            dshosothiduakhenthuong_canhan::create($inputs);
        } else
            $model->update($inputs);
        // return response()->json($inputs['id']);

        $model = dshosothiduakhenthuong_canhan::where('mahosotdkt', $inputs['mahosotdkt'])->get();


        $this->htmlCaNhan($result, $model);
        return response()->json($result);
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

        $m_tapthe = dshosothiduakhenthuong_canhan::where('mahosotdkt', $model->mahosotdkt)->get();
        $this->htmlCaNhan($result, $m_tapthe);
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
                'mahinhthuckt' => $data[$i][$inputs['mahinhthuckt']] ?? $inputs['mahinhthuckt_md'],
                'maphanloaicanbo' => $data[$i][$inputs['maphanloaicanbo']] ?? $inputs['maphanloaicanbo_md'],
                'madanhhieutd' => $data[$i][$inputs['madanhhieutd']] ?? $inputs['madanhhieutd_md'],
                "gioitinh" => $data[$i][$inputs['madanhhieutd']] ?? 'NAM',
                'ngaysinh' => $data[$i][$inputs['ngaysinh']] ?? null,
                'chucvu' => $data[$i][$inputs['chucvu']] ?? '',
                'tenphongban' => $data[$i][$inputs['tenphongban']] ?? '',
                'tencoquan' => $data[$i][$inputs['tencoquan']] ?? '',
                'ketqua' => '1',
            );
        }

        dshosothiduakhenthuong_canhan::insert($a_dm);
        File::Delete($path);

        return redirect(static::$url . 'Sua?mahosotdkt=' . $inputs['mahosotdkt']);
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
            dshosothiduakhenthuong_tapthe::create($inputs);
        } else
            $model->update($inputs);
        // return response()->json($inputs['id']);

        $model = dshosothiduakhenthuong_tapthe::where('mahosotdkt', $inputs['mahosotdkt'])->get();


        $this->htmlTapThe($result, $model);
        return response()->json($result);
        //return die(json_encode($result));
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
                'mahinhthuckt' => $data[$i][$inputs['mahinhthuckt']] ?? $inputs['mahinhthuckt_md'],
                'maphanloaitapthe' => $data[$i][$inputs['maphanloaitapthe']] ?? $inputs['maphanloaitapthe_md'],
                'madanhhieutd' => $data[$i][$inputs['madanhhieutd']] ?? $inputs['madanhhieutd_md'],
                'ketqua' => '1',
            );
        }
        dshosothiduakhenthuong_tapthe::insert($a_dm);
        File::Delete($path);

        return redirect(static::$url . 'Sua?mahosotdkt=' . $inputs['mahosotdkt']);
    }

    function htmlTapThe(&$result, $model)
    {
        if (isset($model)) {
            $a_hinhthuckt = array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt');
            $a_danhhieutd = array_column(dmdanhhieuthidua::all()->toArray(), 'tendanhhieutd', 'madanhhieutd');
            $a_tapthe = array_column(dmnhomphanloai_chitiet::all()->toarray(), 'tenphanloai', 'maphanloai');

            $result['message'] = '<div class="row" id="dskhenthuongtapthe">';
            $result['message'] .= '<div class="col-md-12">';
            $result['message'] .= '<table id="sample_4" class="table table-striped table-bordered table-hover">';
            $result['message'] .= '<thead>';
            $result['message'] .= '<tr class="text-center">';
            $result['message'] .= '<th width="5%">STT</th>';
            $result['message'] .= '<th>Tên tập thể</th>';
            $result['message'] .= '<th>Phân loại<br>tập thể</th>';
            $result['message'] .= '<th>Hình thức<br>khen thưởng</th>';
            $result['message'] .= '<th>Danh hiệu<br>thi đua</th>';
            $result['message'] .= '<th>Kết quả<br>khen thưởng</th>';
            $result['message'] .= '<th width="15%">Thao tác</th>';
            $result['message'] .= '</tr>';
            $result['message'] .= '</thead>';
            $result['message'] .= '<tbody>';
            $i = 1;
            foreach ($model as $tt) {
                $result['message'] .= '<tr class="odd gradeX">';
                $result['message'] .= '<td class="text-center">' . $i++ . '</td>';
                $result['message'] .= '<td>' . $tt->tentapthe . '</td>';
                $result['message'] .= '<td>' . ($a_tapthe[$tt->maphanloaitapthe] ?? '') . '</td>';
                $result['message'] .= '<td class="text-center">' . ($a_hinhthuckt[$tt->mahinhthuckt] ?? '') . '</td>';
                $result['message'] .= '<td class="text-center">' . ($a_danhhieutd[$tt->madanhhieutd] ?? '') . '</td>';
                if ($tt->ketqua == '1')
                    $result['message'] .= '<td class="text-center"><button class="btn btn-sm btn-clean btn-icon">
                    <i class="icon-lg la fa-check text-primary icon-2x"></i></button></td>';
                else
                    $result['message'] .= '<td class="text-center"><button class="btn btn-sm btn-clean btn-icon">
                    <i class="icon-lg la fa-times-circle text-danger icon-2x"></i></button></td>';
                $result['message'] .= '<td class="text-center"><button title="Sửa thông tin" type="button" onclick="getTapThe(' . $tt->id . ')"  class="btn btn-sm btn-clean btn-icon"
                                                                    data-target="#modal-create-tapthe" data-toggle="modal"><i class="icon-lg la fa-edit text-primary icon-2x"></i></button>';
                $result['message'] .= '<button title="Xóa" type="button" onclick="delKhenThuong(' . $tt->id . ', &#39;/KhenThuongCongHien/HoSo/XoaTapThe&#39;, &#39;TAPTHE&#39;)" class="btn btn-sm btn-clean btn-icon" data-target="#modal-delete-khenthuong" data-toggle="modal">
                                                                    <i class="icon-lg la fa-trash text-danger icon-2x"></i></button>';

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
            $a_hinhthuckt = array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt');
            $a_danhhieutd = array_column(dmdanhhieuthidua::all()->toArray(), 'tendanhhieutd', 'madanhhieutd');
            $a_tapthe = array_column(dmnhomphanloai_chitiet::all()->toarray(), 'tenphanloai', 'maphanloai');

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
            $result['message'] .= '<th>Hình thức<br>khen thưởng</th>';
            $result['message'] .= '<th>Danh hiệu<br>thi đua</th>';
            $result['message'] .= '<th>Kết quả<br>khen thưởng</th>';
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
                $result['message'] .= '<td class="text-center"> ' . ($a_hinhthuckt[$tt->mahinhthuckt] ?? '') . '</td>';
                $result['message'] .= '<td class="text-center"> ' . ($a_danhhieutd[$tt->madanhhieutd] ?? '') . '</td>';
                if ($tt->ketqua == '1')
                    $result['message'] .= '<td class="text-center"><button class="btn btn-sm btn-clean btn-icon">
                <i class="icon-lg la fa-check text-primary icon-2x"></i></button></td>';
                else
                    $result['message'] .= '<td class="text-center"><button class="btn btn-sm btn-clean btn-icon">
                <i class="icon-lg la fa-times-circle text-danger icon-2x"></i></button></td>';
                $result['message'] .= '<td class="text-center"><button title="Sửa thông tin" type="button" onclick="getCaNhan(' . $tt->id . ')"  class="btn btn-sm btn-clean btn-icon"
                                                                    data-target="#modal-create" data-toggle="modal"><i class="icon-lg la fa-edit text-primary icon-2x"></i></button>';
                $result['message'] .= '<button title="Xóa" type="button" onclick="delKhenThuong(' . $tt->id . ', &#39;/KhenThuongCongHien/HoSo/XoaCaNhan&#39;, &#39;CANHAN&#39;)" class="btn btn-sm btn-clean btn-icon" data-target="#modal-delete-khenthuong" data-toggle="modal">
                                                                    <i class="icon-lg la fa-trash text-danger icon-2x"></i></button>';

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
}
