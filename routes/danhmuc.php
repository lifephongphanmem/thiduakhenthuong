<?php
use App\Http\Controllers\DanhMuc\dmphanloaiController;
use App\Http\Controllers\DanhMuc\duthaoquyetdinhController;
use App\Http\Controllers\HeThong\dsnhomtaikhoanController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix'=>'DanhHieuThiDua'], function(){
    Route::get('ThongTin','DanhMuc\dmdanhhieuthiduaController@ThongTin');
    Route::post('Them','DanhMuc\dmdanhhieuthiduaController@store');
    Route::post('Xoa','DanhMuc\dmdanhhieuthiduaController@delete');
    Route::get('TieuChuan','DanhMuc\dmdanhhieuthiduaController@TieuChuan');
    Route::post('TieuChuan','DanhMuc\dmdanhhieuthiduaController@ThemTieuChuan');
    Route::post('XoaTieuChuan','DanhMuc\dmdanhhieuthiduaController@delete_TieuChuan');
    //Route::get('Sua','system\DSTaiKhoanController@edit');
});

Route::group(['prefix'=>'LoaiHinhKhenThuong'], function(){
    Route::get('ThongTin','DanhMuc\dmloaihinhkhenthuongController@ThongTin');
    Route::post('Them','DanhMuc\dmloaihinhkhenthuongController@store');
    Route::post('Xoa','HeThong\dmloaihinhkhenthuongController@delete');
});

Route::group(['prefix'=>'HinhThucKhenThuong'], function(){
    Route::get('ThongTin','DanhMuc\dmhinhthuckhenthuongController@ThongTin');
    Route::post('Them','DanhMuc\dmhinhthuckhenthuongController@store');
    Route::post('Xoa','DanhMuc\dmhinhthuckhenthuongController@delete');
});


Route::group(['prefix' => 'DuThaoQD'], function () {
    Route::get('ThongTin', [duthaoquyetdinhController::class, 'ThongTin']);
    Route::post('Them', [duthaoquyetdinhController::class, 'Them']);
    Route::post('Xoa', [duthaoquyetdinhController::class, 'Xoa']);
    Route::get('Xem', [duthaoquyetdinhController::class, 'XemDuThao']);
    Route::post('Luu', [duthaoquyetdinhController::class, 'LuuDuThao']);
});

Route::group(['prefix' => 'DMPhanLoai'], function () {
    Route::get('ThongTin', [dmphanloaiController::class, 'ThongTin']);
    Route::post('Them', [dmphanloaiController::class, 'Them']);
    Route::post('ThemNhom', [dmphanloaiController::class, 'ThemNhom']);
    Route::post('Xoa', [dmphanloaiController::class, 'Xoa']);
});


Route::group(['prefix' => 'NhomChucNang'], function () {
    Route::get('ThongTin', [dsnhomtaikhoanController::class, 'ThongTin']);
    Route::post('Sua', [dsnhomtaikhoanController::class, 'store']);
    Route::post('Xoa', [dsnhomtaikhoanController::class, 'destroy']);

    Route::get('PhanQuyen', [dsnhomtaikhoanController::class, 'PhanQuyen']);
    Route::post('PhanQuyen', [dsnhomtaikhoanController::class, 'LuuPhanQuyen']);

    Route::get('DanhSach', [dsnhomtaikhoanController::class, 'DanhSach']);
    Route::post('ThietLapLai', [dsnhomtaikhoanController::class, 'ThietLapLai']);
});


