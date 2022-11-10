@extends('HeThong.main')

@section('custom-style')
    <link rel="stylesheet" type="text/css" href="{{ url('assets/css/pages/dataTables.bootstrap.css') }}" />
    {{-- <link rel="stylesheet" type="text/css" href="{{ url('assets/css/pages/select2.css') }}" /> --}}
@stop

@section('custom-script-footer')
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="/assets/js/pages/select2.js"></script>
@stop

@section('content')
    <!--begin::Card-->
    {!! Form::model($model, ['method' => 'POST', '/TaiKhoan/DoiMatKhau', 'class' => 'horizontal-form', 'id' => 'update_dmdonvi', 'files' => true, 'enctype' => 'multipart/form-data']) !!}
    {{-- {{ Form::hidden('id', null) }} --}}
    {{ Form::hidden('madonvi', null) }}
    <div class="card card-custom wave wave-animate-slow wave-primary" style="min-height: 600px">
        <div class="card-header flex-wrap border-1 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Thông tin chi tiết tài khoản</h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                <!--end::Button-->
            </div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <div class="col-lg-4">
                    <label>Đơn vị quản lý</label>
                    {!! Form::select('madonvi', $a_donvi, null, ['class' => 'form-control select2basic', 'disabled']) !!}
                </div>

                <div class="col-lg-4">
                    <label>Tên tài khoản<span class="require">*</span></label>
                    {!! Form::text('tentaikhoan', null, ['class' => 'form-control', 'required', 'readonly'=>'true']) !!}
                </div>               
            </div>            

            <div class="form-group row">
                <div class="col-lg-4">
                    <label>Tài khoản truy cập<span class="require">*</span></label>
                    {!! Form::text('tendangnhap', null, ['class' => 'form-control', 'readonly'=>'true']) !!}
                </div>
                <div class="col-lg-4">
                    <label>Mật khẩu mới<span class="require">*</span></label>
                    {!! Form::text('matkhaumoi', null, ['class' => 'form-control','required']) !!}
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row text-center">
                <div class="col-lg-12">
                    <a href="{{ url('/TaiKhoan/DanhSach?madonvi=' . $model->madonvi) }}" class="btn btn-danger mr-5"><i
                            class="fa fa-reply"></i>&nbsp;Quay lại</a>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>Hoàn thành</button>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
    <!--end::Card-->
@stop
