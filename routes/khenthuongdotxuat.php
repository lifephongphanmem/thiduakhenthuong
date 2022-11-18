<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NghiepVu\KhenThuongDotXuat\dshosodenghikhenthuongdotxuatController;
use App\Http\Controllers\NghiepVu\KhenThuongDotXuat\qdhosodenghikhenthuongdotxuatController;
use App\Http\Controllers\NghiepVu\KhenThuongDotXuat\xdhosodenghikhenthuongdotxuatController;
use App\Http\Controllers\NghiepVu\KhenThuongDotXuat\dshosokhenthuongdotxuatController;
//Khen thưởng đột xuất
Route::group(['prefix' => 'KhenThuongDotXuat'], function () {
    Route::group(['prefix' => 'HoSoKT'], function () {
        Route::get('ThongTin', [dshosokhenthuongdotxuatController::class, 'ThongTin']);
        Route::post('Them', [dshosokhenthuongdotxuatController::class, 'Them']);
        Route::get('Sua', [dshosokhenthuongdotxuatController::class, 'ThayDoi']);
        Route::post('Sua', [dshosokhenthuongdotxuatController::class, 'LuuHoSo']);
        Route::get('InHoSo', [dshosokhenthuongdotxuatController::class, 'XemHoSo']);
        Route::get('InHoSoKT', [dshosokhenthuongdotxuatController::class, 'InHoSoKT']);
        Route::post('Xoa', [dshosokhenthuongdotxuatController::class, 'XoaHoSo']);

        Route::post('ThemTapThe', [dshosokhenthuongdotxuatController::class, 'ThemTapThe']);
        Route::get('XoaTapThe', [dshosokhenthuongdotxuatController::class, 'XoaTapThe']);
        Route::get('LayTapThe', [dshosokhenthuongdotxuatController::class, 'LayTapThe']);
        //Route::post('NhanExcelTapThe', [dshosokhenthuongdotxuatController::class, 'NhanExcelTapThe']);

        Route::post('ThemCaNhan', [dshosokhenthuongdotxuatController::class, 'ThemCaNhan']);
        Route::get('XoaCaNhan', [dshosokhenthuongdotxuatController::class, 'XoaCaNhan']);
        Route::get('LayCaNhan', [dshosokhenthuongdotxuatController::class, 'LayCaNhan']);
        //Route::post('NhanExcelCaNhan', [dshosokhenthuongdotxuatController::class, 'NhanExcelCaNhan']);

        Route::post('ThemDeTai', [dshosokhenthuongdotxuatController::class, 'ThemDeTai']);
        Route::get('XoaDeTai', [dshosokhenthuongdotxuatController::class, 'XoaDeTai']);
        Route::get('LayDeTai', [dshosokhenthuongdotxuatController::class, 'LayDeTai']);

        Route::post('ThemHoGiaDinh', [dshosokhenthuongdotxuatController::class, 'ThemHoGiaDinh']);
        Route::get('XoaHoGiaDinh', [dshosokhenthuongdotxuatController::class, 'XoaHoGiaDinh']);
        Route::get('LayHoGiaDinh', [dshosokhenthuongdotxuatController::class, 'LayHoGiaDinh']);

        Route::post('NhanExcel', [dshosokhenthuongdotxuatController::class, 'NhanExcel']);

        Route::get('TaiLieuDinhKem', [dshosokhenthuongdotxuatController::class, 'TaiLieuDinhKem']);
        Route::post('ChuyenHoSo', [dshosokhenthuongdotxuatController::class, 'ChuyenHoSo']);
        Route::get('LayLyDo', [dshosokhenthuongdotxuatController::class, 'LayLyDo']);

        //29.10.2022
        Route::get('QuyetDinh', [dshosokhenthuongdotxuatController::class, 'QuyetDinh']);
        Route::get('TaoDuThao', [dshosokhenthuongdotxuatController::class, 'DuThaoQuyetDinh']);
        Route::post('QuyetDinh', [dshosokhenthuongdotxuatController::class, 'LuuQuyetDinh']);
        Route::get('PheDuyet', [dshosokhenthuongdotxuatController::class, 'PheDuyet']);
        Route::post('PheDuyet', [dshosokhenthuongdotxuatController::class, 'LuuPheDuyet']);
        Route::post('HuyPheDuyet', [dshosokhenthuongdotxuatController::class, 'HuyPheDuyet']);
        Route::get('InQuyetDinh', [dshosokhenthuongdotxuatController::class, 'InQuyetDinh']);
        Route::get('InPhoi', [dshosokhenthuongdotxuatController::class, 'InPhoi']);

        Route::post('NoiDungKhenThuong', [dshosokhenthuongdotxuatController::class, 'NoiDungKhenThuong']);
        Route::get('InBangKhenCaNhan', [dshosokhenthuongdotxuatController::class, 'InBangKhenCaNhan']);
        Route::get('InBangKhenTapThe', [dshosokhenthuongdotxuatController::class, 'InBangKhenTapThe']);
        Route::get('InGiayKhenCaNhan', [dshosokhenthuongdotxuatController::class, 'InGiayKhenCaNhan']);
        Route::get('InGiayKhenTapThe', [dshosokhenthuongdotxuatController::class, 'InGiayKhenTapThe']);

        //09.11.2022
        Route::get('ToTrinhHoSo', [dshosokhenthuongdotxuatController::class, 'ToTrinhHoSo']);
        Route::post('ToTrinhHoSo', [dshosokhenthuongdotxuatController::class, 'LuuToTrinhHoSo']);
        Route::get('InToTrinhHoSo', [dshosokhenthuongdotxuatController::class, 'InToTrinhHoSo']);

        Route::get('ToTrinhPheDuyet', [dshosokhenthuongdotxuatController::class, 'ToTrinhPheDuyet']);
        Route::post('ToTrinhPheDuyet', [dshosokhenthuongdotxuatController::class, 'LuuToTrinhPheDuyet']);
        Route::get('InToTrinhPheDuyet', [dshosokhenthuongdotxuatController::class, 'InToTrinhPheDuyet']);
    });

    Route::group(['prefix' => 'HoSo'], function () {
        Route::get('ThongTin', 'NghiepVu\KhenThuongDotXuat\dshosodenghikhenthuongdotxuatController@ThongTin');
        Route::post('Them', 'NghiepVu\KhenThuongDotXuat\dshosodenghikhenthuongdotxuatController@Them');
        Route::get('Sua', 'NghiepVu\KhenThuongDotXuat\dshosodenghikhenthuongdotxuatController@ThayDoi');
        Route::post('Sua', 'NghiepVu\KhenThuongDotXuat\dshosodenghikhenthuongdotxuatController@LuuHoSo');
        Route::get('Xem', 'NghiepVu\KhenThuongDotXuat\dshosodenghikhenthuongdotxuatController@XemHoSo');
        Route::post('Xoa', 'NghiepVu\KhenThuongDotXuat\dshosodenghikhenthuongdotxuatController@XoaHoSo');

        Route::post('CaNhan', 'NghiepVu\KhenThuongDotXuat\dshosodenghikhenthuongdotxuatController@ThemCaNhan');
        Route::post('TapThe', 'NghiepVu\KhenThuongDotXuat\dshosodenghikhenthuongdotxuatController@ThemTapThe');
        Route::get('LayTieuChuan', 'NghiepVu\KhenThuongDotXuat\dshosodenghikhenthuongdotxuatController@LayTieuChuan');
        Route::get('LayDoiTuong', 'NghiepVu\KhenThuongDotXuat\dshosodenghikhenthuongdotxuatController@LayDoiTuong');
        Route::post('ChuyenHoSo', 'NghiepVu\KhenThuongDotXuat\dshosodenghikhenthuongdotxuatController@ChuyenHoSo');
        Route::get('LayLyDo', 'NghiepVu\KhenThuongDotXuat\dshosodenghikhenthuongdotxuatController@LayLyDo');

        Route::get('InHoSo', [dshosodenghikhenthuongdotxuatController::class, 'XemHoSo']);
        Route::get('InHoSoPD', [qdhosodenghikhenthuongdotxuatController::class, 'XemHoSo']);
       
        Route::post('ThemTapThe', [dshosodenghikhenthuongdotxuatController::class, 'ThemTapThe']);
        Route::get('XoaTapThe', [dshosodenghikhenthuongdotxuatController::class, 'XoaTapThe']);
        Route::get('LayTapThe', [dshosodenghikhenthuongdotxuatController::class, 'LayTapThe']);
        //Route::post('NhanExcelTapThe', [dshosodenghikhenthuongdotxuatController::class, 'NhanExcelTapThe']);

        Route::post('ThemHoGiaDinh', [dshosodenghikhenthuongdotxuatController::class, 'ThemHoGiaDinh']);
        Route::get('XoaHoGiaDinh', [dshosodenghikhenthuongdotxuatController::class, 'XoaHoGiaDinh']);
        Route::get('LayHoGiaDinh', [dshosodenghikhenthuongdotxuatController::class, 'LayHoGiaDinh']);

        Route::post('ThemCaNhan', [dshosodenghikhenthuongdotxuatController::class, 'ThemCaNhan']);
        Route::get('XoaCaNhan', [dshosodenghikhenthuongdotxuatController::class, 'XoaCaNhan']);
        Route::get('LayCaNhan', [dshosodenghikhenthuongdotxuatController::class, 'LayCaNhan']);
        //Route::post('NhanExcelCaNhan', [dshosodenghikhenthuongdotxuatController::class, 'NhanExcelCaNhan']);
        Route::get('TaiLieuDinhKem', [dshosodenghikhenthuongdotxuatController::class, 'TaiLieuDinhKem']);

        Route::post('NhanExcel', [dshosodenghikhenthuongdotxuatController::class, 'NhanExcel']);
        //29.10.2022
        Route::get('QuyetDinh', [dshosodenghikhenthuongdotxuatController::class, 'QuyetDinh']);
        Route::get('TaoDuThao', [dshosodenghikhenthuongdotxuatController::class, 'DuThaoQuyetDinh']);
        Route::post('QuyetDinh', [dshosodenghikhenthuongdotxuatController::class, 'LuuQuyetDinh']);
        Route::get('PheDuyet', [dshosodenghikhenthuongdotxuatController::class, 'PheDuyet']);
        Route::post('PheDuyet', [dshosodenghikhenthuongdotxuatController::class, 'LuuPheDuyet']);
        Route::post('HuyPheDuyet', [dshosodenghikhenthuongdotxuatController::class, 'HuyPheDuyet']);

        Route::get('InQuyetDinh', [qdhosodenghikhenthuongdotxuatController::class, 'InQuyetDinh']);
        Route::get('InPhoi', [qdhosodenghikhenthuongdotxuatController::class, 'InPhoi']);

        Route::post('NoiDungKhenThuong', [qdhosodenghikhenthuongdotxuatController::class, 'NoiDungKhenThuong']);
        Route::get('InBangKhenCaNhan', [qdhosodenghikhenthuongdotxuatController::class, 'InBangKhenCaNhan']);
        Route::get('InBangKhenTapThe', [qdhosodenghikhenthuongdotxuatController::class, 'InBangKhenTapThe']);
        Route::get('InGiayKhenCaNhan', [qdhosodenghikhenthuongdotxuatController::class, 'InGiayKhenCaNhan']);
        Route::get('InGiayKhenTapThe', [qdhosodenghikhenthuongdotxuatController::class, 'InGiayKhenTapThe']);

        //09.11.2022
        Route::get('ToTrinhHoSo', [dshosodenghikhenthuongdotxuatController::class, 'ToTrinhHoSo']);
        Route::post('ToTrinhHoSo', [dshosodenghikhenthuongdotxuatController::class, 'LuuToTrinhHoSo']);
        Route::get('InToTrinhHoSo', [dshosodenghikhenthuongdotxuatController::class, 'InToTrinhHoSo']);

        Route::get('ToTrinhPheDuyet', [dshosodenghikhenthuongdotxuatController::class, 'ToTrinhPheDuyet']);
        Route::post('ToTrinhPheDuyet', [dshosodenghikhenthuongdotxuatController::class, 'LuuToTrinhPheDuyet']);
        Route::get('InToTrinhPheDuyet', [dshosodenghikhenthuongdotxuatController::class, 'InToTrinhPheDuyet']);
    });

    Route::group(['prefix' => 'XetDuyet'], function () {
        Route::get('ThongTin', 'NghiepVu\KhenThuongDotXuat\xdhosodenghikhenthuongdotxuatController@ThongTin');
        Route::post('TraLai', 'NghiepVu\KhenThuongDotXuat\xdhosodenghikhenthuongdotxuatController@TraLai');
        Route::post('NhanHoSo', 'NghiepVu\KhenThuongDotXuat\xdhosodenghikhenthuongdotxuatController@NhanHoSo');
        Route::post('ChuyenHoSo', 'NghiepVu\KhenThuongDotXuat\xdhosodenghikhenthuongdotxuatController@ChuyenHoSo');

        Route::get('XetKT', [xdhosodenghikhenthuongdotxuatController::class, 'XetKT']);
        Route::post('ThemTapThe', [xdhosodenghikhenthuongdotxuatController::class, 'ThemTapThe']);
        Route::post('ThemCaNhan', [xdhosodenghikhenthuongdotxuatController::class, 'ThemCaNhan']);
        Route::post('GanKhenThuong', [xdhosodenghikhenthuongdotxuatController::class, 'GanKhenThuong']);
        Route::get('QuyetDinh', [xdhosodenghikhenthuongdotxuatController::class, 'QuyetDinh']);
        Route::get('TaoDuThao', [xdhosodenghikhenthuongdotxuatController::class, 'DuThaoQuyetDinh']);
        Route::post('QuyetDinh', [xdhosodenghikhenthuongdotxuatController::class, 'LuuQuyetDinh']);
        Route::post('PheDuyet', [xdhosodenghikhenthuongdotxuatController::class, 'PheDuyet']);
        Route::get('LayLyDo', [xdhosodenghikhenthuongdotxuatController::class, 'LayLyDo']);

        //
        Route::get('ToTrinhPheDuyet', [xdhosodenghikhenthuongdotxuatController::class, 'ToTrinhPheDuyet']);
        Route::post('ToTrinhPheDuyet', [xdhosodenghikhenthuongdotxuatController::class, 'LuuToTrinhPheDuyet']);

        Route::get('TrinhKetQua', [xdhosodenghikhenthuongdotxuatController::class, 'TrinhKetQua']);
        Route::post('TrinhKetQua', [xdhosodenghikhenthuongdotxuatController::class, 'LuuTrinhKetQua']);
    });

    Route::group(['prefix' => 'KhenThuong'], function () {
        Route::get('ThongTin', 'NghiepVu\KhenThuongDotXuat\qdhosodenghikhenthuongdotxuatController@ThongTin');
        Route::post('KhenThuong', 'NghiepVu\KhenThuongDotXuat\qdhosodenghikhenthuongdotxuatController@KhenThuong');
        Route::get('DanhSach', 'NghiepVu\KhenThuongDotXuat\qdhosodenghikhenthuongdotxuatController@DanhSach');
        Route::post('DanhSach', 'NghiepVu\KhenThuongDotXuat\qdhosodenghikhenthuongdotxuatController@LuuHoSo');
        //Route::post('PheDuyet', 'NghiepVu\KhenThuongDotXuat\qdhosodenghikhenthuongdotxuatController@PheDuyet');

        Route::get('PheDuyet', [qdhosodenghikhenthuongdotxuatController::class, 'PheDuyet']);
        Route::post('PheDuyet', [qdhosodenghikhenthuongdotxuatController::class, 'LuuPheDuyet']);

        Route::post('ThemTapThe', [qdhosodenghikhenthuongdotxuatController::class, 'ThemTapThe']);
        Route::post('ThemCaNhan', [qdhosodenghikhenthuongdotxuatController::class, 'ThemCaNhan']);
        Route::post('ThemHoGiaDinh', [qdhosodenghikhenthuongdotxuatController::class, 'ThemHoGiaDinh']);
        Route::post('GanKhenThuong', [qdhosodenghikhenthuongdotxuatController::class, 'GanKhenThuong']);

        Route::post('HuyPheDuyet', 'NghiepVu\KhenThuongDotXuat\qdhosodenghikhenthuongdotxuatController@HuyPheDuyet');
        Route::post('HoSo', 'NghiepVu\KhenThuongDotXuat\qdhosodenghikhenthuongdotxuatController@HoSo');
        Route::post('KetQua', 'NghiepVu\KhenThuongDotXuat\qdhosodenghikhenthuongdotxuatController@KetQua');
        Route::get('LayDoiTuong', 'NghiepVu\KhenThuongDotXuat\qdhosodenghikhenthuongdotxuatController@LayDoiTuong');
        Route::get('LayTieuChuan', 'NghiepVu\KhenThuongDotXuat\qdhosodenghikhenthuongdotxuatController@LayTieuChuan');

        Route::get('InKetQua', 'NghiepVu\KhenThuongDotXuat\qdhosodenghikhenthuongdotxuatController@InKetQua');
        Route::get('MacDinhQuyetDinh', 'NghiepVu\KhenThuongDotXuat\qdhosodenghikhenthuongdotxuatController@MacDinhQuyetDinh');
        Route::get('QuyetDinh', 'NghiepVu\KhenThuongDotXuat\qdhosodenghikhenthuongdotxuatController@QuyetDinh');
        Route::post('QuyetDinh', 'NghiepVu\KhenThuongDotXuat\qdhosodenghikhenthuongdotxuatController@LuuQuyetDinh');
        Route::get('XemQuyetDinh', 'NghiepVu\KhenThuongDotXuat\qdhosodenghikhenthuongdotxuatController@XemQuyetDinh');

        Route::get('InHoSoPD', [qdhosodenghikhenthuongdotxuatController::class, 'XemHoSo']);
        Route::get('InQuyetDinh', [qdhosodenghikhenthuongdotxuatController::class, 'InQuyetDinh']);

        Route::get('InPhoi', [qdhosodenghikhenthuongdotxuatController::class, 'InPhoi']);
        Route::post('NoiDungKhenThuong', [qdhosodenghikhenthuongdotxuatController::class, 'NoiDungKhenThuong']);
        Route::get('InBangKhenCaNhan', [qdhosodenghikhenthuongdotxuatController::class, 'InBangKhenCaNhan']);
        Route::get('InBangKhenTapThe', [qdhosodenghikhenthuongdotxuatController::class, 'InBangKhenTapThe']);
        Route::get('InGiayKhenCaNhan', [qdhosodenghikhenthuongdotxuatController::class, 'InGiayKhenCaNhan']);
        Route::get('InGiayKhenTapThe', [qdhosodenghikhenthuongdotxuatController::class, 'InGiayKhenTapThe']);

        //23.10.2022
        Route::post('ThemTapThe', [xdhosodenghikhenthuongdotxuatController::class, 'ThemTapThe']);
        Route::post('ThemCaNhan', [xdhosodenghikhenthuongdotxuatController::class, 'ThemCaNhan']);
        Route::post('TraLai', 'NghiepVu\KhenThuongDotXuat\qdhosodenghikhenthuongdotxuatController@TraLai');

        //09.11.2022
        
        Route::get('InToTrinhPheDuyet', [qdhosodenghikhenthuongdotxuatController::class, 'InToTrinhPheDuyet']);
    });
});
