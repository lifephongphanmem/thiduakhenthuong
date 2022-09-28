<?php

use App\Http\Controllers\NghiepVu\KhenThuongKhangChien\ChongPhapCaNhan\dshosochongphap_canhanController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'KhenThuongKhangChien'], function () {
    Route::group(['prefix' => 'ChongPhapCaNhan'], function () {
        Route::get('ThongTin', [dshosochongphap_canhanController::class, 'ThongTin']);
        Route::get('Them', [dshosochongphap_canhanController::class, 'ThemHoSo']);
        Route::post('Them', [dshosochongphap_canhanController::class, 'LuuHoSo']);
        Route::get('Sua', [dshosochongphap_canhanController::class, 'SuaHoSo']);
        Route::post('NhanHoSo', [dshosochongphap_canhanController::class, 'NhanHoSo']);
        Route::get('Xem', [dshosochongphap_canhanController::class, 'XemHoSo']);
        Route::get('TaiLieuDinhKem', [dshosochongphap_canhanController::class, 'TaiLieuDinhKem']);
        Route::post('PheDuyet', [dshosochongphap_canhanController::class, 'PheDuyet']);
        Route::post('HuyPheDuyet', [dshosochongphap_canhanController::class, 'HuyPheDuyet']);
    });
});
