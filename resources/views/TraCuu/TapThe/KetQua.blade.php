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
            TableManagedclass.init();
        });
    </script>
@stop

@section('content')
    <!--begin::Card-->

    <div class="card card-custom" style="min-height: 600px">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Thông tin kết quả tìm kiếm</h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                <button type="button" title="In quyết định khen thưởng" onclick="setInDuLieu()"
                    class="btn btn-sm btn-clean btn-icon" data-target="#indulieu-modal" data-toggle="modal">
                    <i class="icon-lg la flaticon2-print text-dark icon-2x"></i>
                </button>
                <!--end::Button-->
            </div>
        </div>

        <div class="card-body">
            <h4 class="text-dark font-weight-bold mb-10">Danh sách khen thưởng</h4>
            <div class="row" id="dskhenthuong">
                <div class="col-md-12">
                    <table class="table table-striped table-bordered table-hover dulieubang">
                        <thead>
                            <tr class="text-center">
                                <th rowspan="2" width="5%">STT</th>
                                <th colspan="3">Quyết định</th>
                                <th colspan="2">Tờ trình</th>
                                <th rowspan="2">Tên cơ quan, tập thể</th>
                                <th rowspan="2">Phân loại cơ quan, tập thể</th>
                                <th rowspan="2">Loại hình khen thưởng</th>
                                <th rowspan="2">Danh hiệu thi đua</br>/Hình thức khen thưởng</th>

                            </tr>
                            <tr class="text-center">
                                <th>Số QĐ</th>
                                <th>Ngày tháng</th>
                                <th>Cấp độ</th>
                                <th>Số TT</th>
                                <th>Ngày tháng</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            @foreach ($model_khenthuong as $key => $tt)
                                <tr class="odd gradeX">
                                    <td class="text-center">{{ $i++ }}</td>
                                    <td class="text-center">{{ $tt->soqd }}</td>
                                    <td class="text-center">{{ getDayVn($tt->ngayqd) }}</td>
                                    <td class="text-center">{{ $phamvi[$tt->capkhenthuong] ?? $tt->capkhenthuong }}</td>
                                    <td class="text-center">{{ $tt->sototrinh }}</td>
                                    <td class="text-center">{{ getDayVn($tt->ngayhoso) }}</td>
                                    <td>{{ $tt->tentapthe }}</td>
                                    <td>{{ $a_tapthe[$tt->maphanloaitapthe] ?? '' }}</td>
                                    <td>{{ $a_loaihinhkt[$tt->maloaihinhkt] ?? '' }}</td>
                                    <td>{{ $a_dhkt[$tt->madanhhieukhenthuong] ?? '' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <div class="row text-center">
                    <div class="col-lg-12">
                        <a href="{{ url('/TraCuu/TapThe/ThongTin') }}" class="btn btn-danger mr-5"><i
                                class="fa fa-reply"></i>&nbsp;Quay lại</a>

                    </div>
                </div>
            </div>
        </div>
        <!--end::Card-->

        {{-- In dữ liệu --}}
        <div id="indulieu-modal" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade">
            {!! Form::open(['url' => '', 'id' => 'frm_InDuLieu', 'target' => '_blank']) !!}
            <input type="hidden" name="tentapthe" value="{{ $inputs['tentapthe'] }}" />
            <input type="hidden" name="ngaytu" value="{{ $inputs['ngaytu'] }}" />
            <input type="hidden" name="ngayden" value="{{ $inputs['ngayden'] }}" />
            <input type="hidden" name="maphanloaitapthe" value="{{ $inputs['maphanloaitapthe'] }}" />
            <input type="hidden" name="maloaihinhkt" value="{{ $inputs['maloaihinhkt'] }}" />

            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header modal-header-primary">
                        <h4 id="modal-header-primary-label" class="modal-title">Thông tin in dữ liệu</h4>
                        <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                    </div>
                    <div class="modal-body">


                        <div class="row">
                            <div class="col-lg-12">
                                <button type="submit" onclick="setInDL('/TraCuu/TapThe/InKetQua')"
                                    class="btn btn-sm btn-clean text-dark font-weight-bold" target="_blank">
                                    <i class="la flaticon2-print"></i>Kết quả tìm kiếm
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

        <script>
            function setInDL(url) {
                $('#frm_InDuLieu').attr('action', url);
            }
        </script>
    @stop
