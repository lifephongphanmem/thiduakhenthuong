<?php

use App\Http\Controllers\HeThong\hethongchungController;
use App\Http\Controllers\NghiepVu\_DungChung\dungchung_nghiepvuController;
use Illuminate\Support\Facades\Route;

Route::get('','HeThong\hethongchungController@index');

Route::get('DanhSachHoTro',[hethongchungController::class,'DanhSachHoTro']);

Route::get('DanhSachTaiKhoan',[hethongchungController::class,'DanhSachTaiKhoan']);
Route::get('DoiMatKhau',[hethongchungController::class,'DoiMatKhau']);

Route::get('TrangChu','HeThong\congboController@TrangChu');
//dùng chung cho nghiệp vụ
Route::group(['prefix' => 'DungChung'], function () {
    Route::get('getDonViKhenThuong_ThemHS', [dungchung_nghiepvuController::class, 'getDonViKhenThuong_ThemHS']);
    Route::get('lichsucapnhat', [dungchung_nghiepvuController::class, 'getDonViKhenThuong_ThemHS']);
    
});

//Hệ thống
include('hethong.php');
include('danhmuc.php');
include('thiduakhenthuongcaccap.php');
include('cumkhoi.php');
include('tracuu.php');
include('dangkydanhhieu.php');
include('baocao.php');
include('khenthuongkhangchien.php');
include('vanbantailieu.php');
include('congbo.php');
