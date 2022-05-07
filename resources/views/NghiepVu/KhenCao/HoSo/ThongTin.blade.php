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
                window.location.href = '/KhenCao/HoSo/ThongTin?madonvi=' + $(
                        '#madonvi').val() +
                    '&nam=' + $('#nam').val() ;
            });
            $('#nam').change(function() {
                window.location.href = '/KhenCao/HoSo/ThongTin?madonvi=' + $(
                        '#madonvi').val() +
                    '&nam=' + $('#nam').val() ;
            });
        });        
    
    </script>
@stop

@section('content')
    <!--begin::Card-->
    <div class="card card-custom wave wave-animate-slow wave-info" style="min-height: 600px">
        <div class="card-header flex-wrap border-1 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Danh sách hồ sơ khen cao</h3>
            </div>
            <div class="card-toolbar">
                @if (chkPhanQuyen('dshosokhencao', 'modify'))
                <button type="button" class="btn btn-success btn-xs" data-target="#taohoso-modal" data-toggle="modal">
                    <i class="fa fa-plus"></i>&nbsp;Thêm mới</button>
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
                                <th width="5%">STT</th>
                                <th>Nội dung hồ sơ</th>
                                <th width="8%">Trạng thái</th>
                                <th width="10%">Thao tác</th>
                            </tr>
                        </thead>

                        @foreach ($model as $key => $tt)
                            <tr>
                                <td class="text-center">{{ $key + 1 }}</td>
                                <td>{{ $tt->noidung }}</td>
                                @include('includes.td.td_trangthai_hoso')

                                <td style="text-align: center">
                                    @if (in_array($tt->trangthai, ['CC', 'BTL', 'CXD']))
                                        <a title="Thông tin hồ sơ"
                                            href="{{ url('/KhenCao/HoSo/Sua?mahosokt=' . $tt->mahosokt) }}"
                                            class="btn btn-sm btn-clean btn-icon">
                                            <i class="icon-lg la fa-check-square text-primary"></i></a>

                                        <button title="Hoàn thành hồ sơ" type="button"
                                            onclick="confirmNhan('{{ $tt->mahosokt }}','/KhenCao/HoSo/NhanHoSo','')"
                                            class="btn btn-sm btn-clean btn-icon" data-target="#nhan-modal-confirm"
                                            data-toggle="modal">
                                            <i class="icon-lg la fa-share text-primary"></i></button>

                                        <button type="button"
                                            onclick="confirmDelete('{{ $tt->id }}','/KhenCao/HoSo/Xoa')"
                                            class="btn btn-sm btn-clean btn-icon" data-target="#delete-modal"
                                            data-toggle="modal">
                                            <i class="icon-lg la fa-trash text-danger"></i></button>
                                    @else
                                        <a title="Thông tin hồ sơ"
                                            href="{{ url('/KhenCao/HoSo/Xem?mahosokt=' . $tt->mahosokt) }}"
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
    
    <!--Modal Tạo hồ sơ-->
    {!! Form::open(['url' => '/KhenCao/HoSo/Them', 'id' => 'frm_hoso']) !!}
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
                            <label>Ngày tạo hồ sơ</label>
                            {!! Form::input('date', 'ngayhoso', date('Y-m-d'), ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label>Nội dung hồ sơ</label>
                            {!! Form::textarea('noidung', null, ['class' => 'form-control', 'rows'=>3]) !!}
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

    @include('includes.modal.modal-lydo')
    @include('includes.modal.modal-delete')
    @include('includes.modal.modal_accept_hs')
@stop
