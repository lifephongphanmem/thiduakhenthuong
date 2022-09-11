<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/5/2018
 * Time: 3:05 PM
 */

function getTenTrangThaiPT($trangthai){
    $a_trangthai = array(
        'DKT' => 'Đã khen thưởng',
        'DXKT' => 'Đang xét khen thưởng',
        'CC' => 'Đang phát động',
    );
    return $a_trangthai[$trangthai] ?? $trangthai;
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


function getPhanLoaiPhongTraoThiDua($all = false)
{
    $a_kq = array(
        'CHUYENDE' => 'Phong trào thi đua thường xuyên',
        'DOT' => 'Phong trào thi đua theo đợt',
        'HANGNAM' => 'Phong trào thi đua hàng năm',
        'NAMNAM' => 'Phong trào thi đua 05 năm',
        'KHAC' => 'Phong trào thi đua khác',
    );
    if ($all == true) {
        return array_merge(['ALL' => 'Tất cả'], $a_kq);
    }
    return $a_kq;
}

function getPhanLoaiDonVi_DiaBan()
{
    return array(
        //'ADMIN'=>'Đơn vị tổng hợp toàn Tỉnh',
        'T' => 'Đơn vị hành chính cấp Tỉnh',
        'H' => 'Đơn vị hành chính cấp Thành phố, Huyện',
        'X' => 'Đơn vị hành chính cấp Xã, Phường, Thị trấn',
    );
}

function getPhanLoaiDonViCumKhoi()
{
    return array(
        'TRUONGKHOI' => 'Trưởng cụm, khối',
        'PHOKHOI' => 'Phó trưởng cụm, khối',
        'THANHVIEN' => 'Thành viên',
    );
}

function getPhamViApDung()
{
    return array(
        //'ADMIN'=>'Đơn vị tổng hợp toàn Tỉnh',
        'TW' => 'Cấp Trung ương',
        'T' => 'Cấp Tỉnh',
        'H' => 'Cấp Thành phố, Thị xã, Huyện',
        'X' => 'Cấp Xã, Phường, Thị trấn',
    );
}

function getPhanLoaiDonVi()
{
    return array(
        'TONGHOP' => 'Đơn vị tổng hợp dữ liệu',
        'NHAPLIEU' => 'Đơn vị nhập liệu',
        'QUANTRI' => 'Đơn vị quản trị hệ thống',
    );
}

function getPhanLoaiTDKT()
{
    return array(
        'CANHAN' => 'Danh hiệu thi đua đối với cá nhân',
        'TAPTHE' => 'Danh hiệu thi đua đối với tập thể',
        'HOGIADINH' => 'Danh hiệu thi đua đối với hộ gia đình',
    );
}

function getPhanLoaiHinhThucKT()
{
    return array(
        'HUANCHUONG' => 'Huân chương',
        'HUYCHUONG' => 'Huy chương',
        'DANHHIEUNN' => 'Danh hiệu vinh dự Nhà nước',
        'GIAITHUONG' => 'Giải thưởng Hồ Chí Minh, Giải thưởng Nhà nước',
        'KYNIEMCHUONG' => 'Kỷ niệm chương, Huy hiệu',
        'BANGKHEN' => 'Bằng khen',
        'GIAYKHEN' => 'Giấy khen',
    );
}

function getPhamViPhongTrao($capdo = 'T')
{
    // return array(
    //     'CUNGCAP' => 'Các đơn vị trong cùng cấp quản lý (cùng địa bàn quản lý)',
    //     'CAPDUOI' => 'Các đơn vị cấp dưới quản lý trực tiếp',
    //     'TOANTINH' => 'Toàn bộ các đơn vị trong Tỉnh',
    //     'TRUNGUONG' => 'Phong trào thi đua cấp TW',
    // );
    $a_kq['T'] =  array(
        'CAPXA' => 'Phong trào thi đua cấp Xã',
        'CAPHUYEN' => 'Phong trào thi đua cấp Huyện',
        'TOANTINH' => 'Phong trào thi đua cấp Tỉnh',
        'TRUNGUONG' => 'Phong trào thi đua cấp Trung Ương',
    );
    $a_kq['H'] =  array(
        'CAPXA' => 'Phong trào thi đua cấp Xã',
        'CAPHUYEN' => 'Phong trào thi đua cấp Huyện',
    );
    $a_kq['X'] =  array(
        'CAPXA' => 'Phong trào thi đua cấp Xã',
    );
    return $a_kq[$capdo];
}

function getTrangThaiTDKT()
{
    return array(
        'CHUABATDAU' => 'Chưa bắt đầu nhận hồ sơ',
        'DANGNHAN' => 'Đang nhận hồ sơ',
        'DXKT' => 'Đang xét khen thưởng',
        'KETTHUC' => 'Đã kết thúc nhận hồ sơ',
    );
}

function getGioiTinh()
{
    return array(
        'NAM' => 'Nam',
        'NU' => 'Nữ',
        'KHAC' => 'Khác',
    );
}

function getLoaiVanBan()
{
    $vbqlnn = array(
        'luat' => 'Luật',
        'nghidinh' => 'Nghị định',
        'nghiquyet' => 'Nghị quyết',
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

function getThoiDiem()
{
    return [
        '06THANGDAUNAM' => 'Báo cáo 06 tháng đầu năm',
        '06THANGCUOINAM' => 'Báo cáo 06 tháng cuối năm',
        'CANAM' => 'Báo cáo cả năm',
        '05NAM' => 'Báo cáo 05 năm',
        'quy1' => 'Quý I',
        'quy2' => 'Quý II',
        'quy3' => 'Quý III',
        'quy4' => 'Quý IV',
        'thang01' => 'Tháng 01',
        'thang02' => 'Tháng 02',
        'thang03' => 'Tháng 03',
        'thang04' => 'Tháng 04',
        'thang05' => 'Tháng 05',
        'thang06' => 'Tháng 06',
        'thang07' => 'Tháng 07',
        'thang08' => 'Tháng 08',
        'thang09' => 'Tháng 09',
        'thang10' => 'Tháng 10',
        'thang11' => 'Tháng 11',
        'thang12' => 'Tháng 12',
    ];
}

function getThang($all = false)
{
    $a_tl = array(
        '01' => '01', '02' => '02', '03' => '03',
        '04' => '04', '05' => '05', '06' => '06',
        '07' => '07', '08' => '08', '09' => '09',
        '10' => '10', '11' => '11', '12' => '12'
    );
    if ($all)
        return array_merge(array('ALL' => '--Tất cả--'), $a_tl);
    else
        return $a_tl;
}

function getNam($all = false)
{
    $a_tl = $all == true ? array('ALL' => 'Tất cả') : array();
    for ($i = date('Y') - 2; $i <= date('Y') + 1; $i++) {
        $a_tl[$i] = $i;
    }
    return $a_tl;
}
