<?php

namespace App\Http\Controllers\NghiepVu\KhenCao;


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
use App\Model\NghiepVu\KhenCao\dshosokhencao;
use App\Model\NghiepVu\KhenCao\dshosokhencao_khenthuong;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosokhenthuong;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_khenthuong;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_tieuchuan;
use App\Model\View\viewdiabandonvi;
use Illuminate\Support\Facades\Session;

class dshosokhencaoController extends Controller
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
            $model = dshosokhencao::where('madonvi', $inputs['madonvi']);
            if ($inputs['maloaihinhkt'] != 'ALL')
                $model = $model->where('maloaihinhkt', $inputs['maloaihinhkt']);
            $model = $model->orderby('ngayhoso')->get();
            

            return view('NghiepVu.KhenCao.HoSo.ThongTin')
                ->with('model', $model)
                ->with('a_donvi', array_column($m_donvi->toArray(), 'tendonvi', 'madonvi'))
                ->with('a_capdo', getPhamViApDung())
                ->with('m_donvi', $m_donvi)
                ->with('m_diaban', $m_diaban)
                ->with('a_donviql', getDonViQuanLyDiaBan($donvi->madiaban))
                ->with('a_loaihinhkt', array_column($m_loaihinh->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
                ->with('inputs', $inputs)
                ->with('pageTitle', 'Danh s??ch h??? s?? khen cao');
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
            $model = dshosokhencao::where('mahosokt', $inputs['mahosokt'])->first();
            $m_khenthuong = dshosokhencao_khenthuong::where('mahosokt', $inputs['mahosokt'])->get();
            $model->tendonvi = getThongTinDonVi($model->madonvi, 'tendonvi');
            $m_donvi = getDonVi(session('admin')->capdo);
            $m_diaban = dsdiaban::wherein('madiaban', array_column($m_donvi->toarray(), 'madiaban'))->get();
            $m_danhhieu = dmdanhhieuthidua::all();
            $m_canhan = getDoiTuongKhenCao();
            $m_tapthe = getTapTheKhenCao();
            $model_canhan= $m_khenthuong->where('phanloai', 'CANHAN');
            $model_tapthe = $m_khenthuong->where('phanloai', 'TAPTHE');
            
            return view('NghiepVu.KhenCao.HoSo.ThayDoi')
                ->with('model', $model)
                ->with('model_canhan', $model_canhan)
                ->with('model_tapthe', $model_tapthe)
                ->with('m_donvi', $m_donvi)
                ->with('m_diaban', $m_diaban)
                ->with('m_danhhieu', $m_danhhieu)
                ->with('m_canhan', $m_canhan)
                ->with('m_tapthe', $m_tapthe)
                ->with('a_danhhieu', array_column($m_danhhieu->toArray(), 'tendanhhieutd', 'madanhhieutd'))
                ->with('a_donvi', array_column($m_donvi->toArray(), 'tendonvi', 'madonvi'))
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
            $model = dshosokhencao::where('mahosokt', $inputs['mahosokt'])->first();
            $m_khenthuong = dshosokhencao_khenthuong::where('mahosokt', $inputs['mahosokt'])->get();
            $model->tendonvi = getThongTinDonVi($model->madonvi, 'tendonvi');
            $m_donvi = getDonVi(session('admin')->capdo);
            $m_diaban = dsdiaban::wherein('madiaban', array_column($m_donvi->toarray(), 'madiaban'))->get();
            $m_danhhieu = dmdanhhieuthidua::all();
            $m_canhan = getDoiTuongKhenCao($model->madonvi);
            $m_tapthe = getTapTheKhenCao($model->madonvi);
            return view('NghiepVu.KhenCao.HoSo.Xem')
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
            $inputs['mahosokt'] = (string)getdate()[0];
            $inputs['trangthai'] = 'CC';
            $inputs['phanloai'] = 'KHENTHUONG';
            dshosokhencao::create($inputs);
            return redirect('/KhenCao/HoSo/Sua?mahosokt=' . $inputs['mahosokt']);
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
            dshosokhencao::where('mahosokt', $inputs['mahosokt'])->first()->update($inputs);

            return redirect('/KhenCao/HoSo/ThongTin?madonvi=' . $inputs['madonvi']);
        } else
            return view('errors.notlogin');
    }

    public function ThemCaNhan(Request $request)
    {
        if (Session::has('admin')) {
            $inputs = $request->all();
            $model = dshosokhencao_khenthuong::where('madoituong', $inputs['madoituong'])->where('mahosokt', $inputs['mahosokt'])->first();

            if ($model == null) {
                $inputs['madoituong'] = (string)getdate()[0];
                $inputs['phanloai'] = 'CANHAN';
                dshosokhencao_khenthuong::create($inputs);
            } else
                $model->update($inputs);

            if (isset($inputs['filedk'])) {
                $filedk = $request->file('filedk');
                $inputs['filedk'] = $inputs['madoituong'] . '_detai.' . $filedk->getClientOriginalExtension();
                $filedk->move(public_path() . '/data/sangkien/', $inputs['filedk']);
            }
            //dd($inputs);
            return redirect('/KhenCao/HoSo/Sua?mahosokt=' . $inputs['mahosokt']);
        } else
            return view('errors.notlogin');
    }

    public function ThemTapThe(Request $request)
    {
        if (Session::has('admin')) {
            $inputs = $request->all();
            $model = dshosokhencao_khenthuong::where('matapthe', $inputs['matapthe'])->where('mahosokt', $inputs['mahosokt'])->first();

            if ($model == null) {
                $inputs['matapthe'] = (string)getdate()[0];
                $inputs['phanloai'] = 'TAPTHE';
                dshosokhencao_khenthuong::create($inputs);
            } else
                $model->update($inputs);

            if (isset($inputs['filedk'])) {
                $filedk = $request->file('filedk');
                $inputs['filedk'] = $inputs['matapthe'] . '_detai.' . $filedk->getClientOriginalExtension();
                $filedk->move(public_path() . '/data/sangkien/', $inputs['filedk']);
            }
            //dd($inputs);
            return redirect('/KhenCao/HoSo/Sua?mahosokt=' . $inputs['mahosokt']);
        } else
            return view('errors.notlogin');
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
        $model = dshosokhencao::where('mahosotdkt', $inputs['mahosotdkt'])->first();
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
        $model = dshosokhencao_khenthuong::findorfail($inputs['iddelete']);
        $model->delete();
        return redirect('/KhenCao/HoSo/Sua?mahosokt=' .  $model->mahosokt);
    }

    public function NhanHoSo(Request $request)
    {
        if (Session::has('admin')) {
            $inputs = $request->all();
            $model = dshosokhencao::where('mahosokt', $inputs['mahoso'])->first();
            //$m_donvi = viewdiabandonvi::where('madonvi', $inputs['madonvi_nhan'])->first();
            
            $model->trangthai = 'DD';
            //$model->madonvi_nhan = $inputs['madonvi_nhan'];
            $model->thoigian = date('Y-m-d H:i:s');
            //setChuyenHoSo($m_donvi->capdo, $model, ['madonvi' => $inputs['madonvi_nhan'], 'thoigian' => $model->thoigian, 'trangthai' => 'CD']);
            //dd($model);
            $model->save();

            $trangthai = new trangthaihoso();
            $trangthai->trangthai = 'DD';
            $trangthai->madonvi = $model->madonvi;
            $trangthai->madonvi_nhan = $inputs['madonvi_nhan'];
            $trangthai->phanloai = 'dshosokhencao';
            $trangthai->mahoso = $model->mahosotdkt;
            $trangthai->thoigian = $model->thoigian;
            $trangthai->save();

            return redirect('/KhenCao/HoSo/ThongTin?madonvi=' . $model->madonvi);
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
        $model = dshosokhencao_khenthuong::findorfail($inputs['id']);
        die(json_encode($model));
    }
}
