<?php

namespace App\Http\Controllers\API;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\DanhMuc\dmdanhhieuthidua;
use App\Model\DanhMuc\dmhinhthuckhenthuong;
use App\Model\DanhMuc\dmloaihinhkhenthuong;
use App\Model\DanhMuc\dmnhomphanloai_chitiet;
use App\Model\DanhMuc\dsdonvi;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_tailieu;
use App\Model\View\view_tdkt_canhan;
use App\Model\View\view_tdkt_detai;
use App\Model\View\view_tdkt_tapthe;
use App\Model\View\viewdiabandonvi;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class APIdungchungController extends Controller
{
    public function convertHoSo($hoso, $danhsachdonvi)
    {
        $tailieu = dshosothiduakhenthuong_tailieu::where('mahosotdkt', $hoso->mahosotdkt)->get();
        $a_kq = [
            'MaHoSo' => $hoso->mahosotdkt,
            'LoaiHinhKhenThuong' => $hoso->mahinhthuckt,
            'NoiDungKhenThuong' => $hoso->noidung,
            'SoQuyetDinh' => $hoso->soqd,
            'NgayQuyetDinh' => $hoso->ngayqd,
            'TrangThaiHoSo' => $hoso->trangthai,
        ];
        //Gán thông tin đơn vị
        $donvi_denghi = $danhsachdonvi->where('madonvi', $hoso->madonvi)->first();
        $a_kq['MaDonViDeNghi'] = $donvi_denghi->madonvi;
        $a_kq['TenDonViDeNghi'] = $donvi_denghi->tendonvi;
        $a_kq['MaQuanHeNganSachDonViDeNghi'] = $donvi_denghi->maqhns;

        $donvi_xd = $danhsachdonvi->where('madonvi', $hoso->madonvi_xd)->first();
        $a_kq['MaDonViXetDuyet'] = $donvi_xd->madonvi ?? '';
        $a_kq['TenDonViXetDuyet'] = $donvi_xd->tendonvi ?? '';
        $a_kq['MaQuanHeNganSachDonViXetDuyet'] = $donvi_xd->maqhns ?? '';

        $donvi_pd = $danhsachdonvi->where('madonvi', $hoso->madonvi_kt)->first();
        $a_kq['MaDonViPheDuyet'] = $donvi_pd->madonvi ?? '';
        $a_kq['TenDonViPheDuyet'] = $donvi_pd->tendonvi ?? '';
        $a_kq['MaQuanHeNganSachDonViPheDuyet'] = $donvi_pd->maqhns ?? '';
        //Gán tài liệu đính kèm
        $a_tailieu = [];
        $i = 1;
        foreach ($tailieu as $dinhkem) {
            $a_tailieu[] = [
                'STT' => $i++,
                'TenTaiLieu' => $dinhkem->tentailieu,
                'PhanLoaiTaiLieu' => $dinhkem->phanloai,
                'MoTaTaiLieu' => $dinhkem->noidung,
                'Base_64' => $dinhkem->base64,
                'MaDonViDinhKem' => $dinhkem->madonvi,
            ];
        }
        $a_kq['DanhSachTaiLieu'] = $a_tailieu;

        //Trả kết quả
        return  $a_kq;
    }
}
