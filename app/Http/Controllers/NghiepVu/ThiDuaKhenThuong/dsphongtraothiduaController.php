<?php

namespace App\Http\Controllers\NghiepVu\ThiDuaKhenThuong;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\DanhMuc\dmdanhhieuthidua;
use App\Model\DanhMuc\dmdanhhieuthidua_tieuchuan;
use App\Model\DanhMuc\dmhinhthuckhenthuong;
use App\Model\DanhMuc\dmloaihinhkhenthuong;
use App\Model\DanhMuc\dsdiaban;
use App\Model\DanhMuc\dsdonvi;
use App\Model\HeThong\trangthaihoso;
use App\Model\NghiepVu\ThiDuaKhenThuong\dsphongtraothidua;
use App\Model\NghiepVu\ThiDuaKhenThuong\dsphongtraothidua_khenthuong;
use App\Model\NghiepVu\ThiDuaKhenThuong\dsphongtraothidua_tieuchuan;
use App\Model\View\viewdiabandonvi;
use Illuminate\Support\Facades\Session;

class dsphongtraothiduaController extends Controller
{
    public static $url = '';
    public function __construct()
    {
        static::$url = '/PhongTraoThiDua/';
        $this->middleware(function ($request, $next) {
            if (!Session::has('admin')) {
                return redirect('/');
            };
            return $next($request);
        });
    }

    public function ThongTin(Request $request)
    {
        if (!chkPhanQuyen('dsphongtraothidua', 'danhsach')) {
            return view('errors.noperm')->with('machucang', 'dsphongtraothidua');
        }
        $inputs = $request->all();
        $m_donvi = getDonVi(session('admin')->capdo);
        $m_diaban = getDiaBan(session('admin')->capdo);
        $inputs['nam'] = $inputs['nam'] ?? 'ALL';
        $inputs['madonvi'] = $inputs['madonvi'] ?? $m_donvi->first()->madonvi;
        $inputs['phanloai'] = $inputs['phanloai'] ?? 'ALL';
        $inputs['phamviapdung'] = $inputs['phamviapdung'] ?? 'ALL';
        $model = dsphongtraothidua::where('madonvi', $inputs['madonvi']);
        if ($inputs['nam'] != 'ALL')
            $model = $model->whereYear('ngayqd', $inputs['nam']);
        if ($inputs['phanloai'] != 'ALL')
            $model = $model->where('phanloai', $inputs['phanloai']);

        return view('NghiepVu.ThiDuaKhenThuong.PhongTraoThiDua.ThongTin')
            ->with('model', $model->orderby('ngayqd')->get())
            ->with('m_donvi', $m_donvi)
            ->with('m_diaban', $m_diaban)
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('a_phamvi', getPhamViPhongTrao($m_donvi->where('madonvi', $inputs['madonvi'])->first()->capdo ?? 'T'))
            ->with('a_phanloai', getPhanLoaiPhongTraoThiDua(true))
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Danh sách phong trào thi đua');
    }

    public function ThayDoi(Request $request)
    {
        if (!chkPhanQuyen('dsphongtraothidua', 'thaydoi')) {
            return view('errors.noperm')->with('machucang', 'dsphongtraothidua');
        }

        $inputs = $request->all();
        $inputs['maphongtraotd'] = $inputs['maphongtraotd'] ?? null;
        $model = dsphongtraothidua::where('maphongtraotd', $inputs['maphongtraotd'])->first();
        $inputs['madonvi'] = $inputs['madonvi'] ?? $model->madonvi;
        $donvi = viewdiabandonvi::where('madonvi', $inputs['madonvi'])->first();

        if ($model == null) {
            $model = new dsphongtraothidua();
            $model->madonvi = $inputs['madonvi'];
            $model->maphongtraotd = getdate()[0];
            $model->trangthai = 'CC';
            $model->phanloai = $donvi->capdo;
            $model->maloaihinhkt = session('chucnang')['dsphongtraothidua']['mahinhthuckt'] ?? '';
        }
        $model->tendonvi = getThongTinDonVi($model->madonvi, 'tendonvi');
        $model_tieuchuan = dsphongtraothidua_tieuchuan::where('maphongtraotd', $model->maphongtraotd)->get();
        //dd($model_tieuchuan);
        return view('NghiepVu.ThiDuaKhenThuong.PhongTraoThiDua.ThayDoi')
            ->with('model', $model)
            ->with('model_tieuchuan', $model_tieuchuan)
            ->with('a_tieuchuan', array_column(dmdanhhieuthidua_tieuchuan::all()->toArray(), 'tentieuchuandhtd', 'matieuchuandhtd'))
            ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
            ->with('a_hinhthuckt', array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
            ->with('a_phamvi', getPhamViPhongTrao($donvi->capdo))
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Danh sách phong trào thi đua');
    }

    public function XemThongTin(Request $request)
    {
        $inputs = $request->all();
        $model = dsphongtraothidua::where('maphongtraotd', $inputs['maphongtraotd'])->first();
        $model->tendonvi = getThongTinDonVi($model->madonvi, 'tendonvi');
        $model_tieuchi = dsphongtraothidua_tieuchuan::where('maphongtraotd', $model->maphongtraotd)->get();
        $m_donvi = dsdonvi::where('madonvi', $model->madonvi)->first();
        return view('NghiepVu.ThiDuaKhenThuong.PhongTraoThiDua.InPhongTrao')
            ->with('model', $model)
            ->with('model_tieuchi', $model_tieuchi)
            ->with('m_donvi', $m_donvi)
            ->with('a_phamvi', getPhamViPhongTrao('T'))
            ->with('a_phanloai', getPhanLoaiPhongTraoThiDua(true))
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Danh sách phong trào thi đua');
    }

    public function LuuPhongTrao(Request $request)
    {

        if (!chkPhanQuyen('dsphongtraothidua', 'thaydoi')) {
            return view('errors.noperm')->with('machucang', 'dsphongtraothidua');
        }
        $inputs = $request->all();
        if (isset($inputs['qdkt'])) {
            $filedk = $request->file('qdkt');
            $inputs['qdkt'] = $inputs['maphongtraotd'] . '_qd.' . $filedk->getClientOriginalExtension();
            $filedk->move(public_path() . '/data/qdkt/', $inputs['qdkt']);
        }

        if (isset($inputs['tailieukhac'])) {
            $filedk = $request->file('tailieukhac');
            $inputs['tailieukhac'] = $inputs['maphongtraotd'] . '_tailieukhac.' . $filedk->getClientOriginalExtension();
            $filedk->move(public_path() . '/data/tailieukhac/', $inputs['tailieukhac']);
        }

        $model = dsphongtraothidua::where('maphongtraotd', $inputs['maphongtraotd'])->first();
        if ($model == null) {
            $inputs['trangthai'] = 'CC';
            dsphongtraothidua::create($inputs);

            $trangthai = new trangthaihoso();
            $trangthai->trangthai = 'CC';
            $trangthai->madonvi = $inputs['madonvi'];
            $trangthai->phanloai = 'dsphongtraothidua';
            $trangthai->mahoso = $inputs['maphongtraotd'];
            $trangthai->thoigian = date('Y-m-d H:i:s');
            $trangthai->save();
        } else {
            $model->update($inputs);
        }

        return redirect(static::$url . 'ThongTin?madonvi=' . $inputs['madonvi']);
    }


    public function delete(Request $request)
    {
        if (!chkPhanQuyen('dsphongtraothidua', 'thaydoi')) {
            return view('errors.noperm')->with('machucang', 'dsphongtraothidua');
        }
        $inputs = $request->all();
        $model = dsphongtraothidua::findorfail($inputs['iddelete']);
        $model->delete();
        return redirect(static::$url . 'ThongTin?madonvi=' . $model->madonvi);
    }

    public function ThemKhenThuong(Request $request)
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
        $m_danhhieu = dmdanhhieuthidua::where('madanhhieutd', $inputs['madanhhieutd'])->first();
        $model = dsphongtraothidua_khenthuong::where('madanhhieutd', $inputs['madanhhieutd'])
            ->where('maphongtraotd', $inputs['maphongtraotd'])->first();
        if ($model == null) {
            $model = new dsphongtraothidua_khenthuong();
            $model->madanhhieutd = $m_danhhieu->madanhhieutd;
            $model->mahinhthuckt = $inputs['mahinhthuckt'];
            $model->maphongtraotd = $inputs['maphongtraotd'];
            $model->soluong = $inputs['soluong'];
            $model->tendanhhieutd = $m_danhhieu->tendanhhieutd;
            $model->phanloai = $m_danhhieu->phanloai;
            $model->save();
            $m_tieuchuan = dmdanhhieuthidua_tieuchuan::where('madanhhieutd', $inputs['madanhhieutd'])->get();
            foreach ($m_tieuchuan as $tieuchuan) {
                $model = new dsphongtraothidua_tieuchuan();
                $model->maphongtraotd = $inputs['maphongtraotd'];
                $model->madanhhieutd = $tieuchuan->madanhhieutd;
                $model->matieuchuandhtd = $tieuchuan->matieuchuandhtd;
                $model->tentieuchuandhtd = $tieuchuan->tentieuchuandhtd;
                $model->cancu = $tieuchuan->cancu;
                $model->batbuoc = 1;
                $model->save();
            }
        } else {
            $model->soluong = $inputs['soluong'];
            $model->mahinhthuckt = $inputs['mahinhthuckt'];
            $model->tendanhhieutd = $m_danhhieu->tendanhhieutd;
            $model->phanloai = $m_danhhieu->phanloai;
            $model->save();
        }

        $modelct = dsphongtraothidua_khenthuong::where('maphongtraotd', $inputs['maphongtraotd'])->get();
        $a_hinhthuckt = array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt');
        if (isset($modelct)) {

            $result['message'] = '<div class="row" id="dskhenthuong">';

            $result['message'] .= '<div class="col-md-12">';
            $result['message'] .= '<table id="sample_3" class="table table-striped table-bordered table-hover" >';
            $result['message'] .= '<thead>';
            $result['message'] .= '<tr>';
            $result['message'] .= '<th width="2%" style="text-align: center">STT</th>';
            $result['message'] .= '<th style="text-align: center" width="25%">Phân loại</th>';
            $result['message'] .= '<th style="text-align: center">Danh hiệu thi đua</th>';
            $result['message'] .= '<th style="text-align: center">Hình thức khen thưởng</th>';
            $result['message'] .= '<th style="text-align: center" width="8%">Số lượng</th>';
            $result['message'] .= '<th style="text-align: center" width="10%">Thao tác</th>';
            $result['message'] .= '</tr>';
            $result['message'] .= '</thead>';

            $result['message'] .= '<tbody>';
            $key = 1;
            foreach ($modelct as $ct) {

                $result['message'] .= '<tr>';
                $result['message'] .= '<td style="text-align: center">' . $key++ . '</td>';
                $result['message'] .= '<td>' . $ct->phanloai . '</td>';
                $result['message'] .= '<td class="active">' . $ct->tendanhhieutd . '</td>';
                $result['message'] .= '<td>' . ($a_hinhthuckt[$ct->mahinhthuckt] ?? '') . '</td>';
                $result['message'] .= '<td style="text-align: center">' . $ct->soluong . '</td>';
                $result['message'] .= '<td>' .
                    '<button title="Tiêu chuẩn" type="button" onclick="getTieuChuan(' . $ct->madanhhieutd . ')" class="btn btn-sm btn-clean btn-icon" data-target="#modal-tieuchuan" data-toggle="modal"> <i class="icon-lg la fa-list text-dark"></i></button>' .
                    '<button title="Xóa" type="button" onclick="getId(' . $ct->id . ')"  class="btn btn-sm btn-clean btn-icon" data-target="#delete-modal" data-toggle="modal">  <i class="icon-lg la fa-trash-alt text-danger"></i></button>' .
                    '</td>';

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

    public function ThemTieuChuan(Request $request)
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
        $model = dsphongtraothidua_tieuchuan::where('maphongtraotd', $inputs['maphongtraotd'])->where('matieuchuandhtd', $inputs['matieuchuandhtd'])->first();
        if ($model == null) {
            $model = new dsphongtraothidua_tieuchuan();
            $model->maphongtraotd = $inputs['maphongtraotd'];
            $model->tentieuchuandhtd = $inputs['tentieuchuandhtd'];
            $model->matieuchuandhtd = getdate()[0];
            $model->batbuoc = isset($inputs['batbuoc']) ? 1 : 0;
            $model->save();
        } else {
            $model->batbuoc = isset($inputs['batbuoc']) ? 1 : 0;
            $model->tentieuchuandhtd = $inputs['tentieuchuandhtd'];
            $model->save();
        }

        $modelct = dsphongtraothidua_tieuchuan::where('maphongtraotd', $inputs['maphongtraotd'])->get();
        if (isset($modelct)) {

            $result['message'] = '<div class="row" id="dstieuchuan">';

            $result['message'] .= '<div class="col-md-12">';
            $result['message'] .= '<table id="sample_4" class="table table-striped table-bordered table-hover" >';
            $result['message'] .= '<thead>';
            $result['message'] .= '<tr>';
            $result['message'] .= '<th width="5%" style="text-align: center">STT</th>';
            $result['message'] .= '<th style="text-align: center">Tên tiêu chuẩn xét khen thưởng</th>';
            $result['message'] .= '<th style="text-align: center" width="10%">Tiêu chuẩn</br>Bắt buộcc</th>';
            $result['message'] .= '<th style="text-align: center" width="10%">Thao tác</th>';
            $result['message'] .= '</tr>';
            $result['message'] .= '</thead>';

            $result['message'] .= '<tbody>';
            $key = 1;
            foreach ($modelct as $ct) {

                $result['message'] .= '<tr>';
                $result['message'] .= '<td style="text-align: center">' . $key++ . '</td>';
                $result['message'] .= '<td class="active">' . $ct->tentieuchuandhtd . '</td>';
                $result['message'] .= '<td style="text-align: center">' . $ct->batbuoc . '</td>';
                $result['message'] .= '<td>' .
                    '<button type="button" data-target="#modal-tieuchuan" data-toggle="modal" class="btn btn-sm btn-clean btn-icon" onclick="getTieuChuan(' . $ct->id . ')" ><i class="icon-lg la fa-edit text-dark"></i></button>' .
                    '<button type="button" data-target="#delete-modal" data-toggle="modal" class="btn btn-sm btn-clean btn-icon" onclick="editDanhHieu(' . $ct->id . ')"><i class="icon-lg la fa-trash-alt text-dangert"></i></button>'
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
        $model = dsphongtraothidua_tieuchuan::findorfail($inputs['id']);
        die(json_encode($model));
    }

    public function TaiLieuDinhKem(Request $request)
    {
        $result = array(
            'status' => 'fail',
            'message' => 'error',
        );

        $inputs = $request->all();
        $model = dsphongtraothidua::where('maphongtraotd', $inputs['mahs'])->first();
        $result['message'] = '<div class="modal-body" id = "dinh_kem" >';

        if (isset($model->qdkt)) {
            $result['message'] .= '<div class="form-group row">';
            $result['message'] .= '<label class="col-3 col-form-label font-weight-bold" >Quyết định:</label>';
            $result['message'] .= '<div class="col-9 form-control"><a target = "_blank" href = "' . url('/data/qdkt/' . $model->qdkt) . '">' . $model->qdkt . '</a ></div>';
            $result['message'] .= '</div>';
        }

        if (isset($model->tailieukhac)) {
            $result['message'] .= '<div class="form-group row">';
            $result['message'] .= '<label class="col-3 col-form-label font-weight-bold" >Tài liệu khác:</label>';
            $result['message'] .= '<div class="col-9 form-control"><a target = "_blank" href = "' . url('/data/tailieukhac/' . $model->tailieukhac) . '">' . $model->tailieukhac . '</a ></div>';
            $result['message'] .= '</div>';
        }
        $result['message'] .= '</div>';
        $result['status'] = 'success';

        die(json_encode($result));
    }
}
