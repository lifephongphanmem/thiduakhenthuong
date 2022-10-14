<?php

namespace App\Http\Controllers\NghiepVu\KhenThuongDotXuat;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\DanhMuc\dmdanhhieuthidua;
use App\Model\DanhMuc\dmdanhhieuthidua_tieuchuan;
use App\Model\DanhMuc\dmhinhthuckhenthuong;
use App\Model\DanhMuc\dmloaihinhkhenthuong;
use App\Model\DanhMuc\dmnhomphanloai_chitiet;
use App\Model\DanhMuc\dscumkhoi;
use App\Model\DanhMuc\dsdiaban;
use App\Model\DanhMuc\dsdonvi;
use App\Model\HeThong\trangthaihoso;
use App\Model\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi;
use App\Model\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi_khenthuong;
use App\Model\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi_tieuchuan;
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
use Illuminate\Support\Facades\Session;

class qdhosokhenthuongdotxuatController extends Controller
{
    public static $url = '';
    public function __construct()
    {
        static::$url = '/KhenThuongDotXuat/KhenThuong/';
        $this->middleware(function ($request, $next) {
            if (!Session::has('admin')) {
                return redirect('/');
            };
            return $next($request);
        });
    }
    public function ThongTin(Request $request)
    {
        if (!chkPhanQuyen('qdhosokhenthuongdotxuat', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'qdhosokhenthuongdotxuat')->with('tenphanquyen', 'danhsach');
        }
        $inputs = $request->all();
        $inputs['url_hs'] = '/KhenThuongDotXuat/HoSo/';
        $inputs['url_xd'] = '/KhenThuongDotXuat/XetDuyet/';
        $inputs['url_qd'] = '/KhenThuongDotXuat/KhenThuong/';
        $m_donvi = getDonVi(session('admin')->capdo, 'qdhosokhenthuongdotxuat');
        $m_diaban = dsdiaban::wherein('madiaban', array_column($m_donvi->toarray(), 'madiaban'))->get();

        // $m_donvi = viewdiabandonvi::wherein('madonvi', array_column($m_donvi->toarray(), 'madonviQL'))->get();
        $m_loaihinh = dmloaihinhkhenthuong::all();
        $inputs['nam'] = $inputs['nam'] ?? 'ALL';
        $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;
        $inputs['maloaihinhkt'] = session('chucnang')['qdhosokhenthuongdotxuat']['maloaihinhkt'] ?? 'ALL';
        $inputs['tendvcqhienthi'] = $m_donvi->where('madonvi', $inputs['madonvi'])->first()->tendvcqhienthi;
        $inputs['capdo'] = $m_donvi->where('madonvi', $inputs['madonvi'])->first()->capdo;

        $model = dshosothiduakhenthuong::where('madonvi_kt', $inputs['madonvi'])
            ->wherein('trangthai', ['CXKT', 'DXKT', 'DKT']);


        if ($inputs['maloaihinhkt'] != 'ALL')
            $model = $model->where('maloaihinhkt', $inputs['maloaihinhkt']);

            $inputs['phanloai'] = $inputs['phanloai'] ?? 'ALL';
            if ($inputs['phanloai'] != 'ALL')
                $model = $model->where('phanloai', $inputs['phanloai']);
            $inputs['nam'] = $inputs['nam'] ?? 'ALL';
            if ($inputs['nam'] != 'ALL')
                $model = $model->whereyear('ngayhoso', $inputs['nam']);
            //Lấy hồ sơ
            $model = $model->orderby('ngayhoso')->get();

        foreach ($model as $hoso) {
            $hoso->chinhsua = $hoso->madonvi == $inputs['madonvi'] ? true : false;
            $hoso->soluongkhenthuong = dshosothiduakhenthuong_canhan::where('mahosotdkt', $hoso->mahosotdkt)->where('ketqua', '1')->count()
                + dshosothiduakhenthuong_tapthe::where('mahosotdkt', $hoso->mahosotdkt)->where('ketqua', '1')->count();
            getDonViChuyen($inputs['madonvi'], $hoso);
        }
        //dd($model);
        return view('NghiepVu.KhenThuongDotXuat.QuyetDinh.ThongTin')
            ->with('inputs', $inputs)
            ->with('model', $model)
            ->with('m_donvi', $m_donvi)
            ->with('m_diaban', $m_diaban)
            ->with('a_donvi', array_column(dsdonvi::all()->toArray(), 'tendonvi', 'madonvi'))
            ->with('a_loaihinhkt', array_column($m_loaihinh->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('a_phanloaihs', getPhanLoaiHoSo())
            //->with('a_trangthaihoso', getTrangThaiTDKT())
            //->with('a_phamvi', getPhamViPhongTrao())
            ->with('pageTitle', 'Danh sách hồ sơ trình khen thưởng đột xuất');
    }

    public function LuuHoSo(Request $request)
    {
        if (!chkPhanQuyen('qdhosokhenthuongdotxuat', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'qdhosokhenthuongdotxuat')->with('tenphanquyen', 'thaydoi');
        }
        $inputs = $request->all();
        $model = dshosokhenthuong::where('mahosokt', $inputs['mahosokt'])->first();
        if (isset($inputs['totrinh'])) {
            $filedk = $request->file('totrinh');
            $inputs['totrinh'] = $model->mahosokt . '_' . $filedk->getClientOriginalExtension();
            $filedk->move(public_path() . '/data/totrinh/', $inputs['totrinh']);
        }
        if (isset($inputs['qdkt'])) {
            $filedk = $request->file('qdkt');
            $inputs['qdkt'] = $model->mahosokt . '_' . $filedk->getClientOriginalExtension();
            $filedk->move(public_path() . '/data/qdkt/', $inputs['qdkt']);
        }
        if (isset($inputs['bienban'])) {
            $filedk = $request->file('bienban');
            $inputs['bienban'] = $model->mahosokt . '_' . $filedk->getClientOriginalExtension();
            $filedk->move(public_path() . '/data/bienban/', $inputs['bienban']);
        }
        if (isset($inputs['tailieukhac'])) {
            $filedk = $request->file('tailieukhac');
            $inputs['tailieukhac'] = $model->mahosokt . '_' . $filedk->getClientOriginalExtension();
            $filedk->move(public_path() . '/data/tailieukhac/', $inputs['tailieukhac']);
        }
        $model->update($inputs);
        return redirect('/KhenThuongDotXuat/KhenThuong/ThongTin?madonvi=' . $model->madonvi);
    }

    public function KhenThuong(Request $request)
    {
        if (!chkPhanQuyen('qdhosokhenthuongdotxuat', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'qdhosokhenthuongdotxuat')->with('tenphanquyen', 'thaydoi');
        }
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
        return redirect('/KhenThuongDotXuat/KhenThuong/DanhSach?mahosokt=' . $inputs['mahosokt']);
    }

    public function DanhSach(Request $request)
    {
        if (!chkPhanQuyen('qdhosokhenthuongdotxuat', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'qdhosokhenthuongdotxuat')->with('tenphanquyen', 'thaydoi');
        }
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
        return view('NghiepVu.KhenThuongDotXuat.QuyetDinh.DanhSach')
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
    }
    

    public function HoSo(Request $request)
    {
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
        return redirect('/KhenThuongDotXuat/KhenThuong/DanhSach?mahosokt=' . $inputs['mahosokt']);
    }

    public function KetQua(Request $request)
    {

        $inputs = $request->all();
        $model = dshosokhenthuong_khenthuong::findorfail($inputs['id']);
        $model->ketqua = isset($inputs['dieukien']) ? 1 : 0;
        $model->mahinhthuckt = $inputs['mahinhthuckt'];
        $model->save();
        //dd($inputs);
        return redirect('/KhenThuongDotXuat/KhenThuong/DanhSach?mahosokt=' . $model->mahosokt);
    }

    public function PheDuyet(Request $request)
    {
        if (!chkPhanQuyen('qdhosokhenthuongchuyende', 'hoanthanh')) {
            return view('errors.noperm')
                ->with('machucnang', 'qdhosokhenthuongchuyende')
                ->with('tenphanquyen', 'hoanthanh');
        }
        $inputs = $request->all();
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
        $model->save();
        trangthaihoso::create([
            'mahoso' => $inputs['mahosotdkt'],
            'phanloai' => 'dshosothiduakhenthuong',
            'trangthai' => $model->trangthai,
            'thoigian' => $thoigian,
            'madonvi' => $inputs['madonvi'],
            'thongtin' => 'Phê duyệt đề nghị khen thưởng.',
        ]);
        return redirect(static::$url . 'ThongTin?madonvi=' . $inputs['madonvi']);
    }

    public function HuyPheDuyet(Request $request)
    {
        if (!chkPhanQuyen('qdhosokhenthuongchuyende', 'hoanthanh')) {
            return view('errors.noperm')
                ->with('machucnang', 'qdhosokhenthuongchuyende')
                ->with('tenphanquyen', 'hoanthanh');
        }
        $inputs = $request->all();
        $thoigian = date('Y-m-d H:i:s');
        $trangthai = 'CXKT';
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        setTrangThaiHoSo($inputs['madonvi'], $model, ['thoigian' => $thoigian, 'trangthai' => $trangthai]);
        $model->trangthai = $trangthai; //gán trạng thái hồ sơ để theo dõi
        $model->donvikhenthuong = null;
        $model->capkhenthuong = null;
        $model->soqd = null;
        $model->ngayqd = null;
        $model->chucvunguoikyqd = null;
        $model->hotennguoikyqd = null;
        //dd($model);
        $model->save();
        return redirect(static::$url . 'ThongTin?madonvi=' . $inputs['madonvi']);
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

        $inputs = $request->all();
        $model = dshosokhenthuong::where('mahosokt', $inputs['mahosokt'])->first();
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
        return view('BaoCao.DonVi.QuyetDinh.DotXuat')
            ->with('model', $model)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Quyết định khen thưởng');
    }

    public function XemQuyetDinh(Request $request)
    {

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
    }

    public function MacDinhQuyetDinh(Request $request)
    {

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
    }

    public function LuuQuyetDinh(Request $request)
    {

        $inputs = $request->all();
        //dd($inputs['thongtinquyetdinh']);
        $model = dshosokhenthuong::where('mahosokt', $inputs['mahosokt'])->first();
        $model->thongtinquyetdinh = $inputs['thongtinquyetdinh'];
        $model->save();
        return redirect('/KhenThuongHoSoThiDua/ThongTin');
    }

    public function XemHoSo(Request $request)
    {
        $inputs = $request->all();
        $model =  dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $model_canhan = dshosothiduakhenthuong_canhan::where('mahosotdkt', $model->mahosotdkt)->get();
        $model_tapthe = dshosothiduakhenthuong_tapthe::where('mahosotdkt', $model->mahosotdkt)->get();
        $a_phanloaidt = array_column(dmnhomphanloai_chitiet::all()->toarray(), 'tenphanloai', 'maphanloai');
        $m_donvi = dsdonvi::where('madonvi', $model->madonvi)->first();

        return view('NghiepVu.KhenThuongDoiNgoai.KhenThuong.Xem')
            ->with('model', $model)
            ->with('model_canhan', $model_canhan)
            ->with('model_tapthe', $model_tapthe)
            ->with('m_donvi', $m_donvi)
            ->with('a_phanloaidt', $a_phanloaidt)
            ->with('a_danhhieu', array_column(dmdanhhieuthidua::all()->toArray(), 'tendanhhieutd', 'madanhhieutd'))
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('a_hinhthuckt', array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Thông tin hồ sơ khen thưởng');
    }

    public function InPhoi(Request $request)
    {
        $inputs = $request->all();
        $inputs['url_hs'] = '/KhenThuongChuyenDe/HoSo/';
        $inputs['url_xd'] = '/KhenThuongChuyenDe/XetDuyet/';
        $inputs['url_qd'] = '/KhenThuongChuyenDe/KhenThuong/';
        $model =  dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $model_canhan = dshosothiduakhenthuong_canhan::where('mahosotdkt', $model->mahosotdkt)->get();
        $model_tapthe = dshosothiduakhenthuong_tapthe::where('mahosotdkt', $model->mahosotdkt)->get();
        $m_donvi = dsdonvi::where('madonvi', $model->madonvi)->first();

        return view('NghiepVu._DungChung.InPhoi')
            ->with('model', $model)
            ->with('model_canhan', $model_canhan)
            ->with('model_tapthe', $model_tapthe)
            ->with('m_donvi', $m_donvi)
            ->with('a_danhhieu', array_column(dmdanhhieuthidua::all()->toArray(), 'tendanhhieutd', 'madanhhieutd'))
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('a_hinhthuckt', array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
            ->with('inputs', $inputs)
            ->with('pageTitle', 'In bằng khen');
    }

    public function InBangKhenCaNhan(Request $request)
    {
        $inputs = $request->all();

        $model = dshosothiduakhenthuong_canhan::where('id', $inputs['id'])->get();
        $m_hoso = dshosothiduakhenthuong::where('mahosotdkt', $model->first()->mahosotdkt)->first();
        foreach ($model as $doituong) {
            $doituong->noidungkhenthuong = catchuoi($doituong->noidungkhenthuong);
        }
        //dd($m_hoso);
        return view('BaoCao.DonVi.InBangKhenCaNhan')
            ->with('model', $model)
            ->with('m_hoso', $m_hoso)
            ->with('pageTitle', 'In bằng khen cá nhân');
    }

    public function InBangKhenTapThe(Request $request)
    {
        $inputs = $request->all();

        $model = dshosothiduakhenthuong_tapthe::where('id', $inputs['id'])->get();
        $m_hoso = dshosothiduakhenthuong::where('mahosotdkt', $model->first()->mahosotdkt)->first();
        foreach ($model as $doituong) {
            $doituong->noidungkhenthuong = catchuoi($doituong->noidungkhenthuong);
        }
        //dd($m_hoso);
        return view('BaoCao.DonVi.InBangKhenTapThe')
            ->with('model', $model)
            ->with('m_hoso', $m_hoso)
            ->with('pageTitle', 'In bằng khen tập thể');
    }

    public function InGiayKhenCaNhan(Request $request)
    {
        $inputs = $request->all();

        $model = dshosothiduakhenthuong_canhan::where('id', $inputs['id'])->get();
        $m_hoso = dshosothiduakhenthuong::where('mahosotdkt', $model->first()->mahosotdkt)->first();
        foreach ($model as $doituong) {
            $doituong->noidungkhenthuong = catchuoi($doituong->noidungkhenthuong);
        }
        //dd($m_hoso);
        return view('BaoCao.DonVi.InGiayKhenCaNhan')
            ->with('model', $model)
            ->with('m_hoso', $m_hoso)
            ->with('pageTitle', 'In bằng khen cá nhân');
    }

    public function InGiayKhenTapThe(Request $request)
    {
        $inputs = $request->all();

        $model = dshosothiduakhenthuong_tapthe::where('id', $inputs['id'])->get();
        $m_hoso = dshosothiduakhenthuong::where('mahosotdkt', $model->first()->mahosotdkt)->first();
        foreach ($model as $doituong) {
            $doituong->noidungkhenthuong = catchuoi($doituong->noidungkhenthuong);
        }
        //dd($m_hoso);
        return view('BaoCao.DonVi.InGiayKhenTapThe')
            ->with('model', $model)
            ->with('m_hoso', $m_hoso)
            ->with('pageTitle', 'In bằng khen tập thể');
    }

    public function NoiDungKhenThuong(Request $request)
    {
        $inputs = $request->all();
        
        if ($inputs['phanloai'] == 'CANHAN') {
            $model = dshosothiduakhenthuong_canhan::where('id', $inputs['id'])->first();
            $model->noidungkhenthuong = $inputs['noidungkhenthuong'];
            $model->save();
        } else {
            $model = dshosothiduakhenthuong_tapthe::where('id', $inputs['id'])->first();
            $model->noidungkhenthuong = $inputs['noidungkhenthuong'];
            $model->save();
        }
        //dd($m_hoso);
        return redirect(static::$url . 'InPhoi?mahosotdkt=' . $model->mahosotdkt);
    }
}
