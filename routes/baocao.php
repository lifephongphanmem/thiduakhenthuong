<?php
use App\Http\Controllers\BaoCao\baocaodonviController;
use App\Http\Controllers\BaoCao\baocaotonghopController;
use Illuminate\Support\Facades\Route;
Route::group(['prefix'=>'BaoCao'], function(){
    Route::group(['prefix'=>'DonVi'], function(){
        Route::get('ThongTin', [baocaodonviController::class, 'ThongTin']);
        Route::post('CaNhan',[baocaodonviController::class, 'CaNhan']);
        Route::post('PhongTrao',[baocaodonviController::class, 'PhongTrao']);
        Route::post('TapThe',[baocaodonviController::class, 'TapThe']);
    });
    Route::group(['prefix'=>'TongHop'], function(){
        Route::get('ThongTin',[baocaotonghopController::class,'ThongTin']);
        Route::post('PhongTrao',[baocaotonghopController::class,'PhongTrao']);
        Route::post('HoSo',[baocaotonghopController::class,'HoSo']);
        Route::post('DanhHieu',[baocaotonghopController::class,'DanhHieu']);
        Route::post('KhenThuong_m1',[baocaotonghopController::class,'KhenThuong_m1']);
        Route::post('KhenThuong_m2',[baocaotonghopController::class,'KhenThuong_m2']);
        Route::post('KhenThuong_m3',[baocaotonghopController::class,'KhenThuong_m3']);
        Route::post('KhenCao_m1',[baocaotonghopController::class,'KhenCao_m1']);
        Route::post('KhenCao_m2',[baocaotonghopController::class,'KhenCao_m2']);
        Route::post('Mau0701',[baocaotonghopController::class,'Mau0701']);
        Route::post('Mau0702','BaoCao\baocaotonghopController@Mau0702');
        Route::post('Mau0703','BaoCao\baocaotonghopController@Mau0703');

        Route::post('QuyKhenThuong',[baocaotonghopController::class,'QuyKhenThuong']);
    });
});


