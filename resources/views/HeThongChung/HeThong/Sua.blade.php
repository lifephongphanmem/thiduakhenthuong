@extends('HeThong.main')

@section('custom-style')
    {{-- <link rel="stylesheet" type="text/css" href="{{ url('assets/global/plugins/select2/select2.css') }}" /> --}}
@stop


@section('custom-script')
    {{-- <script type="text/javascript" src="{{ url('assets/global/plugins/jquery-validation/js/jquery.validate.min.js') }}"></script> --}}
    {{-- <script type="text/javascript" src="{{ url('assets/global/plugins/select2/select2.min.js') }}"></script> --}}

@stop

@section('content')
    <div class="card card-custom" style="min-height: 600px">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Thông tin đơn vị quản lý<small> chỉnh sửa</small></h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                <!--end::Button-->
            </div>
        </div>

        {!! Form::model($model, [
            'method' => 'POST',
            'url' => '/HeThongChung/ThayDoi',
            'class' => 'horizontal-form',
            'id' => 'update_general',
            'files' => 'true',
        ]) !!}
        <div class="card-body">
            <h4 class="text-dark font-weight-bold mb-5">Thông tin chung</h4>
            
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
                        <label class="control-label">Địa danh<span class="require">*</span></label>
                        {!! Form::text('diadanh', null, ['id' => 'diadanh', 'class' => 'form-control required']) !!}
                    </div>
                </div>
                <!--/span-->
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label">Số điện thoại</label>
                        {!! Form::text('dienthoai', null, ['id' => 'dienthoai', 'class' => 'form-control required']) !!}
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Email<span class="require">*</span></label>
                        {!! Form::text('emailql', null, ['id' => 'emailql', 'class' => 'form-control required']) !!}
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

                <h4 class="text-dark font-weight-bold mb-5">Thiết lập khác</h4>
                <div class="form-group row">
                    <label class="col-1"></label>
                    <div class="col-11 col-form-label">
                        <div class="checkbox-inline">
                            <label class="checkbox checkbox-outline checkbox-success">
                                <input type="checkbox" name="opt_duthaototrinh" />
                                <span></span>Dự thảo tờ trình</label>
                            <label class="checkbox checkbox-outline checkbox-success">
                                <input type="checkbox" name="opt_duthaoquyetdinh" />
                                <span></span>Dự thảo quyết định khen thưởng</label>
                        </div>
                    </div>
                </div>
            @endif



        </div>
        <div class="card-footer">
            <div class="row text-center">
                <div class="col-lg-12">
                    <a href="{{ url('general') }}" class="btn btn-danger"><i class="fa fa-reply"></i>&nbsp;Quay lại</a>
                <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Cập
                    nhật</button>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@stop
