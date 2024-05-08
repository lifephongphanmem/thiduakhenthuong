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
    </script>
@stop

@section('content')
    <!--begin::Card-->

    <div class="card card-custom wave wave-animate-slow wave-info">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Danh sách khen thưởng theo cá nhân</h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                <!--end::Button-->
            </div>
        </div>

        <div class="card-body">
            <div class="form-group row">
                <div class="col-6">
                    <label>Đơn vị</label>
                    {!! Form::select('madonvi', $a_donvi, $inputs['madonvi'], [
                        'id' => 'madonvi',
                        'class' => 'form-control select2basic',
                    ]) !!}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-12">
                    <table class="table table-bordered table-hover" id="sample_3">
                        <thead>
                            <tr class="text-center">
                                <th width="2%">STT</th>
                                <th>Tên đối tượng</th>
                                {{-- <th width="8%">Ngày sinh</th> --}}
                                {{-- <th>Giới</br>tính</th> --}}
                                <th>Phân loại cán bộ</th>
                                <th>Thông tin công tác</th>
                                <th>Hình thức khen thưởng /<br>Danh hiệu thi đua</th>
                                <th>Loại hình<br>khen thưởng</th>
                                <th>Tờ trình<br>đề nghị</th>
                                <th>Đơn vị<br>đề nghị</th>
                                <th>Tờ trình<br>kết quả</th>
                                <th>Đơn vị<br>xét duyệt</th>
                                <th>Số quyết định<br>khen thưởng</th>
                                <th>Đơn vị phê duyệt</th>
                                <th width="5%">Thao tác</th>
                            </tr>
                        </thead>

                        <?php $i = 1; ?>
                        @foreach ($model as $key => $tt)
                            <tr>
                                <td class="text-center">{{ $i++ }}</td>
                                <td>{{ $tt->tendoituong }}</td>
                                {{-- <td>{{ $tt->gioitinh }}</td> --}}
                                <td>{{ $a_canhan[$tt->maphanloaicanbo] ?? '' }}</td>
                                <td class="text-center">
                                    {{ $tt->chucvu . ',' . $tt->tenphongban . ',' . $tt->tencoquan }}
                                </td>
                                <td class="text-center">
                                    {{ $a_dhkt_canhan[$tt->madanhhieukhenthuong] ?? '' }}
                                </td>
                                <td class="text-center">
                                    {{ $a_loaihinhkt[$tt->maloaihinhkt] ?? '' }}
                                </td>
                                <td class="text-center">{{ $tt->sototrinh }}<br>{{ getDayVn($tt->ngayhoso) }} </td>
                                {{-- @include('includes.td.td_trangthai_hoso') --}}
                                <td>{{ $a_donvi[$tt->madonvi] ?? '' }}</td>
                                <td class="text-center">{{ $tt->sototrinhdenghi }}<br>{{ getDayVn($tt->ngaythangtotrinhdenghi) }} </td>
                                <td>{{ $a_donvi[$tt->madonvi_xd] ?? '' }}</td>
                                <td class="text-center">{{ $tt->soqd }}<br>{{ getDayVn($tt->ngayqd) }} </td>
                                <td>{{ $a_donvi[$tt->madonvi_kt] ?? '' }}</td>

                                <td style="text-align: center">
                                    <button type="button" title="Tạo link API"
                                        onclick="TaoLinkAPI('{{ $tt->id }}', '{{ $inputs['madonvi'] }}')"
                                        class="btn btn-sm btn-clean btn-icon" data-target="#taoapi-modal"
                                        data-toggle="modal">
                                        <i class="icon-lg la flaticon-multimedia-4 text-dark"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row text-center">
                <div class="col-12">
                    {{-- <button class="btn btn-primary" onclick="TaoLinkAPI()"><i class="fa fa-check"></i>Tạo Link API</button> --}}
                </div>
            </div>
        </div>
    </div>

    <!--end::Card-->


    <!--Modal Nhận và trình khen thưởng hồ sơ hồ sơ-->
    <div id="taoapi-modal" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade kt_select2_modal">
        {!! Form::open(['url' => '', 'id' => 'frm_api']) !!}
        <input type="hidden" name="madonvi" />
        <input type="hidden" name="mahosotdkt" />
        <input type="hidden" name="url" />
        <input type="hidden" name="currentUrl" />
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <h4 id="modal-header-primary-label" class="modal-title">Tạo link API cho hồ sơ
                    </h4>
                    <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>

                </div>
                <div class="modal-body">

                    <div class="form-group row">
                        <div class="col-12">
                            <label>Link API</label>
                            {!! Form::textarea('linkAPI', null, [
                                'id' => 'linkAPI',
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>

    <script>
        // function TaoLinkAPI(mahosotdkt, madonvi) {
        //     let currentUrl = window.location.origin;
        //     let url = currentUrl + '/api/QuanLyVanBan/getHoSoKhenThuong?maso=' + btoa(madonvi + ':' + mahosotdkt);
        //     $('#linkAPI').val(url);
        //     return false;
        // }

        function TaoLinkAPI(mahosotdkt, madonvi) {
            $('#frm_api').find("[name='mahosotdkt']").val(mahosotdkt);
            $('#frm_api').find("[name='madonvi']").val(madonvi);
            $('#frm_api').find("[name='currentUrl']").val(window.location.origin);
            $('#frm_api').find("[name='url']").val("/api/QuanLyCanBo/getKhenThuongCaNhan");
            var formData = new FormData($('#frm_api')[0]);

            let currentUrl = window.location.origin;
            $.ajax({
                url: "{{ $inputs['url'] }}" + "TaoAPI",
                method: "POST",
                cache: false,
                dataType: false,
                processData: false,
                contentType: false,
                data: formData,
                success: function(data) {
                    // console.log(data);
                    var kq = JSON.parse(data)
                    if (kq.status == 'success') {
                        $('#linkAPI').val(kq.message);
                    }
                }
            });
        }
    </script>
@stop
