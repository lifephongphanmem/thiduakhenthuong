<?php

use App\Http\Controllers\DanhMuc\dmphanloaiController;
use App\Http\Controllers\DanhMuc\duthaoquyetdinhController;
use Illuminate\Support\Facades\Route;

//Đăng nhập
Route::get('DangNhap','HeThong\hethongchungController@DangNhap');
Route::post('DangNhap','HeThong\hethongchungController@XacNhanDangNhap');
Route::post('QuenMatKhau','HeThong\hethongchungController@QuenMatKhau');
Route::get('DangXuat','HeThong\hethongchungController@DangXuat');

Route::group(['prefix'=>'HeThongChung'], function(){
    Route::get('ThongTin','HeThong\hethongchungController@ThongTin');
    Route::get('ThayDoi','HeThong\hethongchungController@ThayDoi');
    Route::post('ThayDoi','HeThong\hethongchungController@LuuThayDoi');
});
Route::group(['prefix'=>'DiaBan'], function(){
    Route::get('ThongTin','HeThong\dsdiabanController@index');
    Route::post('Sua','HeThong\dsdiabanController@modify');
    Route::post('delete','HeThong\dsdiabanController@delete');
});

Route::group(['prefix'=>'DonVi'], function(){
    Route::get('ThongTin','HeThong\dsdonviController@ThongTin');
    Route::get('DanhSach','HeThong\dsdonviController@DanhSach');
    Route::get('Them','HeThong\dsdonviController@create');
    Route::post('Them','HeThong\dsdonviController@store');
    Route::get('Sua','HeThong\dsdonviController@edit');
    Route::post('Sua','HeThong\dsdonviController@store');
    Route::post('Xoa','HeThong\dsdonviController@destroy');
    Route::get('QuanLy','HeThong\dsdonviController@QuanLy');
    Route::post('QuanLy','HeThong\dsdonviController@LuuQuanLy');

});

Route::group(['prefix'=>'TaiKhoan'], function(){
    Route::get('ThongTin','HeThong\dstaikhoanController@ThongTin');
    Route::get('Them','HeThong\dstaikhoanController@create');
    Route::post('Them','HeThong\dstaikhoanController@store');
    Route::get('Sua','HeThong\dstaikhoanController@edit');

});
Route::group(['prefix'=>'HeThongAPI'], function(){
    Route::get('CaNhan','HeThong\HeThongAPIController@CaNhan');
    Route::get('TapThe','HeThong\HeThongAPIController@TapThe');
    Route::get('PhongTrao','HeThong\HeThongAPIController@PhongTrao');
});

Route::group(['prefix'=>'ChucNang'], function(){
    Route::get('ThongTin','HeThong\dschucnangController@ThongTin');
    Route::post('ThongTin','HeThong\dschucnangController@LuuChucNang');
    Route::get('LayChucNang','HeThong\dschucnangController@LayChucNang');
});

Route::group(['prefix'=>'DMPhanLoai'], function(){
    Route::get('ThongTin', [dmphanloaiController::class,'ThongTin']);
    Route::post('Them', [dmphanloaiController::class,'Them']);
    Route::post('ThemNhom', [dmphanloaiController::class,'ThemNhom']);
    Route::post('Xoa',[dmphanloaiController::class,'Xoa']);
});

Route::group(['prefix'=>'DuThaoQD'], function(){
    Route::get('ThongTin', [duthaoquyetdinhController::class,'ThongTin']);
    Route::post('Them', [duthaoquyetdinhController::class,'Them']);
    Route::post('Xoa',[duthaoquyetdinhController::class,'Xoa']);
    Route::get('Xem', [duthaoquyetdinhController::class,'XemDuThao']);
    Route::post('Luu', [duthaoquyetdinhController::class,'LuuDuThao']);
});