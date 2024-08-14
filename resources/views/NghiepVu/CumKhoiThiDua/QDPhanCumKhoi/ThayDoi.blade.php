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
    {!! Form::model($model, [
        'method' => 'POST',
        '/CumKhoiThiDua/CumKhoi/Them',
        'class' => 'horizontal-form',
        'id' => 'update_dmdonvi',
        'files' => true,
        'enctype' => 'multipart/form-data',
    ]) !!}
    {{-- {{ Form::hidden('id', null) }} --}}
    {{ Form::hidden('maqdphancumkhoi', null) }}
    <div class="card card-custom wave wave-animate-slow wave-primary" style="min-height: 600px">
        <div class="card-header flex-wrap border-1 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Thông tin quyết định phân cụm, khối thi đua</h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                <!--end::Button-->
            </div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <div class="col-3">
                    <label>Số quyết định<span class="require">*</span></label>
                    {!! Form::text('soqd', null, ['class' => 'form-control', 'required']) !!}
                </div>
                <div class="col-3">
                    <label>Ngày quyết định</label>
                    {!! Form::input('date', 'ngayqd', null, ['class' => 'form-control']) !!}
                </div>
                <div class="col-6">
                    <label>Đơn vị ban hành</label>
                    {!! Form::text('dvbanhanh', null, ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-12">
                    <label>Nội dung quyết định</label>
                    {!! Form::textarea('noidung', null, ['class' => 'form-control', 'rows' => '3']) !!}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-3">
                    <label>Ngày áp dụng</label>
                    {!! Form::input('date', 'ngayapdung', null, ['class' => 'form-control', 'required']) !!}
                </div>
                <div class="col-3">
                    <label>Tình trạng áp dụng</label>
                    {!! Form::select('tinhtrang', ['1'=>'Đang áp dụng', '0'=>'Không áp dụng'],null,  ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-12">
                    <label>Quyết định phân cụm, khối </label>
                    {!! Form::file('ipf1', null, ['class' => 'form-control']) !!}
                    @if ($model->ipf1 != '')
                        <span class="form-control" style="border-style: none">
                            <a href="{{ url('/data/quyetdinh/' . $model->ipf1) }}" target="_blank">{{ $model->ipf1 }}</a>
                        </span>
                    @endif
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row text-center">
                <div class="col-lg-12">
                    <a href="{{ url('/CumKhoiThiDua/QDPhanCumKhoi/ThongTin') }}" class="btn btn-danger mr-5"><i
                            class="fa fa-reply"></i>&nbsp;Quay lại</a>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>Hoàn thành</button>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
    <!--end::Card-->
@stop
