<?php

use App\Http\Controllers\HeThong\dstaikhoanController;
use App\Http\Controllers\HeThong\hethongchungController;
use App\Http\Controllers\NghiepVu\_DungChung\dungchung_inphoi_khenthuongController;
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
    Route::get('DinhKemHoSoKhenThuong', [dungchung_nghiepvuController::class, 'DinhKemHoSoKhenThuong']);
    Route::get('DinhKemHoSoKhenCao', [dungchung_nghiepvuController::class, 'DinhKemHoSoKhenCao']);
    Route::get('DinhKemHoSoCumKhoi', [dungchung_nghiepvuController::class, 'DinhKemHoSoCumKhoi']);
    Route::get('DinhKemHoSoThamGia', [dungchung_nghiepvuController::class, 'DinhKemHoSoThamGia']);   
    

    Route::group(['prefix' => 'InPhoiKhenThuong'], function () {
        Route::get('DanhSach', [dungchung_inphoi_khenthuongController::class, 'DanhSach']);
        //Route::post('NoiDungKhenThuong', [dungchung_inphoi_khenthuongController::class, 'NoiDungKhenThuong']);
        Route::get('InBangKhen', [dungchung_inphoi_khenthuongController::class, 'InBangKhen']);
        Route::get('InMauBangKhen', [dungchung_inphoi_khenthuongController::class, 'InMauBangKhen']);
        Route::get('InBangKhenHoGiaDinh', [dungchung_inphoi_khenthuongController::class, 'InBangKhenHoGiaDinh']);
        Route::get('InBangKhenCaNhan', [dungchung_inphoi_khenthuongController::class, 'InBangKhenCaNhan']);

        Route::get('InGiayKhen', [dungchung_inphoi_khenthuongController::class, 'InGiayKhen']);
        Route::get('InGiayKhenHoGiaDinh', [dungchung_inphoi_khenthuongController::class, 'InGiayKhenHoGiaDinh']);
        Route::get('InGiayKhenCaNhan', [dungchung_inphoi_khenthuongController::class, 'InGiayKhenCaNhan']);
    });
    Route::get('InPhoiCumKhoi/DanhSach', [dungchung_inphoi_khenthuongController::class, 'DanhSachCumKhoi']);

    Route::get('LuuToaDo', [dungchung_nghiepvuController::class, 'LuuToaDo']);
    Route::get('GanToaDoMacDinh', [dungchung_nghiepvuController::class, 'GanToaDoMacDinh']);
    Route::post('LuuThayDoiViTri', [dungchung_nghiepvuController::class, 'LuuThayDoiViTri']);
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
include('cumkhoi.php');
include('tracuu.php');
include('dangkydanhhieu.php');
include('baocao.php');
include('khenthuongkhangchien.php');
include('vanbantailieu.php');
include('congbo.php');
