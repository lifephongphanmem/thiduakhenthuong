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
            TableManagedclass.init();
        });
    </script>
@stop

@section('content')
    <!--begin::Card-->
    {!! Form::open([
        'method' => 'POST',
        'url' => '/TraCuu/CaNhan/ThongTin',
        'class' => 'form',
        'id' => 'frm_ThayDoi',
        'files' => true,
        'enctype' => 'multipart/form-data',
    ]) !!}
    <div class="card card-custom wave wave-animate-slow wave-info">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Thông tin tìm kiếm theo cá nhân</h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                <!--end::Button-->
            </div>
        </div>

        <div class="card-body">



            <div class="row" style="display: block;" id="frm_tths">
                <div class="row" style="">
                    <div class="col-xl-12">
                        <div class="card card-custom gutter-b example example-compact" style="border: 1px solid #60aee4;">
                            <div class="card-header">
                                <div class="checkbox-inline">
                                    <label class="checkbox checkbox-lg">

                                        <label class="card-title">
                                            <span class="label label-danger label-dot mr-2"></span>
                                            Tiêu chuẩn tìm kiếm
                                        </label>
                                    </label>
                                </div>
                                <div class="card-toolbar">
                                    <button type="button" class="btn btn-clean btn-sm btn-icon" id="btn_ttlt"
                                        title="Thu gọn/ Hiển thị">
                                        <i class="ki ki-bold-more-hor"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body" style="display: block;" id="frm_lt">
                                <div class="form-group row">
                                    <div class="col-4">
                                        <label class="form-control-label">Tên đối tượng</label>
                                        {!! Form::text('tendoituong', null, ['id' => 'tendoituong', 'class' => 'form-control']) !!}
                                    </div>

                                    <div class="col-4">
                                        <label class="form-control-label">Tên phòng ban làm việc</label>
                                        {!! Form::text('tendoituong', null, ['id' => 'tendoituong', 'class' => 'form-control']) !!}
                                    </div>

                                    <div class="col-4">
                                        <label>Tên đơn vị công tác</label>
                                        {!! Form::text('tendonvi', null, ['class' => 'form-control', 'readonly' => 'true']) !!}
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-2">
                                        <label>Khen thưởng - Từ</label>
                                        {!! Form::input('date', 'ngaytu', null, ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="col-lg-2">
                                        <label>Khen thưởng - Đến</label>
                                        {!! Form::input('date', 'ngayden', null, ['class' => 'form-control']) !!}
                                    </div>

                                    <div class="col-md-2">
                                        <label class="form-control-label">Giới tính</label>
                                        {!! Form::select('gioitinh', getGioiTinh(), null, ['id' => 'gioitinh', 'class' => 'form-control']) !!}
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-control-label">Phân loại cán bộ</label>
                                        {!! Form::select('gioitinh', getGioiTinh(), null, ['id' => 'gioitinh', 'class' => 'form-control']) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <div class="row text-center">
                                    <div class="col-lg-12">
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>Tìm
                                            kiếm</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="row" style="">
                    <div class="col-xl-12">
                        <div class="card card-custom gutter-b example example-compact" style="border: 1px solid #60aee4;">
                            <div class="card-header">
                                <div class="checkbox-inline">
                                    <label class="checkbox checkbox-lg">
                                        
                                        <label class="card-title">
                                            <span class="label label-danger label-dot mr-2"></span>
                                            Kết quả tìm kiếm
                                        </label>
                                    </label>
                                </div>
                                <div class="card-toolbar">
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
                            </div>
                            {!! Form::model($model, ['url' => '', 'class' => 'form', 'id' => 'frm_ThayDoi']) !!}
                            <div class="card-body">
                                <h4 class="text-dark font-weight-bold mb-10">Thông tin chung</h4>
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Tên đối tượng</label>
                                        {!! Form::text('tendoituong', null, ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Tên đơn vị</label>
                                        {!! Form::text('tendonvi', null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <label class="form-control-label">Ngày sinh</label>
                                        {!! Form::input('date', 'ngaysinh', null, ['id' => 'ngaysinh', 'class' => 'form-control']) !!}
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-control-label">Giới tính</label>
                                        {!! Form::select('gioitinh', getGioiTinh(), null, ['id' => 'gioitinh', 'class' => 'form-control']) !!}
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-control-label">Chức vụ/Chức danh</label>
                                        {!! Form::text('chucvu', null, ['id' => 'chucvu', 'class' => 'form-control']) !!}
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-control-label">Mã CCVC</label>
                                        {!! Form::text('maccvc', null, ['id' => 'maccvc', 'class' => 'form-control']) !!}
                                    </div>
                                </div>

                                <div class="separator separator-dashed my-5"></div>
                                <h4 class="text-dark font-weight-bold mb-10">Danh sách khen thưởng</h4>

                                <div class="row" id="dskhenthuong">
                                    <div class="col-md-12">
                                        <table class="table table-striped table-bordered table-hover dulieubang">
                                            <thead>
                                                <tr class="text-center">
                                                    <th rowspan="2" width="5%">STT</th>
                                                    <th colspan="3">Quyết định</th>                                                    
                                                    <th colspan="2">Tờ trình</th>
                                                    <th rowspan="2">Phân loại cán bộ</th>
                                                    <th rowspan="2">Thông tin công tác</th>
                                                    <th rowspan="2">Loại hình khen thưởng</th>
                                                    <th rowspan="2">Danh hiệu thi đua</th>
                                                    <th rowspan="2">Hình thức khen thưởng</th>
                                                    
                                                </tr>
                                                <tr class="text-center">                                                    
                                                    <th>Số QĐ</th>                                                  
                                                    <th>Ngày tháng</th>
                                                    <th>Cấp độ</th>
                                                    <th>Số TT</th>
                                                    <th>Ngày tháng</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                @foreach ($model_danhhieu as $key => $tt)
                                                    <tr class="odd gradeX">
                                                        <td class="text-center">{{ $i++ }}</td>
                                                        <td>{{ $a_danhhieu[$tt->madanhhieutd] ?? '' }}</td>
                                                        <td>{{ $a_hinhthuckt[$tt->mahinhthuckt] ?? '' }}</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="separator separator-dashed my-5"></div>
                                <h4 class="text-dark font-weight-bold mb-10">Danh sách đề tài, sáng kiến</h4>

                                <div class="row" id="dskhenthuongtapthe">
                                    <div class="col-md-12">
                                        <table class="table table-striped table-bordered table-hover dulieubang">
                                            <thead>
                                                <tr class="text-center">
                                                    <th width="10%">STT</th>
                                                    <th>Tên đề tài, sáng kiến</th>
                                                    <th>Thành tích đạt được</th>
                                                    <th>Thông tin tác giả</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                @foreach ($model_detai as $key => $tt)
                                                    <tr class="odd gradeX">
                                                        <td class="text-center">{{ $i++ }}</td>
                                                        <td>{{ $tt->tensangkien }}</td>
                                                        <td>{{ $tt->thanhtichdatduoc }}</td>
                                                        <td>{{ $tt->thanhtichdatduoc }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row text-center">

                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
    <!--end::Card-->

@stop
