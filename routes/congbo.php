<?php

Route::group(['prefix'=>'CongBo'], function(){
    Route::get('VanBan','HeThong\congboController@VanBan');
    Route::get('QuyetDinh','HeThong\congboController@QuyetDinh');
    
});


