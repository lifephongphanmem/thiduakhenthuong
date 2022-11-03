<?php

use App\Http\Controllers\NghiepVu\CumKhoiThiDua\dscumkhoiController;
use App\Http\Controllers\NghiepVu\CumKhoiThiDua\dshosodenghikhenthuongcumkhoiController;
use App\Http\Controllers\NghiepVu\CumKhoiThiDua\dshosokhenthuongcumkhoiController;
use App\Http\Controllers\NghiepVu\CumKhoiThiDua\dsphongtraothiduacumkhoiController;
use App\Http\Controllers\NghiepVu\CumKhoiThiDua\dstruongcumkhoiController;
use App\Http\Controllers\NghiepVu\CumKhoiThiDua\GiaoUoc\dshosogiaouocthiduaController;
use App\Http\Controllers\NghiepVu\CumKhoiThiDua\GiaoUoc\xdhosogiaouocthiduaController;
use App\Http\Controllers\NghiepVu\CumKhoiThiDua\khenthuonghosokhenthuongcumkhoiController;
use App\Http\Controllers\NghiepVu\CumKhoiThiDua\qdhosokhenthuongcumkhoiController;
use App\Http\Controllers\NghiepVu\CumKhoiThiDua\xetduyethosokhenthuongcumkhoiController;
use Illuminate\Support\Facades\Route;

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

        Route::get('TaiLieuDinhKem', [dscumkhoiController::class, 'TaiLieuDinhKem']);
    });
    Route::group(['prefix' => 'TruongCumKhoi'], function () {
        Route::get('ThongTin', [dstruongcumkhoiController::class, 'ThongTin']);
        Route::get('Them', [dstruongcumkhoiController::class, 'ThayDoi']);
        Route::post('Them', [dstruongcumkhoiController::class, 'LuuDanhSach']);

        Route::get('DanhSach', [dstruongcumkhoiController::class, 'DanhSach']);
        Route::post('Xoa', [dstruongcumkhoiController::class, 'XoaDS']);
        Route::post('LuuTruongCum', [dstruongcumkhoiController::class, 'LuuTruongCum']);
    });

    Route::group(['prefix' => 'PhongTraoThiDua'], function () {
        Route::get('ThongTin', [dsphongtraothiduacumkhoiController::class, 'ThongTin']);
        Route::get('Xem', [dsphongtraothiduacumkhoiController::class, 'XemThongTin']);
        Route::get('Them', [dsphongtraothiduacumkhoiController::class, 'ThayDoi']);
        Route::post('Them', [dsphongtraothiduacumkhoiController::class, 'LuuPhongTrao']);
        Route::get('Sua', [dsphongtraothiduacumkhoiController::class, 'ThayDoi']);
        Route::post('Sua', [dsphongtraothiduacumkhoiController::class, 'LuuPhongTrao']);

        Route::get('ThemKhenThuong', [dsphongtraothiduacumkhoiController::class, 'ThemKhenThuong']);
        Route::get('ThemTieuChuan', [dsphongtraothiduacumkhoiController::class, 'ThemTieuChuan']);
        Route::get('LayTieuChuan', [dsphongtraothiduacumkhoiController::class, 'LayTieuChuan']);
        Route::get('XoaTieuChuan', [dsphongtraothiduacumkhoiController::class, 'XoaTieuChuan']);
        Route::get('TaiLieuDinhKem', [dsphongtraothiduacumkhoiController::class, 'TaiLieuDinhKem']);

        //Route::get('Sua','system\DSTaiKhoanController@edit');
    });

    Route::group(['prefix' => 'KTCumKhoi'], function () {
        Route::group(['prefix' => 'HoSoKT'], function () {
            Route::get('ThongTin', [dshosokhenthuongcumkhoiController::class, 'ThongTin']);
            Route::post('Them', [dshosokhenthuongcumkhoiController::class, 'Them']);
            Route::get('Sua', [dshosokhenthuongcumkhoiController::class, 'ThayDoi']);
            Route::post('Sua', [dshosokhenthuongcumkhoiController::class, 'LuuHoSo']);
            
            Route::get('InHoSo', [dshosokhenthuongcongtrangController::class, 'XemHoSo']);
            Route::post('Xoa', [dshosokhenthuongcongtrangController::class, 'XoaHoSo']);
    
            Route::post('ThemTapThe', [dshosokhenthuongcongtrangController::class, 'ThemTapThe']);
            Route::get('XoaTapThe', [dshosokhenthuongcongtrangController::class, 'XoaTapThe']);
            Route::get('LayTapThe', [dshosokhenthuongcongtrangController::class, 'LayTapThe']);
            Route::post('NhanExcelTapThe', [dshosokhenthuongcongtrangController::class, 'NhanExcelTapThe']);
    
            Route::post('ThemCaNhan', [dshosokhenthuongcongtrangController::class, 'ThemCaNhan']);
            Route::get('XoaCaNhan', [dshosokhenthuongcongtrangController::class, 'XoaCaNhan']);
            Route::get('LayCaNhan', [dshosokhenthuongcongtrangController::class, 'LayCaNhan']);
            Route::post('NhanExcelCaNhan', [dshosokhenthuongcongtrangController::class, 'NhanExcelCaNhan']);
    
            Route::post('ThemDeTai', [dshosokhenthuongcongtrangController::class, 'ThemDeTai']);
            Route::get('XoaDeTai', [dshosokhenthuongcongtrangController::class, 'XoaDeTai']);
            Route::get('LayDeTai', [dshosokhenthuongcongtrangController::class, 'LayDeTai']);
            Route::post('NhanExcelDeTai', [dshosokhenthuongcongtrangController::class, 'NhanExcelDeTai']);
    
            Route::get('TaiLieuDinhKem', [dshosokhenthuongcongtrangController::class, 'TaiLieuDinhKem']);
            Route::post('ChuyenHoSo', 'NghiepVu\KhenThuongCongTrang\dshosokhenthuongcongtrangController@ChuyenHoSo');
            Route::get('LayLyDo', 'NghiepVu\KhenThuongCongTrang\dshosokhenthuongcongtrangController@LayLyDo');
            Route::get('LayTieuChuan', 'NghiepVu\KhenThuongCongTrang\dshosokhenthuongcongtrangController@LayTieuChuan');
            Route::get('LayDoiTuong', 'NghiepVu\KhenThuongCongTrang\dshosokhenthuongcongtrangController@LayDoiTuong');
            //29.10.2022
            Route::get('QuyetDinh', [dshosokhenthuongcongtrangController::class, 'QuyetDinh']);
            Route::get('TaoDuThao', [dshosokhenthuongcongtrangController::class, 'DuThaoQuyetDinh']);
            Route::post('QuyetDinh', [dshosokhenthuongcongtrangController::class, 'LuuQuyetDinh']);
            Route::get('PheDuyet', [dshosokhenthuongcongtrangController::class, 'PheDuyet']);
            Route::post('PheDuyet', [dshosokhenthuongcongtrangController::class, 'LuuPheDuyet']);
            Route::post('HuyPheDuyet', [dshosokhenthuongcongtrangController::class, 'HuyPheDuyet']);
            Route::get('InQuyetDinh', [dshosokhenthuongcongtrangController::class, 'InQuyetDinh']);
            Route::get('InPhoi', [dshosokhenthuongcongtrangController::class, 'InPhoi']);
    
            Route::post('NoiDungKhenThuong', [dshosokhenthuongcongtrangController::class, 'NoiDungKhenThuong']);
            Route::get('InBangKhenCaNhan', [dshosokhenthuongcongtrangController::class, 'InBangKhenCaNhan']);
            Route::get('InBangKhenTapThe', [dshosokhenthuongcongtrangController::class, 'InBangKhenTapThe']);
            Route::get('InGiayKhenCaNhan', [dshosokhenthuongcongtrangController::class, 'InGiayKhenCaNhan']);
            Route::get('InGiayKhenTapThe', [dshosokhenthuongcongtrangController::class, 'InGiayKhenTapThe']);
        });

        Route::group(['prefix' => 'HoSo'], function () {
            Route::get('ThongTin', [dshosodenghikhenthuongcumkhoiController::class, 'ThongTin']);
            Route::get('DanhSach', [dshosodenghikhenthuongcumkhoiController::class, 'DanhSach']);
            Route::post('Them', [dshosodenghikhenthuongcumkhoiController::class, 'Them']);
            Route::get('Sua', [dshosodenghikhenthuongcumkhoiController::class, 'ThayDoi']);
            Route::post('Sua', [dshosodenghikhenthuongcumkhoiController::class, 'LuuHoSo']);
            Route::get('InHoSo', [dshosodenghikhenthuongcumkhoiController::class, 'XemHoSo']);
            Route::post('Xoa', [dshosodenghikhenthuongcumkhoiController::class, 'XoaHoSo']);

            Route::post('ThemTapThe', [dshosodenghikhenthuongcumkhoiController::class, 'ThemTapThe']);
            Route::get('XoaTapThe', [dshosodenghikhenthuongcumkhoiController::class, 'XoaTapThe']);
            Route::get('LayTapThe', [dshosodenghikhenthuongcumkhoiController::class, 'LayTapThe']);
            Route::post('NhanExcelTapThe', [dshosodenghikhenthuongcumkhoiController::class, 'NhanExcelTapThe']);

            Route::post('ThemCaNhan', [dshosodenghikhenthuongcumkhoiController::class, 'ThemCaNhan']);
            Route::get('XoaCaNhan', [dshosodenghikhenthuongcumkhoiController::class, 'XoaCaNhan']);
            Route::get('LayCaNhan', [dshosodenghikhenthuongcumkhoiController::class, 'LayCaNhan']);
            Route::post('NhanExcelCaNhan', [dshosodenghikhenthuongcumkhoiController::class, 'NhanExcelCaNhan']);

            Route::post('ThemDeTai', [dshosodenghikhenthuongcumkhoiController::class, 'ThemDeTai']);
            Route::get('XoaDeTai', [dshosodenghikhenthuongcumkhoiController::class, 'XoaDeTai']);
            Route::get('LayDeTai', [dshosodenghikhenthuongcumkhoiController::class, 'LayDeTai']);
            Route::post('NhanExcelDeTai', [dshosodenghikhenthuongcumkhoiController::class, 'NhanExcelDeTai']);

            Route::get('TaiLieuDinhKem', [dshosodenghikhenthuongcumkhoiController::class, 'TaiLieuDinhKem']);
            Route::post('ChuyenHoSo', [dshosodenghikhenthuongcumkhoiController::class, 'ChuyenHoSo']);
            Route::get('LayLyDo', [dshosodenghikhenthuongcumkhoiController::class, 'LayLyDo']);
            Route::get('LayTieuChuan', [dshosodenghikhenthuongcumkhoiController::class, 'LayTieuChuan']);
            Route::get('LayDoiTuong', [dshosodenghikhenthuongcumkhoiController::class, 'LayDoiTuong']);

            //29.10.2022
            Route::get('QuyetDinh', [dshosodenghikhenthuongcumkhoiController::class, 'QuyetDinh']);
            Route::get('TaoDuThao', [dshosodenghikhenthuongcumkhoiController::class, 'DuThaoQuyetDinh']);
            Route::post('QuyetDinh', [dshosodenghikhenthuongcumkhoiController::class, 'LuuQuyetDinh']);
            Route::get('PheDuyet', [dshosodenghikhenthuongcumkhoiController::class, 'PheDuyet']);
            Route::post('PheDuyet', [dshosodenghikhenthuongcumkhoiController::class, 'LuuPheDuyet']);
            Route::post('HuyPheDuyet', [dshosodenghikhenthuongcumkhoiController::class, 'HuyPheDuyet']);

            Route::get('InQuyetDinh', [qdhosokhenthuongcumkhoiController::class, 'InQuyetDinh']);
            Route::get('InPhoi', [qdhosokhenthuongcumkhoiController::class, 'InPhoi']);

            Route::post('NoiDungKhenThuong', [qdhosokhenthuongcumkhoiController::class, 'NoiDungKhenThuong']);
            Route::get('InBangKhenCaNhan', [qdhosokhenthuongcumkhoiController::class, 'InBangKhenCaNhan']);
            Route::get('InBangKhenTapThe', [qdhosokhenthuongcumkhoiController::class, 'InBangKhenTapThe']);
            Route::get('InGiayKhenCaNhan', [qdhosokhenthuongcumkhoiController::class, 'InGiayKhenCaNhan']);
            Route::get('InGiayKhenTapThe', [qdhosokhenthuongcumkhoiController::class, 'InGiayKhenTapThe']);
        });

        Route::group(['prefix' => 'XetDuyet'], function () {
            Route::get('ThongTin', [xetduyethosokhenthuongcumkhoiController::class, 'ThongTin']);
            Route::post('TraLai', [xetduyethosokhenthuongcumkhoiController::class, 'TraLai']);
            Route::post('NhanHoSo', [xetduyethosokhenthuongcumkhoiController::class, 'NhanHoSo']);
            Route::post('ChuyenHoSo', [xetduyethosokhenthuongcumkhoiController::class, 'ChuyenHoSo']);

            Route::get('XetKT', [xetduyethosokhenthuongcumkhoiController::class, 'XetKT']);
            Route::post('ThemTapThe', [xetduyethosokhenthuongcumkhoiController::class, 'ThemTapThe']);
            Route::post('ThemCaNhan', [xetduyethosokhenthuongcumkhoiController::class, 'ThemCaNhan']);
            Route::post('GanKhenThuong', [xetduyethosokhenthuongcumkhoiController::class, 'GanKhenThuong']);
            Route::get('QuyetDinh', [xetduyethosokhenthuongcumkhoiController::class, 'QuyetDinh']);
            Route::get('TaoDuThao', [xetduyethosokhenthuongcumkhoiController::class, 'DuThaoQuyetDinh']);
            Route::post('QuyetDinh', [xetduyethosokhenthuongcumkhoiController::class, 'LuuQuyetDinh']);
            Route::post('PheDuyet', [xetduyethosokhenthuongcumkhoiController::class, 'PheDuyet']);
            Route::get('LayLyDo', [xetduyethosokhenthuongcumkhoiController::class, 'LayLyDo']);
        });

        Route::group(['prefix' => 'KhenThuong'], function () {
            Route::get('ThongTin', [qdhosokhenthuongcumkhoiController::class, 'ThongTin']);
            Route::post('Them', [qdhosokhenthuongcumkhoiController::class, 'Them']);
            Route::get('Sua', [qdhosokhenthuongcumkhoiController::class, 'Sua']);
            Route::post('Sua', [qdhosokhenthuongcumkhoiController::class, 'LuuHoSo']);
            Route::post('Xoa', [qdhosokhenthuongcumkhoiController::class, 'XoaHoSo']);

            Route::post('ThemTapThe', [qdhosokhenthuongcumkhoiController::class, 'ThemTapThe']);
            Route::get('XoaTapThe', [qdhosokhenthuongcumkhoiController::class, 'XoaTapThe']);
            Route::post('NhanExcelTapThe', [qdhosokhenthuongcumkhoiController::class, 'NhanExcelTapThe']);
            Route::post('ThemCaNhan', [qdhosokhenthuongcumkhoiController::class, 'ThemCaNhan']);
            Route::get('XoaCaNhan', [qdhosokhenthuongcumkhoiController::class, 'XoaCaNhan']);
            Route::post('NhanExcelCaNhan', [qdhosokhenthuongcumkhoiController::class, 'NhanExcelCaNhan']);
            Route::post('NhanExcelDeTai', [qdhosokhenthuongcumkhoiController::class, 'NhanExcelDeTai']);


            Route::get('XetKT', [qdhosokhenthuongcumkhoiController::class, 'XetKT']);
            Route::get('QuyetDinh', [qdhosokhenthuongcumkhoiController::class, 'QuyetDinh']);
            Route::get('TaoDuThao', [qdhosokhenthuongcumkhoiController::class, 'DuThaoQuyetDinh']);
            Route::post('QuyetDinh', [qdhosokhenthuongcumkhoiController::class, 'LuuQuyetDinh']);
            //Route::post('PheDuyet', [qdhosokhenthuongcumkhoiController::class, 'PheDuyet']);
            Route::get('PheDuyet', [qdhosokhenthuongcumkhoiController::class, 'PheDuyet']);
            Route::post('PheDuyet', [qdhosokhenthuongcumkhoiController::class, 'LuuPheDuyet']);
            Route::post('GanKhenThuong', [qdhosokhenthuongcumkhoiController::class, 'GanKhenThuong']);
            Route::post('HuyPheDuyet', [qdhosokhenthuongcumkhoiController::class, 'HuyPheDuyet']);
            Route::post('TraLai', [qdhosokhenthuongcumkhoiController::class, 'TraLai']);

            //In dữ liệu
            Route::post('LayDoiTuong', [qdhosokhenthuongcumkhoiController::class, 'LayDoiTuong']);
            Route::get('InQuyetDinh', [qdhosokhenthuongcumkhoiController::class, 'InQuyetDinh']);
            Route::post('InBangKhen', [qdhosokhenthuongcumkhoiController::class, 'InBangKhen']);
            Route::post('InGiayKhen', [qdhosokhenthuongcumkhoiController::class, 'InGiayKhen']);
            Route::get('InHoSo', [qdhosokhenthuongcumkhoiController::class, 'InHoSo']);

            Route::get('InPhoi', [qdhosokhenthuongcumkhoiController::class, 'InPhoi']);
            Route::post('NoiDungKhenThuong', [qdhosokhenthuongcumkhoiController::class, 'NoiDungKhenThuong']);
            Route::get('InBangKhenCaNhan', [qdhosokhenthuongcumkhoiController::class, 'InBangKhenCaNhan']);
            Route::get('InBangKhenTapThe', [qdhosokhenthuongcumkhoiController::class, 'InBangKhenTapThe']);
            Route::get('InGiayKhenCaNhan', [qdhosokhenthuongcumkhoiController::class, 'InGiayKhenCaNhan']);
            Route::get('InGiayKhenTapThe', [qdhosokhenthuongcumkhoiController::class, 'InGiayKhenTapThe']);
        });
    });

    Route::group(['prefix' => 'HoSoKhenThuong'], function () {
        Route::get('ThongTin', [dshosodenghikhenthuongcumkhoiController::class, 'ThongTin']);
        Route::get('DanhSach', 'NghiepVu\CumKhoiThiDua\dshosodenghikhenthuongcumkhoiController@DanhSach');

        Route::get('Them', 'NghiepVu\CumKhoiThiDua\dshosodenghikhenthuongcumkhoiController@ThayDoi');
        Route::post('Them', 'NghiepVu\CumKhoiThiDua\dshosodenghikhenthuongcumkhoiController@LuuHoSo');
        Route::get('Sua', 'NghiepVu\CumKhoiThiDua\dshosodenghikhenthuongcumkhoiController@Sua');
        Route::post('Sua', 'NghiepVu\CumKhoiThiDua\dshosodenghikhenthuongcumkhoiController@LuuHoSo');
        Route::get('Xem', 'NghiepVu\CumKhoiThiDua\dshosodenghikhenthuongcumkhoiController@XemHoSo');

        Route::get('ThemDoiTuong', 'NghiepVu\CumKhoiThiDua\dshosodenghikhenthuongcumkhoiController@ThemDoiTuong');
        Route::get('ThemDoiTuongTapThe', 'NghiepVu\CumKhoiThiDua\dshosodenghikhenthuongcumkhoiController@ThemDoiTuongTapThe');
        Route::get('LayTieuChuan', 'NghiepVu\CumKhoiThiDua\dshosodenghikhenthuongcumkhoiController@LayTieuChuan');
        Route::get('LuuTieuChuan', 'NghiepVu\CumKhoiThiDua\dshosodenghikhenthuongcumkhoiController@LuuTieuChuan');
        Route::get('LayDoiTuong', 'NghiepVu\CumKhoiThiDua\dshosodenghikhenthuongcumkhoiController@LayDoiTuong');

        Route::get('LayLyDo', 'NghiepVu\CumKhoiThiDua\dshosodenghikhenthuongcumkhoiController@LayLyDo');
        Route::get('XoaDoiTuong', 'NghiepVu\CumKhoiThiDua\dshosodenghikhenthuongcumkhoiController@XoaDoiTuong');

        Route::post('Xoa', 'NghiepVu\CumKhoiThiDua\dshosodenghikhenthuongcumkhoiController@XoaHoSo');
        Route::post('ChuyenHoSo', 'NghiepVu\CumKhoiThiDua\dshosodenghikhenthuongcumkhoiController@ChuyenHoSo');
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
