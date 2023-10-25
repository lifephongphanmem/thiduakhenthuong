<?php

use App\Http\Controllers\HeThong\dstaikhoanController;
use App\Http\Controllers\HeThong\hethongchungController;
use App\Http\Controllers\NghiepVu\_DungChung\dungchung_duthaokhenthuongController;
use App\Http\Controllers\NghiepVu\_DungChung\dungchung_inphoi_khenthuongController;
use App\Http\Controllers\NghiepVu\_DungChung\dungchung_nghiepvu_tailieuController;
use App\Http\Controllers\NghiepVu\_DungChung\dungchung_nghiepvuController;
use Illuminate\Support\Facades\Route;

Route::get('', 'HeThong\hethongchungController@index');

Route::get('DanhSachHoTro', [hethongchungController::class, 'DanhSachHoTro']);

Route::get('DanhSachTaiKhoan', [hethongchungController::class, 'DanhSachTaiKhoan']);
Route::get('DoiMatKhau', [dstaikhoanController::class, 'DoiMatKhau']);
Route::post('DoiMatKhau', [dstaikhoanController::class, 'LuuMatKhau']);

Route::get('TrangChu', 'HeThong\congboController@TrangChu');
//dùng chung cho nghiệp vụ
Route::group(['prefix' => 'DungChung'], function () {
    Route::get('getDonViKhenThuong_ThemHS', [dungchung_nghiepvuController::class, 'getDonViKhenThuong_ThemHS']);
    Route::get('lichsucapnhat', [dungchung_nghiepvuController::class, 'getDonViKhenThuong_ThemHS']);
    //
    Route::get('DinhKemHoSoKhenThuong', [dungchung_nghiepvu_tailieuController::class, 'DinhKemHoSoKhenThuong']);
    Route::get('DinhKemHoSoKhenCao', [dungchung_nghiepvuController::class, 'DinhKemHoSoKhenCao']);
    Route::get('DinhKemHoSoCumKhoi', [dungchung_nghiepvu_tailieuController::class, 'DinhKemHoSoCumKhoi']);
    Route::get('DinhKemHoSoThamGia', [dungchung_nghiepvuController::class, 'DinhKemHoSoThamGia']);    
    
    Route::get('DinhKemHoSoDeNghiCumKhoi', [dungchung_nghiepvu_tailieuController::class, 'DinhKemHoSoDeNghiCumKhoi']);

    Route::group(['prefix' => 'InPhoiKhenThuong'], function () {
        Route::get('DanhSach', [dungchung_inphoi_khenthuongController::class, 'DanhSach']);
        Route::get('getNoiDungKhenThuong', [dungchung_inphoi_khenthuongController::class, 'getNoiDungKhenThuong']);        
        Route::get('InBangKhen', [dungchung_inphoi_khenthuongController::class, 'InBangKhen']);
        Route::get('InMauBangKhen', [dungchung_inphoi_khenthuongController::class, 'InMauBangKhen']);
        Route::post('InDanhSachBangKhen', [dungchung_inphoi_khenthuongController::class, 'InDanhSachBangKhen']);
        Route::get('InGiayKhen', [dungchung_inphoi_khenthuongController::class, 'InGiayKhen']);
        Route::get('InMauGiayKhen', [dungchung_inphoi_khenthuongController::class, 'InMauGiayKhen']);
        Route::post('InDanhSachGiayKhen', [dungchung_inphoi_khenthuongController::class, 'InDanhSachGiayKhen']);
    });
    Route::get('InPhoiCumKhoi/DanhSach', [dungchung_inphoi_khenthuongController::class, 'DanhSachCumKhoi']);

    Route::get('LuuToaDo', [dungchung_nghiepvuController::class, 'LuuToaDo']);
    Route::get('GanToaDoMacDinh', [dungchung_nghiepvuController::class, 'GanToaDoMacDinh']);
    Route::post('LuuThayDoiViTri', [dungchung_nghiepvuController::class, 'LuuThayDoiViTri']);
    Route::post('TaiLaiToaDo', [dungchung_nghiepvuController::class, 'TaiLaiToaDo']);

    //2023.09.14 Dùng chung cho nghiệp vụ tài liệu đính kèm
    Route::group(['prefix' => 'TaiLieuDinhKem'], function () {
        Route::get('LayTaiLieu', [dungchung_nghiepvu_tailieuController::class, 'LayTaiLieu']);
        Route::post('ThemTaiLieu', [dungchung_nghiepvu_tailieuController::class, 'ThemTaiLieu']);
        Route::get('XoaTaiLieu', [dungchung_nghiepvu_tailieuController::class, 'XoaTaiLieu']);

    });
    //2023.10.10 Các nghiệp vụ dự thảo
    Route::group(['prefix' => 'DuThao'], function () {
        //hosothiduakhenthuong
        //Tờ trình đề nghị khen thưởng
        Route::get('ToTrinhDeNghiKhenThuong', [dungchung_duthaokhenthuongController::class, 'ToTrinhDeNghiKhenThuong']);
        Route::post('LuuToTrinhDeNghiKhenThuong', [dungchung_duthaokhenthuongController::class, 'LuuToTrinhDeNghiKhenThuong']);
        Route::post('TaoToTrinhDeNghiKhenThuong', [dungchung_duthaokhenthuongController::class, 'TaoToTrinhDeNghiKhenThuong']);
        Route::get('InToTrinhDeNghiKhenThuong', [dungchung_duthaokhenthuongController::class, 'InToTrinhDeNghiKhenThuong']);
        //Tờ trình kết quả
        Route::get('ToTrinhKetQuaKhenThuong', [dungchung_duthaokhenthuongController::class, 'ToTrinhKetQuaKhenThuong']);
        Route::post('LuuToTrinhKetQuaKhenThuong', [dungchung_duthaokhenthuongController::class, 'LuuToTrinhKetQuaKhenThuong']);
        Route::post('TaoToTrinhKetQuaKhenThuong', [dungchung_duthaokhenthuongController::class, 'TaoToTrinhKetQuaKhenThuong']);
        Route::get('InToTrinhKetQuaKhenThuong', [dungchung_duthaokhenthuongController::class, 'InToTrinhKetQuaKhenThuong']);
        //Quyết định khen thưởng
        Route::get('InQuyetDinhKhenThuong', [dungchung_duthaokhenthuongController::class, 'InQuyetDinhKhenThuong']);
        Route::get('QuyetDinhKhenThuong', [dungchung_duthaokhenthuongController::class, 'QuyetDinhKhenThuong']);
        Route::post('LuuQuyetDinhKhenThuong', [dungchung_duthaokhenthuongController::class, 'LuuQuyetDinhKhenThuong']);
        Route::post('TaoQuyetDinhKhenThuong', [dungchung_duthaokhenthuongController::class, 'TaoQuyetDinhKhenThuong']);

        //Cụm khối
        Route::get('QuyetDinhCumKhoi', [dungchung_duthaokhenthuongController::class, 'QuyetDinhCumKhoi']);
    });
});



//Hệ thống
include('hethong.php');
include('danhmuc.php');
include('phongtraothidua.php');
include('thiduakhenthuongcaccap.php');
include('khenthuongcongtrang.php');
include('khenthuongchuyende.php');
include('khenthuongdotxuat.php');
include('khenthuongconghien.php');
include('khenthuongdoingoai.php');
include('khencao.php');
include('cumkhoi.php');
include('tracuu.php');
include('dangkydanhhieu.php');
include('baocao.php');
include('khenthuongkhangchien.php');
include('vanbantailieu.php');
include('congbo.php');
include('quykhenthuong.php');
