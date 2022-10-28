    <!--Modal Nhận hồ sơ-->
    {!! Form::open(['url' =>$inputs['url_hs']. 'Them', 'id' => 'frm_hoso']) !!}
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
                        <div class="col-6">
                            <label>Loại hình khen thưởng</label>
                            {!! Form::select('maloaihinhkt', $a_loaihinhkt, $inputs['maloaihinhkt'], ['class' => 'form-control']) !!}
                        </div>

                        <div class="col-6">
                            <label>Trạng thái hồ sơ</label>
                            {!! Form::select('trangthai', getTEST(), $inputs['trangthai'], ['class' => 'form-control'], getTEST_gr()) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-6">
                            <label>Số tờ trình</label>
                            {!! Form::text('sototrinh', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-6">
                            <label>Ngày tạo hồ sơ</label>
                            {!! Form::input('date', 'ngayhoso', date('Y-m-d'), ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-6">
                            <label>Chức vụ người ký tờ trình</label>
                            {!! Form::text('chucvunguoiky', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-6">
                            <label>Họ tên người ký tờ trình</label>
                            {!! Form::text('nguoikytotrinh', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-12">
                            <label>Nội dung trình khen thưởng</label>
                            {!! Form::textarea('noidung', null, ['class' => 'form-control', 'rows' => 3]) !!}
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