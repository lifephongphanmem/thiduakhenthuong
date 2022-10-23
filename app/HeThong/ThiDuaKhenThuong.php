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

function getDanhHieuKhenThuong($capdo, $phanloai = 'CANHAN')
{
    $a_ketqua = [];
    if ($capdo == 'ALL')
        $m_danhhieu = App\Model\DanhMuc\dmdanhhieuthidua::all();
    else {
        if ($phanloai == 'CANHAN')
            $m_danhhieu = App\Model\DanhMuc\dmdanhhieuthidua::where('phanloai', $phanloai)->get();
        else{
            $m_danhhieu = App\Model\DanhMuc\dmdanhhieuthidua::where('phanloai', '<>', 'CANHAN')->get();            
        }
            
    }
    foreach ($m_danhhieu as $danhhieu) {
        if ($capdo == 'ALL')
            $a_ketqua[$danhhieu->madanhhieutd] = $danhhieu->tendanhhieutd;
        elseif (in_array($capdo, explode(';', $danhhieu->phamviapdung)))
            $a_ketqua[$danhhieu->madanhhieutd] = $danhhieu->tendanhhieutd;
    }
    foreach (App\Model\DanhMuc\dmhinhthuckhenthuong::all() as $danhhieu) {
        if ($capdo == 'ALL')
            $a_ketqua[$danhhieu->mahinhthuckt] = $danhhieu->tenhinhthuckt;
        elseif (in_array($capdo, explode(';', $danhhieu->phamviapdung)))
            $a_ketqua[$danhhieu->mahinhthuckt] = $danhhieu->tenhinhthuckt;
    }

    return $a_ketqua;
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

function getDonViQuanLyDiaBan($donvi, $kieudulieu = 'ARRAY')
{
    //Lấy đơn vị quản lý địa bàn và đơn vi
    $m_diaban = \App\Model\DanhMuc\dsdiaban::where('madiaban', $donvi->madiaban)->first();
    $model = \App\Model\DanhMuc\dsdonvi::wherein('madonvi', [$m_diaban->madonviQL, $donvi->madonvi])->get();
    switch ($kieudulieu) {
        case 'MODEL': {
                return $model;
                break;
            }
        default:
            return array_column($model->toarray(), 'tendonvi', 'madonvi');
    }
}

function getDonViXetDuyetDiaBan($donvi, $kieudulieu = 'ARRAY')
{
    //Lấy đơn vị quản lý địa bàn và đơn vi
    $m_diaban = \App\Model\DanhMuc\dsdiaban::where('madiaban', $donvi->madiaban)->first();
    $model = \App\Model\DanhMuc\dsdonvi::wherein('madonvi', [$m_diaban->madonviKT, $donvi->madonvi])->get();
    switch ($kieudulieu) {
        case 'MODEL': {
                return $model;
                break;
            }
        default:
            return array_column($model->toarray(), 'tendonvi', 'madonvi');
    }
}

function getDonViQuanLyNganh($donvi, $kieudulieu = 'ARRAY')
{
    //dd($donvi);
    $linhvuchoatdong = $donvi->linhvuchoatdong == '' ? 'KHONGCHON' : $donvi->linhvuchoatdong;

    //X => lấy ds huyện có cùng ngành, lĩnh vực
    //H => lấy ds tỉnh có cùng ngành, lĩnh vực
    //T => lấy ds đơn vị cùng ngành lĩnh vực
    switch ($donvi->capdo) {
        case 'X': {
                $model = \App\Model\View\viewdiabandonvi::where('linhvuchoatdong', $linhvuchoatdong)->where('capdo', 'H')->get();
                break;
            }
            //mặc định cấp tỉnh
        default:
            $model = \App\Model\View\viewdiabandonvi::where('linhvuchoatdong', $linhvuchoatdong)->where('capdo', 'T')->get();
    }
    //dd($model);
    switch ($kieudulieu) {
        case 'MODEL': {
                return $model;
                break;
            }
        default:
            return array_column($model->toarray(), 'tendonvi', 'madonvi');
    }
}

function getDonViCK($capdo, $chucnang = null, $kieudulieu = 'ARRAY')
{
    // $model = \App\Model\View\view_dscumkhoi::all();
    // switch ($kieudulieu) {
    //     case 'MODEL': {
    //             return $model;
    //             break;
    //         }
    //     default:
    //         return array_column($model->toarray(), 'tendonvi', 'madonvi');
    // }

    if ($capdo == 'SSA' || $capdo == 'ADMIN') {
        $m_donvi = App\Model\View\view_dscumkhoi::all();
    } else {
        $m_donvi = App\Model\View\view_dscumkhoi::where('madonvi', session('admin')->madonvi)->get();
    }

    if ($chucnang != null) {
        $a_tk = App\Model\DanhMuc\dstaikhoan::wherein('madonvi', array_column($m_donvi->toarray(), 'madonvi'))->get('tendangnhap');
        $a_tk_pq = App\Model\DanhMuc\dstaikhoan_phanquyen::where('machucnang', $chucnang)->where('phanquyen', '1')
            ->wherein('tendangnhap', $a_tk)->get('tendangnhap');
        $m_donvi = App\Model\View\viewdiabandonvi::wherein('madonvi', function ($qr) use ($a_tk_pq) {
            $qr->select('madonvi')->from('dstaikhoan')->wherein('tendangnhap', $a_tk_pq)->distinct();
        })->get();
    }
    // if(count($m_donvi) == 0){
    //     return redirect('/DangNhap');
    // }
    return $m_donvi;
}

function getDonViXetDuyetCumKhoi($macumkhoi, $kieudulieu = 'ARRAY')
{
    $m_donvi = \App\Model\View\view_dscumkhoi::where('macumkhoi', $macumkhoi)->wherein('phanloai', ['TRUONGKHOI'])->first();
    $m_diaban = \App\Model\DanhMuc\dsdiaban::where('madiaban', $m_donvi->madiaban)->first();
    // $model = \App\Model\DanhMuc\dsdonvi::wherein('madonvi', [$m_diaban->madonviKT, $m_donvi->madonvi])->get();
    $model = \App\Model\DanhMuc\dsdonvi::wherein('madonvi', [$m_diaban->madonviKT])->get();
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
    $m_donvi = \App\Model\View\view_dscumkhoi::where('macumkhoi', $macumkhoi)->wherein('phanloai', ['TRUONGKHOI'])->first();
    $m_diaban = \App\Model\DanhMuc\dsdiaban::where('madiaban', $m_donvi->madiaban)->first();
    // $model = \App\Model\DanhMuc\dsdonvi::wherein('madonvi', [$m_diaban->madonviQL, $m_donvi->madonvi])->get();
    $model = \App\Model\DanhMuc\dsdonvi::wherein('madonvi', [$m_diaban->madonviQL])->get();
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
function getDonViXetDuyetHoSo($madonvi = null, $chucnang = null, $kieudulieu = 'ARRAY')
{
    //Lấy đơn vị có thông tin đơn vị
    $m_donvi = \App\Model\View\viewdiabandonvi::where('madonvi', $madonvi)->get();

    //Lấy đơn vị quản lý địa bàn
    $model = \App\Model\View\viewdiabandonvi::where('madonvi', $m_donvi->first()->madonviQL)->get();
    if ($chucnang != null) {
        $a_tk = App\Model\DanhMuc\dstaikhoan::wherein('madonvi', array_column($m_donvi->toarray(), 'madonvi'))->get('tendangnhap');
        $a_tk_pq = App\Model\DanhMuc\dstaikhoan_phanquyen::where('machucnang', $chucnang)->where('phanquyen', '1')
            ->wherein('tendangnhap', $a_tk)->get('tendangnhap');
        $m_donvi = App\Model\View\viewdiabandonvi::wherein('madonvi', function ($qr) use ($a_tk_pq) {
            $qr->select('madonvi')->from('dstaikhoan')->wherein('tendangnhap', $a_tk_pq)->distinct();
        })->get();
    }

    foreach ($m_donvi as $donvi) {
        $model->add($donvi);
    }

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
    if ($capdo == 'SSA' || $capdo == 'ADMIN') {
        $m_donvi = App\Model\View\viewdiabandonvi::all();
    } else {
        $m_donvi = App\Model\View\viewdiabandonvi::where('madonvi', session('admin')->madonvi)->get();
    }

    if ($chucnang != null) {
        $a_tk = App\Model\DanhMuc\dstaikhoan::wherein('madonvi', array_column($m_donvi->toarray(), 'madonvi'))->get('tendangnhap');
        $a_tk_pq = App\Model\DanhMuc\dstaikhoan_phanquyen::where('machucnang', $chucnang)->where('phanquyen', '1')
            ->wherein('tendangnhap', $a_tk)->get('tendangnhap');
        $m_donvi = App\Model\View\viewdiabandonvi::wherein('madonvi', function ($qr) use ($a_tk_pq) {
            $qr->select('madonvi')->from('dstaikhoan')->wherein('tendangnhap', $a_tk_pq)->distinct();
        })->get();
    }
    // if(count($m_donvi) == 0){
    //     return redirect('/DangNhap');
    // }
    return $m_donvi;
}

//Lấy danh sách địa bàn theo đơn vị để kết xuất báo cáo tổng hợp
function getDiaBanBaoCaoTongHop($donvi)
{
    $m_donvi = App\Model\DanhMuc\dsdiaban::where('madiaban', $donvi->madiaban)->get();
    //Lấy địa bàn trực thuộc
    $dsdiaban = App\Model\DanhMuc\dsdiaban::where('madiaban', '<>', $donvi->madiaban)->get();
    getDiaBanTrucThuoc($dsdiaban, $donvi->madiaban, $m_donvi);
    return $m_donvi;
}

//Chức năng
function getDiaBan($capdo, $chucnang = null, $tenquyen = null)
{
    if ($capdo == 'SSA' || $capdo == 'ADMIN') {
        $m_donvi = App\Model\DanhMuc\dsdiaban::all();
    } else {
        $m_donvi = App\Model\DanhMuc\dsdiaban::where('madiaban', session('admin')->madiaban)->get();
        //Lấy địa bàn trực thuộc
        $dsdiaban = App\Model\DanhMuc\dsdiaban::where('madiaban', '<>', session('admin')->madiaban)->get();
        getDiaBanTrucThuoc($dsdiaban, session('admin')->madiaban, $m_donvi);
    }

    return $m_donvi;
}

function getDiaBanTrucThuoc(&$dsdiaban, $madiabanQL, &$ketqua)
{
    foreach ($dsdiaban as $key => $val) {
        if ($val->madiabanQL == $madiabanQL) {
            $ketqua->add($val);
            $dsdiaban->forget($key);
            getDiaBanTrucThuoc($dsdiaban, $val->madiaban, $ketqua);
        }
    }
}

function getDSPhongTrao($donvi)
{
    $m_phongtrao = App\Model\View\viewdonvi_dsphongtrao::wherein('phamviapdung', ['T', 'TW'])->orderby('tungay')->get();
    switch ($donvi->capdo) {
        case 'X': {
                //đơn vị cấp xã => chỉ các phong trào trong huyện, xã
                $model_xa = App\Model\View\viewdonvi_dsphongtrao::wherein('madiaban', [$donvi->madiaban, $donvi->madiabanQL])->orderby('tungay')->get();
                break;
            }
        case 'H': {
                //đơn vị cấp huyện =>chỉ các phong trào trong huyện
                $model_xa = App\Model\View\viewdonvi_dsphongtrao::where('madiaban', $donvi->madiaban)->orderby('tungay')->get();
                break;
            }
        case 'T': {
                //Phong trào theo SBN
                $model_xa = App\Model\View\viewdonvi_dsphongtrao::where('phamviapdung', 'SBN')->orderby('tungay')->get();
                break;
            }
    }
    foreach ($model_xa as $ct) {
        $m_phongtrao->add($ct);
    }
    return $m_phongtrao;
}

//Làm sẵn hàm sau lọc theo truonq theodoi = 1
function getLoaiHinhKhenThuong()
{
    return App\Model\DanhMuc\dmloaihinhkhenthuong::all();
}

function setArrayAll($array, $noidung = 'Tất cả', $giatri = 'ALL')
{
    $a_kq = [$giatri => $noidung];
    foreach ($array as $k => $v) {
        $a_kq[(string)$k] = $v;
    }
    return $a_kq;
}

function setChuyenXetDuyet($hoso, $a_hoanthanh)
{
    if (isset($a_hoanthanh['madonvi']))
        $hoso->madonvi_xd = $a_hoanthanh['madonvi'];
    if (isset($a_hoanthanh['trangthai']))
        $hoso->trangthai_xd = $a_hoanthanh['trangthai'];
    if (isset($a_hoanthanh['lydo']))
        $hoso->lydo_xd = $a_hoanthanh['lydo'];
    if (isset($a_hoanthanh['thoigian']))
        $hoso->thoigian_xd = $a_hoanthanh['thoigian'];
}

function setChuyenKhenThuong($hoso, $a_hoanthanh)
{
    if (isset($a_hoanthanh['madonvi']))
        $hoso->madonvi_kt = $a_hoanthanh['madonvi'];
    if (isset($a_hoanthanh['trangthai']))
        $hoso->trangthai_kt = $a_hoanthanh['trangthai'];
    if (isset($a_hoanthanh['lydo']))
        $hoso->lydo_kt = $a_hoanthanh['lydo'];
    if (isset($a_hoanthanh['thoigian']))
        $hoso->thoigian_kt = $a_hoanthanh['thoigian'];
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
