<?php

namespace App\Http\Controllers\NghiepVu\ThiDuaKhenThuong;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\DanhMuc\dmdanhhieuthidua;
use App\Model\DanhMuc\dmhinhthuckhenthuong;
use App\Model\DanhMuc\dmloaihinhkhenthuong;
use App\Model\DanhMuc\dmnhomphanloai_chitiet;
use App\Model\DanhMuc\dsdiaban;
use App\Model\DanhMuc\dsdonvi;
use App\Model\HeThong\trangthaihoso;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothamgiaphongtraotd;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothamgiaphongtraotd_canhan;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothamgiaphongtraotd_tapthe;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothamgiaphongtraotd_tieuchuan;
use App\Model\NghiepVu\ThiDuaKhenThuong\dsphongtraothidua;
use App\Model\NghiepVu\ThiDuaKhenThuong\dsphongtraothidua_khenthuong;
use App\Model\NghiepVu\ThiDuaKhenThuong\dsphongtraothidua_tieuchuan;
use App\Model\View\viewdiabandonvi;
use App\Model\View\viewdonvi_dsphongtrao;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class dshosothiduaController extends Controller
{
    public static $url = '';
    public function __construct()
    {
        static::$url = '/HoSoThiDua/';
        $this->middleware(function ($request, $next) {
            if (!Session::has('admin')) {
                return redirect('/');
            };
            return $next($request);
        });
    }

    public function ThongTin(Request $request)
    {
        if (!chkPhanQuyen('dshosothidua', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'dshosothidua')->with('tenphanquyen', 'danhsach');
        }

        $inputs = $request->all();
        $inputs['url'] = static::$url;
        $m_donvi = getDonVi(session('admin')->capdo, 'dshosothidua');
        $m_diaban = dsdiaban::wherein('madiaban', array_column($m_donvi->toarray(), 'madiaban'))->get();
        $inputs['nam'] = $inputs['nam'] ?? 'ALL';
        $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;
        $inputs['phamviapdung'] = $inputs['phamviapdung'] ?? 'ALL';
        $inputs['phanloai'] = $inputs['phanloai'] ?? 'ALL';
        $donvi = $m_donvi->where('madonvi', $inputs['madonvi'])->first();
        
        //lấy hết phong trào cấp tỉnh
        $model = viewdonvi_dsphongtrao::wherein('phamviapdung', ['T','TW'])->orderby('tungay')->get();
        
        switch($donvi->capdo){
            case 'X' :{
                //đơn vị cấp xã => chỉ các phong trào trong huyện, xã
                $model_xa = viewdonvi_dsphongtrao::wherein('madiaban',[$donvi->madiaban, $donvi->madiabanQL])->orderby('tungay')->get();                
                break;
            }
            case 'H' :{
                //đơn vị cấp huyện =>chỉ các phong trào trong huyện
                $model_xa = viewdonvi_dsphongtrao::where('madiaban', $donvi->madiaban)->orderby('tungay')->get();
                break;
            }
            case 'T' :{
                //Phong trào theo SBN
                $model_xa = viewdonvi_dsphongtrao::where('phamviapdung', 'SBN')->orderby('tungay')->get();
                break;
            }
        }
        foreach ($model_xa as $ct) {
            $model->add($ct);
        }
        //kết quả
        if ($inputs['phamviapdung'] != 'ALL') {
            $model = $model->where('phamviapdung', $inputs['phamviapdung']);
        }
        
        $ngayhientai = date('Y-m-d');
        $m_hoso = dshosothamgiaphongtraotd::wherein('maphongtraotd', array_column($model->toarray(), 'maphongtraotd'))->get();
        $m_hoso_khenthuong = dshosothamgiaphongtraotd::wherein('maphongtraotd', array_column($model->toarray(), 'maphongtraotd'))->where('trangthai', 'DKT')->get();

        foreach ($model as $DangKy) {
            if ($DangKy->trangthai == 'CC') {
                $DangKy->nhanhoso = 'CHUABATDAU';
                if ($DangKy->tungay < $ngayhientai && $DangKy->denngay > $ngayhientai) {
                    $DangKy->nhanhoso = 'DANGNHAN';
                }
                if (strtotime($DangKy->denngay) < strtotime($ngayhientai)) {
                    $DangKy->nhanhoso = 'KETTHUC';
                }
            } else {
                $DangKy->nhanhoso = 'KETTHUC';
            }

            $HoSo = $m_hoso->where('maphongtraotd', $DangKy->maphongtraotd)->wherein('trangthai', ['CD', 'DD', 'CNXKT', 'DXKT', 'CXKT', 'DKT']);
            $DangKy->sohoso = $HoSo == null ? 0 : $HoSo->count();
            $DangKy->mahosothamgiapt = $m_hoso_khenthuong->where('maphongtraotd', $DangKy->maphongtraotd)->where('madonvi', $inputs['madonvi'])->first()->mahosothamgiapt ?? null;

            $HoSodv = $m_hoso->where('maphongtraotd', $DangKy->maphongtraotd)->where('madonvi', $inputs['madonvi'])->first();
            $DangKy->trangthai = $HoSodv->trangthai ?? 'CXD';
            $DangKy->thoigian = $HoSodv->thoigian ?? '';
            $DangKy->hosodonvi = $HoSodv == null ? 0 : 1;
            $DangKy->id = $HoSodv == null ? -1 : $HoSodv->id;
            $DangKy->mahosothamgiapt = $HoSodv == null ? -1 : $HoSodv->mahosothamgiapt;
        }
        //dd($m_diaban);
        //->with('a_phamvi', getPhamViPhongTrao($m_donvi->where('madonvi', $inputs['madonvi'])->first()->capdo ?? 'T'))

        return view('NghiepVu.ThiDuaKhenThuong.HoSoThiDua.ThongTin')
            ->with('inputs', $inputs)
            ->with('model', $model->sortby('tungay'))
            ->with('m_donvi', $m_donvi)
            ->with('m_diaban', $m_diaban)
            ->with('a_donviql', getDonViQuanLyDiaBan($donvi))
            ->with('a_phamvi', getPhamViPhongTrao())
            ->with('a_phanloai', getPhanLoaiPhongTraoThiDua(true))
            ->with('a_trangthaihoso', getTrangThaiTDKT())
            ->with('pageTitle', 'Danh sách hồ sơ thi đua');
    }

    public function ThemHoSo(Request $request)
    {
        if (!chkPhanQuyen('dshosothidua', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dshosothidua')->with('tenphanquyen', 'thaydoi');
        }

        $inputs = $request->all();
        $inputs['url_hs'] = '/HoSoThiDua/';
        $inputs['url_xd'] = '/XetDuyetHoSoThiDua/';
        $inputs['url_qd'] = '/KhenThuongHoSoThiDua/';
        $inputs['maloaihinhkt'] = session('chucnang')['dshosothidua']['maloaihinhkt'] ?? 'ALL';
        $inputs['mahinhthuckt'] = session('chucnang')['dshosothidua']['mahinhthuckt'] ?? 'ALL';
        $m_phongtrao = dsphongtraothidua::where('maphongtraotd', $inputs['maphongtraotd'])->first();
        $model = new dshosothamgiaphongtraotd();
        $model->madonvi = $inputs['madonvi'];
        $model->tendonvi = getThongTinDonVi($inputs['madonvi'], 'tendonvi');
        $model->mahosothamgiapt = (string)getdate()[0];
        $model->maloaihinhkt = $m_phongtrao->maloaihinhkt;
        $model->tenphongtrao = $m_phongtrao->noidung;
        $model->maphongtraotd = $inputs['maphongtraotd'];

        $model_canhan = dshosothamgiaphongtraotd_canhan::where('mahosothamgiapt', $model->mahosothamgiapt)->get();
        $model_tapthe = dshosothamgiaphongtraotd_tapthe::where('mahosothamgiapt', $model->mahosothamgiapt)->get();
        $model_tieuchuan = dsphongtraothidua_tieuchuan::where('maphongtraotd', $model->maphongtraotd)->get();

        $m_danhhieu = dmdanhhieuthidua::all();
        $m_tieuchuan = dsphongtraothidua_tieuchuan::where('maphongtraotd', $inputs['maphongtraotd'])->get();
        //dd( $model);
        $m_donvi = dsdonvi::all();
        $m_diaban = dsdiaban::all();
        $m_canhan = getDoiTuongKhenThuong($model->madonvi);
        $m_tapthe = getTapTheKhenThuong($model->madonvi);

        $a_tapthe = array_column(dmnhomphanloai_chitiet::wherein('manhomphanloai', ['TAPTHE', 'HOGIADINH'])->get()->toarray(), 'tenphanloai', 'maphanloai');
        $a_canhan = array_column(dmnhomphanloai_chitiet::wherein('manhomphanloai', ['CANHAN'])->get()->toarray(), 'tenphanloai', 'maphanloai');
        return view('NghiepVu.ThiDuaKhenThuong.HoSoThiDua.ThayDoi')
            ->with('model', $model)
            ->with('model_canhan', $model_canhan)
            ->with('model_tapthe', $model_tapthe)
            ->with('model_tieuchuan', $model_tieuchuan)
            ->with('m_danhhieu', $m_danhhieu)
            ->with('m_tieuchuan', $m_tieuchuan)
            ->with('m_canhan', $m_canhan)
            ->with('m_tapthe', $m_tapthe)
            ->with('a_tapthe', $a_tapthe)
            ->with('a_canhan', $a_canhan)
            ->with('a_danhhieutd', array_column($m_danhhieu->toArray(), 'tendanhhieutd', 'madanhhieutd'))
            ->with('a_tieuchuan', array_column($m_tieuchuan->toArray(), 'tentieuchuandhtd', 'matieuchuandhtd'))
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('a_hinhthuckt', array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
            ->with('a_phongtraotd', array_column($m_phongtrao->toArray(), 'tenphongtraotd', 'maphongtraotd'))
            ->with('inputs', $inputs)
            ->with('m_donvi', $m_donvi)
            ->with('m_diaban', $m_diaban)
            ->with('pageTitle', 'Hồ sơ thi đua');
    }

    public function ThayDoi(Request $request)
    {
        if (!chkPhanQuyen('dshosothidua', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dshosothidua')->with('tenphanquyen', 'thaydoi');
        }

        $inputs = $request->all();
        $inputs['url'] = '/HoSoThiDua/';
        $inputs['url_hs'] = '/HoSoThiDua/';
        $inputs['url_xd'] = '/XetDuyetHoSoThiDua/';
        $inputs['url_qd'] = '/KhenThuongHoSoThiDua/';
        $inputs['maloaihinhkt'] = session('chucnang')['dshosothidua']['maloaihinhkt'] ?? 'ALL';
        $inputs['mahinhthuckt'] = session('chucnang')['dshosothidua']['mahinhthuckt'] ?? 'ALL';
        $model = dshosothamgiaphongtraotd::where('mahosothamgiapt', $inputs['mahosothamgiapt'])->first();
        $m_phongtrao = dsphongtraothidua::where('maphongtraotd', $model->maphongtraotd)->first();
        $model->tendonvi = getThongTinDonVi($model->madonvi, 'tendonvi');
        $model->tenphongtrao = $m_phongtrao->noidung;

        $model_canhan = dshosothamgiaphongtraotd_canhan::where('mahosothamgiapt', $model->mahosothamgiapt)->get();
        $model_tapthe = dshosothamgiaphongtraotd_tapthe::where('mahosothamgiapt', $model->mahosothamgiapt)->get();
        $model_tieuchuan = dsphongtraothidua_tieuchuan::where('maphongtraotd', $model->maphongtraotd)->get();

        $m_danhhieu = dmdanhhieuthidua::all();;
        $m_tieuchuan = dsphongtraothidua_tieuchuan::where('maphongtraotd', $model->maphongtraotd)->get();
        //dd( $model);
        $m_donvi = dsdonvi::all();
        $m_diaban = dsdiaban::all();
        $m_canhan = getDoiTuongKhenThuong($model->madonvi);
        $m_tapthe = getTapTheKhenThuong($model->madonvi);
        $a_tapthe = array_column(dmnhomphanloai_chitiet::wherein('manhomphanloai', ['TAPTHE', 'HOGIADINH'])->get()->toarray(), 'tenphanloai', 'maphanloai');
        $a_canhan = array_column(dmnhomphanloai_chitiet::wherein('manhomphanloai', ['CANHAN'])->get()->toarray(), 'tenphanloai', 'maphanloai');
        return view('NghiepVu.ThiDuaKhenThuong.HoSoThiDua.ThayDoi')
            ->with('model', $model)
            ->with('model_canhan', $model_canhan)
            ->with('model_tapthe', $model_tapthe)
            ->with('model_tieuchuan', $model_tieuchuan)
            ->with('m_danhhieu', $m_danhhieu)
            ->with('m_tieuchuan', $m_tieuchuan)
            ->with('m_canhan', $m_canhan)
            ->with('m_tapthe', $m_tapthe)
            ->with('a_tapthe', $a_tapthe)
            ->with('a_canhan', $a_canhan)
            ->with('a_danhhieutd', array_column($m_danhhieu->toArray(), 'tendanhhieutd', 'madanhhieutd'))
            ->with('a_tieuchuan', array_column($m_tieuchuan->toArray(), 'tentieuchuandhtd', 'matieuchuandhtd'))
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('a_hinhthuckt', array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
            ->with('inputs', $inputs)
            ->with('m_donvi', $m_donvi)
            ->with('m_diaban', $m_diaban)
            ->with('pageTitle', 'Hồ sơ thi đua');
    }

    public function XemHoSo(Request $request)
    {
        $inputs = $request->all();
        $model = dshosothamgiaphongtraotd::where('mahosothamgiapt', $inputs['mahosothamgiapt'])->first();
        $m_phongtrao = dsphongtraothidua::where('maphongtraotd', $model->maphongtraotd)->first();
        $m_donvi = dsdonvi::where('madonvi', $model->madonvi)->first();
        $model->tendonvi = getThongTinDonVi($model->madonvi, 'tendonvi');
        $model->tenphongtrao = $m_phongtrao->noidung;
        $model_canhan = dshosothamgiaphongtraotd_canhan::where('mahosothamgiapt', $model->mahosothamgiapt)->get();
        $model_tapthe = dshosothamgiaphongtraotd_tapthe::where('mahosothamgiapt', $model->mahosothamgiapt)->get();
        $m_danhhieu = dsphongtraothidua_khenthuong::where('maphongtraotd', $model->maphongtraotd)->get();
        $m_tieuchuan = dsphongtraothidua_tieuchuan::where('maphongtraotd', $model->maphongtraotd)->get();

        //dd( $model);

        return view('NghiepVu.ThiDuaKhenThuong.HoSoThiDua.Xem')
            ->with('model', $model)
            ->with('m_donvi', $m_donvi)
            ->with('model_canhan', $model_canhan)
            ->with('model_tapthe', $model_tapthe)
            ->with('a_danhhieu', array_column($m_danhhieu->toArray(), 'tendanhhieutd', 'madanhhieutd'))
            ->with('a_tieuchuan', array_column($m_tieuchuan->toArray(), 'tentieuchuandhtd', 'matieuchuandhtd'))
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('a_hinhthuckt', array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
            ->with('pageTitle', 'Hồ sơ thi đua');
    }

    public function LuuHoSo(Request $request)
    {

        if (!chkPhanQuyen('dshosothidua', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dshosothidua')->with('tenphanquyen', 'thaydoi');
        }

        $inputs = $request->all();

        if (isset($inputs['totrinh'])) {
            $filedk = $request->file('totrinh');
            $inputs['totrinh'] = $inputs['mahosothamgiapt'] . '_totrinh.' . $filedk->getClientOriginalExtension();
            $filedk->move(public_path() . '/data/totrinh/', $inputs['totrinh']);
        }
        if (isset($inputs['baocao'])) {
            $filedk = $request->file('baocao');
            $inputs['baocao'] = $inputs['mahosothamgiapt'] . '_baocao.' . $filedk->getClientOriginalExtension();
            $filedk->move(public_path() . '/data/baocao/', $inputs['baocao']);
        }
        if (isset($inputs['bienban'])) {
            $filedk = $request->file('bienban');
            $inputs['bienban'] = $inputs['mahosothamgiapt'] . '_bienban.' . $filedk->getClientOriginalExtension();
            $filedk->move(public_path() . '/data/bienban/', $inputs['bienban']);
        }
        if (isset($inputs['tailieukhac'])) {
            $filedk = $request->file('tailieukhac');
            $inputs['tailieukhac'] = $inputs['mahosothamgiapt'] . 'tailieukhac.' . $filedk->getClientOriginalExtension();
            $filedk->move(public_path() . '/data/tailieukhac/', $inputs['tailieukhac']);
        }

        $model = dshosothamgiaphongtraotd::where('mahosothamgiapt', $inputs['mahosothamgiapt'])->first();
        if ($model == null) {
            $inputs['trangthai'] = 'CC';
            $inputs['phanloai'] = 'THIDUA';
            $inputs['maloaihinhkt'] = dsphongtraothidua::where('maphongtraotd', $inputs['maphongtraotd'])->first()->maloaihinhkt;

            //dd($inputs);
            dshosothamgiaphongtraotd::create($inputs);
            $trangthai = new trangthaihoso();
            $trangthai->trangthai = $inputs['trangthai'];
            $trangthai->madonvi = $inputs['madonvi'];
            $trangthai->phanloai = 'dshosothamgiaphongtraotd';
            $trangthai->mahoso = $inputs['mahosothamgiapt'];
            $trangthai->thoigian = date('Y-m-d H:i:s');
            $trangthai->save();
        } else {
            $model->update($inputs);
        }

        return redirect(static::$url . 'ThongTin?madonvi=' . $inputs['madonvi']);
    }

    public function delete(Request $request)
    {
        if (!chkPhanQuyen('dshosothidua', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'dshosothidua')->with('tenphanquyen', 'thaydoi');
        }

        $inputs = $request->all();
        $model = dshosothamgiaphongtraotd::findorfail($inputs['id']);
        //dshosothamgiaphongtraotd_tieuchuan::where('mahosothamgiapt', $model->mahosothamgiapt)->delete();
        dshosothamgiaphongtraotd_canhan::where('mahosothamgiapt', $model->mahosothamgiapt)->delete();
        $model->delete();
        return redirect(static::$url . 'ThongTin?madonvi=' . $model->madonvi);
    }

    public function ChuyenHoSo(Request $request)
    {
        if (!chkPhanQuyen('dshosothidua', 'hoanthanh')) {
            return view('errors.noperm')->with('machucnang', 'dshosothidua')->with('tenphanquyen', 'hoanthanh');
        }
        $inputs = $request->all();
        $model = dshosothamgiaphongtraotd::where('mahosothamgiapt', $inputs['mahoso'])->first();
        $m_donvi = viewdiabandonvi::where('madonvi', $inputs['madonvi_nhan'])->first();
        //dd($model);
        $model->trangthai = 'CD';
        $model->madonvi_nhan = $inputs['madonvi_nhan'];
        $model->thoigian = date('Y-m-d H:i:s');
        setChuyenHoSo($m_donvi->capdo, $model, ['madonvi' => $inputs['madonvi_nhan'], 'thoigian' => $model->thoigian, 'trangthai' => 'CD']);
        //dd($model);
        $model->save();

        $trangthai = new trangthaihoso();
        $trangthai->trangthai = 'CD';
        $trangthai->madonvi = $model->madonvi;
        $trangthai->madonvi_nhan = $inputs['madonvi_nhan'];
        $trangthai->phanloai = 'dshosothamgiaphongtraotd';
        $trangthai->mahoso = $model->mahosothamgiapt;
        $trangthai->thoigian = $model->thoigian;
        $trangthai->save();

        return redirect(static::$url . 'ThongTin?madonvi=' . $model->madonvi);
    }

    function returnHTMLCaNhan($modelct)
    {
        $result = [];
        if (isset($modelct)) {
            $result['message'] = '<div class="row" id="dskhenthuong">';
            $result['message'] .= '<div class="col-md-12">';
            $result['message'] .= '<table id="sample_3" class="table table-striped table-bordered table-hover" >';
            $result['message'] .= '<thead>';
            $result['message'] .= '<tr>';
            $result['message'] .= '<th width="2%" style="text-align: center">STT</th>';
            $result['message'] .= '<th style="text-align: center">Tên đối tượng</th>';
            $result['message'] .= '<th style="text-align: center" width="10%">Ngày sinh</th>';
            $result['message'] .= '<th style="text-align: center" width="10%">Giới tính</th>';
            $result['message'] .= '<th style="text-align: center" width="15%">Chức vụ</th>';
            $result['message'] .= '<th style="text-align: center" width="20%">Hình thức<br>khen thưởng</th>';
            $result['message'] .= '<th style="text-align: center" width="10%">Thao tác</th>';
            $result['message'] .= '</tr>';
            $result['message'] .= '</thead>';

            $result['message'] .= '<tbody>';
            $key = 1;
            foreach ($modelct as $ct) {
                $result['message'] .= '<tr>';
                $result['message'] .= '<td style="text-align: center">' . $key++ . '</td>';
                $result['message'] .= '<td>' . $ct->tendoituong . '</td>';
                $result['message'] .= '<td>' . getDayVn($ct->ngaysinh) . '</td>';
                $result['message'] .= '<td style="text-align: center">' . $ct->gioitinh . '</td>';
                $result['message'] .= '<td style="text-align: center">' . $ct->chucvu . '</td>';
                $result['message'] .= '<td style="text-align: center">' . $ct->mahinhthuckt . '</td>';
                $result['message'] .= '<td>' .
                    '<button title="Tiêu chuẩn" type="button" onclick="getTieuChuan(' . $ct->madoituong . ',' . $ct->tendoituong . ')" class="btn btn-sm btn-clean btn-icon" data-target="#modal-tieuchuan" data-toggle="modal"> <i class="icon-lg la fa-list text-primary"></i></button>' .
                    '<button title="Sửa" type="button" data-target="#modal-create" data-toggle="modal" class="btn btn-sm btn-clean btn-icon" onclick="getCaNhan(' . $ct->id . ')"><i class="icon-lg la la fa-edit text-primary"></i></button>' .
                    '<button title="Xóa" type="button" data-target="#modal-delete-khenthuong" data-toggle="modal" class="btn btn-sm btn-clean btn-icon" onclick="delKhenThuong(' . $ct->id . ',CANHAN)" ><i class="icon-lg la la fa-trash text-danger"></i></button>' .

                    '</td>';

                $result['message'] .= '</tr>';
            }
            $result['message'] .= '</tbody>';
            $result['message'] .= '</table>';
            $result['message'] .= '</div>';
            $result['message'] .= '</div>';
            $result['status'] = 'success';
        }
        return $result;
    }



    public function returnHTMLTapThe($modelct)
    {
        $result = [];
        if (isset($modelct)) {

            $result['message'] = '<div class="row" id="dskhenthuongtapthe">';

            $result['message'] .= '<div class="col-md-12">';
            $result['message'] .= '<table id="sample_4" class="table table-striped table-bordered table-hover" >';
            $result['message'] .= '<thead>';
            $result['message'] .= '<tr>';
            $result['message'] .= '<th width="5%" style="text-align: center">STT</th>';
            $result['message'] .= '<th style="text-align: center">Tên đơn vi</th>';
            $result['message'] .= '<th style="text-align: center" width="30%">Hình thức<br>khen thưởng</th>';
            $result['message'] .= '<th style="text-align: center" width="10%">Thao tác</th>';
            $result['message'] .= '</tr>';
            $result['message'] .= '</thead>';

            $result['message'] .= '<tbody>';
            $key = 1;
            foreach ($modelct as $ct) {
                $result['message'] .= '<tr>';
                $result['message'] .= '<td style="text-align: center">' . $key++ . '</td>';
                $result['message'] .= '<td>' . $ct->tentapthe . '</td>';
                $result['message'] .= '<td style="text-align: center">' . $ct->mahinhthuckt . '</td>';
                $result['message'] .= '<td>' .
                    '<button title="Tiêu chuẩn" type="button" onclick="getTieuChuan(' . $ct->matapthe . ',' . $ct->tentapthe . ')" class="btn btn-sm btn-clean btn-icon" data-target="#modal-tieuchuan" data-toggle="modal"> <i class="icon-lg la fa-list text-primary"></i></button>' .
                    '<button type="button" data-target="#modal-create-tapthe" data-toggle="modal" class="btn btn-sm btn-clean btn-icon" onclick="getTapThe(' . $ct->id . ')"><i class="icon-lg la fa-edit text-primary"></i></button>' .
                    '<button type="button" data-target="#modal-delete-khenthuong" data-toggle="modal" class="btn btn-sm btn-clean btn-icon" onclick="delKhenThuong(' . $ct->id . ',TAPTHE)" ><i class="icon-lg la fa-trash text-danger"></i></button>' .
                    '</td>';

                $result['message'] .= '</tr>';
            }
            $result['message'] .= '</tbody>';
            $result['message'] .= '</table>';
            $result['message'] .= '</div>';
            $result['message'] .= '</div>';
            $result['status'] = 'success';
        }
        return $result;
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

        $model = dshosothamgiaphongtraotd_tieuchuan::where('iddoituong', $inputs['iddoituong'])
            ->where('mahosothamgiapt', $inputs['mahosothamgiapt'])->get();
        $model_tieuchuan = dsphongtraothidua_tieuchuan::where('maphongtraotd', $inputs['maphongtraotd'])
            ->where('phanloaidoituong', $inputs['phanloaidoituong'])->get();

        if (isset($model_tieuchuan)) {
            $result['message'] = '<div class="row" id="dstieuchuan">';

            $result['message'] .= '<div class="col-md-12">';
            $result['message'] .= '<table id="sample_4" class="table table-striped table-bordered table-hover" >';
            $result['message'] .= '<thead>';
            $result['message'] .= '<tr>';
            $result['message'] .= '<th width="2%" style="text-align: center">STT</th>';
            $result['message'] .= '<th style="text-align: center">Tên tiêu chuẩn</th>';
            $result['message'] .= '<th style="text-align: center" width="12%">Bắt buộc</th>';
            $result['message'] .= '<th style="text-align: center" width="12%">Đạt điều kiên</th>';
            $result['message'] .= '<th style="text-align: center" width="5%">Thao tác</th>';
            $result['message'] .= '</tr>';
            $result['message'] .= '</thead>';

            $result['message'] .= '<tbody>';
            $key = 1;
            foreach ($model_tieuchuan as $ct) {
                $tieuchuan = $model->where('matieuchuandhtd', $ct->matieuchuandhtd)->first();

                $result['message'] .= '<tr>';
                $result['message'] .= '<td style="text-align: center">' . $key++ . '</td>';
                $result['message'] .= '<td>' . $ct->tentieuchuandhtd . '</td>';
                $result['message'] .= '<td style="text-align: center">' . $ct->batbuoc . '</td>';
                $result['message'] .= '<td style="text-align: center">' . ($tieuchuan->dieukien ?? 0) . '</td>';
                $result['message'] .= '<td>' .
                    '<button type="button" data-target="#modal-luutieuchuan" data-toggle="modal" class="btn btn-sm btn-clean btn-icon" onclick="ThayDoiTieuChuan(' . chr(39) . $ct->matieuchuandhtd . chr(39) . ',' . chr(39) . ($tieuchuan->id ?? -1) . chr(39) . ',' . chr(39) . $ct->tentieuchuandhtd . chr(39) . ')"><i class="fa fa-edit"></i></button>'
                    . '</td>';

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


    public function LuuTieuChuan(Request $request)
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
        $model = dshosothamgiaphongtraotd_tieuchuan::where('id', $inputs['id'])->first();

        //chưa lấy biến điều kiện đang dùng tạm để demo
        if ($model == null) {
            $m_tieuchuan = dsphongtraothidua_tieuchuan::where('maphongtraotd', $inputs['maphongtraotd'])
                ->where('matieuchuandhtd', $inputs['matieuchuandhtd'])->first();
            $model = new dshosothamgiaphongtraotd_tieuchuan();
            $model->iddoituong = $inputs['iddoituong'];
            $model->matieuchuandhtd = $m_tieuchuan->matieuchuandhtd;
            $model->tentieuchuandhtd = $m_tieuchuan->tentieuchuandhtd;
            $model->batbuoc = $m_tieuchuan->batbuoc;
            //$model->madonvi = $inputs['madonvi'];
            $model->mahosothamgiapt = $inputs['mahosothamgiapt'];
            $model->dieukien = 1;
            $model->save();
        } else {
            $model->dieukien = 1;
            $model->save();
        }
        //
        $model = dshosothamgiaphongtraotd_tieuchuan::where('iddoituong', $inputs['iddoituong'])
            ->where('mahosothamgiapt', $inputs['mahosothamgiapt'])->get();
        $model_tieuchuan = dsphongtraothidua_tieuchuan::where('maphongtraotd', $inputs['maphongtraotd'])
            ->where('phanloaidoituong', $inputs['phanloaidoituong'])->get();

        if (isset($model_tieuchuan)) {
            $result['message'] = '<div class="row" id="dstieuchuan">';

            $result['message'] .= '<div class="col-md-12">';
            $result['message'] .= '<table id="sample_4" class="table table-striped table-bordered table-hover" >';
            $result['message'] .= '<thead>';
            $result['message'] .= '<tr>';
            $result['message'] .= '<th width="2%" style="text-align: center">STT</th>';
            $result['message'] .= '<th style="text-align: center">Tên tiêu chuẩn</th>';
            $result['message'] .= '<th style="text-align: center" width="12%">Bắt buộc</th>';
            $result['message'] .= '<th style="text-align: center" width="12%">Đạt điều kiên</th>';
            $result['message'] .= '<th style="text-align: center" width="5%">Thao tác</th>';
            $result['message'] .= '</tr>';
            $result['message'] .= '</thead>';

            $result['message'] .= '<tbody>';
            $key = 1;
            foreach ($model_tieuchuan as $ct) {
                $tieuchuan = $model->where('matieuchuandhtd', $ct->matieuchuandhtd)->first();

                $result['message'] .= '<tr>';
                $result['message'] .= '<td style="text-align: center">' . $key++ . '</td>';
                $result['message'] .= '<td>' . $ct->tentieuchuandhtd . '</td>';
                $result['message'] .= '<td style="text-align: center">' . $ct->batbuoc . '</td>';
                $result['message'] .= '<td style="text-align: center">' . ($tieuchuan->dieukien ?? 0) . '</td>';
                $result['message'] .= '<td>' .
                    '<button type="button" data-target="#modal-luutieuchuan" data-toggle="modal" class="btn btn-sm btn-clean btn-icon" onclick="ThayDoiTieuChuan(' . chr(39) . $ct->matieuchuandhtd . chr(39) . ',' . chr(39) . ($tieuchuan->id ?? -1) . chr(39) . ',' . chr(39) . $ct->tentieuchuandhtd . chr(39) . ')"><i class="fa fa-edit"></i></button>'
                    . '</td>';

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
        $model = dshosothamgiaphongtraotd::where('mahosothamgiapt', $inputs['mahosotdkt'])->first();

        $result['message'] = '<div class="col-md-12" id="showlido">';
        $result['message'] .= $model->lydo;

        $result['message'] .= '</div>';
        $result['status'] = 'success';


        die(json_encode($result));
    }

    public function TaiLieuDinhKem(Request $request)
    {
        $result = array(
            'status' => 'fail',
            'message' => 'error',
        );

        $inputs = $request->all();        
        $result['message'] = '<div class="modal-body" id = "dinh_kem" >';
        $model = dshosothamgiaphongtraotd::where('mahosothamgiapt', $inputs['mahs'])->first();
        $result['message'] .= '<h5>Tài liệu hồ sơ đề nghị khen thưởng</h5>';
        if (isset($model->totrinh)) {
            $result['message'] .= '<div class="form-group row">';
            $result['message'] .= '<label class="col-2 col-form-label font-weight-bold" >Tờ trình:</label>';
            $result['message'] .= '<div class="col-10 form-control"><a target = "_blank" href = "' . url('/data/totrinh/' . $model->totrinh) . '">' . $model->totrinh . '</a ></div>';
            $result['message'] .= '</div>';
        }
        if (isset($model->qdkt)) {
            $result['message'] .= '<div class="form-group row">';
            $result['message'] .= '<label class="col-2 col-form-label font-weight-bold" >Quyết định khen thưởng:</label>';
            $result['message'] .= '<div class="col-10 form-control"><a target = "_blank" href = "' . url('/data/qdkt/' . $model->qdkt) . '">' . $model->qdkt . '</a ></div>';
            $result['message'] .= '</div>';
        }
        if (isset($model->bienban)) {
            $result['message'] .= '<div class="form-group row">';
            $result['message'] .= '<label class="col-2 col-form-label font-weight-bold" >Biên bản cuộc họp</label>';
            $result['message'] .= '<div class="col-10 form-control"><a target = "_blank" href = "' . url('/data/bienban/' . $model->bienban) . '">' . $model->bienban . '</a ></div>';
            $result['message'] .= '</div>';
        }
        if (isset($model->tailieukhac)) {
            $result['message'] .= '<div class="form-group row">';
            $result['message'] .= '<label class="col-2 col-form-label font-weight-bold" >Tài liệu khác</label>';
            $result['message'] .= '<div class="col-10 form-control"><a target = "_blank" href = "' . url('/data/tailieukhac/' . $model->tailieukhac) . '">' . $model->tailieukhac . '</a ></div>';
            $result['message'] .= '</div>';
        }
        $result['message'] .= '<hr><h5>Tài liệu phong trào thi đua</h5>';
        $model_pt = dsphongtraothidua::where('maphongtraotd', $model->maphongtraotd)->first();
        if (isset($model_pt->qdkt)) {
            $result['message'] .= '<div class="form-group row">';
            $result['message'] .= '<label class="col-3 col-form-label font-weight-bold" >Quyết định:</label>';
            $result['message'] .= '<div class="col-9 form-control"><a target = "_blank" href = "' . url('/data/qdkt/' . $model_pt->qdkt) . '">' . $model_pt->qdkt . '</a ></div>';
            $result['message'] .= '</div>';
        }

        if (isset($model_pt->tailieukhac)) {
            $result['message'] .= '<div class="form-group row">';
            $result['message'] .= '<label class="col-3 col-form-label font-weight-bold" >Tài liệu khác:</label>';
            $result['message'] .= '<div class="col-9 form-control"><a target = "_blank" href = "' . url('/data/tailieukhac/' . $model_pt->tailieukhac) . '">' . $model_pt->tailieukhac . '</a ></div>';
            $result['message'] .= '</div>';
        }
        $result['message'] .= '</div>';
        $result['status'] = 'success';

        die(json_encode($result));
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
        $model = dshosothamgiaphongtraotd_canhan::where('id', $inputs['id'])->first();
        unset($inputs['id']);
        if ($model == null) {
            dshosothamgiaphongtraotd_canhan::create($inputs);
        } else
            $model->update($inputs);
        // return response()->json($inputs['id']);

        $model = dshosothamgiaphongtraotd_canhan::where('mahosothamgiapt', $inputs['mahosothamgiapt'])->get();


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
        $model = dshosothamgiaphongtraotd_canhan::findorfail($inputs['id']);
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
        $model = dshosothamgiaphongtraotd_canhan::findorfail($inputs['id']);
        $model->delete();

        $m_tapthe = dshosothamgiaphongtraotd_canhan::where('mahosothamgiapt', $model->mahosothamgiapt)->get();
        $this->htmlCaNhan($result, $m_tapthe);
        return response()->json($result);
    }

    public function NhanExcelCaNhan(Request $request)
    {
        $inputs = $request->all();
        //dd($inputs);
        //$model = dshosothiduakhenthuong::where('mahosothamgiapt', $inputs['mahosothamgiapt'])->first();
        $filename = $inputs['mahosothamgiapt'] . '_' . getdate()[0];
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
                'mahosothamgiapt' => $inputs['mahosothamgiapt'],
                'tendoituong' => $data[$i][$inputs['tendoituong']] ?? '',
                'mahinhthuckt' => $data[$i][$inputs['mahinhthuckt']] ?? $inputs['mahinhthuckt_md'],
                'maphanloaicanbo' => $data[$i][$inputs['maphanloaicanbo']] ?? $inputs['maphanloaicanbo_md'],
                'madanhhieutd' => $data[$i][$inputs['madanhhieutd']] ?? $inputs['madanhhieutd_md'],
                "gioitinh" => $data[$i][$inputs['madanhhieutd']] ?? 'NAM',
                'ngaysinh' => $data[$i][$inputs['ngaysinh']] ?? null,
                'chucvu' => $data[$i][$inputs['chucvu']] ?? '',
                'tenphongban' => $data[$i][$inputs['tenphongban']] ?? '',
                'tencoquan' => $data[$i][$inputs['tencoquan']] ?? '',
            );
        }

        dshosothamgiaphongtraotd_canhan::insert($a_dm);
        File::Delete($path);

        return redirect(static::$url .  'Sua?mahosothamgiapt=' . $inputs['mahosothamgiapt']);
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
        $model = dshosothamgiaphongtraotd_tapthe::where('id', $inputs['id'])->first();
        unset($inputs['id']);
        if ($model == null) {
            dshosothamgiaphongtraotd_tapthe::create($inputs);
        } else
            $model->update($inputs);

        $model = dshosothamgiaphongtraotd_tapthe::where('mahosothamgiapt', $inputs['mahosothamgiapt'])->get();

        $this->htmlTapThe($result, $model);
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
        $model = dshosothamgiaphongtraotd_tapthe::findorfail($inputs['id']);
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
        $model = dshosothamgiaphongtraotd_tapthe::findorfail($inputs['id']);
        $model->delete();

        $m_tapthe = dshosothamgiaphongtraotd_tapthe::where('mahosothamgiapt', $model->mahosothamgiapt)->get();
        $this->htmlTapThe($result, $m_tapthe);
        return response()->json($result);
    }

    public function NhanExcelTapThe(Request $request)
    {
        $inputs = $request->all();
        //dd($inputs);
        //$model = dshosothiduakhenthuong::where('mahosothamgiapt', $inputs['mahosothamgiapt'])->first();
        $filename = $inputs['mahosothamgiapt'] . '_' . getdate()[0];
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
                'mahosothamgiapt' => $inputs['mahosothamgiapt'],
                'tentapthe' => $data[$i][$inputs['tentapthe']] ?? '',
                'mahinhthuckt' => $data[$i][$inputs['mahinhthuckt']] ?? $inputs['mahinhthuckt_md'],
                'maphanloaitapthe' => $data[$i][$inputs['maphanloaitapthe']] ?? $inputs['maphanloaitapthe_md'],
                'madanhhieutd' => $data[$i][$inputs['madanhhieutd']] ?? $inputs['madanhhieutd_md'],
            );
        }
        dshosothamgiaphongtraotd_tapthe::insert($a_dm);
        File::Delete($path);

        return redirect(static::$url . 'Sua?mahosothamgiapt=' . $inputs['mahosothamgiapt']);
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
                $result['message'] .= '<td class="text-center"><button title="Sửa thông tin" type="button" onclick="getTapThe(' . $tt->id . ')"  class="btn btn-sm btn-clean btn-icon"
                                                                    data-target="#modal-create-tapthe" data-toggle="modal"><i class="icon-lg la fa-edit text-primary"></i></button>';
                $result['message'] .= '<button title="Xóa" type="button" onclick="delKhenThuong(' . $tt->id . ', &#39;' . static::$url . 'XoaTapThe&#39;, &#39;TAPTHE&#39;)" class="btn btn-sm btn-clean btn-icon" data-target="#modal-delete-khenthuong" data-toggle="modal">
                                                                    <i class="icon-lg la fa-trash text-danger"></i></button>';
                $result['message'] .= '<button title="Tiêu chuẩn" type="button" onclick="getTieuChuan(' . $tt->id . ',&#39;TAPTHE&#39;,&#39;' . $tt->tendoituong . '&#39;)" class="btn btn-sm btn-clean btn-icon" data-target="#modal-tieuchuan" data-toggle="modal"> <i class="icon-lg la fa-list text-dark"></i> </button>';

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

                $result['message'] .= '<td class="text-center"><button title="Sửa thông tin" type="button" onclick="getCaNhan(' . $tt->id . ')"  class="btn btn-sm btn-clean btn-icon"
                                                                    data-target="#modal-create" data-toggle="modal"><i class="icon-lg la fa-edit text-primary"></i></button>';
                $result['message'] .= '<button title="Xóa" type="button" onclick="delKhenThuong(' . $tt->id . ', &#39;' . static::$url . 'XoaCaNhan&#39;, &#39;CANHAN&#39;)" class="btn btn-sm btn-clean btn-icon" data-target="#modal-delete-khenthuong" data-toggle="modal">
                                                                    <i class="icon-lg la fa-trash text-danger"></i></button>';
                $result['message'] .= '<button title="Tiêu chuẩn" type="button" onclick="getTieuChuan(' . $tt->id . ',&#39;CANHAN&#39;,&#39;' . $tt->tendoituong . '&#39;)" class="btn btn-sm btn-clean btn-icon" data-target="#modal-tieuchuan" data-toggle="modal"> <i class="icon-lg la fa-list text-dark"></i> </button>';

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
