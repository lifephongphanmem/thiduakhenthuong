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
use App\Model\DanhMuc\dsdiaban;
use App\Model\HeThong\trangthaihoso;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosokhenthuong;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_khenthuong;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_tieuchuan;
use App\Model\View\viewdiabandonvi;
use Illuminate\Support\Facades\Session;

class dshosokhenthuongdotxuatController extends Controller
{
    public function ThongTin(Request $request)
    {
        if (Session::has('admin')) {
            if (!chkPhanQuyen()) {
                return view('errors.noperm');
            }
            $inputs = $request->all();
            $m_donvi = getDonVi(session('admin')->capdo);
            $m_diaban = dsdiaban::all();
            $m_loaihinh = dmloaihinhkhenthuong::all();
            $inputs['nam'] = $inputs['nam'] ?? 'ALL';
            $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;
            $donvi = $m_donvi->where('madonvi', $inputs['madonvi'])->first();
            $inputs['maloaihinhkt'] = $inputs['maloaihinhkt'] ?? 'ALL';
            $model = dshosothiduakhenthuong::where('madonvi', $inputs['madonvi'])->where('phanloai', 'DOTXUAT');
            if ($inputs['maloaihinhkt'] != 'ALL')
                $model = $model->where('maloaihinhkt', $inputs['maloaihinhkt']);
            $model = $model->orderby('ngayhoso')->get();
            $m_khenthuong = dshosokhenthuong::wherein('mahosotdkt', array_column($model->toarray(), 'mahosotdkt'))->where('trangthai', 'DKT')->get();
            foreach ($model as $hoso) {
                $model->mahosokt = $m_khenthuong->where('mahosotdkt', $hoso->mahosotdkt)->first()->mahosokt ?? null;
            }

            return view('NghiepVu.KhenThuongDotXuat.HoSo.ThongTin')
                ->with('model', $model)
                ->with('a_donvi', array_column($m_donvi->toArray(), 'tendonvi', 'madonvi'))
                ->with('a_capdo', getPhamViApDung())
                ->with('m_donvi', $m_donvi)
                ->with('m_diaban', $m_diaban)
                ->with('a_donviql', getDonViQuanLyDiaBan($donvi->madiaban))
                ->with('a_loaihinhkt', array_column($m_loaihinh->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
                ->with('inputs', $inputs)
                ->with('pageTitle', 'Danh s??ch h??? s?? khen th?????ng ?????t xu???t');
        } else
            return view('errors.notlogin');
    }

    public function ThayDoi(Request $request)
    {
        if (Session::has('admin')) {
            if (!chkPhanQuyen()) {
                return view('errors.noperm');
            }
            $inputs = $request->all();
            $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
            $m_khenthuong = dshosothiduakhenthuong_khenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->get();
            $model->tendonvi = getThongTinDonVi($model->madonvi, 'tendonvi');
            $m_donvi = getDonVi(session('admin')->capdo);
            $m_diaban = dsdiaban::wherein('madiaban', array_column($m_donvi->toarray(), 'madiaban'))->get();
            $m_danhhieu = dmdanhhieuthidua::all();
            $m_canhan = getDoiTuongKhenThuong($model->madonvi);
            $m_tapthe = getTapTheKhenThuong($model->madonvi);
            return view('NghiepVu.KhenThuongDotXuat.HoSo.ThayDoi')
                ->with('model', $model)
                ->with('model_canhan', $m_khenthuong->where('phanloai', 'CANHAN'))
                ->with('model_tapthe', $m_khenthuong->where('phanloai', 'TAPTHE'))
                ->with('m_donvi', $m_donvi)
                ->with('m_diaban', $m_diaban)
                ->with('m_danhhieu', $m_danhhieu)
                ->with('m_canhan', $m_canhan)
                ->with('m_tapthe', $m_tapthe)
                ->with('a_danhhieu', array_column($m_danhhieu->toArray(), 'tendanhhieutd', 'madanhhieutd'))
                ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
                ->with('a_hinhthuckt', array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
                ->with('inputs', $inputs)
                ->with('pageTitle', 'Th??ng tin h??? s?? ????? ngh??? khen th?????ng');
        } else
            return view('errors.notlogin');
    }

    public function XemHoSo(Request $request)
    {
        if (Session::has('admin')) {
            if (!chkPhanQuyen()) {
                return view('errors.noperm');
            }
            $inputs = $request->all();
            $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
            $m_khenthuong = dshosothiduakhenthuong_khenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->get();
            $model->tendonvi = getThongTinDonVi($model->madonvi, 'tendonvi');
            $m_donvi = getDonVi(session('admin')->capdo);
            $m_diaban = dsdiaban::wherein('madiaban', array_column($m_donvi->toarray(), 'madiaban'))->get();
            $m_danhhieu = dmdanhhieuthidua::all();
            $m_canhan = getDoiTuongKhenThuong($model->madonvi);
            $m_tapthe = getTapTheKhenThuong($model->madonvi);
            return view('NghiepVu.KhenThuongDotXuat.HoSo.Xem')
                ->with('model', $model)
                ->with('model_canhan', $m_khenthuong->where('phanloai', 'CANHAN'))
                ->with('model_tapthe', $m_khenthuong->where('phanloai', 'TAPTHE'))
                ->with('m_donvi', $m_donvi)
                ->with('m_diaban', $m_diaban)
                ->with('m_danhhieu', $m_danhhieu)
                ->with('m_canhan', $m_canhan)
                ->with('m_tapthe', $m_tapthe)
                ->with('a_danhhieu', array_column($m_danhhieu->toArray(), 'tendanhhieutd', 'madanhhieutd'))
                ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
                ->with('a_hinhthuckt', array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
                ->with('inputs', $inputs)
                ->with('pageTitle', 'Th??ng tin h??? s?? ????? ngh??? khen th?????ng');
        } else
            return view('errors.notlogin');
    }

    public function Them(Request $request)
    {
        if (Session::has('admin')) {
            //t??i kho???n SSA; t??i kho???n qu???n tr??? + c?? ph??n quy???n
            if (!chkPhanQuyen()) {
                return view('errors.noperm');
            }
            $inputs = $request->all();
            $inputs['mahosotdkt'] = (string)getdate()[0];
            $inputs['trangthai'] = 'CC';
            $inputs['phanloai'] = 'DOTXUAT';
            dshosothiduakhenthuong::create($inputs);
            return redirect('/KhenThuongDotXuat/HoSo/Sua?mahosotdkt=' . $inputs['mahosotdkt']);
        } else
            return view('errors.notlogin');
    }

    public function LuuHoSo(Request $request)
    {
        if (Session::has('admin')) {
            //t??i kho???n SSA; t??i kho???n qu???n tr??? + c?? ph??n quy???n
            if (!chkPhanQuyen()) {
                return view('errors.noperm');
            }
            $inputs = $request->all();
            if (isset($inputs['totrinh'])) {
                $filedk = $request->file('totrinh');
                $inputs['totrinh'] = $inputs['mahosotdkt'].'_totrinh.'. $filedk->getClientOriginalExtension();
                $filedk->move(public_path() . '/data/totrinh/', $inputs['totrinh']);
            }
            if (isset($inputs['baocao'])) {
                $filedk = $request->file('baocao');
                $inputs['baocao'] = $inputs['mahosotdkt'].'_baocao.'. $filedk->getClientOriginalExtension();
                $filedk->move(public_path() . '/data/baocao/', $inputs['baocao']);
            }
            if (isset($inputs['bienban'])) {
                $filedk = $request->file('bienban');
                $inputs['bienban'] =$inputs['mahosotdkt'].'_bienban.'. $filedk->getClientOriginalExtension();
                $filedk->move(public_path() . '/data/bienban/', $inputs['bienban']);
            }
            if (isset($inputs['tailieukhac'])) {
                $filedk = $request->file('tailieukhac');
                $inputs['tailieukhac'] =$inputs['mahosotdkt'].'tailieukhac.'. $filedk->getClientOriginalExtension();
                $filedk->move(public_path() . '/data/tailieukhac/', $inputs['tailieukhac']);
            }
            dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first()->update($inputs);

            return redirect('/KhenThuongDotXuat/HoSo/ThongTin?madonvi=' . $inputs['madonvi']);
        } else
            return view('errors.notlogin');
    }

    public function ThemCaNhan(Request $request)
    {
        if (Session::has('admin')) {
            $inputs = $request->all();
            $model = dshosothiduakhenthuong_khenthuong::where('madoituong', $inputs['madoituong'])->where('mahosotdkt', $inputs['mahosotdkt'])->first();

            if ($model == null) {
                $inputs['madoituong'] = (string)getdate()[0];
                $inputs['phanloai'] = 'CANHAN';
                dshosothiduakhenthuong_khenthuong::create($inputs);
            } else
                $model->update($inputs);

            if (isset($inputs['filedk'])) {
                $filedk = $request->file('filedk');
                $inputs['filedk'] = $inputs['madoituong'] . '_detai.' . $filedk->getClientOriginalExtension();
                $filedk->move(public_path() . '/data/sangkien/', $inputs['filedk']);
            }
            //dd($inputs);
            return redirect('/KhenThuongDotXuat/HoSo/Sua?mahosotdkt=' . $inputs['mahosotdkt']);
        } else
            return view('errors.notlogin');
    }

    public function ThemTapThe(Request $request)
    {
        if (Session::has('admin')) {
            $inputs = $request->all();
            $model = dshosothiduakhenthuong_khenthuong::where('matapthe', $inputs['matapthe'])->where('mahosotdkt', $inputs['mahosotdkt'])->first();

            if ($model == null) {
                $inputs['matapthe'] = (string)getdate()[0];
                $inputs['phanloai'] = 'TAPTHE';
                dshosothiduakhenthuong_khenthuong::create($inputs);
            } else
                $model->update($inputs);

            if (isset($inputs['filedk'])) {
                $filedk = $request->file('filedk');
                $inputs['filedk'] = $inputs['matapthe'] . '_detai.' . $filedk->getClientOriginalExtension();
                $filedk->move(public_path() . '/data/sangkien/', $inputs['filedk']);
            }
            //dd($inputs);
            return redirect('/KhenThuongDotXuat/HoSo/Sua?mahosotdkt=' . $inputs['mahosotdkt']);
        } else
            return view('errors.notlogin');
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
        //Ch??a t???i ??u v?? t??m ki???m tr??ng ?????i t?????ng
        $model = dshosothiduakhenthuong_tieuchuan::where('madoituong', $inputs['madoituong'])
            ->where('madanhhieutd', $inputs['madanhhieutd'])
            ->where('mahosotdkt', $inputs['mahosotdkt'])->get();
        $model_tieuchuan = dmdanhhieuthidua_tieuchuan::where('madanhhieutd', $inputs['madanhhieutd'])->get();

        if (isset($model_tieuchuan)) {

            $result['message'] = '<div class="row" id="dstieuchuan">';

            $result['message'] .= '<div class="col-md-12">';
            $result['message'] .= '<table id="sample_4" class="table table-striped table-bordered table-hover" >';
            $result['message'] .= '<thead>';
            $result['message'] .= '<tr>';
            $result['message'] .= '<th width="2%" style="text-align: center">STT</th>';
            $result['message'] .= '<th style="text-align: center">T??n ti??u chu???n</th>';
            $result['message'] .= '<th style="text-align: center" width="15%">B???t bu???c</th>';
            $result['message'] .= '<th style="text-align: center" width="15%">?????t ??i???u ki??n</th>';
            $result['message'] .= '<th style="text-align: center" width="10%">Thao t??c</th>';
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
                $result['message'] .= '<td>' .
                    '<button type="button" data-target="#modal-luutieuchuan" data-toggle="modal" class="btn btn-sm btn-clean btn-icon" onclick="ThayDoiTieuChuan(' . chr(39) . $ct->matieuchuandhtd . chr(39) . ',' . chr(39) . $ct->tentieuchuandhtd . chr(39) . ')"><i class="fa fa-edit"></i></button>'
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
        //$m_danhhieu = dmdanhhieutd::where('madanhhieutd', $inputs['madanhhieutd'])->first();
        //Ch??a t???i ??u v?? t??m ki???m tr??ng ?????i t?????ng
        $model = dshosothiduakhenthuong_tieuchuan::where('madoituong', $inputs['madoituong'])
            ->where('matieuchuandhtd', $inputs['matieuchuandhtd'])
            ->where('madanhhieutd', $inputs['madanhhieutd'])
            ->where('mahosotdkt', $inputs['mahosotdkt'])->first();

        //ch??a l???y bi???n ??i???u ki???n ??ang d??ng t???m ????? demo
        if ($model == null) {
            $model = new dshosothiduakhenthuong_tieuchuan();
            $model->madoituong = $inputs['madoituong'];
            $model->matieuchuandhtd = $inputs['matieuchuandhtd'];
            $model->madanhhieutd = $inputs['madanhhieutd'];
            //$model->madonvi = $inputs['madonvi'];
            $model->mahosotdkt = $inputs['mahosotdkt'];
            $model->dieukien = 1;
            $model->save();
        } else {
            $model->dieukien = 1;
            $model->save();
        }
        //
        $model = dshosothiduakhenthuong_tieuchuan::where('madoituong', $inputs['madoituong'])
            ->where('madanhhieutd', $inputs['madanhhieutd'])
            ->where('mahosotdkt', $inputs['mahosotdkt'])->get();
        $model_tieuchuan = dmdanhhieuthidua_tieuchuan::where('madanhhieutd', $inputs['madanhhieutd'])->get();

        if (isset($model_tieuchuan)) {

            $result['message'] = '<div class="row" id="dstieuchuan">';

            $result['message'] .= '<div class="col-md-12">';
            $result['message'] .= '<table id="sample_4" class="table table-striped table-bordered table-hover" >';
            $result['message'] .= '<thead>';
            $result['message'] .= '<tr>';
            $result['message'] .= '<th width="2%" style="text-align: center">STT</th>';
            $result['message'] .= '<th style="text-align: center">T??n ti??u chu???n</th>';
            $result['message'] .= '<th style="text-align: center" width="15%">B???t bu???c</th>';
            $result['message'] .= '<th style="text-align: center" width="15%">?????t ??i???u ki??n</th>';
            $result['message'] .= '<th style="text-align: center" width="10%">Thao t??c</th>';
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
                $result['message'] .= '<td>' .
                    '<button type="button" data-target="#modal-luutieuchuan" data-toggle="modal" class="btn btn-sm btn-clean btn-icon" onclick="ThayDoiTieuChuan(' . chr(39) . $ct->matieuchuandhtd . chr(39) . ',' . chr(39) . $ct->tentieuchuandhtd . chr(39) . ')"><i class="fa fa-edit"></i></button>'
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
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahosotdkt'])->first();
        die(json_encode($model));
    }

    public function XoaDoiTuong(Request $request)
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
        $model = dshosothiduakhenthuong_khenthuong::findorfail($inputs['id']);
        $model->delete();
        return redirect('/KhenThuongDotXuat/HoSo/Sua?mahosotdkt=' . $model->mahosotdkt);
    }

    public function ChuyenHoSo(Request $request)
    {
        if (Session::has('admin')) {
            $inputs = $request->all();
            $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahoso'])->first();
            $m_donvi = viewdiabandonvi::where('madonvi', $inputs['madonvi_nhan'])->first();
            
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
            $trangthai->phanloai = 'dshosothiduakhenthuong';
            $trangthai->mahoso = $model->mahosotdkt;
            $trangthai->thoigian = $model->thoigian;
            $trangthai->save();

            return redirect('/KhenThuongDotXuat/HoSo/ThongTin?madonvi=' . $model->madonvi);
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
        //dd($request);
        $inputs = $request->all();
        $model = dshosothiduakhenthuong_khenthuong::findorfail($inputs['id']);
        die(json_encode($model));
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
        return redirect('/KhenThuongDotXuat/HoSo/ThongTin?madonvi=' . $model->madonvi);
    }
}
