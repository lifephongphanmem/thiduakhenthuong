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
});


