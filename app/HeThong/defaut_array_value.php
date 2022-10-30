<?php

use App\Model\DanhMuc\dsdonvi;

/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/5/2018
 * Time: 3:05 PM
 */

function getPhanLoaiHoSo()
{
    return array(
        'KHENTHUONG' => 'Hồ sơ khen thưởng theo địa bàn',
        'KTNGANH' => 'Hồ sơ khen thưởng theo ngành',
    );
}

function getPhamViKhenCao()
{
    return array(
        'H' => 'Hồ sơ khen cao cấp Huyện',
        'T' => 'Hồ sơ khen cao cấp Tỉnh',
        'TW' => 'Hồ sơ khen cao cấp TW',
    );
}

function getPhanLoaiHoSoKhenCao()
{
    return array(
        'CHINHPHU' => 'Hồ sơ cao của Chính phủ, Thủ tướng chính phủ',
        'CHUTICHNUOC' => 'Hồ sơ cao của Nhà nước, Chủ tịch nước',
    );
}

function getTaoQuyetDinhKT(&$model)
{
    if ($model->thongtinquyetdinh == '') {
        getTaoDuThaoKT($model);
    }
    $tendonvi = dsdonvi::where('madonvi', $model->madonvi)->first()->tendonvi ?? '';
    $model->thongtinquyetdinh = str_replace('[chucvunguoiky]', $model->chucvunguoikyqd, $model->thongtinquyetdinh);
    $model->thongtinquyetdinh = str_replace('[hotennguoiky]',  $model->hotennguoikyqd, $model->thongtinquyetdinh);
    $model->thongtinquyetdinh = str_replace('[soqd]',  $model->soqd, $model->thongtinquyetdinh);
    $model->thongtinquyetdinh = str_replace('[sototrinh]',  $model->sototrinh, $model->thongtinquyetdinh);
    $model->thongtinquyetdinh = str_replace('[diadanh]',  '......', $model->thongtinquyetdinh);
    $model->thongtinquyetdinh = str_replace('[ngayqd]',  Date2Str($model->ngayqd), $model->thongtinquyetdinh);
    $model->thongtinquyetdinh = str_replace('[ngayhoso]',  Date2Str($model->ngayhoso), $model->thongtinquyetdinh);
    $model->thongtinquyetdinh = str_replace('[donvidenghi]',  $tendonvi, $model->thongtinquyetdinh);
    $model->thongtinquyetdinh = str_replace('[donvikhenthuong]',  $model->donvikhenthuong, $model->thongtinquyetdinh);
}

function getTaoDuThaoKT(&$model, $maduthao = null)
{
    if ($model->thongtinquyetdinh == '') {
        if ($maduthao == null)
            $thongtinquyetdinh = App\Model\DanhMuc\duthaoquyetdinh::all()->first()->codehtml ?? '';
        else
            $thongtinquyetdinh = App\Model\DanhMuc\duthaoquyetdinh::where('maduthao', $maduthao)->first()->codehtml ?? '';
        $tendonvi = dsdonvi::where('madonvi', $model->madonvi)->first()->tendonvi ?? '';
        
        //Gán thông tin
        $thongtinquyetdinh = str_replace('[noidung]', $model->noidung, $thongtinquyetdinh);
        $thongtinquyetdinh = str_replace('[donvidenghi]',  $tendonvi, $thongtinquyetdinh);
        $thongtinquyetdinh = str_replace('[sototrinh]',  $model->sototrinh, $thongtinquyetdinh);
        $thongtinquyetdinh = str_replace('[ngayhoso]',  Date2Str($model->ngayhoso), $thongtinquyetdinh);

        $m_canhan = App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_canhan::where('mahosotdkt', $model->mahosotdkt)
            ->where('ketqua', '1')->orderby('stt')->get();
        if ($m_canhan->count() > 0) {
            $s_canhan = '';
            $i = 1;
            foreach ($m_canhan as $canhan) {
                $s_canhan .= '<p style=&#34;margin-left:40px;&#34;>' .
                    ($i++) . '. ' . $canhan->tendoituong .
                    ($canhan->chucvu == '' ? '' : ('; ' . $canhan->chucvu)) .
                    ($canhan->tencoquan == '' ? '' : ('; ' . $canhan->tencoquan)) .
                    '</p>';
                //dd($s_canhan);
            }
            //dd($s_canhan);
            // $thongtinquyetdinh = str_replace('<p style=&#34;margin-left:25px;&#34;>[khenthuongcanhan]</p>',  $s_canhan, $thongtinquyetdinh);
            $thongtinquyetdinh = str_replace('[khenthuongcanhan]',  $s_canhan, $thongtinquyetdinh);
        }

        //Tập thể
        $m_tapthe = App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_tapthe::where('mahosotdkt', $model->mahosotdkt)
            ->where('ketqua', '1')->orderby('stt')->get();
        if ($m_tapthe->count() > 0) {
            $s_tapthe = '';
            $i = 1;
            foreach ($m_tapthe as $chitiet) {
                $s_tapthe .= '<p style=&#34;margin-left:40px;&#34;>' .
                    ($i++) . '. ' . $chitiet->tentapthe .
                    '</p>';
            }
            $thongtinquyetdinh = str_replace('[khenthuongtapthe]',  $s_tapthe, $thongtinquyetdinh);
        }
        $model->thongtinquyetdinh = $thongtinquyetdinh;
    }
}


function getNganhLinhVuc()
{
    /*
    Điều 3 Nghị định 99/NQ-CP ngày 24/6/2020 quy định
    a) Ngành, lĩnh vực nội vụ, gồm: Tổ chức bộ máy hành chính nhà nước; đơn vị sự nghiệp công lập; tiền lương của cán bộ, công chức, viên chức, vị trí việc làm;

    b) Ngành, lĩnh vực tài nguyên và môi trường, gồm: Biển và hải đảo;

    c) Ngành, lĩnh vực thông tin và truyền thông, gồm: Phát thanh và truyền hình;

    d) Ngành, lĩnh vực văn hóa, gồm: Điện ảnh;

    đ) Ngành, lĩnh vực y tế, gồm: Khám bệnh, chữa bệnh;

    e) Ngành, lĩnh vực xây dựng, gồm: Hoạt động đầu tư xây dựng; kiến trúc; quy hoạch; phát triển đô thị;

    g) Ngành, lĩnh vực khoa học và công nghệ, gồm: Hoạt động khoa học và công nghệ;

    h) Ngành, lĩnh vực lao động, thương binh và xã hội, gồm: Quản lý người lao động Việt Nam đi làm việc ở nước ngoài theo hợp đồng; an toàn, vệ sinh lao động;

    i) Ngành, lĩnh vực tài chính, gồm: Thu ngân sách nhà nước; chi ngân sách nhà nước; quản lý nợ công; phí và lệ phí; tài sản công;

    k) Ngành, lĩnh vực kế hoạch và đầu tư, gồm: Quản lý đầu tư; đầu tư công; đầu tư nước ngoài.
    */
    $a_nganh = array(
        'NLVNOIVU' => 'Ngành, lĩnh vực nội vụ',
        'NLVTAINGHUYEN' => 'Ngành, lĩnh vực tài nguyên và môi trường',
        'NLVTHONGTIN' => 'Ngành, lĩnh vực thông tin và truyền thông',
        'NLVVANHOA' => 'Ngành, lĩnh vực văn hóa',
        'NLVYTE' => 'Ngành, lĩnh vực y tế',
        'NLVXAYDUNG' => 'Ngành, lĩnh vực xây dựng',
        'NLVKHOAHOC' => 'Ngành, lĩnh vực khoa học và công nghệ',
        'NLVLAODONG' => 'Ngành, lĩnh vực lao động, thương binh và xã hội',
        'NLVTAICHINH' => 'Ngành, lĩnh vực tài chính',
        'NLVKEHOACH' => 'Ngành, lĩnh vực kế hoạch và đầu tư',
        'NLVGDDT' => 'Ngành, lĩnh vực giáo dục và đào tạo',
        'NLVTDTT' => 'Ngành, lĩnh vực thể dục và thể thao',
        'NLVQLNN' => 'Ngành, lĩnh vực quản lý nhà nước',
    );
    return $a_nganh;
}

function getTenTrangThaiPT($trangthai)
{
    $a_trangthai = array(
        'DKT' => 'Đã khen thưởng',
        'DXKT' => 'Đang xét khen thưởng',
        'CC' => 'Đang phát động',
    );
    return $a_trangthai[$trangthai] ?? $trangthai;
}

function getLoaiVbQlNn()
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

function getTrangThaiVanBan()
{
    $vbqlnn = array(
        'CONHL' => 'Còn hiệu lực',
        'HETMP' => 'Hết hiệu lực một phần',
        'HETHL' => 'Hết hiệu lực',
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
        'CANHAN' => 'Áp dụng đối với cá nhân',
        'TAPTHE' => 'Áp dụng đối với tập thể',
        'HOGIADINH' => 'Áp dụng đối với hộ gia đình',
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
        'X' => 'Phong trào thi đua cấp Xã',
        'H' => 'Phong trào thi đua cấp Huyện',
        'T' => 'Phong trào thi đua cấp Tỉnh',
        'SBN' => 'Phong trào cho Sở, ban, ngành',
        'TW' => 'Phong trào thi đua cấp Trung Ương',
    );
    $a_kq['H'] =  array(
        'X' => 'Phong trào thi đua cấp Xã',
        'H' => 'Phong trào thi đua cấp Huyện',
    );
    $a_kq['X'] =  array(
        'X' => 'Phong trào thi đua cấp Xã',
    );
    return $a_kq[$capdo];
}

function getPhamViPhatDongPhongTrao($capdo = 'T')
{
    // return array(
    //     'CUNGCAP' => 'Các đơn vị trong cùng cấp quản lý (cùng địa bàn quản lý)',
    //     'CAPDUOI' => 'Các đơn vị cấp dưới quản lý trực tiếp',
    //     'TOANTINH' => 'Toàn bộ các đơn vị trong Tỉnh',
    //     'TRUNGUONG' => 'Phong trào thi đua cấp TW',
    // );
    $a_kq['T'] =  array(
        //'X' => 'Phong trào thi đua cấp Xã',
        //'H' => 'Phong trào thi đua cấp Huyện',
        'T' => 'Phong trào thi đua cấp Tỉnh',
        'SBN' => 'Phong trào cho Sở, ban, ngành',
        'TW' => 'Phong trào thi đua cấp Trung Ương',
    );
    $a_kq['H'] =  array(
        //'X' => 'Phong trào thi đua cấp Xã',
        'H' => 'Phong trào thi đua cấp Huyện',
    );
    $a_kq['X'] =  array(
        'X' => 'Phong trào thi đua cấp Xã',
    );
    return $a_kq[$capdo];
}

function getPhamViApDungPhongTrao($capdo = 'T')
{
    $a_kq['T'] =  array('T', 'TW', 'SBN');
    $a_kq['H'] =  array('H', 'T', 'TW',);
    $a_kq['X'] =  array('X', 'H', 'T', 'TW',);
    return $a_kq[$capdo];
}

function getPhamViThongKe($capdo = 'T')
{
    $a_kq['T'] =  array('T' => 'Các đơn vị hành chính cấp Tỉnh', 'H' => 'Các đơn vị hành chính cấp Huyện', 'X' => 'Các đơn vị hành chính cấp Xã');
    $a_kq['H'] =  array('H' => 'Các đơn vị hành chính cấp Huyện', 'X' => 'Các đơn vị hành chính cấp Xã');
    $a_kq['X'] =  array('X' => 'Các đơn vị hành chính cấp Xã');
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

function getTDChiTiet()
{
    // return [
    //     '06THANGDAUNAM' => ['tungay' => $nam . '-01-01', 'denngay' => $nam . '-06-30'],
    //     '06THANGCUOINAM' => ['tungay' => $nam . '-07-01', 'denngay' => $nam . '-12-31'],
    //     'CANAM' => ['tungay' => $nam . '-01-01', 'denngay' => $nam . '-12-31'],
    //     '05NAM' => ['tungay' => '2020-01-01', 'denngay' => $nam . '2025-12-31'],
    //     'quy1' => ['tungay' => $nam . '-01-01', 'denngay' => $nam . '-03-31'],
    //     'quy2' => ['tungay' => $nam . '-04-01', 'denngay' => $nam . '-06-30'],
    //     'quy3' => ['tungay' => $nam . '-07-01', 'denngay' => $nam . '-09-30'],
    //     'quy4' => ['tungay' => $nam . '-10-01', 'denngay' => $nam . '-12-31'],
    //     'thang01' => ['tungay' => $nam . '-01-01', 'denngay' => $nam . '-12-31'],
    //     'thang02' => ['tungay' => $nam . '-02-01', 'denngay' => $nam . '-12-31'],
    //     'thang03' => ['tungay' => $nam . '-03-01', 'denngay' => $nam . '-12-31'],
    //     'thang04' => ['tungay' => $nam . '-04-01', 'denngay' => $nam . '-12-31'],
    //     'thang05' => ['tungay' => $nam . '-05-01', 'denngay' => $nam . '-12-31'],
    //     'thang06' => ['tungay' => $nam . '-06-01', 'denngay' => $nam . '-12-31'],
    //     'thang07' => ['tungay' => $nam . '-07-01', 'denngay' => $nam . '-12-31'],
    //     'thang08' => ['tungay' => $nam . '-08-01', 'denngay' => $nam . '-12-31'],
    //     'thang09' => ['tungay' => $nam . '-09-01', 'denngay' => $nam . '-12-31'],
    //     'thang10' => ['tungay' => $nam . '-10-01', 'denngay' => $nam . '-12-31'],
    //     'thang11' => ['tungay' => $nam . '-11-01', 'denngay' => $nam . '-12-31'],
    //     'thang12' => ['tungay' => $nam . '-12-01', 'denngay' => $nam . '-12-31'],
    // ];
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

function getTrangThaiHoSo()
{
    return [
        'CC' => 'Chờ chuyển',
        'CD' => 'Chờ duyệt',
        'BTL' => 'Bị trả lại',
        'BTLXD' => 'Trả lại xét duyệt',
        'CXKT' => 'Chờ xét khen thưởng',
        'DKT' => 'Đã khen thưởng',
        'DXKT' => 'Đang xét khen thưởng',
        'DD' => 'Đã duyệt',
    ];
}

//Gán cho mặc định chức năg
function getTrangThaiChucNangHoSo($trangthai = 'ALL')
{
    $a_kq = [
        'CC' => 'Chờ chuyển', //=>Nộp hồ sơ bình thưởng
        'CXKT' => 'Chờ xét khen thưởng', //Đã gán madonvi_xd,madonvi_kt,
        'DKT' => 'Đã khen thưởng', //Đã gán madonvi_xd,madonvi_kt,
    ];
    return $trangthai == 'ALL' ? $a_kq : [$trangthai => $a_kq[$trangthai]];
}

function getTEST()
{
    return [
        'Hồ sơ' => ['CC' => 'Chờ chuyển',],
        'Xét duyệt' => ['CD' => 'Chờ duyệt', 'DD' => 'Đã duyệt',],
        'Phê duyệt' => ['CXKT' => 'Chờ xét khen thưởng', 'DKT' => 'Đã khen thưởng',],
    ];
}
