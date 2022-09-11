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

        function add() {
            $('#madanhhieutd').val('');
            $('#madanhhieutd').attr('readonly', true);
        }

        function edit(madanhhieutd, tendanhhieutd, phanloai) {
            $('#madanhhieutd').attr('readonly', false);
            $('#madanhhieutd').val(madanhhieutd);
            $('#tendanhhieutd').val(tendanhhieutd);
            $('#phanloai').val(phanloai).trigger('change');
        }
    </script>
@stop

@section('content')
    <!--begin::Card-->
    <div class="card card-custom" style="min-height: 600px">
        <div class="card-header flex-wrap border-1 pt-6 pb-1">
            <div class="card-title">
                <h3 class="card-label text-uppercase">DANH SÁCH BÁO CÁO TẠI ĐƠN VỊ</h3>
            </div>
        </div>
        <div class="card-body">
            {{-- <div class="separator separator-dashed my-5"></div> --}}
            <div class="form-group row">
                <div class="col-lg-12">
                    <ol>
                        <li>
                            <button class="btn btn-clean text-dark" data-target="#modal-canhan" data-toggle="modal">
                                Báo cáo thành tích theo cá nhân
                            </button>
                        </li>

                        <li>
                            <button class="btn btn-clean text-dark" data-target="#modal-tapthe" data-toggle="modal"
                                title="Dữ liệu chi trả theo tổng hợp lương tại đơn vị">
                                Báo cáo thành tích theo tập thể
                            </button>
                        </li>

                        {{-- <li>
                            <a href="#" data-target="#modal-phongtrao" data-toggle="modal"
                                title="Dữ liệu chi trả theo tổng hợp lương tại đơn vị"
                                onclick="chitraluong('{{ 'don_vi/chitratheonkp' }}')">Theo phong trào thi đua khen thưởng
                            </a>
                        </li> --}}

                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!--end::Card-->

    <div id="modal-canhan" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade">
        {!! Form::open([
            'url' => '/BaoCao/DonVi/CaNhan',
            'target' => '_blank',
            'method' => 'post',
            'id' => 'thoaibangluong',
            'class' => 'form-horizontal form-validate',
        ]) !!}
        <div class="modal-dialog modal-content">
            <div class="modal-header modal-header-primary">
                <h4 id="modal-header-primary-label" class="modal-title">Thông tin kết xuất</h4>
                <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">
                    <div class="form-group row">
                        <label class="control-label"> Chọn đối tượng</label>
                        {!! Form::select('tendoituong', array_column($m_canhan->toarray(), 'tendoituong', 'tendoituong'), null, [
                            'id' => 'tendoituong',
                            'class' => 'form-control',
                        ]) !!}

                    </div>

                    <div class="form-group row">
                        <label class="control-label">Khen thưởng từ ngày</label>
                        {!! Form::input('date', 'ngaytu', date('Y') . '-01-01', ['id' => 'ngaytu', 'class' => 'form-control']) !!}

                    </div>

                    <div class="form-group row">
                        <label class="control-label">Khen thưởng đến ngày</label>
                        {!! Form::input('date', 'ngayden', date('Y') . '-12-31', ['id' => 'ngayden', 'class' => 'form-control']) !!}

                    </div>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
                <button type="submit" id="submit" name="submit" value="submit" class="btn btn-primary">Đồng ý</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>

    <div id="modal-tapthe" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade">
        {!! Form::open([
            'url' => '/BaoCao/DonVi/TapThe',
            'target' => '_blank',
            'method' => 'post',
            'id' => 'thoaibangluong',
            'class' => 'form-horizontal form-validate',
        ]) !!}
        <div class="modal-dialog modal-content">
            <div class="modal-header modal-header-primary">
                <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                <h4 id="modal-header-primary-label" class="modal-title">Thông tin kết xuất</h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">
                    <div class="form-group">
                        <label class="col-md-4 control-label"> Chọn tập thể</label>
                        <div class="col-md-8">
                            {!! Form::select('tentapthe', array_column($m_tapthe->toarray(), 'tentapthe', 'tentapthe'), null, [
                                'id' => 'tentapthe',
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label"> Từ ngày</label>
                        <div class="col-md-8">
                            {!! Form::input('date', 'ngaytu', date('Y') . '-01-01', ['id' => 'ngaytu', 'class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label"> Đến ngày</label>
                        <div class="col-md-8">
                            {!! Form::input('date', 'ngayden', date('Y') . '-12-31', ['id' => 'ngayden', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
                <button type="submit" id="submit" name="submit" value="submit" class="btn btn-primary">Đồng ý</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>

    <div id="modal-phongtrao" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade">
        {!! Form::open([
            'url' => '/BaoCao/DonVi/PhongTrao',
            'target' => '_blank',
            'method' => 'post',
            'id' => 'thoaibangluong',
            'class' => 'form-horizontal form-validate',
        ]) !!}
        <div class="modal-dialog modal-content">
            <div class="modal-header modal-header-primary">
                <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                <h4 id="modal-header-primary-label" class="modal-title">Thông tin kết xuất</h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">
                    <div class="form-group">
                        <label class="col-md-4 control-label"> Tên phong trào</label>
                        <div class="col-md-8">
                            {!! Form::select('kihieudhtd', array_column($m_phongtrao->toarray(), 'noidung', 'kihieudhtd'), null, [
                                'id' => 'kihieudhtd',
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                    </div>

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
                <button type="submit" id="submit" name="submit" value="submit" class="btn btn-primary">Đồng
                    ý</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div> 
@stop
