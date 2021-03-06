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
            TableManagedclass.init();
        });

        function confirmDoiTuong(id) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: '/KhenThuongCongTrang/HoSoKhenThuong/LayDoiTuong',
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
                }
            })
            $('#modal-doituong').modal("hide");
        }

        function confirmTapThe(matapthe, tentapthe) {
            var form = $('#frm_ThemTapThe');
            form.find("[name='matapthe']").val(matapthe);
            form.find("[name='tentapthe']").val(tentapthe);
            $('#modal-tapthe').modal("hide");
        }

        function getTieuChuan(madoituong, madanhhieutd, tendt) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $('#madoituong_tc').val(madoituong);
            $('#tendoituong_tc').val(tendt);
            $('#madanhhieutd_tc').val(madanhhieutd).trigger('change');

            $.ajax({
                url: '/KhenThuongCongTrang/HoSoKhenThuong/LayTieuChuan',
                type: 'GET',
                data: {
                    _token: CSRF_TOKEN,
                    madoituong: madoituong,
                    madanhhieutd: madanhhieutd,
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

        function ThayDoiTieuChuan(matieuchuandhtd, tentieuchuandhtd) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $('#tentieuchuandhtd_ltc').val(tentieuchuandhtd);
            $('#matieuchuandhtd_ltc').val(matieuchuandhtd);
        }

        function LuuTieuChuan() {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: '/KhenThuongCongTrang/HoSoKhenThuong/LuuTieuChuan',
                type: 'GET',
                data: {
                    _token: CSRF_TOKEN,
                    madoituong: $('#madoituong_tc').val(),
                    madanhhieutd: $('#madanhhieutd_tc').val(),
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
                url: '/KhenThuongCongTrang/HoSoKhenThuong/XoaDoiTuong',
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

        function setCaNhan() {
            $('#frm_ThemCaNhan').find("[name='madoituong']").val('NULL');
        }

        function setTapThe() {
            $('#frm_ThemTapThe').find("[name='matapthe']").val('NULL');
        }

        function getCaNhan(id) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: '/KhenThuongCongTrang/HoSoKhenThuong/LayDoiTuong',
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
                    form.find("[name='madanhhieutd']").val(data.madanhhieutd).trigger('change');;
                    form.find("[name='tensangkien']").val(data.tensangkien);
                    form.find("[name='donvicongnhan']").val(data.donvicongnhan);
                    form.find("[name='thoigiancongnhan']").val(data.thoigiancongnhan);
                    form.find("[name='thanhtichdatduoc']").val(data.thanhtichdatduoc);
                    if (data.filedk != null && data.filedk != '') {
                        document.getElementById('filedk_canhan').style.visibility = "visible";
                        $('#filedk_canhan').attr("href", "/data/sangkien/" + data.filedk);
                    } else
                        document.getElementById('filedk_canhan').style.visibility = "hidden";

                    //filedk: form.find("[name='filedk']").val(data.madoituong),
                }
            })
        }

        function getTapThe(id) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: '/KhenThuongCongTrang/HoSoKhenThuong/LayDoiTuong',
                type: 'GET',
                data: {
                    _token: CSRF_TOKEN,
                    id: id,
                },
                dataType: 'JSON',
                success: function(data) {
                    var form = $('#frm_ThemTapThe');
                    form.find("[name='matapthe']").val(data.matapthe);
                    form.find("[name='madanhhieutd']").val(data.madanhhieutd).trigger('change');
                    form.find("[name='mahinhthuckt']").val(data.mahinhthuckt).trigger('change');
                    form.find("[name='tentapthe']").val(data.tentapthe);
                    //filedk: form.find("[name='filedk']").val(data.madoituong),
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
                <h3 class="card-label text-uppercase">Th??ng tin h??? s?? ????? ngh??? khen th?????ng theo c??ng tr???ng v?? th??nh t??ch</h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                <!--end::Button-->
            </div>
        </div>

        {!! Form::model($model, ['method' => 'POST', 'url' => '/KhenThuongCongTrang/HoSoKhenThuong/Sua', 'class' => 'form', 'id' => 'frm_ThayDoi', 'files' => true, 'enctype' => 'multipart/form-data']) !!}
        {{ Form::hidden('madonvi', null, ['id' => 'madonvi']) }}
        {{ Form::hidden('mahosotdkt', null, ['id' => 'mahosotdkt']) }}
        <div class="card-body">
            <h4 class="text-dark font-weight-bold mb-5">Th??ng tin chung</h4>
            <div class="form-group row">
                <div class="col-lg-6">
                    <label>T??n ????n v???</label>
                    {!! Form::text('tendonvi', null, ['class' => 'form-control', 'readonly' => 'true']) !!}
                </div>

                <div class="col-lg-6">
                    <label>Lo???i h??nh khen th?????ng</label>
                    {!! Form::select('maloaihinhkt', $a_loaihinhkt, null, ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-6">
                    <label>S??? t??? tr??nh</label>
                    {!! Form::text('sototrinh', null, ['class' => 'form-control']) !!}
                </div>
                <div class="col-lg-6">
                    <label>Ng??y th??ng tr??nh<span class="require">*</span></label>
                    {!! Form::input('date', 'ngayhoso', null, ['class' => 'form-control', 'required']) !!}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-6">
                    <label>Ch???c v??? ng?????i k?? t??? tr??nh</label>
                    {!! Form::text('chucvunguoiky', null, ['class' => 'form-control']) !!}
                </div>
                <div class="col-lg-6">
                    <label>H??? t??n ng?????i k?? t??? tr??nh</label>
                    {!! Form::text('nguoikytotrinh', null, ['class' => 'form-control']) !!}
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
                    @if ($model->baocao != '')
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

            <div class="form-group row">
                <div class="col-lg-8">
                    <h4 class="text-dark font-weight-bold mb-5">Danh s??ch khen th?????ng c?? nh??n</h4>
                </div>
                <div class="col-lg-4 text-right">
                    <div class="btn-group" role="group">
                        <button title="Th??m ?????i t?????ng" type="button" data-target="#modal-create" data-toggle="modal"
                            class="btn btn-success btn-sm" onclick="setCaNhan()">
                            <i class="fa fa-plus"></i></button>
                        <button title="Nh???n t??? file Excel" data-target="#modal-nhanexcel" data-toggle="modal" type="button"
                            class="btn btn-secondary btn-sm"><i class="fa flaticon-list"></i></button></button>
                        <a target="_blank" title="T???i file m???u" href="/data/download/CANHAN.xlsx"
                            class="btn btn-primary btn-sm"><i class="fa flaticon-download"></i></button></a>
                    </div>
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
                                <th>Gi???i</br>t??nh</th>
                                <th>Ch???c v???</th>
                                <th>H??nh th???c<br>khen th?????ng</th>
                                <th width="15%">Thao t??c</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            @foreach ($model_canhan as $key => $tt)
                                <tr class="odd gradeX">
                                    <td class="text-center">{{ $i++ }}</td>
                                    <td>{{ $tt->tendoituong }}</td>
                                    <td>{{ getDayVn($tt->ngaysinh) }}</td>
                                    <td>{{ $tt->gioitinh }}</td>
                                    <td class="text-center">{{ $tt->chucvu }}</td>
                                    <td class="text-center">{{ $a_hinhthuckt[$tt->mahinhthuckt] ?? '' }}</td>
                                    <td class="text-center">
                                        {{-- <button title="Ti??u chu???n" type="button"
                                            onclick="getTieuChuan('{{ $tt->madoituong }}','{{ $tt->madanhhieutd }}','{{ $tt->tendoituong }}')"
                                            class="btn btn-sm btn-clean btn-icon" data-target="#modal-tieuchuan"
                                            data-toggle="modal">
                                            <i class="icon-lg la fa-list text-primary"></i></button> --}}

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
            <div class="form-group row">
                <div class="col-lg-8">
                    <h4 class="text-dark font-weight-bold mb-5">Danh s??ch khen th?????ng t???p th???</h4>
                </div>
                <div class="col-lg-4 text-right">
                    <div class="btn-group" role="group">
                        <div class="form-group">
                            <button type="button" onclick="setTapThe()" data-target="#modal-create-tapthe" data-toggle="modal"
                                class="btn btn-success btn-xs">
                                <i class="fa fa-plus"></i></button>
                        </div>
                        {{-- <button title="Nh???n t??? file Excel" data-target="#modal-nhanexcel" data-toggle="modal" type="button"
                            class="btn btn-secondary btn-sm"><i class="fa flaticon-list"></i></button></button>
                        <a target="_blank" title="T???i file m???u" href="/data/download/CANHAN.xlsx"
                            class="btn btn-primary btn-sm"><i class="fa flaticon-download"></i></button></a> --}}
                    </div>
                </div>
            </div>

            {{-- <h4 class="text-dark font-weight-bold mb-10">Danh s??ch khen th?????ng t???p th???</h4>


            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <button type="button" onclick="setTapThe()" data-target="#modal-create-tapthe" data-toggle="modal"
                            class="btn btn-success btn-xs">
                            <i class="fa fa-plus"></i>&nbsp;Th??m</button>
                    </div>
                </div>
            </div> --}}

            <div class="row" id="dskhenthuongtapthe">
                <div class="col-md-12">
                    <table id="sample_4" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr class="text-center">
                                <th width="5%">STT</th>
                                <th>T??n ?????i t?????ng</th>
                                <th>H??nh th???c<br>khen th?????ng</th>
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
                                        {{-- <button title="Ti??u chu???n" type="button"
                                            onclick="getTieuChuan('{{ $tt->matapthe }}','{{ $tt->madanhhieutd }}','{{ $tt->tentapthe }}')"
                                            class="btn btn-sm btn-clean btn-icon" data-target="#modal-tieuchuan"
                                            data-toggle="modal">
                                            <i class="icon-lg la fa-list text-primary"></i></button> --}}

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
                    <a href="{{ url('/KhenThuongCongTrang/HoSoKhenThuong/ThongTin?madonvi=' . $model->madonvi) }}"
                        class="btn btn-danger mr-5"><i class="fa fa-reply"></i>&nbsp;Quay l???i</a>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>Ho??n th??nh</button>

                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    <!--end::Card-->

    {{-- C?? nh??n --}}
    {!! Form::open(['url' => '/KhenThuongCongTrang/HoSoKhenThuong/CaNhan', 'id' => 'frm_ThemCaNhan', 'class' => 'form', 'files' => true, 'enctype' => 'multipart/form-data']) !!}
    <input type="hidden" name="madoituong" id="madoituong" />
    <input type="hidden" name="mahosotdkt" value="{{ $model->mahosotdkt }}" />
    <div class="modal fade bs-modal-lg" id="modal-create" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Th??m m???i th??ng tin ?????i t?????ng</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                </div>
                <div class="modal-body" id="ttpthemmoi">
                    <div class="form-group row">
                        <div class="col-lg-5">
                            <label class="form-control-label">T??n ?????i t?????ng</label>
                            {!! Form::text('tendoituong', null, ['id' => 'tendoituong', 'class' => 'form-control']) !!}
                        </div>
                        <div class="col-lg-1">
                            <label class="text-center">Ch???n</label>
                            <button type="button" class="btn btn-default" data-target="#modal-doituong" data-toggle="modal">
                                <i class="fa fa-plus"></i></button>
                        </div>
                        <div class="col-md-3">
                            <label class="form-control-label">Ng??y sinh</label>
                            {!! Form::input('date', 'ngaysinh', null, ['id' => 'ngaysinh', 'class' => 'form-control']) !!}
                        </div>

                        <div class="col-md-3">
                            <label class="form-control-label">Gi???i t??nh</label>
                            {!! Form::select('gioitinh', getGioiTinh(), null, ['id' => 'gioitinh', 'class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-4">
                            <label class="form-control-label">Ch???c v???/Ch???c danh</label>
                            {!! Form::text('chucvu', null, ['id' => 'chucvu', 'class' => 'form-control']) !!}
                        </div>

                        <div class="col-md-4">
                            <label class="form-control-label">L??nh ?????o ????n v???</label>
                            {!! Form::select('lanhdao', ['0' => 'Kh??ng', '1' => 'C??'], null, ['id' => 'lanhdao', 'class' => 'form-control']) !!}
                        </div>
                        <div class="col-md-4">
                            <label class="form-control-label">M?? CCVC</label>
                            {!! Form::text('maccvc', null, ['id' => 'maccvc', 'class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
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
                            <span class="form-control" style="border-style: none;visibility: hidden;">
                                <a id="filedk_canhan" href="" target="_blank">T???i file</a>
                            </span>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Tho??t</button>
                    <button type="submit" class="btn btn-primary">Ho??n th??nh</button>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>
    {!! Form::close() !!}

    {{-- t???p th??? --}}
    {!! Form::open(['url' => '/KhenThuongCongTrang/HoSoKhenThuong/TapThe', 'id' => 'frm_ThemTapThe', 'class' => 'form', 'files' => true, 'enctype' => 'multipart/form-data']) !!}
    <input type="hidden" name="mahosotdkt" value="{{ $model->mahosotdkt }}" />
    <input type="hidden" name="matapthe" />
    <div class="modal fade bs-modal-lg" id="modal-create-tapthe" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Th??m m???i th??ng tin ?????i t?????ng</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-md-11">
                            <label class="form-control-label">T??n t???p th???</label>
                            {!! Form::text('tentapthe', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-lg-1">
                            <label class="text-center">Ch???n</label>
                            <button type="button" class="btn btn-default" data-target="#modal-tapthe" data-toggle="modal">
                                <i class="fa fa-plus"></i></button>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12">
                            <label class="control-label">Danh hi???u thi ??ua</label>
                            <select name="madanhhieutd" class="form-control">
                                <option value="null">Kh??ng ????ng k??</option>
                                @foreach ($m_danhhieu->where('phanloai', 'TAPTHE') as $nhom)
                                    <option value="{{ $nhom->madanhhieutd }}">{{ $nhom->tendanhhieutd }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12">
                            <label class="control-label">H??nh th???c khen th?????ng</label>
                            {!! Form::select('mahinhthuckt', $a_hinhthuckt, null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Tho??t</button>
                    <button type="submit" class="btn btn-primary">Ho??n th??nh</button>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>
    {!! Form::close() !!}

    {{-- Th??ng tin ti??u chu???n --}}
    <div class="modal fade bs-modal-lg" id="modal-tieuchuan" tabindex="-1" role="dialog" aria-hidden="true">
        <input type="hidden" id="madoituong_tc" name="madoituong_tc" />
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Th??ng tin ti??u chu???n c???a ?????i t?????ng</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-control-label">T??n ?????i t?????ng</label>
                            {!! Form::text('tendoituong_tc', null, ['id' => 'tendoituong_tc', 'class' => 'form-control']) !!}
                        </div>

                        <div class="col-md-6">
                            <label class="form-control-label">Danh hi???u ????ng k??</label>
                            {!! Form::select('madanhhieutd_tc', $a_danhhieu, null, ['id' => 'madanhhieutd_tc', 'class' => 'form-control']) !!}
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

    {{-- Thong tin ?????i t?????ng --}}
    <div id="modal-doituong" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <h4 id="modal-header-primary-label" class="modal-title">Th??ng tin ?????i t?????ng</h4>
                    <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped table-bordered table-hover dulieubang">
                                <thead>
                                    <tr class="text-center">
                                        <th width="10%">STT</th>
                                        <th>????n v??? c??ng t??c</th>
                                        <th>T??n ?????i t?????ng</th>
                                        <th>Ch???c v???</th>
                                        <th width="10%">Thao t??c</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($m_canhan as $key => $tt)
                                        <tr class="odd gradeX">
                                            <td class="text-center">{{ $i++ }}</td>
                                            <td>{{ $tt->tendonvi }}</td>
                                            <td>{{ $tt->tendoituong }}</td>
                                            <td>{{ $tt->chucvu }}</td>
                                            <td class="text-center">
                                                <button title="Ch???n ?????i t?????ng" type="button"
                                                    onclick="confirmDoiTuong('{{ $tt->id }}')"
                                                    class="btn btn-sm btn-clean btn-icon" data-toggle="modal">
                                                    <i class="icon-lg la fa-check text-success"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">H???y thao t??c</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Th??ng tin ?????i t?????ng l?? t??? th??? --}}
    <div id="modal-tapthe" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <h4 id="modal-header-primary-label" class="modal-title">Th??ng tin ?????i t?????ng</h4>
                    <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped table-bordered table-hover dulieubang">
                                <thead>
                                    <tr class="text-center">
                                        <th width="10%">STT</th>
                                        <th>T??n ????n v???</th>
                                        <th width="10%">Thao t??c</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($m_tapthe as $key => $tt)
                                        <tr class="odd gradeX">
                                            <td class="text-center">{{ $i++ }}</td>
                                            <td>{{ $tt->tentapthe }}</td>
                                            <td class="text-center">
                                                <button title="Ch???n ?????i t?????ng" type="button"
                                                    onclick="confirmTapThe('{{ $tt->matapthe }}','{{ $tt->tentapthe }}')"
                                                    class="btn btn-sm btn-clean btn-icon" data-toggle="modal">
                                                    <i class="icon-lg la fa-check text-success"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
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
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-control-label">T??n ti??u chu???n</label>
                                {!! Form::textarea('tentieuchuandhtd_ltc', null, ['id' => 'tentieuchuandhtd_ltc', 'class' => 'form-control', 'rows' => '3']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-offset-4 col-md-3">
                                <div class="md-checkbox">
                                    <input type="checkbox" id="dieukien_ltc" name="dieukien_ltc" class="md-check">
                                    <label for="dieukien_ltc">
                                        <span></span><span class="check"></span><span
                                            class="box"></span>????? ??i???u ki???n</label>
                                </div>
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
    {!! Form::open(['url' => '/KhenThuongCongTrang/HoSoKhenThuong/XoaDoiTuong', 'id' => 'frm_ThemTapThe', 'class' => 'form', 'files' => true, 'enctype' => 'multipart/form-data']) !!}
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
                    <button type="submit" class="btn btn-primary">?????ng ??</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    {!! Form::close() !!}

    {{-- C?? nh??n t??? file Excel --}}
    {!! Form::open(['url' => '/KhenThuongCongTrang/HoSoKhenThuong/NhanExcel', 'id' => 'frm_NhanExcel', 'class' => 'form', 'files' => true, 'enctype' => 'multipart/form-data']) !!}
    <input type="hidden" name="mahosotdkt" value="{{ $model->mahosotdkt }}" />
    <div class="modal fade bs-modal-lg" id="modal-nhanexcel" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Th??ng tin chi ti???t</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                </div>
                <div class="modal-body" id="ttpthemmoi">
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label class="control-label">T??n ?????i t?????ng</label>
                            {!! Form::text('tendoituong', 'B', ['class' => 'form-control']) !!}
                        </div>

                        <div class="col-md-4">
                            <label class="form-control-label">Gi???i t??nh</label>
                            {!! Form::text('gioitinh', 'C', ['class' => 'form-control']) !!}
                        </div>

                        <div class="col-md-4">
                            <label class="form-control-label">Ng??y sinh</label>
                            {!! Form::text('ngaysinh', 'D', ['class' => 'form-control']) !!}
                        </div>

                    </div>

                    <div class="form-group row">
                        <div class="col-md-4">
                            <label class="form-control-label">L??nh ?????o ????n v???</label>
                            {!! Form::text('lanhdao', 'E', ['class' => 'form-control']) !!}
                        </div>

                        <div class="col-md-4">
                            <label class="form-control-label">Ch???c v???/Ch???c danh</label>
                            {!! Form::text('chucvu', 'F', ['class' => 'form-control']) !!}
                        </div>

                        <div class="col-md-4">
                            <label class="control-label">H??nh th???c khen th?????ng</label>
                            {!! Form::text('mahinhthuckt', 'G', ['id' => 'lanhdao', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3">
                            <label class="control-label">Nh???n t??? d??ng<span class="require">*</span></label>
                            {!! Form::text('tudong', '4', ['class' => 'form-control']) !!}
                            {{-- {!! Form::text('tudong', '4', ['class' => 'form-control', 'required', 'data-mask' => 'fdecimal']) !!} --}}
                        </div>

                        <div class="col-md-3">
                            <label class="control-label">Nh???n ?????n d??ng</label>
                            {!! Form::text('dendong', '200', ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label>File danh s??ch: </label>
                            {!! Form::file('fexcel', null, ['class' => 'form-control', 'required']) !!}
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Tho??t</button>
                    <button type="submit" class="btn btn-primary">Ho??n th??nh</button>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>
    {!! Form::close() !!}


    <script>
        function adddvt() {
            $('#modal-doituong').modal('hide');
        }
    </script>
@stop
