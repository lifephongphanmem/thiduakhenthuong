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

            $('#madonvi, #capdo').change(function() {
                window.location.href = '/TaiKhoan/ThongTin?madonvi=' + $('#madonvi').val() + '&capdo=' + $('#capdo').val();
            });
        });
    </script>
@stop

@section('content')
    <!--begin::Card-->
    <div class="card card-custom wave wave-animate-slow wave-primary" style="min-height: 600px">
        <div class="card-header flex-wrap border-1 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Thiết lập phạm vi dữ liệu cho cán bộ</h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                
                <!--end::Button-->
            </div>
        </div>
        <div class="card-body">
            

            <div class="form-group row">
                <div class="col-md-12">
                    <table class="table table-bordered table-hover" id="sample_3">
                        <thead>
                            <tr class="text-center">
                                <th width="10%">STT</th>
                                <th>Tên đơn vị</th>
                                <th width="10%">Thao tác</th>
                            </tr>

                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            ?>
                           
                                @foreach ($donvi as $tt_donvi)
                                    <tr>
                                        <td class="text-right">{{ $j++ }}</td>
                                        <td>{{ $tt_donvi->tendonvi }}</td>
                                        <td class="text-center">
                                            <a href="{{ '/TaiKhoan/DanhSach?madonvi=' . $tt_donvi->madonvi }}"
                                                class="btn btn-icon btn-clean btn-lg mb-1 position-relative"
                                                title="Danh sách tài khoản">
                                                <span class="svg-icon svg-icon-xl">
                                                    <i class="icon-lg flaticon-user text-success icon-2x"></i>
                                                </span>
                                                <span
                                                    class="label label-sm label-light-danger text-dark label-rounded font-weight-bolder position-absolute top-0 right-0">{{ $tt_donvi->sotaikhoan }}</span>
                                            </a>
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
    @include('includes.modal.modal-delete')
@stop
