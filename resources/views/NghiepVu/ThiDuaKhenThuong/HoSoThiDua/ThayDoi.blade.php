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
            TableManaged4.init();
        });

        function ThemDoiTuong() {
            //var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var form = $('#frm_ThemCaNhan');
            // var file = new FormData();
            // file.append('_token', $('meta[name="csrf-token"]').attr('content'));
            // file.append('madoituong', form.find("[name='madoituong']").val());
            // file.append('tendoituong', form.find("[name='tendoituong']").val());
            // file.append('ngaysinh', form.find("[name='ngaysinh']").val());
            // file.append('gioitinh', form.find("[name='gioitinh']").val());
            // file.append('chucvu', form.find("[name='chucvu']").val());
            // file.append('maccvc', form.find("[name='maccvc']").val());
            // file.append('lanhdao', form.find("[name='lanhdao']").val());                    
            // file.append('madanhhieutd', form.find("[name='madanhhieutd']").val());
            // file.append('tensangkien', form.find("[name='tensangkien']").val());
            // file.append('donvicongnhan', form.find("[name='donvicongnhan']").val());
            // file.append('thoigiancongnhan', form.find("[name='thoigiancongnhan']").val());
            // file.append('thanhtichdatduoc', form.find("[name='thanhtichdatduoc']").val());
            // //file.append('filedk', $("#filedk")[0].files[0]);
            // file.append('madonvi', $('#frm_ThayDoi').find("[name='madonvi']").val());
            // file.append('maphongtraotd', $('#frm_ThayDoi').find("[name='maphongtraotd']").val());
            // file.append('mahosotdkt', $('#frm_ThayDoi').find("[name='mahosotdkt']").val());

            // $.ajax({
            //     url: '/HoSoThiDua/ThemDoiTuong',
            //     type: 'GET',
            //     data: file,
            //     processData: false,
            //     contentType: false,
            //     success: function (data) {
            //         if (data.status == 'success') {
            //             toastr.success("B??? xung th??ng tin th??nh c??ng!");
            //             $('#dskhenthuong').replaceWith(data.message);
            //             jQuery(document).ready(function() {
            //                 TableManaged3.init();
            //             });
            //             $('#modal-create').modal("hide");

            //         }
            //     }
            // })


            $.ajax({
                url: '/HoSoThiDua/ThemDoiTuong',
                type: 'GET',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    madoituong: form.find("[name='madoituong']").val(),
                    tendoituong: form.find("[name='tendoituong']").val(),
                    ngaysinh: form.find("[name='ngaysinh']").val(),
                    gioitinh: form.find("[name='gioitinh']").val(),
                    chucvu: form.find("[name='chucvu']").val(),
                    maccvc: form.find("[name='maccvc']").val(),
                    lanhdao: form.find("[name='lanhdao']").val(),
                    mahinhthuckt: form.find("[name='mahinhthuckt']").val(),
                    tensangkien: form.find("[name='tensangkien']").val(),
                    donvicongnhan: form.find("[name='donvicongnhan']").val(),
                    thoigiancongnhan: form.find("[name='thoigiancongnhan']").val(),
                    thanhtichdatduoc: form.find("[name='thanhtichdatduoc']").val(),
                    //filedk: form.find("[name='filedk']").val(),
                    madonvi: $('#frm_ThayDoi').find("[name='madonvi']").val(),
                    maphongtraotd: $('#frm_ThayDoi').find("[name='maphongtraotd']").val(),
                    mahosotdkt: $('#frm_ThayDoi').find("[name='mahosotdkt']").val()
                },
                dataType: 'JSON',
                success: function(data) {
                    if (data.status == 'success') {
                        toastr.success("B??? xung th??ng tin th??nh c??ng!");
                        $('#dskhenthuong').replaceWith(data.message);
                        jQuery(document).ready(function() {
                            TableManaged3.init();
                        });
                        $('#modal-create').modal("hide");

                    }
                }
            })
        }

        function ThemDoiTuongTapThe() {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var form = $('#frm_ThemTapThe');
            $.ajax({
                url: '/HoSoThiDua/ThemDoiTuongTapThe',
                type: 'GET',
                data: {
                    _token: CSRF_TOKEN,
                    madonvi: $('#madonvi').val(),
                    matapthe: $('#matapthe').val(),
                    mahinhthuckt: form.find("[name='mahinhthuckt']").val(),
                    maphongtraotd: $('#frm_ThayDoi').find("[name='maphongtraotd']").val(),
                    mahosotdkt: $('#frm_ThayDoi').find("[name='mahosotdkt']").val()
                },
                dataType: 'JSON',
                success: function(data) {
                    if (data.status == 'success') {
                        toastr.success("B??? xung th??ng tin th??nh c??ng!");
                        $('#dskhenthuongtapthe').replaceWith(data.message);
                        jQuery(document).ready(function() {
                            TableManaged4.init();
                        });
                        $('#modal-create-tapthe').modal("hide");

                    }
                }
            })
        }

        function getTieuChuan(madoituong, tendt) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $('#frm_TieuChuan').find("[name='madoituong']").val(madoituong);
            $('#frm_TieuChuan').find("[name='tendoituong']").val(tendt);

            $.ajax({
                url: '/HoSoThiDua/LayTieuChuan',
                type: 'GET',
                data: {
                    _token: CSRF_TOKEN,
                    madoituong: madoituong,
                    madonvi: $('#madonvi').val(),
                    maphongtraotd: $('#frm_ThayDoi').find("[name='maphongtraotd']").val(),
                    mahosotdkt: $('#frm_ThayDoi').find("[name='mahosotdkt']").val()
                },
                dataType: 'JSON',
                success: function(data) {
                    if (data.status == 'success') {
                        $('#dstieuchuan').replaceWith(data.message);
                    }
                }
            })
        }

        function setCaNhan() {
            $('#frm_ThemCaNhan').find("[name='madoituong']").val('NULL');
        }

        function getCaNhan(id) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: '/HoSoThiDua/LayDoiTuong',
                type: 'GET',
                data: {
                    _token: CSRF_TOKEN,
                    id: id,
                },
                dataType: 'JSON',
                success: function(data) {
                    var form = $('#frm_ThemCaNhan');
                    form.find("[name='madoituong']").val(data.madoituong);
                    form.find("[name='tendoituong']").val(data.tendoituong);
                    form.find("[name='ngaysinh']").val(data.ngaysinh);
                    form.find("[name='gioitinh']").val(data.gioitinh).trigger('change');;
                    form.find("[name='chucvu']").val(data.chucvu);
                    form.find("[name='maccvc']").val(data.maccvc);
                    form.find("[name='lanhdao']").val(data.lanhdao).trigger('change');
                    form.find("[name='mahinhthuckt']").val(data.mahinhthuckt).trigger('change');;
                    form.find("[name='tensangkien']").val(data.tensangkien);
                    form.find("[name='donvicongnhan']").val(data.donvicongnhan);
                    form.find("[name='thoigiancongnhan']").val(data.thoigiancongnhan);
                    form.find("[name='thanhtichdatduoc']").val(data.thanhtichdatduoc);
                    //filedk: form.find("[name='filedk']").val(data.madoituong),
                }
            })
        }

        function getTapThe(id) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: '/HoSoThiDua/LayDoiTuong',
                type: 'GET',
                data: {
                    _token: CSRF_TOKEN,
                    id: id,
                },
                dataType: 'JSON',
                success: function(data) {
                    var form = $('#frm_ThemTapThe');
                    form.find("[name='matapthe']").val(data.matapthe).trigger('change');
                    form.find("[name='mahinhthuckt']").val(data.mahinhthuckt).trigger('change');
                    //filedk: form.find("[name='filedk']").val(data.madoituong),
                }
            })
        }

        function ThayDoiTieuChuan(matieuchuandhtd, tentieuchuandhtd) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $('#tentieuchuandhtd_ltc').val(tentieuchuandhtd);
            $('#matieuchuandhtd_ltc').val(matieuchuandhtd);
        }

        function LuuTieuChuan() {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: '/HoSoThiDua/LuuTieuChuan',
                type: 'GET',
                data: {
                    _token: CSRF_TOKEN,
                    madoituong: $('#frm_TieuChuan').find("[name='madoituong']").val(),
                    matieuchuandhtd: $('#matieuchuandhtd_ltc').val(),
                    madonvi: $('#madonvi').val(),
                    maphongtraotd: $('#frm_ThayDoi').find("[name='maphongtraotd']").val(),
                    mahosotdkt: $('#frm_ThayDoi').find("[name='mahosotdkt']").val()
                },
                dataType: 'JSON',
                success: function(data) {
                    if (data.status == 'success') {
                        $('#dstieuchuan').replaceWith(data.message);
                    }
                }
            })
            $('#modal-luutieuchuan').modal("hide");
        }

        function delKhenThuong(id, phanloai) {
            document.getElementById("iddelete").value = id;
            document.getElementById("phanloaixoa").value = phanloai;
        }

        function deleteRow() {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: '/HoSoThiDua/XoaDoiTuong',
                type: 'GET',
                data: {
                    _token: CSRF_TOKEN,
                    id: $('#iddelete').val(),
                    phanloai: $('#phanloaixoa').val(),
                    madonvi: $('#madonvi').val(),
                    maphongtraotd: $('#frm_ThayDoi').find("[name='maphongtraotd']").val(),
                    mahosotdkt: $('#frm_ThayDoi').find("[name='mahosotdkt']").val()
                },
                dataType: 'JSON',
                success: function(data) {
                    toastr.success("B???n ???? x??a th??ng tin ?????i t?????ng th??nh c??ng!", "Th??nh c??ng!");
                    if ($('#phanloaixoa').val() == 'CANHAN') {
                        $('#dskhenthuong').replaceWith(data.message);
                        jQuery(document).ready(function() {
                            TableManaged3.init();
                        });
                    } else {
                        $('#dskhenthuongtapthe').replaceWith(data.message);
                        jQuery(document).ready(function() {
                            TableManaged4.init();
                        });
                    }
                    $('#modal-delete-khenthuong').modal("hide");
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
                <h3 class="card-label text-uppercase">Th??ng tin h??? s?? tham gia phong tr??o thi ??ua</h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                <!--end::Button-->
            </div>
        </div>

        {!! Form::model($model, ['method' => 'POST', '/HoSoThiDua/Them', 'class' => 'form', 'id' => 'frm_ThayDoi', 'files' => true, 'enctype' => 'multipart/form-data']) !!}
        {{ Form::hidden('madonvi', null, ['id' => 'madonvi']) }}
        {{ Form::hidden('mahosotdkt', null, ['id' => 'mahosotdkt']) }}
        {{ Form::hidden('maphongtraotd', null, ['id' => 'maphongtraotd']) }}
        <div class="card-body">
            <div class="form-group row">
                <div class="col-lg-6">
                    <label>T??n ????n v???</label>
                    {!! Form::text('tendonvi', null, ['class' => 'form-control', 'readonly']) !!}
                </div>
                <div class="col-lg-6">
                    <label>T??n phong tr??o thi ??ua</label>
                    {!! Form::text('tenphongtrao', null, ['class' => 'form-control', 'readonly']) !!}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-6">
                    <label>Ng??y t???o h??? s??<span class="require">*</span></label>
                    {!! Form::input('date', 'ngayhoso', null, ['class' => 'form-control', 'required']) !!}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-12">
                    <label>M?? t??? h??? s??</label>
                    {!! Form::textarea('noidung', null, ['class' => 'form-control', 'rows' => 2]) !!}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-6">
                    <label>T??? tr??nh: </label>
                    {!! Form::file('totrinh', null, ['id' => 'totrinh', 'class' => 'form-control']) !!}
                    @if ($model->totrinh != '')
                        <span class="form-control" style="border-style: none">
                            <a href="{{ url('/data/totrinh/' . $model->totrinh) }}"
                                target="_blank">{{ $model->totrinh }}</a>
                        </span>
                    @endif
                </div>

                <div class="col-lg-6">
                    <label>B??o c??o th??nh t??ch: </label>
                    {!! Form::file('baocao', null, ['id' => 'baocao', 'class' => 'form-control']) !!}
                    @if ($model->baocao != '')
                        <span class="form-control" style="border-style: none">
                            <a href="{{ url('/data/baocao/' . $model->baocao) }}"
                                target="_blank">{{ $model->baocao }}</a>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-6">
                    <label>Bi??n b???n cu???c h???p: </label>
                    {!! Form::file('bienban', null, ['id' => 'bienban', 'class' => 'form-control']) !!}
                    @if ($model->bienban != '')
                        <span class="form-control" style="border-style: none">
                            <a href="{{ url('/data/bienban/' . $model->bienban) }}"
                                target="_blank">{{ $model->bienban }}</a>
                        </span>
                    @endif
                </div>

                <div class="col-lg-6">
                    <label>T??i li???u kh??c: </label>
                    {!! Form::file('tailieukhac', null, ['id' => 'tailieukhac', 'class' => 'form-control']) !!}
                    @if ($model->tailieukhac != '')
                        <span class="form-control" style="border-style: none">
                            <a href="{{ url('/data/tailieukhac/' . $model->tailieukhac) }}"
                                target="_blank">{{ $model->tailieukhac }}</a>
                        </span>
                    @endif
                </div>
            </div>

            <div class="separator separator-dashed my-5"></div>
            <h4 class="text-dark font-weight-bold mb-10">Danh s??ch khen th?????ng c?? nh??n</h4>
            <div class="form-group row">
                <div class="col-lg-12">
                    <button type="button" onclick="setCaNhan()" data-target="#modal-create" data-toggle="modal"
                        class="btn btn-success btn-xs">
                        <i class="fa fa-plus"></i>&nbsp;Th??m</button>
                </div>
            </div>
            <div class="row" id="dskhenthuong">
                <div class="col-md-12">
                    <table id="sample_3" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr class="text-center">
                                <th width="2%">STT</th>
                                <th>T??n ?????i t?????ng</th>
                                <th width="10%">Ng??y sinh</th>
                                <th width="10%">Gi???i t??nh</th>
                                <th width="15%">Ch???c v???</th>
                                <th width="20%">H??nh th???c<br>khen th?????ng</th>
                                <th width="15%">Thao t??c</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            @foreach ($model_khenthuong as $key => $tt)
                                <tr class="odd gradeX">
                                    <td class="text-center">{{ $i++ }}</td>
                                    <td>{{ $tt->tendoituong }}</td>
                                    <td>{{ getDayVn($tt->ngaysinh) }}</td>
                                    <td>{{ $tt->gioitinh }}</td>
                                    <td class="text-center">{{ $tt->chucvu }}</td>
                                    <td class="text-center">{{ $a_hinhthuckt[$tt->mahinhthuckt] ?? '' }}</td>
                                    <td class="text-center">
                                        <button title="Ti??u chu???n" type="button"
                                            onclick="getTieuChuan('{{ $tt->madoituong }}','{{ $tt->tendoituong }}')"
                                            class="btn btn-sm btn-clean btn-icon" data-target="#modal-tieuchuan"
                                            data-toggle="modal">
                                            <i class="icon-lg la fa-list text-primary"></i></button>

                                        <button title="S???a th??ng tin" type="button"
                                            onclick="getCaNhan('{{ $tt->id }}')"
                                            class="btn btn-sm btn-clean btn-icon" data-target="#modal-create"
                                            data-toggle="modal">
                                            <i class="icon-lg la fa-edit text-primary"></i></button>
                                        <button title="X??a" type="button"
                                            onclick="delKhenThuong('{{ $tt->id }}','CANHAN')"
                                            class="btn btn-sm btn-clean btn-icon" data-target="#modal-delete-khenthuong"
                                            data-toggle="modal">
                                            <i class="icon-lg la fa-trash text-danger"></i></button>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="separator separator-dashed my-5"></div>
            <h4 class="text-dark font-weight-bold mb-10">Danh s??ch khen th?????ng t???p th???</h4>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <button type="button" data-target="#modal-create-tapthe" data-toggle="modal"
                            class="btn btn-success btn-xs">
                            <i class="fa fa-plus"></i>&nbsp;Th??m</button>
                    </div>
                </div>
            </div>

            <div class="row" id="dskhenthuongtapthe">
                <div class="col-md-12">
                    <table id="sample_4" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr class="text-center">
                                <th width="5%">STT</th>
                                <th>T??n ?????i t?????ng</th>
                                <th width="30%">H??nh th???c<br>khen th?????ng</th>
                                <th width="15%">Thao t??c</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            @foreach ($model_tapthe as $key => $tt)
                                <tr class="odd gradeX">
                                    <td class="text-center">{{ $i++ }}</td>
                                    <td>{{ $tt->tentapthe }}</td>
                                    <td class="text-center">{{ $a_hinhthuckt[$tt->mahinhthuckt] ?? '' }}</td>
                                    <td class="text-center">
                                        <button title="Ti??u chu???n" type="button"
                                            onclick="getTieuChuan('{{ $tt->matapthe }}','{{ $tt->tentapthe }}')"
                                            class="btn btn-sm btn-clean btn-icon" data-target="#modal-tieuchuan"
                                            data-toggle="modal">
                                            <i class="icon-lg la fa-list text-primary"></i></button>

                                        <button title="S???a th??ng tin" type="button"
                                            onclick="getTapThe('{{ $tt->id }}')"
                                            class="btn btn-sm btn-clean btn-icon" data-target="#modal-create-tapthe"
                                            data-toggle="modal">
                                            <i class="icon-lg la fa-edit text-primary"></i></button>
                                        <button title="X??a" type="button"
                                            onclick="delKhenThuong('{{ $tt->id }}', 'TAPTHE')"
                                            class="btn btn-sm btn-clean btn-icon" data-target="#modal-delete-khenthuong"
                                            data-toggle="modal">
                                            <i class="icon-lg la fa-trash text-danger"></i></button>

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
                    <a href="{{ url('/HoSoThiDua/ThongTin?madonvi=' . $model->madonvi) }}" class="btn btn-danger mr-5"><i
                            class="fa fa-reply"></i>&nbsp;Quay l???i</a>

                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-check"></i>Ho??n th??nh</button>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    <!--end::Card-->

    {{-- C?? nh??n --}}
    {!! Form::open(['url' => '', 'id' => 'frm_ThemCaNhan', 'class' => 'form', 'files' => true, 'enctype' => 'multipart/form-data']) !!}
    <input type="hidden" name="madoituong" id="madoituong" />
    <div class="modal fade bs-modal-lg" id="modal-create" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Th??ng tin ?????i t?????ng</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                </div>
                <div class="modal-body" id="ttpthemmoi">
                    <div class="form-group row">
                        <div class="col-lg-11">
                            <label class="form-control-label">T??n ?????i t?????ng</label>
                            {!! Form::text('tendoituong', null, ['id' => 'tendoituong', 'class' => 'form-control']) !!}
                        </div>
                        <div class="col-lg-1">
                            <label class="control-label">Ch???n</label>
                            <button type="button" class="btn btn-default" data-target="#modal-doituong" data-toggle="modal">
                                <i class="fa fa-plus"></i></button>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-4">
                            <label class="form-control-label">Ng??y sinh</label>
                            {!! Form::input('date', 'ngaysinh', null, ['id' => 'ngaysinh', 'class' => 'form-control']) !!}
                        </div>

                        <div class="col-md-4">
                            <label class="form-control-label">Gi???i t??nh</label>
                            {!! Form::select('gioitinh', getGioiTinh(), null, ['id' => 'gioitinh', 'class' => 'form-control']) !!}
                        </div>

                        <div class="col-md-4">
                            <label class="form-control-label">Ch???c v???/Ch???c danh</label>
                            {!! Form::text('chucvu', null, ['id' => 'chucvu', 'class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-4">
                            <label class="form-control-label">L??nh ?????o ????n v???</label>
                            {!! Form::select('lanhdao', ['0' => 'Kh??ng', '1' => 'C??'], null, ['id' => 'lanhdao', 'class' => 'form-control']) !!}
                        </div>
                        <div class="col-md-4">
                            <label class="form-control-label">M?? CCVC</label>
                            {!! Form::text('maccvc', null, ['id' => 'maccvc', 'class' => 'form-control']) !!}
                        </div>

                        <div class="col-md-4">
                            <label class="control-label">H??nh th???c khen th?????ng</label>
                            {!! Form::select('mahinhthuckt', $a_hinhthuckt, null, ['id' => 'lanhdao', 'class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12">
                            <label class="form-control-label">T??n ????? t??i, s??ng ki???n</label>
                            {!! Form::text('tensangkien', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-8">
                            <label class="form-control-label">????n v??? c??ng nh???n</label>
                            {!! Form::text('donvicongnhan', null, ['class' => 'form-control']) !!}
                        </div>

                        <div class="col-md-4">
                            <label class="form-control-label">Ng??y c??ng nh???n</label>
                            {!! Form::input('date', 'thoigiancongnhan', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12">
                            <label class="form-control-label">Th??nh t??ch ?????t ???????c</label>
                            {!! Form::textarea('thanhtichdatduoc', null, ['class' => 'form-control', 'rows' => 2]) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label>T??i li???u ????nh k??m: </label>
                            {!! Form::file('filedk', null, ['id' => 'filedk', 'class' => 'form-control']) !!}
                            {{-- @if ($model->tailieukhac != '')
                                <span class="form-control" style="border-style: none">
                                    <a href="{{ url('/data/tailieukhac/' . $model->tailieukhac) }}"
                                        target="_blank">{{ $model->tailieukhac }}</a>
                                </span>
                            @endif --}}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-default">Tho??t</button>
                        <button type="button" class="btn btn-primary" onclick="ThemDoiTuong()">C???p nh???t</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>
    {!! Form::close() !!}

    {!! Form::open(['url' => '', 'id' => 'frm_ThemTapThe', 'class' => 'form', 'files' => true, 'enctype' => 'multipart/form-data']) !!}
    {{-- t???p th??? --}}
    <div class="modal fade bs-modal-lg" id="modal-create-tapthe" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Th??ng tin ?????i t?????ng</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label style="font-weight: bold">????n v???</label>
                            <select class="form-control select2me" name="matapthe" id="matapthe">
                                @foreach ($m_diaban as $diaban)
                                    <optgroup label="{{ $diaban->tendiaban }}">
                                        <?php $donvi = $m_donvi->where('madiaban', $diaban->madiaban); ?>
                                        @foreach ($donvi as $ct)
                                            <option {{ $ct->madonvi == $model->madonvi ? 'selected' : '' }}
                                                value="{{ $ct->madonvi }}">{{ $ct->tendonvi }}</option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-12">
                            <div class="col-md-4">
                                <label class="control-label">H??nh th???c khen th?????ng</label>
                                {!! Form::select('mahinhthuckt', $a_hinhthuckt, null, ['id' => 'lanhdao', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>

                    {{-- <div class="form-group row">
                        <div class="col-md-12">
                            <label class="form-control-label">T??n ????? t??i, s??ng ki???n</label>
                            {!! Form::text('tensangkien', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-8">
                            <label class="form-control-label">????n v??? c??ng nh???n</label>
                            {!! Form::text('donvicongnhan', null, ['class' => 'form-control']) !!}
                        </div>

                        <div class="col-md-4">
                            <label class="form-control-label">Ng??y c??ng nh???n</label>
                            {!! Form::input('date', 'thoigiancongnhan', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12">
                            <label class="form-control-label">Th??nh t??ch ?????t ???????c</label>
                            {!! Form::textarea('thanhtichdatduoc', null, ['class' => 'form-control', 'rows' => 2]) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label>T??i li???u ????nh k??m: </label>
                            {!! Form::file('filedk', null, ['class' => 'form-control']) !!}
                            {{-- @if ($model->tailieukhac != '')
                                <span class="form-control" style="border-style: none">
                                    <a href="{{ url('/data/tailieukhac/' . $model->tailieukhac) }}"
                                        target="_blank">{{ $model->tailieukhac }}</a>
                                </span>
                            @endif 
                        </div>
                    </div> --}}

                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-default">Tho??t</button>
                        <button type="button" class="btn btn-primary" onclick="ThemDoiTuongTapThe()">C???p nh???t</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>
    {!! Form::close() !!}
    {{-- Th??ng tin ti??u chu???n --}}
    {!! Form::open(['url' => '', 'id' => 'frm_TieuChuan', 'class' => 'form', 'files' => true, 'enctype' => 'multipart/form-data']) !!}
    <div class="modal fade bs-modal-lg" id="modal-tieuchuan" tabindex="-1" role="dialog" aria-hidden="true">
        <input type="hidden" id="madoituong" name="madoituong" />
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Th??ng tin ti??u chu???n c???a ?????i t?????ng</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form-control-label">T??n ?????i t?????ng</label>
                            {!! Form::text('tendoituong', null, ['id' => 'tendoituong', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                    <hr>
                    <div class="row" id="dstieuchuan">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Tho??t</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    {!! Form::close() !!}

    {{-- Thong tin ?????i t?????ng --}}
    <div id="modal-doituong" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <h4 id="modal-header-primary-label" class="modal-title">Th??ng tin ?????i t?????ng</h4>
                    <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">H???y thao t??c</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Thay ?????i ti??u chu???n --}}
    <div id="modal-luutieuchuan" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade">
        <input type="hidden" id="matieuchuandhtd_ltc" name="matieuchuandhtd_ltc" />
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <h4 id="modal-header-primary-label" class="modal-title">Th??ng tin ?????i t?????ng</h4>
                    <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label class="form-control-label">T??n ti??u chu???n</label>
                            {!! Form::textarea('tentieuchuandhtd_ltc', null, ['id' => 'tentieuchuandhtd_ltc', 'class' => 'form-control', 'rows' => '3']) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-3"></div>
                        <div class="col-lg-9">
                            <div class="md-checkbox">
                                <input type="checkbox" id="dieukien_ltc" name="dieukien_ltc" class="md-check">
                                <label for="dieukien_ltc">
                                    <span></span><span class="check"></span><span
                                        class="box"></span>????? ??i???u ki???n</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">H???y thao t??c</button>
                    <button type="button" class="btn btn-primary" onclick="LuuTieuChuan()">C???p nh???t</button>
                </div>
            </div>
        </div>
    </div>

    {{-- X??a khen th?????ng ca nh??n --}}
    <div class="modal fade" id="modal-delete-khenthuong" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">?????ng ?? x??a th??ng tin ?????i t?????ng?</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                </div>
                <input type="hidden" id="iddelete" name="iddelete">
                <input type="hidden" id="phanloaixoa" name="phanloaixoa">
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Tho??t</button>
                    <button type="button" class="btn btn-primary" onclick="deleteRow()">?????ng ??</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <script>
        function adddvt() {
            $('#modal-doituong').modal('hide');
        }
    </script>
@stop
