<?php

Route::group(['prefix'=>'QuanLyVanBan'], function(){
    Route::group(['prefix'=>'VanBanPhapLy'], function(){
        Route::get('ThongTin','VanBan\dsvanbanphaplyController@ThongTin');
        Route::get('Them','VanBan\dsvanbanphaplyController@Them');
        Route::get('Sua','VanBan\dsvanbanphaplyController@ThayDoi');
        Route::post('Sua','VanBan\dsvanbanphaplyController@LuuHoSo');
        Route::post('Xoa','VanBan\dsvanbanphaplyController@XoaHoSo'); 
        Route::get('dinhkem','VanBan\dsvanbanphaplyController@show_dinhkem');
    });

    Route::group(['prefix'=>'KhenThuong'], function(){
        Route::get('ThongTin','VanBan\dsquyetdinhkhenthuongController@ThongTin');
        Route::get('Them','VanBan\dsquyetdinhkhenthuongController@Them');
        Route::get('Sua','VanBan\dsquyetdinhkhenthuongController@ThayDoi');
        Route::post('Sua','VanBan\dsquyetdinhkhenthuongController@LuuHoSo');
        Route::post('Xoa','VanBan\dsquyetdinhkhenthuongController@XoaHoSo'); 
        Route::get('dinhkem','VanBan\dsquyetdinhkhenthuongController@show_dinhkem');
    });
    
});


