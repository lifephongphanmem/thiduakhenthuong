@if (in_array($tt->trangthai_hoso, ['CD']))
    <button title="Tiếp nhận hồ sơ" type="button"
        onclick="confirmNhan('{{ $tt->mahosotdkt }}','{{ $inputs['url_xd'] . 'NhanHoSo' }}','{{ $inputs['madonvi'] }}')"
        class="btn btn-sm btn-clean btn-icon" data-target="#nhan-modal-confirm" data-toggle="modal">
        <i class="icon-lg flaticon-interface-5 text-success"></i>
    </button>
@endif

@if (in_array($tt->trangthai_hoso, ['DTN','CD', 'BTLXD']))
    <button title="Huỷ tiếp nhận và trả lại hồ sơ" type="button"
        onclick="confirmTraLai('{{ $tt->mahosotdkt }}', '{{ $inputs['madonvi'] }}', '{{ $inputs['url_xd'] . 'TraLai' }}')"
        class="btn btn-sm btn-clean btn-icon" data-target="#modal-tralai" data-toggle="modal">
        <i class="icon-lg la la-reply text-danger"></i>
    </button>
@endif

@if (in_array($tt->trangthai_hoso, ['DTN', 'BTLXD']))
    <button title="Chuyển xét duyệt khen thưởng" type="button"
        onclick="confirmTrinhHS('{{ $tt->mahosotdkt }}','{{ $inputs['url_xd'] . 'ChuyenHoSo' }}','{{ $inputs['madonvi'] }}')"
        class="btn btn-sm btn-clean btn-icon" {{ $tt->soluongkhenthuong == 0 ? 'disabled' : '' }}
        data-target="#trinhhs-modal" data-toggle="modal">
        <i class="icon-lg la fa-share-square text-success"></i>
    </button>
@endif
