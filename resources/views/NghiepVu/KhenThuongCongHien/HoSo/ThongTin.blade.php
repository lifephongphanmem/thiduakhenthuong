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
                window.location.href = '{{ $inputs['url'] }}' + 'ThongTin?madonvi=' + $(
                    '#madonvi').val() + '&nam=' + $('#nam').val();
            });

            $('#nam').change(function() {
                window.location.href = '{{ $inputs['url'] }}' + 'ThongTin?madonvi=' + $(
                    '#madonvi').val() + '&nam=' + $('#nam').val();
            });
        });
    </script>
@stop

@section('content')
    <!--begin::Card-->
    <div class="card card-custom wave wave-animate-slow wave-info" style="min-height: 600px">
        <div class="card-header flex-wrap border-1 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Danh sách hồ sơ trình khen thưởng theo cống hiến</h3>
            </div>
            <div class="card-toolbar">
                @if (chkPhanQuyen('dshosokhenthuongconghien', 'modify'))
                    <button type="button" class="btn btn-success btn-xs" data-target="#taohoso-modal" data-toggle="modal">
                        <i class="fa fa-plus"></i>&nbsp;Thêm mới</button>
                @endif
            </div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <div class="col-lg-9">
                    <label style="font-weight: bold">Đơn vị</label>
                    <select class="form-control select2basic" id="madonvi">
                        @foreach ($m_diaban as $diaban)
                            <optgroup label="{{ $diaban->tendiaban }}">
                                <?php $donvi = $m_donvi->where('madiaban', $diaban->madiaban); ?>
                                @foreach ($donvi as $ct)
                                    <option {{ $ct->madonvi == $inputs['madonvi'] ? 'selected' : '' }}
                                        value="{{ $ct->madonvi }}">{{ $ct->tendonvi }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-3">
                    <label style="font-weight: bold">Năm</label>
                    {!! Form::select('nam', getNam(true), $inputs['nam'], ['id' => 'nam', 'class' => 'form-control select2basic']) !!}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-12">
                    <table class="table table-striped table-bordered table-hover" id="sample_3">
                        <thead>
                            <tr class="text-center">
                                <th width="2%">STT</th>
                                <th>Nội dung hồ sơ</th>
                                <th width="8%">Tờ trình</th>
                                <th width="8%">Trạng thái</th>
                                <th width="20%">Đơn vị tiếp nhận</th>
                                <th width="10%">Thao tác</th>
                            </tr>
                        </thead>

                        @foreach ($model as $key => $tt)
                            <tr>
                                <td class="text-center">{{ $key + 1 }}</td>
                                <td>{{ $tt->noidung }}</td>
                                <td class="text-center">{{ $tt->sototrinh }}<br>{{ getDayVn($tt->ngayhoso) }}
                                </td>
                                @include('includes.td.td_trangthai_hoso')
                                <td>{{ $a_donvi[$tt->madonvi_nhan] ?? '' }}</td>

                                <td style="text-align: center">
                                    @if (in_array($tt->trangthai, ['CC', 'BTL', 'CXD']))
                                        <a title="Thông tin hồ sơ"
                                            href="{{ url($inputs['url'] . 'Sua?mahosotdkt=' . $tt->mahosotdkt) }}"
                                            class="btn btn-sm btn-clean btn-icon">
                                            <i class="icon-lg la fa-check-square text-primary icon-2x"></i></a>

                                        <button title="Trình hồ sơ đăng ký" type="button"
                                            onclick="confirmChuyen('{{ $tt->mahosotdkt }}','{{ $inputs['url'] . 'ChuyenHoSo' }}')"
                                            class="btn btn-sm btn-clean btn-icon" data-target="#chuyen-modal-confirm"
                                            data-toggle="modal">
                                            <i class="icon-lg la fa-share text-primary icon-2x"></i></button>

                                        <button type="button"
                                            onclick="confirmDelete('{{ $tt->id }}','{{ $inputs['url'] . 'Xoa' }}')"
                                            class="btn btn-sm btn-clean btn-icon" data-target="#delete-modal-confirm"
                                            data-toggle="modal">
                                            <i class="icon-lg la fa-trash text-danger icon-2x"></i></button>
                                    @else
                                        <a title="Xem thông tin hồ sơ"
                                            href="{{ url($inputs['url'] . 'Xem?mahosotdkt=' . $tt->mahosotdkt) }}"
                                            class="btn btn-sm btn-clean btn-icon" target="_blank">
                                            <i class="icon-lg la fa-eye text-dark icon-2x"></i></a>

                                        @if ($tt->trangthai == 'DKT')
                                            <button type="button" title="In quyết định khen thưởng"
                                                onclick="setInDuLieu('{{ $tt->mahosotdkt }}')"
                                                class="btn btn-sm btn-clean btn-icon" data-target="#indulieu-modal"
                                                data-toggle="modal">
                                                <i class="icon-lg la flaticon2-print text-dark icon-2x"></i>
                                            </button>
                                        @endif
                                    @endif

                                    @if ($tt->trangthai == 'BTL')
                                        <button title="Lý do hồ sơ bị trả lại" type="button"
                                            onclick="viewLyDo('{{ $tt->mahosotdkt }}','{{ $inputs['madonvi'] }}', '{{ $inputs['url'] . 'LayLyDo' }}')"
                                            class="btn btn-sm btn-clean btn-icon" data-target="#tralai-modal"
                                            data-toggle="modal">
                                            <i class="icon-lg la fa-archive text-info icon-2x"></i></button>
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

    <!--Modal Tạo hồ sơ-->
    {!! Form::open(['url' => $inputs['url'] . 'Them', 'id' => 'frm_hoso']) !!}
    <input type="hidden" name="madonvi" value="{{ $inputs['madonvi'] }}" />
    <div id="taohoso-modal" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade kt_select2_modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <h4 id="modal-header-primary-label" class="modal-title">Đồng ý tạo hồ sơ trình khen thưởng?</h4>
                    <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label>Loại hình khen thưởng</label>
                            {!! Form::select('maloaihinhkt', $a_loaihinhkt, $inputs['maloaihinhkt'], ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label>Số tờ trình</label>
                            {!! Form::text('sototrinh', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-lg-6">
                            <label>Ngày tạo hồ sơ</label>
                            {!! Form::input('date', 'ngayhoso', date('Y-m-d'), ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label>Chức vụ người ký tờ trình</label>
                            {!! Form::text('chucvunguoiky', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-lg-6">
                            <label>Họ tên người ký tờ trình</label>
                            {!! Form::text('nguoikytotrinh', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label>Nội dung trình khen thưởng</label>
                            {!! Form::textarea('noidung', null, ['class' => 'form-control', 'rows' => 3]) !!}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
                    <button type="submit" class="btn btn-primary">Đồng ý</button>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}

    {{-- In dữ liệu --}}
    <div id="indulieu-modal" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade">
        {!! Form::open(['url' => '', 'id' => 'frm_InDuLieu']) !!}
        <input type="hidden" name="madonvi" value="{{ $inputs['madonvi'] }}" />
        <input type="hidden" name="mahosotdkt" />
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <h4 id="modal-header-primary-label" class="modal-title">Thông tin in dữ liệu</h4>
                    <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <a onclick="setInQD($(this), '{{ url($inputs['url_kt']) }}')"
                                class="btn btn-sm btn-clean text-dark font-weight-bold" target="_blank">
                                <i class="la flaticon2-print"></i>Quyết định khen thưởng
                            </a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <button type="button"
                                onclick="setInPhoi('{{ $inputs['url_kt'] . 'InBangKhen' }}', 'TAPTHE')"
                                class="btn btn-sm btn-clean text-dark font-weight-bold" data-target="#modal-InPhoi"
                                data-toggle="modal">
                                <i class="la flaticon2-print"></i>In phôi bằng khen(Tập thể)
                            </button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <button type="button"
                                onclick="setInPhoi('{{ $inputs['url_kt'] . 'InBangKhen' }}', 'CANHAN')"
                                class="btn btn-sm btn-clean text-dark font-weight-bold" data-target="#modal-InPhoi"
                                data-toggle="modal">
                                <i class="la flaticon2-print"></i>In phôi bằng khen(Cá nhân)
                            </button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <button type="button"
                                onclick="setInPhoi('{{ $inputs['url_kt'] . 'InGiayKhen' }}', 'TAPTHE')"
                                class="btn btn-sm btn-clean text-dark font-weight-bold" data-target="#modal-InPhoi"
                                data-toggle="modal">
                                <i class="la flaticon2-print"></i>In phôi giấy khen(Tập thể)
                            </button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <button type="button"
                                onclick="setInPhoi('{{ $inputs['url_kt'] . 'InGiayKhen' }}', 'CANHAN')"
                                class="btn btn-sm btn-clean text-dark font-weight-bold" data-target="#modal-InPhoi"
                                data-toggle="modal">
                                <i class="la flaticon2-print"></i>In phôi giấy khen(Cá nhân)
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Đóng</button>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>

    {!! Form::open(['url' => '', 'id' => 'frm_InPhoi', 'target' => '_blank']) !!}
    <div id="modal-InPhoi" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade kt_select2_modal">
        <input type="hidden" name="mahosotdkt" />
        <input type="hidden" name="phanloai" />
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <h4 id="modal-header-primary-label" class="modal-title">Thông tin in dữ liệu</h4>
                    <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                </div>
                <div class="modal-body">
                    <div id="doituonginphoi" class="row">
                        <div class="col-lg-12">
                            <label class="form-control-label">Tên đối tượng</label>
                            {!! Form::select('tendoituong', setArrayAll([], 'Tất cả'), null, ['class' => 'form-control select2_modal']) !!}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Đóng</button>
                    <button type="submit" class="btn btn-success">Hoàn thành</button>
                </div>
            </div>
        </div>

    </div>
    {!! Form::close() !!}

    <script>
        function setInDuLieu(mahosotdkt) {
            $('#frm_InDuLieu').find("[name='mahosotdkt']").val(mahosotdkt);
        }

        function setInQD(e, url) {
            e.prop('href', url + '/InQuyetDinh?mahosotdkt=' + $('#frm_InDuLieu').find("[name='mahosotdkt']").val());
        }

        function setInPhoi(url, phanloai) {
            $('#frm_InPhoi').attr('action', url);
            $('#frm_InPhoi').find("[name='mahosotdkt']").val($('#frm_InDuLieu').find("[name='mahosotdkt']").val());
            $('#frm_InPhoi').find("[name='phanloai']").val(phanloai);
            var formData = new FormData($('#frm_InPhoi')[0]);
            $.ajax({
                url: "{{ $inputs['url_kt'] }}" + "LayDoiTuong",
                method: "POST",
                cache: false,
                dataType: false,
                processData: false,
                contentType: false,
                data: formData,
                success: function(data) {
                    //console.log(data);               
                    if (data.status == 'success') {
                        $('#doituonginphoi').replaceWith(data.message);
                    }
                }
            });
        }
    </script>

    @include('includes.modal.modal-lydo')
    @include('includes.modal.modal-delete')
    @include('includes.modal.modal_approve_hs')
@stop
