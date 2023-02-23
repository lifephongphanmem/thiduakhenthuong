<a title="Thông tin hồ sơ" href="{{ url($inputs['url_hs'] . 'Sua?mahosotdkt=' . $tt->mahosotdkt) }}"
    class="btn btn-sm btn-clean btn-icon">
    <i class="icon-lg la flaticon-edit-1 text-success"></i>
</a>

<a title="Tạo dự thảo tờ trình" href="{{ url($inputs['url_hs'] . 'ToTrinhHoSo?mahosotdkt=' . $tt->mahosotdkt) }}"
    class="btn btn-sm btn-clean btn-icon {{ $tt->soluongkhenthuong == 0 ? 'disabled' : '' }}">
    <i class="icon-lg la flaticon-edit-1 text-success"></i>
</a>

@if ($tt->trangthai == 'BTL')
    <button title="Lý do hồ sơ bị trả lại" type="button"
        onclick="viewLyDo('{{ $tt->mahosotdkt }}','{{ $inputs['madonvi'] }}', '{{ $inputs['url_hs'] . 'LayLyDo' }}')"
        class="btn btn-sm btn-clean btn-icon" data-target="#tralai-modal" data-toggle="modal">
        <i class="icon-lg la fa-archive text-info"></i>
    </button>
@endif
<button title="Trình hồ sơ đăng ký" type="button"
    onclick="confirmChuyen('{{ $tt->mahosotdkt }}','{{ $inputs['url_hs'] . 'ChuyenHoSo' }}', '{{ $tt->phanloai }}','{{ $tt->madonvi_xd }}')"
    class="btn btn-sm btn-clean btn-icon">
    <i class="icon-lg la fa-share text-primary"></i>
</button>

<button type="button" onclick="confirmDelete('{{ $tt->id }}','{{ $inputs['url_hs'] . 'Xoa' }}')"
    class="btn btn-sm btn-clean btn-icon" data-target="#delete-modal-confirm" data-toggle="modal">
    <i class="icon-lg la fa-trash text-danger"></i>
</button>
