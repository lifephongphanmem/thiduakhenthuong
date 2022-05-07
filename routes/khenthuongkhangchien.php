<?php

Route::group(['prefix'=>'KhenThuongKhangChien'], function(){
    Route::group(['prefix'=>'ChongPhapCaNhan'], function(){
        Route::get('ThongTin','NghiepVu\KhenThuongKhangChien\ChongPhapCaNhan\dshosochongphap_canhanController@ThongTin');
        Route::get('Them','NghiepVu\KhenThuongKhangChien\ChongPhapCaNhan\dshosochongphap_canhanController@ThemHoSo');
        Route::post('Them','NghiepVu\KhenThuongKhangChien\ChongPhapCaNhan\dshosochongphap_canhanController@LuuHoSo');
        Route::get('Sua','NghiepVu\KhenThuongKhangChien\ChongPhapCaNhan\dshosochongphap_canhanController@SuaHoSo');
        Route::post('NhanHoSo','NghiepVu\KhenThuongKhangChien\ChongPhapCaNhan\dshosochongphap_canhanController@NhanHoSo');
        Route::get('Xem','NghiepVu\KhenThuongKhangChien\ChongPhapCaNhan\dshosochongphap_canhanController@XemHoSo');
    });
    Route::group(['prefix'=>'TongHop'], function(){
        Route::get('ThongTin','BaoCao\baocaotonghopController@ThongTin');
        Route::post('PhongTrao','BaoCao\baocaotonghopController@PhongTrao');
        Route::post('HoSo','BaoCao\baocaotonghopController@HoSo');
        Route::post('DanhHieu','BaoCao\baocaotonghopController@DanhHieu');
        Route::post('KhenThuong','BaoCao\baocaotonghopController@KhenThuong');
    });
});


