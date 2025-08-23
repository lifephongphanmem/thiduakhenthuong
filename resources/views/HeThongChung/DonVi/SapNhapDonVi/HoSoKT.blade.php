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
            $('#madonvi, #nam, #madonvi_bisapnhap').change(function() {
                window.location.href = "{{ $inputs['url'] }}" + "HoSoKT?madonvi=" + $(
                    '#madonvi').val() + "&nam=" + $('#nam').val() + "&madonvi_bisapnhap=" + $('#madonvi_bisapnhap').val()+ "&phanloai=" + $('#phanloai').val();
            });
        });
    </script>
@stop

@section('content')
    <!--begin::Card-->
    <div class="card card-custom wave wave-animate-slow wave-info" style="min-height: 600px">
        <div class="card-header flex-wrap border-1 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Danh sách hồ sơ {{$m_loaihinh->tenloaihinhkt}}</h3>
            </div>
            <div class="card-toolbar">
            </div>
        </div>
        <div class="card-body">
            <input type="hidden" name='phanloai' id='phanloai' value="{{$inputs['phanloai']}}">
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

                <div class="col-2">
                    <label style="font-weight: bold">Năm</label>
                    {!! Form::select('nam', getNam(true), $inputs['nam'], ['id' => 'nam', 'class' => 'form-control select2basic']) !!}
                </div>
                <div class="col-5">
                    <label style="font-weight: bold">Đơn vị sáp nhập</label>
                    <select class="form-control select2basic" id="madonvi_bisapnhap">
                                <option value="ALL">Tất cả</option>
                                @foreach ($a_donvi_sapnhap as $ct)
                                    <option {{ $ct->madonvi == $inputs['madonvi_bisapnhap'] ? 'selected' : '' }}
                                        value="{{ $ct->madonvi }}">{{ $ct->tendonvi }}</option>
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
                                <th>Nội dung hồ sơ</th>
                                <th>Phân loại</th>
                                <th width="10%">Quyết định</th>
                                <th width="10%">Trạng thái</th>
                                {{-- <th width="20%">Đơn vị tiếp nhận</th> --}}
                                <th width="15%">Thao tác</th>
                            </tr>
                        </thead>
                        <?php $i = 1; ?>
                        @foreach ($model as $key => $tt)
                            <tr>
                                <td class="text-center">{{ $i++ }}</td>
                                <td>{{$a_donvi[$tt->madonvi]??''}}</td>
                                <td>{{ $tt->noidung }}</td>
                                <td>{{ $a_phanloaihs[$tt->phanloai] ?? '' }}</td>
                                <td class="text-center">{{ $tt->soqd }}<br>{{ getDayVn($tt->ngayqd) }}
                                </td>
                                @include('includes.td.td_trangthai_hoso')
                                {{-- <td>{{ $a_donvi[$tt->madonvi_nhan] ?? '' }}</td> --}}

                                <td style="text-align: center">
                                    <button type="button" title="In dữ liệu"
                                        onclick="setInDuLieu('{{ $tt->mahosotdkt }}', '{{ $tt->maphongtraotd }}', '{{ $tt->trangthai }}', '{{ $inputs['trangthai'] == 'CC' ? false : true }}')"
                                        class="btn btn-sm btn-clean btn-icon" data-target="#indulieu-modal"
                                        data-toggle="modal">
                                        <i class="icon-lg la flaticon2-print text-dark"></i>
                                    </button>

                                    <button title="Tài liệu đính kèm" type="button"
                                        onclick="get_attack('{{ $tt->mahosotdkt }}', '/DungChung/DinhKemHoSoKhenThuong' )"
                                        class="btn btn-sm btn-clean btn-icon" data-target="#dinhkem-modal-confirm"
                                        data-toggle="modal">
                                        <i class="icon-lg la la-file-download text-dark"></i>
                                    </button>


                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--end::Card-->


    @include('NghiepVu._DungChung.InDuLieuKT')
    @include('includes.modal.modal_attackfile')
@stop
