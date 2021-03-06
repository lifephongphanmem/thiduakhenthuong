<?php
//Đăng nhập
Route::get('DangNhap','HeThong\hethongchungController@DangNhap');
Route::post('DangNhap','HeThong\hethongchungController@XacNhanDangNhap');
Route::post('QuenMatKhau','HeThong\hethongchungController@QuenMatKhau');
Route::get('DangXuat','HeThong\hethongchungController@DangXuat');

Route::group(['prefix'=>'HeThongChung'], function(){
    Route::get('ThongTin','HeThong\hethongchungController@ThongTin');
    Route::get('ThayDoi','HeThong\hethongchungController@ThayDoi');
    Route::post('ThayDoi','HeThong\hethongchungController@LuuThayDoi');
});
Route::group(['prefix'=>'DiaBan'], function(){
    Route::get('ThongTin','HeThong\dsdiabanController@index');
    Route::post('Sua','HeThong\dsdiabanController@modify');
    Route::post('delete','HeThong\dsdiabanController@delete');
});

Route::group(['prefix'=>'DonVi'], function(){
    Route::get('ThongTin','HeThong\dsdonviController@ThongTin');
    Route::get('DanhSach','HeThong\dsdonviController@DanhSach');
    Route::get('Them','HeThong\dsdonviController@create');
    Route::post('Them','HeThong\dsdonviController@store');
    Route::get('Sua','HeThong\dsdonviController@edit');
    Route::post('Sua','HeThong\dsdonviController@store');
    Route::post('Xoa','HeThong\dsdonviController@destroy');
    Route::get('QuanLy','HeThong\dsdonviController@QuanLy');
    Route::post('QuanLy','HeThong\dsdonviController@LuuQuanLy');

});

Route::group(['prefix'=>'TaiKhoan'], function(){
    Route::get('ThongTin','HeThong\dstaikhoanController@ThongTin');
    Route::get('Them','HeThong\dstaikhoanController@create');
    Route::post('Them','HeThong\dstaikhoanController@store');
    Route::get('Sua','HeThong\dstaikhoanController@edit');

});
Route::group(['prefix'=>'HeThongAPI'], function(){
    Route::get('CaNhan','HeThong\HeThongAPIController@CaNhan');
    Route::get('TapThe','HeThong\HeThongAPIController@TapThe');
    Route::get('PhongTrao','HeThong\HeThongAPIController@PhongTrao');
});

Route::group(['prefix'=>'ChucNang'], function(){
    Route::get('ThongTin','HeThong\dschucnangController@ThongTin');
    Route::post('ThongTin','HeThong\dschucnangController@LuuChucNang');
    Route::get('LayChucNang','HeThong\dschucnangController@LayChucNang');
});