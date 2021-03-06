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

        function getId(id) {
            document.getElementById("iddelete").value = id;
        }

        function ClickDelete() {
            $('#frm_delete').submit();
        }

        function add() {
            // $('#machuc').val('');
            // $('#madiaban').attr('readonly', true);
        }

        function getChucNang(id) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: '/ChucNang/LayChucNang',
                type: 'GET',
                data: {
                    _token: CSRF_TOKEN,
                    id: id,
                },
                dataType: 'JSON',
                success: function(data) {
                    var form = $('#frm_modify');
                    form.find("[name='machucnang']").val(data.machucnang);
                    form.find("[name='tenchucnang']").val(data.tenchucnang);
                    form.find("[name='sapxep']").val(data.sapxep);
                    form.find("[name='capdo']").val(data.capdo).trigger('change');
                    form.find("[name='machucnang_goc']").val(data.machucnang_goc).trigger('change');
                    form.find("[name='sudung']").val(data.sudung).trigger('change');
                    form.find("[name='tenbang']").val(data.tenbang);
                    form.find("[name='api']").val(data.api);
                }
            })
        }
    </script>
@stop

@section('content')
    <!--begin::Card-->
    <div class="card card-custom wave wave-animate-slow wave-primary" style="min-height: 600px">
        <div class="card-header flex-wrap border-1 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Danh s??ch ch???c n??ng h??? th???ng</h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                @if (chkPhanQuyen('hethongchung_chucnang', 'modify'))
                    <button type="button" onclick="add()" class="btn btn-success btn-xs" data-target="#modify-modal"
                        data-toggle="modal">
                        <i class="fa fa-plus"></i>&nbsp;Th??m m???i</button>
                @endif
                <!--end::Button-->
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-hover" id="sample_3">
                        <thead>
                            <tr class="text-center">
                                <th width="10%">STT</th>
                                <th width="15%">M?? s???</th>
                                <th>T??n ch???c n??ng</th>
                                <th width="15%">Thao t??c</th>
                            </tr>
                        </thead>
                        <tbody>                            
                            @foreach ($model as $ct_t)
                                <tr class="success">
                                    <td class="text-uppercase">{{toAlpha($ct_t->sapxep)}}</td>
                                    <td>{{ $ct_t->machucnang }}</td>
                                    <td>{{ $ct_t->tenchucnang }}</td>
                                    <td style="text-align: center">
                                        @if (chkPhanQuyen('hethongchung_chucnang', 'modify'))
                                            <button onclick="getChucNang({{ $ct_t->id }})"
                                                class="btn btn-sm btn-clean btn-icon" data-target="#modify-modal"
                                                title="Thay ?????i th??ng tin" data-toggle="modal">
                                                <i class="icon-lg la fa-edit text-dark"></i></button>
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
    <!--Modal th??ng tin chi ti???t -->
    {!! Form::open(['url' => '/ChucNang/ThongTin', 'id' => 'frm_modify']) !!}
    <div id="modify-modal" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade kt_select2_modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <h4 id="modal-header-primary-label" class="modal-title">Th??ng tin ch???c n??ng</h4>
                    <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-horizontal">
                        <div class="row form-group">
                            <div class="col-lg-4">
                                <label class="control-label">M?? s???</label>
                                {!! Form::text('machucnang', null, ['class' => 'form-control']) !!}
                            </div>

                            <div class="col-lg-8">
                                <label class="control-label">T??n ch???c n??ng<span class="require">*</span></label>
                                {!! Form::text('tenchucnang', null, ['class' => 'form-control', 'required' => 'required']) !!}
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-lg-6">
                                <label class="control-label">C???p ?????</label>
                                {!! Form::select('capdo', ['1' => '1', '2' => '2', '3' => '3', '4' => '4'], null, ['class' => 'form-control select2_modal']) !!}
                            </div>

                            <div class="col-lg-6">
                                <label class="control-label">S??? th??? t???</label>
                                {!! Form::text('sapxep', null, ['class' => 'form-control']) !!}
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-lg-12">
                                <label class="control-label">Ch???c n??ng g???c</label>
                                {!! Form::select('machucnang_goc', setArrayAll($a_chucnanggoc,'Kh??ng ch???n'), null, ['class' => 'form-control select2_modal']) !!}
                            </div>
                        </div>

                        @if (session('admin')->capdo == 'SSA')
                            <div class="row form-group">
                                <div class="col-lg-4">
                                    <label class="control-label">T??n b???ng d??? li???u</label>
                                    {!! Form::text('tenbang', null, ['class' => 'form-control']) !!}
                                </div>

                                <div class="col-lg-8">
                                    <label class="control-label">Link API</label>
                                    {!! Form::text('api', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-lg-6">
                                    <label class="control-label">Tr???ng th??i</label>
                                    {!! Form::select('sudung', ['0' => 'Kh??a ch???c n??ng', '1' => '??ang s??? d???ng'], null, ['class' => 'form-control select2_modal']) !!}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">H???y thao t??c</button>
                    <button type="submit" id="submit" name="submit" value="submit" class="btn btn-primary">?????ng ??</button>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}

    <div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                {!! Form::open(['url' => 'diaban/delete', 'id' => 'frm_delete']) !!}
                <div class="modal-header">
                    <h4 class="modal-title">?????ng ?? x??a?</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                </div>
                <input type="hidden" name="iddelete" id="iddelete">
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger" onclick="ClickDelete()">?????ng ??</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">H???y</button>
                </div>
                {!! Form::close() !!}
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>




@stop
