<?php

Route::group(['prefix'=>'BaoCao'], function(){
    Route::group(['prefix'=>'DonVi'], function(){
        Route::get('ThongTin','BaoCao\baocaodonviController@ThongTin');
        Route::post('CaNhan','BaoCao\baocaodonviController@CaNhan');
        Route::post('PhongTrao','BaoCao\baocaodonviController@PhongTrao');
        Route::post('TapThe','BaoCao\baocaodonviController@TapThe');
    });
    Route::group(['prefix'=>'TongHop'], function(){
        Route::get('ThongTin','BaoCao\baocaotonghopController@ThongTin');
        Route::post('PhongTrao','BaoCao\baocaotonghopController@PhongTrao');
        Route::post('HoSo','BaoCao\baocaotonghopController@HoSo');
        Route::post('DanhHieu','BaoCao\baocaotonghopController@DanhHieu');
        Route::post('KhenThuong','BaoCao\baocaotonghopController@KhenThuong');
        Route::post('Mau0701','BaoCao\baocaotonghopController@Mau0701');
        Route::post('Mau0702','BaoCao\baocaotonghopController@Mau0702');
        Route::post('Mau0703','BaoCao\baocaotonghopController@Mau0703');
    });
});


