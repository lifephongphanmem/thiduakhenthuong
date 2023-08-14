@if (in_array($tt->trangthai_hoso, ['CD']))
    <button title="Tiếp nhận hồ sơ" type="button"
        onclick="confirmNhan('{{ $tt->mahosotdkt }}','{{ $inputs['url_xd'] . 'NhanHoSo' }}','{{ $inputs['madonvi'] }}')"
        class="btn btn-sm btn-clean btn-icon" data-target="#nhan-modal-confirm" data-toggle="modal">
        <i class="icon-lg flaticon-interface-5 text-success"></i>
    </button>
@endif

@if (in_array($tt->trangthai_hoso, ['DD', 'BTLXD']))
    <a href="{{ url($inputs['url_xd'] . 'XetKT?mahosotdkt=' . $tt->mahosotdkt . '&madonvi=' . $inputs['madonvi']) }}"
        class="btn btn-icon btn-clean btn-lg mb-1 position-relative" title="Thông tin hồ sơ khen thưởng">
        <span class="svg-icon svg-icon-xl">
            <i class="icon-lg la flaticon-list text-success"></i>
        </span>
        <span
            class="label label-sm label-light-danger text-dark label-rounded font-weight-bolder position-absolute top-0 right-0">{{ $tt->soluongkhenthuong }}</span>
    </a>
    @if (session('admin')->opt_duthaototrinh)
        <a title="Tạo dự thảo quyết định khen thưởng"
            href="{{ url($inputs['url_xd'] . 'QuyetDinh?mahosotdkt=' . $tt->mahosotdkt) }}"
            class="btn btn-sm btn-clean btn-icon {{ $tt->soluongkhenthuong == 0 ? 'disabled' : '' }}">
            <i class="icon-lg la flaticon-edit-1 text-success"></i>
        </a>
    @endif

    <button title="Chuyển phê duyệt khen thưởng" type="button"
        onclick="confirmNhanvaTKT('{{ $tt->mahosotdkt }}','{{ $inputs['url_xd'] . 'ChuyenHoSo' }}','{{ $inputs['madonvi'] }}')"
        class="btn btn-sm btn-clean btn-icon" {{ $tt->soluongkhenthuong == 0 ? 'disabled' : '' }}
        data-target="#nhanvatkt-modal" data-toggle="modal">
        <i class="icon-lg la fa-share-square text-success"></i>
    </button>
@endif

@if ($tt->trangthai_hoso == 'BTLXD')
    <button title="Lý do hồ sơ bị trả lại" type="button"
        onclick="viewLyDo('{{ $tt->mahosotdkt }}','{{ $inputs['madonvi'] }}', '{{ $inputs['url_xd'] . 'LayLyDo' }}')"
        class="btn btn-sm btn-clean btn-icon" data-target="#tralai-modal" data-toggle="modal">
        <i class="icon-lg la fa-archive text-dark"></i>
    </button>
@endif

@if (in_array($tt->trangthai_hoso, ['DD', 'CD', 'BTLXD']))
    <button title="Trả lại hồ sơ" type="button"
        onclick="confirmTraLai('{{ $tt->mahosotdkt }}', '{{ $inputs['madonvi'] }}', '{{ $inputs['url_xd'] . 'TraLai' }}')"
        class="btn btn-sm btn-clean btn-icon" data-target="#modal-tralai" data-toggle="modal">
        <i class="icon-lg la la-reply text-danger"></i>
    </button>
@endif
