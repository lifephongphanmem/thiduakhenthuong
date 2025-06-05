<?php

use App\Http\Controllers\TraCuu\tracuucanhanController;
use App\Http\Controllers\TraCuu\tracuukhencaoController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'TraCuu'], function () {
    Route::group(['prefix' => 'DungChung'], function () {
        Route::get('LayDonVi', [tracuucanhanController::class, 'ThongTin']);
    });

    Route::group(['prefix' => 'CaNhan'], function () {
        Route::get('ThongTin', [tracuucanhanController::class, 'ThongTin']);
        Route::post('ThongTin', 'TraCuu\tracuucanhanController@KetQua');
        Route::post('InKetQua', 'TraCuu\tracuucanhanController@InKetQua');
    });
    Route::group(['prefix' => 'TapThe'], function () {
        Route::get('ThongTin', 'TraCuu\tracuutaptheController@ThongTin');
        Route::post('ThongTin', 'TraCuu\tracuutaptheController@KetQua');
        Route::post('InKetQua', 'TraCuu\tracuutaptheController@InKetQua');
    });
    Route::group(['prefix' => 'PhongTrao'], function () {
        Route::get('ThongTin', 'TraCuu\tracuuphongtraoController@ThongTin');
        Route::post('ThongTin', 'TraCuu\tracuuphongtraoController@KetQua');
        Route::post('InKetQua', 'TraCuu\tracuuphongtraoController@InKetQua');
    });
    Route::prefix('KhenCao')->group(function () {
        Route::prefix('CaNhan')->group(function () {
            Route::get('ThongTin', [tracuukhencaoController::class, 'ThongTinCaNhan']);
            Route::post('ThongTin', [tracuukhencaoController::class, 'KetQuaCaNhan']);
            Route::post('InKetQua', [tracuukhencaoController::class, 'InKetQuaCaNhan']);
        });
        Route::prefix('TapThe')->group(function () {
            Route::get('ThongTin', [tracuukhencaoController::class, 'ThongTinTapThe']);
            Route::post('ThongTin', [tracuukhencaoController::class, 'KetQuaTapThe']);
            Route::post('InKetQua', [tracuukhencaoController::class, 'InKetQuaTapThe']);
        });
    });
});
