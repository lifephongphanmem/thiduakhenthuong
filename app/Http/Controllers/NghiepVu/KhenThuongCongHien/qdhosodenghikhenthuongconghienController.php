<?php

namespace App\Http\Controllers\NghiepVu\KhenThuongCongHien;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\NghiepVu\_DungChung\dungchung_nghiepvu_tailieuController;
use App\Http\Controllers\NghiepVu\_DungChung\dungchung_nghiepvuController;
use App\Model\DanhMuc\dmdanhhieuthidua;
use App\Model\DanhMuc\dmhinhthuckhenthuong;
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
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_tailieu;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_tapthe;
use App\Model\View\viewdiabandonvi;
use Illuminate\Support\Facades\Session;

class qdhosodenghikhenthuongconghienController extends Controller
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
        if (!chkPhanQuyen('qdhosodenghikhenthuongconghien', 'danhsach')) {
            return view('errors.noperm')
                ->with('machucnang', 'qdhosodenghikhenthuongconghien')
                ->with('tenphanquyen', 'danhsach');
        }

        $inputs = $request->all();
        $inputs['url_hs'] = '/KhenThuongCongHien/HoSo/';
        $inputs['url_xd'] = '/KhenThuongCongHien/XetDuyet/';
        $inputs['url_qd'] = '/KhenThuongCongHien/KhenThuong/';
        $inputs['phanloaikhenthuong'] = 'KHENTHUONG';
        $inputs['trangthaihoso'] = $inputs['trangthaihoso'] ?? 'ALL';
        $inputs['phanloaihoso'] = 'dshosothiduakhenthuong';

        $m_donvi = getDonVi(session('admin')->capdo, 'qdhosodenghikhenthuongconghien');
        $m_diaban = dsdiaban::wherein('madiaban', array_column($m_donvi->toarray(), 'madiaban'))->get();

        $inputs['nam'] = $inputs['nam'] ?? 'ALL';
        $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;
        $inputs['capdo'] = $m_donvi->where('madonvi', $inputs['madonvi'])->first()->capdo;
        $inputs['tendvcqhienthi'] = $m_donvi->where('madonvi', $inputs['madonvi'])->first()->tendvcqhienthi;
        $inputs['maloaihinhkt'] = session('chucnang')['qdhosodenghikhenthuongconghien']['maloaihinhkt'] ?? 'ALL';

        $model = dshosothiduakhenthuong::where('madonvi_kt', $inputs['madonvi'])
            ->wherein('phanloai', ['KHENTHUONG', 'KTNGANH','KHENCAOTHUTUONG' ,'KHENCAOCHUTICHNUOC',])
            ->wherein('trangthai', ['CXKT', 'DXKT', 'DKT']);

        if ($inputs['maloaihinhkt'] != 'ALL')
            $model = $model->where('maloaihinhkt', $inputs['maloaihinhkt']);

        $inputs['phanloai'] = $inputs['phanloai'] ?? 'ALL';
        if ($inputs['phanloai'] != 'ALL')
            $model = $model->where('phanloai', $inputs['phanloai']);

        $inputs['nam'] = $inputs['nam'] ?? 'ALL';
        if ($inputs['nam'] != 'ALL')
            $model = $model->whereyear('ngayhoso', $inputs['nam']);

        //Lọc trạng thái (do đã chuyển trạng thái trong quá trình phê duyệt hồ sơ)
        if ($inputs['trangthaihoso'] != 'ALL')
            $model = $model->where('trangthai', $inputs['trangthaihoso']);
        //Lấy hồ sơ
        $model = $model->orderby('ngayhoso')->get();
        // $m_khenthuong = dshosokhenthuong::wherein('mahosotdkt', array_column($model->toarray(), 'mahosotdkt'))->where('trangthai', 'DKT')->get();
        $a_donvilocdulieu = getDiaBanCumKhoi(session('admin')->tendangnhap);
        foreach ($model as $key => $hoso) {
            if (count($a_donvilocdulieu) > 0) {
                //lọc các hồ sơ theo thiết lập dữ liệu
                if (!in_array($hoso->madonvi, $a_donvilocdulieu))
                    $model->forget($key);
            }
            //nếu hồ sơ của đơn vị thì để chỉnh sửa (cho trường hợp tự nhập quyết định khen thưởng)
            $hoso->chinhsua = $hoso->madonvi == $inputs['madonvi'] ? true : false;
            $hoso->soluongkhenthuong = dshosothiduakhenthuong_canhan::where('mahosotdkt', $hoso->mahosotdkt)->where('ketqua', '1')->count()
                + dshosothiduakhenthuong_tapthe::where('mahosotdkt', $hoso->mahosotdkt)->where('ketqua', '1')->count();
            getDonViChuyen($inputs['madonvi'], $hoso);
        }
        if (in_array($inputs['maloaihinhkt'], ['', 'ALL', 'all'])) {
            $m_loaihinh = dmloaihinhkhenthuong::all();
        } else {
            $m_loaihinh = dmloaihinhkhenthuong::where('maloaihinhkt', $inputs['maloaihinhkt'])->get();
        }
        $inputs['trangthai'] = session('chucnang')['qdhosodenghikhenthuongconghien']['trangthai'] ?? 'CC';
        //dd($inputs);
        return view('NghiepVu.KhenThuongCongHien.KhenThuong.ThongTin')
            ->with('inputs', $inputs)
            ->with('model', $model)
            ->with('m_donvi', $m_donvi)
            ->with('m_diaban', $m_diaban)
            ->with('a_donvi', array_column(dsdonvi::all()->toArray(), 'tendonvi', 'madonvi'))
            ->with('a_loaihinhkt', array_column($m_loaihinh->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('a_phanloaihs', getPhanLoaiHoSo('KHENTHUONG'))
            //->with('a_trangthaihoso', getTrangThaiTDKT())
            //->with('a_phamvi', getPhamViPhongTrao())
            ->with('pageTitle', 'Danh sách hồ sơ trình khen thưởng');
    }

    public function PheDuyet(Request $request)
    {
        $inputs = $request->all();
        $inputs['url_hs'] = '/KhenThuongCongHien/HoSo/';
        $inputs['url_xd'] = '/KhenThuongCongHien/XetDuyet/';
        $inputs['url_qd'] = '/KhenThuongCongHien/KhenThuong/';
        $inputs['url'] = '/KhenThuongCongHien/KhenThuong/';
        $inputs['phanloaihoso'] = 'dshosothiduakhenthuong';

        //$inputs['mahinhthuckt'] = session('chucnang')['qdhosodenghikhenthuongcongtrang']['mahinhthuckt'] ?? 'ALL';
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $model_canhan = dshosothiduakhenthuong_canhan::where('mahosotdkt', $inputs['mahosotdkt'])->get();
        $model_tapthe = dshosothiduakhenthuong_tapthe::where('mahosotdkt', $inputs['mahosotdkt'])->get();
        $model_hogiadinh = dshosothiduakhenthuong_hogiadinh::where('mahosotdkt', $inputs['mahosotdkt'])->get();
        $model_tailieu = dshosothiduakhenthuong_tailieu::where('mahosotdkt', $inputs['mahosotdkt'])->get();
        $donvi = viewdiabandonvi::where('madonvi', $model->madonvi)->first();
        $a_dhkt_canhan = getDanhHieuKhenThuong($donvi->capdo);
        $a_dhkt_tapthe = getDanhHieuKhenThuong($donvi->capdo, 'TAPTHE');
        $model->tendonvi = $donvi->tendonvi;

        $a_tapthe = array_column(dmnhomphanloai_chitiet::wherein('manhomphanloai', ['TAPTHE'])->get()->toarray(), 'tenphanloai', 'maphanloai');
        $a_hogiadinh = array_column(dmnhomphanloai_chitiet::wherein('manhomphanloai', ['HOGIADINH'])->get()->toarray(), 'tenphanloai', 'maphanloai');
        $a_canhan = array_column(dmnhomphanloai_chitiet::wherein('manhomphanloai', ['CANHAN'])->get()->toarray(), 'tenphanloai', 'maphanloai');
        $a_dhkt_hogiadinh = getDanhHieuKhenThuong($donvi->capdo, 'HOGIADINH');

        //Xác định loại đề nghị để gán quyết định khen thưởng
        switch ($model->phanloai) {
            case 'KTDONVI':
            case 'KHENTHUONG': {
                    $inputs['phanloai'] = 'KHENTINH';
                    $donvi_kt = viewdiabandonvi::where('madonvi', $model->madonvi_kt)->first();
                    $model->capkhenthuong =  $donvi_kt->capdo;
                    $model->donvikhenthuong =  $donvi_kt->tendonvi;
                    $model->chucvunguoikyqd = 'Chủ tịch';
                    $a_donvikt = array_unique(array_merge([$model->donvikhenthuong], getDonViKhenThuong()));
                    break;
                }

            case 'KHENCAOTHUTUONG': {
                    $inputs['phanloai'] = 'KHENCAO';
                    $model->capkhenthuong =  'TW';
                    $model->donvikhenthuong =  'Chính phủ nước Cộng hòa xã hội chủ nghĩa Việt Nam';
                    $model->chucvunguoikyqd = 'Thủ tướng chính phủ';
                    $a_donvikt = ['Chính phủ nước Cộng hòa xã hội chủ nghĩa Việt Nam' => 'Chính phủ nước Cộng hòa xã hội chủ nghĩa Việt Nam'];
                    break;
                }
            case 'KHENCAOCHUTICHNUOC': {
                    $inputs['phanloai'] = 'KHENCAO';
                    $model->capkhenthuong =  'TW';
                    $model->donvikhenthuong =  'Nhà nước Cộng hòa xã hội chủ nghĩa Việt Nam';
                    $model->chucvunguoikyqd = 'Chủ tịch nước';
                    $a_donvikt = ['Nhà nước Cộng hòa xã hội chủ nghĩa Việt Nam' => 'Nhà nước Cộng hòa xã hội chủ nghĩa Việt Nam'];
                    break;
                }
        }
        //Gán thông tin để thông tin đơn vị đang thao tác
        $inputs['madonvi'] = $model->madonvi_kt;
        
        return view('NghiepVu.KhenThuongCongHien.KhenThuong.PheDuyetKT')
            ->with('model', $model)
            ->with('model_canhan', $model_canhan)
            ->with('model_tapthe', $model_tapthe)
            ->with('model_hogiadinh', $model_hogiadinh)
            ->with('model_tailieu', $model_tailieu)
            ->with('a_pltailieu', getPhanLoaiTaiLieuDK())
            ->with('a_donvi', array_column(dsdonvi::all()->toArray(), 'tendonvi', 'madonvi'))
            ->with('a_dhkt_canhan', $a_dhkt_canhan)
            ->with('a_donvikt', $a_donvikt)
            ->with('a_hogiadinh', $a_hogiadinh)
            ->with('a_dhkt_tapthe', $a_dhkt_tapthe)
            ->with('a_dhkt_hogiadinh', $a_dhkt_hogiadinh)
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            //->with('a_donvi_kt', [$donvi_kt->madonvi => $donvi_kt->tendonvi])
            ->with('a_tapthe', $a_tapthe)
            ->with('a_canhan', $a_canhan)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Thông tin phê duyệt hồ sơ đề nghị khen thưởng');
    }

    public function LuuPheDuyet(Request $request)
    {
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
        return redirect(static::$url . 'ThongTin?madonvi=' . $model->madonvi_kt);
    }

    public function HuyPheDuyet(Request $request)
    {
        if (!chkPhanQuyen('qdhosodenghikhenthuongconghien', 'hoanthanh')) {
            return view('errors.noperm')
                ->with('machucnang', 'qdhosodenghikhenthuongconghien')
                ->with('tenphanquyen', 'hoanthanh');
        }
        $inputs = $request->all();
        $inputs['thoigian'] = date('Y-m-d H:i:s');
        $inputs['trangthai'] = 'CXKT';
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        setHuyKhenThuong($model, $inputs);
        //Xoá tài liệu đính kèm quyết định khen thưởng
        $model_tailieu = dshosothiduakhenthuong_tailieu::where('mahosotdkt', $inputs['mahosotdkt'])->where('phanloai', 'QDKT')->first();
        if ($model_tailieu != null) {
            $rq = new Request([
                'phanloaihoso'   => 'dshosothiduakhenthuong',
                'id' => $model_tailieu->id,
                'madonvi' => $model->madonvi_kt,
            ]);
            //$rq->request->add(['phanloaihoso' => 'dshosothiduakhenthuong', 'id'=>'10']);        
            $dinhkem = new dungchung_nghiepvu_tailieuController();
            $dinhkem->XoaTaiLieu($rq);
        }
        return redirect(static::$url . 'ThongTin?madonvi=' . $inputs['madonvi']);
    }

    public function TraLai(Request $request)
    {
        if (!chkPhanQuyen('qdhosodenghikhenthuongdotxuat', 'hoanthanh')) {
            return view('errors.noperm')
                ->with('machucnang', 'qdhosodenghikhenthuongdotxuat')
                ->with('tenphanquyen', 'hoanthanh');
        }
        $inputs = $request->all();
        //dd($inputs);
        //dd($inputs);
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahoso'])->first();
        //gán trạng thái hồ sơ để theo dõi
        $madonvi = $model->madonvi_kt;
        $inputs['trangthai'] = 'BTLXD';
        $inputs['thoigian'] = date('Y-m-d H:i:s');
        setTraLaiPD($model, $inputs);
        return redirect(static::$url . 'ThongTin?madonvi=' . $madonvi);
    }

    public function QuyetDinh(Request $request)
    {
        $inputs = $request->all();
        $inputs['url'] = static::$url;
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        if ($model->thongtinquyetdinh == '') {
            $thongtinquyetdinh = duthaoquyetdinh::all()->first()->codehtml ?? '';
            //noidung
            $thongtinquyetdinh = str_replace('[noidung]', $model->noidung, $thongtinquyetdinh);
            //chucvunguoiky
            $thongtinquyetdinh = str_replace('[chucvunguoiky]', $model->chucvunguoiky, $thongtinquyetdinh);
            //hotennguoiky
            $thongtinquyetdinh = str_replace('[hotennguoiky]',  $model->hotennguoiky, $thongtinquyetdinh);

            $m_canhan = dshosothiduakhenthuong_canhan::where('mahosotdkt', $model->mahosotdkt)->where('ketqua', '1')->orderby('stt')->get();
            if ($m_canhan->count() > 0) {
                $s_canhan = '';
                $i = 1;
                foreach ($m_canhan as $canhan) {
                    $s_canhan .= '<p style=&#34;margin-left:40px;&#34;>' .
                        ($i++) . '. ' . $canhan->tendoituong .
                        ($canhan->chucvu == '' ? '' : ('; ' . $canhan->chucvu)) .
                        ($canhan->tencoquan == '' ? '' : ('; ' . $canhan->tencoquan)) .
                        '</p>';
                    //dd($s_canhan);
                }
                //dd($s_canhan);
                // $thongtinquyetdinh = str_replace('<p style=&#34;margin-left:25px;&#34;>[khenthuongcanhan]</p>',  $s_canhan, $thongtinquyetdinh);
                $thongtinquyetdinh = str_replace('[khenthuongcanhan]',  $s_canhan, $thongtinquyetdinh);
            }

            //Tập thể
            $m_tapthe = dshosothiduakhenthuong_tapthe::where('mahosotdkt', $model->mahosotdkt)->where('ketqua', '1')->orderby('stt')->get();
            if ($m_tapthe->count() > 0) {
                $s_tapthe = '';
                $i = 1;
                foreach ($m_tapthe as $chitiet) {
                    $s_tapthe .= '<p style=&#34;margin-left:40px;&#34;>' .
                        ($i++) . '. ' . $chitiet->tentapthe .
                        '</p>';
                }
                $thongtinquyetdinh = str_replace('[khenthuongtapthe]',  $s_tapthe, $thongtinquyetdinh);
            }
            $model->thongtinquyetdinh = $thongtinquyetdinh;
        }
        //dd($model);
        $a_duthao = array_column(duthaoquyetdinh::all()->toArray(), 'noidung', 'maduthao');
        $inputs['maduthao'] = $inputs['maduthao'] ?? array_key_first($a_duthao);
        return view('BaoCao.DonVi.QuyetDinh.CongHien')
            ->with('model', $model)
            ->with('a_duthao', $a_duthao)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Quyết định khen thưởng');
    }

    public function InQuyetDinh(Request $request)
    {
        $inputs = $request->all();
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        getTaoQuyetDinhKT($model);
        $model->thongtinquyetdinh = str_replace('<p>[sangtrangmoi]</p>', '<div class=&#34;sangtrangmoi&#34;></div>', $model->thongtinquyetdinh);
        //dd($model);
        return view('BaoCao.DonVi.XemQuyetDinh')
            ->with('model', $model)
            ->with('pageTitle', 'Quyết định khen thưởng');
    }

    public function DuThaoQuyetDinh(Request $request)
    {

        $inputs = $request->all();
        $inputs['url'] = static::$url;
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $a_duthao = array_column(duthaoquyetdinh::all()->toArray(), 'noidung', 'maduthao');
        $inputs['maduthao'] = $inputs['maduthao'] ?? array_key_first($a_duthao);
        $thongtinquyetdinh = duthaoquyetdinh::where('maduthao', $inputs['maduthao'])->first()->codehtml ?? '';
        //noidung
        $thongtinquyetdinh = str_replace('[noidung]', $model->noidung, $thongtinquyetdinh);
        //chucvunguoiky
        $thongtinquyetdinh = str_replace('[chucvunguoiky]', $model->chucvunguoiky, $thongtinquyetdinh);
        //hotennguoiky
        $thongtinquyetdinh = str_replace('[hotennguoiky]',  $model->hotennguoiky, $thongtinquyetdinh);

        $m_canhan = dshosothiduakhenthuong_canhan::where('mahosotdkt', $model->mahosotdkt)->where('ketqua', '1')->orderby('stt')->get();
        if ($m_canhan->count() > 0) {
            $s_canhan = '';
            $i = 1;
            foreach ($m_canhan as $canhan) {
                $s_canhan .= '<p style=&#34;margin-left:40px;&#34;>' .
                    ($i++) . '. ' . $canhan->tendoituong .
                    ($canhan->chucvu == '' ? '' : ('; ' . $canhan->chucvu)) .
                    ($canhan->tencoquan == '' ? '' : ('; ' . $canhan->tencoquan)) .
                    '</p>';
                //dd($s_canhan);
            }
            //dd($s_canhan);
            // $thongtinquyetdinh = str_replace('<p style=&#34;margin-left:25px;&#34;>[khenthuongcanhan]</p>',  $s_canhan, $thongtinquyetdinh);
            $thongtinquyetdinh = str_replace('[khenthuongcanhan]',  $s_canhan, $thongtinquyetdinh);
        }

        //Tập thể
        $m_tapthe = dshosothiduakhenthuong_tapthe::where('mahosotdkt', $model->mahosotdkt)->where('ketqua', '1')->orderby('stt')->get();
        if ($m_tapthe->count() > 0) {
            $s_tapthe = '';
            $i = 1;
            foreach ($m_tapthe as $chitiet) {
                $s_tapthe .= '<p style=&#34;margin-left:40px;&#34;>' .
                    ($i++) . '. ' . $chitiet->tentapthe .
                    '</p>';
            }
            $thongtinquyetdinh = str_replace('[khenthuongtapthe]',  $s_tapthe, $thongtinquyetdinh);
        }
        $model->thongtinquyetdinh = $thongtinquyetdinh;

        return view('BaoCao.DonVi.QuyetDinh.CongHien')
            ->with('model', $model)
            ->with('a_duthao', $a_duthao)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Quyết định khen thưởng');
    }

    public function LuuQuyetDinh(Request $request)
    {
        $inputs = $request->all();
        //dd($inputs);
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $model->thongtinquyetdinh = $inputs['thongtinquyetdinh'];
        $model->save();
        return redirect(static::$url . 'ThongTin');
    }

    public function ToTrinhPheDuyet(Request $request)
    {
        $inputs = $request->all();
        $inputs['url'] = static::$url;
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $inputs['madonvi'] = $model->madonvi;
        $inputs['maduthao'] = $inputs['maduthao'] ?? 'ALL';
        getTaoDuThaoToTrinhPheDuyet($model, $inputs['maduthao']);
        $a_duthao = array_column(duthaoquyetdinh::wherein('phanloai', ['TOTRINHHOSO'])->get()->toArray(), 'noidung', 'maduthao');

        $inputs['maduthao'] = $inputs['maduthao'] ?? array_key_first($a_duthao);
        return view('BaoCao.DonVi.QuyetDinh.MauChungToTrinhKT')
            ->with('model', $model)
            ->with('a_duthao', $a_duthao)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Dự thảo tờ trình khen thưởng');
    }

    public function LuuToTrinhPheDuyet(Request $request)
    {
        $inputs = $request->all();
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        $model->thongtintotrinhdenghi = $inputs['thongtintotrinhdenghi'];
        $model->save();
        return redirect(static::$url . 'ThongTin?madonvi=' . $model->madonvi);
    }

    public function InToTrinhPheDuyet(Request $request)
    {
        $inputs = $request->all();
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        getTaoDuThaoToTrinhPheDuyet($model);
        $model->thongtinquyetdinh = $model->thongtintotrinhdenghi;
        $model->thongtinquyetdinh = str_replace('<p>[sangtrangmoi]</p>', '<div class=&#34;sangtrangmoi&#34;></div>', $model->thongtinquyetdinh);
        //dd($model);
        return view('BaoCao.DonVi.XemQuyetDinh')
            ->with('model', $model)
            ->with('pageTitle', 'Tờ trình khen thưởng');
    }

    public function GanKhenThuong(Request $request)
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
        //dd($inputs);
        if ($inputs['phanloai'] == 'TAPTHE') {
            dshosothiduakhenthuong_tapthe::where('mahosotdkt', $inputs['mahosotdkt'])->update(['ketqua' => $inputs['ketqua'], 'noidungkhenthuong' => $inputs['noidungkhenthuong']]);
            $model = dshosothiduakhenthuong_tapthe::where('mahosotdkt', $inputs['mahosotdkt'])->get();
            $dungchung = new dungchung_nghiepvuController();
            $dungchung->htmlPheDuyetTapThe($result, $model);
        }
        if ($inputs['phanloai'] == 'CANHAN') {
            dshosothiduakhenthuong_canhan::where('mahosotdkt', $inputs['mahosotdkt'])->update(['ketqua' => $inputs['ketqua'], 'noidungkhenthuong' => $inputs['noidungkhenthuong']]);
            $model = dshosothiduakhenthuong_canhan::where('mahosotdkt', $inputs['mahosotdkt'])->get();
            $dungchung = new dungchung_nghiepvuController();
            $dungchung->htmlPheDuyetCaNhan($result, $model);
        }
        if ($inputs['phanloai'] == 'HOGIADINH') {
            dshosothiduakhenthuong_hogiadinh::where('mahosotdkt', $inputs['mahosotdkt'])->update(['ketqua' => $inputs['ketqua'], 'noidungkhenthuong' => $inputs['noidungkhenthuong']]);
            $model = dshosothiduakhenthuong_hogiadinh::where('mahosotdkt', $inputs['mahosotdkt'])->get();
            $dungchung = new dungchung_nghiepvuController();
            $dungchung->htmlPheDuyetHoGiaDinh($result, $model);
        }

        return response()->json($result);
    }

    public function XemHoSo(Request $request)
    {
        $inputs = $request->all();
        $model =  dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        //$model->tenphongtraotd = dsphongtraothidua::where('maphongtraotd', $model->maphongtraotd)->first()->noidung ?? '';
        $model_canhan = dshosothiduakhenthuong_canhan::where('mahosotdkt', $model->mahosotdkt)->get();
        $model_tapthe = dshosothiduakhenthuong_tapthe::where('mahosotdkt', $model->mahosotdkt)->get();
        $model_detai = dshosothiduakhenthuong_detai::where('mahosotdkt', $model->mahosotdkt)->get();
        $model_hogiadinh = dshosothiduakhenthuong_hogiadinh::where('mahosotdkt', $model->mahosotdkt)->get();
        $a_phanloaidt = array_column(dmnhomphanloai_chitiet::all()->toarray(), 'tenphanloai', 'maphanloai');
        $m_donvi = dsdonvi::where('madonvi', $model->madonvi)->first();
        $a_dhkt = getDanhHieuKhenThuong('ALL');

        return view('NghiepVu.KhenThuongCongHien.KhenThuong.Xem')
            ->with('model', $model)
            ->with('model_canhan', $model_canhan)
            ->with('model_tapthe', $model_tapthe)
            ->with('model_detai', $model_detai)
            ->with('model_hogiadinh', $model_hogiadinh)
            ->with('m_donvi', $m_donvi)
            ->with('a_phanloaidt', $a_phanloaidt)
            ->with('a_dhkt', $a_dhkt)
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            //->with('a_hinhthuckt', array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Thông tin hồ sơ khen thưởng');
    }
}
