<?php

namespace App\Http\Controllers\NghiepVu\_DungChung;


use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\DanhMuc\dmloaihinhkhenthuong;
use App\Model\DanhMuc\dmnhomphanloai_chitiet;
use App\Model\DanhMuc\dsdonvi;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothamgiaphongtraotd;
use App\Model\NghiepVu\ThiDuaKhenThuong\dshosothiduakhenthuong;
use App\Model\NghiepVu\ThiDuaKhenThuong\dsphongtraothidua;

class dungchung_nghiepvuController extends Controller
{
    public function getDonViKhenThuong_ThemHS(Request $request)
    {
        $inputs = $request->all();
        $donvi = dsdonvi::where('madonvi', $inputs['madonvi'])->first();
        if ($donvi != null)
            $model = getDonViQuanLyDiaBan($donvi);
        else
            $model = ['ALL' => 'Chọn đơn vị'];
        $result['status'] = 'success';
        $result['message'] = '<div id="donvikhenthuong" class="col-6">';
        $result['message'] .= '<label>Đơn vị khen thưởng</label>';
        $result['message'] .= '<select id="madonvi_kt_themhs" class="form-control" required="" name="madonvi_kt">';
        foreach ($model as $key => $val) {
            $result['message'] .= '<option value="' . $key . '">' . $val . '</option>';
        }
        $result['message'] .= '</select></div>';
        die(json_encode($result));
    }

    function htmlTapThe(&$result, $model, $url, $bXoa = true, $maloaihinhkt)
    {
        if (isset($model)) {
            //$a_hinhthuckt = array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt');
            //$a_danhhieutd = array_column(dmdanhhieuthidua::all()->toArray(), 'tendanhhieutd', 'madanhhieutd');
            $a_tapthe = array_column(dmnhomphanloai_chitiet::all()->toarray(), 'tenphanloai', 'maphanloai');
            $a_dhkt = getDanhHieuKhenThuong('ALL');
            $a_loaihinh = array_column(dmloaihinhkhenthuong::all()->toarray(), 'tenloaihinhkt', 'maloaihinhkt');
            $a_linhvuc = getLinhVucHoatDong();

            $result['message'] = '<div class="row" id="dskhenthuongtapthe">';
            $result['message'] .= '<div class="col-md-12">';
            $result['message'] .= '<table id="sample_4" class="table table-striped table-bordered table-hover">';
            $result['message'] .= '<thead>';
            $result['message'] .= '<tr class="text-center">';
            $result['message'] .= '<th width="5%">STT</th>';
            $result['message'] .= '<th>Tên tập thể</th>';
            $result['message'] .= '<th>Phân loại<br>đối tượng</th>';
            $result['message'] .= '<th>Lĩnh vực hoạt động</th>';
            $result['message'] .= '<th>Danh hiệu thi đua/<br>Hình thức khen thưởng</th>';
            $result['message'] .= '<th>Loại hình khen thưởng</th>';
            $result['message'] .= '<th width="10%">Thao tác</th>';
            $result['message'] .= '</tr>';
            $result['message'] .= '</thead>';
            $result['message'] .= '<tbody>';
            $i = 1;
            foreach ($model as $tt) {
                $result['message'] .= '<tr class="odd gradeX">';
                $result['message'] .= '<td class="text-center">' . $i++ . '</td>';
                $result['message'] .= '<td>' . $tt->tentapthe . '</td>';
                $result['message'] .= '<td>' . ($a_tapthe[$tt->maphanloaitapthe] ?? '') . '</td>';
                $result['message'] .= '<td>' . ($a_linhvuc[$tt->linhvuchoatdong] ?? '') . '</td>';
                $result['message'] .= '<td class="text-center">' . ($a_dhkt[$tt->madanhhieukhenthuong] ?? '') . '</td>';
                $result['message'] .= '<td class="text-center">' . ($a_loaihinh[$maloaihinhkt] ?? '') . '</td>';
                $result['message'] .= '<td class="text-center"><button title="Sửa thông tin" type="button" onclick="getTapThe(' . $tt->id . ')"  class="btn btn-sm btn-clean btn-icon"
                                                                    data-target="#modal-create-tapthe" data-toggle="modal"><i class="icon-lg la fa-edit text-primary"></i></button>';
                if ($bXoa)
                    $result['message'] .= '<button title="Xóa" type="button" onclick="delKhenThuong(' . $tt->id . ', &#39;' . $url . 'XoaTapThe&#39;, &#39;TAPTHE&#39;)" class="btn btn-sm btn-clean btn-icon" data-target="#modal-delete-khenthuong" data-toggle="modal">
                                                                    <i class="icon-lg la fa-trash text-danger"></i></button>';
                // $result['message'] .= '<button title="Tiêu chuẩn" type="button" onclick="getTieuChuan(' . $tt->id . ',&#39;TAPTHE&#39;,&#39;' . $tt->tendoituong . '&#39;)" class="btn btn-sm btn-clean btn-icon" data-target="#modal-tieuchuan" data-toggle="modal"> <i class="icon-lg la fa-list text-dark"></i> </button>';

                $result['message'] .= '</td>';
                $result['message'] .= '</tr>';
            }
            $result['message'] .= '</tbody>';
            $result['message'] .= '</table>';
            $result['message'] .= '</div>';
            $result['message'] .= '</div>';


            $result['status'] = 'success';
        }
    }

    function htmlCaNhan(&$result, $model, $url, $bXoa = true, $maloaihinhkt)
    {
        if (isset($model)) {
            $a_tapthe = array_column(dmnhomphanloai_chitiet::all()->toarray(), 'tenphanloai', 'maphanloai');
            $a_dhkt = getDanhHieuKhenThuong('ALL');
            $a_loaihinh = array_column(getLoaiHinhKhenThuong()->toarray(), 'tenloaihinhkt', 'maloaihinhkt');
            //$a_linhvuc = getLinhVucHoatDong();


            $result['message'] = '<div class="row" id="dskhenthuongcanhan">';
            $result['message'] .= '<div class="col-md-12">';
            $result['message'] .= '<table id="sample_3" class="table table-striped table-bordered table-hover">';
            $result['message'] .= '<thead>';
            $result['message'] .= '<tr class="text-center">';
            $result['message'] .= '<th width="2%">STT</th>';
            $result['message'] .= '<th>Tên đối tượng</th>';
            // $result['message'] .= '<th width="8%">Ngày sinh</th>';
            $result['message'] .= '<th width="5%">Giới</br>tính</th>';
            $result['message'] .= '<th>Phân loại cán bộ</th>';
            $result['message'] .= '<th>Thông tin công tác</th>';
            $result['message'] .= '<th>Danh hiệu thi đua/<br>Hình thức khen thưởng</th>';
            $result['message'] .= '<th>Loại hình khen thưởng</th>';
            $result['message'] .= '<th width="10%">Thao tác</th>';
            $result['message'] .= '</tr>';
            $result['message'] .= '</thead>';
            $result['message'] .= '<tbody>';
            $i = 1;
            foreach ($model as $tt) {
                $result['message'] .= '<tr class="odd gradeX">';
                $result['message'] .= '<td class="text-center">' . $i++ . '</td>';
                $result['message'] .= '<td>' . $tt->tendoituong . '</td>';
                // $result['message'] .= '<td class="text-center">' . getDayVn($tt->ngaysinh) . '</td>';
                $result['message'] .= '<td>' . $tt->gioitinh . '</td>';
                $result['message'] .= '<td>' . ($a_tapthe[$tt->maphanloaicanbo] ?? '') . '</td>';
                $result['message'] .= '<td class="text-center">' . $tt->chucvu . ',' . $tt->tenphongban . ',' . $tt->tencoquan . '</td>';
                $result['message'] .= '<td class="text-center">' . ($a_dhkt[$tt->madanhhieukhenthuong] ?? '') . '</td>';
                $result['message'] .= '<td class="text-center">' . ($a_loaihinh[$maloaihinhkt] ?? '') . '</td>';

                $result['message'] .= '<td class="text-center"><button title="Sửa thông tin" type="button" onclick="getCaNhan(' . $tt->id . ')"  class="btn btn-sm btn-clean btn-icon"
                                                                    data-target="#modal-create" data-toggle="modal"><i class="icon-lg la fa-edit text-primary"></i></button>';
                if ($bXoa)
                    $result['message'] .= '<button title="Xóa" type="button" onclick="delKhenThuong(' . $tt->id . ', &#39;' . $url . 'XoaCaNhan&#39;, &#39;CANHAN&#39;)" class="btn btn-sm btn-clean btn-icon" data-target="#modal-delete-khenthuong" data-toggle="modal">
                                                                    <i class="icon-lg la fa-trash text-danger"></i></button>';
                // $result['message'] .= '<button title="Tiêu chuẩn" type="button" onclick="getTieuChuan(' . $tt->id . ',&#39;CANHAN&#39;,&#39;' . $tt->tendoituong . '&#39;)" class="btn btn-sm btn-clean btn-icon" data-target="#modal-tieuchuan" data-toggle="modal"> <i class="icon-lg la fa-list text-dark"></i> </button>';

                $result['message'] .= '</td>';
                $result['message'] .= '</tr>';
            }
            $result['message'] .= '</tbody>';
            $result['message'] .= '</table>';
            $result['message'] .= '</div>';
            $result['message'] .= '</div>';


            $result['status'] = 'success';
        }
    }

    function htmlHoGiaDinh(&$result, $model, $url, $bXoa = true, $maloaihinhkt)
    {
        if (isset($model)) {
            //$a_hinhthuckt = array_column(dmhinhthuckhenthuong::all()->toArray(), 'tenhinhthuckt', 'mahinhthuckt');
            //$a_danhhieutd = array_column(dmdanhhieuthidua::all()->toArray(), 'tendanhhieutd', 'madanhhieutd');
            $a_tapthe = array_column(dmnhomphanloai_chitiet::all()->toarray(), 'tenphanloai', 'maphanloai');
            $a_dhkt = getDanhHieuKhenThuong('ALL');
            $a_loaihinh = array_column(dmloaihinhkhenthuong::all()->toarray(), 'tenloaihinhkt', 'maloaihinhkt');
            $a_linhvuc = getLinhVucHoatDong();

            $result['message'] = '<div class="row" id="dskhenthuonghogiadinh">';
            $result['message'] .= '<div class="col-md-12">';
            $result['message'] .= '<table id="sample_5" class="table table-striped table-bordered table-hover">';
            $result['message'] .= '<thead>';
            $result['message'] .= '<tr class="text-center">';
            $result['message'] .= '<th width="5%">STT</th>';
            $result['message'] .= '<th>Tên hộ gia đình</th>';
            // $result['message'] .= '<th>Phân loại<br>đối tượng</th>';
            $result['message'] .= '<th>Danh hiệu thi đua/<br>Hình thức khen thưởng</th>';
            $result['message'] .= '<th>Loại hình khen thưởng</th>';
            $result['message'] .= '<th width="10%">Thao tác</th>';
            $result['message'] .= '</tr>';
            $result['message'] .= '</thead>';
            $result['message'] .= '<tbody>';
            $i = 1;
            foreach ($model as $tt) {
                $result['message'] .= '<tr class="odd gradeX">';
                $result['message'] .= '<td class="text-center">' . $i++ . '</td>';
                $result['message'] .= '<td>' . $tt->tentapthe . '</td>';
                // $result['message'] .= '<td>' . ($a_tapthe[$tt->maphanloaitapthe] ?? '') . '</td>';
                $result['message'] .= '<td class="text-center">' . ($a_dhkt[$tt->madanhhieukhenthuong] ?? '') . '</td>';
                $result['message'] .= '<td class="text-center">' . ($a_loaihinh[$maloaihinhkt] ?? '') . '</td>';
                $result['message'] .= '<td class="text-center"><button title="Sửa thông tin" type="button" onclick="getHoGiaDinh(' . $tt->id . ')"  class="btn btn-sm btn-clean btn-icon"
                                                                    data-target="#modal-create-hogiadinh" data-toggle="modal"><i class="icon-lg la fa-edit text-primary"></i></button>';
                if ($bXoa)
                    $result['message'] .= '<button title="Xóa" type="button" onclick="delKhenThuong(' . $tt->id . ', &#39;' . $url . 'XoaHoGiaDinh&#39;, &#39;HOGIADINH&#39;)" class="btn btn-sm btn-clean btn-icon" data-target="#modal-delete-khenthuong" data-toggle="modal">
                                                                    <i class="icon-lg la fa-trash text-danger"></i></button>';
                // $result['message'] .= '<button title="Tiêu chuẩn" type="button" onclick="getTieuChuan(' . $tt->id . ',&#39;TAPTHE&#39;,&#39;' . $tt->tendoituong . '&#39;)" class="btn btn-sm btn-clean btn-icon" data-target="#modal-tieuchuan" data-toggle="modal"> <i class="icon-lg la fa-list text-dark"></i> </button>';

                $result['message'] .= '</td>';
                $result['message'] .= '</tr>';
            }
            $result['message'] .= '</tbody>';
            $result['message'] .= '</table>';
            $result['message'] .= '</div>';
            $result['message'] .= '</div>';


            $result['status'] = 'success';
        }
    }

    function htmlDeTai(&$result, $model, $url, $bXoa = true)
    {
        if (isset($model)) {
            $result['message'] = '<div class="row" id="dsdetai">';
            $result['message'] .= '<div class="col-md-12">';
            $result['message'] .= '<table id="sample_5" class="table table-striped table-bordered table-hover">';
            $result['message'] .= '<thead>';
            $result['message'] .= '<tr class="text-center">';
            $result['message'] .= '<th width="5%">STT</th>';
            $result['message'] .= '<th>Tên đề tài, sáng kiến</th>';
            $result['message'] .= '<th>Thông tin tác giả</th>';
            $result['message'] .= '<th width="10%">Thao tác</th>';
            $result['message'] .= '</tr>';
            $result['message'] .= '</thead>';
            $result['message'] .= '<tbody>';
            $i = 1;
            foreach ($model as $tt) {
                $result['message'] .= '<tr class="odd gradeX">';
                $result['message'] .= '<td class="text-center">' . $i++ . '</td>';
                $result['message'] .= '<td>' . $tt->tensangkien . '</td>';
                $result['message'] .= '<td class="text-center">' . $tt->tendoituong . ',' . $tt->tenphongban . ',' . $tt->tencoquan . '</td>';

                $result['message'] .= '<td class="text-center"><button title="Sửa thông tin" type="button" onclick="getDeTai(' . $tt->id . ')"  class="btn btn-sm btn-clean btn-icon"
                                                                    data-target="#modal-detai" data-toggle="modal"><i class="icon-lg la fa-edit text-primary"></i></button>';
                $result['message'] .= '<button title="Xóa" type="button" onclick="delDeTai(' . $tt->id . ', &#39;' . $url . 'XoaDeTai&#39;)" class="btn btn-sm btn-clean btn-icon" data-target="#modal-delete-detai" data-toggle="modal">
                                                                    <i class="icon-lg la fa-trash text-danger"></i></button>';

                $result['message'] .= '</td>';
                $result['message'] .= '</tr>';
            }
            $result['message'] .= '</tbody>';
            $result['message'] .= '</table>';
            $result['message'] .= '</div>';
            $result['message'] .= '</div>';


            $result['status'] = 'success';
        }
    }
    public function DinhKemHoSoThamGia(Request $request)
    {
        $result = array(
            'status' => 'fail',
            'message' => 'error',
        );

        $inputs = $request->all();
        $result['message'] = '<div class="modal-body" id = "dinh_kem" >';
        $model = dshosothamgiaphongtraotd::where('mahosothamgiapt', $inputs['mahs'])->first();
        $result['message'] .= '<h5>Tài liệu hồ sơ đề nghị khen thưởng</h5>';
        if ($model != null) {
            if (isset($model->totrinh)) {
                $result['message'] .= '<div class="form-group row">';
                $result['message'] .= '<label class="col-3 col-form-label font-weight-bold" >Tờ trình:</label>';
                $result['message'] .= '<div class="col-9 form-control"><a target = "_blank" href = "' . url('/data/totrinh/' . $model->totrinh) . '">' . $model->totrinh . '</a ></div>';
                $result['message'] .= '</div>';
            }

            if (isset($model->baocao)) {
                $result['message'] .= '<div class="form-group row">';
                $result['message'] .= '<label class="col-3 col-form-label font-weight-bold" >Báo cáo thành tích:</label>';
                $result['message'] .= '<div class="col-9 form-control"><a target = "_blank" href = "' . url('/data/baocao/' . $model->baocao) . '">' . $model->baocao . '</a ></div>';
                $result['message'] .= '</div>';
            }

            if (isset($model->bienban)) {
                $result['message'] .= '<div class="form-group row">';
                $result['message'] .= '<label class="col-3 col-form-label font-weight-bold" >Biên bản cuộc họp</label>';
                $result['message'] .= '<div class="col-9 form-control"><a target = "_blank" href = "' . url('/data/bienban/' . $model->bienban) . '">' . $model->bienban . '</a ></div>';
                $result['message'] .= '</div>';
            }
            if (isset($model->tailieukhac)) {
                $result['message'] .= '<div class="form-group row">';
                $result['message'] .= '<label class="col-3 col-form-label font-weight-bold" >Tài liệu khác</label>';
                $result['message'] .= '<div class="col-9 form-control"><a target = "_blank" href = "' . url('/data/tailieukhac/' . $model->tailieukhac) . '">' . $model->tailieukhac . '</a ></div>';
                $result['message'] .= '</div>';
            }

            if (isset($model->quyetdinh)) {
                $result['message'] .= '<div class="form-group row">';
                $result['message'] .= '<label class="col-3 col-form-label font-weight-bold" >Quyết định khen thưởng:</label>';
                $result['message'] .= '<div class="col-9 form-control"><a target = "_blank" href = "' . url('/data/quyetdinh/' . $model->quyetdinh) . '">' . $model->quyetdinh . '</a ></div>';
                $result['message'] .= '</div>';
            }
            $result['message'] .= '<hr><h5>Tài liệu phong trào thi đua</h5>';
            $model_pt = dsphongtraothidua::where('maphongtraotd', $model->maphongtraotd)->first();
            if (isset($model_pt->qdkt)) {
                $result['message'] .= '<div class="form-group row">';
                $result['message'] .= '<label class="col-3 col-form-label font-weight-bold" >Quyết định:</label>';
                $result['message'] .= '<div class="col-9 form-control"><a target = "_blank" href = "' . url('/data/qdkt/' . $model_pt->qdkt) . '">' . $model_pt->qdkt . '</a ></div>';
                $result['message'] .= '</div>';
            }

            if (isset($model_pt->tailieukhac)) {
                $result['message'] .= '<div class="form-group row">';
                $result['message'] .= '<label class="col-3 col-form-label font-weight-bold" >Tài liệu khác:</label>';
                $result['message'] .= '<div class="col-9 form-control"><a target = "_blank" href = "' . url('/data/tailieukhac/' . $model_pt->tailieukhac) . '">' . $model_pt->tailieukhac . '</a ></div>';
                $result['message'] .= '</div>';
            }
        }
        $result['message'] .= '</div>';
        $result['status'] = 'success';

        die(json_encode($result));
    }

    public function DinhKemHoSoKhenThuong(Request $request)
    {
        $result = array(
            'status' => 'fail',
            'message' => 'error',
        );

        $inputs = $request->all();
        $result['message'] = '<div class="modal-body" id = "dinh_kem" >';
        $model = dshosothiduakhenthuong::where('mahosotdkt', $inputs['mahs'])->first();
        if ($model != null) {
            if (isset($model->totrinh)) {
                $result['message'] .= '<div class="form-group row">';
                $result['message'] .= '<label class="col-3 col-form-label font-weight-bold" >Tờ trình:</label>';
                $result['message'] .= '<div class="col-9 form-control"><a target = "_blank" href = "' . url('/data/totrinh/' . $model->totrinh) . '">' . $model->totrinh . '</a ></div>';
                $result['message'] .= '</div>';
            }

            if (isset($model->baocao)) {
                $result['message'] .= '<div class="form-group row">';
                $result['message'] .= '<label class="col-3 col-form-label font-weight-bold" >Báo cáo thành tích:</label>';
                $result['message'] .= '<div class="col-9 form-control"><a target = "_blank" href = "' . url('/data/baocao/' . $model->baocao) . '">' . $model->baocao . '</a ></div>';
                $result['message'] .= '</div>';
            }

            if (isset($model->bienban)) {
                $result['message'] .= '<div class="form-group row">';
                $result['message'] .= '<label class="col-3 col-form-label font-weight-bold" >Biên bản cuộc họp</label>';
                $result['message'] .= '<div class="col-9 form-control"><a target = "_blank" href = "' . url('/data/bienban/' . $model->bienban) . '">' . $model->bienban . '</a ></div>';
                $result['message'] .= '</div>';
            }
            if (isset($model->tailieukhac)) {
                $result['message'] .= '<div class="form-group row">';
                $result['message'] .= '<label class="col-3 col-form-label font-weight-bold" >Tài liệu khác</label>';
                $result['message'] .= '<div class="col-9 form-control"><a target = "_blank" href = "' . url('/data/tailieukhac/' . $model->tailieukhac) . '">' . $model->tailieukhac . '</a ></div>';
                $result['message'] .= '</div>';
            }

            if (isset($model->quyetdinh)) {
                $result['message'] .= '<div class="form-group row">';
                $result['message'] .= '<label class="col-3 col-form-label font-weight-bold" >Quyết định khen thưởng:</label>';
                $result['message'] .= '<div class="col-9 form-control"><a target = "_blank" href = "' . url('/data/quyetdinh/' . $model->quyetdinh) . '">' . $model->quyetdinh . '</a ></div>';
                $result['message'] .= '</div>';
            }            
        }
        $result['message'] .= '</div>';
        $result['status'] = 'success';

        die(json_encode($result));
    }

}
