<?php
//Phong trào thi đua


use App\Http\Controllers\NghiepVu\ThiDuaKhenThuong\dshosothiduaController;
use App\Http\Controllers\NghiepVu\ThiDuaKhenThuong\dsphongtraothiduaController;
use App\Http\Controllers\NghiepVu\ThiDuaKhenThuong\qdhosodenghikhenthuongthiduaController;
use App\Http\Controllers\NghiepVu\ThiDuaKhenThuong\dshosodenghikhenthuongthiduaController;
use App\Http\Controllers\NghiepVu\ThiDuaKhenThuong\dshosokhenthuongthiduaController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'PhongTraoThiDua'], function () {
    Route::get('ThongTin', [dsphongtraothiduaController::class, 'ThongTin']);
    Route::get('Xem', 'NghiepVu\ThiDuaKhenThuong\dsphongtraothiduaController@XemThongTin');
    Route::get('Them', 'NghiepVu\ThiDuaKhenThuong\dsphongtraothiduaController@ThayDoi');
    Route::post('Them', 'NghiepVu\ThiDuaKhenThuong\dsphongtraothiduaController@LuuPhongTrao');
    Route::get('Sua', 'NghiepVu\ThiDuaKhenThuong\dsphongtraothiduaController@ThayDoi');
    Route::post('Sua', 'NghiepVu\ThiDuaKhenThuong\dsphongtraothiduaController@LuuPhongTrao');
    Route::post('KetThuc', [dsphongtraothiduaController::class, 'KetThuc']);
    Route::post('HuyKetThuc', [dsphongtraothiduaController::class, 'HuyKetThuc']);
    Route::post('Xoa', 'NghiepVu\ThiDuaKhenThuong\dsphongtraothiduaController@Xoa');

    Route::get('ThemKhenThuong', 'NghiepVu\ThiDuaKhenThuong\dsphongtraothiduaController@ThemKhenThuong');
    Route::get('ThemTieuChuan', 'NghiepVu\ThiDuaKhenThuong\dsphongtraothiduaController@ThemTieuChuan');
    Route::get('LayTieuChuan', 'NghiepVu\ThiDuaKhenThuong\dsphongtraothiduaController@LayTieuChuan');
    Route::get('XoaTieuChuan', 'NghiepVu\ThiDuaKhenThuong\dsphongtraothiduaController@XoaTieuChuan');
    Route::get('TaiLieuDinhKem', 'NghiepVu\ThiDuaKhenThuong\dsphongtraothiduaController@TaiLieuDinhKem');

    //Route::get('Sua','system\DSTaiKhoanController@edit');
});

Route::group(['prefix' => 'HoSoThiDua'], function () {
    Route::get('ThongTin', [dshosothiduaController::class, 'ThongTin']);
    Route::get('Them', [dshosothiduaController::class, 'ThemHoSo']);
    Route::post('Them', 'NghiepVu\ThiDuaKhenThuong\dshosothiduaController@LuuHoSo');
    Route::get('Sua', 'NghiepVu\ThiDuaKhenThuong\dshosothiduaController@ThayDoi');
    Route::post('Sua', 'NghiepVu\ThiDuaKhenThuong\dshosothiduaController@LuuHoSo');
    Route::get('Xem', [dshosothiduaController::class, 'XemHoSo']);
    Route::post('Xoa', 'NghiepVu\ThiDuaKhenThuong\dshosothiduaController@XoaHoSo');

    Route::get('LayTieuChuan', [dshosothiduaController::class, 'LayTieuChuan']);
    Route::get('LuuTieuChuan', 'NghiepVu\ThiDuaKhenThuong\dshosothiduaController@LuuTieuChuan');
    Route::post('ChuyenHoSo', 'NghiepVu\ThiDuaKhenThuong\dshosothiduaController@ChuyenHoSo');
    Route::post('delete', 'NghiepVu\ThiDuaKhenThuong\dshosothiduaController@delete');
    Route::get('LayLyDo', 'NghiepVu\ThiDuaKhenThuong\dshosothiduaController@LayLyDo');
    Route::get('XoaDoiTuong', 'NghiepVu\ThiDuaKhenThuong\dshosothiduaController@XoaDoiTuong');

    Route::post('ThemTapThe', [dshosothiduaController::class, 'ThemTapThe']);
    Route::get('XoaTapThe', [dshosothiduaController::class, 'XoaTapThe']);
    Route::get('LayTapThe', [dshosothiduaController::class, 'LayTapThe']);
    Route::post('NhanExcelTapThe', [dshosothiduaController::class, 'NhanExcelTapThe']);

    Route::post('ThemCaNhan', [dshosothiduaController::class, 'ThemCaNhan']);
    Route::get('XoaCaNhan', [dshosothiduaController::class, 'XoaCaNhan']);
    Route::get('LayCaNhan', [dshosothiduaController::class, 'LayCaNhan']);
    Route::post('NhanExcelCaNhan', [dshosothiduaController::class, 'NhanExcelCaNhan']);

    Route::get('TaiLieuDinhKem', [dshosothiduaController::class, 'TaiLieuDinhKem']);
});

Route::group(['prefix' => 'XetDuyetHoSoThiDua'], function () {
    Route::get('ThongTin', 'NghiepVu\ThiDuaKhenThuong\dshosodenghikhenthuongthiduaController@ThongTin');
    Route::get('DanhSach', 'NghiepVu\ThiDuaKhenThuong\dshosodenghikhenthuongthiduaController@DanhSach');
    Route::post('TraLai', 'NghiepVu\ThiDuaKhenThuong\dshosodenghikhenthuongthiduaController@TraLai');
    Route::get('Xem', 'NghiepVu\ThiDuaKhenThuong\dshosodenghikhenthuongthiduaController@XemDanhSach');
    Route::post('ChuyenHoSo', 'NghiepVu\ThiDuaKhenThuong\dshosodenghikhenthuongthiduaController@ChuyenHoSo');
    Route::post('NhanHoSo', 'NghiepVu\ThiDuaKhenThuong\dshosodenghikhenthuongthiduaController@NhanHoSo');

    Route::post('ThemKT', [dshosodenghikhenthuongthiduaController::class, 'ThemKT']);
    Route::get('XetKT', [dshosodenghikhenthuongthiduaController::class, 'XetKT']);
    Route::post('XetKT', [dshosodenghikhenthuongthiduaController::class, 'LuuKT']);
    Route::post('XoaHoSoKT', [dshosodenghikhenthuongthiduaController::class, 'XoaHoSoKT']);
    Route::get('Xem', [dshosodenghikhenthuongthiduaController::class, 'XemHoSoKT']);
    Route::get('TaiLieuDinhKem', [dshosodenghikhenthuongthiduaController::class, 'TaiLieuDinhKem']);

    Route::get('LayTapThe', [dshosodenghikhenthuongthiduaController::class, 'LayTapThe']);
    Route::post('ThemTapThe', [dshosodenghikhenthuongthiduaController::class, 'ThemTapThe']);
    Route::get('XoaTapThe', [dshosodenghikhenthuongthiduaController::class, 'XoaTapThe']);
    Route::post('NhanExcelTapThe', [dshosodenghikhenthuongthiduaController::class, 'NhanExcelTapThe']);
    Route::get('LayCaNhan', [dshosodenghikhenthuongthiduaController::class, 'LayCaNhan']);
    Route::post('ThemCaNhan', [dshosodenghikhenthuongthiduaController::class, 'ThemCaNhan']);
    Route::get('XoaCaNhan', [dshosodenghikhenthuongthiduaController::class, 'XoaCaNhan']);
    Route::post('NhanExcelCaNhan', [dshosodenghikhenthuongthiduaController::class, 'NhanExcelCaNhan']);

    Route::get('QuyetDinh', [dshosodenghikhenthuongthiduaController::class, 'QuyetDinh']);
    Route::get('TaoDuThao', [dshosodenghikhenthuongthiduaController::class, 'DuThaoQuyetDinh']);
    Route::post('QuyetDinh', [dshosodenghikhenthuongthiduaController::class, 'LuuQuyetDinh']);
    Route::post('PheDuyet', [dshosodenghikhenthuongthiduaController::class, 'PheDuyet']);
    Route::get('LayLyDo', [dshosodenghikhenthuongthiduaController::class, 'LayLyDo']);

    Route::post('GanKhenThuong', [dshosodenghikhenthuongthiduaController::class, 'GanKhenThuong']);
});

Route::group(['prefix' => 'KhenThuongHoSoThiDua'], function () {
    Route::get('ThongTin', 'NghiepVu\ThiDuaKhenThuong\qdhosodenghikhenthuongthiduaController@ThongTin');
    Route::post('KhenThuong', 'NghiepVu\ThiDuaKhenThuong\qdhosodenghikhenthuongthiduaController@KhenThuong');
    Route::get('DanhSach', 'NghiepVu\ThiDuaKhenThuong\qdhosodenghikhenthuongthiduaController@DanhSach');
    Route::post('Sua', 'NghiepVu\ThiDuaKhenThuong\qdhosodenghikhenthuongthiduaController@LuuHoSo');
    Route::get('Xem', 'NghiepVu\ThiDuaKhenThuong\qdhosodenghikhenthuongthiduaController@XemHoSo');
    Route::post('TraLai', [qdhosodenghikhenthuongthiduaController::class, 'TraLai']);

    Route::post('HoSo', 'NghiepVu\ThiDuaKhenThuong\qdhosodenghikhenthuongthiduaController@HoSo');
    Route::post('KetQua', 'NghiepVu\ThiDuaKhenThuong\qdhosodenghikhenthuongthiduaController@KetQua');


    Route::get('InKetQua', 'NghiepVu\ThiDuaKhenThuong\qdhosodenghikhenthuongthiduaController@InKetQua');
    Route::get('MacDinhQuyetDinh', 'NghiepVu\ThiDuaKhenThuong\qdhosodenghikhenthuongthiduaController@MacDinhQuyetDinh');
    Route::get('QuyetDinh', 'NghiepVu\ThiDuaKhenThuong\qdhosodenghikhenthuongthiduaController@QuyetDinh');
    Route::post('QuyetDinh', 'NghiepVu\ThiDuaKhenThuong\qdhosodenghikhenthuongthiduaController@LuuQuyetDinh');
    Route::get('XemQuyetDinh', 'NghiepVu\ThiDuaKhenThuong\qdhosodenghikhenthuongthiduaController@XemQuyetDinh');
    Route::get('LayTieuChuan', 'NghiepVu\ThiDuaKhenThuong\qdhosodenghikhenthuongthiduaController@LayTieuChuan');
    Route::post('KetThuc', 'NghiepVu\ThiDuaKhenThuong\qdhosodenghikhenthuongthiduaController@KetThuc');

    Route::get('LayTapThe', [qdhosodenghikhenthuongthiduaController::class, 'LayTapThe']);
    Route::post('ThemTapThe', [qdhosodenghikhenthuongthiduaController::class, 'ThemTapThe']);
    Route::get('XoaTapThe', [qdhosodenghikhenthuongthiduaController::class, 'XoaTapThe']);
    Route::post('NhanExcelTapThe', [qdhosodenghikhenthuongthiduaController::class, 'NhanExcelTapThe']);
    Route::get('LayCaNhan', [qdhosodenghikhenthuongthiduaController::class, 'LayCaNhan']);
    Route::post('ThemCaNhan', [qdhosodenghikhenthuongthiduaController::class, 'ThemCaNhan']);
    Route::get('XoaCaNhan', [qdhosodenghikhenthuongthiduaController::class, 'XoaCaNhan']);
    Route::post('NhanExcelCaNhan', [qdhosodenghikhenthuongthiduaController::class, 'NhanExcelCaNhan']);

    //In dữ liệu
    Route::post('LayDoiTuong', 'NghiepVu\ThiDuaKhenThuong\qdhosodenghikhenthuongthiduaController@LayDoiTuong');
    Route::post('InBangKhen', 'NghiepVu\ThiDuaKhenThuong\qdhosodenghikhenthuongthiduaController@InBangKhen');
    Route::post('InGiayKhen', 'NghiepVu\ThiDuaKhenThuong\qdhosodenghikhenthuongthiduaController@InGiayKhen');

    Route::get('InPhoi', [qdhosodenghikhenthuongthiduaController::class, 'InPhoi']);
    Route::post('NoiDungKhenThuong', [qdhosodenghikhenthuongthiduaController::class, 'NoiDungKhenThuong']);
    Route::get('InBangKhenCaNhan', [qdhosodenghikhenthuongthiduaController::class, 'InBangKhenCaNhan']);
    Route::get('InBangKhenTapThe', [qdhosodenghikhenthuongthiduaController::class, 'InBangKhenTapThe']);
    Route::get('InGiayKhenCaNhan', [qdhosodenghikhenthuongthiduaController::class, 'InGiayKhenCaNhan']);
    Route::get('InGiayKhenTapThe', [qdhosodenghikhenthuongthiduaController::class, 'InGiayKhenTapThe']);
    //
    Route::get('PheDuyet', [qdhosodenghikhenthuongthiduaController::class, 'PheDuyet']);
    Route::post('PheDuyet', [qdhosodenghikhenthuongthiduaController::class, 'LuuPheDuyet']);

    //Route::post('PheDuyet', 'NghiepVu\ThiDuaKhenThuong\qdhosodenghikhenthuongthiduaController@PheDuyet');
    Route::post('HuyPheDuyet', 'NghiepVu\ThiDuaKhenThuong\qdhosodenghikhenthuongthiduaController@HuyPheDuyet');
});

Route::group(['prefix' => 'HoSoThiDuaKT'], function () {
    Route::get('ThongTin', [dshosokhenthuongthiduaController::class, 'ThongTin']);
    Route::post('ThemKT', [dshosokhenthuongthiduaController::class, 'Them']);
    Route::get('Sua', [dshosokhenthuongthiduaController::class, 'ThayDoi']);
    Route::post('Sua', [dshosokhenthuongthiduaController::class, 'LuuHoSo']);
    Route::get('InHoSo', [dshosokhenthuongthiduaController::class, 'XemHoSo']);
    Route::post('Xoa', [dshosokhenthuongthiduaController::class, 'XoaHoSo']);

    Route::post('ThemTapThe', [dshosokhenthuongthiduaController::class, 'ThemTapThe']);
    Route::get('XoaTapThe', [dshosokhenthuongthiduaController::class, 'XoaTapThe']);
    Route::get('LayTapThe', [dshosokhenthuongthiduaController::class, 'LayTapThe']);
    Route::post('NhanExcelTapThe', [dshosokhenthuongthiduaController::class, 'NhanExcelTapThe']);

    Route::post('ThemCaNhan', [dshosokhenthuongthiduaController::class, 'ThemCaNhan']);
    Route::get('XoaCaNhan', [dshosokhenthuongthiduaController::class, 'XoaCaNhan']);
    Route::get('LayCaNhan', [dshosokhenthuongthiduaController::class, 'LayCaNhan']);
    Route::post('NhanExcelCaNhan', [dshosokhenthuongthiduaController::class, 'NhanExcelCaNhan']);

    Route::post('ThemDeTai', [dshosokhenthuongthiduaController::class, 'ThemDeTai']);
    Route::get('XoaDeTai', [dshosokhenthuongthiduaController::class, 'XoaDeTai']);
    Route::get('LayDeTai', [dshosokhenthuongthiduaController::class, 'LayDeTai']);
    Route::post('NhanExcelDeTai', [dshosokhenthuongthiduaController::class, 'NhanExcelDeTai']);

    Route::get('TaiLieuDinhKem', [dshosokhenthuongthiduaController::class, 'TaiLieuDinhKem']);

    //29.10.2022
    Route::get('QuyetDinh', [dshosokhenthuongthiduaController::class, 'QuyetDinh']);
    Route::get('TaoDuThao', [dshosokhenthuongthiduaController::class, 'DuThaoQuyetDinh']);
    Route::post('QuyetDinh', [dshosokhenthuongthiduaController::class, 'LuuQuyetDinh']);
    Route::get('PheDuyet', [dshosokhenthuongthiduaController::class, 'PheDuyet']);
    Route::post('PheDuyet', [dshosokhenthuongthiduaController::class, 'LuuPheDuyet']);
    Route::post('HuyPheDuyet', [dshosokhenthuongthiduaController::class, 'HuyPheDuyet']);
    Route::get('InQuyetDinh', [dshosokhenthuongthiduaController::class, 'InQuyetDinh']);
    Route::get('InPhoi', [dshosokhenthuongthiduaController::class, 'InPhoi']);

    Route::post('NoiDungKhenThuong', [dshosokhenthuongthiduaController::class, 'NoiDungKhenThuong']);
    Route::get('InBangKhenCaNhan', [dshosokhenthuongthiduaController::class, 'InBangKhenCaNhan']);
    Route::get('InBangKhenTapThe', [dshosokhenthuongthiduaController::class, 'InBangKhenTapThe']);
    Route::get('InGiayKhenCaNhan', [dshosokhenthuongthiduaController::class, 'InGiayKhenCaNhan']);
    Route::get('InGiayKhenTapThe', [dshosokhenthuongthiduaController::class, 'InGiayKhenTapThe']);

    //09.11.2022
    Route::get('ToTrinhHoSo', [dshosokhenthuongthiduaController::class, 'ToTrinhHoSo']);
    Route::post('ToTrinhHoSo', [dshosokhenthuongthiduaController::class, 'LuuToTrinhHoSo']);
    Route::get('InToTrinhHoSo', [dshosokhenthuongthiduaController::class, 'InToTrinhHoSo']);

    Route::get('ToTrinhPheDuyet', [dshosokhenthuongthiduaController::class, 'ToTrinhPheDuyet']);
    Route::post('ToTrinhPheDuyet', [dshosokhenthuongthiduaController::class, 'LuuToTrinhPheDuyet']);
    Route::get('InToTrinhPheDuyet', [dshosokhenthuongthiduaController::class, 'InToTrinhPheDuyet']);
});

use App\Http\Controllers\NghiepVu\KhenThuongCongTrang\dshosodenghikhenthuongcongtrangController;
use App\Http\Controllers\NghiepVu\KhenThuongCongTrang\dshosokhenthuongcongtrangController;
use App\Http\Controllers\NghiepVu\KhenThuongCongTrang\qdhosodenghikhenthuongcongtrangController;
use App\Http\Controllers\NghiepVu\KhenThuongCongTrang\xdhosodenghikhenthuongcongtrangController;


//Khen thưởng theo công trạng
Route::group(['prefix' => 'KhenThuongCongTrang'], function () {
    Route::group(['prefix' => 'HoSoKT'], function () {
        Route::get('ThongTin', [dshosokhenthuongcongtrangController::class, 'ThongTin']);
        Route::post('Them', 'NghiepVu\KhenThuongCongTrang\dshosokhenthuongcongtrangController@Them');
        Route::get('Sua', 'NghiepVu\KhenThuongCongTrang\dshosokhenthuongcongtrangController@ThayDoi');
        Route::post('Sua', 'NghiepVu\KhenThuongCongTrang\dshosokhenthuongcongtrangController@LuuHoSo');
        Route::get('InHoSo', [dshosokhenthuongcongtrangController::class, 'XemHoSo']);
        Route::get('InHoSoKT', [dshosokhenthuongcongtrangController::class, 'InHoSoKT']);
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
        //09.11.2022
        Route::get('ToTrinhHoSo', [dshosokhenthuongcongtrangController::class, 'ToTrinhHoSo']);
        Route::post('ToTrinhHoSo', [dshosokhenthuongcongtrangController::class, 'LuuToTrinhHoSo']);
        Route::get('InToTrinhHoSo', [dshosokhenthuongcongtrangController::class, 'InToTrinhHoSo']);

        Route::get('ToTrinhPheDuyet', [dshosokhenthuongcongtrangController::class, 'ToTrinhPheDuyet']);
        Route::post('ToTrinhPheDuyet', [dshosokhenthuongcongtrangController::class, 'LuuToTrinhPheDuyet']);
        Route::get('InToTrinhPheDuyet', [dshosokhenthuongcongtrangController::class, 'InToTrinhPheDuyet']);
    });

    Route::group(['prefix' => 'HoSo'], function () {
        Route::get('ThongTin', 'NghiepVu\KhenThuongCongTrang\dshosodenghikhenthuongcongtrangController@ThongTin');
        Route::post('Them', 'NghiepVu\KhenThuongCongTrang\dshosodenghikhenthuongcongtrangController@Them');
        Route::get('Sua', 'NghiepVu\KhenThuongCongTrang\dshosodenghikhenthuongcongtrangController@ThayDoi');
        Route::post('Sua', 'NghiepVu\KhenThuongCongTrang\dshosodenghikhenthuongcongtrangController@LuuHoSo');
        Route::get('InHoSo', [dshosodenghikhenthuongcongtrangController::class, 'XemHoSo']);
        Route::post('Xoa', [dshosodenghikhenthuongcongtrangController::class, 'XoaHoSo']);

        Route::post('ThemTapThe', [dshosodenghikhenthuongcongtrangController::class, 'ThemTapThe']);
        Route::get('XoaTapThe', [dshosodenghikhenthuongcongtrangController::class, 'XoaTapThe']);
        Route::get('LayTapThe', [dshosodenghikhenthuongcongtrangController::class, 'LayTapThe']);
        Route::post('NhanExcelTapThe', [dshosodenghikhenthuongcongtrangController::class, 'NhanExcelTapThe']);

        Route::post('ThemCaNhan', [dshosodenghikhenthuongcongtrangController::class, 'ThemCaNhan']);
        Route::get('XoaCaNhan', [dshosodenghikhenthuongcongtrangController::class, 'XoaCaNhan']);
        Route::get('LayCaNhan', [dshosodenghikhenthuongcongtrangController::class, 'LayCaNhan']);
        Route::post('NhanExcelCaNhan', [dshosodenghikhenthuongcongtrangController::class, 'NhanExcelCaNhan']);

        Route::post('ThemDeTai', [dshosodenghikhenthuongcongtrangController::class, 'ThemDeTai']);
        Route::get('XoaDeTai', [dshosodenghikhenthuongcongtrangController::class, 'XoaDeTai']);
        Route::get('LayDeTai', [dshosodenghikhenthuongcongtrangController::class, 'LayDeTai']);
        Route::post('NhanExcelDeTai', [dshosodenghikhenthuongcongtrangController::class, 'NhanExcelDeTai']);

        Route::get('TaiLieuDinhKem', [dshosodenghikhenthuongcongtrangController::class, 'TaiLieuDinhKem']);
        Route::post('ChuyenHoSo', 'NghiepVu\KhenThuongCongTrang\dshosodenghikhenthuongcongtrangController@ChuyenHoSo');
        Route::get('LayLyDo', 'NghiepVu\KhenThuongCongTrang\dshosodenghikhenthuongcongtrangController@LayLyDo');
        Route::get('LayTieuChuan', 'NghiepVu\KhenThuongCongTrang\dshosodenghikhenthuongcongtrangController@LayTieuChuan');
        Route::get('LayDoiTuong', 'NghiepVu\KhenThuongCongTrang\dshosodenghikhenthuongcongtrangController@LayDoiTuong');
        //29.10.2022
        Route::get('InHoSoPD', [qdhosodenghikhenthuongcongtrangController::class, 'XemHoSo']);
        Route::get('QuyetDinh', [dshosodenghikhenthuongcongtrangController::class, 'QuyetDinh']);
        Route::get('TaoDuThao', [dshosodenghikhenthuongcongtrangController::class, 'DuThaoQuyetDinh']);
        Route::post('QuyetDinh', [dshosodenghikhenthuongcongtrangController::class, 'LuuQuyetDinh']);
        Route::get('PheDuyet', [dshosodenghikhenthuongcongtrangController::class, 'PheDuyet']);
        Route::post('PheDuyet', [dshosodenghikhenthuongcongtrangController::class, 'LuuPheDuyet']);
        Route::post('HuyPheDuyet', [dshosodenghikhenthuongcongtrangController::class, 'HuyPheDuyet']);

        Route::get('InQuyetDinh', [qdhosodenghikhenthuongcongtrangController::class, 'InQuyetDinh']);
        Route::get('InPhoi', [qdhosodenghikhenthuongcongtrangController::class, 'InPhoi']);

        Route::post('NoiDungKhenThuong', [qdhosodenghikhenthuongcongtrangController::class, 'NoiDungKhenThuong']);
        Route::get('InBangKhenCaNhan', [qdhosodenghikhenthuongcongtrangController::class, 'InBangKhenCaNhan']);
        Route::get('InBangKhenTapThe', [qdhosodenghikhenthuongcongtrangController::class, 'InBangKhenTapThe']);
        Route::get('InGiayKhenCaNhan', [qdhosodenghikhenthuongcongtrangController::class, 'InGiayKhenCaNhan']);
        Route::get('InGiayKhenTapThe', [qdhosodenghikhenthuongcongtrangController::class, 'InGiayKhenTapThe']);
    });

    Route::group(['prefix' => 'XetDuyet'], function () {
        Route::get('ThongTin', [xdhosodenghikhenthuongcongtrangController::class, 'ThongTin']);
        Route::post('TraLai', 'NghiepVu\KhenThuongCongTrang\xdhosodenghikhenthuongcongtrangController@TraLai');
        Route::post('NhanHoSo', 'NghiepVu\KhenThuongCongTrang\xdhosodenghikhenthuongcongtrangController@NhanHoSo');
        Route::post('ChuyenHoSo', 'NghiepVu\KhenThuongCongTrang\xdhosodenghikhenthuongcongtrangController@ChuyenHoSo');

        Route::get('XetKT', [xdhosodenghikhenthuongcongtrangController::class, 'XetKT']);
        Route::post('ThemTapThe', [xdhosodenghikhenthuongcongtrangController::class, 'ThemTapThe']);
        Route::post('ThemCaNhan', [xdhosodenghikhenthuongcongtrangController::class, 'ThemCaNhan']);
        Route::post('GanKhenThuong', [xdhosodenghikhenthuongcongtrangController::class, 'GanKhenThuong']);
        Route::get('QuyetDinh', [xdhosodenghikhenthuongcongtrangController::class, 'QuyetDinh']);
        Route::get('TaoDuThao', [xdhosodenghikhenthuongcongtrangController::class, 'DuThaoQuyetDinh']);
        Route::post('QuyetDinh', [xdhosodenghikhenthuongcongtrangController::class, 'LuuQuyetDinh']);
        Route::post('PheDuyet', [xdhosodenghikhenthuongcongtrangController::class, 'PheDuyet']);
        Route::get('LayLyDo', [xdhosodenghikhenthuongcongtrangController::class, 'LayLyDo']);
    });

    Route::group(['prefix' => 'KhenThuong'], function () {
        Route::get('ThongTin', [qdhosodenghikhenthuongcongtrangController::class, 'ThongTin']);
        Route::post('Them', [qdhosodenghikhenthuongcongtrangController::class, 'Them']);
        Route::get('Sua', [qdhosodenghikhenthuongcongtrangController::class, 'Sua']);
        Route::post('Sua', [qdhosodenghikhenthuongcongtrangController::class, 'LuuHoSo']);
        Route::post('Xoa', [qdhosodenghikhenthuongcongtrangController::class, 'XoaHoSo']);

        Route::post('ThemTapThe', [qdhosodenghikhenthuongcongtrangController::class, 'ThemTapThe']);
        Route::get('XoaTapThe', [qdhosodenghikhenthuongcongtrangController::class, 'XoaTapThe']);
        Route::post('NhanExcelTapThe', [qdhosodenghikhenthuongcongtrangController::class, 'NhanExcelTapThe']);
        Route::post('ThemCaNhan', [qdhosodenghikhenthuongcongtrangController::class, 'ThemCaNhan']);
        Route::get('XoaCaNhan', [qdhosodenghikhenthuongcongtrangController::class, 'XoaCaNhan']);
        Route::post('NhanExcelCaNhan', [qdhosodenghikhenthuongcongtrangController::class, 'NhanExcelCaNhan']);
        Route::post('NhanExcelDeTai', [qdhosodenghikhenthuongcongtrangController::class, 'NhanExcelDeTai']);

        Route::get('PheDuyet', [qdhosodenghikhenthuongcongtrangController::class, 'PheDuyet']);
        Route::post('PheDuyet', [qdhosodenghikhenthuongcongtrangController::class, 'LuuPheDuyet']);

        Route::get('XetKT', [qdhosodenghikhenthuongcongtrangController::class, 'XetKT']);
        Route::get('QuyetDinh', [qdhosodenghikhenthuongcongtrangController::class, 'QuyetDinh']);
        Route::get('TaoDuThao', [qdhosodenghikhenthuongcongtrangController::class, 'DuThaoQuyetDinh']);
        Route::post('QuyetDinh', [qdhosodenghikhenthuongcongtrangController::class, 'LuuQuyetDinh']);
        //Route::post('PheDuyet', [qdhosodenghikhenthuongcongtrangController::class, 'PheDuyet']);
        Route::post('GanKhenThuong', [qdhosodenghikhenthuongcongtrangController::class, 'GanKhenThuong']);
        Route::post('HuyPheDuyet', [qdhosodenghikhenthuongcongtrangController::class, 'HuyPheDuyet']);
        Route::post('TraLai', [qdhosodenghikhenthuongcongtrangController::class, 'TraLai']);

        //In dữ liệu
        Route::post('LayDoiTuong', [qdhosodenghikhenthuongcongtrangController::class, 'LayDoiTuong']);
        Route::get('InQuyetDinh', [qdhosodenghikhenthuongcongtrangController::class, 'InQuyetDinh']);
        Route::post('InBangKhen', [qdhosodenghikhenthuongcongtrangController::class, 'InBangKhen']);
        Route::post('InGiayKhen', [qdhosodenghikhenthuongcongtrangController::class, 'InGiayKhen']);
        Route::get('InHoSoPD', [qdhosodenghikhenthuongcongtrangController::class, 'XemHoSo']);

        Route::get('InPhoi', [qdhosodenghikhenthuongcongtrangController::class, 'InPhoi']);
        Route::post('NoiDungKhenThuong', [qdhosodenghikhenthuongcongtrangController::class, 'NoiDungKhenThuong']);
        Route::get('InBangKhenCaNhan', [qdhosodenghikhenthuongcongtrangController::class, 'InBangKhenCaNhan']);
        Route::get('InBangKhenTapThe', [qdhosodenghikhenthuongcongtrangController::class, 'InBangKhenTapThe']);
        Route::get('InGiayKhenCaNhan', [qdhosodenghikhenthuongcongtrangController::class, 'InGiayKhenCaNhan']);
        Route::get('InGiayKhenTapThe', [qdhosodenghikhenthuongcongtrangController::class, 'InGiayKhenTapThe']);
    });
});

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
        Route::post('NhanExcelTapThe', [dshosokhenthuongdotxuatController::class, 'NhanExcelTapThe']);

        Route::post('ThemCaNhan', [dshosokhenthuongdotxuatController::class, 'ThemCaNhan']);
        Route::get('XoaCaNhan', [dshosokhenthuongdotxuatController::class, 'XoaCaNhan']);
        Route::get('LayCaNhan', [dshosokhenthuongdotxuatController::class, 'LayCaNhan']);
        Route::post('NhanExcelCaNhan', [dshosokhenthuongdotxuatController::class, 'NhanExcelCaNhan']);

        Route::post('ThemDeTai', [dshosokhenthuongdotxuatController::class, 'ThemDeTai']);
        Route::get('XoaDeTai', [dshosokhenthuongdotxuatController::class, 'XoaDeTai']);
        Route::get('LayDeTai', [dshosokhenthuongdotxuatController::class, 'LayDeTai']);
        Route::post('NhanExcelDeTai', [dshosokhenthuongdotxuatController::class, 'NhanExcelDeTai']);

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
        Route::post('NhanExcelTapThe', [dshosodenghikhenthuongdotxuatController::class, 'NhanExcelTapThe']);

        Route::post('ThemCaNhan', [dshosodenghikhenthuongdotxuatController::class, 'ThemCaNhan']);
        Route::get('XoaCaNhan', [dshosodenghikhenthuongdotxuatController::class, 'XoaCaNhan']);
        Route::get('LayCaNhan', [dshosodenghikhenthuongdotxuatController::class, 'LayCaNhan']);
        Route::post('NhanExcelCaNhan', [dshosodenghikhenthuongdotxuatController::class, 'NhanExcelCaNhan']);
        Route::get('TaiLieuDinhKem', [dshosodenghikhenthuongdotxuatController::class, 'TaiLieuDinhKem']);
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
    });

    Route::group(['prefix' => 'KhenThuong'], function () {
        Route::get('ThongTin', 'NghiepVu\KhenThuongDotXuat\qdhosodenghikhenthuongdotxuatController@ThongTin');
        Route::post('KhenThuong', 'NghiepVu\KhenThuongDotXuat\qdhosodenghikhenthuongdotxuatController@KhenThuong');
        Route::get('DanhSach', 'NghiepVu\KhenThuongDotXuat\qdhosodenghikhenthuongdotxuatController@DanhSach');
        Route::post('DanhSach', 'NghiepVu\KhenThuongDotXuat\qdhosodenghikhenthuongdotxuatController@LuuHoSo');
        //Route::post('PheDuyet', 'NghiepVu\KhenThuongDotXuat\qdhosodenghikhenthuongdotxuatController@PheDuyet');

        Route::get('PheDuyet', [qdhosodenghikhenthuongdotxuatController::class, 'PheDuyet']);
        Route::post('PheDuyet', [qdhosodenghikhenthuongdotxuatController::class, 'LuuPheDuyet']);

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
    });
});
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

//Khen thưởng công hiến
use App\Http\Controllers\NghiepVu\KhenThuongCongHien\dshosodenghikhenthuongconghienController;
use App\Http\Controllers\NghiepVu\KhenThuongCongHien\dshosokhenthuongconghienController;
use App\Http\Controllers\NghiepVu\KhenThuongCongHien\qdhosodenghikhenthuongconghienController;
use App\Http\Controllers\NghiepVu\KhenThuongCongHien\xdhosodenghikhenthuongconghienController;

Route::group(['prefix' => 'KhenThuongCongHien'], function () {
    Route::group(['prefix' => 'HoSoKT'], function () {
        Route::get('ThongTin', [dshosokhenthuongconghienController::class, 'ThongTin']);
        Route::post('Them', [dshosokhenthuongconghienController::class, 'Them']);
        Route::get('Sua', [dshosokhenthuongconghienController::class, 'ThayDoi']);
        Route::post('Sua', [dshosokhenthuongconghienController::class, 'LuuHoSo']);
        Route::get('InHoSo', [dshosokhenthuongconghienController::class, 'XemHoSo']);
        Route::get('InHoSoPD', [dshosokhenthuongconghienController::class, 'InHoSoPD']);
        Route::post('Xoa', [dshosokhenthuongconghienController::class, 'XoaHoSo']);

        Route::post('ThemTapThe', [dshosokhenthuongconghienController::class, 'ThemTapThe']);
        Route::get('XoaTapThe', [dshosokhenthuongconghienController::class, 'XoaTapThe']);
        Route::get('LayTapThe', [dshosokhenthuongconghienController::class, 'LayTapThe']);
        Route::post('NhanExcelTapThe', [dshosokhenthuongconghienController::class, 'NhanExcelTapThe']);

        Route::post('ThemCaNhan', [dshosokhenthuongconghienController::class, 'ThemCaNhan']);
        Route::get('XoaCaNhan', [dshosokhenthuongconghienController::class, 'XoaCaNhan']);
        Route::get('LayCaNhan', [dshosokhenthuongconghienController::class, 'LayCaNhan']);
        Route::post('NhanExcelCaNhan', [dshosokhenthuongconghienController::class, 'NhanExcelCaNhan']);

        Route::post('ThemDeTai', [dshosokhenthuongconghienController::class, 'ThemDeTai']);
        Route::get('XoaDeTai', [dshosokhenthuongconghienController::class, 'XoaDeTai']);
        Route::get('LayDeTai', [dshosokhenthuongconghienController::class, 'LayDeTai']);
        Route::post('NhanExcelDeTai', [dshosokhenthuongconghienController::class, 'NhanExcelDeTai']);

        Route::get('TaiLieuDinhKem', [dshosokhenthuongconghienController::class, 'TaiLieuDinhKem']);
        Route::post('ChuyenHoSo', [dshosokhenthuongconghienController::class, 'ChuyenHoSo']);
        Route::get('LayLyDo', [dshosokhenthuongconghienController::class, 'LayLyDo']);

        //29.10.2022
        Route::get('QuyetDinh', [dshosokhenthuongconghienController::class, 'QuyetDinh']);
        Route::get('TaoDuThao', [dshosokhenthuongconghienController::class, 'DuThaoQuyetDinh']);
        Route::post('QuyetDinh', [dshosokhenthuongconghienController::class, 'LuuQuyetDinh']);
        Route::get('PheDuyet', [dshosokhenthuongconghienController::class, 'PheDuyet']);
        Route::post('PheDuyet', [dshosokhenthuongconghienController::class, 'LuuPheDuyet']);
        Route::post('HuyPheDuyet', [dshosokhenthuongconghienController::class, 'HuyPheDuyet']);
        Route::get('InQuyetDinh', [dshosokhenthuongconghienController::class, 'InQuyetDinh']);
        Route::get('InPhoi', [dshosokhenthuongconghienController::class, 'InPhoi']);

        Route::post('NoiDungKhenThuong', [dshosokhenthuongconghienController::class, 'NoiDungKhenThuong']);
        Route::get('InBangKhenCaNhan', [dshosokhenthuongconghienController::class, 'InBangKhenCaNhan']);
        Route::get('InBangKhenTapThe', [dshosokhenthuongconghienController::class, 'InBangKhenTapThe']);
        Route::get('InGiayKhenCaNhan', [dshosokhenthuongconghienController::class, 'InGiayKhenCaNhan']);
        Route::get('InGiayKhenTapThe', [dshosokhenthuongconghienController::class, 'InGiayKhenTapThe']);

        //09.11.2022
        Route::get('ToTrinhHoSo', [dshosokhenthuongconghienController::class, 'ToTrinhHoSo']);
        Route::post('ToTrinhHoSo', [dshosokhenthuongconghienController::class, 'LuuToTrinhHoSo']);
        Route::get('InToTrinhHoSo', [dshosokhenthuongconghienController::class, 'InToTrinhHoSo']);

        Route::get('ToTrinhPheDuyet', [dshosokhenthuongconghienController::class, 'ToTrinhPheDuyet']);
        Route::post('ToTrinhPheDuyet', [dshosokhenthuongconghienController::class, 'LuuToTrinhPheDuyet']);
        Route::get('InToTrinhPheDuyet', [dshosokhenthuongconghienController::class, 'InToTrinhPheDuyet']);
    });

    Route::group(['prefix' => 'HoSo'], function () {
        Route::get('ThongTin', [dshosodenghikhenthuongconghienController::class, 'ThongTin']);
        Route::post('Them', [dshosodenghikhenthuongconghienController::class, 'Them']);
        Route::get('Sua', [dshosodenghikhenthuongconghienController::class, 'ThayDoi']);
        Route::post('Sua', [dshosodenghikhenthuongconghienController::class, 'LuuHoSo']);
        Route::get('InHoSo', [dshosodenghikhenthuongconghienController::class, 'InHoSo']);
        Route::get('InHoSoPD', [qdhosodenghikhenthuongconghienController::class, 'XemHoSo']);
        Route::post('Xoa', [dshosodenghikhenthuongconghienController::class, 'XoaHoSo']);

        Route::post('ChuyenHoSo', [dshosodenghikhenthuongconghienController::class, 'ChuyenHoSo']);
        Route::get('LayLyDo', [dshosodenghikhenthuongconghienController::class, 'LayLyDo']);

        Route::post('ThemTapThe', [dshosodenghikhenthuongconghienController::class, 'ThemTapThe']);
        Route::get('XoaTapThe', [dshosodenghikhenthuongconghienController::class, 'XoaTapThe']);
        Route::get('LayTapThe', [dshosodenghikhenthuongconghienController::class, 'LayTapThe']);
        Route::post('NhanExcelTapThe', [dshosodenghikhenthuongconghienController::class, 'NhanExcelTapThe']);

        Route::post('ThemCaNhan', [dshosodenghikhenthuongconghienController::class, 'ThemCaNhan']);
        Route::get('XoaCaNhan', [dshosodenghikhenthuongconghienController::class, 'XoaCaNhan']);
        Route::get('LayCaNhan', [dshosodenghikhenthuongconghienController::class, 'LayCaNhan']);
        Route::post('NhanExcelCaNhan', [dshosodenghikhenthuongconghienController::class, 'NhanExcelCaNhan']);

        Route::get('TaiLieuDinhKem', [dshosodenghikhenthuongconghienController::class, 'TaiLieuDinhKem']);

        //29.10.2022
        Route::get('QuyetDinh', [dshosodenghikhenthuongconghienController::class, 'QuyetDinh']);
        Route::get('TaoDuThao', [dshosodenghikhenthuongconghienController::class, 'DuThaoQuyetDinh']);
        Route::post('QuyetDinh', [dshosodenghikhenthuongconghienController::class, 'LuuQuyetDinh']);
        Route::get('PheDuyet', [dshosodenghikhenthuongconghienController::class, 'PheDuyet']);
        Route::post('PheDuyet', [dshosodenghikhenthuongconghienController::class, 'LuuPheDuyet']);
        Route::post('HuyPheDuyet', [dshosodenghikhenthuongconghienController::class, 'HuyPheDuyet']);

        Route::get('InQuyetDinh', [qdhosodenghikhenthuongconghienController::class, 'InQuyetDinh']);
        Route::get('InPhoi', [qdhosodenghikhenthuongconghienController::class, 'InPhoi']);

        Route::post('NoiDungKhenThuong', [qdhosodenghikhenthuongconghienController::class, 'NoiDungKhenThuong']);
        Route::get('InBangKhenCaNhan', [qdhosodenghikhenthuongconghienController::class, 'InBangKhenCaNhan']);
        Route::get('InBangKhenTapThe', [qdhosodenghikhenthuongconghienController::class, 'InBangKhenTapThe']);
        Route::get('InGiayKhenCaNhan', [qdhosodenghikhenthuongconghienController::class, 'InGiayKhenCaNhan']);
        Route::get('InGiayKhenTapThe', [qdhosodenghikhenthuongconghienController::class, 'InGiayKhenTapThe']);
    });

    Route::group(['prefix' => 'XetDuyet'], function () {
        Route::get('ThongTin', [xdhosodenghikhenthuongconghienController::class, 'ThongTin']);
        Route::post('TraLai', [xdhosodenghikhenthuongconghienController::class, 'TraLai']);
        Route::post('ChuyenHoSo', [xdhosodenghikhenthuongconghienController::class, 'ChuyenHoSo']);
        Route::post('NhanHoSo', [xdhosodenghikhenthuongconghienController::class, 'NhanHoSo']);

        Route::get('XetKT', [xdhosodenghikhenthuongconghienController::class, 'XetKT']);

        Route::post('ThemTapThe', [qdhosodenghikhenthuongconghienController::class, 'ThemTapThe']);
        Route::post('ThemCaNhan', [qdhosodenghikhenthuongconghienController::class, 'ThemCaNhan']);

        Route::post('GanKhenThuong', [xdhosodenghikhenthuongconghienController::class, 'GanKhenThuong']);
        Route::get('QuyetDinh', [xdhosodenghikhenthuongconghienController::class, 'QuyetDinh']);
        Route::get('TaoDuThao', [xdhosodenghikhenthuongconghienController::class, 'DuThaoQuyetDinh']);
        Route::post('QuyetDinh', [xdhosodenghikhenthuongconghienController::class, 'LuuQuyetDinh']);
        Route::post('PheDuyet', [xdhosodenghikhenthuongconghienController::class, 'PheDuyet']);
        Route::get('LayLyDo', [xdhosodenghikhenthuongconghienController::class, 'LayLyDo']);
    });

    Route::group(['prefix' => 'KhenThuong'], function () {
        Route::get('ThongTin', [qdhosodenghikhenthuongconghienController::class, 'ThongTin']);

        Route::post('Them', [qdhosodenghikhenthuongconghienController::class, 'Them']);
        Route::get('Sua', [qdhosodenghikhenthuongconghienController::class, 'Sua']);
        Route::post('Sua', [qdhosodenghikhenthuongconghienController::class, 'LuuHoSo']);
        Route::post('ThemTapThe', [qdhosodenghikhenthuongconghienController::class, 'ThemTapThe']);
        Route::get('XoaTapThe', [qdhosodenghikhenthuongconghienController::class, 'XoaTapThe']);
        Route::post('NhanExcelTapThe', [qdhosodenghikhenthuongconghienController::class, 'NhanExcelTapThe']);
        Route::post('ThemCaNhan', [qdhosodenghikhenthuongconghienController::class, 'ThemCaNhan']);
        Route::get('XoaCaNhan', [qdhosodenghikhenthuongconghienController::class, 'XoaCaNhan']);
        Route::post('NhanExcelCaNhan', [qdhosodenghikhenthuongconghienController::class, 'NhanExcelCaNhan']);

        Route::get('XetKT', [qdhosodenghikhenthuongconghienController::class, 'XetKT']);

        Route::get('QuyetDinh', [qdhosodenghikhenthuongconghienController::class, 'QuyetDinh']);
        Route::get('TaoDuThao', [qdhosodenghikhenthuongconghienController::class, 'DuThaoQuyetDinh']);
        Route::post('QuyetDinh', [qdhosodenghikhenthuongconghienController::class, 'LuuQuyetDinh']);
        //Route::post('PheDuyet', [qdhosodenghikhenthuongconghienController::class, 'PheDuyet']);
        Route::get('PheDuyet', [qdhosodenghikhenthuongconghienController::class, 'PheDuyet']);
        Route::post('PheDuyet', [qdhosodenghikhenthuongconghienController::class, 'LuuPheDuyet']);
        Route::post('GanKhenThuong', [qdhosodenghikhenthuongconghienController::class, 'GanKhenThuong']);
        Route::post('HuyPheDuyet', [qdhosodenghikhenthuongconghienController::class, 'HuyPheDuyet']);
        Route::post('TraLai', [qdhosodenghikhenthuongconghienController::class, 'TraLai']);

        //In dữ liệu
        Route::post('LayDoiTuong', [qdhosodenghikhenthuongconghienController::class, 'LayDoiTuong']);
        Route::get('InQuyetDinh', [qdhosodenghikhenthuongconghienController::class, 'InQuyetDinh']);
        Route::post('InBangKhen', [qdhosodenghikhenthuongconghienController::class, 'InBangKhen']);

        Route::get('InHoSoPD', [qdhosodenghikhenthuongconghienController::class, 'XemHoSo']);
        Route::get('InPhoi', [qdhosodenghikhenthuongconghienController::class, 'InPhoi']);
        Route::post('NoiDungKhenThuong', [qdhosodenghikhenthuongconghienController::class, 'NoiDungKhenThuong']);
        Route::get('InBangKhenCaNhan', [qdhosodenghikhenthuongconghienController::class, 'InBangKhenCaNhan']);
        Route::get('InBangKhenTapThe', [qdhosodenghikhenthuongconghienController::class, 'InBangKhenTapThe']);
        Route::get('InGiayKhenCaNhan', [qdhosodenghikhenthuongconghienController::class, 'InGiayKhenCaNhan']);
        Route::get('InGiayKhenTapThe', [qdhosodenghikhenthuongconghienController::class, 'InGiayKhenTapThe']);
    });
});

//Khen thưởng theo đối ngoại
use App\Http\Controllers\NghiepVu\KhenThuongDoiNgoai\dshosodenghikhenthuongdoingoaiController;
use App\Http\Controllers\NghiepVu\KhenThuongDoiNgoai\dshosokhenthuongdoingoaiController;
use App\Http\Controllers\NghiepVu\KhenThuongDoiNgoai\qdhosodenghikhenthuongdoingoaiController;
use App\Http\Controllers\NghiepVu\KhenThuongDoiNgoai\xdhosodenghikhenthuongdoingoaiController;

Route::group(['prefix' => 'KhenThuongDoiNgoai'], function () {
    Route::group(['prefix' => 'HoSoKT'], function () {
        Route::get('ThongTin', [dshosokhenthuongdoingoaiController::class, 'ThongTin']);
        Route::post('Them', [dshosokhenthuongdoingoaiController::class, 'Them']);
        Route::get('Sua', [dshosokhenthuongdoingoaiController::class, 'ThayDoi']);
        Route::post('Sua', [dshosokhenthuongdoingoaiController::class, 'LuuHoSo']);
        Route::get('InHoSo', [dshosokhenthuongdoingoaiController::class, 'XemHoSo']);
        Route::get('InHoSoPD', [dshosokhenthuongdoingoaiController::class, 'InHoSoPD']);
        Route::post('Xoa', [dshosokhenthuongdoingoaiController::class, 'XoaHoSo']);

        Route::post('ThemTapThe', [dshosokhenthuongdoingoaiController::class, 'ThemTapThe']);
        Route::get('XoaTapThe', [dshosokhenthuongdoingoaiController::class, 'XoaTapThe']);
        Route::get('LayTapThe', [dshosokhenthuongdoingoaiController::class, 'LayTapThe']);
        Route::post('NhanExcelTapThe', [dshosokhenthuongdoingoaiController::class, 'NhanExcelTapThe']);

        Route::post('ThemCaNhan', [dshosokhenthuongdoingoaiController::class, 'ThemCaNhan']);
        Route::get('XoaCaNhan', [dshosokhenthuongdoingoaiController::class, 'XoaCaNhan']);
        Route::get('LayCaNhan', [dshosokhenthuongdoingoaiController::class, 'LayCaNhan']);
        Route::post('NhanExcelCaNhan', [dshosokhenthuongdoingoaiController::class, 'NhanExcelCaNhan']);

        Route::post('ThemDeTai', [dshosokhenthuongdoingoaiController::class, 'ThemDeTai']);
        Route::get('XoaDeTai', [dshosokhenthuongdoingoaiController::class, 'XoaDeTai']);
        Route::get('LayDeTai', [dshosokhenthuongdoingoaiController::class, 'LayDeTai']);
        Route::post('NhanExcelDeTai', [dshosokhenthuongdoingoaiController::class, 'NhanExcelDeTai']);

        Route::get('TaiLieuDinhKem', [dshosokhenthuongdoingoaiController::class, 'TaiLieuDinhKem']);
        Route::post('ChuyenHoSo', [dshosokhenthuongdoingoaiController::class, 'ChuyenHoSo']);
        Route::get('LayLyDo', [dshosokhenthuongdoingoaiController::class, 'LayLyDo']);

        //29.10.2022
        Route::get('QuyetDinh', [dshosokhenthuongdoingoaiController::class, 'QuyetDinh']);
        Route::get('TaoDuThao', [dshosokhenthuongdoingoaiController::class, 'DuThaoQuyetDinh']);
        Route::post('QuyetDinh', [dshosokhenthuongdoingoaiController::class, 'LuuQuyetDinh']);
        Route::get('PheDuyet', [dshosokhenthuongdoingoaiController::class, 'PheDuyet']);
        Route::post('PheDuyet', [dshosokhenthuongdoingoaiController::class, 'LuuPheDuyet']);
        Route::post('HuyPheDuyet', [dshosokhenthuongdoingoaiController::class, 'HuyPheDuyet']);
        Route::get('InQuyetDinh', [dshosokhenthuongdoingoaiController::class, 'InQuyetDinh']);
        Route::get('InPhoi', [dshosokhenthuongdoingoaiController::class, 'InPhoi']);

        Route::post('NoiDungKhenThuong', [dshosokhenthuongdoingoaiController::class, 'NoiDungKhenThuong']);
        Route::get('InBangKhenCaNhan', [dshosokhenthuongdoingoaiController::class, 'InBangKhenCaNhan']);
        Route::get('InBangKhenTapThe', [dshosokhenthuongdoingoaiController::class, 'InBangKhenTapThe']);
        Route::get('InGiayKhenCaNhan', [dshosokhenthuongdoingoaiController::class, 'InGiayKhenCaNhan']);
        Route::get('InGiayKhenTapThe', [dshosokhenthuongdoingoaiController::class, 'InGiayKhenTapThe']);
        //09.11.22
        Route::get('ToTrinhHoSo', [dshosokhenthuongdoingoaiController::class, 'ToTrinhHoSo']);
        Route::post('ToTrinhHoSo', [dshosokhenthuongdoingoaiController::class, 'LuuToTrinhHoSo']);
        Route::get('InToTrinhHoSo', [dshosokhenthuongdoingoaiController::class, 'InToTrinhHoSo']);

        Route::get('ToTrinhPheDuyet', [dshosokhenthuongdoingoaiController::class, 'ToTrinhPheDuyet']);
        Route::post('ToTrinhPheDuyet', [dshosokhenthuongdoingoaiController::class, 'LuuToTrinhPheDuyet']);
        Route::get('InToTrinhPheDuyet', [dshosokhenthuongdoingoaiController::class, 'InToTrinhPheDuyet']);
    });

    Route::group(['prefix' => 'HoSo'], function () {
        Route::get('ThongTin', [dshosodenghikhenthuongdoingoaiController::class, 'ThongTin']);
        Route::post('Them', [dshosodenghikhenthuongdoingoaiController::class, 'Them']);
        Route::get('Sua', [dshosodenghikhenthuongdoingoaiController::class, 'ThayDoi']);
        Route::post('Sua', [dshosodenghikhenthuongdoingoaiController::class, 'LuuHoSo']);
        Route::get('InHoSo', [dshosodenghikhenthuongdoingoaiController::class, 'XemHoSo']);
        Route::get('InHoSoPD', [qdhosodenghikhenthuongdoingoaiController::class, 'XemHoSo']);
        Route::post('Xoa', [dshosodenghikhenthuongdoingoaiController::class, 'XoaHoSo']);

        Route::post('ThemTapThe', [dshosodenghikhenthuongdoingoaiController::class, 'ThemTapThe']);
        Route::get('XoaTapThe', [dshosodenghikhenthuongdoingoaiController::class, 'XoaTapThe']);
        Route::get('LayTapThe', [dshosodenghikhenthuongdoingoaiController::class, 'LayTapThe']);
        Route::post('NhanExcelTapThe', [dshosodenghikhenthuongdoingoaiController::class, 'NhanExcelTapThe']);

        Route::post('ThemCaNhan', [dshosodenghikhenthuongdoingoaiController::class, 'ThemCaNhan']);
        Route::get('XoaCaNhan', [dshosodenghikhenthuongdoingoaiController::class, 'XoaCaNhan']);
        Route::get('LayCaNhan', [dshosodenghikhenthuongdoingoaiController::class, 'LayCaNhan']);
        Route::post('NhanExcelCaNhan', [dshosodenghikhenthuongdoingoaiController::class, 'NhanExcelCaNhan']);

        Route::post('ThemDeTai', [dshosodenghikhenthuongdoingoaiController::class, 'ThemDeTai']);
        Route::get('XoaDeTai', [dshosodenghikhenthuongdoingoaiController::class, 'XoaDeTai']);
        Route::get('LayDeTai', [dshosodenghikhenthuongdoingoaiController::class, 'LayDeTai']);
        Route::post('NhanExcelDeTai', [dshosodenghikhenthuongdoingoaiController::class, 'NhanExcelDeTai']);

        Route::get('TaiLieuDinhKem', [dshosodenghikhenthuongdoingoaiController::class, 'TaiLieuDinhKem']);
        Route::post('ChuyenHoSo', [dshosodenghikhenthuongdoingoaiController::class, 'ChuyenHoSo']);
        Route::get('LayLyDo', [dshosodenghikhenthuongdoingoaiController::class, 'LayLyDo']);
        Route::get('LayTieuChuan', [dshosodenghikhenthuongdoingoaiController::class, 'LayTieuChuan']);
        Route::get('LayDoiTuong', [dshosodenghikhenthuongdoingoaiController::class, 'LayDoiTuong']);

        //29.10.2022
        Route::get('QuyetDinh', [dshosodenghikhenthuongdoingoaiController::class, 'QuyetDinh']);
        Route::get('TaoDuThao', [dshosodenghikhenthuongdoingoaiController::class, 'DuThaoQuyetDinh']);
        Route::post('QuyetDinh', [dshosodenghikhenthuongdoingoaiController::class, 'LuuQuyetDinh']);
        Route::get('PheDuyet', [dshosodenghikhenthuongdoingoaiController::class, 'PheDuyet']);
        Route::post('PheDuyet', [dshosodenghikhenthuongdoingoaiController::class, 'LuuPheDuyet']);
        Route::post('HuyPheDuyet', [dshosodenghikhenthuongdoingoaiController::class, 'HuyPheDuyet']);

        Route::get('InQuyetDinh', [qdhosodenghikhenthuongdoingoaiController::class, 'InQuyetDinh']);
        Route::get('InPhoi', [qdhosodenghikhenthuongdoingoaiController::class, 'InPhoi']);

        Route::post('NoiDungKhenThuong', [qdhosodenghikhenthuongdoingoaiController::class, 'NoiDungKhenThuong']);
        Route::get('InBangKhenCaNhan', [qdhosodenghikhenthuongdoingoaiController::class, 'InBangKhenCaNhan']);
        Route::get('InBangKhenTapThe', [qdhosodenghikhenthuongdoingoaiController::class, 'InBangKhenTapThe']);
        Route::get('InGiayKhenCaNhan', [qdhosodenghikhenthuongdoingoaiController::class, 'InGiayKhenCaNhan']);
        Route::get('InGiayKhenTapThe', [qdhosodenghikhenthuongdoingoaiController::class, 'InGiayKhenTapThe']);
    });

    Route::group(['prefix' => 'XetDuyet'], function () {
        Route::get('ThongTin', [xdhosodenghikhenthuongdoingoaiController::class, 'ThongTin']);
        Route::post('TraLai', [xdhosodenghikhenthuongdoingoaiController::class, 'TraLai']);
        Route::post('NhanHoSo', [xdhosodenghikhenthuongdoingoaiController::class, 'NhanHoSo']);
        Route::post('ChuyenHoSo', [xdhosodenghikhenthuongdoingoaiController::class, 'ChuyenHoSo']);

        Route::get('XetKT', [xdhosodenghikhenthuongdoingoaiController::class, 'XetKT']);
        Route::post('ThemTapThe', [xdhosodenghikhenthuongdoingoaiController::class, 'ThemTapThe']);
        Route::post('ThemCaNhan', [xdhosodenghikhenthuongdoingoaiController::class, 'ThemCaNhan']);
        Route::post('GanKhenThuong', [xdhosodenghikhenthuongdoingoaiController::class, 'GanKhenThuong']);
        Route::get('QuyetDinh', [xdhosodenghikhenthuongdoingoaiController::class, 'QuyetDinh']);
        Route::get('TaoDuThao', [xdhosodenghikhenthuongdoingoaiController::class, 'DuThaoQuyetDinh']);
        Route::post('QuyetDinh', [xdhosodenghikhenthuongdoingoaiController::class, 'LuuQuyetDinh']);
        Route::post('PheDuyet', [xdhosodenghikhenthuongdoingoaiController::class, 'PheDuyet']);
        Route::get('LayLyDo', [xdhosodenghikhenthuongdoingoaiController::class, 'LayLyDo']);
    });

    Route::group(['prefix' => 'KhenThuong'], function () {
        Route::get('ThongTin', [qdhosodenghikhenthuongdoingoaiController::class, 'ThongTin']);
        Route::post('Them', [qdhosodenghikhenthuongdoingoaiController::class, 'Them']);
        Route::get('Sua', [qdhosodenghikhenthuongdoingoaiController::class, 'Sua']);
        Route::post('Sua', [qdhosodenghikhenthuongdoingoaiController::class, 'LuuHoSo']);
        Route::post('Xoa', [qdhosodenghikhenthuongdoingoaiController::class, 'XoaHoSo']);

        Route::post('ThemTapThe', [qdhosodenghikhenthuongdoingoaiController::class, 'ThemTapThe']);
        Route::get('XoaTapThe', [qdhosodenghikhenthuongdoingoaiController::class, 'XoaTapThe']);
        Route::post('NhanExcelTapThe', [qdhosodenghikhenthuongdoingoaiController::class, 'NhanExcelTapThe']);
        Route::post('ThemCaNhan', [qdhosodenghikhenthuongdoingoaiController::class, 'ThemCaNhan']);
        Route::get('XoaCaNhan', [qdhosodenghikhenthuongdoingoaiController::class, 'XoaCaNhan']);
        Route::post('NhanExcelCaNhan', [qdhosodenghikhenthuongdoingoaiController::class, 'NhanExcelCaNhan']);
        Route::post('NhanExcelDeTai', [qdhosodenghikhenthuongdoingoaiController::class, 'NhanExcelDeTai']);


        Route::get('XetKT', [qdhosodenghikhenthuongdoingoaiController::class, 'XetKT']);
        Route::get('QuyetDinh', [qdhosodenghikhenthuongdoingoaiController::class, 'QuyetDinh']);
        Route::get('TaoDuThao', [qdhosodenghikhenthuongdoingoaiController::class, 'DuThaoQuyetDinh']);
        Route::post('QuyetDinh', [qdhosodenghikhenthuongdoingoaiController::class, 'LuuQuyetDinh']);
        //Route::post('PheDuyet', [qdhosodenghikhenthuongdoingoaiController::class, 'PheDuyet']);
        Route::post('GanKhenThuong', [qdhosodenghikhenthuongdoingoaiController::class, 'GanKhenThuong']);
        Route::post('HuyPheDuyet', [qdhosodenghikhenthuongdoingoaiController::class, 'HuyPheDuyet']);
        Route::post('TraLai', [qdhosodenghikhenthuongdoingoaiController::class, 'TraLai']);

        Route::get('PheDuyet', [qdhosodenghikhenthuongdoingoaiController::class, 'PheDuyet']);
        Route::post('PheDuyet', [qdhosodenghikhenthuongdoingoaiController::class, 'LuuPheDuyet']);
        //In dữ liệu
        Route::post('LayDoiTuong', [qdhosodenghikhenthuongdoingoaiController::class, 'LayDoiTuong']);
        // Route::get('InQuyetDinh', [qdhosodenghikhenthuongdoingoaiController::class, 'InQuyetDinh']);
        // Route::post('InBangKhen', [qdhosodenghikhenthuongdoingoaiController::class, 'InBangKhen']);
        // Route::post('InGiayKhen', [qdhosodenghikhenthuongdoingoaiController::class, 'InGiayKhen']);

        Route::get('InHoSoPD', [qdhosodenghikhenthuongdoingoaiController::class, 'XemHoSo']);
        Route::get('InQuyetDinh', [qdhosodenghikhenthuongdoingoaiController::class, 'InQuyetDinh']);

        Route::get('InPhoi', [qdhosodenghikhenthuongdoingoaiController::class, 'InPhoi']);
        Route::post('NoiDungKhenThuong', [qdhosodenghikhenthuongdoingoaiController::class, 'NoiDungKhenThuong']);
        Route::get('InBangKhenCaNhan', [qdhosodenghikhenthuongdoingoaiController::class, 'InBangKhenCaNhan']);
        Route::get('InBangKhenTapThe', [qdhosodenghikhenthuongdoingoaiController::class, 'InBangKhenTapThe']);
        Route::get('InGiayKhenCaNhan', [qdhosodenghikhenthuongdoingoaiController::class, 'InGiayKhenCaNhan']);
        Route::get('InGiayKhenTapThe', [qdhosodenghikhenthuongdoingoaiController::class, 'InGiayKhenTapThe']);
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

use App\Http\Controllers\NghiepVu\KhenThuongChuyenDe\dshosodenghikhenthuongchuyendeController;
use App\Http\Controllers\NghiepVu\KhenThuongChuyenDe\dshosokhenthuongchuyendeController;
use App\Http\Controllers\NghiepVu\KhenThuongChuyenDe\qdhosodenghikhenthuongchuyendeController;
use App\Http\Controllers\NghiepVu\KhenThuongChuyenDe\xdhosodenghikhenthuongchuyendeController;

//Khen thưởng chuyên đề
Route::group(['prefix' => 'KhenThuongChuyenDe'], function () {
    Route::group(['prefix' => 'HoSoKT'], function () {
        Route::get('ThongTin', [dshosokhenthuongchuyendeController::class, 'ThongTin']);
        Route::post('Them', [dshosokhenthuongchuyendeController::class, 'Them']);
        Route::get('Sua', [dshosokhenthuongchuyendeController::class, 'ThayDoi']);
        Route::post('Sua', [dshosokhenthuongchuyendeController::class, 'LuuHoSo']);
        Route::get('InHoSo', [dshosokhenthuongchuyendeController::class, 'XemHoSo']);
        Route::get('InHoSoKT', [dshosokhenthuongchuyendeController::class, 'InHoSoKT']);
        Route::post('Xoa', [dshosokhenthuongchuyendeController::class, 'XoaHoSo']);

        Route::post('ThemTapThe', [dshosokhenthuongchuyendeController::class, 'ThemTapThe']);
        Route::get('XoaTapThe', [dshosokhenthuongchuyendeController::class, 'XoaTapThe']);
        Route::get('LayTapThe', [dshosokhenthuongchuyendeController::class, 'LayTapThe']);
        Route::post('NhanExcelTapThe', [dshosokhenthuongchuyendeController::class, 'NhanExcelTapThe']);

        Route::post('ThemCaNhan', [dshosokhenthuongchuyendeController::class, 'ThemCaNhan']);
        Route::get('XoaCaNhan', [dshosokhenthuongchuyendeController::class, 'XoaCaNhan']);
        Route::get('LayCaNhan', [dshosokhenthuongchuyendeController::class, 'LayCaNhan']);
        Route::post('NhanExcelCaNhan', [dshosokhenthuongchuyendeController::class, 'NhanExcelCaNhan']);

        Route::post('ThemDeTai', [dshosokhenthuongchuyendeController::class, 'ThemDeTai']);
        Route::get('XoaDeTai', [dshosokhenthuongchuyendeController::class, 'XoaDeTai']);
        Route::get('LayDeTai', [dshosokhenthuongchuyendeController::class, 'LayDeTai']);
        Route::post('NhanExcelDeTai', [dshosokhenthuongchuyendeController::class, 'NhanExcelDeTai']);

        Route::get('TaiLieuDinhKem', [dshosokhenthuongchuyendeController::class, 'TaiLieuDinhKem']);
        Route::post('ChuyenHoSo', [dshosokhenthuongchuyendeController::class, 'ChuyenHoSo']);
        Route::get('LayLyDo', [dshosokhenthuongchuyendeController::class, 'LayLyDo']);

        //29.10.2022
        Route::get('ToTrinhHoSo', [dshosokhenthuongchuyendeController::class, 'ToTrinhHoSo']);
        Route::post('ToTrinhHoSo', [dshosokhenthuongchuyendeController::class, 'LuuToTrinhHoSo']);
        Route::get('InToTrinhHoSo', [dshosokhenthuongchuyendeController::class, 'InToTrinhHoSo']);

        Route::get('ToTrinhPheDuyet', [dshosokhenthuongchuyendeController::class, 'ToTrinhPheDuyet']);
        Route::post('ToTrinhPheDuyet', [dshosokhenthuongchuyendeController::class, 'LuuToTrinhPheDuyet']);
        Route::get('InToTrinhPheDuyet', [dshosokhenthuongchuyendeController::class, 'InToTrinhPheDuyet']);
        Route::get('QuyetDinh', [dshosokhenthuongchuyendeController::class, 'QuyetDinh']);
        Route::get('TaoDuThao', [dshosokhenthuongchuyendeController::class, 'DuThaoQuyetDinh']);
        Route::post('QuyetDinh', [dshosokhenthuongchuyendeController::class, 'LuuQuyetDinh']);
        Route::get('PheDuyet', [dshosokhenthuongchuyendeController::class, 'PheDuyet']);
        Route::post('PheDuyet', [dshosokhenthuongchuyendeController::class, 'LuuPheDuyet']);
        Route::post('HuyPheDuyet', [dshosokhenthuongchuyendeController::class, 'HuyPheDuyet']);
        Route::get('InQuyetDinh', [dshosokhenthuongchuyendeController::class, 'InQuyetDinh']);
        Route::get('InPhoi', [dshosokhenthuongchuyendeController::class, 'InPhoi']);

        Route::post('NoiDungKhenThuong', [dshosokhenthuongchuyendeController::class, 'NoiDungKhenThuong']);
        Route::get('InBangKhenCaNhan', [dshosokhenthuongchuyendeController::class, 'InBangKhenCaNhan']);
        Route::get('InBangKhenTapThe', [dshosokhenthuongchuyendeController::class, 'InBangKhenTapThe']);
        Route::get('InGiayKhenCaNhan', [dshosokhenthuongchuyendeController::class, 'InGiayKhenCaNhan']);
        Route::get('InGiayKhenTapThe', [dshosokhenthuongchuyendeController::class, 'InGiayKhenTapThe']);
    });

    Route::group(['prefix' => 'HoSo'], function () {
        Route::get('ThongTin', [dshosodenghikhenthuongchuyendeController::class, 'ThongTin']);
        Route::post('Them', [dshosodenghikhenthuongchuyendeController::class, 'Them']);
        Route::get('Sua', [dshosodenghikhenthuongchuyendeController::class, 'ThayDoi']);
        Route::post('Sua', [dshosodenghikhenthuongchuyendeController::class, 'LuuHoSo']);
        Route::get('InHoSo', [dshosodenghikhenthuongchuyendeController::class, 'XemHoSo']);
        Route::get('InHoSoPD', [qdhosodenghikhenthuongchuyendeController::class, 'XemHoSo']);
        Route::post('Xoa', [dshosodenghikhenthuongchuyendeController::class, 'XoaHoSo']);

        Route::post('ThemTapThe', [dshosodenghikhenthuongchuyendeController::class, 'ThemTapThe']);
        Route::get('XoaTapThe', [dshosodenghikhenthuongchuyendeController::class, 'XoaTapThe']);
        Route::get('LayTapThe', [dshosodenghikhenthuongchuyendeController::class, 'LayTapThe']);
        Route::post('NhanExcelTapThe', [dshosodenghikhenthuongchuyendeController::class, 'NhanExcelTapThe']);

        Route::post('ThemCaNhan', [dshosodenghikhenthuongchuyendeController::class, 'ThemCaNhan']);
        Route::get('XoaCaNhan', [dshosodenghikhenthuongchuyendeController::class, 'XoaCaNhan']);
        Route::get('LayCaNhan', [dshosodenghikhenthuongchuyendeController::class, 'LayCaNhan']);
        Route::post('NhanExcelCaNhan', [dshosodenghikhenthuongchuyendeController::class, 'NhanExcelCaNhan']);

        Route::post('ThemDeTai', [dshosodenghikhenthuongchuyendeController::class, 'ThemDeTai']);
        Route::get('XoaDeTai', [dshosodenghikhenthuongchuyendeController::class, 'XoaDeTai']);
        Route::get('LayDeTai', [dshosodenghikhenthuongchuyendeController::class, 'LayDeTai']);
        Route::post('NhanExcelDeTai', [dshosodenghikhenthuongchuyendeController::class, 'NhanExcelDeTai']);

        Route::get('TaiLieuDinhKem', [dshosodenghikhenthuongchuyendeController::class, 'TaiLieuDinhKem']);
        Route::post('ChuyenHoSo', [dshosodenghikhenthuongchuyendeController::class, 'ChuyenHoSo']);
        Route::get('LayLyDo', [dshosodenghikhenthuongchuyendeController::class, 'LayLyDo']);
        Route::get('LayTieuChuan', [dshosodenghikhenthuongchuyendeController::class, 'LayTieuChuan']);
        Route::get('LayDoiTuong', [dshosodenghikhenthuongchuyendeController::class, 'LayDoiTuong']);

        //29.10.2022
        Route::get('QuyetDinh', [dshosodenghikhenthuongchuyendeController::class, 'QuyetDinh']);
        Route::get('TaoDuThao', [dshosodenghikhenthuongchuyendeController::class, 'DuThaoQuyetDinh']);
        Route::post('QuyetDinh', [dshosodenghikhenthuongchuyendeController::class, 'LuuQuyetDinh']);
        Route::get('PheDuyet', [dshosodenghikhenthuongchuyendeController::class, 'PheDuyet']);
        Route::post('PheDuyet', [dshosodenghikhenthuongchuyendeController::class, 'LuuPheDuyet']);
        Route::post('HuyPheDuyet', [dshosodenghikhenthuongchuyendeController::class, 'HuyPheDuyet']);

        Route::get('InQuyetDinh', [qdhosodenghikhenthuongchuyendeController::class, 'InQuyetDinh']);
        Route::get('InPhoi', [qdhosodenghikhenthuongchuyendeController::class, 'InPhoi']);

        Route::post('NoiDungKhenThuong', [qdhosodenghikhenthuongchuyendeController::class, 'NoiDungKhenThuong']);
        Route::get('InBangKhenCaNhan', [qdhosodenghikhenthuongchuyendeController::class, 'InBangKhenCaNhan']);
        Route::get('InBangKhenTapThe', [qdhosodenghikhenthuongchuyendeController::class, 'InBangKhenTapThe']);
        Route::get('InGiayKhenCaNhan', [qdhosodenghikhenthuongchuyendeController::class, 'InGiayKhenCaNhan']);
        Route::get('InGiayKhenTapThe', [qdhosodenghikhenthuongchuyendeController::class, 'InGiayKhenTapThe']);
    });

    Route::group(['prefix' => 'XetDuyet'], function () {
        Route::get('ThongTin', [xdhosodenghikhenthuongchuyendeController::class, 'ThongTin']);
        Route::post('TraLai', [xdhosodenghikhenthuongchuyendeController::class, 'TraLai']);
        Route::post('NhanHoSo', [xdhosodenghikhenthuongchuyendeController::class, 'NhanHoSo']);
        Route::post('ChuyenHoSo', [xdhosodenghikhenthuongchuyendeController::class, 'ChuyenHoSo']);

        Route::get('XetKT', [xdhosodenghikhenthuongchuyendeController::class, 'XetKT']);
        Route::post('ThemTapThe', [xdhosodenghikhenthuongchuyendeController::class, 'ThemTapThe']);
        Route::post('ThemCaNhan', [xdhosodenghikhenthuongchuyendeController::class, 'ThemCaNhan']);
        Route::post('GanKhenThuong', [xdhosodenghikhenthuongchuyendeController::class, 'GanKhenThuong']);
        Route::get('QuyetDinh', [xdhosodenghikhenthuongchuyendeController::class, 'QuyetDinh']);
        Route::get('TaoDuThao', [xdhosodenghikhenthuongchuyendeController::class, 'DuThaoQuyetDinh']);
        Route::post('QuyetDinh', [xdhosodenghikhenthuongchuyendeController::class, 'LuuQuyetDinh']);
        Route::post('PheDuyet', [xdhosodenghikhenthuongchuyendeController::class, 'PheDuyet']);
        Route::get('LayLyDo', [xdhosodenghikhenthuongchuyendeController::class, 'LayLyDo']);
    });

    Route::group(['prefix' => 'KhenThuong'], function () {
        Route::get('ThongTin', [qdhosodenghikhenthuongchuyendeController::class, 'ThongTin']);
        Route::post('Them', [qdhosodenghikhenthuongchuyendeController::class, 'Them']);
        Route::get('Sua', [qdhosodenghikhenthuongchuyendeController::class, 'Sua']);
        Route::post('Sua', [qdhosodenghikhenthuongchuyendeController::class, 'LuuHoSo']);
        Route::post('Xoa', [qdhosodenghikhenthuongchuyendeController::class, 'XoaHoSo']);

        Route::post('ThemTapThe', [qdhosodenghikhenthuongchuyendeController::class, 'ThemTapThe']);
        Route::get('XoaTapThe', [qdhosodenghikhenthuongchuyendeController::class, 'XoaTapThe']);
        Route::post('NhanExcelTapThe', [qdhosodenghikhenthuongchuyendeController::class, 'NhanExcelTapThe']);
        Route::post('ThemCaNhan', [qdhosodenghikhenthuongchuyendeController::class, 'ThemCaNhan']);
        Route::get('XoaCaNhan', [qdhosodenghikhenthuongchuyendeController::class, 'XoaCaNhan']);
        Route::post('NhanExcelCaNhan', [qdhosodenghikhenthuongchuyendeController::class, 'NhanExcelCaNhan']);
        Route::post('NhanExcelDeTai', [qdhosodenghikhenthuongchuyendeController::class, 'NhanExcelDeTai']);

        Route::get('PheDuyet', [qdhosodenghikhenthuongchuyendeController::class, 'PheDuyet']);
        Route::post('PheDuyet', [qdhosodenghikhenthuongchuyendeController::class, 'LuuPheDuyet']);

        Route::get('XetKT', [qdhosodenghikhenthuongchuyendeController::class, 'XetKT']);
        Route::get('QuyetDinh', [qdhosodenghikhenthuongchuyendeController::class, 'QuyetDinh']);
        Route::get('TaoDuThao', [qdhosodenghikhenthuongchuyendeController::class, 'DuThaoQuyetDinh']);
        Route::post('QuyetDinh', [qdhosodenghikhenthuongchuyendeController::class, 'LuuQuyetDinh']);
        Route::post('GanKhenThuong', [qdhosodenghikhenthuongchuyendeController::class, 'GanKhenThuong']);
        Route::post('HuyPheDuyet', [qdhosodenghikhenthuongchuyendeController::class, 'HuyPheDuyet']);
        Route::post('TraLai', [qdhosodenghikhenthuongchuyendeController::class, 'TraLai']);

        //In dữ liệu
        Route::post('LayDoiTuong', [qdhosodenghikhenthuongchuyendeController::class, 'LayDoiTuong']);
        Route::get('InQuyetDinh', [qdhosodenghikhenthuongchuyendeController::class, 'InQuyetDinh']);
        Route::get('InHoSoPD', [qdhosodenghikhenthuongchuyendeController::class, 'XemHoSo']);

        Route::get('InPhoi', [qdhosodenghikhenthuongchuyendeController::class, 'InPhoi']);
        Route::post('NoiDungKhenThuong', [qdhosodenghikhenthuongchuyendeController::class, 'NoiDungKhenThuong']);
        Route::get('InBangKhenCaNhan', [qdhosodenghikhenthuongchuyendeController::class, 'InBangKhenCaNhan']);
        Route::get('InBangKhenTapThe', [qdhosodenghikhenthuongchuyendeController::class, 'InBangKhenTapThe']);
        Route::get('InGiayKhenCaNhan', [qdhosodenghikhenthuongchuyendeController::class, 'InGiayKhenCaNhan']);
        Route::get('InGiayKhenTapThe', [qdhosodenghikhenthuongchuyendeController::class, 'InGiayKhenTapThe']);
    });
});
