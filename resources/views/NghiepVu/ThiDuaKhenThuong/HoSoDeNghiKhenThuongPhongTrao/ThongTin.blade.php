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
            $('#madonvi,#nam,#phamviapdung').change(function() {
                window.location.href = "{{ $inputs['url_hs'] }}" + 'ThongTin?madonvi=' + $('#madonvi')
                    .val() +
                    '&nam=' + $('#nam').val() + '&phamviapdung=' + $('#phamviapdung').val();
            });
        });
    </script>
@stop

@section('content')
    <!--begin::Card-->
    <div class="card card-custom wave wave-animate-slow wave-info" style="min-height: 600px">
        <div class="card-header flex-wrap border-1 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Danh sách hồ sơ thi đua từ đơn vị cấp dưới</h3>
            </div>
            <div class="card-toolbar">
            </div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <div class="col-md-4">
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

                <div class="col-md-4">
                    <label style="font-weight: bold">Phạm vi phát động</label>
                    {!! Form::select('phamviapdung', setArrayAll($a_phamvi, 'Tất cả', 'ALL'), $inputs['phamviapdung'], [
                        'id' => 'phamviapdung',
                        'class' => 'form-control select2basic',
                    ]) !!}
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
                                <th rowspan="2" width="2%">STT</th>
                                <th colspan="3">Hồ sơ đề nghị khen thưởng</th>
                                <th colspan="2">Phong trào</th>
                                <th rowspan="2" style="text-align: center" width="10%">Thao tác</th>
                            </tr>
                            <tr class="text-center">
                                <th>Nội dung hồ sơ</th>
                                <th>Trạng thái</th>
                                <th>Đơn vị tiếp nhận</th>
                                <th>Phạm vị phát động</th>
                                <th width="25%">Tên phong trào thi đua</th>
                            </tr>
                        </thead>
                        <?php $i = 1; ?>
                        @foreach ($model as $key => $tt)
                            <tr>
                                <td style="text-align: center">{{ $i++ }}</td>
                                <td>{{ $tt->noidungkt }}</td>
                                @include('includes.td.td_trangthai_khenthuong')
                                <td>{{ $a_dsdonvi[$tt->madonvinhankt] ?? '' }}</td>

                                <td class="text-center">
                                    {{ $a_phamvi[$tt->phamviapdung] ?? '' }}<br>({{ $a_trangthaihoso[$tt->nhanhoso] }})
                                </td>
                                <td>{{ $tt->noidung }}</td>
                                <td style="text-align: center">
                                    <button type="button" title="In dữ liệu"
                                        onclick="setInDuLieu('{{ $tt->mahosothamgiapt }}','{{ $tt->mahosotdkt }}', '{{ $tt->maphongtraotd }}', '{{ $tt->trangthaikt }}')"
                                        class="btn btn-sm btn-clean btn-icon" data-target="#indulieu-modal"
                                        data-toggle="modal">
                                        <i class="icon-lg la flaticon2-print text-dark"></i>
                                    </button>

                                    <button title="Tài liệu đính kèm" type="button"
                                        onclick="get_attack('{{ $tt->mahosotdkt }}', '/DungChung/DinhKemHoSoKhenThuong')"
                                        class="btn btn-sm btn-clean btn-icon" data-target="#dinhkem-modal-confirm"
                                        data-toggle="modal">
                                        <i class="icon-lg la la-file-download text-dark"></i>
                                    </button>
                                    <a title="Danh sách chi tiết"
                                        href="{{ url($inputs['url_hs'] . 'DanhSach?maphongtraotd=' . $tt->maphongtraotd . '&madonvi=' . $inputs['madonvi'] . '&trangthai=false') }}"
                                        class="btn btn-icon btn-clean btn-lg mb-1 position-relative">
                                        <span class="svg-icon svg-icon-xl">
                                            <i class="icon-lg la flaticon-folder-1 text-dark"></i>
                                        </span>
                                        <span
                                            class="label label-sm label-light-danger text-dark label-rounded font-weight-bolder position-absolute top-0 right-0">{{ $tt->sohoso }}</span>
                                    </a>

                                    @if ($inputs['trangthai'] == 'CC')
                                        <!--
                                                                    1.Chưa có hồ sơ khen thưởng => tạo hồ sơ đề nghị
                                                                    2.Có hồ sơ đề nghị => Xem; Sửa; Xoá; Gửi
                                                                 -->
                                        @if ($tt->nhanhoso == 'KETTHUC' && chkPhanQuyen('dshosodenghikhenthuongthidua', 'hoanthanh'))
                                            @if ($tt->mahosotdkt == '-1')
                                                <!-- 1.Chưa có hồ sơ khen thưởng => tạo hồ sơ đề nghị -->
                                                <button title="Tạo hồ sơ khen thưởng" type="button"
                                                    onclick="confirmKhenThuong('{{ $tt->maphongtraotd }}')"
                                                    class="btn btn-sm btn-clean btn-icon" data-target="#taohoso-modal"
                                                    data-toggle="modal">
                                                    <i class="icon-lg la flaticon-edit-1 text-success"></i>
                                                </button>
                                            @else
                                                <!-- 1.Đã có hồ sơ khen thưởng -->
                                                @if (in_array($tt->trangthaikt, ['CC', 'BTLXD', 'BTL']))
                                                    <a href="{{ url($inputs['url_hs'] . 'Sua?mahosotdkt=' . $tt->mahosotdkt) }}"
                                                        class="btn btn-icon btn-clean btn-lg mb-1 position-relative"
                                                        title="Thông tin hồ sơ khen thưởng">
                                                        <span class="svg-icon svg-icon-xl">
                                                            <i class="icon-lg la flaticon-list text-success"></i>
                                                        </span>
                                                        <span
                                                            class="label label-sm label-light-danger text-dark label-rounded font-weight-bolder position-absolute top-0 right-0">{{ $tt->soluongkhenthuong }}</span>
                                                    </a>

                                                    @if (session('admin')->opt_duthaototrinh)
                                                        <a title="Tạo dự thảo đề nghị khen thưởng" target="_blank"
                                                            href="{{ url('/DungChung/DuThao/ToTrinhDeNghiKhenThuong?mahosotdkt=' . $tt->mahosotdkt) }}"
                                                            class="btn btn-sm btn-clean btn-icon">
                                                            {{-- class="btn btn-sm btn-clean btn-icon {{ $tt->soluongkhenthuong == 0 ? 'disabled' : '' }}"> --}}
                                                            <i class="icon-lg la flaticon-clipboard text-success"></i>
                                                        </a>
                                                    @endif

                                                    <button title="Chuyển xét duyệt khen thưởng" type="button"
                                                        onclick="confirmNhanvaTKT('{{ $tt->mahosotdkt }}','{{ $inputs['url_hs'] . 'ChuyenHoSo' }}','{{ $inputs['madonvi'] }}')"
                                                        class="btn btn-sm btn-clean btn-icon"
                                                        {{ $tt->soluongkhenthuong == 0 ? 'disabled' : '' }}
                                                        data-target="#nhanvatkt-modal" data-toggle="modal">
                                                        <i class="icon-lg la fa-share-square text-success"></i>
                                                    </button>

                                                    <button type="button"
                                                        onclick="confirmDelete('{{ $tt->mahosotdkt }}','{{ $inputs['url_hs'] . 'XoaHoSoKT' }}')"
                                                        class="btn btn-sm btn-clean btn-icon"
                                                        data-target="#delete-modal-confirm" data-toggle="modal">
                                                        <i class="icon-lg flaticon-delete text-danger"></i>
                                                    </button>
                                                @else
                                                @endif
                                            @endif
                                        @endif
                                    @else
                                        @if (
                                            $tt->nhanhoso == 'KETTHUC' &&
                                                chkPhanQuyen('dshosodenghikhenthuongthidua', 'hoanthanh') &&
                                                in_array($tt->trangthaikt, ['DD', 'BTLXD', 'CXD', 'CXKT']))
                                            @if ($tt->mahosotdkt == '-1')
                                                <button title="Tạo hồ sơ khen thưởng" type="button"
                                                    onclick="confirmKhenThuong('{{ $tt->maphongtraotd }}')"
                                                    class="btn btn-sm btn-clean btn-icon" data-target="#taohoso-modal"
                                                    data-toggle="modal">
                                                    <i class="icon-lg la flaticon-edit-1 text-success"></i>
                                                </button>
                                            @else
                                                <a href="{{ url('/XetDuyetHoSoThiDua/XetKT?mahosotdkt=' . $tt->mahosotdkt . '&madonvi=' . $inputs['madonvi']) }}"
                                                    class="btn btn-icon btn-clean btn-lg mb-1 position-relative"
                                                    title="Thông tin hồ sơ khen thưởng">
                                                    <span class="svg-icon svg-icon-xl">
                                                        <i class="icon-lg la flaticon-list text-success"></i>
                                                    </span>
                                                    <span
                                                        class="label label-sm label-light-danger text-dark label-rounded font-weight-bolder position-absolute top-0 right-0">{{ $tt->soluongkhenthuong }}</span>
                                                </a>

                                                <a title="Tạo dự thảo tờ trình"
                                                    href="{{ url('/XetDuyetHoSoThiDua/ToTrinhHoSo?mahosotdkt=' . $tt->mahosotdkt) }}"
                                                    class="btn btn-sm btn-clean btn-icon {{ $tt->soluongkhenthuong == 0 ? 'disabled' : '' }}">
                                                    <i class="icon-lg la flaticon-edit-1 text-success"></i>
                                                </a>

                                                @if (session('admin')->opt_duthaototrinh)
                                                    <a title="Tạo dự thảo đề nghị khen thưởng" target="_blank"
                                                        href="{{ url('/DungChung/DuThao/ToTrinhDeNghiKhenThuong?mahosotdkt=' . $tt->mahosotdkt) }}"
                                                        class="btn btn-sm btn-clean btn-icon">
                                                        {{-- class="btn btn-sm btn-clean btn-icon {{ $tt->soluongkhenthuong == 0 ? 'disabled' : '' }}"> --}}
                                                        <i class="icon-lg la flaticon-clipboard text-success"></i>
                                                    </a>
                                                @endif

                                                {{-- <a title="Tạo dự thảo quyết định khen thưởng"
                                                    href="{{ url('/XetDuyetHoSoThiDua/QuyetDinh?mahosotdkt=' . $tt->mahosotdkt) }}"
                                                    class="btn btn-sm btn-clean btn-icon {{ $tt->soluongkhenthuong == 0 ? 'disabled' : '' }}">
                                                    <i class="icon-lg la flaticon-edit-1 text-success"></i>
                                                </a> --}}

                                                <button type="button"
                                                    onclick="confirmDelete('{{ $tt->mahosotdkt }}','/XetDuyetHoSoThiDua/XoaHoSoKT')"
                                                    class="btn btn-sm btn-clean btn-icon"
                                                    data-target="#delete-modal-confirm" data-toggle="modal">
                                                    <i class="icon-lg flaticon-delete text-danger"></i>
                                                </button>
                                            @endif
                                        @endif
                                    @endif

                                    @if ($tt->trangthai == 'BTLXD')
                                        <button title="Lý do hồ sơ bị trả lại" type="button"
                                            onclick="viewLyDo('{{ $tt->mahosotdkt }}','{{ $inputs['madonvi'] }}', '/XetDuyetHoSoThiDua/LayLyDo' )"
                                            class="btn btn-sm btn-clean btn-icon" data-target="#tralai-modal"
                                            data-toggle="modal">
                                            <i class="icon-lg la fa-archive text-dark"></i>
                                        </button>
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

    {!! Form::open(['url' => '', 'id' => 'frm_delete']) !!}
    <div id="delete-modal-confirm" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <h4 id="modal-header-primary-label" class="modal-title">Đồng ý xoá?</h4>
                    <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                    <input type="hidden" name="mahosotdkt" />
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
                    <button type="submit" data-dismiss="modal" class="btn btn-primary" onclick="clickdelete()">Đồng
                        ý</button>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    <script>
        function confirmDelete(mahosotdkt, url) {
            $('#frm_delete').attr('action', url);
            $('#frm_delete').find("[name='mahosotdkt']").val(mahosotdkt);
        }

        function clickdelete() {
            $('#frm_delete').submit();
        }
    </script>

    @include('NghiepVu.ThiDuaKhenThuong._DungChung.InDuLieu')
    @include('NghiepVu.ThiDuaKhenThuong._DungChung.HoSo_TaoHoSo')
    @include('includes.modal.modal_unapprove_hs')
    @include('includes.modal.modal_accept_hs')
    @include('includes.modal.modal_nhanvatrinhkt_hs')
    @include('includes.modal.modal_attackfile')
    @include('includes.modal.modal-lydo')
@stop