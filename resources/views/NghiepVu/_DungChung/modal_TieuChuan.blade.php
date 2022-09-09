    
    {{-- Thông tin tiêu chuẩn --}}
    <div class="modal fade bs-modal-lg" id="modal-tieuchuan" tabindex="-1" role="dialog" aria-hidden="true">
        <input type="hidden" id="madoituong_tc" name="madoituong_tc" />
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Thông tin tiêu chuẩn của đối tượng</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-control-label">Tên đối tượng</label>
                            {!! Form::text('tendoituong_tc', null, ['id' => 'tendoituong_tc', 'class' => 'form-control']) !!}
                        </div>

                        <div class="col-md-6">
                            <label class="form-control-label">Danh hiệu đăng ký</label>
                            {!! Form::select('madanhhieutd_tc', $a_danhhieutd, null, ['id' => 'madanhhieutd_tc', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                    <hr>
                    <div class="row" id="dstieuchuan">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Thoát</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    
    {{-- Thay đổi tiêu chuẩn --}}
    <div id="modal-luutieuchuan" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade">
        <input type="hidden" id="matieuchuandhtd_ltc" name="matieuchuandhtd_ltc" />
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <h4 id="modal-header-primary-label" class="modal-title">Thông tin đối tượng</h4>
                    <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-control-label">Tên tiêu chuẩn</label>
                                {!! Form::textarea('tentieuchuandhtd_ltc', null, [
                                    'id' => 'tentieuchuandhtd_ltc',
                                    'class' => 'form-control',
                                    'rows' => '3',
                                ]) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-offset-4 col-md-3">
                                <div class="md-checkbox">
                                    <input type="checkbox" id="dieukien_ltc" name="dieukien_ltc" class="md-check">
                                    <label for="dieukien_ltc">
                                        <span></span><span class="check"></span><span class="box"></span>Đủ điều
                                        kiện</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
                    <button type="button" class="btn btn-primary" onclick="LuuTieuChuan()">Cập nhật</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function getTieuChuan(madoituong, madanhhieutd, tendt) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $('#madoituong_tc').val(madoituong);
            $('#tendoituong_tc').val(tendt);
            $('#madanhhieutd_tc').val(madanhhieutd).trigger('change');

            $.ajax({
                url: '/KhenThuongCongTrang/HoSoKhenThuong/LayTieuChuan',
                type: 'GET',
                data: {
                    _token: CSRF_TOKEN,
                    madoituong: madoituong,
                    madanhhieutd: madanhhieutd,
                    madonvi: $('#madonvi').val(),
                    maphongtraotd: $('#frm_ThayDoi').find("[name='maphongtraotd']").val(),
                    mahosotdkt: $('#frm_ThayDoi').find("[name='mahosotdkt']").val()
                },
                dataType: 'JSON',
                success: function(data) {
                    if (data.status == 'success') {
                        $('#dstieuchuan').replaceWith(data.message);
                    }
                }
            })
        }

        function ThayDoiTieuChuan(matieuchuandhtd, tentieuchuandhtd) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $('#tentieuchuandhtd_ltc').val(tentieuchuandhtd);
            $('#matieuchuandhtd_ltc').val(matieuchuandhtd);
        }

        function LuuTieuChuan() {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: '/KhenThuongCongTrang/HoSoKhenThuong/LuuTieuChuan',
                type: 'GET',
                data: {
                    _token: CSRF_TOKEN,
                    madoituong: $('#madoituong_tc').val(),
                    madanhhieutd: $('#madanhhieutd_tc').val(),
                    matieuchuandhtd: $('#matieuchuandhtd_ltc').val(),
                    madonvi: $('#madonvi').val(),
                    maphongtraotd: $('#frm_ThayDoi').find("[name='maphongtraotd']").val(),
                    mahosotdkt: $('#frm_ThayDoi').find("[name='mahosotdkt']").val()
                },
                dataType: 'JSON',
                success: function(data) {
                    if (data.status == 'success') {
                        $('#dstieuchuan').replaceWith(data.message);
                    }
                }
            })
            $('#modal-luutieuchuan').modal("hide");
        }
    </script>
