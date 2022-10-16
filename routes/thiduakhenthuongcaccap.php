<?php
//Phong trào thi đua
use App\Http\Controllers\NghiepVu\KhenThuongCongTrang\dshosokhenthuongcongtrangController;
use App\Http\Controllers\NghiepVu\KhenThuongCongTrang\qdhosokhenthuongcongtrangController;
use App\Http\Controllers\NghiepVu\KhenThuongCongTrang\xdhosokhenthuongcongtrangController;
use App\Http\Controllers\NghiepVu\KhenThuongDotXuat\dshosokhenthuongdotxuatController;
use App\Http\Controllers\NghiepVu\KhenThuongDotXuat\qdhosokhenthuongdotxuatController;
use App\Http\Controllers\NghiepVu\KhenThuongDotXuat\xdhosokhenthuongdotxuatController;
use App\Http\Controllers\NghiepVu\ThiDuaKhenThuong\dshosothiduaController;
use App\Http\Controllers\NghiepVu\ThiDuaKhenThuong\dsphongtraothiduaController;
use App\Http\Controllers\NghiepVu\ThiDuaKhenThuong\khenthuonghosothiduaController;
use App\Http\Controllers\NghiepVu\ThiDuaKhenThuong\xetduyethosothiduaController;
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

    Route::get('ThemKhenThuong', 'NghiepVu\ThiDuaKhenThuong\dsphongtraothiduaController@ThemKhenThuong');
    Route::get('ThemTieuChuan', 'NghiepVu\ThiDuaKhenThuong\dsphongtraothiduaController@ThemTieuChuan');
    Route::get('LayTieuChuan', 'NghiepVu\ThiDuaKhenThuong\dsphongtraothiduaController@LayTieuChuan');
    Route::get('XoaTieuChuan', 'NghiepVu\ThiDuaKhenThuong\dsphongtraothiduaController@XoaTieuChuan');
    Route::get('TaiLieuDinhKem', 'NghiepVu\ThiDuaKhenThuong\dsphongtraothiduaController@TaiLieuDinhKem');

    //Route::get('Sua','system\DSTaiKhoanController@edit');
});

Route::group(['prefix' => 'HoSoThiDua'], function () {
    Route::get('ThongTin', 'NghiepVu\ThiDuaKhenThuong\dshosothiduaController@ThongTin');
    Route::get('Them', [dshosothiduaController::class, 'ThemHoSo']);
    Route::post('Them', 'NghiepVu\ThiDuaKhenThuong\dshosothiduaController@LuuHoSo');
    Route::get('Sua', 'NghiepVu\ThiDuaKhenThuong\dshosothiduaController@ThayDoi');
    Route::post('Sua', 'NghiepVu\ThiDuaKhenThuong\dshosothiduaController@LuuHoSo');
    Route::get('Xem', 'NghiepVu\ThiDuaKhenThuong\dshosothiduaController@XemHoSo');
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
    Route::get('ThongTin', 'NghiepVu\ThiDuaKhenThuong\xetduyethosothiduaController@ThongTin');
    Route::get('DanhSach', 'NghiepVu\ThiDuaKhenThuong\xetduyethosothiduaController@DanhSach');
    Route::post('TraLai', 'NghiepVu\ThiDuaKhenThuong\xetduyethosothiduaController@TraLai');
    Route::get('Xem', 'NghiepVu\ThiDuaKhenThuong\xetduyethosothiduaController@XemDanhSach');
    Route::post('ChuyenHoSo', 'NghiepVu\ThiDuaKhenThuong\xetduyethosothiduaController@ChuyenHoSo');
    Route::post('NhanHoSo', 'NghiepVu\ThiDuaKhenThuong\xetduyethosothiduaController@NhanHoSo');

    Route::post('ThemKT', [xetduyethosothiduaController::class, 'ThemKT']);
    Route::get('XetKT', [xetduyethosothiduaController::class, 'XetKT']);
    Route::post('XetKT', [xetduyethosothiduaController::class, 'LuuKT']);
    Route::post('XoaHoSoKT', [xetduyethosothiduaController::class, 'XoaHoSoKT']);
    Route::get('Xem', [xetduyethosothiduaController::class, 'XemHoSoKT']);
    Route::get('TaiLieuDinhKem', [xetduyethosothiduaController::class, 'TaiLieuDinhKem']);

    Route::get('LayTapThe', [xetduyethosothiduaController::class, 'LayTapThe']);
    Route::post('ThemTapThe', [xetduyethosothiduaController::class, 'ThemTapThe']);
    Route::get('XoaTapThe', [xetduyethosothiduaController::class, 'XoaTapThe']);
    Route::post('NhanExcelTapThe', [xetduyethosothiduaController::class, 'NhanExcelTapThe']);
    Route::get('LayCaNhan', [xetduyethosothiduaController::class, 'LayCaNhan']);
    Route::post('ThemCaNhan', [xetduyethosothiduaController::class, 'ThemCaNhan']);
    Route::get('XoaCaNhan', [xetduyethosothiduaController::class, 'XoaCaNhan']);
    Route::post('NhanExcelCaNhan', [xetduyethosothiduaController::class, 'NhanExcelCaNhan']);

    Route::get('QuyetDinh', [xetduyethosothiduaController::class, 'QuyetDinh']);
    Route::get('TaoDuThao', [xetduyethosothiduaController::class, 'DuThaoQuyetDinh']);
    Route::post('QuyetDinh', [xetduyethosothiduaController::class, 'LuuQuyetDinh']);
    Route::post('PheDuyet', [xetduyethosothiduaController::class, 'PheDuyet']);
    Route::get('LayLyDo', [xetduyethosothiduaController::class, 'LayLyDo']);
});

Route::group(['prefix' => 'KhenThuongHoSoThiDua'], function () {
    Route::get('ThongTin', 'NghiepVu\ThiDuaKhenThuong\khenthuonghosothiduaController@ThongTin');
    Route::post('KhenThuong', 'NghiepVu\ThiDuaKhenThuong\khenthuonghosothiduaController@KhenThuong');
    Route::get('DanhSach', 'NghiepVu\ThiDuaKhenThuong\khenthuonghosothiduaController@DanhSach');
    Route::post('Sua', 'NghiepVu\ThiDuaKhenThuong\khenthuonghosothiduaController@LuuHoSo');
    Route::get('Xem', 'NghiepVu\ThiDuaKhenThuong\khenthuonghosothiduaController@XemHoSo');
    Route::post('TraLai', [khenthuonghosothiduaController::class, 'TraLai']);

    Route::post('HoSo', 'NghiepVu\ThiDuaKhenThuong\khenthuonghosothiduaController@HoSo');
    Route::post('KetQua', 'NghiepVu\ThiDuaKhenThuong\khenthuonghosothiduaController@KetQua');
    Route::post('PheDuyet', 'NghiepVu\ThiDuaKhenThuong\khenthuonghosothiduaController@PheDuyet');
    Route::post('HuyPheDuyet', 'NghiepVu\ThiDuaKhenThuong\khenthuonghosothiduaController@HuyPheDuyet');

    Route::get('InKetQua', 'NghiepVu\ThiDuaKhenThuong\khenthuonghosothiduaController@InKetQua');
    Route::get('MacDinhQuyetDinh', 'NghiepVu\ThiDuaKhenThuong\khenthuonghosothiduaController@MacDinhQuyetDinh');
    Route::get('QuyetDinh', 'NghiepVu\ThiDuaKhenThuong\khenthuonghosothiduaController@QuyetDinh');
    Route::post('QuyetDinh', 'NghiepVu\ThiDuaKhenThuong\khenthuonghosothiduaController@LuuQuyetDinh');
    Route::get('XemQuyetDinh', 'NghiepVu\ThiDuaKhenThuong\khenthuonghosothiduaController@XemQuyetDinh');
    Route::get('LayTieuChuan', 'NghiepVu\ThiDuaKhenThuong\khenthuonghosothiduaController@LayTieuChuan');
    Route::post('KetThuc', 'NghiepVu\ThiDuaKhenThuong\khenthuonghosothiduaController@KetThuc');

    Route::get('LayTapThe', [khenthuonghosothiduaController::class, 'LayTapThe']);
    Route::post('ThemTapThe', [khenthuonghosothiduaController::class, 'ThemTapThe']);
    Route::get('XoaTapThe', [khenthuonghosothiduaController::class, 'XoaTapThe']);
    Route::post('NhanExcelTapThe', [khenthuonghosothiduaController::class, 'NhanExcelTapThe']);
    Route::get('LayCaNhan', [khenthuonghosothiduaController::class, 'LayCaNhan']);
    Route::post('ThemCaNhan', [khenthuonghosothiduaController::class, 'ThemCaNhan']);
    Route::get('XoaCaNhan', [khenthuonghosothiduaController::class, 'XoaCaNhan']);
    Route::post('NhanExcelCaNhan', [khenthuonghosothiduaController::class, 'NhanExcelCaNhan']);

    //In dữ liệu
    Route::post('LayDoiTuong', 'NghiepVu\ThiDuaKhenThuong\khenthuonghosothiduaController@LayDoiTuong');
    Route::post('InBangKhen', 'NghiepVu\ThiDuaKhenThuong\khenthuonghosothiduaController@InBangKhen');
    Route::post('InGiayKhen', 'NghiepVu\ThiDuaKhenThuong\khenthuonghosothiduaController@InGiayKhen');

    Route::get('InPhoi', [khenthuonghosothiduaController::class, 'InPhoi']);
    Route::post('NoiDungKhenThuong', [khenthuonghosothiduaController::class, 'NoiDungKhenThuong']);
    Route::get('InBangKhenCaNhan', [khenthuonghosothiduaController::class, 'InBangKhenCaNhan']);
    Route::get('InBangKhenTapThe', [khenthuonghosothiduaController::class, 'InBangKhenTapThe']);
    Route::get('InGiayKhenCaNhan', [khenthuonghosothiduaController::class, 'InGiayKhenCaNhan']);
    Route::get('InGiayKhenTapThe', [khenthuonghosothiduaController::class, 'InGiayKhenTapThe']);
});

//Khen thưởng theo công trạng
Route::group(['prefix' => 'KhenThuongCongTrang'], function () {
    Route::group(['prefix' => 'HoSo'], function () {
        Route::get('ThongTin', 'NghiepVu\KhenThuongCongTrang\dshosokhenthuongcongtrangController@ThongTin');
        Route::post('Them', 'NghiepVu\KhenThuongCongTrang\dshosokhenthuongcongtrangController@Them');
        Route::get('Sua', 'NghiepVu\KhenThuongCongTrang\dshosokhenthuongcongtrangController@ThayDoi');
        Route::post('Sua', 'NghiepVu\KhenThuongCongTrang\dshosokhenthuongcongtrangController@LuuHoSo');
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
    });

    Route::group(['prefix' => 'XetDuyet'], function () {
        Route::get('ThongTin', [xdhosokhenthuongcongtrangController::class, 'ThongTin']);
        Route::post('TraLai', 'NghiepVu\KhenThuongCongTrang\xdhosokhenthuongcongtrangController@TraLai');
        Route::post('NhanHoSo', 'NghiepVu\KhenThuongCongTrang\xdhosokhenthuongcongtrangController@NhanHoSo');
        Route::post('ChuyenHoSo', 'NghiepVu\KhenThuongCongTrang\xdhosokhenthuongcongtrangController@ChuyenHoSo');

        Route::get('XetKT', [xdhosokhenthuongcongtrangController::class, 'XetKT']);
        Route::post('ThemTapThe', [xdhosokhenthuongcongtrangController::class, 'ThemTapThe']);
        Route::post('ThemCaNhan', [xdhosokhenthuongcongtrangController::class, 'ThemCaNhan']);
        Route::post('GanKhenThuong', [xdhosokhenthuongcongtrangController::class, 'GanKhenThuong']);
        Route::get('QuyetDinh', [xdhosokhenthuongcongtrangController::class, 'QuyetDinh']);
        Route::get('TaoDuThao', [xdhosokhenthuongcongtrangController::class, 'DuThaoQuyetDinh']);
        Route::post('QuyetDinh', [xdhosokhenthuongcongtrangController::class, 'LuuQuyetDinh']);
        Route::post('PheDuyet', [xdhosokhenthuongcongtrangController::class, 'PheDuyet']);
        Route::get('LayLyDo', [xdhosokhenthuongcongtrangController::class, 'LayLyDo']);
    });
    Route::group(['prefix' => 'KhenThuong'], function () {
        Route::get('ThongTin', [qdhosokhenthuongcongtrangController::class, 'ThongTin']);
        Route::post('Them', [qdhosokhenthuongcongtrangController::class, 'Them']);
        Route::get('Sua', [qdhosokhenthuongcongtrangController::class, 'Sua']);
        Route::post('Sua', [qdhosokhenthuongcongtrangController::class, 'LuuHoSo']);
        Route::post('Xoa', [qdhosokhenthuongcongtrangController::class, 'XoaHoSo']);

        Route::post('ThemTapThe', [qdhosokhenthuongcongtrangController::class, 'ThemTapThe']);
        Route::get('XoaTapThe', [qdhosokhenthuongcongtrangController::class, 'XoaTapThe']);
        Route::post('NhanExcelTapThe', [qdhosokhenthuongcongtrangController::class, 'NhanExcelTapThe']);
        Route::post('ThemCaNhan', [qdhosokhenthuongcongtrangController::class, 'ThemCaNhan']);
        Route::get('XoaCaNhan', [qdhosokhenthuongcongtrangController::class, 'XoaCaNhan']);
        Route::post('NhanExcelCaNhan', [qdhosokhenthuongcongtrangController::class, 'NhanExcelCaNhan']);
        Route::post('NhanExcelDeTai', [qdhosokhenthuongcongtrangController::class, 'NhanExcelDeTai']);


        Route::get('XetKT', [qdhosokhenthuongcongtrangController::class, 'XetKT']);
        Route::get('QuyetDinh', [qdhosokhenthuongcongtrangController::class, 'QuyetDinh']);
        Route::get('TaoDuThao', [qdhosokhenthuongcongtrangController::class, 'DuThaoQuyetDinh']);
        Route::post('QuyetDinh', [qdhosokhenthuongcongtrangController::class, 'LuuQuyetDinh']);
        Route::post('PheDuyet', [qdhosokhenthuongcongtrangController::class, 'PheDuyet']);
        Route::post('GanKhenThuong', [qdhosokhenthuongcongtrangController::class, 'GanKhenThuong']);
        Route::post('HuyPheDuyet', [qdhosokhenthuongcongtrangController::class, 'HuyPheDuyet']);
        Route::post('TraLai', [qdhosokhenthuongcongtrangController::class, 'TraLai']);

        //In dữ liệu
        Route::post('LayDoiTuong', [qdhosokhenthuongcongtrangController::class, 'LayDoiTuong']);
        Route::get('InQuyetDinh', [qdhosokhenthuongcongtrangController::class, 'InQuyetDinh']);
        Route::post('InBangKhen', [qdhosokhenthuongcongtrangController::class, 'InBangKhen']);
        Route::post('InGiayKhen', [qdhosokhenthuongcongtrangController::class, 'InGiayKhen']);
        Route::get('InHoSo', [qdhosokhenthuongcongtrangController::class, 'XemHoSo']);

        Route::get('InPhoi', [qdhosokhenthuongcongtrangController::class, 'InPhoi']);
        Route::post('NoiDungKhenThuong', [qdhosokhenthuongcongtrangController::class, 'NoiDungKhenThuong']);
        Route::get('InBangKhenCaNhan', [qdhosokhenthuongcongtrangController::class, 'InBangKhenCaNhan']);
        Route::get('InBangKhenTapThe', [qdhosokhenthuongcongtrangController::class, 'InBangKhenTapThe']);
        Route::get('InGiayKhenCaNhan', [qdhosokhenthuongcongtrangController::class, 'InGiayKhenCaNhan']);
        Route::get('InGiayKhenTapThe', [qdhosokhenthuongcongtrangController::class, 'InGiayKhenTapThe']);
    });
});

//Khen thưởng đột xuất
Route::group(['prefix' => 'KhenThuongDotXuat'], function () {
    Route::group(['prefix' => 'HoSo'], function () {
        Route::get('ThongTin', 'NghiepVu\KhenThuongDotXuat\dshosokhenthuongdotxuatController@ThongTin');
        Route::post('Them', 'NghiepVu\KhenThuongDotXuat\dshosokhenthuongdotxuatController@Them');
        Route::get('Sua', 'NghiepVu\KhenThuongDotXuat\dshosokhenthuongdotxuatController@ThayDoi');
        Route::post('Sua', 'NghiepVu\KhenThuongDotXuat\dshosokhenthuongdotxuatController@LuuHoSo');
        Route::get('Xem', 'NghiepVu\KhenThuongDotXuat\dshosokhenthuongdotxuatController@XemHoSo');
        Route::post('Xoa', 'NghiepVu\KhenThuongDotXuat\dshosokhenthuongdotxuatController@XoaHoSo');

        Route::post('CaNhan', 'NghiepVu\KhenThuongDotXuat\dshosokhenthuongdotxuatController@ThemCaNhan');
        Route::post('TapThe', 'NghiepVu\KhenThuongDotXuat\dshosokhenthuongdotxuatController@ThemTapThe');
        Route::get('LayTieuChuan', 'NghiepVu\KhenThuongDotXuat\dshosokhenthuongdotxuatController@LayTieuChuan');
        Route::get('LayDoiTuong', 'NghiepVu\KhenThuongDotXuat\dshosokhenthuongdotxuatController@LayDoiTuong');
        Route::post('ChuyenHoSo', 'NghiepVu\KhenThuongDotXuat\dshosokhenthuongdotxuatController@ChuyenHoSo');
        Route::get('LayLyDo', 'NghiepVu\KhenThuongDotXuat\dshosokhenthuongdotxuatController@LayLyDo');

        Route::get('InHoSo', [dshosokhenthuongdotxuatController::class, 'XemHoSo']);
        Route::post('ThemTapThe', [dshosokhenthuongdotxuatController::class, 'ThemTapThe']);
        Route::get('XoaTapThe', [dshosokhenthuongdotxuatController::class, 'XoaTapThe']);
        Route::get('LayTapThe', [dshosokhenthuongdotxuatController::class, 'LayTapThe']);
        Route::post('NhanExcelTapThe', [dshosokhenthuongdotxuatController::class, 'NhanExcelTapThe']);

        Route::post('ThemCaNhan', [dshosokhenthuongdotxuatController::class, 'ThemCaNhan']);
        Route::get('XoaCaNhan', [dshosokhenthuongdotxuatController::class, 'XoaCaNhan']);
        Route::get('LayCaNhan', [dshosokhenthuongdotxuatController::class, 'LayCaNhan']);
        Route::post('NhanExcelCaNhan', [dshosokhenthuongdotxuatController::class, 'NhanExcelCaNhan']);

        Route::get('TaiLieuDinhKem', [dshosokhenthuongcongtrangController::class, 'TaiLieuDinhKem']);
    });

    Route::group(['prefix' => 'XetDuyet'], function () {
        Route::get('ThongTin', 'NghiepVu\KhenThuongDotXuat\xdhosokhenthuongdotxuatController@ThongTin');
        Route::post('TraLai', 'NghiepVu\KhenThuongDotXuat\xdhosokhenthuongdotxuatController@TraLai');
        Route::post('NhanHoSo', 'NghiepVu\KhenThuongDotXuat\xdhosokhenthuongdotxuatController@NhanHoSo');
        Route::post('ChuyenHoSo', 'NghiepVu\KhenThuongDotXuat\xdhosokhenthuongdotxuatController@ChuyenHoSo');

        Route::get('XetKT', [xdhosokhenthuongdotxuatController::class, 'XetKT']);
        Route::post('ThemTapThe', [xdhosokhenthuongdotxuatController::class, 'ThemTapThe']);
        Route::post('ThemCaNhan', [xdhosokhenthuongdotxuatController::class, 'ThemCaNhan']);
        Route::post('GanKhenThuong', [xdhosokhenthuongdotxuatController::class, 'GanKhenThuong']);
        Route::get('QuyetDinh', [xdhosokhenthuongdotxuatController::class, 'QuyetDinh']);
        Route::get('TaoDuThao', [xdhosokhenthuongdotxuatController::class, 'DuThaoQuyetDinh']);
        Route::post('QuyetDinh', [xdhosokhenthuongdotxuatController::class, 'LuuQuyetDinh']);
        Route::post('PheDuyet', [xdhosokhenthuongdotxuatController::class, 'PheDuyet']);
        Route::get('LayLyDo', [xdhosokhenthuongdotxuatController::class, 'LayLyDo']);
    });

    Route::group(['prefix' => 'KhenThuong'], function () {
        Route::get('ThongTin', 'NghiepVu\KhenThuongDotXuat\qdhosokhenthuongdotxuatController@ThongTin');
        Route::post('KhenThuong', 'NghiepVu\KhenThuongDotXuat\qdhosokhenthuongdotxuatController@KhenThuong');
        Route::get('DanhSach', 'NghiepVu\KhenThuongDotXuat\qdhosokhenthuongdotxuatController@DanhSach');
        Route::post('DanhSach', 'NghiepVu\KhenThuongDotXuat\qdhosokhenthuongdotxuatController@LuuHoSo');
        Route::post('PheDuyet', 'NghiepVu\KhenThuongDotXuat\qdhosokhenthuongdotxuatController@PheDuyet');
        Route::post('HoSo', 'NghiepVu\KhenThuongDotXuat\qdhosokhenthuongdotxuatController@HoSo');
        Route::post('KetQua', 'NghiepVu\KhenThuongDotXuat\qdhosokhenthuongdotxuatController@KetQua');
        Route::get('LayDoiTuong', 'NghiepVu\KhenThuongDotXuat\qdhosokhenthuongdotxuatController@LayDoiTuong');
        Route::get('LayTieuChuan', 'NghiepVu\KhenThuongDotXuat\qdhosokhenthuongdotxuatController@LayTieuChuan');

        Route::get('InKetQua', 'NghiepVu\KhenThuongDotXuat\qdhosokhenthuongdotxuatController@InKetQua');
        Route::get('MacDinhQuyetDinh', 'NghiepVu\KhenThuongDotXuat\qdhosokhenthuongdotxuatController@MacDinhQuyetDinh');
        Route::get('QuyetDinh', 'NghiepVu\KhenThuongDotXuat\qdhosokhenthuongdotxuatController@QuyetDinh');
        Route::post('QuyetDinh', 'NghiepVu\KhenThuongDotXuat\qdhosokhenthuongdotxuatController@LuuQuyetDinh');
        Route::get('XemQuyetDinh', 'NghiepVu\KhenThuongDotXuat\qdhosokhenthuongdotxuatController@XemQuyetDinh');

        Route::get('InHoSo', [qdhosokhenthuongdotxuatController::class, 'XemHoSo']);
        Route::get('InQuyetDinh', [qdhosokhenthuongcongtrangController::class, 'InQuyetDinh']);

        Route::get('InPhoi', [qdhosokhenthuongdotxuatController::class, 'InPhoi']);
        Route::post('NoiDungKhenThuong', [qdhosokhenthuongdotxuatController::class, 'NoiDungKhenThuong']);
        Route::get('InBangKhenCaNhan', [qdhosokhenthuongdotxuatController::class, 'InBangKhenCaNhan']);
        Route::get('InBangKhenTapThe', [qdhosokhenthuongdotxuatController::class, 'InBangKhenTapThe']);
        Route::get('InGiayKhenCaNhan', [qdhosokhenthuongdotxuatController::class, 'InGiayKhenCaNhan']);
        Route::get('InGiayKhenTapThe', [qdhosokhenthuongdotxuatController::class, 'InGiayKhenTapThe']);
    });
});
//
//Khen cao
use App\Http\Controllers\NghiepVu\KhenCao\dshosokhencaoController;

Route::group(['prefix' => 'KhenCao'], function () {
    Route::get('ThongTin', [dshosokhencaoController::class, 'ThongTin']);
    Route::post('Them', 'NghiepVu\KhenCao\dshosokhencaoController@Them');
    Route::get('Sua', [dshosokhencaoController::class, 'ThayDoi']);
    Route::post('Sua', [dshosokhencaoController::class, 'LuuHoSo']);
    Route::get('InHoSo', [dshosokhencaoController::class, 'XemHoSo']);
    Route::post('Xoa', [dshosokhencaoController::class, 'XoaHoSo']);
    Route::post('PheDuyet', [dshosokhencaoController::class, 'PheDuyet']);
    Route::post('HuyPheDuyet', [dshosokhencaoController::class, 'HuyPheDuyet']);
    Route::get('TaiLieuDinhKem', [dshosokhencaoController::class, 'TaiLieuDinhKem']);

    Route::post('ThemTapThe', [dshosokhencaoController::class, 'ThemTapThe']);
    Route::get('XoaTapThe', [dshosokhencaoController::class, 'XoaTapThe']);
    Route::get('LayTapThe', [dshosokhencaoController::class, 'LayTapThe']);
    Route::post('NhanExcelTapThe', [dshosokhencaoController::class, 'NhanExcelTapThe']);

    Route::post('ThemCaNhan', [dshosokhencaoController::class, 'ThemCaNhan']);
    Route::get('XoaCaNhan', [dshosokhencaoController::class, 'XoaCaNhan']);
    Route::get('LayCaNhan', [dshosokhencaoController::class, 'LayCaNhan']);
    Route::post('NhanExcelCaNhan', [dshosokhencaoController::class, 'NhanExcelCaNhan']);
});

//Khen thưởng công hiến
use App\Http\Controllers\NghiepVu\KhenThuongCongHien\dshosokhenthuongconghienController;
use App\Http\Controllers\NghiepVu\KhenThuongCongHien\qdhosokhenthuongconghienController;
use App\Http\Controllers\NghiepVu\KhenThuongCongHien\xdhosokhenthuongconghienController;

Route::group(['prefix' => 'KhenThuongCongHien'], function () {
    Route::group(['prefix' => 'HoSo'], function () {
        Route::get('ThongTin', [dshosokhenthuongconghienController::class, 'ThongTin']);
        Route::post('Them', [dshosokhenthuongconghienController::class, 'Them']);
        Route::get('Sua', [dshosokhenthuongconghienController::class, 'ThayDoi']);
        Route::post('Sua', [dshosokhenthuongconghienController::class, 'LuuHoSo']);
        Route::get('InHoSo', [dshosokhenthuongconghienController::class, 'InHoSo']);
        Route::post('Xoa', [dshosokhenthuongconghienController::class, 'XoaHoSo']);

        Route::post('ChuyenHoSo', [dshosokhenthuongconghienController::class, 'ChuyenHoSo']);
        Route::get('LayLyDo', [dshosokhenthuongconghienController::class, 'LayLyDo']);

        Route::post('ThemTapThe', [dshosokhenthuongconghienController::class, 'ThemTapThe']);
        Route::get('XoaTapThe', [dshosokhenthuongconghienController::class, 'XoaTapThe']);
        Route::get('LayTapThe', [dshosokhenthuongconghienController::class, 'LayTapThe']);
        Route::post('NhanExcelTapThe', [dshosokhenthuongconghienController::class, 'NhanExcelTapThe']);

        Route::post('ThemCaNhan', [dshosokhenthuongconghienController::class, 'ThemCaNhan']);
        Route::get('XoaCaNhan', [dshosokhenthuongconghienController::class, 'XoaCaNhan']);
        Route::get('LayCaNhan', [dshosokhenthuongconghienController::class, 'LayCaNhan']);
        Route::post('NhanExcelCaNhan', [dshosokhenthuongconghienController::class, 'NhanExcelCaNhan']);

        Route::get('TaiLieuDinhKem', [dshosokhenthuongconghienController::class, 'TaiLieuDinhKem']);
    });

    Route::group(['prefix' => 'XetDuyet'], function () {
        Route::get('ThongTin', [xdhosokhenthuongconghienController::class, 'ThongTin']);
        Route::post('TraLai', [xdhosokhenthuongconghienController::class, 'TraLai']);
        Route::post('ChuyenHoSo', [xdhosokhenthuongconghienController::class, 'ChuyenHoSo']);
        Route::post('NhanHoSo', [xdhosokhenthuongconghienController::class, 'NhanHoSo']);

        Route::get('XetKT', [xdhosokhenthuongconghienController::class, 'XetKT']);
        Route::post('ThemTapThe', [xdhosokhenthuongconghienController::class, 'ThemTapThe']);
        Route::post('ThemCaNhan', [xdhosokhenthuongconghienController::class, 'ThemCaNhan']);
        Route::post('GanKhenThuong', [xdhosokhenthuongconghienController::class, 'GanKhenThuong']);
        Route::get('QuyetDinh', [xdhosokhenthuongconghienController::class, 'QuyetDinh']);
        Route::get('TaoDuThao', [xdhosokhenthuongconghienController::class, 'DuThaoQuyetDinh']);
        Route::post('QuyetDinh', [xdhosokhenthuongconghienController::class, 'LuuQuyetDinh']);
        Route::post('PheDuyet', [xdhosokhenthuongconghienController::class, 'PheDuyet']);
        Route::get('LayLyDo', [xdhosokhenthuongconghienController::class, 'LayLyDo']);
    });
    Route::group(['prefix' => 'KhenThuong'], function () {
        Route::get('ThongTin', [qdhosokhenthuongconghienController::class, 'ThongTin']);

        Route::post('Them', [qdhosokhenthuongconghienController::class, 'Them']);
        Route::get('Sua', [qdhosokhenthuongconghienController::class, 'Sua']);
        Route::post('Sua', [qdhosokhenthuongconghienController::class, 'LuuHoSo']);
        Route::post('ThemTapThe', [qdhosokhenthuongconghienController::class, 'ThemTapThe']);
        Route::get('XoaTapThe', [qdhosokhenthuongconghienController::class, 'XoaTapThe']);
        Route::post('NhanExcelTapThe', [qdhosokhenthuongconghienController::class, 'NhanExcelTapThe']);
        Route::post('ThemCaNhan', [qdhosokhenthuongconghienController::class, 'ThemCaNhan']);
        Route::get('XoaCaNhan', [qdhosokhenthuongconghienController::class, 'XoaCaNhan']);
        Route::post('NhanExcelCaNhan', [qdhosokhenthuongconghienController::class, 'NhanExcelCaNhan']);

        Route::get('XetKT', [qdhosokhenthuongconghienController::class, 'XetKT']);

        Route::get('QuyetDinh', [qdhosokhenthuongconghienController::class, 'QuyetDinh']);
        Route::get('TaoDuThao', [qdhosokhenthuongconghienController::class, 'DuThaoQuyetDinh']);
        Route::post('QuyetDinh', [qdhosokhenthuongconghienController::class, 'LuuQuyetDinh']);
        Route::post('PheDuyet', [qdhosokhenthuongconghienController::class, 'PheDuyet']);
        Route::post('GanKhenThuong', [qdhosokhenthuongconghienController::class, 'GanKhenThuong']);
        Route::post('HuyPheDuyet', [qdhosokhenthuongconghienController::class, 'HuyPheDuyet']);
        Route::post('TraLai', [qdhosokhenthuongconghienController::class, 'TraLai']);

        //In dữ liệu
        Route::post('LayDoiTuong', [qdhosokhenthuongconghienController::class, 'LayDoiTuong']);
        Route::get('InQuyetDinh', [qdhosokhenthuongconghienController::class, 'InQuyetDinh']);
        Route::post('InBangKhen', [qdhosokhenthuongconghienController::class, 'InBangKhen']);

        Route::get('InHoSo', [qdhosokhenthuongconghienController::class, 'XemHoSo']);
        Route::get('InPhoi', [qdhosokhenthuongconghienController::class, 'InPhoi']);
        Route::post('NoiDungKhenThuong', [qdhosokhenthuongconghienController::class, 'NoiDungKhenThuong']);
        Route::get('InBangKhenCaNhan', [qdhosokhenthuongconghienController::class, 'InBangKhenCaNhan']);
        Route::get('InBangKhenTapThe', [qdhosokhenthuongconghienController::class, 'InBangKhenTapThe']);
        Route::get('InGiayKhenCaNhan', [qdhosokhenthuongconghienController::class, 'InGiayKhenCaNhan']);
        Route::get('InGiayKhenTapThe', [qdhosokhenthuongconghienController::class, 'InGiayKhenTapThe']);
    });
});

//Khen thưởng theo đối ngoại
use App\Http\Controllers\NghiepVu\KhenThuongDoiNgoai\dshosokhenthuongdoingoaiController;
use App\Http\Controllers\NghiepVu\KhenThuongDoiNgoai\qdhosokhenthuongdoingoaiController;
use App\Http\Controllers\NghiepVu\KhenThuongDoiNgoai\xdhosokhenthuongdoingoaiController;

Route::group(['prefix' => 'KhenThuongDoiNgoai'], function () {
    Route::group(['prefix' => 'HoSo'], function () {
        Route::get('ThongTin', [dshosokhenthuongdoingoaiController::class, 'ThongTin']);
        Route::post('Them', [dshosokhenthuongdoingoaiController::class, 'Them']);
        Route::get('Sua', [dshosokhenthuongdoingoaiController::class, 'ThayDoi']);
        Route::post('Sua', [dshosokhenthuongdoingoaiController::class, 'LuuHoSo']);
        Route::get('InHoSo', [dshosokhenthuongdoingoaiController::class, 'XemHoSo']);
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
        Route::get('LayTieuChuan', [dshosokhenthuongdoingoaiController::class, 'LayTieuChuan']);
        Route::get('LayDoiTuong', [dshosokhenthuongdoingoaiController::class, 'LayDoiTuong']);
    });

    Route::group(['prefix' => 'XetDuyet'], function () {
        Route::get('ThongTin', [xdhosokhenthuongdoingoaiController::class, 'ThongTin']);
        Route::post('TraLai', [xdhosokhenthuongdoingoaiController::class, 'TraLai']);
        Route::post('NhanHoSo', [xdhosokhenthuongdoingoaiController::class, 'NhanHoSo']);
        Route::post('ChuyenHoSo', [xdhosokhenthuongdoingoaiController::class, 'ChuyenHoSo']);

        Route::get('XetKT', [xdhosokhenthuongdoingoaiController::class, 'XetKT']);
        Route::post('ThemTapThe', [xdhosokhenthuongdoingoaiController::class, 'ThemTapThe']);
        Route::post('ThemCaNhan', [xdhosokhenthuongdoingoaiController::class, 'ThemCaNhan']);
        Route::post('GanKhenThuong', [xdhosokhenthuongdoingoaiController::class, 'GanKhenThuong']);
        Route::get('QuyetDinh', [xdhosokhenthuongdoingoaiController::class, 'QuyetDinh']);
        Route::get('TaoDuThao', [xdhosokhenthuongdoingoaiController::class, 'DuThaoQuyetDinh']);
        Route::post('QuyetDinh', [xdhosokhenthuongdoingoaiController::class, 'LuuQuyetDinh']);
        Route::post('PheDuyet', [xdhosokhenthuongdoingoaiController::class, 'PheDuyet']);
        Route::get('LayLyDo', [xdhosokhenthuongdoingoaiController::class, 'LayLyDo']);
    });

    Route::group(['prefix' => 'KhenThuong'], function () {
        Route::get('ThongTin', [qdhosokhenthuongdoingoaiController::class, 'ThongTin']);
        Route::post('Them', [qdhosokhenthuongdoingoaiController::class, 'Them']);
        Route::get('Sua', [qdhosokhenthuongdoingoaiController::class, 'Sua']);
        Route::post('Sua', [qdhosokhenthuongdoingoaiController::class, 'LuuHoSo']);
        Route::post('Xoa', [qdhosokhenthuongdoingoaiController::class, 'XoaHoSo']);

        Route::post('ThemTapThe', [qdhosokhenthuongdoingoaiController::class, 'ThemTapThe']);
        Route::get('XoaTapThe', [qdhosokhenthuongdoingoaiController::class, 'XoaTapThe']);
        Route::post('NhanExcelTapThe', [qdhosokhenthuongdoingoaiController::class, 'NhanExcelTapThe']);
        Route::post('ThemCaNhan', [qdhosokhenthuongdoingoaiController::class, 'ThemCaNhan']);
        Route::get('XoaCaNhan', [qdhosokhenthuongdoingoaiController::class, 'XoaCaNhan']);
        Route::post('NhanExcelCaNhan', [qdhosokhenthuongdoingoaiController::class, 'NhanExcelCaNhan']);
        Route::post('NhanExcelDeTai', [qdhosokhenthuongdoingoaiController::class, 'NhanExcelDeTai']);


        Route::get('XetKT', [qdhosokhenthuongdoingoaiController::class, 'XetKT']);
        Route::get('QuyetDinh', [qdhosokhenthuongdoingoaiController::class, 'QuyetDinh']);
        Route::get('TaoDuThao', [qdhosokhenthuongdoingoaiController::class, 'DuThaoQuyetDinh']);
        Route::post('QuyetDinh', [qdhosokhenthuongdoingoaiController::class, 'LuuQuyetDinh']);
        Route::post('PheDuyet', [qdhosokhenthuongdoingoaiController::class, 'PheDuyet']);
        Route::post('GanKhenThuong', [qdhosokhenthuongdoingoaiController::class, 'GanKhenThuong']);
        Route::post('HuyPheDuyet', [qdhosokhenthuongdoingoaiController::class, 'HuyPheDuyet']);
        Route::post('TraLai', [qdhosokhenthuongdoingoaiController::class, 'TraLai']);

        //In dữ liệu
        Route::post('LayDoiTuong', [qdhosokhenthuongdoingoaiController::class, 'LayDoiTuong']);
        // Route::get('InQuyetDinh', [qdhosokhenthuongdoingoaiController::class, 'InQuyetDinh']);
        // Route::post('InBangKhen', [qdhosokhenthuongdoingoaiController::class, 'InBangKhen']);
        // Route::post('InGiayKhen', [qdhosokhenthuongdoingoaiController::class, 'InGiayKhen']);

        Route::get('InHoSo', [qdhosokhenthuongdoingoaiController::class, 'XemHoSo']);
        Route::get('InQuyetDinh', [qdhosokhenthuongdoingoaiController::class, 'InQuyetDinh']);

        Route::get('InPhoi', [qdhosokhenthuongdoingoaiController::class, 'InPhoi']);
        Route::post('NoiDungKhenThuong', [qdhosokhenthuongdoingoaiController::class, 'NoiDungKhenThuong']);
        Route::get('InBangKhenCaNhan', [qdhosokhenthuongdoingoaiController::class, 'InBangKhenCaNhan']);
        Route::get('InBangKhenTapThe', [qdhosokhenthuongdoingoaiController::class, 'InBangKhenTapThe']);
        Route::get('InGiayKhenCaNhan', [qdhosokhenthuongdoingoaiController::class, 'InGiayKhenCaNhan']);
        Route::get('InGiayKhenTapThe', [qdhosokhenthuongdoingoaiController::class, 'InGiayKhenTapThe']);
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

use App\Http\Controllers\NghiepVu\KhenThuongChuyenDe\dshosokhenthuongchuyendeController;
use App\Http\Controllers\NghiepVu\KhenThuongChuyenDe\qdhosokhenthuongchuyendeController;
use App\Http\Controllers\NghiepVu\KhenThuongChuyenDe\xdhosokhenthuongchuyendeController;

//Khen thưởng chuyên đề
Route::group(['prefix' => 'KhenThuongChuyenDe'], function () {
    Route::group(['prefix' => 'HoSo'], function () {
        Route::get('ThongTin', [dshosokhenthuongchuyendeController::class, 'ThongTin']);
        Route::post('Them', [dshosokhenthuongchuyendeController::class, 'Them']);
        Route::get('Sua', [dshosokhenthuongchuyendeController::class, 'ThayDoi']);
        Route::post('Sua', [dshosokhenthuongchuyendeController::class, 'LuuHoSo']);
        Route::get('InHoSo', [dshosokhenthuongchuyendeController::class, 'XemHoSo']);
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
        Route::get('LayTieuChuan', [dshosokhenthuongchuyendeController::class, 'LayTieuChuan']);
        Route::get('LayDoiTuong', [dshosokhenthuongchuyendeController::class, 'LayDoiTuong']);
    });

    Route::group(['prefix' => 'XetDuyet'], function () {
        Route::get('ThongTin', [xdhosokhenthuongchuyendeController::class, 'ThongTin']);
        Route::post('TraLai', [xdhosokhenthuongchuyendeController::class, 'TraLai']);
        Route::post('NhanHoSo', [xdhosokhenthuongchuyendeController::class, 'NhanHoSo']);
        Route::post('ChuyenHoSo', [xdhosokhenthuongchuyendeController::class, 'ChuyenHoSo']);

        Route::get('XetKT', [xdhosokhenthuongchuyendeController::class, 'XetKT']);
        Route::post('ThemTapThe', [xdhosokhenthuongchuyendeController::class, 'ThemTapThe']);
        Route::post('ThemCaNhan', [xdhosokhenthuongchuyendeController::class, 'ThemCaNhan']);
        Route::post('GanKhenThuong', [xdhosokhenthuongchuyendeController::class, 'GanKhenThuong']);
        Route::get('QuyetDinh', [xdhosokhenthuongchuyendeController::class, 'QuyetDinh']);
        Route::get('TaoDuThao', [xdhosokhenthuongchuyendeController::class, 'DuThaoQuyetDinh']);
        Route::post('QuyetDinh', [xdhosokhenthuongchuyendeController::class, 'LuuQuyetDinh']);
        Route::post('PheDuyet', [xdhosokhenthuongchuyendeController::class, 'PheDuyet']);
        Route::get('LayLyDo', [xdhosokhenthuongchuyendeController::class, 'LayLyDo']);
    });
    Route::group(['prefix' => 'KhenThuong'], function () {
        Route::get('ThongTin', [qdhosokhenthuongchuyendeController::class, 'ThongTin']);
        Route::post('Them', [qdhosokhenthuongchuyendeController::class, 'Them']);
        Route::get('Sua', [qdhosokhenthuongchuyendeController::class, 'Sua']);
        Route::post('Sua', [qdhosokhenthuongchuyendeController::class, 'LuuHoSo']);
        Route::post('Xoa', [qdhosokhenthuongchuyendeController::class, 'XoaHoSo']);

        Route::post('ThemTapThe', [qdhosokhenthuongchuyendeController::class, 'ThemTapThe']);
        Route::get('XoaTapThe', [qdhosokhenthuongchuyendeController::class, 'XoaTapThe']);
        Route::post('NhanExcelTapThe', [qdhosokhenthuongchuyendeController::class, 'NhanExcelTapThe']);
        Route::post('ThemCaNhan', [qdhosokhenthuongchuyendeController::class, 'ThemCaNhan']);
        Route::get('XoaCaNhan', [qdhosokhenthuongchuyendeController::class, 'XoaCaNhan']);
        Route::post('NhanExcelCaNhan', [qdhosokhenthuongchuyendeController::class, 'NhanExcelCaNhan']);
        Route::post('NhanExcelDeTai', [qdhosokhenthuongchuyendeController::class, 'NhanExcelDeTai']);


        Route::get('XetKT', [qdhosokhenthuongchuyendeController::class, 'XetKT']);
        Route::get('QuyetDinh', [qdhosokhenthuongchuyendeController::class, 'QuyetDinh']);
        Route::get('TaoDuThao', [qdhosokhenthuongchuyendeController::class, 'DuThaoQuyetDinh']);
        Route::post('QuyetDinh', [qdhosokhenthuongchuyendeController::class, 'LuuQuyetDinh']);
        Route::post('PheDuyet', [qdhosokhenthuongchuyendeController::class, 'PheDuyet']);
        Route::post('GanKhenThuong', [qdhosokhenthuongchuyendeController::class, 'GanKhenThuong']);
        Route::post('HuyPheDuyet', [qdhosokhenthuongchuyendeController::class, 'HuyPheDuyet']);
        Route::post('TraLai', [qdhosokhenthuongchuyendeController::class, 'TraLai']);

        //In dữ liệu
        Route::post('LayDoiTuong', [qdhosokhenthuongchuyendeController::class, 'LayDoiTuong']);
        Route::get('InQuyetDinh', [qdhosokhenthuongchuyendeController::class, 'InQuyetDinh']);
        Route::get('InHoSo', [qdhosokhenthuongchuyendeController::class, 'XemHoSo']);

        Route::get('InPhoi', [qdhosokhenthuongchuyendeController::class, 'InPhoi']);
        Route::post('NoiDungKhenThuong', [qdhosokhenthuongchuyendeController::class, 'NoiDungKhenThuong']);
        Route::get('InBangKhenCaNhan', [qdhosokhenthuongchuyendeController::class, 'InBangKhenCaNhan']);
        Route::get('InBangKhenTapThe', [qdhosokhenthuongchuyendeController::class, 'InBangKhenTapThe']);
        Route::get('InGiayKhenCaNhan', [qdhosokhenthuongchuyendeController::class, 'InGiayKhenCaNhan']);
        Route::get('InGiayKhenTapThe', [qdhosokhenthuongchuyendeController::class, 'InGiayKhenTapThe']);
    });
});
