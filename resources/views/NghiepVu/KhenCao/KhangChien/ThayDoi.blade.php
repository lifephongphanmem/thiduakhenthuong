@extends('HeThong.main')

@section('custom-style')
    <link rel="stylesheet" type="text/css" href="{{ url('assets/css/pages/dataTables.bootstrap.css') }}" />
    {{-- <link rel="stylesheet" type="text/css" href="{{ url('assets/css/pages/select2.css') }}" /> --}}
@stop

@section('custom-script-footer')
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="/assets/js/pages/select2.js"></script>
    <script src="/assets/js/pages/jquery.dataTables.min.js"></script>
    <script src="/assets/js/pages/dataTables.bootstrap.js"></script>
    <script src="/assets/js/pages/table-lifesc.js"></script>
    <!-- END PAGE LEVEL PLUGINS -->
    <script>
        jQuery(document).ready(function() {
            TableManaged3.init();
            TableManaged4.init();
            TableManaged5.init();
            TableManagedclass.init();
        });
    </script>
@stop

@section('content')
    <!--begin::Card-->

    <div class="card card-custom" style="min-height: 600px">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Thông tin hồ sơ khen khen thưởng kháng chiến</h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                <!--end::Button-->
            </div>
        </div>

        {!! Form::model($model, [
            'method' => 'POST',
            'url' => $inputs['url_hs'] . 'Sua',
            'class' => 'form',
            'id' => 'frm_ThayDoi',
            'files' => true,
            'enctype' => 'multipart/form-data',
        ]) !!}
        {{ Form::hidden('madonvi', null, ['id' => 'madonvi']) }}
        {{ Form::hidden('mahosotdkt', null, ['id' => 'mahosotdkt']) }}
        <div class="card-body">
            <h4 class="text-dark font-weight-bold mb-5">Thông tin chung</h4>
            <div class="form-group row">
                <div class="col-12">
                    <label>Tên đơn vị đề nghị khen thưởng</label>
                    {!! Form::text('tendonvi', null, ['class' => 'form-control', 'readonly' => 'true']) !!}
                </div>


            </div>

            {{-- <div class="form-group row">
                <div class="col-11">
                    <label>Tên phong trào thi đua</label>
                    {!! Form::select('maphongtraotd', setArrayAll($a_phongtraotd, 'Không chọn', 'null'), null, [
                        'class' => 'form-control select2basic',
                    ]) !!}
                </div>
                <div class="col-1">
                    <label class="text-center">Chọn</label>
                    <button type="button" class="btn btn-default" data-target="#modal-phongtraotd" data-toggle="modal">
                        <i class="fa fa-plus"></i></button>
                </div>
            </div> --}}

            <div class="form-group row">
                <div class="col-6">
                    <label>Cấp độ khen thưởng</label>
                    {!! Form::select('capkhenthuong', getPhamViKhenCao(), null, ['class' => 'form-control']) !!}
                </div>
                <div class="col-6">
                    <label>Loại hình khen thưởng</label>
                    {!! Form::select('maloaihinhkt', $a_loaihinhkt, null, ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-3">
                    <label>Số tờ trình</label>
                    {!! Form::text('sototrinh', null, ['class' => 'form-control']) !!}
                </div>
                <div class="col-3">
                    <label>Ngày tháng trình<span class="require">*</span></label>
                    {!! Form::input('date', 'ngayhoso', null, ['class' => 'form-control', 'required']) !!}
                </div>

                <div class="col-3">
                    <label>Chức vụ người ký tờ trình</label>
                    {!! Form::text('chucvunguoiky', null, ['class' => 'form-control']) !!}
                </div>
                <div class="col-3">
                    <label>Họ tên người ký tờ trình</label>
                    {!! Form::text('nguoikytotrinh', null, ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-12">
                    <label>Mô tả hồ sơ</label>
                    {!! Form::textarea('noidung', null, ['class' => 'form-control', 'rows' => 2]) !!}
                </div>
            </div>

            {{-- <div class="form-group row">
                <div class="col-lg-6">
                    <label>Tờ trình: </label>
                    {!! Form::file('totrinh', null, ['id' => 'totrinh', 'class' => 'form-control']) !!}
                    @if ($model->totrinh != '')
                        <span class="form-control" style="border-style: none">
                            <a href="{{ url('/data/totrinh/' . $model->totrinh) }}"
                                target="_blank">{{ $model->totrinh }}</a>
                        </span>
                    @endif
                </div>

                <div class="col-lg-6">
                    <label>Báo cáo thành tích: </label>
                    {!! Form::file('baocao', null, ['id' => 'baocao', 'class' => 'form-control']) !!}
                    @if ($model->baocao != '')
                        <span class="form-control" style="border-style: none">
                            <a href="{{ url('/data/baocao/' . $model->baocao) }}" target="_blank">{{ $model->baocao }}</a>
                        </span>
                    @endif
                </div>
            </div> --}}

            {{-- <div class="form-group row">
                <div class="col-lg-6">
                    <label>Biên bản cuộc họp: </label>
                    {!! Form::file('bienban', null, ['id' => 'bienban', 'class' => 'form-control']) !!}
                    @if ($model->bienban != '')
                        <span class="form-control" style="border-style: none">
                            <a href="{{ url('/data/bienban/' . $model->bienban) }}"
                                target="_blank">{{ $model->bienban }}</a>
                        </span>
                    @endif
                </div>

                <div class="col-lg-6">
                    <label>Tài liệu khác: </label>
                    {!! Form::file('tailieukhac', null, ['id' => 'tailieukhac', 'class' => 'form-control']) !!}
                    @if ($model->tailieukhac != '')
                        <span class="form-control" style="border-style: none">
                            <a href="{{ url('/data/tailieukhac/' . $model->tailieukhac) }}"
                                target="_blank">{{ $model->tailieukhac }}</a>
                        </span>
                    @endif
                </div>
            </div> --}}

            <div class="row">
                <div class="col-md-12">
                    <div class="card card-custom">
                        <div class="card-header card-header-tabs-line">
                            <div class="card-toolbar">
                                <ul class="nav nav-tabs nav-bold nav-tabs-line">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#kt_tapthe">
                                            <span class="nav-icon">
                                                <i class="fas fa-users"></i>
                                            </span>
                                            <span class="nav-text">Khen thưởng tập thể</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#kt_canhan">
                                            <span class="nav-icon">
                                                <i class="far fa-user"></i>
                                            </span>
                                            <span class="nav-text">Khen thưởng cá nhân</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#kt_tailieu">
                                            <span class="nav-icon">
                                                <i class="far flaticon-folder-1"></i>
                                            </span>
                                            <span class="nav-text">Tài liệu đính kèm</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-toolbar">

                            </div>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane fade active show" id="kt_tapthe" role="tabpanel"
                                    aria-labelledby="kt_tapthe">
                                    <div class="form-group row">
                                        <div class="col-lg-12 text-right">
                                            <div class="btn-group" role="group">
                                                <button type="button" onclick="setTapThe()"
                                                    data-target="#modal-create-tapthe" data-toggle="modal"
                                                    class="btn btn-light-dark btn-icon btn-sm">
                                                    <i class="fa fa-plus"></i></button>
                                                <button title="Nhận từ file Excel" data-target="#modal-nhanexcel"
                                                    data-toggle="modal" type="button"
                                                    class="btn btn-info btn-icon btn-sm"><i
                                                        class="fas fa-file-import"></i></button>
                                                <a target="_blank" title="Tải file mẫu" href="/data/download/TapThe.xlsx"
                                                    class="btn btn-primary btn-icon btn-sm"><i
                                                        class="fa flaticon-download"></i></button></a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row" id="dskhenthuongtapthe">
                                        <div class="col-md-12">
                                            <table id="sample_4" class="table table-striped table-bordered table-hover">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th width="5%">STT</th>
                                                        <th>Tên tập thể</th>
                                                        <th>Phân loại<br>tập thể</th>
                                                        <th>Hình thức khen thưởng/<br>Danh hiệu thi đua</th>
                                                        <th>Kết quả<br>khen thưởng</th>
                                                        <th width="10%">Thao tác</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i = 1; ?>
                                                    @foreach ($model_tapthe as $key => $tt)
                                                        <tr class="odd gradeX">
                                                            <td class="text-center">{{ $i++ }}</td>
                                                            <td>{{ $tt->tentapthe }}</td>
                                                            <td>{{ $a_tapthe[$tt->maphanloaitapthe] ?? '' }}</td>
                                                            <td class="text-center">
                                                                {{ $a_dhkt_tapthe[$tt->madanhhieukhenthuong] ?? '' }}</td>

                                                            @if ($tt->ketqua == 1)
                                                                <td class="text-center">
                                                                    <a class="btn btn-sm btn-clean btn-icon">
                                                                        <i
                                                                            class="icon-lg la fa-check text-primary icon-2x"></i></a>
                                                                @else
                                                                <td class="text-center">
                                                                    <a class="btn btn-sm btn-clean btn-icon">
                                                                        <i
                                                                            class="icon-lg la fa-times-circle text-danger icon-2x"></i></a>
                                                                </td>
                                                            @endif
                                                            <td class="text-center">
                                                                <button title="Sửa thông tin" type="button"
                                                                    onclick="getTapThe('{{ $tt->id }}')"
                                                                    class="btn btn-sm btn-clean btn-icon"
                                                                    data-target="#modal-create-tapthe"
                                                                    data-toggle="modal">
                                                                    <i class="icon-lg la fa-edit text-primary"></i>
                                                                </button>
                                                                <button title="Xóa" type="button"
                                                                    onclick="delKhenThuong('{{ $tt->id }}',  '{{ $inputs['url_hs'] . 'XoaTapThe' }}', 'TAPTHE')"
                                                                    class="btn btn-sm btn-clean btn-icon"
                                                                    data-target="#modal-delete-khenthuong"
                                                                    data-toggle="modal">
                                                                    <i class="icon-lg la fa-trash text-danger"></i>
                                                                </button>

                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="kt_canhan" role="tabpanel" aria-labelledby="kt_canhan">
                                    <div class="form-group row">
                                        <div class="col-lg-12 text-right">
                                            <div class="btn-group" role="group">
                                                <button title="Thêm đối tượng" type="button" data-target="#modal-create"
                                                    data-toggle="modal" class="btn btn-light-dark btn-icon btn-sm"
                                                    onclick="setCaNhan()">
                                                    <i class="fa fa-plus"></i></button>

                                                <button title="Nhận từ file Excel" data-target="#modal-nhanexcel"
                                                    data-toggle="modal" type="button"
                                                    class="btn btn-info btn-icon btn-sm"><i
                                                        class="fas fa-file-import"></i></button>

                                                <a target="_blank" title="Tải file mẫu" href="/data/download/CANHAN.xlsx"
                                                    class="btn btn-primary btn-icon btn-sm"><i
                                                        class="fa flaticon-download"></i></button></a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row" id="dskhenthuongcanhan">
                                        <div class="col-md-12">
                                            <table id="sample_3" class="table table-striped table-bordered table-hover">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th width="2%">STT</th>
                                                        <th>Tên đối tượng</th>
                                                        <th width="8%">Ngày sinh</th>
                                                        <th width="5%">Giới</br>tính</th>
                                                        <th width="15%">Phân loại cán bộ</th>
                                                        <th>Thông tin công tác</th>
                                                        <th>Hình thức khen thưởng/<br>Danh hiệu thi đua</th>
                                                        <th>Kết quả<br>khen thưởng</th>
                                                        <th width="10%">Thao tác</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i = 1; ?>
                                                    @foreach ($model_canhan as $key => $tt)
                                                        <tr class="odd gradeX">
                                                            <td class="text-center">{{ $i++ }}</td>
                                                            <td>{{ $tt->tendoituong }}</td>
                                                            <td class="text-center">{{ getDayVn($tt->ngaysinh) }}</td>
                                                            <td>{{ $tt->gioitinh }}</td>
                                                            <td>{{ $a_canhan[$tt->maphanloaicanbo] ?? '' }}</td>
                                                            <td class="text-center">
                                                                {{ $tt->chucvu . ',' . $tt->tenphongban . ',' . $tt->tencoquan }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $a_dhkt_canhan[$tt->madanhhieukhenthuong] ?? '' }}
                                                            </td>
                                                            @if ($tt->ketqua == 1)
                                                                <td class="text-center">
                                                                    <a class="btn btn-sm btn-clean btn-icon">
                                                                        <i
                                                                            class="icon-lg la fa-check text-primary icon-2x"></i></a>
                                                                @else
                                                                <td class="text-center">
                                                                    <a class="btn btn-sm btn-clean btn-icon">
                                                                        <i
                                                                            class="icon-lg la fa-times-circle text-danger icon-2x"></i></a>
                                                                </td>
                                                            @endif
                                                            <td class="text-center">
                                                                <button title="Sửa thông tin" type="button"
                                                                    onclick="getCaNhan('{{ $tt->id }}')"
                                                                    class="btn btn-sm btn-clean btn-icon"
                                                                    data-target="#modal-create" data-toggle="modal">
                                                                    <i class="icon-lg la fa-edit text-primary"></i>
                                                                </button>
                                                                <button title="Xóa" type="button"
                                                                    onclick="delKhenThuong('{{ $tt->id }}',  '{{ $inputs['url_hs'] . 'XoaCaNhan' }}', 'CANHAN')"
                                                                    class="btn btn-sm btn-clean btn-icon"
                                                                    data-target="#modal-delete-khenthuong"
                                                                    data-toggle="modal">
                                                                    <i class="icon-lg la fa-trash text-danger"></i>
                                                                </button>

                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="kt_tailieu" role="tabpanel" aria-labelledby="kt_tailieu">
                                    <div class="form-group row">
                                        <div class="col-lg-12 text-right">
                                            <div class="btn-group" role="group">
                                                <button title="Thêm đối tượng" type="button"
                                                    data-target="#modal-tailieu" data-toggle="modal"
                                                    class="btn btn-light-dark btn-icon btn-sm" onclick="setTaiLieu()">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row" id="dstailieu">
                                        <div class="col-md-12">
                                            <table class="table table-bordered table-hover dulieubang">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th width="2%">STT</th>
                                                        <th width="20%">Đơn vị tải lên</th>
                                                        <th width="20%">Phân loại tài liệu</th>
                                                        <th>Nội dung tóm tắt</th>
                                                        <th width="15%">Thao tác</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i = 1; ?>
                                                    @foreach ($model_tailieu as $key => $tt)
                                                        <tr class="odd gradeX">
                                                            <td class="text-center">{{ $i++ }}</td>
                                                            <td>{{ $a_donvi[$tt->madonvi] ?? $tt->madonvi }}</td>
                                                            <td>{{ $a_pltailieu[$tt->phanloai] ?? $tt->phanloai }}</td>
                                                            <td class="text-center">{{ $tt->noidung }}</td>

                                                            <td class="text-center">
                                                                <button title="Sửa thông tin" type="button"
                                                                    onclick="getTaiLieu('{{ $tt->id }}')"
                                                                    class="btn btn-sm btn-clean btn-icon"
                                                                    data-target="#modal-tailieu" data-toggle="modal">
                                                                    <i class="icon-lg la fa-edit text-primary"></i>
                                                                </button>
                                                                <button title="Xóa" type="button"
                                                                    onclick="delTaiLieu('{{ $tt->id }}')"
                                                                    class="btn btn-sm btn-clean btn-icon"
                                                                    data-target="#modal-delete-tailieu"
                                                                    data-toggle="modal">
                                                                    <i class="icon-lg la fa-trash text-danger"></i>
                                                                </button>
                                                                @if ($tt->tentailieu != '')
                                                                    <a target="_blank" title="Tải file đính kèm"
                                                                        href="{{ '/data/tailieudinhkem/' . $tt->tentailieu }}"
                                                                        class="btn btn-clean btn-icon btn-sm"><i
                                                                            class="fa flaticon-download text-info"></i>
                                                                    </a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <div class="card-footer">
            <div class="row text-center">
                <div class="col-lg-12">
                    <a href="{{ url($inputs['url_hs'] . 'ThongTin?madonvi=' . $model->madonvi) }}"
                        class="btn btn-danger mr-5"><i class="fa fa-reply"></i>&nbsp;Quay lại</a>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>Hoàn thành</button>

                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    <!--end::Card-->
    @include('NghiepVu._DungChung.modal_QD_CaNhan')
    @include('NghiepVu._DungChung.modal_QD_TapThe')
        @include('NghiepVu._DungChung.modal_TaiLieuDinhKem')
    {{-- chưa dùng tiêu chuẩn --}}
    {{-- @include('NghiepVu._DungChung.modal_TieuChuan') --}}
    @include('NghiepVu._DungChung.modal_XoaDoiTuong')
    @include('NghiepVu._DungChung.modal_QD_Excel')
    {{-- @include('NghiepVu._DungChung.modal_DoiTuong') --}}

@stop
