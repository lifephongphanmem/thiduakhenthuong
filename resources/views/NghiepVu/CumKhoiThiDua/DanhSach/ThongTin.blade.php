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
                <h3 class="card-label text-uppercase">Danh sách cụm khối thi đua</h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                @if (chkPhanQuyen('dscumkhoithidua', 'thaydoi'))
                    <a href="{{ url($inputs['url'] . 'Them') }}" class="btn btn-success btn-xs">
                        <i class="fa fa-plus"></i> Thêm mới</a>
                @endif
                <!--end::Button-->
            </div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <div class="col-md-12">

                    <table class="table table-striped table-bordered table-hover" id="sample_3">
                        <thead>
                            <tr class="text-center">
                                <th width="5%">STT</th>
                                <th>Tên cụm, khối thi đua</th>
                                {{-- <th width="15%">Cấp độ</th> --}}
                                <th width="8%">Số</br>đơn vị</th>
                                <th width="30%">Đơn vị quản lý</th>
                                <th width="10%">Thao tác</th>
                            </tr>
                        </thead>
                        @foreach ($model as $key => $tt)
                            <tr>
                                <td style="text-align: center">{{ $key + 1 }}</td>
                                <td class="active">{{ $tt->tencumkhoi }}</td>
                                {{-- <td>{{ $a_capdo[$tt->capdo] ?? '' }}</td> --}}
                                <td class=" text-center">{{ $tt->sodonvi }}</td>
                                <td>{{ $a_donvi[$tt->madonviql] ?? '' }}</td>
                                <td class=" text-center">
                                    @if (chkPhanQuyen('dscumkhoithidua', 'thaydoi'))
                                        <a title="Chỉnh sửa"
                                            href="{{ url($inputs['url'] . 'Sua?macumkhoi=' . $tt->macumkhoi) }}"
                                            class="btn btn-sm btn-clean btn-icon"><i
                                                class="icon-lg la fa-edit text-success"></i>
                                        </a>

                                        <a title="Danh sách đơn vị"
                                            href="{{ url($inputs['url'] . 'DanhSach/?macumkhoi=' . $tt->macumkhoi) }}"
                                            class="btn btn-sm btn-clean btn-icon">
                                            <i class="icon-lg la la-clipboard-list text-dark"></i>
                                        </a>

                                        <button title="Xóa cụm khối" type="button"
                                            onclick="confirmDelete('{{ $tt->id }}',$inputs['url'].'Xoa')"
                                            class="btn btn-sm btn-clean btn-icon" data-target="#delete-modal-confirm"
                                            data-toggle="modal">
                                            <i class="icon-lg la fa-trash-alt text-danger"></i>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--end::Card-->
    @include('includes.modal.modal-delete')
@stop
