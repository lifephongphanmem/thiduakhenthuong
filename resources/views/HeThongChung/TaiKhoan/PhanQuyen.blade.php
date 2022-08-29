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
    <div class="card card-custom wave wave-animate-slow wave-primary" style="min-height: 600px">
        <div class="card-header flex-wrap border-1 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Phân quyền tài khoản:</h3>
            </div>
            <div class="card-toolbar">
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-hover" id="sample_3">
                        <thead>
                            <tr class="text-center">
                                <th rowspan="2" width="10%">STT</th>
                                <th rowspan="2">Mã số</th>
                                <th rowspan="2">Tên chức năng</th>
                                <th colspan="3">Phân quyền</th>
                                <th rowspan="2" width="10%">Thao tác</th>
                            </tr>
                            <tr class="text-center">
                                <th width="10%">Xem hồ sơ</th>
                                <th width="10%">Thay đổi</th>
                                <th width="10%">Gửi/Duyệt</br>hồ sơ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($model as $c1)
                                <?php
                                $model_c2 = $m_chucnang->where('machucnang_goc', $c1->machucnang)->sortby('sapxep');
                                ?>
                                <tr>
                                    <td
                                        class="text-uppercase font-weight-bold text-info {{ $c1->sudung == 0 ? 'text-line-through' : '' }}">
                                        {{ toAlpha($c1->sapxep) }}</td>
                                    <td class="font-weight-bold {{ $c1->sudung == 0 ? 'text-line-through' : '' }}">
                                        {{ $c1->machucnang }}</td>
                                    <td class="font-weight-bold {{ $c1->sudung == 0 ? 'text-line-through' : '' }}">
                                        {{ $c1->tenchucnang }}</td>
                                    <td>{{ $c1->danhsach }}</td>
                                    <td>{{ $c1->thaydoi }}</td>
                                    <td>{{ $c1->hoanthanh }}</td>
                                    <td style="text-decoration: none;text-align: center">
                                        @if (chkPhanQuyen('hethongchung_chucnang', 'modify'))
                                            <button onclick="getChucNang({{ $c1->id }})"
                                                class="btn btn-sm btn-clean btn-icon" data-target="#modify-modal"
                                                title="Thay đổi thông tin" data-toggle="modal">
                                                <i class="icon-lg la fa-edit text-primary icon-2x"></i></button>
                                        @endif

                                    </td>
                                </tr>

                                @foreach ($model_c2 as $c2)
                                    <?php
                                    $sudung_c2 = $c2->sudung == 0 || $c1->sudung == 0 ? 0 : 1;
                                    $model_c3 = $m_chucnang->where('machucnang_goc', $c2->machucnang)->sortby('sapxep');
                                    ?>
                                    <tr>
                                        <td
                                            class="text-uppercase text-warning {{ $sudung_c2 == 0 ? 'text-line-through' : '' }}">
                                            {{ toAlpha($c1->sapxep) }}--{{ romanNumerals($c2->sapxep) }}</td>
                                        <td class="{{ $sudung_c2 == 0 ? 'text-line-through' : '' }}">{{ $c2->machucnang }}
                                        </td>
                                        <td class="{{ $sudung_c2 == 0 ? 'text-line-through' : '' }}">
                                            {{ $c2->tenchucnang }}</td>
                                        <td>{{ $c2->danhsach }}</td>
                                        <td>{{ $c2->thaydoi }}</td>
                                        <td>{{ $c2->hoanthanh }}</td>
                                        <td style="text-decoration: none;text-align: center">
                                            @if (chkPhanQuyen('hethongchung_chucnang', 'modify'))
                                                <button onclick="getChucNang({{ $c2->id }})"
                                                    class="btn btn-sm btn-clean btn-icon" data-target="#modify-modal"
                                                    title="Thay đổi thông tin" data-toggle="modal">
                                                    <i class="icon-lg la fa-edit text-dark icon-2x"></i>
                                                </button>
                                            @endif

                                        </td>
                                    </tr>

                                    @foreach ($model_c3 as $c3)
                                        <?php
                                        $sudung_c3 = $c3->sudung == 0 || $sudung_c2 == 0 ? 0 : 1;
                                        $model_c4 = $m_chucnang->where('machucnang_goc', $c3->machucnang)->sortby('sapxep');
                                        ?>
                                        <tr>
                                            <td class="text-uppercase {{ $sudung_c3 == 0 ? 'text-line-through' : '' }}">
                                                {{ toAlpha($c1->sapxep) }}--{{ romanNumerals($c2->sapxep) }}--{{ $c3->sapxep }}
                                            </td>
                                            <td class="{{ $sudung_c3 == 0 ? 'text-line-through' : '' }}">
                                                {{ $c3->machucnang }}</td>
                                            <td class="{{ $sudung_c3 == 0 ? 'text-line-through' : '' }}">
                                                {{ $c3->tenchucnang }}</td>
                                            <td>{{ $c3->danhsach }}</td>
                                            <td>{{ $c3->thaydoi }}</td>
                                            <td>{{ $c3->hoanthanh }}</td>
                                            <td style="text-align: center">
                                                @if (chkPhanQuyen('hethongchung_chucnang', 'modify'))
                                                    <button onclick="getChucNang({{ $c3->id }})"
                                                        class="btn btn-sm btn-clean btn-icon" data-target="#modify-modal"
                                                        title="Thay đổi thông tin" data-toggle="modal">
                                                        <i class="icon-lg la fa-edit text-dark icon-2x"></i>
                                                    </button>
                                                @endif

                                            </td>
                                        </tr>

                                        @foreach ($model_c4 as $c4)
                                            <?php
                                            $sudung_c4 = $c4->sudung == 0 || $sudung_c3 == 0 ? 0 : 1;
                                            ?>
                                            <tr>
                                                <td
                                                    class="text-uppercase {{ $sudung_c4 == 0 ? 'text-line-through' : '' }}">
                                                    {{ toAlpha($c1->sapxep) }}--{{ romanNumerals($c2->sapxep) }}--{{ $c3->sapxep }}--{{ $c4->sapxep }}
                                                </td>
                                                <td class="{{ $sudung_c4 == 0 ? 'text-line-through' : '' }}">
                                                    {{ $c4->machucnang }}</td>
                                                <td class="{{ $sudung_c4 == 0 ? 'text-line-through' : '' }}">
                                                    {{ $c4->tenchucnang }}</td>
                                                <td>{{ $c4->danhsach }}</td>
                                                <td>{{ $c4->thaydoi }}</td>
                                                <td>{{ $c4->hoanthanh }}</td>
                                                <td style="text-align: center">
                                                    @if (chkPhanQuyen('hethongchung_chucnang', 'modify'))
                                                        <button onclick="getChucNang({{ $c4->id }})"
                                                            class="btn btn-sm btn-clean btn-icon"
                                                            data-target="#modify-modal" title="Thay đổi thông tin"
                                                            data-toggle="modal">
                                                            <i class="icon-lg la fa-edit text-dark icon-2x"></i>
                                                        </button>
                                                    @endif

                                                </td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--end::Card-->

    <!--Modal thông tin chi tiết -->
    {!! Form::open(['url' => '/ChucNang/ThongTin', 'id' => 'frm_modify']) !!}
    <div id="modify-modal" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade kt_select2_modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <h4 id="modal-header-primary-label" class="modal-title">Thông tin chức năng</h4>
                    <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-horizontal">
                        <div class="row form-group">                           

                            <div class="col-6">
                                <label class="control-label">Tên chức năng<span class="require">*</span></label>
                                {!! Form::text('tenchucnang', null, ['class' => 'form-control', 'required' => 'required']) !!}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-3 col-form-label">Thiết lập chức năng:</label>
                            <div class="col-9 col-form-label">
                                <div class="checkbox-inline">
                                    <label class="checkbox checkbox-outline checkbox-success">
                                    <input type="checkbox" name="Checkboxes15">
                                    <span></span>Sử dụng</label>
                                    <label class="checkbox checkbox-outline checkbox-success">
                                    <input type="checkbox" name="Checkboxes15" checked="checked">
                                    <span></span>Áp dụng cho chức năng con</label>                                    
                                </div>
                                <span class="form-text text-muted">Some help text goes here</span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-3 col-form-label">Phân quyền chức năng:</label>
                            <div class="col-9 col-form-label">
                                <div class="checkbox-inline">
                                    <label class="checkbox checkbox-outline checkbox-success">
                                    <input type="checkbox" name="Checkboxes15">
                                    <span></span>Danh sách</label>
                                    <label class="checkbox checkbox-outline checkbox-success">
                                    <input type="checkbox" name="Checkboxes15" checked="checked">
                                    <span></span>Thay đổi</label>
                                    <label class="checkbox checkbox-outline checkbox-success checkbox-disabled">
                                    <input type="checkbox" name="Checkboxes15" disabled="disabled">
                                    <span></span>Hoàn thành</label>
                                </div>
                                <span class="form-text text-muted">Some help text goes here</span>
                            </div>
                        </div>




                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
                    <button type="submit" id="submit" name="submit" value="submit" class="btn btn-primary">Đồng
                        ý</button>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}

    <div class="modal fade" id="delete-modal-confirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                {!! Form::open(['url' => '', 'id' => 'frm_delete']) !!}
                <div class="modal-header">
                    <h4 class="modal-title">Đồng ý xóa?</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                </div>
                <input type="hidden" name="iddelete" />
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-danger" onclick="ClickDelete()">Đồng ý</button>
                </div>
                {!! Form::close() !!}
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>




@stop
