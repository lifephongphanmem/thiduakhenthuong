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
                window.location.href = '/KhenThuongKhangChien/ChongPhapCaNhan/ThongTin?madonvi=' + $(
                        '#madonvi').val() +
                    '&nam=' + $('#nam').val() + '&maloaihinhkt=' + $('#maloaihinhkt').val();
            });
            $('#maloaihinhkt').change(function() {
                window.location.href = '/KhenThuongKhangChien/ChongPhapCaNhan/ThongTin?madonvi=' + $(
                        '#madonvi').val() +
                    '&nam=' + $('#nam').val() + '&maloaihinhkt=' + $('#maloaihinhkt').val();
            });
            $('#nam').change(function() {
                window.location.href = '/KhenThuongKhangChien/ChongPhapCaNhan/ThongTin?madonvi=' + $(
                        '#madonvi').val() +
                    '&nam=' + $('#nam').val() + '&maloaihinhkt=' + $('#maloaihinhkt').val();
            });
        });        
    
    </script>
@stop

@section('content')
    <!--begin::Card-->
    <div class="card card-custom wave wave-animate-slow wave-info" style="min-height: 600px">
        <div class="card-header flex-wrap border-1 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Danh sách hồ sơ khen thưởng kháng chiến chống Pháp cho cá nhân</h3>
            </div>
            <div class="card-toolbar">
                @if (chkPhanQuyen('dshosochongphap_canhan', 'modify'))
                    <a href="{{url('/KhenThuongKhangChien/ChongPhapCaNhan/Them?madonvi='.$inputs['madonvi'])}}" class="btn btn-success btn-xs" >
                        <i class="fa fa-plus"></i>&nbsp;Thêm mới</a>
                @endif
            </div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <div class="col-md-5">
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
                <div class="col-md-5">
                    <label style="font-weight: bold">Loại hình khen thưởng</label>
                    {!! Form::select('maloaihinhkt', setArrayAll($a_loaihinhkt), $inputs['maloaihinhkt'], ['id' => 'maloaihinhkt', 'class' => 'form-control select2basic']) !!}
                </div>
                <div class="col-md-2">
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
                                <th>Loại hồ sơ</th>
                                <th>Nội dung hồ sơ</th>
                                <th width="15%">Loại hình khen thưởng</th>
                                <th width="15%">Danh hiệu khen thưởng</th>
                                <th width="8%">Trạng thái</th>
                                <th width="10%">Thao tác</th>
                            </tr>
                        </thead>

                        @foreach ($model as $key => $tt)
                            <tr>
                                <td class="text-center">{{ $key + 1 }}</td>
                                <td>{{ $tt->loaihosokc }}</td>
                                <td>{{ $tt->noidung }}</td>
                                <td>{{ $a_loaihinhkt[$tt->maloaihinhkt] ?? '' }}</td>
                                <td>{{ $a_hinhthuckt[$tt->mahinhthuckt] }}</td>
                                @include('includes.td.td_trangthai_hoso')

                                <td style="text-align: center">
                                    @if (in_array($tt->trangthai, ['CC', 'BTL', 'CXD']))
                                        <a title="Thông tin hồ sơ"
                                            href="{{ url('/KhenThuongKhangChien/ChongPhapCaNhan/Sua?mahosokt=' . $tt->mahosokt) }}"
                                            class="btn btn-sm btn-clean btn-icon">
                                            <i class="icon-lg la fa-check-square text-primary"></i></a>

                                        <button title="Hoàn thành hồ sơ" type="button"
                                            onclick="confirmNhan('{{ $tt->mahosokt }}','/KhenThuongKhangChien/ChongPhapCaNhan/NhanHoSo','')"
                                            class="btn btn-sm btn-clean btn-icon" data-target="#nhan-modal-confirm"
                                            data-toggle="modal">
                                            <i class="icon-lg la fa-share text-primary"></i></button>

                                        <button type="button"
                                            onclick="confirmDelete('{{ $tt->id }}','/KhenThuongKhangChien/ChongPhapCaNhan/Xoa')"
                                            class="btn btn-sm btn-clean btn-icon" data-target="#delete-modal"
                                            data-toggle="modal">
                                            <i class="icon-lg la fa-trash text-danger"></i></button>
                                    @else
                                        <a title="Thông tin hồ sơ"
                                            href="{{ url('/KhenThuongKhangChien/ChongPhapCaNhan/Xem?mahosokt=' . $tt->mahosokt) }}"
                                            class="btn btn-sm btn-clean btn-icon" target="_blank">
                                            <i class="icon-lg la fa-eye text-dark"></i></a>
                                       
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
    
    @include('includes.modal.modal-lydo')
    @include('includes.modal.modal-delete')
    @include('includes.modal.modal_accept_hs')
@stop
