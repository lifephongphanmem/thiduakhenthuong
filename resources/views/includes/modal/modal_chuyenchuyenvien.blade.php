<!--Modal Chuyển chuyên viên-->
<div id="modal-chuyenchuyenvien" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade kt_select2_modal">
    {!! Form::open(['url' => '', 'id' => 'frm_chuyenchuyenvien']) !!}
    <input type="hidden" name="mahoso" />
    <input type="hidden" name="madonvi" />
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-primary">
                <h4 id="modal-header-primary-label" class="modal-title">Chuyển hồ sơ cho chuyên viên xử lý
                </h4>
                <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>

            </div>
            <div class="modal-body">                
                <div class="form-group row">
                    <div class="col-md-12">
                        <label class="control-label">Chuyên viên</label>
                        {!! Form::select('tendangnhap_xd', $a_taikhoanchuyenvien, null, ['class' => 'form-control select2_modal']) !!}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
                <button type="submit" data-dismiss="modal" class="btn btn-primary" onclick="clickChuyenChuyenVien()">Đồng
                    ý</button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>

<!--Modal Xử lý hồ sơ-->
<div id="modal-xulyhoso" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade kt_select2_modal">
    {!! Form::open(['url' => '', 'id' => 'frm_xulyhoso']) !!}
    <input type="hidden" name="mahoso" />
    <input type="hidden" name="madonvi" />
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-primary">
                <h4 id="modal-header-primary-label" class="modal-title">Thông tin xử lý hồ sơ
                </h4>
                <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>

            </div>
            <div class="modal-body">                
                <div class="form-group row">
                    <div class="col-md-12">
                        <label class="control-label">Trạng thái hồ sơ</label>
                        {!! Form::select('trangthai', getTrangThaiXuLyHoSo(), null, ['class' => 'form-control select2_modal']) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-12">
                        <label class=" control-label">Diễn giải nội dung</label>
                        {!! Form::textarea('noidungxuly_xd', null, ['rows' => 3, 'cols' => 10, 'class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
                <button type="submit" data-dismiss="modal" class="btn btn-primary" onclick="clickXuLyHoSo()">Đồng
                    ý</button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>

{{-- Chi tiết xử lý hồ sơ --}}
<div id="modal-layxulyhoso" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade kt_select2_modal">
    {!! Form::open(['url' => '', 'id' => 'frm_layxulyhoso']) !!}
    <input type="hidden" name="mahoso" />
    <input type="hidden" name="madonvi" />
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-primary">
                <h4 id="modal-header-primary-label" class="modal-title">Thông tin xử lý hồ sơ
                </h4>
                <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>

            </div>
            <div class="modal-body">  
                <div class="form-group row">
                    <div class="col-md-12">
                        <label class="control-label">Chuyên viên</label>
                        {!! Form::select('tendangnhap_xd', $a_taikhoanchuyenvien, null, ['class' => 'form-control select2_modal']) !!}
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-12">
                        <label class="control-label">Trạng thái hồ sơ</label>
                        {!! Form::select('trangthai', getTrangThaiXuLyHoSo(), null, ['class' => 'form-control select2_modal']) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-12">
                        <label class=" control-label">Diễn giải nội dung</label>
                        {!! Form::textarea('noidungxuly_xd', null, ['rows' => 3, 'cols' => 10, 'class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>                
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>

<script>
    function clickChuyenChuyenVien() {
        $('#frm_chuyenchuyenvien').submit();
    }

    function confirmChuyenChuyenVien(mahs, madonvi, url) {
        $('#frm_chuyenchuyenvien').attr('action', url);
        $('#frm_chuyenchuyenvien').find("[name='mahoso']").val(mahs);
        $('#frm_chuyenchuyenvien').find("[name='madonvi']").val(madonvi);
    }

    function clickXuLyHoSo() {
        $('#frm_xulyhoso').submit();
    }

    function confirmXuLyHoSo(mahs, madonvi, url) {
        $('#frm_xulyhoso').attr('action', url);
        $('#frm_xulyhoso').find("[name='mahoso']").val(mahs);
        $('#frm_xulyhoso').find("[name='madonvi']").val(madonvi);
    }

    function viewXuLyHoSo(tendangnhap_xd, trangthai, noidungxuly_xd){
        $('#frm_layxulyhoso').find("[name='tendangnhap_xd']").val(tendangnhap_xd).trigger('change');
        $('#frm_layxulyhoso').find("[name='trangthai']").val(trangthai).trigger('change');
        $('#frm_layxulyhoso').find("[name='noidungxuly_xd']").val(noidungxuly_xd);
    }


</script>
