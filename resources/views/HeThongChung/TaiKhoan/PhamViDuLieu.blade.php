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
        });
    </script>
@stop

@section('content')
    <!--begin::Card-->
    <div class="card card-custom wave wave-animate-slow wave-primary" style="min-height: 600px">
        <div class="card-header flex-wrap border-1 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Thiết lập phạm vi dữ liệu cho cán bộ:
                    {{ $model_taikhoan->tentaikhoan }} </h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                <button type="button" class="btn btn-success btn-xs" data-target="#taohoso-modal" data-toggle="modal">
                    <i class="fa fa-plus"></i>&nbsp;Thêm mới
                </button>
                <!--end::Button-->
            </div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <div class="col-md-12">
                    <table class="table table-bordered table-hover" id="sample_3">
                        <thead>
                            <tr class="text-center">
                                <th width="5%">STT</th>
                                <th>Tên địa bàn/Tên cụm khối</th>
                                <th width="15%">Thao tác</th>
                            </tr>

                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            @foreach ($model as $ct)
                                <tr>
                                    <td class="text-right">{{ $i++ }}</td>
                                    <td>{{ $a_diabancumkhoi[$ct->madiabancumkhoi] ?? $ct->madiabancumkhoi }}</td>
                                    <td class="text-center">
                                        <button type="button"
                                            onclick="confirmDelete('{{ $ct->id }}', '/TaiKhoan/XoaPhamViDuLieu' )"
                                            class="btn btn-sm btn-clean btn-icon" data-target="#delete-modal-confirm"
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

        <div class="card-footer">
            <div class="row text-center">
                <div class="col-lg-12">
                    <a href="{{ url('/TaiKhoan/DanhSach?madonvi=' . $model_taikhoan->madonvi) }}"
                        class="btn btn-danger mr-5"><i class="fa fa-reply"></i>&nbsp;Quay lại
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!--end::Card-->

    {!! Form::open(['url' => $inputs['url'], 'id' => 'frm_hoso', 'files' => true]) !!}
    <input type="hidden" name="tendangnhap" value="{{ $model_taikhoan->tendangnhap }}" />
    <div id="taohoso-modal" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade kt_select2_modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <h4 id="modal-header-primary-label" class="modal-title">Thiết lập địa bàn; cụm khối lọc dữ liệu</h4>
                    <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                </div>

                <div class="modal-body">

                    <div class="form-group row">
                        <div class="col-12">
                            <label>Tên địa bàn/Tên cụm khối</label>
                            {!! Form::select('madiabancumkhoi', $a_diabancumkhoi, null, ['class' => 'form-control select2_modal']) !!}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
                    <button type="submit" class="btn btn-primary">Đồng ý</button>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}

    @include('includes.modal.modal-delete')
@stop
