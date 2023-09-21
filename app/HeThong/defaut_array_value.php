<?php

use App\Model\DanhMuc\dsdonvi;

/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/5/2018
 * Time: 3:05 PM
 */

function getPhanLoaiLocDuLieu()
{
    return array(
        'DONVI' => 'Đơn vị sử dụng',
        'DIABAN' => 'Địa bàn hành chính',
        'CUMKHOI' => 'Cụm, khối thi đua'
    );
}

function getPhanLoaiDoiTuong()
{
    return array(
        'Ông' => 'Ông',
        'Bà' => 'Bà',
    );
}

function getChucVuKhenThuong($capdo = 'T')
{
    return array(
        'Chủ tịch UBND Xã' => 'Chủ tịch UBND Xã',
        'Chủ tịch UBND Huyện' => 'Chủ tịch UBND Huyện',
        'Chủ tịch UBND Tỉnh' => 'Chủ tịch UBND Tỉnh',
        'Thủ tướng chính phủ' => 'Thủ tướng chính phủ',
        'Chủ tịch nước' => 'Chủ tịch nước',
        'Tổng giám đốc' => 'Tổng giám đốc',
        'Giám đốc' => 'Giám đốc',
    );
}

function getFontFamilyList()
{
    return array(
        'Arial' => 'Arial',
        'Times New Roman' => 'Times New Roman',
        'Shelley Allegro' => 'Shelley Allegro',
        // 'UTMVnShelley' => 'UTMVnShelley',
        // 'UTMDiana' => 'UTMDiana',
        // 'UTMBeautiful' => 'UTMBeautiful',
        // 'UTMEdwardianKT' => 'UTMEdwardianKT',
        // 'UTMFleur' => 'UTMFleur',
        // 'UTMNovido' => 'UTMNovido',
        // 'UTMSloop' => 'UTMSloop',
        // 'UTMThuPhapThienAn' => 'UTMThuPhapThienAn',
        'VnTimes' => 'VnTimes',
        // 'UTMWedding' => 'UTMWedding',
        // 'UTMYves' => 'UTMYves',
    );
}

function getDSToaDo_Truong()
{
    return  [
        'toado_tendoituongin' => 'tendoituongin',
        'toado_ngayqd' => 'ngayqd',
        'toado_chucvunguoikyqd' => 'chucvunguoikyqd',
        'toado_hotennguoikyqd' => 'hotennguoikyqd',
        'toado_chucvudoituong' => 'chucvudoituong',
        'toado_quyetdinh' => 'quyetdinh',
        'toado_pldoituong' => 'pldoituong',
        'toado_noidungkhenthuong' =>  'noidungkhenthuong',
    ];
}

function getTenTruongTheToaDo($tentoado)
{
    $a_kq = getDSToaDo_Truong();
    return $a_kq[$tentoado] ?? 'noidungkhenthuong';
}

function getLinhVucHoatDong()
{
    return array(
        '0001' => 'An ninh - Quốc phòng',
        '0009' => 'Báo chí - Thông tin - Truyền thông',
        '0021' => 'Bảo hiểm xã hội',
        '0022' => 'Các cơ quan, tổ chức Đảng',
        '0020' => 'Các tổ chức Hội và Đoàn thể',
        '0002' => 'Công nghiệp - Thương mại',
        '0023' => 'Cơ quan lập pháp',
        '0003' => 'Giáo dục - Đào tạo',
        '0004' => 'Giao thông vận tải',
        '0024' => 'Kế hoạch - Đầu tư',
        '0014' => 'Kinh tế - Xã hội',
        '0006' => 'Khoa học - Công nghệ',
        '0019' => 'Lao động, Thương Binh và Xã hội',
        '0005' => 'N/A',
        '0007' => 'Nông nghiệp - Nông thôn',
        '0015' => 'Ngoại giao',
        '0013' => 'Quản lý Nhà nước',
        '0008' => 'Tài chính - Ngân hàng',
        '0018' => 'Tài nguyên - Môi trường',
        '0016' => 'Tôn giáo - Tín ngưỡng',
        '0017' => 'Tư pháp - Thanh tra - Tòa án - Kiểm sát',
        '0010' => 'Văn hóa - Thể Thao - Du lịch',
        '0011' => 'Xây dựng',
        '0012' => 'Y tế',
    );
}

function getPhanLoaiDMDuThao()
{
    return array(
        'QUYETDINH' => 'Dự thảo quyết định khen thưởng',
        'TOTRINHHOSO' => 'Dự thảo tờ trình hồ sơ đề nghị khen thưởng',
        'TOTRINHPHEDUYET' => 'Dự thảo tờ trình phê duyệt khen thưởng',
        'KHAC' => 'Dự thảo khác',
    );
}

function getTrangThaiTheoDoi()
{
    return array(
        '0' => 'Không theo dõi',
        '1' => 'Có theo dõi',
    );
}

//chưa dùng
function getPhanLoaiHoSoKT()
{
    return array(
        'KTDONVI' => 'Hồ sơ khen thưởng tại đơn vị',
    );
}

function getPhanLoaiHoSo()
{
    return array(
        'KHENTHUONG' => 'Hồ sơ đề nghị cấp trên khen thưởng',
        //'KTNGANH' => 'Hồ sơ khen thưởng theo ngành', //chuyển lên loại hồ sơ khen thưởng tại đơn vị
    );
}

function getPhanLoaiHoSo_BaoCao()
{
    return array(
        'KTDONVI' => 'Hồ sơ khen thưởng tại đơn vị',
        'KHENTHUONG' => 'Hồ sơ đề nghị cấp trên khen thưởng',
    );
}

function getPhamViKhenCao($phamvi = 'T')
{
    switch ($phamvi) {
        case 'X': {
                return array(
                    'H' => 'Hồ sơ khen cấp Huyện',
                );
                break;
            }
        case 'H': {
                return array(
                    'T' => 'Hồ sơ khen cấp Tỉnh',
                );
                break;
            }
        default: {
                return array(
                    'TW' => 'Hồ sơ khen cấp Nhà nước',
                );
                break;
            }
    }
}

function getPhanLoaiHoSoKhenCao($phanloai = 'ALL')
{
    $a_kq = array(
        'CHINHPHU' => 'Hồ sơ khen của Thủ tướng chính phủ',
        'CHUTICHNUOC' => 'Hồ sơ khen của Chủ tịch nước',
        'KHANGCHIEN' => 'Hồ sơ khen kháng chiến',
    );
    if ($phanloai == 'ALL') {
        return $a_kq;
    } else {
        return [$phanloai => $a_kq[$phanloai]];
    }
}

function getTaoDuThaoToTrinhHoSoCumKhoi(&$model, $maduthao = null)
{
    //$maduthao = 'ALL' =>khỏi tạo lại dự thảo
    if ($maduthao  == 'ALL') {
        $thongtintotrinhhoso = App\Model\DanhMuc\duthaoquyetdinh::wherein('phanloai', ['TOTRINHHOSO'])->first()->codehtml ?? '';
        $donvi = dsdonvi::where('madonvi', $model->madonvi)->first();
        $tendonvi = $donvi->tendonvi ?? '';

        //Gán thông tin
        $thongtintotrinhhoso = str_replace('[noidung]', $model->noidung, $thongtintotrinhhoso);
        $thongtintotrinhhoso = str_replace('[donvidenghi]',  $tendonvi, $thongtintotrinhhoso);
        $thongtintotrinhhoso = str_replace('[sototrinh]',  $model->sototrinh, $thongtintotrinhhoso);
        $thongtintotrinhhoso = str_replace('[ngayhoso]',  Date2Str($model->ngayhoso), $thongtintotrinhhoso);
        //Thông tin đơn vị
        $thongtintotrinhhoso = str_replace('[diadanh]',  $donvi->diadanh, $thongtintotrinhhoso);
        $thongtintotrinhhoso = str_replace('[chucvunguoiky]',  $model->chucvunguoiky, $thongtintotrinhhoso);
        $thongtintotrinhhoso = str_replace('[nguoikytotrinh]',  $donvi->nguoikytotrinh, $thongtintotrinhhoso);

        $m_canhan = App\Model\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi_canhan::where('mahosotdkt', $model->mahosotdkt)
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
            // $thongtintotrinhhoso = str_replace('<p style=&#34;margin-left:25px;&#34;>[khenthuongcanhan]</p>',  $s_canhan, $thongtintotrinhhoso);
            $thongtintotrinhhoso = str_replace('[khenthuongcanhan]',  $s_canhan, $thongtintotrinhhoso);
        }

        //Tập thể
        $m_tapthe = App\Model\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi_tapthe::where('mahosotdkt', $model->mahosotdkt)
            ->where('ketqua', '1')->orderby('stt')->get();
        if ($m_tapthe->count() > 0) {
            $s_tapthe = '';
            $i = 1;
            foreach ($m_tapthe as $chitiet) {
                $s_tapthe .= '<p style=&#34;margin-left:40px;&#34;>' .
                    ($i++) . '. ' . $chitiet->tentapthe .
                    '</p>';
            }
            $thongtintotrinhhoso = str_replace('[khenthuongtapthe]',  $s_tapthe, $thongtintotrinhhoso);
        }
        $model->thongtintotrinhhoso = $thongtintotrinhhoso;
    } else {
        //Load dự thảo theo mẫu
        if ($model->thongtintotrinhhoso == '') {
            if ($maduthao == null)
                $thongtintotrinhhoso = App\Model\DanhMuc\duthaoquyetdinh::wherein('phanloai', ['TOTRINHHOSO'])->first()->codehtml ?? '';
            else
                $thongtintotrinhhoso = App\Model\DanhMuc\duthaoquyetdinh::where('maduthao', $maduthao)->first()->codehtml ?? '';

            $donvi = dsdonvi::where('madonvi', $model->madonvi)->first();
            $tendonvi = $donvi->tendonvi ?? '';

            //Gán thông tin
            $thongtintotrinhhoso = str_replace('[noidung]', $model->noidung, $thongtintotrinhhoso);
            $thongtintotrinhhoso = str_replace('[donvidenghi]',  $tendonvi, $thongtintotrinhhoso);
            $thongtintotrinhhoso = str_replace('[sototrinh]',  $model->sototrinh, $thongtintotrinhhoso);
            $thongtintotrinhhoso = str_replace('[ngayhoso]',  Date2Str($model->ngayhoso), $thongtintotrinhhoso);
            //Thông tin đơn vị
            $thongtintotrinhhoso = str_replace('[diadanh]',  $donvi->diadanh, $thongtintotrinhhoso);
            $thongtintotrinhhoso = str_replace('[chucvunguoiky]',  $model->chucvunguoiky, $thongtintotrinhhoso);
            $thongtintotrinhhoso = str_replace('[nguoikytotrinh]',  $donvi->nguoikytotrinh, $thongtintotrinhhoso);

            $m_canhan = App\Model\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi_canhan::where('mahosotdkt', $model->mahosotdkt)
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
                // $thongtintotrinhhoso = str_replace('<p style=&#34;margin-left:25px;&#34;>[khenthuongcanhan]</p>',  $s_canhan, $thongtintotrinhhoso);
                $thongtintotrinhhoso = str_replace('[khenthuongcanhan]',  $s_canhan, $thongtintotrinhhoso);
            }

            //Tập thể
            $m_tapthe = App\Model\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi_tapthe::where('mahosotdkt', $model->mahosotdkt)
                ->where('ketqua', '1')->orderby('stt')->get();
            if ($m_tapthe->count() > 0) {
                $s_tapthe = '';
                $i = 1;
                foreach ($m_tapthe as $chitiet) {
                    $s_tapthe .= '<p style=&#34;margin-left:40px;&#34;>' .
                        ($i++) . '. ' . $chitiet->tentapthe .
                        '</p>';
                }
                $thongtintotrinhhoso = str_replace('[khenthuongtapthe]',  $s_tapthe, $thongtintotrinhhoso);
            }
            $model->thongtintotrinhhoso = $thongtintotrinhhoso;
        }
    }
}

function getTaoDuThaoToTrinhPheDuyetCumKhoi(&$model, $maduthao = null)
{
    //$maduthao = 'ALL' =>khỏi tạo lại dự thảo
    if ($maduthao  == 'ALL') {
        $thongtintotrinhdenghi = App\Model\DanhMuc\duthaoquyetdinh::wherein('phanloai', ['TOTRINHPHEDUYET'])->first()->codehtml ?? '';
        $donvi = dsdonvi::where('madonvi', $model->madonvi)->first();
        $donvi_xd = dsdonvi::where('madonvi', $model->madonvi_xd)->first();
        $donvi_kt = dsdonvi::where('madonvi', $model->madonvi_kt)->first();
        $tendonvi = $donvi->tendonvi ?? '';
        //dd($thongtintotrinhdenghi);
        //Gán thông tin
        $thongtintotrinhdenghi = str_replace('[sototrinhdenghi]', $model->sototrinhdenghi, $thongtintotrinhdenghi);
        $thongtintotrinhdenghi = str_replace('[noidung]', $model->noidung, $thongtintotrinhdenghi);
        $thongtintotrinhdenghi = str_replace('[donvixetduyet]',  $donvi_xd->tendonvi ?? '', $thongtintotrinhdenghi);
        $thongtintotrinhdenghi = str_replace('[ngaythangtotrinhdenghi]',  Date2Str($model->ngaythangtotrinhdenghi), $thongtintotrinhdenghi);

        $thongtintotrinhdenghi = str_replace('[diadanh]',  $donvi->diadanh, $thongtintotrinhdenghi);
        $thongtintotrinhdenghi = str_replace('[chucvunguoikyxetduyet]',  $donvi_xd->cdlanhdao ?? '', $thongtintotrinhdenghi);
        $thongtintotrinhdenghi = str_replace('[nguoikytotrinhxetduyet]',  $donvi_xd->lanhdao ?? '', $thongtintotrinhdenghi);

        $thongtintotrinhdenghi = str_replace('[chucvunguoikykhenthuong]',  $donvi_kt->lanhdao ?? '', $thongtintotrinhdenghi);
        $thongtintotrinhdenghi = str_replace('[hinhthuckhenthuong]',  'Bằng khen', $thongtintotrinhdenghi);

        $thongtintotrinhdenghi = str_replace('[donvidenghi]',  $tendonvi, $thongtintotrinhdenghi);
        $thongtintotrinhdenghi = str_replace('[sototrinh]',  $model->sototrinh, $thongtintotrinhdenghi);
        $thongtintotrinhdenghi = str_replace('[ngayhoso]',  Date2Str($model->ngayhoso), $thongtintotrinhdenghi);
        // soluongtapthe
        // soluongcanhan
        $m_canhan = App\Model\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi_canhan::where('mahosotdkt', $model->mahosotdkt)
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
            // $thongtintotrinhdenghi = str_replace('<p style=&#34;margin-left:25px;&#34;>[khenthuongcanhan]</p>',  $s_canhan, $thongtintotrinhdenghi);
            $thongtintotrinhdenghi = str_replace('[khenthuongcanhan]',  $s_canhan, $thongtintotrinhdenghi);
            $thongtintotrinhdenghi = str_replace('[soluongcanhan]', $m_canhan->count() . ' cá nhân', $thongtintotrinhdenghi);
        }

        //Tập thể
        $m_tapthe = App\Model\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi_tapthe::where('mahosotdkt', $model->mahosotdkt)
            ->where('ketqua', '1')->orderby('stt')->get();
        if ($m_tapthe->count() > 0) {
            $s_tapthe = '';
            $i = 1;
            foreach ($m_tapthe as $chitiet) {
                $s_tapthe .= '<p style=&#34;margin-left:40px;&#34;>' .
                    ($i++) . '. ' . $chitiet->tentapthe .
                    '</p>';
            }
            $thongtintotrinhdenghi = str_replace('[khenthuongtapthe]',  $s_tapthe, $thongtintotrinhdenghi);
            $thongtintotrinhdenghi = str_replace('[soluongtapthe]', $m_tapthe->count() . ' tập thể', $thongtintotrinhdenghi);
        }

        $model->thongtintotrinhdenghi = $thongtintotrinhdenghi;
    } else {
        //Load dự thảo theo mẫu
        if ($model->thongtintotrinhdenghi == '') {
            if ($maduthao == null)
                $thongtintotrinhdenghi = App\Model\DanhMuc\duthaoquyetdinh::wherein('phanloai', ['TOTRINHPHEDUYET'])->first()->codehtml ?? '';
            else
                $thongtintotrinhdenghi = App\Model\DanhMuc\duthaoquyetdinh::where('maduthao', $maduthao)->first()->codehtml ?? '';

            $donvi = dsdonvi::where('madonvi', $model->madonvi)->first();
            $donvi_xd = dsdonvi::where('madonvi', $model->madonvi_xd)->first();
            $donvi_kt = dsdonvi::where('madonvi', $model->madonvi_kt)->first();
            $tendonvi = $donvi->tendonvi ?? '';
            //dd($thongtintotrinhdenghi);
            //Gán thông tin
            $thongtintotrinhdenghi = str_replace('[sototrinhdenghi]', $model->sototrinhdenghi, $thongtintotrinhdenghi);
            $thongtintotrinhdenghi = str_replace('[noidung]', $model->noidung, $thongtintotrinhdenghi);
            $thongtintotrinhdenghi = str_replace('[donvixetduyet]',  $donvi_xd->tendonvi ?? '', $thongtintotrinhdenghi);
            $thongtintotrinhdenghi = str_replace('[ngaythangtotrinhdenghi]',  Date2Str($model->ngaythangtotrinhdenghi), $thongtintotrinhdenghi);

            $thongtintotrinhdenghi = str_replace('[diadanh]',  $donvi->diadanh, $thongtintotrinhdenghi);
            $thongtintotrinhdenghi = str_replace('[chucvunguoikyxetduyet]',  $donvi_xd->cdlanhdao ?? '', $thongtintotrinhdenghi);
            $thongtintotrinhdenghi = str_replace('[nguoikytotrinhxetduyet]',  $donvi_xd->lanhdao ?? '', $thongtintotrinhdenghi);

            $thongtintotrinhdenghi = str_replace('[chucvunguoikykhenthuong]',  $donvi_kt->lanhdao ?? '', $thongtintotrinhdenghi);
            $thongtintotrinhdenghi = str_replace('[hinhthuckhenthuong]',  'Bằng khen', $thongtintotrinhdenghi);

            $thongtintotrinhdenghi = str_replace('[donvidenghi]',  $tendonvi, $thongtintotrinhdenghi);
            $thongtintotrinhdenghi = str_replace('[sototrinh]',  $model->sototrinh, $thongtintotrinhdenghi);
            $thongtintotrinhdenghi = str_replace('[ngayhoso]',  Date2Str($model->ngayhoso), $thongtintotrinhdenghi);
            // soluongtapthe
            // soluongcanhan
            $m_canhan = App\Model\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi_canhan::where('mahosotdkt', $model->mahosotdkt)
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
                // $thongtintotrinhdenghi = str_replace('<p style=&#34;margin-left:25px;&#34;>[khenthuongcanhan]</p>',  $s_canhan, $thongtintotrinhdenghi);
                $thongtintotrinhdenghi = str_replace('[khenthuongcanhan]',  $s_canhan, $thongtintotrinhdenghi);
                $thongtintotrinhdenghi = str_replace('[soluongcanhan]', $m_canhan->count() . ' cá nhân', $thongtintotrinhdenghi);
            }

            //Tập thể
            $m_tapthe = App\Model\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi_tapthe::where('mahosotdkt', $model->mahosotdkt)
                ->where('ketqua', '1')->orderby('stt')->get();
            if ($m_tapthe->count() > 0) {
                $s_tapthe = '';
                $i = 1;
                foreach ($m_tapthe as $chitiet) {
                    $s_tapthe .= '<p style=&#34;margin-left:40px;&#34;>' .
                        ($i++) . '. ' . $chitiet->tentapthe .
                        '</p>';
                }
                $thongtintotrinhdenghi = str_replace('[khenthuongtapthe]',  $s_tapthe, $thongtintotrinhdenghi);
                $thongtintotrinhdenghi = str_replace('[soluongtapthe]', $m_tapthe->count() . ' tập thể', $thongtintotrinhdenghi);
            }

            $model->thongtintotrinhdenghi = $thongtintotrinhdenghi;
        }
    }
}

function getTaoDuThaoToTrinhHoSo(&$model, $maduthao = null)
{
    //$maduthao = 'ALL' =>khỏi tạo lại dự thảo
    if ($maduthao  == 'ALL') {
        $thongtintotrinhhoso = App\Model\DanhMuc\duthaoquyetdinh::wherein('phanloai', ['TOTRINHHOSO'])->first()->codehtml ?? '';
        $donvi = dsdonvi::where('madonvi', $model->madonvi)->first();
        $tendonvi = $donvi->tendonvi ?? '';

        //Gán thông tin
        $thongtintotrinhhoso = str_replace('[noidung]', $model->noidung, $thongtintotrinhhoso);
        $thongtintotrinhhoso = str_replace('[donvidenghi]',  $tendonvi, $thongtintotrinhhoso);
        $thongtintotrinhhoso = str_replace('[sototrinh]',  $model->sototrinh, $thongtintotrinhhoso);
        $thongtintotrinhhoso = str_replace('[ngayhoso]',  Date2Str($model->ngayhoso), $thongtintotrinhhoso);
        //Thông tin đơn vị
        $thongtintotrinhhoso = str_replace('[tendvcqhienthi]',  $donvi->tendvcqhienthi, $thongtintotrinhhoso);
        $thongtintotrinhhoso = str_replace('[diadanh]',  $donvi->diadanh, $thongtintotrinhhoso);
        $thongtintotrinhhoso = str_replace('[chucvunguoiky]',  $model->chucvunguoiky, $thongtintotrinhhoso);
        $thongtintotrinhhoso = str_replace('[nguoikytotrinh]',  $donvi->nguoikytotrinh, $thongtintotrinhhoso);

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
            // $thongtintotrinhhoso = str_replace('<p style=&#34;margin-left:25px;&#34;>[khenthuongcanhan]</p>',  $s_canhan, $thongtintotrinhhoso);
            $thongtintotrinhhoso = str_replace('[khenthuongcanhan]',  $s_canhan, $thongtintotrinhhoso);
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
            $thongtintotrinhhoso = str_replace('[khenthuongtapthe]',  $s_tapthe, $thongtintotrinhhoso);
        }

        //Hộ gia đình        
        $m_hogiadinh = App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_hogiadinh::where('mahosotdkt', $model->mahosotdkt)
            ->where('ketqua', '1')->orderby('stt')->get();
        if ($m_hogiadinh->count() > 0) {
            $s_hgd = '';
            $i = 1;
            foreach ($m_hogiadinh as $chitiet) {
                $s_hgd .= '<p style=&#34;margin-left:40px;&#34;>' .
                    ($i++) . '. ' . $chitiet->tentapthe .
                    '</p>';
            }
            $thongtintotrinhhoso = str_replace('[khenthuonghogiadinh]',  $s_hgd, $thongtintotrinhhoso);
        }

        $model->thongtintotrinhhoso = $thongtintotrinhhoso;
    } else {
        //Load dự thảo theo mẫu
        if ($model->thongtintotrinhhoso == '') {
            if ($maduthao == null)
                $thongtintotrinhhoso = App\Model\DanhMuc\duthaoquyetdinh::wherein('phanloai', ['TOTRINHHOSO'])->first()->codehtml ?? '';
            else
                $thongtintotrinhhoso = App\Model\DanhMuc\duthaoquyetdinh::where('maduthao', $maduthao)->first()->codehtml ?? '';

            $donvi = dsdonvi::where('madonvi', $model->madonvi)->first();
            $tendonvi = $donvi->tendonvi ?? '';

            //Gán thông tin
            $thongtintotrinhhoso = str_replace('[noidung]', $model->noidung, $thongtintotrinhhoso);
            $thongtintotrinhhoso = str_replace('[donvidenghi]',  $tendonvi, $thongtintotrinhhoso);
            $thongtintotrinhhoso = str_replace('[sototrinh]',  $model->sototrinh, $thongtintotrinhhoso);
            $thongtintotrinhhoso = str_replace('[ngayhoso]',  Date2Str($model->ngayhoso), $thongtintotrinhhoso);
            //Thông tin đơn vị
            $thongtintotrinhhoso = str_replace('[diadanh]',  $donvi->diadanh, $thongtintotrinhhoso);
            $thongtintotrinhhoso = str_replace('[chucvunguoiky]',  $model->chucvunguoiky, $thongtintotrinhhoso);
            $thongtintotrinhhoso = str_replace('[nguoikytotrinh]',  $donvi->nguoikytotrinh, $thongtintotrinhhoso);

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
                // $thongtintotrinhhoso = str_replace('<p style=&#34;margin-left:25px;&#34;>[khenthuongcanhan]</p>',  $s_canhan, $thongtintotrinhhoso);
                $thongtintotrinhhoso = str_replace('[khenthuongcanhan]',  $s_canhan, $thongtintotrinhhoso);
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
                $thongtintotrinhhoso = str_replace('[khenthuongtapthe]',  $s_tapthe, $thongtintotrinhhoso);
            }

            //Hộ gia đình        
            $m_hogiadinh = App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_hogiadinh::where('mahosotdkt', $model->mahosotdkt)
                ->where('ketqua', '1')->orderby('stt')->get();
            if ($m_hogiadinh->count() > 0) {
                $s_hgd = '';
                $i = 1;
                foreach ($m_hogiadinh as $chitiet) {
                    $s_hgd .= '<p style=&#34;margin-left:40px;&#34;>' .
                        ($i++) . '. ' . $chitiet->tentapthe .
                        '</p>';
                }
                $thongtintotrinhhoso = str_replace('[khenthuonghogiadinh]',  $s_hgd, $thongtintotrinhhoso);
            }

            $model->thongtintotrinhhoso = $thongtintotrinhhoso;
        }
    }
}

function getTaoDuThaoToTrinhPheDuyet(&$model, $maduthao = null)
{
    //$maduthao = 'ALL' =>khỏi tạo lại dự thảo
    if ($maduthao  == 'ALL') {
        $thongtintotrinhdenghi = App\Model\DanhMuc\duthaoquyetdinh::wherein('phanloai', ['TOTRINHPHEDUYET'])->first()->codehtml ?? '';
        $donvi = dsdonvi::where('madonvi', $model->madonvi)->first();
        $donvi_xd = dsdonvi::where('madonvi', $model->madonvi_xd)->first();
        $donvi_kt = dsdonvi::where('madonvi', $model->madonvi_kt)->first();
        $tendonvi = $donvi->tendonvi ?? '';
        //dd($thongtintotrinhdenghi);
        //Gán thông tin
        $thongtintotrinhdenghi = str_replace('[sototrinhdenghi]', $model->sototrinhdenghi, $thongtintotrinhdenghi);
        $thongtintotrinhdenghi = str_replace('[noidung]', $model->noidung, $thongtintotrinhdenghi);
        $thongtintotrinhdenghi = str_replace('[donvixetduyet]',  $donvi_xd->tendonvi ?? '', $thongtintotrinhdenghi);
        $thongtintotrinhdenghi = str_replace('[ngaythangtotrinhdenghi]',  Date2Str($model->ngaythangtotrinhdenghi), $thongtintotrinhdenghi);

        $thongtintotrinhdenghi = str_replace('[diadanh]',  $donvi->diadanh, $thongtintotrinhdenghi);
        $thongtintotrinhdenghi = str_replace('[chucvunguoikyxetduyet]',  $donvi_xd->cdlanhdao ?? '', $thongtintotrinhdenghi);
        $thongtintotrinhdenghi = str_replace('[nguoikytotrinhxetduyet]',  $donvi_xd->lanhdao ?? '', $thongtintotrinhdenghi);

        $thongtintotrinhdenghi = str_replace('[donvikhenthuong]',  $donvi_kt->tendonvi ?? '', $thongtintotrinhdenghi);
        $thongtintotrinhdenghi = str_replace('[chucvunguoikykhenthuong]',  $donvi_kt->lanhdao ?? '', $thongtintotrinhdenghi);
        $thongtintotrinhdenghi = str_replace('[hinhthuckhenthuong]',  'Bằng khen', $thongtintotrinhdenghi);

        $thongtintotrinhdenghi = str_replace('[donvidenghi]',  $tendonvi, $thongtintotrinhdenghi);
        $thongtintotrinhdenghi = str_replace('[sototrinh]',  $model->sototrinh, $thongtintotrinhdenghi);
        $thongtintotrinhdenghi = str_replace('[ngayhoso]',  Date2Str($model->ngayhoso), $thongtintotrinhdenghi);
        // soluongtapthe
        // soluongcanhan
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
            // $thongtintotrinhdenghi = str_replace('<p style=&#34;margin-left:25px;&#34;>[khenthuongcanhan]</p>',  $s_canhan, $thongtintotrinhdenghi);
            $thongtintotrinhdenghi = str_replace('[khenthuongcanhan]',  $s_canhan, $thongtintotrinhdenghi);
            $thongtintotrinhdenghi = str_replace('[soluongcanhan]', $m_canhan->count() . ' cá nhân', $thongtintotrinhdenghi);
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
            $thongtintotrinhdenghi = str_replace('[khenthuongtapthe]',  $s_tapthe, $thongtintotrinhdenghi);
            $thongtintotrinhdenghi = str_replace('[soluongtapthe]', $m_tapthe->count() . ' tập thể', $thongtintotrinhdenghi);
        }

        //Hộ gia đình
        $m_hogiadinh = App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_hogiadinh::where('mahosotdkt', $model->mahosotdkt)
            ->where('ketqua', '1')->orderby('stt')->get();
        if ($m_hogiadinh->count() > 0) {
            $s_hogiadinh = '';
            $i = 1;
            foreach ($m_hogiadinh as $chitiet) {
                $s_hogiadinh .= '<p style=&#34;margin-left:40px;&#34;>' .
                    ($i++) . '. ' . $chitiet->tentapthe .
                    '</p>';
            }
            $thongtintotrinhdenghi = str_replace('[khenthuonghogiadinh]',  $s_tapthe, $thongtintotrinhdenghi);
        }

        $model->thongtintotrinhdenghi = $thongtintotrinhdenghi;
    } else {
        //Load dự thảo theo mẫu
        if ($model->thongtintotrinhdenghi == '') {
            if ($maduthao == null)
                $thongtintotrinhdenghi = App\Model\DanhMuc\duthaoquyetdinh::wherein('phanloai', ['TOTRINHPHEDUYET'])->first()->codehtml ?? '';
            else
                $thongtintotrinhdenghi = App\Model\DanhMuc\duthaoquyetdinh::where('maduthao', $maduthao)->first()->codehtml ?? '';

            $donvi = dsdonvi::where('madonvi', $model->madonvi)->first();
            $donvi_xd = dsdonvi::where('madonvi', $model->madonvi_xd)->first();
            $donvi_kt = dsdonvi::where('madonvi', $model->madonvi_kt)->first();
            $tendonvi = $donvi->tendonvi ?? '';
            //dd($thongtintotrinhdenghi);
            //Gán thông tin
            $thongtintotrinhdenghi = str_replace('[sototrinhdenghi]', $model->sototrinhdenghi, $thongtintotrinhdenghi);
            $thongtintotrinhdenghi = str_replace('[noidung]', $model->noidung, $thongtintotrinhdenghi);
            $thongtintotrinhdenghi = str_replace('[donvixetduyet]',  $donvi_xd->tendonvi ?? '', $thongtintotrinhdenghi);
            $thongtintotrinhdenghi = str_replace('[ngaythangtotrinhdenghi]',  Date2Str($model->ngaythangtotrinhdenghi), $thongtintotrinhdenghi);

            $thongtintotrinhdenghi = str_replace('[diadanh]',  $donvi->diadanh, $thongtintotrinhdenghi);
            $thongtintotrinhdenghi = str_replace('[chucvunguoikyxetduyet]',  $donvi_xd->cdlanhdao ?? '', $thongtintotrinhdenghi);
            $thongtintotrinhdenghi = str_replace('[nguoikytotrinhxetduyet]',  $donvi_xd->lanhdao ?? '', $thongtintotrinhdenghi);

            $thongtintotrinhdenghi = str_replace('[chucvunguoikykhenthuong]',  $donvi_kt->lanhdao ?? '', $thongtintotrinhdenghi);
            $thongtintotrinhdenghi = str_replace('[hinhthuckhenthuong]',  'Bằng khen', $thongtintotrinhdenghi);

            $thongtintotrinhdenghi = str_replace('[donvidenghi]',  $tendonvi, $thongtintotrinhdenghi);
            $thongtintotrinhdenghi = str_replace('[sototrinh]',  $model->sototrinh, $thongtintotrinhdenghi);
            $thongtintotrinhdenghi = str_replace('[ngayhoso]',  Date2Str($model->ngayhoso), $thongtintotrinhdenghi);
            // soluongtapthe
            // soluongcanhan
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
                // $thongtintotrinhdenghi = str_replace('<p style=&#34;margin-left:25px;&#34;>[khenthuongcanhan]</p>',  $s_canhan, $thongtintotrinhdenghi);
                $thongtintotrinhdenghi = str_replace('[khenthuongcanhan]',  $s_canhan, $thongtintotrinhdenghi);
                $thongtintotrinhdenghi = str_replace('[soluongcanhan]', $m_canhan->count() . ' cá nhân', $thongtintotrinhdenghi);
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
                $thongtintotrinhdenghi = str_replace('[khenthuongtapthe]',  $s_tapthe, $thongtintotrinhdenghi);
                $thongtintotrinhdenghi = str_replace('[soluongtapthe]', $m_tapthe->count() . ' tập thể', $thongtintotrinhdenghi);
            }

            //Hộ gia đình
            $m_hogiadinh = App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_hogiadinh::where('mahosotdkt', $model->mahosotdkt)
                ->where('ketqua', '1')->orderby('stt')->get();
            if ($m_hogiadinh->count() > 0) {
                $s_hogiadinh = '';
                $i = 1;
                foreach ($m_hogiadinh as $chitiet) {
                    $s_hogiadinh .= '<p style=&#34;margin-left:40px;&#34;>' .
                        ($i++) . '. ' . $chitiet->tentapthe .
                        '</p>';
                }
                $thongtintotrinhdenghi = str_replace('[khenthuonghogiadinh]',  $s_tapthe, $thongtintotrinhdenghi);
            }
            $model->thongtintotrinhdenghi = $thongtintotrinhdenghi;
        }
    }
}

function getTaoQuyetDinhKT(&$model)
{
    if ($model->thongtinquyetdinh == '') {
        getTaoDuThaoKT($model);        
    }    
    $tendonvi = dsdonvi::where('madonvi', $model->madonvi)->first()->tendonvi ?? '';
    $donvi_xd = dsdonvi::where('madonvi', $model->madonvi_xd)->first();
    $model->thongtinquyetdinh = str_replace('[chucvunguoikyqd]', $model->chucvunguoikyqd, $model->thongtinquyetdinh);
    $model->thongtinquyetdinh = str_replace('[hotennguoikyqd]',  $model->hotennguoikyqd, $model->thongtinquyetdinh);
    $model->thongtinquyetdinh = str_replace('[soqd]',  $model->soqd, $model->thongtinquyetdinh);
    $model->thongtinquyetdinh = str_replace('[sototrinh]',  $model->sototrinh, $model->thongtinquyetdinh);
    $model->thongtinquyetdinh = str_replace('[diadanh]',  '......', $model->thongtinquyetdinh);
    $model->thongtinquyetdinh = str_replace('[ngayqd]',  Date2Str($model->ngayqd), $model->thongtinquyetdinh);
    $model->thongtinquyetdinh = str_replace('[ngayhoso]',  Date2Str($model->ngayhoso), $model->thongtinquyetdinh);
    $model->thongtinquyetdinh = str_replace('[donvidenghi]',  $tendonvi, $model->thongtinquyetdinh);
    $model->thongtinquyetdinh = str_replace('[donvikhenthuong]',  $model->donvikhenthuong, $model->thongtinquyetdinh);
    $model->thongtinquyetdinh = str_replace('[donvixetduyet]',  $donvi_xd->tendonvi ?? '', $model->thongtinquyetdinh);
    //dd($model);
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
        $donvi_xd = dsdonvi::where('madonvi', $model->madonvi_xd)->first();

        $thongtinquyetdinh = str_replace('[noidung]', $model->noidung, $thongtinquyetdinh);
        $thongtinquyetdinh = str_replace('[donvidenghi]',  $tendonvi, $thongtinquyetdinh);
        $thongtinquyetdinh = str_replace('[sototrinh]',  $model->sototrinh, $thongtinquyetdinh);
        $thongtinquyetdinh = str_replace('[ngayhoso]',  Date2Str($model->ngayhoso), $thongtinquyetdinh);
        $thongtinquyetdinh = str_replace('[hinhthuckhenthuong]',  'Bằng khen', $thongtinquyetdinh);
        $thongtinquyetdinh = str_replace('[donvixetduyet]',  $donvi_xd->tendonvi ?? '', $thongtinquyetdinh);

        // Lấy danh sách khen thưởng theo cá nhân và tập thể

        $m_canhan = App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_canhan::where('mahosotdkt', $model->mahosotdkt)
            ->where('ketqua', '1')->orderby('stt')->get();

        $m_tapthe = App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_tapthe::where('mahosotdkt', $model->mahosotdkt)
            ->where('ketqua', '1')->orderby('stt')->get();
        //Xử lý các trường hợp

        if ($m_canhan->count() > 0 && $m_tapthe->count() > 0) {
            //Cá nhân
            $s_canhan = '';
            $i = 1;
            foreach ($m_canhan as $canhan) {
                $s_canhan .= '<p style=&#34;margin-left:40px;&#34;>' .
                    ($i++) . '. ' . $canhan->tendoituong .
                    ($canhan->chucvu == '' ? '' : (', ' . $canhan->chucvu)) .
                    ($canhan->tencoquan == '' ? '' : (' ' . $canhan->tencoquan)) .
                    '</p>';
                //dd($s_canhan);
            }
            //dd($s_canhan);
            // $thongtinquyetdinh = str_replace('<p style=&#34;margin-left:25px;&#34;>[khenthuongcanhan]</p>',  $s_canhan, $thongtinquyetdinh);
            $thongtinquyetdinh = str_replace('[khenthuongcanhan]',  $s_canhan, $thongtinquyetdinh);
            

            //Tập thể
            $s_tapthe = '';
            $i = 1;
            foreach ($m_tapthe as $chitiet) {
                $s_tapthe .= '<p style=&#34;margin-left:40px;&#34;>' .
                    ($i++) . '. ' . $chitiet->tentapthe .
                    '</p>';
            }
            $thongtinquyetdinh = str_replace('[khenthuongtapthe]',  $s_tapthe, $thongtinquyetdinh);

            $thongtinquyetdinh = str_replace('[soluongcanhan]', $m_canhan->count() . ' cá nhân', $thongtinquyetdinh);
            $thongtinquyetdinh = str_replace('[soluongtapthe]', $m_tapthe->count() . ' tập thể', $thongtinquyetdinh);
        } else {
            //Cá nhân
            if ($m_canhan->count() > 0) {
                $s_canhan = '';
                $i = 1;
                foreach ($m_canhan as $canhan) {
                    $s_canhan .= '<p style=&#34;margin-left:40px;&#34;>' .
                        ($i++) . '. ' . $canhan->tendoituong .
                        ($canhan->chucvu == '' ? '' : (', ' . $canhan->chucvu)) .
                        ($canhan->tencoquan == '' ? '' : (' ' . $canhan->tencoquan)) .
                        '</p>';
                    //dd($s_canhan);
                }
                //dd($s_canhan);
                // $thongtinquyetdinh = str_replace('<p style=&#34;margin-left:25px;&#34;>[khenthuongcanhan]</p>',  $s_canhan, $thongtinquyetdinh);
                $thongtinquyetdinh = str_replace('[khenthuongcanhan]',  $s_canhan, $thongtinquyetdinh);
                
                $thongtinquyetdinh = str_replace('II. Tập thể',  '', $thongtinquyetdinh);
                $thongtinquyetdinh = str_replace('[khenthuongtapthe]',  '', $thongtinquyetdinh);
                $thongtinquyetdinh = str_replace('[soluongtapthe] và [soluongcanhan]', $m_canhan->count() . ' cá nhân', $thongtinquyetdinh);
            }

            //Tập thể
            if ($m_tapthe->count() > 0) {
                $s_tapthe = '';
                $i = 1;
                foreach ($m_tapthe as $chitiet) {
                    $s_tapthe .= '<p style=&#34;margin-left:40px;&#34;>' .
                        ($i++) . '. ' . $chitiet->tentapthe .
                        '</p>';
                }
                $thongtinquyetdinh = str_replace('[khenthuongtapthe]',  $s_tapthe, $thongtinquyetdinh);
                $thongtinquyetdinh = str_replace('I. Cá nhân',  '', $thongtinquyetdinh);
                $thongtinquyetdinh = str_replace('II. Tập thể',  'I. Tập thể', $thongtinquyetdinh);
                $thongtinquyetdinh = str_replace('[khenthuongcanhan]',  '', $thongtinquyetdinh);
                $thongtinquyetdinh = str_replace('[soluongtapthe] và [soluongcanhan]', $m_tapthe->count() . ' tập thể', $thongtinquyetdinh);
            }
        }

        //Hộ gia đình        
        $m_hogiadinh = App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_hogiadinh::where('mahosotdkt', $model->mahosotdkt)
            ->where('ketqua', '1')->orderby('stt')->get();
        if ($m_hogiadinh->count() > 0) {
            $s_hgd = '';
            $i = 1;
            foreach ($m_hogiadinh as $chitiet) {
                $s_hgd .= '<p style=&#34;margin-left:40px;&#34;>' .
                    ($i++) . '. ' . $chitiet->tentapthe .
                    '</p>';
            }
            $thongtinquyetdinh = str_replace('[khenthuonghogiadinh]',  $s_hgd, $thongtinquyetdinh);
        }
        //gán thong tin quyet dinh
        //dd($thongtinquyetdinh);
        $model->thongtinquyetdinh = $thongtinquyetdinh;
    }
}

function getTaoQuyetDinhKTCumKhoi(&$model)
{
    if ($model->thongtinquyetdinh == '') {
        getTaoDuThaoKTCumKhoi($model);
    }
    $tendonvi = dsdonvi::where('madonvi', $model->madonvi)->first()->tendonvi ?? '';
    $donvi_xd = dsdonvi::where('madonvi', $model->madonvi_xd)->first();
    $model->thongtinquyetdinh = str_replace('[chucvunguoikyqd]', $model->chucvunguoikyqd, $model->thongtinquyetdinh);
    $model->thongtinquyetdinh = str_replace('[hotennguoikyqd]',  $model->hotennguoikyqd, $model->thongtinquyetdinh);
    $model->thongtinquyetdinh = str_replace('[soqd]',  $model->soqd, $model->thongtinquyetdinh);
    $model->thongtinquyetdinh = str_replace('[sototrinh]',  $model->sototrinh, $model->thongtinquyetdinh);
    $model->thongtinquyetdinh = str_replace('[diadanh]',  '......', $model->thongtinquyetdinh);
    $model->thongtinquyetdinh = str_replace('[ngayqd]',  Date2Str($model->ngayqd), $model->thongtinquyetdinh);
    $model->thongtinquyetdinh = str_replace('[ngayhoso]',  Date2Str($model->ngayhoso), $model->thongtinquyetdinh);
    $model->thongtinquyetdinh = str_replace('[donvidenghi]',  $tendonvi, $model->thongtinquyetdinh);
    $model->thongtinquyetdinh = str_replace('[donvikhenthuong]',  $model->donvikhenthuong, $model->thongtinquyetdinh);
    $model->thongtinquyetdinh = str_replace('[donvixetduyet]',  $donvi_xd->tendonvi ?? '', $model->thongtinquyetdinh);
}

function getTaoDuThaoKTCumKhoi(&$model, $maduthao = null)
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
        $thongtinquyetdinh = str_replace('[hinhthuckhenthuong]',  'Bằng khen', $thongtinquyetdinh);

        $m_canhan = App\Model\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi_canhan::where('mahosotdkt', $model->mahosotdkt)
            ->where('ketqua', '1')->orderby('stt')->get();
        //dd($m_canhan);
        if ($m_canhan->count() > 0) {
            $s_canhan = '';
            $i = 1;
            foreach ($m_canhan as $canhan) {
                $s_canhan .= '<p style=&#34;margin-left:40px;&#34;>' .
                    ($i++) . '. ' . $canhan->tendoituong .
                    ($canhan->chucvu == '' ? '' : (', ' . $canhan->chucvu)) .
                    ($canhan->tencoquan == '' ? '' : (' ' . $canhan->tencoquan)) .
                    '</p>';
                //dd($s_canhan);
            }
            //dd($s_canhan);
            // $thongtinquyetdinh = str_replace('<p style=&#34;margin-left:25px;&#34;>[khenthuongcanhan]</p>',  $s_canhan, $thongtinquyetdinh);
            $thongtinquyetdinh = str_replace('[khenthuongcanhan]',  $s_canhan, $thongtinquyetdinh);
            $thongtinquyetdinh = str_replace('[soluongcanhan]', $m_canhan->count() . ' cá nhân', $thongtinquyetdinh);
        }

        //Tập thể
        $m_tapthe = App\Model\NghiepVu\CumKhoiThiDua\dshosotdktcumkhoi_tapthe::where('mahosotdkt', $model->mahosotdkt)
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
            $thongtinquyetdinh = str_replace('[soluongtapthe]', $m_tapthe->count() . ' tập thể', $thongtinquyetdinh);
        }
        //Hộ gia đình        
        $m_hogiadinh = App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong_hogiadinh::where('mahosotdkt', $model->mahosotdkt)
            ->where('ketqua', '1')->orderby('stt')->get();
        if ($m_hogiadinh->count() > 0) {
            $s_hgd = '';
            $i = 1;
            foreach ($m_hogiadinh as $chitiet) {
                $s_hgd .= '<p style=&#34;margin-left:40px;&#34;>' .
                    ($i++) . '. ' . $chitiet->tentapthe .
                    '</p>';
            }
            $thongtinquyetdinh = str_replace('[khenthuonghogiadinh]',  $s_hgd, $thongtinquyetdinh);
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
        'H' => 'Đơn vị hành chính cấp Huyện',
        'X' => 'Đơn vị hành chính cấp Xã',
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
        'TW' => 'Cấp Nhà nước',
        'T' => 'Cấp Tỉnh',
        'H' => 'Cấp Huyện',
        'X' => 'Cấp Xã',
    );
}

function getNhomChiQuy()
{
    return array(
        'KHENTHUONG' => 'Chi khen thưởng',
        'KHAC' => 'Chi khác',
    );
}

function getPhanLoaiQuy()
{
    return array(
        'THU' => 'Thu',
        'CHI' => 'Chi',
    );
}

function getDoiTuongApDung()
{
    return array(
        'CANHAN' => 'Cá nhân',
        'TAPTHE' => 'Tập thể',
        'HOGIADINH' => 'Hộ gia đình',
    );
}

function getPhamViKhenThuong()
{
    return array(
        'T' => 'Cấp Tỉnh',
        'SBN' => 'Cấp Sở, ban, ngành',
        'H' => 'Cấp Huyện',
        'X' => 'Cấp Xã',
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
        'DANHHIEUTD' => 'Danh hiệu thi đua',
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
        'TW' => 'Phong trào thi đua cấp Nhà nước',
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
        'TW' => 'Phong trào thi đua cấp Trung Ương',
    );
    $a_kq['H'] =  array(
        //'X' => 'Phong trào thi đua cấp Xã',
        'SBN' => 'Phong trào cho Sở, ban, ngành',
        'H' => 'Phong trào thi đua cấp Huyện',
    );
    $a_kq['X'] =  array(
        'X' => 'Phong trào thi đua cấp Xã',
    );
    return $a_kq[$capdo];
}

function getPhamViApDungPhongTrao($capdo = 'T')
{
    $a_kq['T'] =  array('T', 'TW',);
    $a_kq['H'] =  array('H', 'SBN', 'T', 'TW',);
    $a_kq['X'] =  array('X', 'H', 'T', 'TW',);
    return $a_kq[$capdo];
}

function getPhamViThongKe($capdo = 'T')
{
    $a_kq['T'] =  array('T' => 'Cấp Tỉnh', 'H' => 'Cấp Huyện', 'X' => 'Cấp Xã');
    $a_kq['H'] =  array('H' => 'Cấp Huyện', 'X' => 'Cấp Xã');
    $a_kq['X'] =  array('X' => 'Cấp Xã');
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
        'vbhdcd' => 'Văn bản hướng dẫn, chỉ đạo',
        'vbdh' => 'Văn bản điều hành',
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
        'DD' => 'Chờ chuyển<br>khen thưởng',
    ];
}

//Gán cho mặc định chức năg
function getTrangThaiChucNangHoSo($trangthai = 'ALL')
{
    $a_kq = [
        'CC' => 'Chờ chuyển', //=>Nộp hồ sơ bình thưởng
        'DD' => 'Chờ chuyển khen thưởng', //
        'CXKT' => 'Chờ xét khen thưởng', //Đã gán madonvi_xd,madonvi_kt,
        'DKT' => 'Đã khen thưởng', //Đã gán madonvi_xd,madonvi_kt,
        'BTL' => 'Bị trả lại',
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

function getTrangThai_TD_HoSo($trangthai)
{
    $a_trangthai = [
        'CC' => [
            'trangthai' => 'Chờ chuyển',
            'class' => 'badge badge-warning'
        ],

        'CD' => [
            'trangthai' => 'Chờ duyệt',
            'class' => 'badge badge-info'
        ],
        'BTL' => [
            'trangthai' => 'Bị trả<br>lại',
            'class' => 'badge badge-danger'
        ],

        'BTLXD' => [
            'trangthai' => 'Trả lại<br>xét duyệt',
            'class' => 'badge badge-danger'
        ],

        'CNXKT' => [
            'trangthai' => 'Chờ nhận<br>để xét<br>khen thưởng',
            'class' => 'badge badge-info'
        ],
        'CXKT' => [
            'trangthai' => 'Chờ xét<br>khen thưởng',
            'class' => 'badge badge-warning'
        ],

        'DKT' => [
            'trangthai' => 'Đã khen<br>thưởng',
            'class' => 'badge badge-success'
        ],
        'DD' => [
            'trangthai' => 'Chờ chuyển<br>khen thưởng',
            'class' => 'badge badge-success'
        ],

        'DXKT' => [
            'trangthai' => 'Đang xét<br>khen thưởng',
            'class' => 'badge badge-warning'
        ],
    ];

    return $a_trangthai[$trangthai] ?? ['trangthai' => $trangthai, 'class' => 'badge badge-info'];
}

function getPhanLoaiTaiLieuDK($phanloaihoso = 'ALL')
{
    $a_kq = [
        'TOTRINH' => 'Tờ trình đề nghị khen thưởng',
        'BAOCAO' => 'Báo cáo thành tích',
        'BIENBAN' => 'Biên bản cuộc họp',
        'DTKH' => 'Đề tài khoa học',
        'SANGKIEN' => 'Sáng kiến sáng tạo',
        'TOTRINHKQ' => 'Tờ trình kết quả khen thưởng',
        'QDKT' => 'Quyết định khen thưởng',
        'KHAC' => 'Tài liệu khác',
    ];
    //Bỏ các giấy tờ đính kèm xét duyệt và qd
    if ($phanloaihoso == 'DENGHI') {
        unset($a_kq['TOTRINHKQ']);
        unset($a_kq['QDKT']);
    }
    return $a_kq;
}
