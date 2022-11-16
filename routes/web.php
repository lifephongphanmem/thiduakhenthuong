<?php

use App\Http\Controllers\HeThong\dstaikhoanController;
use App\Http\Controllers\HeThong\hethongchungController;
use App\Http\Controllers\NghiepVu\_DungChung\dungchung_nghiepvuController;
use Illuminate\Support\Facades\Route;

Route::get('','HeThong\hethongchungController@index');

Route::get('DanhSachHoTro',[hethongchungController::class,'DanhSachHoTro']);

Route::get('DanhSachTaiKhoan',[hethongchungController::class,'DanhSachTaiKhoan']);
Route::get('DoiMatKhau',[dstaikhoanController::class,'DoiMatKhau']);
Route::post('DoiMatKhau',[dstaikhoanController::class,'LuuMatKhau']);

Route::get('TrangChu','HeThong\congboController@TrangChu');
//dùng chung cho nghiệp vụ
Route::group(['prefix' => 'DungChung'], function () {
    Route::get('getDonViKhenThuong_ThemHS', [dungchung_nghiepvuController::class, 'getDonViKhenThuong_ThemHS']);
    Route::get('lichsucapnhat', [dungchung_nghiepvuController::class, 'getDonViKhenThuong_ThemHS']);
    //
    Route::get('DinhKemHoSoKhenThuong', [dungchung_nghiepvuController::class, 'DinhKemHoSoKhenThuong']);
    Route::get('DinhKemHoSoKhenCao', [dungchung_nghiepvuController::class, 'DinhKemHoSoKhenCao']);
    Route::get('DinhKemHoSoCumKhoi', [dungchung_nghiepvuController::class, 'DinhKemHoSoCumKhoi']);
    Route::get('DinhKemHoSoThamGia', [dungchung_nghiepvuController::class, 'DinhKemHoSoThamGia']);
    
});

//Hệ thống
include('hethong.php');
include('danhmuc.php');
include('phongtraothidua.php');
include('thiduakhenthuongcaccap.php');
include('khenthuongcongtrang.php');
include('khenthuongchuyende.php');
include('cumkhoi.php');
include('tracuu.php');
include('dangkydanhhieu.php');
include('baocao.php');
include('khenthuongkhangchien.php');
include('vanbantailieu.php');
include('congbo.php');
