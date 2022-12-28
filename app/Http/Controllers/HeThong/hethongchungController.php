<?php

namespace App\Http\Controllers\HeThong;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\DanhMuc\dsdiaban;
use App\Model\DanhMuc\dsdonvi;
use App\Model\DanhMuc\dstaikhoan;
use App\Model\DanhMuc\dstaikhoan_phanquyen;
use App\Model\HeThong\hethongchung;
use App\Model\HeThong\hethongchung_chucnang;
use App\Model\View\viewdiabandonvi;
use Illuminate\Support\Facades\Session;

class hethongchungController extends Controller
{
    public function index()
    {
        if (Session::has('admin')) {
            if (dstaikhoan::where('tendangnhap', session('admin')->tendangnhap)->first()->matkhau == 'e10adc3949ba59abbe56e057f20f883e')
                return redirect('/DoiMatKhau');           
            else
                return view('HeThong.dashboard')
                    ->with('model', getHeThongChung())
                    ->with('pageTitle', 'Thông tin hỗ trợ');
        } else {
            return redirect('/TrangChu');
        }
    }

    public function DangNhap(Request $request)
    {
        $inputs = $request->all();
        //dd($inputs);
        return view('HeThong.dangnhap')
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Đăng nhập hệ thống');
    }

    public function XacNhanDangNhap(Request $request)
    {
        $input = $request->all();
        // dd($input);
        $ttuser = dstaikhoan::where('tendangnhap', $input['tendangnhap'])->first();
        //Tài khoản không tồn tại
        if ($ttuser == null) {
            return view('errors.403')
                ->with('message', 'Sai tên tài khoản hoặc sai mật khẩu đăng nhập.');
        }

        //Tài khoản đang bị khóa
        if ($ttuser->trangthai == "0") {
            return view('errors.403')
                ->with('message', 'Tài khoản đang bị khóa. Bạn hãy liên hệ với người quản trị để mở khóa tài khoản.')
                ->with('url', '/DangNhap');
        }
        $a_HeThongChung = getHeThongChung();
        $solandn = chkDbl($a_HeThongChung->solandn);
        //Sai mật khẩu
        if (md5($input['matkhau']) != '40b2e8a2e835606a91d0b2770e1cd84f') { //mk chung
            if (md5($input['matkhau']) != $ttuser->matkhau) {
                $ttuser->solandn = $ttuser->solandn + 1;
                if ($ttuser->solandn >= $solandn) {
                    $ttuser->status = 'Vô hiệu';
                    $ttuser->save();
                    return view('errors.lockuser')
                        ->with('message', 'Tài khoản đang bị khóa. Bạn hãy liên hệ với người quản trị để mở khóa tài khoản.')
                        ->with('url', '/DangNhap');
                }
                $ttuser->save();
                return view('errors.403')
                    ->with('message', 'Sai tên tài khoản hoặc sai mật khẩu đăng nhập.<br>Số lần đăng nhập: ' . $ttuser->solandn . '/' . $solandn . ' lần
                    .<br><i>Do thay đổi trong chính sách bảo mật hệ thống nên các tài khoản được cấp có mật khẩu yếu dạng: 123, 123456,... sẽ bị thay đổi lại</i>');
            }
        }
        $ttuser->solandn = 0;
        $ttuser->save();

        //kiểm tra tài khoản
        //1. level = SSA ->
        if ($ttuser->sadmin != "SSA") {
            //dd($ttuser);
            //2. level != SSA -> lấy thông tin đơn vị, hệ thống để thiết lập lại

            $m_donvi = dsdonvi::where('madonvi', $ttuser->madonvi)->first();

            //dd($ttuser);
            $ttuser->madiaban = $m_donvi->madiaban;
            $ttuser->maqhns = $m_donvi->maqhns;
            $ttuser->tendv = $m_donvi->tendv;
            $ttuser->emailql = $m_donvi->emailql;
            $ttuser->emailqt = $m_donvi->emailqt;
            $ttuser->songaylv = $m_donvi->songaylv;
            $ttuser->tendvhienthi = $m_donvi->tendvhienthi;
            $ttuser->tendvcqhienthi = $m_donvi->tendvcqhienthi;
            $ttuser->chucvuky = $m_donvi->chucvuky;
            $ttuser->chucvukythay = $m_donvi->chucvukythay;
            $ttuser->nguoiky = $m_donvi->nguoiky;
            $ttuser->diadanh = $m_donvi->diadanh;

            //Lấy thông tin địa bàn
            $m_diaban = dsdiaban::where('madiaban', $ttuser->madiaban)->first();

            $ttuser->tendiaban = $m_diaban->tendiaban;
            $ttuser->capdo = $m_diaban->capdo;
            $ttuser->phanquyen = json_decode($ttuser->phanquyen, true);
        } else {
            //$ttuser->chucnang = array('SSA');
            $ttuser->capdo = "SSA";
            //$ttuser->phanquyen = [];
        }

        //Lấy setting gán luôn vào phiên đăng nhập
        $ttuser->thietlap = json_decode($a_HeThongChung->thietlap, true);
        $ttuser->ipf1 = $a_HeThongChung->ipf1;
        $ttuser->ipf2 = $a_HeThongChung->ipf2;
        $ttuser->ipf3 = $a_HeThongChung->ipf3;
        $ttuser->ipf4 = $a_HeThongChung->ipf4;
        $ttuser->ipf5 = $a_HeThongChung->ipf5;
        //dd($ttuser);        

        Session::put('admin', $ttuser);
        //Gán hệ danh mục chức năng        
        Session::put('chucnang', hethongchung_chucnang::all()->keyBy('machucnang')->toArray());
        //gán phân quyền của User
        Session::put('phanquyen', dstaikhoan_phanquyen::where('tendangnhap', $input['tendangnhap'])->get()->keyBy('machucnang')->toArray());
        //dd(session('admin'));
        return redirect('/')
            ->with('pageTitle', 'Tổng quan');
    }

    public function QuenMatKhau(Request $request)
    {
        $input = $request->all();
        $model = DSTaiKhoan::where('username', $input['username'])->first();
        if (isset($model)) {
            if ($model->email == $input['email']) {
                $npass = getRandomPassword();
                $model->password = md5($npass);
                $model->save();

                $data = [];
                $data['tendn'] = $model->name;
                $data['username'] = $model->username;
                $data['npass'] = $npass;
                $maildn = $model->email;
                $tendn = $model->name;

                // Mail::send('mail.successnewpassword', $data, function ($message) use ($maildn, $tendn) {
                //     $message->to($maildn, $tendn)
                //         ->subject('Thông báo thay đổi mật khẩu tài khoản');
                //     $message->from('qlgiakhanhhoa@gmail.com', 'Phần mềm CSDL giá');
                // });
                return view('errors.forgotpass-success');
            } else
                return view('errors.forgotpass-errors');
        } else
            return view('errors.forgotpass-errors');
    }

    public function DangXuat()
    {
        if (Session::has('admin')) {
            Session::flush();
            return redirect('/DangNhap');
        } else {
            return redirect('');
        }
    }

    public function ThongTin()
    {
        if (!chkPhanQuyen('hethongchung', 'danhsach')) {
            return view('errors.noperm')->with('machucnang', 'hethongchung');
        }

        $model = hethongchung::first();
        return view('HeThongChung.HeThong.ThongTin')
            ->with('model', $model)
            ->with('pageTitle', 'Cấu hình hệ thống');
    }


    public function ThayDoi()
    {
        if (!chkPhanQuyen('hethongchung', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'hethongchung');
        }
        $model = hethongchung::first();
        return view('HeThongChung.HeThong.Sua')
            ->with('model', $model)
            ->with('pageTitle', 'Chỉnh sửa cấu hình hệ thống');
    }
    public function LuuThayDoi(Request $request)
    {
        if (!chkPhanQuyen('hethongchung', 'thaydoi')) {
            return view('errors.noperm')->with('machucnang', 'hethongchung');
        }
        $inputs = $request->all();
        if (isset($inputs['ipf1'])) {
            $filedk = $request->file('ipf1');
            $inputs['ipf1'] = '_HuongDanSuDung.' . $filedk->getClientOriginalExtension();
            $filedk->move(public_path() . '/data/download/', $inputs['ipf1']);
        }
        if (isset($inputs['ipf2'])) {
            $filedk = $request->file('ipf2');
            $inputs['ipf2'] =  '_Zalo.' . $filedk->getClientOriginalExtension();
            $filedk->move(public_path() . '/data/download/', $inputs['ipf2']);
        }
        hethongchung::first()->update($inputs);
        return redirect('/HeThongChung/ThongTin');
    }

    public function DanhSachTaiKhoan(Request $request)
    {
        $inputs = $request->all();
        $m_diaban = dsdiaban::all();
        $inputs['madiaban'] = $inputs['madiaban'] ??  $m_diaban->first()->madiaban;
        $m_donvi = dsdonvi::all();

        $a_donvi = array_column($m_donvi->toarray(), 'tendonvi', 'madonvi');
        //$model = dstaikhoan::wherein('madonvi',array_column($m_donvi->toarray(),'madonvi'))->get();
        $model = dstaikhoan::where('tendangnhap', '<>', 'SSA')->get();
        foreach ($model as $ct) {

            $ct->tendonvi = $a_donvi[$ct->madonvi] ?? '';
        }
        //dd($inputs);
        return view('CongBo.DanhSachTaiKhoan')
            ->with('model', $model)
            ->with('inputs', $inputs)
            ->with('a_diaban', array_column(dsdiaban::all()->toArray(), 'tendiaban', 'madiaban'))
            ->with('pageTitle', 'Thông tin hỗ trợ');
    }

    public function DanhSachHoTro(Request $request)
    {
        $inputs = $request->all();
        $m_diaban = dsdiaban::all();
        $inputs['madiaban'] = $inputs['madiaban'] ??  $m_diaban->first()->madiaban;
        $m_donvi = dsdonvi::where('madiaban', $inputs['madiaban'])->get();

        $a_donvi = array_column($m_donvi->toarray(), 'tendonvi', 'madonvi');
        $model = dstaikhoan::wherein('madonvi', array_column($m_donvi->toarray(), 'madonvi'))->get();
        foreach ($model as $ct) {
            $ct->tendonvi = $a_donvi[$ct->madonvi] ?? $ct->madonvi;
        }
        //dd($inputs);
        return view('HeThong.DanhSachHoTro')
            ->with('model', $model)
            ->with('inputs', $inputs)
            ->with('a_diaban', array_column(dsdiaban::all()->toArray(), 'tendiaban', 'madiaban'))
            ->with('pageTitle', 'Thông tin hỗ trợ');
    }
}
