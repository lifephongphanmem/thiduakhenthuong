<?php
//Phong trào thi đua
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'PhongTraoThiDua'], function () {
    Route::get('ThongTin', 'NghiepVu\ThiDuaKhenThuong\dsphongtraothiduaController@ThongTin');
    Route::get('Xem', 'NghiepVu\ThiDuaKhenThuong\dsphongtraothiduaController@XemThongTin');
    Route::get('Them', 'NghiepVu\ThiDuaKhenThuong\dsphongtraothiduaController@ThayDoi');
    Route::post('Them', 'NghiepVu\ThiDuaKhenThuong\dsphongtraothiduaController@LuuPhongTrao');
    Route::get('Sua', 'NghiepVu\ThiDuaKhenThuong\dsphongtraothiduaController@ThayDoi');
    Route::post('Sua', 'NghiepVu\ThiDuaKhenThuong\dsphongtraothiduaController@LuuPhongTrao');

    Route::get('ThemKhenThuong', 'NghiepVu\ThiDuaKhenThuong\dsphongtraothiduaController@ThemKhenThuong');
    Route::get('ThemTieuChuan', 'NghiepVu\ThiDuaKhenThuong\dsphongtraothiduaController@ThemTieuChuan');
    Route::get('LayTieuChuan', 'NghiepVu\ThiDuaKhenThuong\dsphongtraothiduaController@LayTieuChuan');
    Route::get('XoaTieuChuan', 'NghiepVu\ThiDuaKhenThuong\dsphongtraothiduaController@XoaTieuChuan');
    Route::get('TaiLieuDinhKem', 'NghiepVu\ThiDuaKhenThuong\dsphongtraothiduaController@TaiLieuDinhKem');

    //Route::get('Sua','system\DSTaiKhoanController@edit');
});

Route::group(['prefix' => 'HoSoThiDua'], function () {
    Route::get('ThongTin', 'NghiepVu\ThiDuaKhenThuong\dshosothiduaController@ThongTin');
    Route::get('Them', 'NghiepVu\ThiDuaKhenThuong\dshosothiduaController@ThemHoSo');
    Route::post('Them', 'NghiepVu\ThiDuaKhenThuong\dshosothiduaController@LuuHoSo');
    Route::get('Sua', 'NghiepVu\ThiDuaKhenThuong\dshosothiduaController@ThayDoi');
    Route::post('Sua', 'NghiepVu\ThiDuaKhenThuong\dshosothiduaController@LuuHoSo');
    Route::get('Xem', 'NghiepVu\ThiDuaKhenThuong\dshosothiduaController@XemHoSo');
    Route::post('Xoa', 'NghiepVu\ThiDuaKhenThuong\dshosothiduaController@XoaHoSo');

    Route::get('ThemDoiTuong', 'NghiepVu\ThiDuaKhenThuong\dshosothiduaController@ThemDoiTuong');
    Route::get('ThemDoiTuongTapThe', 'NghiepVu\ThiDuaKhenThuong\dshosothiduaController@ThemDoiTuongTapThe');
    Route::get('LayDoiTuong', 'NghiepVu\ThiDuaKhenThuong\dshosothiduaController@LayDoiTuong');

    Route::get('LayTieuChuan', 'NghiepVu\ThiDuaKhenThuong\dshosothiduaController@LayTieuChuan');
    Route::get('LuuTieuChuan', 'NghiepVu\ThiDuaKhenThuong\dshosothiduaController@LuuTieuChuan');
    Route::post('ChuyenHoSo', 'NghiepVu\ThiDuaKhenThuong\dshosothiduaController@ChuyenHoSo');
    Route::post('delete', 'NghiepVu\ThiDuaKhenThuong\dshosothiduaController@delete');
    Route::get('LayLyDo', 'NghiepVu\ThiDuaKhenThuong\dshosothiduaController@LayLyDo');
    Route::get('XoaDoiTuong', 'NghiepVu\ThiDuaKhenThuong\dshosothiduaController@XoaDoiTuong');    
    Route::get('TaiLieuDinhKem', 'NghiepVu\ThiDuaKhenThuong\dshosothiduaController@TaiLieuDinhKem');
});

Route::group(['prefix' => 'XetDuyetHoSoThiDua'], function () {
    Route::get('ThongTin', 'NghiepVu\ThiDuaKhenThuong\xetduyethosothiduaController@ThongTin');
    Route::get('DanhSach', 'NghiepVu\ThiDuaKhenThuong\xetduyethosothiduaController@DanhSach');
    Route::post('TraLai', 'NghiepVu\ThiDuaKhenThuong\xetduyethosothiduaController@TraLai');
    Route::get('Xem', 'NghiepVu\ThiDuaKhenThuong\xetduyethosothiduaController@XemDanhSach');
    Route::post('ChuyenHoSo', 'NghiepVu\ThiDuaKhenThuong\xetduyethosothiduaController@ChuyenHoSo');
    Route::post('NhanHoSo', 'NghiepVu\ThiDuaKhenThuong\xetduyethosothiduaController@NhanHoSo');    
});

Route::group(['prefix' => 'KhenThuongHoSoThiDua'], function () {
    Route::get('ThongTin', 'NghiepVu\ThiDuaKhenThuong\khenthuonghosothiduaController@ThongTin');
    Route::post('KhenThuong', 'NghiepVu\ThiDuaKhenThuong\khenthuonghosothiduaController@KhenThuong');
    Route::get('DanhSach', 'NghiepVu\ThiDuaKhenThuong\khenthuonghosothiduaController@DanhSach');
    Route::post('LuuHoSo', 'NghiepVu\ThiDuaKhenThuong\khenthuonghosothiduaController@LuuHoSo');
    Route::get('Xem', 'NghiepVu\ThiDuaKhenThuong\khenthuonghosothiduaController@XemHoSo');

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
    Route::get('TaiLieuDinhKem', 'NghiepVu\ThiDuaKhenThuong\dshosothiduaController@TaiLieuDinhKem');

    //In dữ liệu
    Route::post('LayDoiTuong', 'NghiepVu\ThiDuaKhenThuong\khenthuonghosothiduaController@LayDoiTuong');
    Route::post('InBangKhen', 'NghiepVu\ThiDuaKhenThuong\khenthuonghosothiduaController@InBangKhen');
    Route::post('InGiayKhen', 'NghiepVu\ThiDuaKhenThuong\khenthuonghosothiduaController@InGiayKhen');
});
//

//Khen thưởng theo công trạng
Route::group(['prefix' => 'KhenThuongCongTrang'], function () {
    Route::group(['prefix' => 'HoSo'], function () {
        Route::get('ThongTin', 'NghiepVu\KhenThuongCongTrang\dshosokhenthuongcongtrangController@ThongTin');
        Route::post('Them', 'NghiepVu\KhenThuongCongTrang\dshosokhenthuongcongtrangController@Them');
        Route::get('Sua', 'NghiepVu\KhenThuongCongTrang\dshosokhenthuongcongtrangController@ThayDoi');
        Route::post('Sua', 'NghiepVu\KhenThuongCongTrang\dshosokhenthuongcongtrangController@LuuHoSo');
        Route::get('Xem', 'NghiepVu\KhenThuongCongTrang\dshosokhenthuongcongtrangController@XemHoSo');
        Route::post('Xoa', 'NghiepVu\KhenThuongCongTrang\dshosokhenthuongcongtrangController@XoaHoSo');
        Route::post('NhanExcel', 'NghiepVu\KhenThuongCongTrang\dshosokhenthuongcongtrangController@NhanExcel');

        Route::post('CaNhan', 'NghiepVu\KhenThuongCongTrang\dshosokhenthuongcongtrangController@ThemCaNhan');
        Route::post('TapThe', 'NghiepVu\KhenThuongCongTrang\dshosokhenthuongcongtrangController@ThemTapThe');
        Route::get('LayTieuChuan', 'NghiepVu\KhenThuongCongTrang\dshosokhenthuongcongtrangController@LayTieuChuan');
        Route::get('LayDoiTuong', 'NghiepVu\KhenThuongCongTrang\dshosokhenthuongcongtrangController@LayDoiTuong');
        Route::post('ChuyenHoSo', 'NghiepVu\KhenThuongCongTrang\dshosokhenthuongcongtrangController@ChuyenHoSo');
        Route::get('LayLyDo', 'NghiepVu\KhenThuongCongTrang\dshosokhenthuongcongtrangController@LayLyDo');
        Route::post('XoaDoiTuong', 'NghiepVu\KhenThuongCongTrang\dshosokhenthuongcongtrangController@XoaDoiTuong');
    });

    Route::group(['prefix' => 'XetDuyet'], function () {
        Route::get('ThongTin', 'NghiepVu\KhenThuongCongTrang\xdhosokhenthuongcongtrangController@ThongTin');
        Route::post('TraLai', 'NghiepVu\KhenThuongCongTrang\xdhosokhenthuongcongtrangController@TraLai');
        Route::post('NhanHoSo', 'NghiepVu\KhenThuongCongTrang\xdhosokhenthuongcongtrangController@NhanHoSo');
        Route::post('ChuyenHoSo', 'NghiepVu\KhenThuongCongTrang\xdhosokhenthuongcongtrangController@ChuyenHoSo');
    });
    Route::group(['prefix' => 'KhenThuong'], function () {
        Route::get('ThongTin', 'NghiepVu\KhenThuongCongTrang\qdhosokhenthuongcongtrangController@ThongTin');
        Route::post('KhenThuong', 'NghiepVu\KhenThuongCongTrang\qdhosokhenthuongcongtrangController@KhenThuong');
        Route::get('DanhSach', 'NghiepVu\KhenThuongCongTrang\qdhosokhenthuongcongtrangController@DanhSach');
        Route::post('DanhSach', 'NghiepVu\KhenThuongCongTrang\qdhosokhenthuongcongtrangController@LuuHoSo');
        Route::post('PheDuyet', 'NghiepVu\KhenThuongCongTrang\qdhosokhenthuongcongtrangController@PheDuyet');
        Route::post('HoSo', 'NghiepVu\KhenThuongCongTrang\qdhosokhenthuongcongtrangController@HoSo');
        Route::post('KetQua', 'NghiepVu\KhenThuongCongTrang\qdhosokhenthuongcongtrangController@KetQua');
        Route::get('LayDoiTuong', 'NghiepVu\KhenThuongCongTrang\qdhosokhenthuongcongtrangController@LayDoiTuong');
        Route::get('LayTieuChuan', 'NghiepVu\KhenThuongCongTrang\qdhosokhenthuongcongtrangController@LayTieuChuan');
        Route::get('Xem', 'NghiepVu\KhenThuongCongTrang\qdhosokhenthuongcongtrangController@XemHoSo');

        Route::get('InKetQua', 'NghiepVu\KhenThuongCongTrang\qdhosokhenthuongcongtrangController@InKetQua');
        Route::get('MacDinhQuyetDinh', 'NghiepVu\KhenThuongCongTrang\qdhosokhenthuongcongtrangController@MacDinhQuyetDinh');
        Route::get('QuyetDinh', 'NghiepVu\KhenThuongCongTrang\qdhosokhenthuongcongtrangController@QuyetDinh');
        Route::post('QuyetDinh', 'NghiepVu\KhenThuongCongTrang\qdhosokhenthuongcongtrangController@LuuQuyetDinh');
        Route::get('XemQuyetDinh', 'NghiepVu\KhenThuongCongTrang\qdhosokhenthuongcongtrangController@XemQuyetDinh');
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
    });

    Route::group(['prefix' => 'XetDuyet'], function () {
        Route::get('ThongTin', 'NghiepVu\KhenThuongDotXuat\xdhosokhenthuongdotxuatController@ThongTin');
        Route::post('TraLai', 'NghiepVu\KhenThuongDotXuat\xdhosokhenthuongdotxuatController@TraLai');
        Route::post('NhanHoSo', 'NghiepVu\KhenThuongDotXuat\xdhosokhenthuongdotxuatController@NhanHoSo');
        Route::post('ChuyenHoSo', 'NghiepVu\KhenThuongDotXuat\xdhosokhenthuongdotxuatController@ChuyenHoSo');
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

        Route::get('Xem', 'NghiepVu\KhenThuongDotXuat\qdhosokhenthuongdotxuatController@XemHoSo');
    });
});
//
//Khen cao
Route::group(['prefix' => 'KhenCao'], function () {
    Route::group(['prefix' => 'HoSo'], function () {
        Route::get('ThongTin', 'NghiepVu\KhenCao\dshosokhencaoController@ThongTin');
        Route::post('Them', 'NghiepVu\KhenCao\dshosokhencaoController@Them');
        Route::get('Sua', 'NghiepVu\KhenCao\dshosokhencaoController@ThayDoi');
        Route::post('Sua', 'NghiepVu\KhenCao\dshosokhencaoController@LuuHoSo');
        Route::get('Xem', 'NghiepVu\KhenCao\dshosokhencaoController@XemHoSo');

        Route::post('CaNhan', 'NghiepVu\KhenCao\dshosokhencaoController@ThemCaNhan');
        Route::post('TapThe', 'NghiepVu\KhenCao\dshosokhencaoController@ThemTapThe');
        Route::get('LayDoiTuong', 'NghiepVu\KhenCao\dshosokhencaoController@LayDoiTuong');
        Route::post('NhanHoSo', 'NghiepVu\KhenCao\dshosokhencaoController@NhanHoSo');
    });
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
        Route::get('Xem', [dshosokhenthuongconghienController::class, 'InHoSo']);
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
    });
});
