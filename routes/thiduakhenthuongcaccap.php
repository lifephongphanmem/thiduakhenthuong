<?php
use Illuminate\Support\Facades\Route;

//
//Khen cao
use App\Http\Controllers\NghiepVu\KhenCao\dshosokhencaochinhphuController;
use App\Http\Controllers\NghiepVu\KhenCao\dshosokhencaokhangchienController;
use App\Http\Controllers\NghiepVu\KhenCao\dshosokhencaonhanuocController;

Route::group(['prefix' => 'KhenCao'], function () {
    Route::group(['prefix' => 'ChinhPhu'], function () {
        Route::get('ThongTin', [dshosokhencaochinhphuController::class, 'ThongTin']);
        Route::post('Them', [dshosokhencaochinhphuController::class, 'Them']);
        Route::get('Sua', [dshosokhencaochinhphuController::class, 'ThayDoi']);
        Route::post('Sua', [dshosokhencaochinhphuController::class, 'LuuHoSo']);
        Route::get('InHoSo', [dshosokhencaochinhphuController::class, 'XemHoSo']);
        Route::get('InHoSoKT', [dshosokhencaochinhphuController::class, 'InHoSoKT']);
        Route::post('Xoa', [dshosokhencaochinhphuController::class, 'XoaHoSo']);
        Route::get('PheDuyet', [dshosokhencaochinhphuController::class, 'PheDuyet']);
        Route::post('PheDuyet', [dshosokhencaochinhphuController::class, 'LuuPheDuyet']);
        Route::post('HuyPheDuyet', [dshosokhencaochinhphuController::class, 'HuyPheDuyet']);
        Route::get('TaiLieuDinhKem', [dshosokhencaochinhphuController::class, 'TaiLieuDinhKem']);
        Route::get('InQuyetDinh', [dshosokhencaochinhphuController::class, 'InQuyetDinh']);
        Route::post('GanKhenThuong', [dshosokhencaochinhphuController::class, 'GanKhenThuong']);

        Route::post('ThemTapThe', [dshosokhencaochinhphuController::class, 'ThemTapThe']);
        Route::get('XoaTapThe', [dshosokhencaochinhphuController::class, 'XoaTapThe']);
        Route::get('LayTapThe', [dshosokhencaochinhphuController::class, 'LayTapThe']);
        Route::post('NhanExcelTapThe', [dshosokhencaochinhphuController::class, 'NhanExcelTapThe']);

        Route::post('ThemCaNhan', [dshosokhencaochinhphuController::class, 'ThemCaNhan']);
        Route::get('XoaCaNhan', [dshosokhencaochinhphuController::class, 'XoaCaNhan']);
        Route::get('LayCaNhan', [dshosokhencaochinhphuController::class, 'LayCaNhan']);
        Route::post('NhanExcelCaNhan', [dshosokhencaochinhphuController::class, 'NhanExcelCaNhan']);
    });
    Route::group(['prefix' => 'NhaNuoc'], function () {
        Route::get('ThongTin', [dshosokhencaonhanuocController::class, 'ThongTin']);
        Route::post('Them', [dshosokhencaonhanuocController::class, 'Them']);
        Route::get('Sua', [dshosokhencaonhanuocController::class, 'ThayDoi']);
        Route::post('Sua', [dshosokhencaonhanuocController::class, 'LuuHoSo']);
        Route::get('InHoSo', [dshosokhencaonhanuocController::class, 'XemHoSo']);
        Route::get('InHoSoKT', [dshosokhencaonhanuocController::class, 'InHoSoKT']);
        Route::post('Xoa', [dshosokhencaonhanuocController::class, 'XoaHoSo']);
        Route::get('PheDuyet', [dshosokhencaonhanuocController::class, 'PheDuyet']);
        Route::post('PheDuyet', [dshosokhencaonhanuocController::class, 'LuuPheDuyet']);
        Route::post('HuyPheDuyet', [dshosokhencaonhanuocController::class, 'HuyPheDuyet']);
        Route::get('TaiLieuDinhKem', [dshosokhencaonhanuocController::class, 'TaiLieuDinhKem']);
        Route::get('InQuyetDinh', [dshosokhencaonhanuocController::class, 'InQuyetDinh']);
        Route::post('GanKhenThuong', [dshosokhencaonhanuocController::class, 'GanKhenThuong']);

        Route::post('ThemTapThe', [dshosokhencaonhanuocController::class, 'ThemTapThe']);
        Route::get('XoaTapThe', [dshosokhencaonhanuocController::class, 'XoaTapThe']);
        Route::get('LayTapThe', [dshosokhencaonhanuocController::class, 'LayTapThe']);
        Route::post('NhanExcelTapThe', [dshosokhencaonhanuocController::class, 'NhanExcelTapThe']);

        Route::post('ThemCaNhan', [dshosokhencaonhanuocController::class, 'ThemCaNhan']);
        Route::get('XoaCaNhan', [dshosokhencaonhanuocController::class, 'XoaCaNhan']);
        Route::get('LayCaNhan', [dshosokhencaonhanuocController::class, 'LayCaNhan']);
        Route::post('NhanExcelCaNhan', [dshosokhencaonhanuocController::class, 'NhanExcelCaNhan']);
    });

    Route::group(['prefix' => 'KhangChien'], function () {
        Route::get('ThongTin', [dshosokhencaokhangchienController::class, 'ThongTin']);
        Route::post('Them', [dshosokhencaokhangchienController::class, 'Them']);
        Route::get('Sua', [dshosokhencaokhangchienController::class, 'ThayDoi']);
        Route::post('Sua', [dshosokhencaokhangchienController::class, 'LuuHoSo']);
        Route::get('InHoSo', [dshosokhencaokhangchienController::class, 'XemHoSo']);
        Route::get('InHoSoKT', [dshosokhencaokhangchienController::class, 'InHoSoKT']);
        Route::post('Xoa', [dshosokhencaokhangchienController::class, 'XoaHoSo']);
        Route::get('PheDuyet', [dshosokhencaokhangchienController::class, 'PheDuyet']);
        Route::post('PheDuyet', [dshosokhencaokhangchienController::class, 'LuuPheDuyet']);
        Route::post('HuyPheDuyet', [dshosokhencaokhangchienController::class, 'HuyPheDuyet']);
        Route::get('TaiLieuDinhKem', [dshosokhencaokhangchienController::class, 'TaiLieuDinhKem']);
        Route::get('InQuyetDinh', [dshosokhencaokhangchienController::class, 'InQuyetDinh']);
        Route::post('GanKhenThuong', [dshosokhencaokhangchienController::class, 'GanKhenThuong']);

        Route::post('ThemTapThe', [dshosokhencaokhangchienController::class, 'ThemTapThe']);
        Route::get('XoaTapThe', [dshosokhencaokhangchienController::class, 'XoaTapThe']);
        Route::get('LayTapThe', [dshosokhencaokhangchienController::class, 'LayTapThe']);
        Route::post('NhanExcelTapThe', [dshosokhencaokhangchienController::class, 'NhanExcelTapThe']);

        Route::post('ThemCaNhan', [dshosokhencaokhangchienController::class, 'ThemCaNhan']);
        Route::get('XoaCaNhan', [dshosokhencaokhangchienController::class, 'XoaCaNhan']);
        Route::get('LayCaNhan', [dshosokhencaokhangchienController::class, 'LayCaNhan']);
        Route::post('NhanExcelCaNhan', [dshosokhencaokhangchienController::class, 'NhanExcelCaNhan']);
    });
});

//Khen thưởng theo niên hạn
use App\Http\Controllers\NghiepVu\KhenThuongNienHan\dshosokhenthuongnienhanController;
use App\Http\Controllers\NghiepVu\KhenThuongNienHan\qdhosokhenthuongnienhanController;
use App\Http\Controllers\NghiepVu\KhenThuongNienHan\xdhosokhenthuongnienhanController;

Route::group(['prefix' => 'KhenThuongNienHan'], function () {
    Route::group(['prefix' => 'HoSo'], function () {
        Route::get('ThongTin', [dshosokhenthuongnienhanController::class, 'ThongTin']);
        Route::post('Them', [dshosokhenthuongnienhanController::class, 'Them']);
        Route::get('Sua', [dshosokhenthuongnienhanController::class, 'ThayDoi']);
        Route::post('Sua', [dshosokhenthuongnienhanController::class, 'LuuHoSo']);
        Route::get('InHoSo', [dshosokhenthuongnienhanController::class, 'XemHoSo']);
        Route::post('Xoa', [dshosokhenthuongnienhanController::class, 'XoaHoSo']);

        Route::post('ThemTapThe', [dshosokhenthuongnienhanController::class, 'ThemTapThe']);
        Route::get('XoaTapThe', [dshosokhenthuongnienhanController::class, 'XoaTapThe']);
        Route::get('LayTapThe', [dshosokhenthuongnienhanController::class, 'LayTapThe']);
        Route::post('NhanExcelTapThe', [dshosokhenthuongnienhanController::class, 'NhanExcelTapThe']);

        Route::post('ThemCaNhan', [dshosokhenthuongnienhanController::class, 'ThemCaNhan']);
        Route::get('XoaCaNhan', [dshosokhenthuongnienhanController::class, 'XoaCaNhan']);
        Route::get('LayCaNhan', [dshosokhenthuongnienhanController::class, 'LayCaNhan']);
        Route::post('NhanExcelCaNhan', [dshosokhenthuongnienhanController::class, 'NhanExcelCaNhan']);

        Route::post('ThemDeTai', [dshosokhenthuongnienhanController::class, 'ThemDeTai']);
        Route::get('XoaDeTai', [dshosokhenthuongnienhanController::class, 'XoaDeTai']);
        Route::get('LayDeTai', [dshosokhenthuongnienhanController::class, 'LayDeTai']);
        Route::post('NhanExcelDeTai', [dshosokhenthuongnienhanController::class, 'NhanExcelDeTai']);

        Route::get('TaiLieuDinhKem', [dshosokhenthuongnienhanController::class, 'TaiLieuDinhKem']);
        Route::post('ChuyenHoSo', [dshosokhenthuongnienhanController::class, 'ChuyenHoSo']);
        Route::get('LayLyDo', [dshosokhenthuongnienhanController::class, 'LayLyDo']);
        Route::get('LayTieuChuan', [dshosokhenthuongnienhanController::class, 'LayTieuChuan']);
        Route::get('LayDoiTuong', [dshosokhenthuongnienhanController::class, 'LayDoiTuong']);
    });

    Route::group(['prefix' => 'XetDuyet'], function () {
        Route::get('ThongTin', [xdhosokhenthuongnienhanController::class, 'ThongTin']);
        Route::post('TraLai', [xdhosokhenthuongnienhanController::class, 'TraLai']);
        Route::post('NhanHoSo', [xdhosokhenthuongnienhanController::class, 'NhanHoSo']);
        Route::post('ChuyenHoSo', [xdhosokhenthuongnienhanController::class, 'ChuyenHoSo']);

        Route::get('XetKT', [xdhosokhenthuongnienhanController::class, 'XetKT']);
        Route::post('ThemTapThe', [xdhosokhenthuongnienhanController::class, 'ThemTapThe']);
        Route::post('ThemCaNhan', [xdhosokhenthuongnienhanController::class, 'ThemCaNhan']);
        Route::post('GanKhenThuong', [xdhosokhenthuongnienhanController::class, 'GanKhenThuong']);
        Route::get('QuyetDinh', [xdhosokhenthuongnienhanController::class, 'QuyetDinh']);
        Route::get('TaoDuThao', [xdhosokhenthuongnienhanController::class, 'DuThaoQuyetDinh']);
        Route::post('QuyetDinh', [xdhosokhenthuongnienhanController::class, 'LuuQuyetDinh']);
        Route::post('PheDuyet', [xdhosokhenthuongnienhanController::class, 'PheDuyet']);
        Route::get('LayLyDo', [xdhosokhenthuongnienhanController::class, 'LayLyDo']);
    });
    Route::group(['prefix' => 'KhenThuong'], function () {
        Route::get('ThongTin', [qdhosokhenthuongnienhanController::class, 'ThongTin']);
        Route::post('Them', [qdhosokhenthuongnienhanController::class, 'Them']);
        Route::get('Sua', [qdhosokhenthuongnienhanController::class, 'Sua']);
        Route::post('Sua', [qdhosokhenthuongnienhanController::class, 'LuuHoSo']);
        Route::post('Xoa', [qdhosokhenthuongnienhanController::class, 'XoaHoSo']);

        Route::post('ThemTapThe', [qdhosokhenthuongnienhanController::class, 'ThemTapThe']);
        Route::get('XoaTapThe', [qdhosokhenthuongnienhanController::class, 'XoaTapThe']);
        Route::post('NhanExcelTapThe', [qdhosokhenthuongnienhanController::class, 'NhanExcelTapThe']);
        Route::post('ThemCaNhan', [qdhosokhenthuongnienhanController::class, 'ThemCaNhan']);
        Route::get('XoaCaNhan', [qdhosokhenthuongnienhanController::class, 'XoaCaNhan']);
        Route::post('NhanExcelCaNhan', [qdhosokhenthuongnienhanController::class, 'NhanExcelCaNhan']);
        Route::post('NhanExcelDeTai', [qdhosokhenthuongnienhanController::class, 'NhanExcelDeTai']);

        Route::get('XetKT', [qdhosokhenthuongnienhanController::class, 'XetKT']);
        Route::get('QuyetDinh', [qdhosokhenthuongnienhanController::class, 'QuyetDinh']);
        Route::get('TaoDuThao', [qdhosokhenthuongnienhanController::class, 'DuThaoQuyetDinh']);
        Route::post('QuyetDinh', [qdhosokhenthuongnienhanController::class, 'LuuQuyetDinh']);
        Route::post('PheDuyet', [qdhosokhenthuongnienhanController::class, 'PheDuyet']);
        Route::post('GanKhenThuong', [qdhosokhenthuongnienhanController::class, 'GanKhenThuong']);
        Route::post('HuyPheDuyet', [qdhosokhenthuongnienhanController::class, 'HuyPheDuyet']);
        Route::post('TraLai', [qdhosokhenthuongnienhanController::class, 'TraLai']);

        Route::post('LayDoiTuong', [qdhosokhenthuongnienhanController::class, 'LayDoiTuong']);
        //In dữ liệu
        Route::get('InHoSo', [qdhosokhenthuongnienhanController::class, 'XemHoSo']);
        Route::get('InQuyetDinh', [qdhosokhenthuongnienhanController::class, 'InQuyetDinh']);

        Route::get('InPhoi', [qdhosokhenthuongnienhanController::class, 'InPhoi']);
        Route::post('NoiDungKhenThuong', [qdhosokhenthuongnienhanController::class, 'NoiDungKhenThuong']);
        Route::get('InBangKhenCaNhan', [qdhosokhenthuongnienhanController::class, 'InBangKhenCaNhan']);
        Route::get('InBangKhenTapThe', [qdhosokhenthuongnienhanController::class, 'InBangKhenTapThe']);
        Route::get('InGiayKhenCaNhan', [qdhosokhenthuongnienhanController::class, 'InGiayKhenCaNhan']);
        Route::get('InGiayKhenTapThe', [qdhosokhenthuongnienhanController::class, 'InGiayKhenTapThe']);
    });
});


