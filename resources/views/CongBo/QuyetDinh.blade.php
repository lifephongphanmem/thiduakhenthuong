@extends('CongBo.maincongbo')

@section('custom-style-cb')
    <link rel="stylesheet" type="text/css" href="{{ url('assets/css/pages/dataTables.bootstrap.css') }}" />
    <!-- END THEME STYLES -->
@stop

@section('custom-script-cb')
    {{-- <script src="/assets/js/pages/select2.js"></script> --}}
    <script src="/assets/js/pages/jquery.dataTables.min.js"></script>
    <script src="/assets/js/pages/dataTables.bootstrap.js"></script>
    {{-- <script src="/assets/js/pages/table-lifesc.js"></script> --}}
    <!-- END PAGE LEVEL PLUGINS -->
@stop

@section('content-cb')

    <div class="container">
        <div class="row margin-top-10">
            <div class=" col-sm-12">
                <!-- BEGIN PORTLET-->
                <!--div class="portlet light"-->
                <div class="portlet-title">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN SAMPLE TABLE PORTLET-->
                            <div class="portlet light" style="min-height: 587px">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-cogs font-green-sharp"></i>
                                        <span class="caption-subject theme-font bold uppercase">danh sách quyết định khen
                                            thưởng</span>
                                    </div>
                                    <div class="tools">
                                    </div>
                                </div>
                                <div class="row">

                                </div>
                                <br>

                                <div class="portlet-body">
                                    <div class="table-scrollable">
                                        <table class="table table-striped table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th style="text-align: center">Đơn vị ban hành</th>
                                                    <th style="text-align: center" width="5%">Số hiệu <br>văn bản</th>
                                                    <th style="text-align: center">Nội dung</th>
                                                    <th style="text-align: center">Cấp độ<br>khen thưởng</th>
                                                    <th style="text-align: center" width="5%">Thao tác</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @foreach ($model as $key => $tt)
                                                    <tr>
                                                        <td class="active">{{ $tt->donvikhenthuong }}</td>
                                                        <td class="success text-center">
                                                            {{ $tt->soqd }}<br>{{ getDayVn($tt->ngayqd) }}</td>
                                                        <td>{{ $tt->tieude }}</td>
                                                        <td style="text-align: center">
                                                            {{ $a_phamvi[$tt->capkhenthuong] ?? '' }}</td>
                                                        <td>
                                                            <button type="button"
                                                                onclick="get_attack('{{ $tt->maquyetdinh }}', '{{ $tt->phanloaikhenthuong }}')"
                                                                class="btn btn-default btn-xs mbs"
                                                                data-target="#dinhkem-modal-confirm" data-toggle="modal"><i
                                                                    class="fa fa-cloud-download"></i>&nbsp;Tải tệp
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                            <!-- END SAMPLE TABLE PORTLET-->
                        </div>
                    </div>

                    <!--/div-->
                    <!-- END PORTLET-->
                </div>
            </div>
        </div>
    </div>

    <div id="dinhkem-modal-confirm" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade">
        {!! Form::open(['url' => '', 'id' => 'frm_dinhkem']) !!}
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <h4 id="modal-header-primary-label" class="modal-title">Danh sách tài liệu đính kèm</h4>
                    <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                </div>
                <div class="modal-body" id="dinh_kem">

                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Đóng</button>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    <script>
        function get_attack(maqd, bang) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: '/CongBo/TaiLieuQuyetDinh',
                type: 'GET',
                data: {
                    _token: CSRF_TOKEN,
                    maqd: maqd,
                    phanloai: bang,
                },
                dataType: 'JSON',
                success: function(data) {
                    if (data.status == 'success') {
                        $('#dinh_kem').replaceWith(data.message);
                    }
                },
                error: function(message) {
                    toastr.error(message, 'Lỗi!');
                }
            });
        }
    </script>
@stop
