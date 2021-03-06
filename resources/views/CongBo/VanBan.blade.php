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
    <script>
        
        function get_attack_id(id) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: '/vanbanqlnnvegia/dinhkem',
                type: 'GET',
                data: {
                    _token: CSRF_TOKEN,
                    id: id
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
                                        <span class="caption-subject theme-font bold uppercase">Văn bản quản lý nhà nước về
                                            thi đua khen thưởng</span>
                                    </div>
                                    <div class="tools">
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Loại văn bản</label>
                                            {!! Form::select('loaivb', getLoaiVanBan(), null, ['id' => 'loaivb', 'class' => 'form-control']) !!}
                                        </div>
                                    </div>

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
                                                    <th style="text-align: center">Ngày <br>áp dụng</th>
                                                    <th style="text-align: center" width="5%">Thao tác</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @foreach ($model as $key => $tt)
                                                    <tr>
                                                        <td class="active">{{ $tt->dvbanhanh }}</td>
                                                        <td class="success">{{ $tt->kyhieuvb }}</td>
                                                        <td>{{ $tt->tieude }}</td>
                                                        <td style="text-align: center">{{ getDayVn($tt->ngayapdung) }}
                                                        </td>
                                                        <td>
                                                            <button type="button"
                                                                onclick="get_attack('{{ $tt->mavanban }}')"
                                                                class="btn btn-default btn-xs mbs"
                                                                data-target="#dinhkem-modal-confirm" data-toggle="modal"><i
                                                                    class="fa fa-cloud-download"></i>&nbsp;Tải tệp</button>
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
    @include('includes.modal.modal_attackfile')
    {{-- @include('includes.script.inputmask-ajax-scripts') --}}
    {{-- @include('includes.script.create-header-scripts') --}}
@stop
