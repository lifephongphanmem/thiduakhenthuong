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
    <div class="card card-custom" style="min-height: 600px">
        <div class="card-header flex-wrap border-1 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Danh sách tài liệu, văn bản pháp lý</h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                @if (chkPhanQuyen('dsvanbanphaply', 'modify'))
                    <a type="button" href="{{ url('/QuanLyVanBan/VanBanPhapLy/Them') }}" class="btn btn-success btn-xs">
                        <i class="fa fa-plus"></i>&nbsp;Thêm mới</a>
                @endif
                <!--end::Button-->
            </div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <div class="col-lg-6">
                    <label>Loại văn bản</label>
                    {!! Form::select('loaivb', setArrayAll(getLoaiVanBan()), null, ['id' => 'loaivb', 'class' => 'form-control select2basic']) !!}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-12">
                    <table class="table table-striped table-bordered table-hover" id="sample_3">
                        <thead>
                            <tr class="text-center">
                                <th width="2%">STT</th>
                                <th width="15%">Đơn vị ban hành</th>
                                <th>Số hiệu<br>văn bản</th>
                                <th>Nội dung</th>
                                <th>Ngày<br>ban hành</th>
                                <th>Ngày<br>áp dụng</th>
                                <th width="15%">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($model as $key => $tt)
                                <tr>
                                    <td style="text-align: center">{{ $key + 1 }}</td>
                                    <td class="active">{{ $tt->dvbanhanh }}</td>
                                    <td class="success">{{ $tt->kyhieuvb }}</td>
                                    <td>{{ $tt->tieude }}</td>
                                    <td style="text-align: center">{{ getDayVn($tt->ngaybanhanh) }}</td>
                                    <td style="text-align: center">{{ getDayVn($tt->ngayapdung) }}</td>
                                    <td>                                       
                                        <button type="button" onclick="get_attack('{{ $tt->mavanban }}')"
                                            class="btn btn-sm btn-clean btn-icon" data-target="#dinhkem-modal-confirm"
                                            data-toggle="modal">
                                            <i class="icon-lg la flaticon-download text-dark"></i></button>
                                        
                                        @if (chkPhanQuyen('dsvanbanphaply', 'modify'))
                                            <a href="{{ url('/QuanLyVanBan/VanBanPhapLy/Sua?mavanban=' . $tt->mavanban ) }}"
                                                class="btn btn-sm btn-clean btn-icon">
                                                <i class="icon-lg la fa-edit text-dark"></i></a>

                                                <button type="button"
                                                onclick="confirmDelete('{{ $tt->id }}','/QuanLyVanBan/VanBanPhapLy/Xoa')"
                                                class="btn btn-sm btn-clean btn-icon" data-target="#delete-modal-confirm"
                                                data-toggle="modal">
                                                <i class="icon-lg la fa-trash text-danger"></i></button>
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
    <!--end::Card-->
    @include('includes.modal.modal_attackfile')
    @include('includes.modal.modal-delete')
@stop
