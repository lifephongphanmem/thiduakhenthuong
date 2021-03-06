<?php

Route::group(['prefix'=>'TraCuu'], function(){
    Route::group(['prefix'=>'CaNhan'], function(){
        Route::get('ThongTin','TraCuu\tracuucanhanController@ThongTin');
        Route::post('ThongTin','TraCuu\tracuucanhanController@KetQua');
    });
    Route::group(['prefix'=>'TapThe'], function(){
        Route::get('ThongTin','TraCuu\tracuutaptheController@ThongTin');
        Route::post('ThongTin','TraCuu\tracuutaptheController@KetQua');
    });
    Route::group(['prefix'=>'PhongTrao'], function(){
        Route::get('ThongTin','TraCuu\tracuuphongtraoController@ThongTin');
        Route::post('ThongTin','TraCuu\tracuuphongtraoController@KetQua');
    });
});


