<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/5/2018
 * Time: 3:05 PM
 */
function getdanhhieu()
{
    $danhhieu = \App\DanhMuc\dmdanhhieutd::all();
    $options = array();
    $options[''] = '--Chọn danh hiệu thi đua--';
    foreach ($danhhieu as $danhhieu) {
        $options[$danhhieu->madanhhieutd] = $danhhieu->tendanhhieutd;
    }
    return $options;
}
function getloaihinhkt()
{
    $loaihinhkt = \App\dmloaihinhkt::all();
    $options = array();
    $options[''] = '--Chọn loại hình khen thưởng--';
    foreach ($loaihinhkt as $loaihinhkt) {
        $options[$loaihinhkt->maloaihinhkt] = $loaihinhkt->tenloaihinhkt;
    }
    return $options;
}

function gethinhthuckt()
{
    $hinhthuckt = \App\dmhinhthuckt::all();
    $options = array();
    $options[''] = '--Chọn loại hình thức khen thưởng--';
    foreach ($hinhthuckt as $hinhthuckt) {
        $options[$hinhthuckt->mahinhthuckt] = $hinhthuckt->tenhinhthuckt;
    }
    return $options;
}

function getphanloaichi()
{
    $phanloai = \App\Model\manage\quytdkt\qldmchi::all();
    $options = array();
    $options[''] = '--Chọn loại hình khen thưởng--';
    foreach ($phanloai as $phanloai) {
        $options[$phanloai->madmchi] = $phanloai->noidung;
    }
    return $options;
}
function getphanloaiqd()
{
    $phanloai = \App\dmphanloaiqd::all();
    $options = array();
    foreach ($phanloai as $phanloai) {
        $options[$phanloai->maplqd] = $phanloai->tenplqd;
    }
    return $options;
}
function getphongtrao()
{
    $phanloai = \App\model\manage\qltailieu\qlphongtrao::all();
    $options = array();
    $options[''] = '--Chọn phong trào thi đua khen thưởng--';
    foreach ($phanloai as $phanloai) {
        $options[$phanloai->maphongtrao] = $phanloai->veviec;
    }
    return $options;
}

function getLoaiXe(){
    $a_loaixe = array(
        'Xe 4 chỗ' => 'Xe 4 chỗ',
        'Xe 5 chỗ' => 'Xe 5 chỗ',
        'Xe 7 chỗ' => 'Xe 7 chỗ',
        'Xe 16 chỗ' => 'Xe 16 chỗ',
        'Xe 29 chỗ' => 'Xe 29 chỗ',
        'Xe 35 chỗ' => 'Xe 35 chỗ',
        'Xe 45 chỗ' => 'Xe 45 chỗ',
        'Xe 47 chỗ' => 'Xe 47 chỗ',
        'Loại xe khác' => 'Loại xe khác'
    );
    return $a_loaixe ;
}

function getDiaDanhH(){
    $diadanhhs = \App\DiaBanHd::where('level','H')
        ->get();

    $options = array();
    $options[''] = '--Chọn địa bàn quản lý--';
    foreach ($diadanhhs as $diadanhh) {


        $options[$diadanhh->district] = $diadanhh->diaban;
    }
    return $options;
}

function getDtapdungdvlt(){
    $dtads = \App\DtAdDvLt::all();

    $options = array();
    $options['00'] = '--Chọn loại đối tượng áp dụng--';
    foreach ($dtads as $dtad) {
        $options[$dtad->madtad] = $dtad->tendtad;
    }
    return $options;
}

function getDvtDvLt(){
    $dvt = array(
        ''=>'--Chọn đơn vị tính--',
        'Đồng/giường/ngày đêm'=>'Đồng/giường/ngày đêm',
        'Đồng/phòng/ngày đêm'=>'Đồng/phòng/ngày đêm',
        'Đồng/phòng/tuần'=> 'Đồng/phòng/tuần',
        'Đồng/phòng/tháng'=> 'Đồng/phòng/tháng',
        'Đồng/căn hộ/ngày đêm'=>'Đồng/căn hộ/ngày đêm',
        'Đồng/căn hộ/tuần'=> 'Đồng/căn hộ/tuần' ,
        'Đồng/căn hộ/tháng'=>'Đồng/căn hộ/tháng',
    );
    return $dvt;
}

function getLoaiVbQlNn(){
    $vbqlnn = array(
        '' => '--Loại văn bản--',
        'luat' => 'Luật',
        'nghidinh'=>'Nghị định',
        'nghiquyet'=> 'Nghị quyết',
        'thongtu' => 'Thông tư',
        'quyetdinh' => 'Quyết định',
        'vbhd' => 'Văn bản hướng dẫn',
        'baocao' => 'Báo cáo tình hình giá trị trường',
        'tailieu' => 'Báo cáo, tài liệu học tập kinh nghiệm',
        'khoahoc' => 'Kết quả, đề tài nghiên cứu khoa học',
        'vbkhac' => 'Báo cáo, văn bản có liên quan khác',
    );
    return $vbqlnn;
}


?>