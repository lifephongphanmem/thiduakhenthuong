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
        function setURL(url) {
            $('#thoai_thongtu03').attr('action', url);
        }
    </script>
@stop

@section('content')
    <!--begin::Card-->
    <div class="card card-custom" style="min-height: 600px">
        <div class="card-header flex-wrap border-1 pt-6 pb-1">
            <div class="card-title">
                <h3 class="card-label text-uppercase">DANH SÁCH BÁO CÁO TỔNG HỢP</h3>
            </div>
        </div>
        <div class="card-body">
            {{-- <div class="separator separator-dashed my-5"></div> --}}
            <h4 class="form-section text-dark">Thi đua, khen thưởng các cấp</h4>
            <div class="form-group row">
                <div class="col-lg-12">
                    <ol>
                        <li>
                            <button class="btn btn-clean text-dark" data-target="#modal-phongtrao" data-toggle="modal">Phong
                                trào thi đua trên địa
                                bàn</button>
                        </li>

                        <li>
                            <button class="btn btn-clean text-dark" data-target="#modal-hosotdkt" data-toggle="modal">Hồ sơ
                                đăng ký thi đua, khen
                                thưởng</button>
                        </li>

                        <li>
                            <button class="btn btn-clean text-dark" data-target="#modal-danhhieutd" data-toggle="modal">Danh
                                hiệu thi đua trên địa
                                bàn</button>
                        </li>

                        <li>
                            <button class="btn btn-clean text-dark" data-target="#modal-khenthuong" data-toggle="modal">Hình
                                thức khen thưởng trên địa
                                bàn</button>
                        </li>
                        <li>
                            <button type="button" onclick="setURL('/BaoCao/TongHop/Mau0701')" class="btn btn-clean text-dark"
                                data-target="#modal-thongtu03" data-toggle="modal">Số
                                phong trào thi đua (mẫu 0701.N/BNV-TĐKT)</button>
                        </li>
                        <li>
                            <button type="button" onclick="setURL('/BaoCao/TongHop/Mau0702')" class="btn btn-clean text-dark"
                                data-target="#modal-thongtu03" data-toggle="modal">Số
                                lượng khen thưởng cấp nhà nước (mẫu 0702.N/BNV-TĐKT)</button>
                        </li>
                        <li>
                            <button type="button" onclick="setURL('/BaoCao/TongHop/Mau0703')" class="btn btn-clean text-dark"
                                data-target="#modal-thongtu03" data-toggle="modal">Số
                                lượng khen thưởng cấp ban ngành đoàn thể trung ương (mẫu 0703.N/BNV-TĐKT)</button>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!--end::Card-->
    {{-- Phong trào thi đua --}}
    <div id="modal-phongtrao" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade">
        {!! Form::open(['url' => 'BaoCao/TongHop/PhongTrao', 'target' => '_blank', 'method' => 'post', 'id' => 'thoai_phongtrao', 'class' => 'form-horizontal form-validate']) !!}
        <div class="modal-dialog modal-content">
            <div class="modal-header modal-header-primary">
                <h4 id="modal-header-primary-label" class="modal-title">Thông tin kết xuất phong trào thi đua</h4>
                <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-lg-12">
                        <label>Địa bàn</label>
                        {!! Form::select('madiaban', setArrayAll($a_diaban), null, ['madiaban' => 'madt', 'class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-lg-12">
                        <label>Thời điểm báo cáo</label>
                        {!! Form::select('thoidiem', getThoiDiem(), null, ['madiaban' => 'madt', 'class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-lg-6">
                        <label> Từ ngày</label>
                        {!! Form::input('date', 'ngaytu', date('Y') . '-01-01', ['id' => 'ngaytu', 'class' => 'form-control']) !!}
                    </div>

                    <div class="col-lg-6">
                        <label> Đến ngày</label>
                        {!! Form::input('date', 'ngayden', date('Y') . '-12-31', ['id' => 'ngayden', 'class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-12">
                        <label>Đơn vị báo cáo</label>
                        {!! Form::select('madonvi', $a_donvi, null, ['madiaban' => 'madt', 'class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
                <button type="submit" name="submit" value="submit" class="btn btn-primary">Đồng ý</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>

    {{-- Hồ sơ đăng ký thi đua, khen thưởng --}}
    <div id="modal-hosotdkt" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade">
        {!! Form::open(['url' => 'BaoCao/TongHop/HoSo', 'target' => '_blank', 'method' => 'post', 'id' => 'thoai_hoso', 'class' => 'form-horizontal form-validate']) !!}
        <div class="modal-dialog modal-content">
            <div class="modal-header modal-header-primary">
                <h4 id="modal-header-primary-label" class="modal-title">Thông tin kết xuất hồ sơ đăng ký thi đua, khen
                    thưởng</h4>
                <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-lg-12">
                        <label>Địa bàn</label>
                        {!! Form::select('madiaban', setArrayAll($a_diaban), null, ['madiaban' => 'madt', 'class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-lg-12">
                        <label>Thời điểm báo cáo</label>
                        {!! Form::select('thoidiem', getThoiDiem(), null, ['madiaban' => 'madt', 'class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-lg-6">
                        <label> Từ ngày</label>
                        {!! Form::input('date', 'ngaytu', date('Y') . '-01-01', ['id' => 'ngaytu', 'class' => 'form-control']) !!}
                    </div>

                    <div class="col-lg-6">
                        <label> Đến ngày</label>
                        {!! Form::input('date', 'ngayden', date('Y') . '-12-31', ['id' => 'ngayden', 'class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-12">
                        <label>Đơn vị báo cáo</label>
                        {!! Form::select('madonvi', $a_donvi, null, ['madiaban' => 'madt', 'class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
                <button type="submit" name="submit" value="submit" class="btn btn-primary">Đồng ý</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>

    {{-- Danh hiệu thi đua trên địa bàn --}}
    <div id="modal-danhhieutd" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade">
        {!! Form::open(['url' => 'BaoCao/TongHop/DanhHieu', 'target' => '_blank', 'method' => 'post', 'id' => 'thoai_hoso', 'class' => 'form-horizontal form-validate']) !!}
        <div class="modal-dialog modal-content">
            <div class="modal-header modal-header-primary">
                <h4 id="modal-header-primary-label" class="modal-title">Thông tin kết xuất danh hiệu thi đua</h4>
                <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-lg-12">
                        <label>Địa bàn</label>
                        {!! Form::select('madiaban', setArrayAll($a_diaban), null, ['madiaban' => 'madt', 'class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-lg-12">
                        <label>Thời điểm báo cáo</label>
                        {!! Form::select('thoidiem', getThoiDiem(), null, ['madiaban' => 'madt', 'class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-lg-6">
                        <label> Từ ngày</label>
                        {!! Form::input('date', 'ngaytu', date('Y') . '-01-01', ['id' => 'ngaytu', 'class' => 'form-control']) !!}
                    </div>

                    <div class="col-lg-6">
                        <label> Đến ngày</label>
                        {!! Form::input('date', 'ngayden', date('Y') . '-12-31', ['id' => 'ngayden', 'class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-12">
                        <label>Đơn vị báo cáo</label>
                        {!! Form::select('madonvi', $a_donvi, null, ['madiaban' => 'madt', 'class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
                <button type="submit" name="submit" value="submit" class="btn btn-primary">Đồng ý</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>

    {{-- Hình thức khen thưởng --}}
    <div id="modal-khenthuong" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade">
        {!! Form::open(['url' => 'BaoCao/TongHop/KhenThuong', 'target' => '_blank', 'method' => 'post', 'id' => 'thoai_hoso', 'class' => 'form-horizontal form-validate']) !!}
        <div class="modal-dialog modal-content">
            <div class="modal-header modal-header-primary">
                <h4 id="modal-header-primary-label" class="modal-title">Thông tin kết xuất hình thức khen thưởng</h4>
                <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-lg-12">
                        <label>Địa bàn</label>
                        {!! Form::select('madiaban', setArrayAll($a_diaban), null, ['madiaban' => 'madt', 'class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-lg-12">
                        <label>Thời điểm báo cáo</label>
                        {!! Form::select('thoidiem', getThoiDiem(), null, ['madiaban' => 'madt', 'class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-lg-6">
                        <label> Từ ngày</label>
                        {!! Form::input('date', 'ngaytu', date('Y') . '-01-01', ['id' => 'ngaytu', 'class' => 'form-control']) !!}
                    </div>

                    <div class="col-lg-6">
                        <label> Đến ngày</label>
                        {!! Form::input('date', 'ngayden', date('Y') . '-12-31', ['id' => 'ngayden', 'class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-12">
                        <label>Đơn vị báo cáo</label>
                        {!! Form::select('madonvi', $a_donvi, null, ['madiaban' => 'madt', 'class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
                <button type="submit" name="submit" value="submit" class="btn btn-primary">Đồng ý</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>

    {{-- Mẫu thông tu 03 / 2018 --}}
    <div id="modal-thongtu03" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade">
        {!! Form::open(['url' => '/BaoCao/TongHop/KhenThuong', 'target' => '_blank', 'method' => 'post', 'id' => 'thoai_thongtu03', 'class' => 'form-horizontal form-validate']) !!}
        <div class="modal-dialog modal-content">
            <div class="modal-header modal-header-primary">
                <h4 id="modal-header-primary-label" class="modal-title">Thông tin kết xuất hình thức khen thưởng</h4>
                <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-lg-12">
                        <label>Địa bàn</label>
                        {!! Form::select('madiaban', setArrayAll($a_diaban), null, ['madiaban' => 'madt', 'class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-lg-12">
                        <label>Thời điểm báo cáo</label>
                        {!! Form::select('thoidiem', getThoiDiem(), null, ['madiaban' => 'madt', 'class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-lg-6">
                        <label> Từ ngày</label>
                        {!! Form::input('date', 'ngaytu', date('Y') . '-01-01', ['id' => 'ngaytu', 'class' => 'form-control']) !!}
                    </div>

                    <div class="col-lg-6">
                        <label> Đến ngày</label>
                        {!! Form::input('date', 'ngayden', date('Y') . '-12-31', ['id' => 'ngayden', 'class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-12">
                        <label>Đơn vị báo cáo</label>
                        {!! Form::select('madonvi', $a_donvi, null, ['madiaban' => 'madt', 'class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
                <button type="submit" name="submit" value="submit" class="btn btn-primary">Đồng ý</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    

@stop
