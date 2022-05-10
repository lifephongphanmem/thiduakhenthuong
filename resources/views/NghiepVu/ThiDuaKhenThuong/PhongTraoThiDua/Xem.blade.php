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

        function ThemKhenThuong() {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: '/PhongTraoThiDua/ThemKhenThuong',
                type: 'GET',
                data: {
                    _token: CSRF_TOKEN,
                    soluong: $('#soluong').val(),
                    madanhhieutd: $('#madanhhieutd').val(),
                    mahinhthuckt: $('#mahinhthuckt').val(),
                    maphongtraotd: $('#frm_ThayDoi').find("[name='maphongtraotd']").val()
                },
                dataType: 'JSON',
                success: function(data) {
                    if (data.status == 'success') {
                        toastr.success("Bổ xung thông tin thành công!");
                        $('#dskhenthuong').replaceWith(data.message);
                        jQuery(document).ready(function() {
                            TableManaged3.init();
                        });
                        $('#modal-create').modal("hide");

                    }
                }
            })
        }

        function ThemTieuChuan() {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var batbuoc = 0;
            if ($('#batbuoc').checked)
                batbuoc = 1;
            $.ajax({
                url: '/PhongTraoThiDua/ThemTieuChuan',
                type: 'GET',
                data: {
                    _token: CSRF_TOKEN,
                    batbuoc: batbuoc,
                    matieuchuandhtd: $('#frmThemTieuChuan').find("[name='matieuchuandhtd']").val(),
                    tentieuchuandhtd: $('#frmThemTieuChuan').find("[name='tentieuchuandhtd']").val(),
                    maphongtraotd: $('#frm_ThayDoi').find("[name='maphongtraotd']").val()
                },
                dataType: 'JSON',
                success: function(data) {
                    if (data.status == 'success') {
                        toastr.success("Bổ xung thông tin thành công!");
                        $('#dstieuchuan').replaceWith(data.message);
                        jQuery(document).ready(function() {
                            TableManaged4.init();
                        });
                        $('#modal-TieuChuan').modal("hide");

                    }
                }
            })
        }

        function setTieuChuan() {            
            $('#frmThemTieuChuan').find("[name='matieuchuandhtd']").val(null);            
        } 

        function getTieuChuan(id) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: '/PhongTraoThiDua/LayTieuChuan',
                type: 'GET',
                data: {
                    _token: CSRF_TOKEN,
                    id: id,
                    maphongtraotd: $('#frm_ThayDoi').find("[name='maphongtraotd']").val()
                },
                dataType: 'JSON',
                success: function(data) {
                    $('#frmThemTieuChuan').find("[name='tentieuchuandhtd']").val(data.tentieuchuandhtd);
                    $('#frmThemTieuChuan').find("[name='matieuchuandhtd']").val(data.matieuchuandhtd)
                    if (data.batbuoc == 1) {
                        $('#frmThemTieuChuan').find("[name='batbuoc']").prop('checked', true);
                    } else
                        $('#frmThemTieuChuan').find("[name='batbuoc']").prop('checked', false);
                }
            })
        }       

        function deleteRow() {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: '/dangkytddf/delete',
                type: 'GET',
                data: {
                    _token: CSRF_TOKEN,
                    id: $('#iddelete').val(),
                    maphongtraotd: $('#frm_ThayDoi').find("[name='maphongtraotd']").val()
                },
                dataType: 'JSON',
                success: function(data) {
                    //if(data.status == 'success') {
                    toastr.success("Bạn đã xóa thông tin đối tượng thành công!", "Thành công!");
                    $('#dsdt').replaceWith(data.message);
                    jQuery(document).ready(function() {
                        TableManaged.init();
                    });

                    $('#modal-delete').modal("hide");

                    //}
                }
            })

        }
    </script>
@stop

@section('content')
    <!--begin::Card-->

    <div class="card card-custom" style="min-height: 600px">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Thông tin chi tiết phong trào thi đua</h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                <!--end::Button-->
            </div>
        </div>

        {!! Form::model($model, ['method' => 'POST', '', 'class' => 'form', 'id' => 'frm_ThayDoi', 'files' => true, 'enctype' => 'multipart/form-data']) !!}
        {{ Form::hidden('madonvi', null) }}
        {{ Form::hidden('maphongtraotd', null) }}
        <div class="card-body">
            <div class="form-group row">
                <div class="col-lg-12">
                    <label>Đơn vị phát động</label>
                    {!! Form::text('tendonvi', null, ['class' => 'form-control text-success text-bold', 'readonly']) !!}
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-4">
                    <label>Phạm vị phát động</label>
                    {!! Form::select('phamviapdung', getPhamViPhongTrao(), null, ['class' => 'form-control select2basic']) !!}
                </div>

                <div class="col-lg-4">
                    <label>Loại hình khen thưởng</label>
                    {!! Form::select('maloaihinhkt', $a_loaihinhkt, null, ['class' => 'form-control select2basic']) !!}
                </div>

                <div class="col-lg-4">
                    <label>Hình thức tổ chức</label>
                    {!! Form::select('phanloai', getPhanLoaiPhongTraoThiDua(), null, ['class' => 'form-control select2basic']) !!}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-3">
                    <label>Số quyết định<span class="require">*</span></label>
                    {!! Form::text('soqd', null, ['class' => 'form-control', 'required']) !!}
                </div>
                <div class="col-lg-3">
                    <label>Ngày ra quyết định<span class="require">*</span></label>
                    {!! Form::input('date', 'ngayqd', null, ['class' => 'form-control', 'required']) !!}
                </div>


                <div class="col-lg-3">
                    <label>Ngày nhận hồ sơ<span class="require">*</span></label>
                    {!! Form::input('date', 'tungay', null, ['class' => 'form-control', 'required']) !!}
                </div>
                <div class="col-lg-3">
                    <label>Ngày kết thúc<span class="require">*</span></label>
                    {!! Form::input('date', 'denngay', null, ['class' => 'form-control', 'required']) !!}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-12">
                    <label>Nội dung phong trào</label>
                    {!! Form::textarea('noidung', null, ['class' => 'form-control', 'rows' => 2]) !!}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-12">
                    <label>Khẩu hiệu phong trào</label>
                    {!! Form::textarea('khauhieu', null, ['class' => 'form-control', 'rows' => 2]) !!}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-6">
                    <label>Tờ trình: </label>
                    @if ($model->totrinh != '')
                        <span class="form-control" style="border-style: none">
                            <a href="{{ url('/data/totrinh/' . $model->totrinh) }}"
                                target="_blank">{{ $model->totrinh }}</a>
                        </span>
                    @endif
                </div>
                <div class="col-lg-6">
                    <label>Quyết định khen thưởng: </label>
                    @if ($model->qdkt != '')
                        <span class="form-control" style="border-style: none">
                            <a href="{{ url('/data/qdkt/' . $model->qdkt) }}" target="_blank">{{ $model->qdkt }}</a>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-6">
                    <label>Biên bản: </label>
                    @if ($model->bienban != '')
                        <span class="form-control" style="border-style: none">
                            <a href="{{ url('/data/bienban/' . $model->bienban) }}"
                                target="_blank">{{ $model->bienban }}</a>
                        </span>
                    @endif
                </div>
                <div class="col-lg-6">
                    <label>Tài liệu khác: </label>
                    @if ($model->tailieukhac != '')
                        <span class="form-control" style="border-style: none">
                            <a href="{{ url('/data/tailieukhac/' . $model->tailieukhac) }}"
                                target="_blank">{{ $model->tailieukhac }}</a>
                        </span>
                    @endif
                </div>
            </div>
            <div class="separator separator-dashed my-5"></div>
            <h4 class="text-dark font-weight-bold mb-10">Danh sách tiêu chuẩn khen thưởng</h4>

            <div class="form-group row" id="dstieuchuan">
                <div class="col-lg-12">
                    <table id="sample_3" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th style="text-align: center" width="10%">STT</th>
                                <th style="text-align: center">Tên tiêu chuẩn xét khen thưởng</th>
                                <th style="text-align: center" width="10%">Tiêu chuẩn</br>Bắt buộc</th>
                                <th style="text-align: center" width="12%">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            @foreach ($model_tieuchuan as $key => $tt)
                                <tr class="odd gradeX">
                                    <td style="text-align: center">{{ $i++ }}</td>
                                    <td>{{ $tt->tentieuchuandhtd }}</td>
                                    @if ($tt->batbuoc == 0)
                                        <td class="text-center"></td>
                                    @else
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-clean btn-icon">
                                                <i class="icon-lg la fa-check text-success"></i></button>
                                        </td>
                                    @endif
                                    <td class="text-center"></td>
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
                    
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>

    {!! Form::open(['url' => '', 'files' => true, 'id' => 'frmThemTieuChuan', 'class' => 'horizontal-form']) !!}
    {{ Form::hidden('matieuchuandhtd', null) }}
    <div class="modal fade bs-modal-lg" id="modal-tieuchuan" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Thông tin tiêu chuẩn khen thưởng</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label class="control-label">Mô tả tiêu chuẩn</label>
                            {!! Form::textarea('tentieuchuandhtd', null, ['id' => 'tentieuchuandhtd', 'class' => 'form-control', 'rows' => 3]) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-offset-4 col-lg-3">
                            <div class="md-checkbox">
                                <input type="checkbox" id="batbuoc" name="batbuoc" class="md-check">
                                <label for="batbuoc">
                                    <span></span><span class="check"></span><span
                                        class="box"></span>Tiêu chuẩn bắt buộc</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Thoát</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    {!! Form::close() !!}

    {!! Form::open(['url' => '/PhongTraoThiDua/XoaTieuChuan', 'id' => 'frm_delete']) !!}
    <div id="delete-modal" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <h4 id="modal-header-primary-label" class="modal-title">Đồng ý xoá?</h4>
                    <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                    <input type="hidden" name="id" />
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
                    <button type="submit" data-dismiss="modal" class="btn btn-primary" onclick="clickdelete()">Đồng
                        ý</button>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    <script>
        function getId(id) {
            $('#frm_delete').find("[name='id']").val(id);
        }
    
        function clickdelete() {
            $('#frm_delete').submit();
        }
    </script>
    <!--end::Card-->
@stop
