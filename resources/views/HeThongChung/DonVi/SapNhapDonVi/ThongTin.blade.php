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
            $('#madonvi').change(function() {
                window.location.href = "{{ $inputs['url_hs'] }}" + "ThongTin?madonvi=" + $(
                    '#madonvi').val();
            });

            function add() {
                $('#madm').val('');
                $('#madm').attr('readonly', true);
            }

            function edit(madm, tendm, phanloai, ghichu) {
                $('#madm').attr('readonly', false);
                $('#madm').val(madm);
                $('#tendm').val(tendm);
                $('#phanloai').val(phanloai).trigger('change');
                $('#ghichu').val(ghichu);
            }
        });
    </script>
@stop

@section('content')
    <!--begin::Card-->
    <div class="card card-custom wave wave-animate-slow wave-info" style="min-height: 600px">
        <div class="card-header flex-wrap border-1 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Danh sách đơn vị sáp nhập</h3>
            </div>
            <div class="card-toolbar">
                {{-- @if (chkPhanQuyen('dshosokhenthuongconghien', 'thaydoi')) --}}
                <button type="button" onclick="add()" class="btn btn-success btn-xs" data-target="#sapnhap-modal"
                    data-toggle="modal">
                    <i class="fa fa-plus"></i>&nbsp;Thêm mới
                </button>
                {{-- @endif --}}
            </div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <div class="col-5">
                    <label style="font-weight: bold">Đơn vị</label>
                    <select class="form-control select2basic" id="madonvi">
                        @foreach ($a_diaban as $key => $val)
                            <optgroup label="{{ $val }}">
                                <?php $donvi = $m_donvi->where('madiaban', $key); ?>
                                @foreach ($donvi as $ct)
                                    <option {{ $ct->madonvi == $inputs['madonvi'] ? 'selected' : '' }}
                                        value="{{ $ct->madonvi }}">{{ $ct->tendonvi }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-12">
                    <table class="table table-striped table-bordered table-hover" id="sample_3">
                        <thead>
                            <tr class="text-center">
                                <th width="2%">STT</th>
                                <th>Đơn vị</th>
                                <th>Nội dung</th>
                                <th width="10%">Thời gian</th>
                                <th width="15%">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            @foreach ($model as $ct)
                                <tr>

                                    <td>{{ $i++ }}</td>
                                    <td>{{ $a_donvi[$ct->madonvi_bisapnhap] ?? '' }}</td>
                                    <td>{{ $ct->ghichu }}</td>
                                    <td>{{ getDayVn($ct->ngaysapnhap) }}</td>
                                    <td class="text-center">
                                        <button title="Xóa thông tin" type="button" onclick="confirmDelete('{{ $ct->id }}','{{ $inputs['url_hs'] . 'Xoa' }}')"
                                            class="btn btn-sm btn-clean btn-icon" data-target="#delete-modal-confirm"
                                            data-toggle="modal">
                                            <i class="icon-lg la fa-trash-alt text-danger"></i></button>
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
    <!--begin modal::Thêm mới-->
    {!! Form::open(['url' => $inputs['url_hs'] . 'Them', 'id' => 'frm_them', 'files' => true]) !!}
    <input type="hidden" name="madonvi" value="{{ $inputs['madonvi'] }}" />
    <div id="sapnhap-modal" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade kt_select2_modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <h4 id="modal-header-primary-label" class="modal-title">Đồng ý sáp nhập đơn vị ?</h4>
                    <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-4">
                            <label>Phân loại</label>
                            <select name="phanloai" id="" class="form-control select2basic" style="width:100%">
                                <option value="0">Sáp nhập tạo đơn vị mới</option>
                                <option value="1">Sáp nhập vào đơn vị hiện tại</option>
                            </select>
                        </div>

                        <div class="col-8">
                            <label>Đơn vị sáp nhập</label>
                            {!! Form::select('madonvi_bisapnhap[]', $a_donvi_sapnhap, null, [
                                'class' => 'form-control select2basic',
                                'style' => 'width:100%',
                                'multiple' => true,
                            ]) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-6">
                            <label>Khóa đơn vị bị sáp nhập</label>
                            {!! Form::select('khoadonvi', ['1' => 'Khóa', '0' => 'Giữ nguyên'], null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-6">
                            <label>Ngày sáp nhập</label>
                            {!! Form::input('date', 'ngaysapnhap', date('Y-m-d'), ['class' => 'form-control']) !!}
                        </div>

                    </div>

                    <div class="form-group row">
                        <div class="col-12">
                            <label>Ghi chú</label>
                            {!! Form::textarea('noidung', null, ['class' => 'form-control', 'rows' => 2]) !!}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
                    <button type="submit" onclick="chkThongTinHoSo()" class="btn btn-primary">Đồng ý</button>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
    <!--End modal::Thêm mới-->

    <script>
        function chkThongTinHoSo() {
            $("#frm_them").unbind('submit').submit();
        }
    </script>
@stop
