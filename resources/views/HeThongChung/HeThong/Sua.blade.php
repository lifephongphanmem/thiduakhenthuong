@extends('HeThong.main')

@section('custom-style')
    <link rel="stylesheet" type="text/css" href="{{ url('assets/global/plugins/select2/select2.css') }}" />
@stop


@section('custom-script')
    <script type="text/javascript" src="{{ url('assets/global/plugins/jquery-validation/js/jquery.validate.min.js') }}">
    </script>
    <script type="text/javascript" src="{{ url('assets/global/plugins/select2/select2.min.js') }}"></script>

@stop

@section('content')


    <h3 class="page-title">
        Thông tin đơn vị quản lý<small> chỉnh sửa</small>
    </h3>
    <!-- END PAGE HEADER-->

    <!-- BEGIN DASHBOARD STATS -->
    <div class="row center">
        <div class="col-md-12 center">
            <!-- BEGIN VALIDATION STATES-->
            <div class="portlet box blue">
                <!--div class="portlet-title">
                            </div-->
                <div class="portlet-body form">
                    <!-- BEGIN FORM-->
                    {!! Form::model($model, [
                        'method' => 'POST',
                        'url' => '/HeThongChung/ThayDoi',
                        'class' => 'horizontal-form',
                        'id' => 'update_general',
                        'files'=>'true'
                    ]) !!}
                    <meta name="csrf-token" content="{{ csrf_token() }}" />
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Cấp bản quyền cho đơn vị<span
                                            class="require">*</span></label>
                                    {!! Form::text('tendonvi', null, ['id' => 'tendonvi', 'class' => 'form-control required']) !!}
                                </div>
                            </div>
                            <!--/span-->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Mã quan hệ ngân sách<span class="require">*</span></label>
                                    {!! Form::text('maqhns', null, ['id' => 'maqhns', 'class' => 'form-control required']) !!}
                                </div>
                            </div>
                            <!--/span-->
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Địa chỉ<span class="require">*</span></label>
                                    {!! Form::text('diachi', null, ['id' => 'diachi', 'class' => 'form-control required']) !!}
                                </div>
                            </div>
                            <!--/span-->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Thông tin liên hệ<span class="require">*</span></label>
                                    {!! Form::text('tel', null, ['id' => 'tel', 'class' => 'form-control required']) !!}
                                </div>
                            </div>
                            <!--/span-->
                        </div>
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Địa danh<span class="require">*</span></label>
                                    {!! Form::text('diadanh', null, ['id' => 'diadanh', 'class' => 'form-control required']) !!}
                                </div>
                            </div>
                            <!--/span-->
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Tên đơn vị chủ quản hiển thị<span
                                            class="require">*</span></label>
                                    {!! Form::text('tendvcqhienthi', null, ['id' => 'tendvcqhienthi', 'class' => 'form-control required']) !!}
                                </div>
                            </div>
                            <!--/span-->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Tên đơn vị hiển thị<span class="require">*</span></label>
                                    {!! Form::text('tendvhienthi', null, ['id' => 'tendvhienthi', 'class' => 'form-control required']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Thông tin hợp đồng</label>
                                    <textarea id="thongtinhd" class="form-control" name="thongtinhd" cols="10" rows="5"
                                        placeholder="Thông tin, số điện thoại liên lạc với các bộ phận">{{ $model->thongtinhd }}</textarea>
                                </div>
                            </div>
                        </div>
                        @if (session('admin')->capdo == 'SSA')
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label>Tài liệu hướng dẫn sử dụng: </label>
                                    {!! Form::file('ipf1', null, ['id' => 'ipf1', 'class' => 'form-control']) !!}
                                    @if ($model->ipf1 != '')
                                        <span class="form-control" style="border-style: none">
                                            <a href="{{ url('/data/download/' . $model->ipf1) }}"
                                                target="_blank">{{ $model->ipf1 }}</a>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label>Ảnh nhóm hỗ trợ: </label>
                                    {!! Form::file('ipf2', null, ['id' => 'ipf2', 'class' => 'form-control']) !!}
                                    @if ($model->ipf2 != '')
                                        <span class="form-control" style="border-style: none">
                                            <a href="{{ url('/data/download/' . $model->ipf1) }}"
                                                target="_blank">{{ $model->ipf2 }}</a>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- END FORM-->
                </div>
            </div>

            <div style="text-align: center">
                <a href="{{ url('general') }}" class="btn btn-danger"><i class="fa fa-reply"></i>&nbsp;Quay lại</a>
                <button type="reset" class="btn btn-default"><i class="fa fa-refresh"></i>&nbsp;Nhập lại</button>
                <button type="submit" class="btn btn-primary" onclick="validateForm()"><i class="fa fa-check"></i> Cập
                    nhật</button>
            </div>
            {!! Form::close() !!}
            <!-- END VALIDATION STATES-->
        </div>
    </div>
    <script type="text/javascript">
        function validateForm() {

            var validator = $("#update_tttaikhoan").validate({
                rules: {
                    name: "required",
                },
                messages: {
                    name: "Chưa nhập dữ liệu",
                }
            });
        }
    </script>
@stop
