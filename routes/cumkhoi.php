<?php

use App\Http\Controllers\NghiepVu\CumKhoiThiDua\dscumkhoiController;
use App\Http\Controllers\NghiepVu\CumKhoiThiDua\dshosokhenthuongcumkhoiController;
use App\Http\Controllers\NghiepVu\CumKhoiThiDua\GiaoUoc\dshosogiaouocthiduaController;
use App\Http\Controllers\NghiepVu\CumKhoiThiDua\GiaoUoc\xdhosogiaouocthiduaController;
use App\Http\Controllers\NghiepVu\CumKhoiThiDua\khenthuonghosokhenthuongcumkhoiController;

Route::group(['prefix' => 'CumKhoiThiDua'], function () {
    Route::group(['prefix' => 'CumKhoi'], function () {
        Route::get('ThongTin', [dscumkhoiController::class, 'ThongTin']);
        Route::get('ThongTin', 'NghiepVu\CumKhoiThiDua\dscumkhoiController@ThongTin');
        Route::get('Them', 'NghiepVu\CumKhoiThiDua\dscumkhoiController@ThayDoi');
        Route::post('Them', 'NghiepVu\CumKhoiThiDua\dscumkhoiController@LuuCumKhoi');
        Route::get('Sua', 'NghiepVu\CumKhoiThiDua\dscumkhoiController@ThayDoi');
        Route::post('Sua', 'NghiepVu\CumKhoiThiDua\dscumkhoiController@LuuCumKhoi');
        Route::post('Xoa', 'NghiepVu\CumKhoiThiDua\dscumkhoiController@Xoa');

        Route::get('DanhSach', 'NghiepVu\CumKhoiThiDua\dscumkhoiController@DanhSach');
        Route::post('ThemDonVi', 'NghiepVu\CumKhoiThiDua\dscumkhoiController@ThemDonVi');
        Route::post('XoaDonVi', 'NghiepVu\CumKhoiThiDua\dscumkhoiController@XoaDonVi');
    });

    Route::group(['prefix' => 'KTCumKhoi'], function () {
        Route::group(['prefix' => 'HoSo'], function () {
            Route::get('ThongTin', [dshosokhenthuongcumkhoiController::class, 'ThongTin']);
            Route::get('DanhSach', 'NghiepVu\CumKhoiThiDua\dshosokhenthuongcumkhoiController@DanhSach');
    
            Route::get('Them', 'NghiepVu\CumKhoiThiDua\dshosokhenthuongcumkhoiController@ThayDoi');
            Route::post('Them', 'NghiepVu\CumKhoiThiDua\dshosokhenthuongcumkhoiController@LuuHoSo');
            Route::get('Sua', 'NghiepVu\CumKhoiThiDua\dshosokhenthuongcumkhoiController@Sua');
            Route::post('Sua', 'NghiepVu\CumKhoiThiDua\dshosokhenthuongcumkhoiController@LuuHoSo');
            Route::get('Xem', 'NghiepVu\CumKhoiThiDua\dshosokhenthuongcumkhoiController@XemHoSo');
    
            Route::get('ThemDoiTuong', 'NghiepVu\CumKhoiThiDua\dshosokhenthuongcumkhoiController@ThemDoiTuong');
            Route::get('ThemDoiTuongTapThe', 'NghiepVu\CumKhoiThiDua\dshosokhenthuongcumkhoiController@ThemDoiTuongTapThe');
            Route::get('LayTieuChuan', 'NghiepVu\CumKhoiThiDua\dshosokhenthuongcumkhoiController@LayTieuChuan');
            Route::get('LuuTieuChuan', 'NghiepVu\CumKhoiThiDua\dshosokhenthuongcumkhoiController@LuuTieuChuan');
            Route::get('LayDoiTuong', 'NghiepVu\CumKhoiThiDua\dshosokhenthuongcumkhoiController@LayDoiTuong');
    
            Route::get('LayLyDo', 'NghiepVu\CumKhoiThiDua\dshosokhenthuongcumkhoiController@LayLyDo');
            Route::get('XoaDoiTuong', 'NghiepVu\CumKhoiThiDua\dshosokhenthuongcumkhoiController@XoaDoiTuong');
    
            Route::post('Xoa', 'NghiepVu\CumKhoiThiDua\dshosokhenthuongcumkhoiController@XoaHoSo');
            Route::post('ChuyenHoSo', 'NghiepVu\CumKhoiThiDua\dshosokhenthuongcumkhoiController@ChuyenHoSo');
        });
    
    });

    Route::group(['prefix' => 'HoSoKhenThuong'], function () {
        Route::get('ThongTin', [dshosokhenthuongcumkhoiController::class, 'ThongTin']);
        Route::get('DanhSach', 'NghiepVu\CumKhoiThiDua\dshosokhenthuongcumkhoiController@DanhSach');

        Route::get('Them', 'NghiepVu\CumKhoiThiDua\dshosokhenthuongcumkhoiController@ThayDoi');
        Route::post('Them', 'NghiepVu\CumKhoiThiDua\dshosokhenthuongcumkhoiController@LuuHoSo');
        Route::get('Sua', 'NghiepVu\CumKhoiThiDua\dshosokhenthuongcumkhoiController@Sua');
        Route::post('Sua', 'NghiepVu\CumKhoiThiDua\dshosokhenthuongcumkhoiController@LuuHoSo');
        Route::get('Xem', 'NghiepVu\CumKhoiThiDua\dshosokhenthuongcumkhoiController@XemHoSo');

        Route::get('ThemDoiTuong', 'NghiepVu\CumKhoiThiDua\dshosokhenthuongcumkhoiController@ThemDoiTuong');
        Route::get('ThemDoiTuongTapThe', 'NghiepVu\CumKhoiThiDua\dshosokhenthuongcumkhoiController@ThemDoiTuongTapThe');
        Route::get('LayTieuChuan', 'NghiepVu\CumKhoiThiDua\dshosokhenthuongcumkhoiController@LayTieuChuan');
        Route::get('LuuTieuChuan', 'NghiepVu\CumKhoiThiDua\dshosokhenthuongcumkhoiController@LuuTieuChuan');
        Route::get('LayDoiTuong', 'NghiepVu\CumKhoiThiDua\dshosokhenthuongcumkhoiController@LayDoiTuong');

        Route::get('LayLyDo', 'NghiepVu\CumKhoiThiDua\dshosokhenthuongcumkhoiController@LayLyDo');
        Route::get('XoaDoiTuong', 'NghiepVu\CumKhoiThiDua\dshosokhenthuongcumkhoiController@XoaDoiTuong');

        Route::post('Xoa', 'NghiepVu\CumKhoiThiDua\dshosokhenthuongcumkhoiController@XoaHoSo');
        Route::post('ChuyenHoSo', 'NghiepVu\CumKhoiThiDua\dshosokhenthuongcumkhoiController@ChuyenHoSo');
    });

    Route::group(['prefix' => 'XetDuyetHoSoKhenThuong'], function () {
        Route::get('ThongTin', 'NghiepVu\CumKhoiThiDua\xetduyethosokhenthuongcumkhoiController@ThongTin');
        Route::post('NhanHoSo', 'NghiepVu\CumKhoiThiDua\xetduyethosokhenthuongcumkhoiController@NhanHoSo');
        //
        // Route::get('DanhSach','NghiepVu\ThiDuaKhenThuong\xetduyethosothiduaController@DanhSach');
        // Route::post('TraLai','NghiepVu\ThiDuaKhenThuong\xetduyethosothiduaController@TraLai'); 
        // Route::post('ChuyenHoSo','NghiepVu\ThiDuaKhenThuong\xetduyethosothiduaController@ChuyenHoSo');
        // Route::post('KetThuc','NghiepVu\ThiDuaKhenThuong\dshosothiduaController@LuuHoSo');
    });
    Route::group(['prefix' => 'KhenThuongHoSoKhenThuong'], function () {
        Route::get('ThongTin', 'NghiepVu\CumKhoiThiDua\khenthuonghosokhenthuongcumkhoiController@ThongTin');
        Route::post('KhenThuong', 'NghiepVu\CumKhoiThiDua\khenthuonghosokhenthuongcumkhoiController@KhenThuong');
        Route::get('DanhSach', 'NghiepVu\CumKhoiThiDua\khenthuonghosokhenthuongcumkhoiController@DanhSach');
        Route::post('DanhSach', 'NghiepVu\CumKhoiThiDua\khenthuonghosokhenthuongcumkhoiController@LuuKhenThuong');
        Route::post('HoSo', 'NghiepVu\CumKhoiThiDua\khenthuonghosokhenthuongcumkhoiController@HoSo');
        Route::post('KetQua', 'NghiepVu\CumKhoiThiDua\khenthuonghosokhenthuongcumkhoiController@KetQua');
        Route::post('PheDuyet', 'NghiepVu\CumKhoiThiDua\khenthuonghosokhenthuongcumkhoiController@PheDuyet');
        Route::get('Xem', 'NghiepVu\CumKhoiThiDua\khenthuonghosokhenthuongcumkhoiController@XemHoSo');
        Route::get('LayTieuChuan', 'NghiepVu\CumKhoiThiDua\khenthuonghosokhenthuongcumkhoiController@LayTieuChuan');

        Route::get('InKetQua', 'NghiepVu\CumKhoiThiDua\khenthuonghosokhenthuongcumkhoiController@InKetQua');
        Route::get('MacDinhQuyetDinh', 'NghiepVu\CumKhoiThiDua\khenthuonghosokhenthuongcumkhoiController@MacDinhQuyetDinh');
        Route::get('QuyetDinh', 'NghiepVu\CumKhoiThiDua\khenthuonghosokhenthuongcumkhoiController@QuyetDinh');
        Route::post('QuyetDinh', 'NghiepVu\CumKhoiThiDua\khenthuonghosokhenthuongcumkhoiController@LuuQuyetDinh');
        Route::get('XemQuyetDinh', 'NghiepVu\CumKhoiThiDua\khenthuonghosokhenthuongcumkhoiController@XemQuyetDinh');

        Route::get('Sua', [khenthuonghosokhenthuongcumkhoiController::class, 'Sua']);
    });
});
Route::group(['prefix' => 'GiaoUocThiDua'], function () {
    Route::group(['prefix' => 'HoSo'], function () {
        Route::get('ThongTin', [dshosogiaouocthiduaController::class, 'ThongTin']);
        Route::post('Them', [dshosogiaouocthiduaController::class, 'Them']);
        Route::get('Sua', [dshosogiaouocthiduaController::class, 'ThayDoi']);
        Route::post('Sua', [dshosogiaouocthiduaController::class, 'LuuHoSo']);
        Route::post('Xoa', [dshosogiaouocthiduaController::class, 'XoaHoSo']);
        Route::get('Xem', [dshosogiaouocthiduaController::class, 'XemHoSo']);

        Route::post('TapThe', [dshosogiaouocthiduaController::class, 'ThemTapThe']);
        Route::post('CaNhan', [dshosogiaouocthiduaController::class, 'ThemCaNhan']);
        Route::post('DeTai', [dshosogiaouocthiduaController::class, 'ThemDeTai']);

        Route::get('TapThe', [dshosogiaouocthiduaController::class, 'LayTapThe']);
        Route::get('CaNhan', [dshosogiaouocthiduaController::class, 'LayCaNhan']);
        Route::get('DeTai', [dshosogiaouocthiduaController::class, 'LayDeTai']);

        Route::post('ChuyenHoSo', [dshosogiaouocthiduaController::class, 'ChuyenHoSo']);
        Route::get('LayLyDo', [dshosogiaouocthiduaController::class, 'LayLyDo']);
        Route::post('XoaDoiTuong', [dshosogiaouocthiduaController::class, 'XoaHoSo']);
    });
    Route::group(['prefix' => 'XetDuyet'], function () {
        Route::get('ThongTin', [xdhosogiaouocthiduaController::class, 'ThongTin']);
        Route::post('TraLai', [xdhosogiaouocthiduaController::class, 'TraLai']);
        Route::post('NhanHoSo', [xdhosogiaouocthiduaController::class, 'NhanHoSo']);
    });
});
