<?php
function getQuyetDinhCKE($maso)
{
    $a_qd = [];
    $a_qd['QUYETDINH'] = "<figure class=&#34;table&#34;><table>
            <tbody>
                <tr><td><strong>ỦY BAN NHÂN DÂN</strong></td><td><p style=&#34;text-align:center;&#34;><strong>CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</strong></p></td></tr>
                <tr><td><strong>TỈNH QUẢNG BÌNH</strong></td><td><p style=&#34;text-align:center;&#34;><strong>Độc lập - Tự do - Hạnh phúc</strong></p></td></tr>
                <tr><td>Số: .....&nbsp;</td><td><p style=&#34;text-align:right;&#34;><i>Quảng Bình, ngày..... tháng ...... năm ........</i></p></td></tr>
                </tbody>
            </table></figure>
            <h2 style=&#34;text-align:center;&#34;><strong>QUYẾT ĐỊNH</strong></h2>
            <h4 style=&#34;text-align:center;&#34;>[noidung]</h4>
            <p style=&#34;text-align:center;&#34;><strong>CHỦ TỊCH ỦY BAN NHÂN DÂN TỈNH QUẢNG BÌNH</strong></p>
            <p style=&#34;margin-left:40px;text-align:justify;&#34;>Căn cứ Luật Tổ chức Chính quyền địa phương ngày 19/6/2015;</p>
            <p style=&#34;margin-left:40px;text-align:justify;&#34;>Căn cứ Luật Thi đua, Khen thưởng ngày 26/11/2003 và Luật sửa đổi, bổ sung một số Điều của Luật Thi đua, Khen thưởng ngày 16/11 /2013;</p>
            <p style=&#34;margin-left:40px;text-align:justify;&#34;>Căn cứ Nghị định số 91/2017/NĐ-CP ngày 31/7/2017 của Chính phủ quy định chi tiết thi hành một số Điều của Luật thi đua, khen thưởng;</p>
            <p style=&#34;margin-left:40px;text-align:justify;&#34;>Căn cứ Quyết định số 35/2019/QĐ-UBND ngày 11/11/2019 của UBND Tỉnh ban hành quy chế Quy chế Thi đua, khen thưởng Tỉnh Quảng Bình;</p>
            <p style=&#34;margin-left:40px;text-align:justify;&#34;>Xét đề nghị của ………………………………………………………; đề nghị của Trưởng Ban Thi đua Khen thưởng tỉnh tại Tờ trình số ……….. &nbsp;ngày ………………….,&nbsp;</p>
            <p style=&#34;margin-left:25px;text-align:center;&#34;><strong>QUYẾT ĐỊNH:</strong></p>
            <p style=&#34;margin-left:25px;&#34;><strong>Điều 1.</strong></p>
            <p style=&#34;margin-left:25px;&#34;><strong>Điều 2.</strong></p>
            <figure class=&#34;table newpage&#34;><table class=&#34;table newpage&#34;>
                <tbody>
                    <tr><td rowspan=&#34;4&#34;><p style=&#34;margin-left:25px;&#34;>Nơi nhận:</p><p style=&#34;margin-left:40px;&#34;>- Như điều 2</p><p style=&#34;margin-left:40px;&#34;>- Lưu VT, NC</p></td><td><p style=&#34;text-align:center;&#34;><strong>[chucvunguoiky]</strong></p></td></tr>
                    <tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr>
                    <tr><td><p style=&#34;text-align:center;&#34;><strong>[hotennguoiky]</strong></p></td></tr>
                </tbody></table></figure>
                <p>[sangtrangmoi]</p>
                <h3 style=&#34;margin-left:25px;text-align:center;&#34;>DANH SÁCH</h3>
                <p style=&#34;margin-left:25px;text-align:center;&#34;>(<i>Kèm theo quyết định số .... ngày .... tháng ..... năm..... của .....</i>)</p>
                <h4 style=&#34;margin-left:25px;&#34;>I. Cá nhân</h4>
                <p style=&#34;margin-left:25px;&#34;>[khenthuongcanhan]</p>
                <h4 style=&#34;margin-left:25px;&#34;>II. Tập thể</h4>
                <p style=&#34;margin-left:25px;&#34;>[khenthuongtapthe]</p>
                <p style=&#34;margin-left:65px;&#34;>&nbsp;</p>";

    return $a_qd[$maso];
}
function getHeThongChung()
{
    return  \App\Model\HeThong\hethongchung::all()->first() ?? new \App\Model\HeThong\hethongchung();
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

function getPhamViPhongTrao()
{
    return array(
        'CUNGCAP' => 'Các đơn vị trong cùng cấp quản lý (cùng địa bàn quản lý)',
        'CAPDUOI' => 'Các đơn vị cấp dưới quản lý trực tiếp',
        'TOANTINH' => 'Toàn bộ các đơn vị trong Tỉnh',
        'TRUNGUONG' => 'Phong trào thi đua cấp TW',
    );
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
    // return [
    //     'nam'=>'Cả năm',
    //     'quy1'=>'Quý I',
    //     'quy2'=>'Quý II',
    //     'quy3'=>'Quý III',
    //     'quy4'=>'Quý IV',
    //     'thang01'=>'Tháng 01',
    //     'thang02'=>'Tháng 02',
    //     'thang03'=>'Tháng 03',
    //     'thang04'=>'Tháng 04',
    //     'thang05'=>'Tháng 05',
    //     'thang06'=>'Tháng 06',
    //     'thang07'=>'Tháng 07',
    //     'thang08'=>'Tháng 08',
    //     'thang09'=>'Tháng 09',
    //     'thang10'=>'Tháng 10',
    //     'thang11'=>'Tháng 11',
    //     'thang12'=>'Tháng 12',
    // ];
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

function getDoiTuongKhenCao()
{
    $m_hoso = \App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong::all('mahosotdkt');
    $model = \App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_khenthuong::wherein('mahosotdkt', $m_hoso->toarray())->where('phanloai', 'CANHAN')->get();
    return $model;
}

function getTapTheKhenCao()
{
    $m_hoso = \App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong::all('mahosotdkt');
    $model = \App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_khenthuong::wherein('mahosotdkt', $m_hoso->toarray())->where('phanloai', 'TAPTHE')->get();
    return $model;
}

function getDoiTuongKhenThuong($madonvi)
{
    $m_hoso = \App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong::where('madonvi', $madonvi)->get('mahosotdkt');
    $model = \App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_khenthuong::wherein('mahosotdkt', $m_hoso->toarray())->where('phanloai', 'CANHAN')->get();
    return $model;
}

function getTapTheKhenThuong($madonvi)
{
    $m_hoso = \App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong::where('madonvi', $madonvi)->get('mahosotdkt');
    $model = \App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_khenthuong::wherein('mahosotdkt', $m_hoso->toarray())->where('phanloai', 'TAPTHE')->get();
    return $model;
}

function getDiaBan_All($all = false)
{
    $a_diaban = array_column(\App\Model\DanhMuc\dsdiaban::all()->toarray(), 'tendiaban', 'madiaban');
    if ($all) {
        $a_kq = ['null' => '-- Chọn địa bàn --'];
        foreach ($a_diaban as $k => $v) {
            $a_kq[$k] = $v;
        }
        return $a_kq;
    }
    return $a_diaban;
}

function getDonViQuanLyDiaBan($madiaban, $kieudulieu = 'ARRAY')
{
    $m_diaban = \App\Model\DanhMuc\dsdiaban::where('madiaban', $madiaban)->first();
    $model = \App\Model\DanhMuc\dsdonvi::where('madonvi', $m_diaban->madonviQL)->get();
    switch ($kieudulieu) {
        case 'MODEL': {
                return $model;
                break;
            }
        default:
            return array_column($model->toarray(), 'tendonvi', 'madonvi');
    }
}

function getDonViCumKhoi($macumkhoi, $kieudulieu = 'ARRAY')
{
    $donvi = \App\Model\DanhMuc\dscumkhoi_chitiet::where('macumkhoi', $macumkhoi)->get();
    $model = \App\Model\DanhMuc\dsdonvi::wherein('madonvi', array_column($donvi->toarray(), 'madonvi'))->get();
    switch ($kieudulieu) {
        case 'MODEL': {
                return $model;
                break;
            }
        default:
            return array_column($model->toarray(), 'tendonvi', 'madonvi');
    }
}

function getDonViCK($capdo, $madonvi = null, $kieudulieu = 'ARRAY')
{
    $donvi = \App\Model\DanhMuc\dscumkhoi_chitiet::all();
    $model = \App\Model\DanhMuc\dsdonvi::wherein('madonvi', array_column($donvi->toarray(), 'madonvi'))->get();
    switch ($kieudulieu) {
        case 'MODEL': {
                return $model;
                break;
            }
        default:
            return array_column($model->toarray(), 'tendonvi', 'madonvi');
    }
}

function getDonViQuanLyCumKhoi($macumkhoi, $kieudulieu = 'ARRAY')
{
    $m_cum = \App\Model\DanhMuc\dscumkhoi::where('macumkhoi', $macumkhoi)->first();
    $model = \App\Model\DanhMuc\dsdonvi::where('madonvi', $m_cum->madonviql)->get();
    switch ($kieudulieu) {
        case 'MODEL': {
                return $model;
                break;
            }
        default:
            return array_column($model->toarray(), 'tendonvi', 'madonvi');
    }
}

function getDonViQuanLyTinh($kieudulieu = 'ARRAY')
{
    $m_diaban = \App\Model\DanhMuc\dsdiaban::where('capdo', 'T')->first();
    $model = \App\Model\DanhMuc\dsdonvi::where('madonvi', $m_diaban->madonviQL)->get();
    switch ($kieudulieu) {
        case 'MODEL': {
                return $model;
                break;
            }
        default:
            return array_column($model->toarray(), 'tendonvi', 'madonvi');
    }
}

//lây các đơn vị có chức năng quản lý địa bàn
function getDonViXetDuyetHoSo($capdo, $madiaban = null, $chucnang = null, $kieudulieu = 'ARRAY')
{
    $model = \App\Model\View\viewdiabandonvi::wherein('capdo', ['T', 'H', 'X'])->get();
    switch ($kieudulieu) {
        case 'MODEL': {
                return $model;
                break;
            }
        default:
            return array_column($model->toarray(), 'tendonvi', 'madonvi');
    }
}

function getDonViXetDuyetHoSoCumKhoi($capdo, $madiaban = null, $chucnang = null, $kieudulieu = 'ARRAY')
{
    $model = \App\Model\View\viewdiabandonvi::wherein('madonvi', function ($qr) {
        $qr->select('madonviql')->from('dscumkhoi')->get();
    })->get();
    switch ($kieudulieu) {
        case 'MODEL': {
                return $model;
                break;
            }
        default:
            return array_column($model->toarray(), 'tendonvi', 'madonvi');
    }
}

function getDiaBanXetDuyetHoSo($capdo, $madiaban = null, $chucnang = null, $kieudulieu = 'ARRAY')
{
    $model = \App\Model\DanhMuc\dsdiaban::wherein('capdo', ['T', 'H', 'X'])->get();
    switch ($kieudulieu) {
        case 'MODEL': {
                return $model;
                break;
            }
        default:
            return array_column($model->toarray(), 'tendiaban', 'madiaban');
    }
}

function getThongTinDonVi($madonvi, $tentruong)
{
    $model = \App\Model\View\viewdiabandonvi::where('madonvi', $madonvi)->first();
    return $model->$tentruong ?? '';
}

//chưa làm 
function chkPhanQuyen($machucnang = null, $tenphanquyen = null)
{
    //return true;
    //Kiểm tra giao diện (danhmucchucnang)
    if (!chkGiaoDien($machucnang)) {
        return false;
    }
    $capdo = session('admin')->capdo;
    
    if (in_array($capdo, ['SSA', 'ssa',])) {        
        return true;
    }
    //dd(session('phanquyen'));
    return session('phanquyen')[$machucnang][$tenphanquyen] ?? 0;
}

function chkGiaoDien($machucnang, $tentruong = 'sudung')
{    
    $chk = session('chucnang')[$machucnang] ?? ['sudung' => 0, 'tenchucnang' => $machucnang . '()'];
    // if($machucnang == 'quantrihethong'){
    //     dd($chk);
    // }
    return $chk[$tentruong];
}

function getDonVi($capdo, $chucnang = null, $tenquyen = null)
{
    return App\Model\View\viewdiabandonvi::all();
}

function getDiaBan($capdo, $chucnang = null, $tenquyen = null)
{
    return App\Model\View\viewdiabandonvi::all();
}

function setArrayAll($array, $noidung = 'Tất cả', $giatri = 'ALL')
{
    $a_kq = [$giatri => $noidung];
    foreach ($array as $k => $v) {
        $a_kq[(string)$k] = $v;
    }
    return $a_kq;
}

function setChuyenHoSo($capdo, $hoso, $a_hoanthanh)
{
    if ($capdo == 'H') {
        if (isset($a_hoanthanh['madonvi']))
            $hoso->madonvi_h = $a_hoanthanh['madonvi'];
        if (isset($a_hoanthanh['trangthai']))
            $hoso->trangthai_h = $a_hoanthanh['trangthai'];
        if (isset($a_hoanthanh['lydo']))
            $hoso->lydo_h = $a_hoanthanh['lydo'];
        if (isset($a_hoanthanh['thoigian']))
            $hoso->thoigian_h = $a_hoanthanh['thoigian'];
    }

    if ($capdo == 'T') {
        if (isset($a_hoanthanh['madonvi']))
            $hoso->madonvi_t = $a_hoanthanh['madonvi'];
        if (isset($a_hoanthanh['trangthai']))
            $hoso->trangthai_t = $a_hoanthanh['trangthai'];
        if (isset($a_hoanthanh['lydo']))
            $hoso->lydo_t = $a_hoanthanh['lydo'];
        if (isset($a_hoanthanh['thoigian']))
            $hoso->thoigian_t = $a_hoanthanh['thoigian'];
    }

    if ($capdo == 'TW') {
        if (isset($a_hoanthanh['madonvi']))
            $hoso->madonvi_tw = $a_hoanthanh['madonvi'];
        if (isset($a_hoanthanh['trangthai']))
            $hoso->trangthai_tw = $a_hoanthanh['trangthai'];
        if (isset($a_hoanthanh['lydo']))
            $hoso->lydo_tw = $a_hoanthanh['lydo'];
        if (isset($a_hoanthanh['thoigian']))
            $hoso->thoigian_tw = $a_hoanthanh['thoigian'];
    }
}

//Nhận và trả lại
function setNhanHoSo($madonvi_nhan, $hoso, $a_hoanthanh)
{
    if ($madonvi_nhan == $hoso->madonvi_nhan) {
        if (isset($a_hoanthanh['madonvi_nhan']))
            $hoso->madonvi_nhan = $a_hoanthanh['madonvi_nhan'];
        if (isset($a_hoanthanh['trangthai']))
            $hoso->trangthai = $a_hoanthanh['trangthai'];
        if (isset($a_hoanthanh['lydo']))
            $hoso->lydo = $a_hoanthanh['lydo'];
        if (isset($a_hoanthanh['thoigian']))
            $hoso->thoigian = $a_hoanthanh['thoigian'];
    }

    if ($madonvi_nhan == $hoso->madonvi_nhan_h) {
        if (isset($a_hoanthanh['madonvi_nhan']))
            $hoso->madonvi_nhan_h = $a_hoanthanh['madonvi_nhan'];
        if (isset($a_hoanthanh['trangthai']))
            $hoso->trangthai_h = $a_hoanthanh['trangthai'];
        if (isset($a_hoanthanh['lydo']))
            $hoso->lydo_h = $a_hoanthanh['lydo'];
        if (isset($a_hoanthanh['thoigian']))
            $hoso->thoigian_h = $a_hoanthanh['thoigian'];
    }

    if ($madonvi_nhan == $hoso->madonvi_nhan_t) {
        if (isset($a_hoanthanh['madonvi']))
            $hoso->madonvi = $a_hoanthanh['madonvi'];
        if (isset($a_hoanthanh['madonvi_nhan']))
            $hoso->madonvi_nhan_t = $a_hoanthanh['madonvi_nhan'];
        if (isset($a_hoanthanh['trangthai']))
            $hoso->trangthai_t = $a_hoanthanh['trangthai'];
        if (isset($a_hoanthanh['lydo']))
            $hoso->lydo_t = $a_hoanthanh['lydo'];
        if (isset($a_hoanthanh['thoigian']))
            $hoso->thoigian_t = $a_hoanthanh['thoigian'];
    }

    if ($madonvi_nhan == $hoso->madonvi_nhan_tw) {
        if (isset($a_hoanthanh['madonvi_nhan']))
            $hoso->madonvi_nhan_tw = $a_hoanthanh['madonvi_nhan'];
        if (isset($a_hoanthanh['trangthai']))
            $hoso->trangthai_tw = $a_hoanthanh['trangthai'];
        if (isset($a_hoanthanh['lydo']))
            $hoso->lydo_tw = $a_hoanthanh['lydo'];
        if (isset($a_hoanthanh['thoigian']))
            $hoso->thoigian_tw = $a_hoanthanh['thoigian'];
    }
}

function setTraLaiHoSo_Nhan($madonvi, $hoso, $a_hoanthanh)
{
    if ($madonvi == $hoso->madonvi_h) {
        if (isset($a_hoanthanh['madonvi']))
            $hoso->madonvi_h = $a_hoanthanh['madonvi'];
        if (isset($a_hoanthanh['madonvi_nhan']))
            $hoso->madonvi_nhan_h = $a_hoanthanh['madonvi_nhan'];
        if (isset($a_hoanthanh['trangthai']))
            $hoso->trangthai_h = $a_hoanthanh['trangthai'];
        if (isset($a_hoanthanh['lydo']))
            $hoso->lydo_h = $a_hoanthanh['lydo'];
        if (isset($a_hoanthanh['thoigian']))
            $hoso->thoigian_h = $a_hoanthanh['thoigian'];
    }

    if ($madonvi == $hoso->madonvi_t) {
        if (isset($a_hoanthanh['madonvi']))
            $hoso->madonvi_t = $a_hoanthanh['madonvi'];
        if (isset($a_hoanthanh['madonvi_nhan']))
            $hoso->madonvi_nhan_t = $a_hoanthanh['madonvi_nhan'];
        if (isset($a_hoanthanh['trangthai']))
            $hoso->trangthai_t = $a_hoanthanh['trangthai'];
        if (isset($a_hoanthanh['lydo']))
            $hoso->lydo_t = $a_hoanthanh['lydo'];
        if (isset($a_hoanthanh['thoigian']))
            $hoso->thoigian_t = $a_hoanthanh['thoigian'];
    }

    if ($madonvi == $hoso->madonvi_tw) {
        if (isset($a_hoanthanh['madonvi']))
            $hoso->madonvi_tw = $a_hoanthanh['madonvi'];
        if (isset($a_hoanthanh['madonvi_nhan']))
            $hoso->madonvi_nhan_tw = $a_hoanthanh['madonvi_nhan'];
        if (isset($a_hoanthanh['trangthai']))
            $hoso->trangthai_tw = $a_hoanthanh['trangthai'];
        if (isset($a_hoanthanh['lydo']))
            $hoso->lydo_tw = $a_hoanthanh['lydo'];
        if (isset($a_hoanthanh['thoigian']))
            $hoso->thoigian_tw = $a_hoanthanh['thoigian'];
    }
}

function setTrangThaiHoSo($madonvi, $hoso, $a_hoanthanh)
{
    // if ($madonvi == $hoso->madonvi) {
    //     if (isset($a_hoanthanh['madonvi']))
    //         $hoso->madonvi = $a_hoanthanh['madonvi'];
    //     if (isset($a_hoanthanh['madonvi_nhan']))
    //         $hoso->madonvi_nhan = $a_hoanthanh['madonvi_nhan'];
    //     if (isset($a_hoanthanh['trangthai']))
    //         $hoso->trangthai = $a_hoanthanh['trangthai'];
    //     if (isset($a_hoanthanh['lydo']))
    //         $hoso->lydo = $a_hoanthanh['lydo'];
    //     if (isset($a_hoanthanh['thoigian']))
    //         $hoso->thoigian = $a_hoanthanh['thoigian'];
    // }

    if ($madonvi == $hoso->madonvi_h) {
        if (isset($a_hoanthanh['madonvi']))
            $hoso->madonvi_h = $a_hoanthanh['madonvi'];
        if (isset($a_hoanthanh['madonvi_nhan']))
            $hoso->madonvi_nhan_h = $a_hoanthanh['madonvi_nhan'];
        if (isset($a_hoanthanh['trangthai']))
            $hoso->trangthai_h = $a_hoanthanh['trangthai'];
        if (isset($a_hoanthanh['lydo']))
            $hoso->lydo_h = $a_hoanthanh['lydo'];
        if (isset($a_hoanthanh['thoigian']))
            $hoso->thoigian_h = $a_hoanthanh['thoigian'];
    }

    if ($madonvi == $hoso->madonvi_t) {
        if (isset($a_hoanthanh['madonvi']))
            $hoso->madonvi_t = $a_hoanthanh['madonvi'];
        if (isset($a_hoanthanh['madonvi_nhan']))
            $hoso->madonvi_nhan_t = $a_hoanthanh['madonvi_nhan'];
        if (isset($a_hoanthanh['trangthai']))
            $hoso->trangthai_t = $a_hoanthanh['trangthai'];
        if (isset($a_hoanthanh['lydo']))
            $hoso->lydo_t = $a_hoanthanh['lydo'];
        if (isset($a_hoanthanh['thoigian']))
            $hoso->thoigian_t = $a_hoanthanh['thoigian'];
    }

    if ($madonvi == $hoso->madonvi_tw) {
        if (isset($a_hoanthanh['madonvi']))
            $hoso->madonvi_tw = $a_hoanthanh['madonvi'];
        if (isset($a_hoanthanh['madonvi_nhan']))
            $hoso->madonvi_nhan_tw = $a_hoanthanh['madonvi_nhan'];
        if (isset($a_hoanthanh['trangthai']))
            $hoso->trangthai_tw = $a_hoanthanh['trangthai'];
        if (isset($a_hoanthanh['lydo']))
            $hoso->lydo_tw = $a_hoanthanh['lydo'];
        if (isset($a_hoanthanh['thoigian']))
            $hoso->thoigian_tw = $a_hoanthanh['thoigian'];
    }
}

function getDonViChuyen($madonvi_nhan, $hoso)
{
    //dd($macqcq);
    if ($madonvi_nhan == $hoso->madonvi) {
        $hoso->madonvi_hoso = $hoso->madonvi;
        $hoso->trangthai_hoso = $hoso->trangthai;
        $hoso->thoigian_hoso = $hoso->thoigian;
        $hoso->lydo_hoso = $hoso->lydo;
        $hoso->madonvi_nhan_hoso = $hoso->madonvi_nhan;
    }
    if ($madonvi_nhan == $hoso->madonvi_h) {
        $hoso->madonvi_hoso = $hoso->madonvi_h;
        $hoso->trangthai_hoso = $hoso->trangthai_h;
        $hoso->thoigian_hoso = $hoso->thoigian_h;
        $hoso->lydo_hoso = $hoso->lydo_h;
        $hoso->madonvi_nhan_hoso = $hoso->madonvi_nhan_h;
    }
    if ($madonvi_nhan == $hoso->madonvi_t) {
        $hoso->madonvi_hoso = $hoso->madonvi_t;
        $hoso->trangthai_hoso = $hoso->trangthai_t;
        $hoso->thoigian_hoso = $hoso->thoigian_t;
        $hoso->lydo_hoso = $hoso->lydo_t;
        $hoso->madonvi_nhan_hoso = $hoso->madonvi_nhan_t;
    }
    if ($madonvi_nhan == $hoso->madonvi_tw) {
        $hoso->madonvi_hoso = $hoso->madonvi_tw;
        $hoso->trangthai_hoso = $hoso->trangthai_tw;
        $hoso->thoigian_hoso = $hoso->thoigian_tw;
        $hoso->lydo_hoso = $hoso->lydo_tw;
        $hoso->madonvi_nhan_hoso = $hoso->madonvi_nhan_tw;
    }
}

//chưa dùng
function setHoanThanhCQ($level, $hoso, $a_hoanthanh)
{
    if ($level == 'T') {
        $hoso->madonvi_t = $a_hoanthanh['madonvi'] ?? null;
        $hoso->thoigian_t = $a_hoanthanh['thoigian'] ?? null;
        $hoso->trangthai_t = $a_hoanthanh['trangthai'] ?? 'CHT';
    }

    if ($level == 'TW') {
        $hoso->madonvi_ad = $a_hoanthanh['madonvi'] ?? null;
        $hoso->thoidiem_ad = $a_hoanthanh['thoidiem'] ?? null;
        $hoso->trangthai_ad = $a_hoanthanh['trangthai'] ?? 'CHT';
    }

    if ($level == 'H') {
        $hoso->madonvi_h = $a_hoanthanh['madonvi'] ?? null;
        $hoso->thoidiem_h = $a_hoanthanh['thoidiem'] ?? null;
        $hoso->trangthai_h = $a_hoanthanh['trangthai'] ?? 'CHT';
    }
}
//chưa dùng
function setHoanThanhDV($madonvi, $hoso, $a_hoanthanh)
{
    if ($madonvi == $hoso->madonvi) {
        $hoso->macqcq = $a_hoanthanh['macqcq'] ?? null;
        $hoso->trangthai = $a_hoanthanh['trangthai'] ?? 'CHT';
        $hoso->lydo = $a_hoanthanh['lydo'] ?? null;
    }

    if ($madonvi == $hoso->madonvi_h) {
        $hoso->macqcq_h = $a_hoanthanh['macqcq'] ?? null;
        $hoso->trangthai_h = $a_hoanthanh['trangthai'] ?? 'CHT';
        $hoso->lydo_h = $a_hoanthanh['lydo'] ?? null;
    }

    if ($madonvi == $hoso->madonvi_t) {
        $hoso->macqcq_t = $a_hoanthanh['macqcq'] ?? null;
        $hoso->trangthai_t = $a_hoanthanh['trangthai'] ?? 'CHT';
        $hoso->lydo_t = $a_hoanthanh['lydo'] ?? null;
    }

    if ($madonvi == $hoso->madonvi_ad) {
        $hoso->macqcq_ad = $a_hoanthanh['macqcq'] ?? null;
        $hoso->trangthai_ad = $a_hoanthanh['trangthai'] ?? 'CHT';
        $hoso->lydo_ad = $a_hoanthanh['lydo'] ?? null;
    }
}

//chưa dùng


//chưa dùng
function setTraLai($macqcq, $hoso, $a_tralai)
{
    //Gán trạng thái của đơn vị chuyển hồ sơ
    if ($macqcq == $hoso->macqcq) {
        $hoso->macqcq = null;
        $hoso->trangthai = $a_tralai['trangthai'] ?? 'CHT';
        $hoso->lydo = $a_tralai['lydo'] ?? null;
    }
    if ($macqcq == $hoso->macqcq_h) {
        $hoso->macqcq_h = null;
        $hoso->trangthai_h = $a_tralai['trangthai'] ?? 'CHT';
        $hoso->lydo_h = $a_tralai['lydo'] ?? null;
    }
    if ($macqcq == $hoso->macqcq_t) {
        $hoso->macqcq_t = null;
        $hoso->trangthai_t = $a_tralai['trangthai'] ?? 'CHT';
        $hoso->lydo_t = $a_tralai['lydo'] ?? null;
    }
    if ($macqcq == $hoso->macqcq_ad) {
        $hoso->macqcq_ad = null;
        $hoso->trangthai_ad = $a_tralai['trangthai'] ?? 'CHT';
        $hoso->lydo_ad = $a_tralai['lydo'] ?? null;
    }
    //Gán trạng thái của đơn vị tiếp nhận hồ sơ
    if ($macqcq == $hoso->madonvi_h) {
        $hoso->macqcq_h = null;
        $hoso->trangthai_h = null;
        $hoso->lydo_h = null;
        $hoso->thoidiem_h = null;
        $hoso->madonvi_h = null;
    }

    if ($macqcq == $hoso->madonvi_t) {
        $hoso->macqcq_t = null;
        $hoso->trangthai_t = null;
        $hoso->lydo_t = null;
        $hoso->thoidiem_t = null;
        $hoso->madonvi_t = null;
    }

    if ($macqcq == $hoso->madonvi_ad) {
        $hoso->macqcq_ad = null;
        $hoso->trangthai_ad = null;
        $hoso->lydo_ad = null;
        $hoso->thoidiem_ad = null;
        $hoso->madonvi_ad = null;
    }
}
