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
                window.location.href = '/TaiKhoan/ThongTin?madonvi=' + $(this).val();
            });
        });
    </script>
@stop

@section('content')
    <!--begin::Card-->
    <div class="card card-custom wave wave-animate-slow wave-primary" style="min-height: 600px">
        <div class="card-header flex-wrap border-1 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Danh sách tài khoản</h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                @if (chkPhanQuyen('dstaikhoan', 'modify'))
                    <a href="{{ url('/TaiKhoan/Them?&madonvi=' . $inputs['madonvi']) }}" class="btn btn-success btn-xs">
                        <i class="fa fa-plus"></i> Thêm mới</a>
                @endif
                <!--end::Button-->
            </div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <div class="col-md-6">
                    <label style="font-weight: bold">Đơn vị</label>
                    <select class="form-control select2basic" name="madonvi" id="madonvi">
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
            </div>

            <div class="form-group row">
                <div class="col-md-12">
                    <table class="table table-bordered table-hover" id="sample_3">
                        <thead>
                            <tr class="text-center">
                                <th width="5%">STT</th>
                                <th>Tên tài khoản</th>
                                <th width="15%">Tài khoản<br>truy cập</th>
                                <th width="8%">Trạng thái</th>
                                <th width="20%">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            ?>
                            @foreach ($model as $key => $tt)
                                <tr>
                                    <td style="text-align: center">{{ $key + 1 }}</td>
                                    <td>{{ $tt->tentaikhoan }}</td>
                                    <td class="text-center">{{ $tt->tendangnhap }}</td>

                                    @if ($tt->trangthai == 1)
                                        <td class="text-center">
                                            <button title="Tài khoản đang được kích hoạt"
                                                class="btn btn-sm btn-clean btn-icon">
                                                <i class="icon-lg la fa-check text-primary icon-2x"></i></button>
                                        @else
                                        <td class="text-center">
                                            <button title="Tài khoản đang được kích hoạt"
                                                class="btn btn-sm btn-clean btn-icon">
                                                <i class="icon-lg la fa-times-circle text-danger icon-2x"></i>
                                            </button>
                                        </td>
                                    @endif                                   

                                    <td class="text-center">
                                        @if (chkPhanQuyen('dstaikhoan', 'modify'))
                                            <a title="Sửa thông tin" href="{{ url('/TaiKhoan/Sua?tendangnhap=' . $tt->tendangnhap) }}"
                                                class="btn btn-sm btn-clean btn-icon">
                                                <i class="icon-lg la fa-edit text-primary icon-2x"></i>
                                            </a>
                                            @if ($tt->trangthai == 1)
                                                <a title="Phân quyền"
                                                    href="{{ url('/TaiKhoan/PhanQuyen?tendangnhap=' . $tt->tendangnhap) }}"
                                                    class="btn btn-sm btn-clean btn-icon">
                                                    <i class="icon-lg flaticon2-user-1 text-primary"></i></a>

                                                {{-- <button type="button" onclick="setPerGroup('{{ $tt->username }}')"
                                                class="btn btn-default btn-xs mbs" data-target="#modify-phanquyen"
                                                data-toggle="modal">
                                                <i class="fa fa-cogs"></i>&nbsp;Phân quyền theo nhóm</button> --}}

                                                <a title="Sao chép tài khoản"
                                                    href="{{ url('taikhoan/copy?username=' . $tt->username) }}"
                                                    class="btn btn-sm btn-clean btn-icon">
                                                    <i class="icon-lg la fa-copy text-info icon-2x"></i></a>

                                                <button title="Xóa thông tin" type="button"
                                                    onclick="confirmDelete('{{ $tt->id }}','TaiKhoan/Xoa' }}')"
                                                    class="btn btn-sm btn-clean btn-icon"
                                                    data-target="#delete-modal-confirm" data-toggle="modal">
                                                    <i class="icon-lg la fa-trash-alt text-danger icon-2x"></i></button>
                                            @endif
                                        @endif
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
@stop