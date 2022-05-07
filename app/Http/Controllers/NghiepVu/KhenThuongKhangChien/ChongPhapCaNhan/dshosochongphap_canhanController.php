<?php

namespace App\Http\Controllers\NghiepVu\KhenThuongKhangChien\ChongPhapCaNhan;


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
use App\Model\NghiepVu\KhenThuongKhangChien\dshosochongphap_canhan;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosokhenthuong;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_khenthuong;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_tieuchuan;
use App\Model\View\viewdiabandonvi;
use Illuminate\Support\Facades\Session;

class dshosochongphap_canhanController extends Controller
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
            $model = dshosochongphap_canhan::where('madonvi', $inputs['madonvi']);
            if ($inputs['maloaihinhkt'] != 'ALL')
                $model = $model->where('maloaihinhkt', $inputs['maloaihinhkt']);
            $model = $model->orderby('ngayhoso')->get();            

            return view('NghiepVu.KhenThuongKhangChien.ChongPhapCaNhan.HoSo.ThongTin')
                ->with('model', $model)
                ->with('a_donvi', array_column($m_donvi->toArray(), 'tendonvi', 'madonvi'))
                ->with('a_capdo', getPhamViApDung())
                ->with('m_donvi', $m_donvi)
                ->with('m_diaban', $m_diaban)
                ->with('a_loaihinhkt', array_column($m_loaihinh->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
                ->with('a_hinhthuckt', array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
                ->with('inputs', $inputs)
                ->with('pageTitle', 'Danh sách hồ sơ khen thưởng kháng chiến chống pháp cho cá nhân');
        } else
            return view('errors.notlogin');
    }

    public function SuaHoSo(Request $request)
    {
        if (Session::has('admin')) {
            if (!chkPhanQuyen()) {
                return view('errors.noperm');
            }
            $inputs = $request->all();
            $model = dshosochongphap_canhan::where('mahosokt', $inputs['mahosokt'])->first();
            $model->tendonvi = getThongTinDonVi($model->madonvi, 'tendonvi');
            $m_danhhieu = dmdanhhieuthidua::all();
            return view('NghiepVu.KhenThuongKhangChien.ChongPhapCaNhan.HoSo.ThayDoi')
                ->with('model', $model)
                ->with('a_danhhieu', array_column($m_danhhieu->toArray(), 'tendanhhieutd', 'madanhhieutd'))
                ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
                ->with('a_hinhthuckt', array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
                ->with('inputs', $inputs)
                ->with('pageTitle', 'Thông tin hồ sơ đề nghị khen thưởng');
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
            $model = dshosochongphap_canhan::where('mahosokt', $inputs['mahosokt'])->first();
            $model->tendonvi = getThongTinDonVi($model->madonvi, 'tendonvi');
            $m_danhhieu = dmdanhhieuthidua::all();
            return view('NghiepVu.KhenThuongKhangChien.ChongPhapCaNhan.HoSo.Xem')
                ->with('model', $model)
                ->with('a_danhhieu', array_column($m_danhhieu->toArray(), 'tendanhhieutd', 'madanhhieutd'))
                ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
                ->with('a_hinhthuckt', array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
                ->with('inputs', $inputs)
                ->with('pageTitle', 'Thông tin hồ sơ đề nghị khen thưởng');
        } else
            return view('errors.notlogin');
    }

    public function ThemHoSo(Request $request)
    {
        if (Session::has('admin')) {
            //tài khoản SSA; tài khoản quản trị + có phân quyền
            if (!chkPhanQuyen()) {
                return view('errors.noperm');
            }
            $inputs = $request->all();
            
            $model = new dshosochongphap_canhan;
            $model->trangthai = 'CC';
            $model->mahosokt = (string)getdate()[0];
            $model->madonvi =  $inputs['madonvi'];
            $model->ngayhoso =  date('Y-m-d');
            $model->tendonvi =  getThongTinDonVi($inputs['madonvi'],'tendonvi');           
            $m_danhhieu = dmdanhhieuthidua::all();            
            return view('NghiepVu.KhenThuongKhangChien.ChongPhapCaNhan.HoSo.ThayDoi')
                ->with('model', $model)
                ->with('a_danhhieu', array_column($m_danhhieu->toArray(), 'tendanhhieutd', 'madanhhieutd'))
                ->with('a_loaihinhkt', array_column(dmloaihinhkhenthuong::all()->toArray(), 'tenloaihinhkt', 'maloaihinhkt'))
                ->with('a_hinhthuckt', array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt'))
                ->with('inputs', $inputs)
                ->with('pageTitle', 'Thông tin hồ sơ đề nghị khen thưởng');

        } else
            return view('errors.notlogin');
    }

    public function LuuHoSo(Request $request)
    {
        if (Session::has('admin')) {
            //tài khoản SSA; tài khoản quản trị + có phân quyền
            if (!chkPhanQuyen()) {
                return view('errors.noperm');
            }
            $inputs = $request->all();
            
            if (isset($inputs['tailieukhac'])) {
                $filedk = $request->file('tailieukhac');
                $inputs['tailieukhac'] =$inputs['mahosokt'].'tailieukhac.'. $filedk->getClientOriginalExtension();
                $filedk->move(public_path() . '/data/tailieukhac/', $inputs['tailieukhac']);
            }
            $model = dshosochongphap_canhan::where('mahosokt', $inputs['mahosokt'])->first();
            if($model == null){
                $inputs['trangthai'] = 'CC';
                dshosochongphap_canhan::create($inputs);
            }else
            $model->update($inputs);

            return redirect('/KhenThuongKhangChien/ChongPhapCaNhan/ThongTin?madonvi=' . $inputs['madonvi']);
        } else
            return view('errors.notlogin');
    }    

    public function NhanHoSo(Request $request)
    {
        if (Session::has('admin')) {
            $inputs = $request->all();
            $model = dshosochongphap_canhan::where('mahosokt', $inputs['mahoso'])->first();
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
            $trangthai->phanloai = 'dshosochongphap_canhan';
            $trangthai->mahoso = $model->mahosotdkt;
            $trangthai->thoigian = $model->thoigian;
            $trangthai->save();

            return redirect('/KhenThuongKhangChien/ChongPhapCaNhan/ThongTin?madonvi=' . $model->madonvi);
        } else
            return view('errors.notlogin');
    }   
}
