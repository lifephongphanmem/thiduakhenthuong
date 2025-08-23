<?php

use App\Http\Controllers\HeThong\donvisapnhapController;
use App\Http\Controllers\HeThong\dschucnangController;
use App\Http\Controllers\HeThong\dsdiabanController;
use App\Http\Controllers\HeThong\dsdonviController;
use App\Http\Controllers\HeThong\dstaikhoanController;
use App\Http\Controllers\HeThong\dsvanphonghotroController;
use App\Http\Controllers\HeThong\tailieuhuongdanController;
use Illuminate\Support\Facades\Route;

//Đăng nhập
Route::get('DangNhap', 'HeThong\hethongchungController@DangNhap');
Route::post('DangNhap', 'HeThong\hethongchungController@XacNhanDangNhap');
Route::post('QuenMatKhau', 'HeThong\hethongchungController@QuenMatKhau');
Route::get('DangXuat', 'HeThong\hethongchungController@DangXuat');
Route::get('ThongTinDonVi', 'HeThong\dsdonviController@ThongTinDonVi');
Route::post('ThongTinDonVi', 'HeThong\dsdonviController@LuuThongTinDonVi');

Route::group(['prefix' => 'HeThongChung'], function () {
    Route::get('ThongTin', 'HeThong\hethongchungController@ThongTin');
    Route::get('ThayDoi', 'HeThong\hethongchungController@ThayDoi');
    Route::post('ThayDoi', 'HeThong\hethongchungController@LuuThayDoi');
});
Route::group(['prefix' => 'DiaBan'], function () {
    Route::get('ThongTin', 'HeThong\dsdiabanController@index');
    Route::post('Sua', 'HeThong\dsdiabanController@modify');
    Route::post('Xoa', 'HeThong\dsdiabanController@delete');
    Route::post('NhanExcel', [dsdiabanController::class, 'NhanExcel']);
    Route::get('LayDonVi', 'HeThong\dsdiabanController@LayDonVi');
    Route::post('TrangThai', [dsdiabanController::class, 'TrangThai']);
});

Route::group(['prefix' => 'DonVi'], function () {
    Route::get('ThongTin', [dsdonviController::class, 'ThongTin']);
    Route::get('DanhSach', 'HeThong\dsdonviController@DanhSach');
    Route::get('Them', 'HeThong\dsdonviController@create');
    Route::post('Them', 'HeThong\dsdonviController@store');
    Route::get('Sua', 'HeThong\dsdonviController@edit');
    Route::post('Sua', 'HeThong\dsdonviController@store');
    Route::post('Xoa', 'HeThong\dsdonviController@destroy');
    //Route::get('QuanLy', 'HeThong\dsdonviController@QuanLy');
    Route::post('QuanLy', 'HeThong\dsdonviController@LuuQuanLy');

    Route::post('NhanExcel', 'HeThong\dsdonviController@NhanExcel');

    Route::prefix('SapNhap')->group(function () {
        Route::get('ThongTin', [donvisapnhapController::class, 'ThongTin']);
        Route::post('Them', [donvisapnhapController::class, 'LuuSapNhap']);
        Route::post('Xoa', [donvisapnhapController::class, 'Xoa']);
        Route::get('HoSoKT', [donvisapnhapController::class, 'HoSoKT']);
    });
});

Route::group(['prefix' => 'TaiKhoan'], function () {
    Route::get('ThongTin', 'HeThong\dstaikhoanController@ThongTin');
    Route::get('DanhSach', 'HeThong\dstaikhoanController@DanhSach');

    Route::get('PhanQuyen', 'HeThong\dstaikhoanController@PhanQuyen');
    Route::post('PhanQuyen', 'HeThong\dstaikhoanController@LuuPhanQuyen');

    Route::get('Them', 'HeThong\dstaikhoanController@create');
    Route::post('Them', 'HeThong\dstaikhoanController@store');
    Route::get('Sua', 'HeThong\dstaikhoanController@edit');
    Route::post('Sua', 'HeThong\dstaikhoanController@store');
    Route::post('NhomChucNang', 'HeThong\dstaikhoanController@NhomChucNang');

    Route::post('Xoa', 'HeThong\dstaikhoanController@XoaTaiKhoan');

    Route::get('PhamViDuLieu', [dstaikhoanController::class, 'PhamViDuLieu']);
    Route::post('PhamViDuLieu', [dstaikhoanController::class, 'LuuPhamViDuLieu']);
    Route::post('XoaPhamViDuLieu', [dstaikhoanController::class, 'XoaPhamViDuLieu']);
    //Làm danh sách đầy đủ tài khoản để theo dõi (do có trường hợp xoá đơn vị nhưng ko xoá tài khoản)
    Route::get('DanhSachDayDu', 'HeThong\dstaikhoanController@DanhSachDayDu');
    Route::post('XoaTaiKhoan', 'HeThong\dstaikhoanController@XoaTaiKhoanDayDu');
});
Route::group(['prefix' => 'HeThongAPI'], function () {
    //Route::get('CaNhan', 'HeThong\HeThongAPIController@CaNhan');
    //Route::get('TapThe', 'HeThong\HeThongAPIController@TapThe');
    //Route::get('PhongTrao', 'HeThong\HeThongAPIController@PhongTrao');
});

Route::group(['prefix' => 'ChucNang'], function () {
    Route::get('ThongTin', [dschucnangController::class, 'ThongTin']);
    Route::post('ThongTin', 'HeThong\dschucnangController@LuuChucNang');
    Route::get('LayChucNang', 'HeThong\dschucnangController@LayChucNang');
    Route::post('Xoa', 'HeThong\dschucnangController@XoaChucNang');
});

Route::group(['prefix' => 'VanPhongHoTro'], function () {
    Route::get('ThongTin', [dsvanphonghotroController::class, 'ThongTin']);
    Route::post('Them', [dsvanphonghotroController::class, 'Them']);
    Route::get('LayChucNang', 'HeThong\dschucnangController@LayChucNang');
    Route::post('Xoa', 'HeThong\dschucnangController@XoaChucNang');
});
Route::prefix('TaiLieuHuongDan')->group(function () {
    Route::get('ThongTin', [tailieuhuongdanController::class, 'index']);
    Route::get('DanhSach', [tailieuhuongdanController::class, 'show']);
    Route::post('Them', [tailieuhuongdanController::class, 'store']);
    Route::post('Xoa', [tailieuhuongdanController::class, 'delete']);
    Route::post('update/{id}', [tailieuhuongdanController::class, 'update']);
    Route::post('uploadvideo/{id}', [tailieuhuongdanController::class, 'upload']);
    Route::post('XoaVideo/{id}', [tailieuhuongdanController::class, 'XoaVideo']);
});
