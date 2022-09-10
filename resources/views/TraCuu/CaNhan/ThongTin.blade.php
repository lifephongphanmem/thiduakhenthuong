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
            TableManagedclass.init();
        });
    </script>
@stop

@section('content')
    <!--begin::Card-->
    {!! Form::open([
        'method' => 'POST',
        'url' => '/TraCuu/CaNhan/ThongTin',
        'class' => 'form',
        'id' => 'frm_ThayDoi',
        'files' => true,
        'enctype' => 'multipart/form-data',
    ]) !!}
    <div class="card card-custom wave wave-animate-slow wave-info">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Thông tin tìm kiếm theo cá nhân</h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                <!--end::Button-->
            </div>
        </div>

        <div class="card-body">

            <div class="form-group row">
                <div class="col-4">
                    <label class="form-control-label">Tên đối tượng</label>
                    {!! Form::text('tendoituong', null, ['id' => 'tendoituong', 'class' => 'form-control']) !!}
                </div>

                <div class="col-4">
                    <label class="form-control-label">Tên phòng ban làm việc</label>
                    {!! Form::text('tendoituong', null, ['id' => 'tendoituong', 'class' => 'form-control']) !!}
                </div>

                <div class="col-4">
                    <label>Tên đơn vị công tác</label>
                    {!! Form::text('tendonvi', null, ['class' => 'form-control', 'readonly' => 'true']) !!}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-2">
                    <label>Khen thưởng - Từ</label>
                    {!! Form::input('date', 'ngaytu', null, ['class' => 'form-control']) !!}
                </div>
                <div class="col-lg-2">
                    <label>Khen thưởng - Đến</label>
                    {!! Form::input('date', 'ngayden', null, ['class' => 'form-control']) !!}
                </div>

                <div class="col-md-2">
                    <label class="form-control-label">Giới tính</label>
                    {!! Form::select('gioitinh', getGioiTinh(), null, ['id' => 'gioitinh', 'class' => 'form-control']) !!}
                </div>

                <div class="col-md-6">
                    <label class="form-control-label">Phân loại cán bộ</label>
                    {!! Form::select('gioitinh', getGioiTinh(), null, ['id' => 'gioitinh', 'class' => 'form-control']) !!}
                </div>
            </div>

            <div class="row" style="display: block;" id="frm_tths">
                <div class="row" style="">
                <div class="col-xl-12">
                    <div class="card card-custom gutter-b example example-compact" style="border: 1px solid #60aee4;">
                        <div class="card-header">               
                            <div class="checkbox-inline">
                                <label class="checkbox checkbox-lg">
                                    <input type="checkbox" data-val="true" data-val-required="The LT field is required." id="LT" name="LT" value="true"><span></span>
                                    <label class="card-title">
                                         <span class="label label-danger label-dot mr-2"></span>
                                        Hoạt động cách mạng trước ngày 01 tháng 01 năm 1945
                                    </label>
                                </label>
                            </div>
                            <div class="card-toolbar">
                                <button type="button" class="btn btn-clean btn-sm btn-icon" id="btn_ttlt" title="Thu gọn/ Hiển thị">
                                    <i class="ki ki-bold-more-hor"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body" style="display: none;" id="frm_lt">
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>Ngày vào Đảng:</label>
                                        <div class="input-group">
                                            <select class="form-control" id="LTNgayVaoDang" name="LTNgayVaoDang">
                                                <option value="">---Chọn ngày---</option>
                                                    <option value="01">01</option>
                                                    <option value="02">02</option>
                                                    <option value="03">03</option>
                                                    <option value="04">04</option>
                                                    <option value="05">05</option>
                                                    <option value="06">06</option>
                                                    <option value="07">07</option>
                                                    <option value="08">08</option>
                                                    <option value="09">09</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                    <option value="12">12</option>
                                                    <option value="13">13</option>
                                                    <option value="14">14</option>
                                                    <option value="15">15</option>
                                                    <option value="16">16</option>
                                                    <option value="17">17</option>
                                                    <option value="18">18</option>
                                                    <option value="19">19</option>
                                                    <option value="20">20</option>
                                                    <option value="21">21</option>
                                                    <option value="22">22</option>
                                                    <option value="23">23</option>
                                                    <option value="24">24</option>
                                                    <option value="25">25</option>
                                                    <option value="26">26</option>
                                                    <option value="27">27</option>
                                                    <option value="28">28</option>
                                                    <option value="29">29</option>
                                                    <option value="30">30</option>
                                                    <option value="31">31</option>
                                            </select>
                                            <select class="form-control" id="LTThangVaoDang" name="LTThangVaoDang">
                                                <option value="">---Chọn tháng---</option>
                                                    <option value="01">01</option>
                                                    <option value="02">02</option>
                                                    <option value="03">03</option>
                                                    <option value="04">04</option>
                                                    <option value="05">05</option>
                                                    <option value="06">06</option>
                                                    <option value="07">07</option>
                                                    <option value="08">08</option>
                                                    <option value="09">09</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                    <option value="12">12</option>
                                            </select>
                                            <select class="form-control" id="LTNamVaoDang" name="LTNamVaoDang">
                                                <option value="">---Chọn năm---</option>
                                                    <option value="1900">1900</option>
                                                    <option value="1901">1901</option>
                                                    <option value="1902">1902</option>
                                                    <option value="1903">1903</option>
                                                    <option value="1904">1904</option>
                                                    <option value="1905">1905</option>
                                                    <option value="1906">1906</option>
                                                    <option value="1907">1907</option>
                                                    <option value="1908">1908</option>
                                                    <option value="1909">1909</option>
                                                    <option value="1910">1910</option>
                                                    <option value="1911">1911</option>
                                                    <option value="1912">1912</option>
                                                    <option value="1913">1913</option>
                                                    <option value="1914">1914</option>
                                                    <option value="1915">1915</option>
                                                    <option value="1916">1916</option>
                                                    <option value="1917">1917</option>
                                                    <option value="1918">1918</option>
                                                    <option value="1919">1919</option>
                                                    <option value="1920">1920</option>
                                                    <option value="1921">1921</option>
                                                    <option value="1922">1922</option>
                                                    <option value="1923">1923</option>
                                                    <option value="1924">1924</option>
                                                    <option value="1925">1925</option>
                                                    <option value="1926">1926</option>
                                                    <option value="1927">1927</option>
                                                    <option value="1928">1928</option>
                                                    <option value="1929">1929</option>
                                                    <option value="1930">1930</option>
                                                    <option value="1931">1931</option>
                                                    <option value="1932">1932</option>
                                                    <option value="1933">1933</option>
                                                    <option value="1934">1934</option>
                                                    <option value="1935">1935</option>
                                                    <option value="1936">1936</option>
                                                    <option value="1937">1937</option>
                                                    <option value="1938">1938</option>
                                                    <option value="1939">1939</option>
                                                    <option value="1940">1940</option>
                                                    <option value="1941">1941</option>
                                                    <option value="1942">1942</option>
                                                    <option value="1943">1943</option>
                                                    <option value="1944">1944</option>
                                                    <option value="1945">1945</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>Ngày chính thức vào Đảng: </label>
                                        <div class="checkbox-inline">
                                            <div class="input-group">
                                                <select class="form-control" id="LTNgayChinhThucDang" name="LTNgayChinhThucDang">
                                                    <option value="">---Chọn ngày---</option>
                                                        <option value="01">01</option>
                                                        <option value="02">02</option>
                                                        <option value="03">03</option>
                                                        <option value="04">04</option>
                                                        <option value="05">05</option>
                                                        <option value="06">06</option>
                                                        <option value="07">07</option>
                                                        <option value="08">08</option>
                                                        <option value="09">09</option>
                                                        <option value="10">10</option>
                                                        <option value="11">11</option>
                                                        <option value="12">12</option>
                                                        <option value="13">13</option>
                                                        <option value="14">14</option>
                                                        <option value="15">15</option>
                                                        <option value="16">16</option>
                                                        <option value="17">17</option>
                                                        <option value="18">18</option>
                                                        <option value="19">19</option>
                                                        <option value="20">20</option>
                                                        <option value="21">21</option>
                                                        <option value="22">22</option>
                                                        <option value="23">23</option>
                                                        <option value="24">24</option>
                                                        <option value="25">25</option>
                                                        <option value="26">26</option>
                                                        <option value="27">27</option>
                                                        <option value="28">28</option>
                                                        <option value="29">29</option>
                                                        <option value="30">30</option>
                                                        <option value="31">31</option>
                                                </select>
                                                <select class="form-control" id="LTThangChinhThucDang" name="LTThangChinhThucDang">
                                                    <option value="">---Chọn tháng---</option>
                                                        <option value="01">01</option>
                                                        <option value="02">02</option>
                                                        <option value="03">03</option>
                                                        <option value="04">04</option>
                                                        <option value="05">05</option>
                                                        <option value="06">06</option>
                                                        <option value="07">07</option>
                                                        <option value="08">08</option>
                                                        <option value="09">09</option>
                                                        <option value="10">10</option>
                                                        <option value="11">11</option>
                                                        <option value="12">12</option>
                                                </select>
                                                <select class="form-control" id="LTNamChinhThucDang" name="LTNamChinhThucDang">
                                                    <option value="">---Chọn năm---</option>
                                                        <option value="1900">1900</option>
                                                        <option value="1901">1901</option>
                                                        <option value="1902">1902</option>
                                                        <option value="1903">1903</option>
                                                        <option value="1904">1904</option>
                                                        <option value="1905">1905</option>
                                                        <option value="1906">1906</option>
                                                        <option value="1907">1907</option>
                                                        <option value="1908">1908</option>
                                                        <option value="1909">1909</option>
                                                        <option value="1910">1910</option>
                                                        <option value="1911">1911</option>
                                                        <option value="1912">1912</option>
                                                        <option value="1913">1913</option>
                                                        <option value="1914">1914</option>
                                                        <option value="1915">1915</option>
                                                        <option value="1916">1916</option>
                                                        <option value="1917">1917</option>
                                                        <option value="1918">1918</option>
                                                        <option value="1919">1919</option>
                                                        <option value="1920">1920</option>
                                                        <option value="1921">1921</option>
                                                        <option value="1922">1922</option>
                                                        <option value="1923">1923</option>
                                                        <option value="1924">1924</option>
                                                        <option value="1925">1925</option>
                                                        <option value="1926">1926</option>
                                                        <option value="1927">1927</option>
                                                        <option value="1928">1928</option>
                                                        <option value="1929">1929</option>
                                                        <option value="1930">1930</option>
                                                        <option value="1931">1931</option>
                                                        <option value="1932">1932</option>
                                                        <option value="1933">1933</option>
                                                        <option value="1934">1934</option>
                                                        <option value="1935">1935</option>
                                                        <option value="1936">1936</option>
                                                        <option value="1937">1937</option>
                                                        <option value="1938">1938</option>
                                                        <option value="1939">1939</option>
                                                        <option value="1940">1940</option>
                                                        <option value="1941">1941</option>
                                                        <option value="1942">1942</option>
                                                        <option value="1943">1943</option>
                                                        <option value="1944">1944</option>
                                                        <option value="1945">1945</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>Nguyên là: </label>
                                        <input type="text" class="form-control" id="LTNguyenLa" name="LTNguyenLa" value="">
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>Cơ quan, đơn vị: </label>
                                        <input type="text" class="form-control" id="LTCoQuanDonVi" name="LTCoQuanDonVi" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>Tham gia CM từ ngày:</label>
                                        <div class="input-group">
                                            <select class="form-control" id="LTCMTuNgay" name="LTCMTuNgay">
                                                <option value="">---Chọn ngày---</option>
                                                    <option value="01">01</option>
                                                    <option value="02">02</option>
                                                    <option value="03">03</option>
                                                    <option value="04">04</option>
                                                    <option value="05">05</option>
                                                    <option value="06">06</option>
                                                    <option value="07">07</option>
                                                    <option value="08">08</option>
                                                    <option value="09">09</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                    <option value="12">12</option>
                                                    <option value="13">13</option>
                                                    <option value="14">14</option>
                                                    <option value="15">15</option>
                                                    <option value="16">16</option>
                                                    <option value="17">17</option>
                                                    <option value="18">18</option>
                                                    <option value="19">19</option>
                                                    <option value="20">20</option>
                                                    <option value="21">21</option>
                                                    <option value="22">22</option>
                                                    <option value="23">23</option>
                                                    <option value="24">24</option>
                                                    <option value="25">25</option>
                                                    <option value="26">26</option>
                                                    <option value="27">27</option>
                                                    <option value="28">28</option>
                                                    <option value="29">29</option>
                                                    <option value="30">30</option>
                                                    <option value="31">31</option>
                                            </select>
                                            <select class="form-control" id="LTCMTuThang" name="LTCMTuThang">
                                                <option value="">---Chọn tháng---</option>
                                                    <option value="01">01</option>
                                                    <option value="02">02</option>
                                                    <option value="03">03</option>
                                                    <option value="04">04</option>
                                                    <option value="05">05</option>
                                                    <option value="06">06</option>
                                                    <option value="07">07</option>
                                                    <option value="08">08</option>
                                                    <option value="09">09</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                    <option value="12">12</option>
                                            </select>
                                            <select class="form-control" id="LTCMTuNam" name="LTCMTuNam">
                                                <option value="">---Chọn năm---</option>
                                                    <option value="1900">1900</option>
                                                    <option value="1901">1901</option>
                                                    <option value="1902">1902</option>
                                                    <option value="1903">1903</option>
                                                    <option value="1904">1904</option>
                                                    <option value="1905">1905</option>
                                                    <option value="1906">1906</option>
                                                    <option value="1907">1907</option>
                                                    <option value="1908">1908</option>
                                                    <option value="1909">1909</option>
                                                    <option value="1910">1910</option>
                                                    <option value="1911">1911</option>
                                                    <option value="1912">1912</option>
                                                    <option value="1913">1913</option>
                                                    <option value="1914">1914</option>
                                                    <option value="1915">1915</option>
                                                    <option value="1916">1916</option>
                                                    <option value="1917">1917</option>
                                                    <option value="1918">1918</option>
                                                    <option value="1919">1919</option>
                                                    <option value="1920">1920</option>
                                                    <option value="1921">1921</option>
                                                    <option value="1922">1922</option>
                                                    <option value="1923">1923</option>
                                                    <option value="1924">1924</option>
                                                    <option value="1925">1925</option>
                                                    <option value="1926">1926</option>
                                                    <option value="1927">1927</option>
                                                    <option value="1928">1928</option>
                                                    <option value="1929">1929</option>
                                                    <option value="1930">1930</option>
                                                    <option value="1931">1931</option>
                                                    <option value="1932">1932</option>
                                                    <option value="1933">1933</option>
                                                    <option value="1934">1934</option>
                                                    <option value="1935">1935</option>
                                                    <option value="1936">1936</option>
                                                    <option value="1937">1937</option>
                                                    <option value="1938">1938</option>
                                                    <option value="1939">1939</option>
                                                    <option value="1940">1940</option>
                                                    <option value="1941">1941</option>
                                                    <option value="1942">1942</option>
                                                    <option value="1943">1943</option>
                                                    <option value="1944">1944</option>
                                                    <option value="1945">1945</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>Tham gia CM đến ngày:</label>
                                        <div class="input-group">
                                            <select class="form-control" id="LTCMDenNgay" name="LTCMDenNgay">
                                                <option value="">---Chọn ngày---</option>
                                                    <option value="01">01</option>
                                                    <option value="02">02</option>
                                                    <option value="03">03</option>
                                                    <option value="04">04</option>
                                                    <option value="05">05</option>
                                                    <option value="06">06</option>
                                                    <option value="07">07</option>
                                                    <option value="08">08</option>
                                                    <option value="09">09</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                    <option value="12">12</option>
                                                    <option value="13">13</option>
                                                    <option value="14">14</option>
                                                    <option value="15">15</option>
                                                    <option value="16">16</option>
                                                    <option value="17">17</option>
                                                    <option value="18">18</option>
                                                    <option value="19">19</option>
                                                    <option value="20">20</option>
                                                    <option value="21">21</option>
                                                    <option value="22">22</option>
                                                    <option value="23">23</option>
                                                    <option value="24">24</option>
                                                    <option value="25">25</option>
                                                    <option value="26">26</option>
                                                    <option value="27">27</option>
                                                    <option value="28">28</option>
                                                    <option value="29">29</option>
                                                    <option value="30">30</option>
                                                    <option value="31">31</option>
                                            </select>
                                            <select class="form-control" id="LTCMDenThang" name="LTCMDenThang">
                                                <option value="">---Chọn tháng---</option>
                                                    <option value="01">01</option>
                                                    <option value="02">02</option>
                                                    <option value="03">03</option>
                                                    <option value="04">04</option>
                                                    <option value="05">05</option>
                                                    <option value="06">06</option>
                                                    <option value="07">07</option>
                                                    <option value="08">08</option>
                                                    <option value="09">09</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                    <option value="12">12</option>
                                            </select>
                                            <select class="form-control" id="LTCMDenNam" name="LTCMDenNam">
                                                <option value="">---Chọn năm---</option>
                                                    <option value="1900">1900</option>
                                                    <option value="1901">1901</option>
                                                    <option value="1902">1902</option>
                                                    <option value="1903">1903</option>
                                                    <option value="1904">1904</option>
                                                    <option value="1905">1905</option>
                                                    <option value="1906">1906</option>
                                                    <option value="1907">1907</option>
                                                    <option value="1908">1908</option>
                                                    <option value="1909">1909</option>
                                                    <option value="1910">1910</option>
                                                    <option value="1911">1911</option>
                                                    <option value="1912">1912</option>
                                                    <option value="1913">1913</option>
                                                    <option value="1914">1914</option>
                                                    <option value="1915">1915</option>
                                                    <option value="1916">1916</option>
                                                    <option value="1917">1917</option>
                                                    <option value="1918">1918</option>
                                                    <option value="1919">1919</option>
                                                    <option value="1920">1920</option>
                                                    <option value="1921">1921</option>
                                                    <option value="1922">1922</option>
                                                    <option value="1923">1923</option>
                                                    <option value="1924">1924</option>
                                                    <option value="1925">1925</option>
                                                    <option value="1926">1926</option>
                                                    <option value="1927">1927</option>
                                                    <option value="1928">1928</option>
                                                    <option value="1929">1929</option>
                                                    <option value="1930">1930</option>
                                                    <option value="1931">1931</option>
                                                    <option value="1932">1932</option>
                                                    <option value="1933">1933</option>
                                                    <option value="1934">1934</option>
                                                    <option value="1935">1935</option>
                                                    <option value="1936">1936</option>
                                                    <option value="1937">1937</option>
                                                    <option value="1938">1938</option>
                                                    <option value="1939">1939</option>
                                                    <option value="1940">1940</option>
                                                    <option value="1941">1941</option>
                                                    <option value="1942">1942</option>
                                                    <option value="1943">1943</option>
                                                    <option value="1944">1944</option>
                                                    <option value="1945">1945</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>Ngày nghỉ hưu:</label>
                                        <div class="input-group">
                                            <select class="form-control" id="LTNgayNghiHuu" name="LTNgayNghiHuu">
                                                <option value="">---Chọn ngày---</option>
                                                    <option value="01">01</option>
                                                    <option value="02">02</option>
                                                    <option value="03">03</option>
                                                    <option value="04">04</option>
                                                    <option value="05">05</option>
                                                    <option value="06">06</option>
                                                    <option value="07">07</option>
                                                    <option value="08">08</option>
                                                    <option value="09">09</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                    <option value="12">12</option>
                                                    <option value="13">13</option>
                                                    <option value="14">14</option>
                                                    <option value="15">15</option>
                                                    <option value="16">16</option>
                                                    <option value="17">17</option>
                                                    <option value="18">18</option>
                                                    <option value="19">19</option>
                                                    <option value="20">20</option>
                                                    <option value="21">21</option>
                                                    <option value="22">22</option>
                                                    <option value="23">23</option>
                                                    <option value="24">24</option>
                                                    <option value="25">25</option>
                                                    <option value="26">26</option>
                                                    <option value="27">27</option>
                                                    <option value="28">28</option>
                                                    <option value="29">29</option>
                                                    <option value="30">30</option>
                                                    <option value="31">31</option>
                                            </select>
                                            <select class="form-control" id="LTThangNghiHuu" name="LTThangNghiHuu">
                                                <option value="">---Chọn tháng---</option>
                                                    <option value="01">01</option>
                                                    <option value="02">02</option>
                                                    <option value="03">03</option>
                                                    <option value="04">04</option>
                                                    <option value="05">05</option>
                                                    <option value="06">06</option>
                                                    <option value="07">07</option>
                                                    <option value="08">08</option>
                                                    <option value="09">09</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                    <option value="12">12</option>
                                            </select>
                                            <select class="form-control" id="LTNamNghiHuu" name="LTNamNghiHuu">
                                                <option value="">---Chọn năm---</option>
                                                    <option value="1900">1900</option>
                                                    <option value="1901">1901</option>
                                                    <option value="1902">1902</option>
                                                    <option value="1903">1903</option>
                                                    <option value="1904">1904</option>
                                                    <option value="1905">1905</option>
                                                    <option value="1906">1906</option>
                                                    <option value="1907">1907</option>
                                                    <option value="1908">1908</option>
                                                    <option value="1909">1909</option>
                                                    <option value="1910">1910</option>
                                                    <option value="1911">1911</option>
                                                    <option value="1912">1912</option>
                                                    <option value="1913">1913</option>
                                                    <option value="1914">1914</option>
                                                    <option value="1915">1915</option>
                                                    <option value="1916">1916</option>
                                                    <option value="1917">1917</option>
                                                    <option value="1918">1918</option>
                                                    <option value="1919">1919</option>
                                                    <option value="1920">1920</option>
                                                    <option value="1921">1921</option>
                                                    <option value="1922">1922</option>
                                                    <option value="1923">1923</option>
                                                    <option value="1924">1924</option>
                                                    <option value="1925">1925</option>
                                                    <option value="1926">1926</option>
                                                    <option value="1927">1927</option>
                                                    <option value="1928">1928</option>
                                                    <option value="1929">1929</option>
                                                    <option value="1930">1930</option>
                                                    <option value="1931">1931</option>
                                                    <option value="1932">1932</option>
                                                    <option value="1933">1933</option>
                                                    <option value="1934">1934</option>
                                                    <option value="1935">1935</option>
                                                    <option value="1936">1936</option>
                                                    <option value="1937">1937</option>
                                                    <option value="1938">1938</option>
                                                    <option value="1939">1939</option>
                                                    <option value="1940">1940</option>
                                                    <option value="1941">1941</option>
                                                    <option value="1942">1942</option>
                                                    <option value="1943">1943</option>
                                                    <option value="1944">1944</option>
                                                    <option value="1945">1945</option>
                                                    <option value="1946">1946</option>
                                                    <option value="1947">1947</option>
                                                    <option value="1948">1948</option>
                                                    <option value="1949">1949</option>
                                                    <option value="1950">1950</option>
                                                    <option value="1951">1951</option>
                                                    <option value="1952">1952</option>
                                                    <option value="1953">1953</option>
                                                    <option value="1954">1954</option>
                                                    <option value="1955">1955</option>
                                                    <option value="1956">1956</option>
                                                    <option value="1957">1957</option>
                                                    <option value="1958">1958</option>
                                                    <option value="1959">1959</option>
                                                    <option value="1960">1960</option>
                                                    <option value="1961">1961</option>
                                                    <option value="1962">1962</option>
                                                    <option value="1963">1963</option>
                                                    <option value="1964">1964</option>
                                                    <option value="1965">1965</option>
                                                    <option value="1966">1966</option>
                                                    <option value="1967">1967</option>
                                                    <option value="1968">1968</option>
                                                    <option value="1969">1969</option>
                                                    <option value="1970">1970</option>
                                                    <option value="1971">1971</option>
                                                    <option value="1972">1972</option>
                                                    <option value="1973">1973</option>
                                                    <option value="1974">1974</option>
                                                    <option value="1975">1975</option>
                                                    <option value="1976">1976</option>
                                                    <option value="1977">1977</option>
                                                    <option value="1978">1978</option>
                                                    <option value="1979">1979</option>
                                                    <option value="1980">1980</option>
                                                    <option value="1981">1981</option>
                                                    <option value="1982">1982</option>
                                                    <option value="1983">1983</option>
                                                    <option value="1984">1984</option>
                                                    <option value="1985">1985</option>
                                                    <option value="1986">1986</option>
                                                    <option value="1987">1987</option>
                                                    <option value="1988">1988</option>
                                                    <option value="1989">1989</option>
                                                    <option value="1990">1990</option>
                                                    <option value="1991">1991</option>
                                                    <option value="1992">1992</option>
                                                    <option value="1993">1993</option>
                                                    <option value="1994">1994</option>
                                                    <option value="1995">1995</option>
                                                    <option value="1996">1996</option>
                                                    <option value="1997">1997</option>
                                                    <option value="1998">1998</option>
                                                    <option value="1999">1999</option>
                                                    <option value="2000">2000</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>Thâm niên </label>
                                        <input type="number" step="0.1" class="form-control" data-val="true" data-val-number="The field ThamNien must be a number." data-val-required="The ThamNien field is required." id="ThamNien" name="ThamNien" value="1">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                document.getElementById('LT').onclick = function (e) {
                    if (this.checked) {
                        document.getElementById("frm_lt").style.display = "block";
                    }
                    else {
                        document.getElementById("frm_lt").style.display = "none";
                    }
                };
                document.getElementById("btn_ttlt").onclick = function (e) {
                    var x = document.getElementById("frm_lt").style.display;
                    if (x == "none") {
                        document.getElementById("frm_lt").style.display = "block";
                    }
                    else {
                        document.getElementById("frm_lt").style.display = "none";
                    }
                };
            </script>
                <div class="row" style="">
                <div class="col-xl-12">
                    <div class="card card-custom gutter-b example example-compact" style="border: 1px solid #60aee4;">
                        <div class="card-header">
                            <div class="checkbox-inline">
                                <label class="checkbox checkbox-lg">
                                    <input type="checkbox" data-val="true" data-val-required="The TKN field is required." id="TKN" name="TKN" value="true"><span></span>
                                    <label class="card-title">
                                         <span class="label label-danger label-dot mr-2"></span>
                                        Hoạt động cách mạng từ ngày 01 tháng 01 năm 1945 đến Cách mạng Tháng Tám
                                    </label>
                                </label>
                            </div>
                            <div class="card-toolbar">
                                <button type="button" class="btn btn-clean btn-sm btn-icon" id="btn_tttkn" title="Thu gọn/ Hiển thị">
                                    <i class="ki ki-bold-more-hor"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body" style="display: none" id="frm_tkn">
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>Ngày vào Đảng:</label>
                                        <div class="input-group">
                                            <select class="form-control" id="TKNNgayVaoDang" name="TKNNgayVaoDang">
                                                <option value="">---Chọn ngày---</option>
                                                    <option value="01">01</option>
                                                    <option value="02">02</option>
                                                    <option value="03">03</option>
                                                    <option value="04">04</option>
                                                    <option value="05">05</option>
                                                    <option value="06">06</option>
                                                    <option value="07">07</option>
                                                    <option value="08">08</option>
                                                    <option value="09">09</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                    <option value="12">12</option>
                                                    <option value="13">13</option>
                                                    <option value="14">14</option>
                                                    <option value="15">15</option>
                                                    <option value="16">16</option>
                                                    <option value="17">17</option>
                                                    <option value="18">18</option>
                                                    <option value="19">19</option>
                                                    <option value="20">20</option>
                                                    <option value="21">21</option>
                                                    <option value="22">22</option>
                                                    <option value="23">23</option>
                                                    <option value="24">24</option>
                                                    <option value="25">25</option>
                                                    <option value="26">26</option>
                                                    <option value="27">27</option>
                                                    <option value="28">28</option>
                                                    <option value="29">29</option>
                                                    <option value="30">30</option>
                                                    <option value="31">31</option>
                                            </select>
                                            <select class="form-control" id="TKNThangVaoDang" name="TKNThangVaoDang">
                                                <option value="">---Chọn tháng---</option>
                                                    <option value="01">01</option>
                                                    <option value="02">02</option>
                                                    <option value="03">03</option>
                                                    <option value="04">04</option>
                                                    <option value="05">05</option>
                                                    <option value="06">06</option>
                                                    <option value="07">07</option>
                                                    <option value="08">08</option>
                                                    <option value="09">09</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                    <option value="12">12</option>
                                            </select>
                                            <select class="form-control" id="TKNNamVaoDang" name="TKNNamVaoDang">
                                                <option value="">---Chọn năm---</option>
                                                    <option value="1900">1900</option>
                                                    <option value="1901">1901</option>
                                                    <option value="1902">1902</option>
                                                    <option value="1903">1903</option>
                                                    <option value="1904">1904</option>
                                                    <option value="1905">1905</option>
                                                    <option value="1906">1906</option>
                                                    <option value="1907">1907</option>
                                                    <option value="1908">1908</option>
                                                    <option value="1909">1909</option>
                                                    <option value="1910">1910</option>
                                                    <option value="1911">1911</option>
                                                    <option value="1912">1912</option>
                                                    <option value="1913">1913</option>
                                                    <option value="1914">1914</option>
                                                    <option value="1915">1915</option>
                                                    <option value="1916">1916</option>
                                                    <option value="1917">1917</option>
                                                    <option value="1918">1918</option>
                                                    <option value="1919">1919</option>
                                                    <option value="1920">1920</option>
                                                    <option value="1921">1921</option>
                                                    <option value="1922">1922</option>
                                                    <option value="1923">1923</option>
                                                    <option value="1924">1924</option>
                                                    <option value="1925">1925</option>
                                                    <option value="1926">1926</option>
                                                    <option value="1927">1927</option>
                                                    <option value="1928">1928</option>
                                                    <option value="1929">1929</option>
                                                    <option value="1930">1930</option>
                                                    <option value="1931">1931</option>
                                                    <option value="1932">1932</option>
                                                    <option value="1933">1933</option>
                                                    <option value="1934">1934</option>
                                                    <option value="1935">1935</option>
                                                    <option value="1936">1936</option>
                                                    <option value="1937">1937</option>
                                                    <option value="1938">1938</option>
                                                    <option value="1939">1939</option>
                                                    <option value="1940">1940</option>
                                                    <option value="1941">1941</option>
                                                    <option value="1942">1942</option>
                                                    <option value="1943">1943</option>
                                                    <option value="1944">1944</option>
                                                    <option value="1945">1945</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>Ngày chính thức vào Đảng: </label>
                                        <div class="checkbox-inline">
                                            <div class="input-group">
                                                <select class="form-control" id="TKNNgayChinhThucDang" name="TKNNgayChinhThucDang">
                                                    <option value="">---Chọn ngày---</option>
                                                        <option value="01">01</option>
                                                        <option value="02">02</option>
                                                        <option value="03">03</option>
                                                        <option value="04">04</option>
                                                        <option value="05">05</option>
                                                        <option value="06">06</option>
                                                        <option value="07">07</option>
                                                        <option value="08">08</option>
                                                        <option value="09">09</option>
                                                        <option value="10">10</option>
                                                        <option value="11">11</option>
                                                        <option value="12">12</option>
                                                        <option value="13">13</option>
                                                        <option value="14">14</option>
                                                        <option value="15">15</option>
                                                        <option value="16">16</option>
                                                        <option value="17">17</option>
                                                        <option value="18">18</option>
                                                        <option value="19">19</option>
                                                        <option value="20">20</option>
                                                        <option value="21">21</option>
                                                        <option value="22">22</option>
                                                        <option value="23">23</option>
                                                        <option value="24">24</option>
                                                        <option value="25">25</option>
                                                        <option value="26">26</option>
                                                        <option value="27">27</option>
                                                        <option value="28">28</option>
                                                        <option value="29">29</option>
                                                        <option value="30">30</option>
                                                        <option value="31">31</option>
                                                </select>
                                                <select class="form-control" id="TKNThangChinhThucDang" name="TKNThangChinhThucDang">
                                                    <option value="">---Chọn tháng---</option>
                                                        <option value="01">01</option>
                                                        <option value="02">02</option>
                                                        <option value="03">03</option>
                                                        <option value="04">04</option>
                                                        <option value="05">05</option>
                                                        <option value="06">06</option>
                                                        <option value="07">07</option>
                                                        <option value="08">08</option>
                                                        <option value="09">09</option>
                                                        <option value="10">10</option>
                                                        <option value="11">11</option>
                                                        <option value="12">12</option>
                                                </select>
                                                <select class="form-control" id="TKNNamChinhThucDang" name="TKNNamChinhThucDang">
                                                    <option value="">---Chọn năm---</option>
                                                        <option value="1900">1900</option>
                                                        <option value="1901">1901</option>
                                                        <option value="1902">1902</option>
                                                        <option value="1903">1903</option>
                                                        <option value="1904">1904</option>
                                                        <option value="1905">1905</option>
                                                        <option value="1906">1906</option>
                                                        <option value="1907">1907</option>
                                                        <option value="1908">1908</option>
                                                        <option value="1909">1909</option>
                                                        <option value="1910">1910</option>
                                                        <option value="1911">1911</option>
                                                        <option value="1912">1912</option>
                                                        <option value="1913">1913</option>
                                                        <option value="1914">1914</option>
                                                        <option value="1915">1915</option>
                                                        <option value="1916">1916</option>
                                                        <option value="1917">1917</option>
                                                        <option value="1918">1918</option>
                                                        <option value="1919">1919</option>
                                                        <option value="1920">1920</option>
                                                        <option value="1921">1921</option>
                                                        <option value="1922">1922</option>
                                                        <option value="1923">1923</option>
                                                        <option value="1924">1924</option>
                                                        <option value="1925">1925</option>
                                                        <option value="1926">1926</option>
                                                        <option value="1927">1927</option>
                                                        <option value="1928">1928</option>
                                                        <option value="1929">1929</option>
                                                        <option value="1930">1930</option>
                                                        <option value="1931">1931</option>
                                                        <option value="1932">1932</option>
                                                        <option value="1933">1933</option>
                                                        <option value="1934">1934</option>
                                                        <option value="1935">1935</option>
                                                        <option value="1936">1936</option>
                                                        <option value="1937">1937</option>
                                                        <option value="1938">1938</option>
                                                        <option value="1939">1939</option>
                                                        <option value="1940">1940</option>
                                                        <option value="1941">1941</option>
                                                        <option value="1942">1942</option>
                                                        <option value="1943">1943</option>
                                                        <option value="1944">1944</option>
                                                        <option value="1945">1945</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>Nguyên là: </label>
                                        <input type="text" class="form-control" id="TKNNguyenLa" name="TKNNguyenLa" value="">
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>Cơ quan, đơn vị: </label>
                                        <input type="text" class="form-control" id="TKNCoQuanDonVi" name="TKNCoQuanDonVi" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>Từ ngày:</label>
                                        <div class="input-group">
                                            <select class="form-control" id="TKNTuNgay" name="TKNTuNgay">
                                                <option value="">---Chọn ngày---</option>
                                                    <option value="01">01</option>
                                                    <option value="02">02</option>
                                                    <option value="03">03</option>
                                                    <option value="04">04</option>
                                                    <option value="05">05</option>
                                                    <option value="06">06</option>
                                                    <option value="07">07</option>
                                                    <option value="08">08</option>
                                                    <option value="09">09</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                    <option value="12">12</option>
                                                    <option value="13">13</option>
                                                    <option value="14">14</option>
                                                    <option value="15">15</option>
                                                    <option value="16">16</option>
                                                    <option value="17">17</option>
                                                    <option value="18">18</option>
                                                    <option value="19">19</option>
                                                    <option value="20">20</option>
                                                    <option value="21">21</option>
                                                    <option value="22">22</option>
                                                    <option value="23">23</option>
                                                    <option value="24">24</option>
                                                    <option value="25">25</option>
                                                    <option value="26">26</option>
                                                    <option value="27">27</option>
                                                    <option value="28">28</option>
                                                    <option value="29">29</option>
                                                    <option value="30">30</option>
                                                    <option value="31">31</option>
                                            </select>
                                            <select class="form-control" id="TKNTuThang" name="TKNTuThang">
                                                <option value="">---Chọn tháng---</option>
                                                    <option value="01">01</option>
                                                    <option value="02">02</option>
                                                    <option value="03">03</option>
                                                    <option value="04">04</option>
                                                    <option value="05">05</option>
                                                    <option value="06">06</option>
                                                    <option value="07">07</option>
                                                    <option value="08">08</option>
                                                    <option value="09">09</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                    <option value="12">12</option>
                                            </select>
                                            <select class="form-control" id="TKNTuNam" name="TKNTuNam">
                                                <option value="">---Chọn năm---</option>
                                                    <option value="1900">1900</option>
                                                    <option value="1901">1901</option>
                                                    <option value="1902">1902</option>
                                                    <option value="1903">1903</option>
                                                    <option value="1904">1904</option>
                                                    <option value="1905">1905</option>
                                                    <option value="1906">1906</option>
                                                    <option value="1907">1907</option>
                                                    <option value="1908">1908</option>
                                                    <option value="1909">1909</option>
                                                    <option value="1910">1910</option>
                                                    <option value="1911">1911</option>
                                                    <option value="1912">1912</option>
                                                    <option value="1913">1913</option>
                                                    <option value="1914">1914</option>
                                                    <option value="1915">1915</option>
                                                    <option value="1916">1916</option>
                                                    <option value="1917">1917</option>
                                                    <option value="1918">1918</option>
                                                    <option value="1919">1919</option>
                                                    <option value="1920">1920</option>
                                                    <option value="1921">1921</option>
                                                    <option value="1922">1922</option>
                                                    <option value="1923">1923</option>
                                                    <option value="1924">1924</option>
                                                    <option value="1925">1925</option>
                                                    <option value="1926">1926</option>
                                                    <option value="1927">1927</option>
                                                    <option value="1928">1928</option>
                                                    <option value="1929">1929</option>
                                                    <option value="1930">1930</option>
                                                    <option value="1931">1931</option>
                                                    <option value="1932">1932</option>
                                                    <option value="1933">1933</option>
                                                    <option value="1934">1934</option>
                                                    <option value="1935">1935</option>
                                                    <option value="1936">1936</option>
                                                    <option value="1937">1937</option>
                                                    <option value="1938">1938</option>
                                                    <option value="1939">1939</option>
                                                    <option value="1940">1940</option>
                                                    <option value="1941">1941</option>
                                                    <option value="1942">1942</option>
                                                    <option value="1943">1943</option>
                                                    <option value="1944">1944</option>
                                                    <option value="1945">1945</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>Đến CMT8 giữ chức vụ: </label>
                                        <input type="text" class="form-control" id="TKNCMT8ChucVu" name="TKNCMT8ChucVu" value="">
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="form-group">
                                        <label>Quá trình hoạt động</label>
                                        <textarea rows="5" class="form-control" id="TKNQuaTrinhHoatDong" name="TKNQuaTrinhHoatDong"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                document.getElementById('TKN').onclick = function (e) {
                    if (this.checked) {
                        document.getElementById("frm_tkn").style.display = "block";
                    }
                    else {
                        document.getElementById("frm_tkn").style.display = "none";
                    }
                };
                document.getElementById("btn_tttkn").onclick = function (e) {
                    var x = document.getElementById("frm_tkn").style.display;
                    if (x == "none") {
                        document.getElementById("frm_tkn").style.display = "block";
                    }
                    else {
                        document.getElementById("frm_tkn").style.display = "none";
                    }
                };
            </script>
                <div class="row" style="">
                <div class="col-xl-12">
                    <div class="card card-custom gutter-b example example-compact" style="border: 1px solid #60aee4;">
                        <div class="card-header">
                            <div class="checkbox-inline">
                                <label class="checkbox checkbox-lg">
                                    <input type="checkbox" data-val="true" data-val-required="The LS field is required." id="LS" name="LS" value="true"><span></span>
                                    <label class="card-title">
                                         <span class="label label-danger label-dot mr-2"></span>
                                        Liệt sỹ
                                    </label>
                                </label>
                            </div>
                            <div class="card-toolbar">
                                <button type="button" class="btn btn-clean btn-sm btn-icon" id="btn_ttls" title="Thu gọn/ Hiển thị">
                                    <i class="ki ki-bold-more-hor"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body" style="display: none" id="frm_ls">
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>Ngày nhập ngũ:</label>
                                        <div class="input-group">
                                            <select class="form-control" id="LSNgayNhapNgu" name="LSNgayNhapNgu">
                                                <option value="">---Chọn ngày---</option>
                                                    <option value="01">01</option>
                                                    <option value="02">02</option>
                                                    <option value="03">03</option>
                                                    <option value="04">04</option>
                                                    <option value="05">05</option>
                                                    <option value="06">06</option>
                                                    <option value="07">07</option>
                                                    <option value="08">08</option>
                                                    <option value="09">09</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                    <option value="12">12</option>
                                                    <option value="13">13</option>
                                                    <option value="14">14</option>
                                                    <option value="15">15</option>
                                                    <option value="16">16</option>
                                                    <option value="17">17</option>
                                                    <option value="18">18</option>
                                                    <option value="19">19</option>
                                                    <option value="20">20</option>
                                                    <option value="21">21</option>
                                                    <option value="22">22</option>
                                                    <option value="23">23</option>
                                                    <option value="24">24</option>
                                                    <option value="25">25</option>
                                                    <option value="26">26</option>
                                                    <option value="27">27</option>
                                                    <option value="28">28</option>
                                                    <option value="29">29</option>
                                                    <option value="30">30</option>
                                                    <option value="31">31</option>
                                            </select>
                                            <select class="form-control" id="LSThangNhapNgu" name="LSThangNhapNgu">
                                                <option value="">---Chọn tháng---</option>
                                                    <option value="01">01</option>
                                                    <option value="02">02</option>
                                                    <option value="03">03</option>
                                                    <option value="04">04</option>
                                                    <option value="05">05</option>
                                                    <option value="06">06</option>
                                                    <option value="07">07</option>
                                                    <option value="08">08</option>
                                                    <option value="09">09</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                    <option value="12">12</option>
                                            </select>
                                            <select class="form-control" id="LSNamNhapNgu" name="LSNamNhapNgu">
                                                <option value="">---Chọn năm---</option>
                                                    <option value="1900">1900</option>
                                                    <option value="1901">1901</option>
                                                    <option value="1902">1902</option>
                                                    <option value="1903">1903</option>
                                                    <option value="1904">1904</option>
                                                    <option value="1905">1905</option>
                                                    <option value="1906">1906</option>
                                                    <option value="1907">1907</option>
                                                    <option value="1908">1908</option>
                                                    <option value="1909">1909</option>
                                                    <option value="1910">1910</option>
                                                    <option value="1911">1911</option>
                                                    <option value="1912">1912</option>
                                                    <option value="1913">1913</option>
                                                    <option value="1914">1914</option>
                                                    <option value="1915">1915</option>
                                                    <option value="1916">1916</option>
                                                    <option value="1917">1917</option>
                                                    <option value="1918">1918</option>
                                                    <option value="1919">1919</option>
                                                    <option value="1920">1920</option>
                                                    <option value="1921">1921</option>
                                                    <option value="1922">1922</option>
                                                    <option value="1923">1923</option>
                                                    <option value="1924">1924</option>
                                                    <option value="1925">1925</option>
                                                    <option value="1926">1926</option>
                                                    <option value="1927">1927</option>
                                                    <option value="1928">1928</option>
                                                    <option value="1929">1929</option>
                                                    <option value="1930">1930</option>
                                                    <option value="1931">1931</option>
                                                    <option value="1932">1932</option>
                                                    <option value="1933">1933</option>
                                                    <option value="1934">1934</option>
                                                    <option value="1935">1935</option>
                                                    <option value="1936">1936</option>
                                                    <option value="1937">1937</option>
                                                    <option value="1938">1938</option>
                                                    <option value="1939">1939</option>
                                                    <option value="1940">1940</option>
                                                    <option value="1941">1941</option>
                                                    <option value="1942">1942</option>
                                                    <option value="1943">1943</option>
                                                    <option value="1944">1944</option>
                                                    <option value="1945">1945</option>
                                                    <option value="1946">1946</option>
                                                    <option value="1947">1947</option>
                                                    <option value="1948">1948</option>
                                                    <option value="1949">1949</option>
                                                    <option value="1950">1950</option>
                                                    <option value="1951">1951</option>
                                                    <option value="1952">1952</option>
                                                    <option value="1953">1953</option>
                                                    <option value="1954">1954</option>
                                                    <option value="1955">1955</option>
                                                    <option value="1956">1956</option>
                                                    <option value="1957">1957</option>
                                                    <option value="1958">1958</option>
                                                    <option value="1959">1959</option>
                                                    <option value="1960">1960</option>
                                                    <option value="1961">1961</option>
                                                    <option value="1962">1962</option>
                                                    <option value="1963">1963</option>
                                                    <option value="1964">1964</option>
                                                    <option value="1965">1965</option>
                                                    <option value="1966">1966</option>
                                                    <option value="1967">1967</option>
                                                    <option value="1968">1968</option>
                                                    <option value="1969">1969</option>
                                                    <option value="1970">1970</option>
                                                    <option value="1971">1971</option>
                                                    <option value="1972">1972</option>
                                                    <option value="1973">1973</option>
                                                    <option value="1974">1974</option>
                                                    <option value="1975">1975</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>Chức vụ</label>
                                        <input type="text" class="form-control" id="LSChucVu" name="LSChucVu" value="">
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>Cấp bậc</label>
                                        <input type="text" class="form-control" id="LSCapBac" name="LSCapBac" value="">
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>Cơ quan, đơn vị: </label>
                                        <input type="text" class="form-control" id="LSCoQuanDonVi" name="LSCoQuanDonVi" value="">
                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="form-group">
                                        <label>Loại đối tượng: </label>
                                        <select class="form-control" id="LSLoaiDoiTuong" name="LSLoaiDoiTuong">
                                            <option value="QN">Quân nhân</option>
                                            <option value="TNXP">Thanh niên xung phong</option>
                                            <option value="CNVC">Chuyên gia</option>
                                            <option value="DQDK">Dân quân, du kích</option>
                                            <option value="TBVTTP">Thương binh chết do vết thương tái phát</option>
                                            <option value="DTK">Đối tượng khác</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="form-group">
                                        <label>Loại liệt sỹ: </label>
                                        <select class="form-control" id="LSLoaiLietSy" name="LSLoaiLietSy">
                                            <option value="Hy sinh">Hy sinh</option>
                                            <option value="Mất tích">Mất tích</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>Ngày hy sinh</label>
                                        <div class="checkbox-inline">
                                            <div class="input-group">
                                                <select class="form-control" id="NgayMat" name="NgayMat">
                                                    <option value="">---Chọn ngày---</option>
                                                        <option value="01">01</option>
                                                        <option value="02">02</option>
                                                        <option value="03">03</option>
                                                        <option value="04">04</option>
                                                        <option value="05">05</option>
                                                        <option value="06">06</option>
                                                        <option value="07">07</option>
                                                        <option value="08">08</option>
                                                        <option value="09">09</option>
                                                        <option value="10">10</option>
                                                        <option value="11">11</option>
                                                        <option value="12">12</option>
                                                        <option value="13">13</option>
                                                        <option value="14">14</option>
                                                        <option value="15">15</option>
                                                        <option value="16">16</option>
                                                        <option value="17">17</option>
                                                        <option value="18">18</option>
                                                        <option value="19">19</option>
                                                        <option value="20">20</option>
                                                        <option value="21">21</option>
                                                        <option value="22">22</option>
                                                        <option value="23">23</option>
                                                        <option value="24">24</option>
                                                        <option value="25">25</option>
                                                        <option value="26">26</option>
                                                        <option value="27">27</option>
                                                        <option value="28">28</option>
                                                        <option value="29">29</option>
                                                        <option value="30">30</option>
                                                        <option value="31">31</option>
                                                </select>
                                                <select class="form-control" id="ThangMat" name="ThangMat">
                                                    <option value="">---Chọn tháng---</option>
                                                        <option value="01">01</option>
                                                        <option value="02">02</option>
                                                        <option value="03">03</option>
                                                        <option value="04">04</option>
                                                        <option value="05">05</option>
                                                        <option value="06">06</option>
                                                        <option value="07">07</option>
                                                        <option value="08">08</option>
                                                        <option value="09">09</option>
                                                        <option value="10">10</option>
                                                        <option value="11">11</option>
                                                        <option value="12">12</option>
                                                </select>
                                                <select class="form-control" id="NamMat" name="NamMat">
                                                    <option value="">---Chọn năm---</option>
                                                        <option value="1900">1900</option>
                                                        <option value="1901">1901</option>
                                                        <option value="1902">1902</option>
                                                        <option value="1903">1903</option>
                                                        <option value="1904">1904</option>
                                                        <option value="1905">1905</option>
                                                        <option value="1906">1906</option>
                                                        <option value="1907">1907</option>
                                                        <option value="1908">1908</option>
                                                        <option value="1909">1909</option>
                                                        <option value="1910">1910</option>
                                                        <option value="1911">1911</option>
                                                        <option value="1912">1912</option>
                                                        <option value="1913">1913</option>
                                                        <option value="1914">1914</option>
                                                        <option value="1915">1915</option>
                                                        <option value="1916">1916</option>
                                                        <option value="1917">1917</option>
                                                        <option value="1918">1918</option>
                                                        <option value="1919">1919</option>
                                                        <option value="1920">1920</option>
                                                        <option value="1921">1921</option>
                                                        <option value="1922">1922</option>
                                                        <option value="1923">1923</option>
                                                        <option value="1924">1924</option>
                                                        <option value="1925">1925</option>
                                                        <option value="1926">1926</option>
                                                        <option value="1927">1927</option>
                                                        <option value="1928">1928</option>
                                                        <option value="1929">1929</option>
                                                        <option value="1930">1930</option>
                                                        <option value="1931">1931</option>
                                                        <option value="1932">1932</option>
                                                        <option value="1933">1933</option>
                                                        <option value="1934">1934</option>
                                                        <option value="1935">1935</option>
                                                        <option value="1936">1936</option>
                                                        <option value="1937">1937</option>
                                                        <option value="1938">1938</option>
                                                        <option value="1939">1939</option>
                                                        <option value="1940">1940</option>
                                                        <option value="1941">1941</option>
                                                        <option value="1942">1942</option>
                                                        <option value="1943">1943</option>
                                                        <option value="1944">1944</option>
                                                        <option value="1945">1945</option>
                                                        <option value="1946">1946</option>
                                                        <option value="1947">1947</option>
                                                        <option value="1948">1948</option>
                                                        <option value="1949">1949</option>
                                                        <option value="1950">1950</option>
                                                        <option value="1951">1951</option>
                                                        <option value="1952">1952</option>
                                                        <option value="1953">1953</option>
                                                        <option value="1954">1954</option>
                                                        <option value="1955">1955</option>
                                                        <option value="1956">1956</option>
                                                        <option value="1957">1957</option>
                                                        <option value="1958">1958</option>
                                                        <option value="1959">1959</option>
                                                        <option value="1960">1960</option>
                                                        <option value="1961">1961</option>
                                                        <option value="1962">1962</option>
                                                        <option value="1963">1963</option>
                                                        <option value="1964">1964</option>
                                                        <option value="1965">1965</option>
                                                        <option value="1966">1966</option>
                                                        <option value="1967">1967</option>
                                                        <option value="1968">1968</option>
                                                        <option value="1969">1969</option>
                                                        <option value="1970">1970</option>
                                                        <option value="1971">1971</option>
                                                        <option value="1972">1972</option>
                                                        <option value="1973">1973</option>
                                                        <option value="1974">1974</option>
                                                        <option value="1975">1975</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>Đơn vị khi hy sinh: </label>
                                        <input type="text" class="form-control" id="LSDonViHySinh" name="LSDonViHySinh" value="">
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label> Nơi hy sinh: </label>
                                        <input type="text" class="form-control" id="LSNoiHySinh" name="LSNoiHySinh" value="">
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>Trong trường hợp:</label>
                                        <input type="text" class="form-control" id="LSTruongHopHySinh" name="LSTruongHopHySinh" value="">
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label> An táng tại: </label>
                                        <input type="text" class="form-control" id="LSNoiAnTang" name="LSNoiAnTang" value="">
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="form-group">
                                        <label> Thông tin giấy báo tử: </label>
                                        <input type="text" class="form-control" id="LSThongTinGiayBaoTu" name="LSThongTinGiayBaoTu" value="">
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="form-group">
                                        <label>Thông tin bằng Tổ Quốc ghi công: </label>
                                        <input type="text" class="form-control" id="LSBangToQuocGhiCong" name="LSBangToQuocGhiCong" value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                document.getElementById('LS').onclick = function (e) {
                    if (this.checked) {
                        document.getElementById("frm_ls").style.display = "block";
                    }
                    else {
                        document.getElementById("frm_ls").style.display = "none";
                    }
                };
                document.getElementById("btn_ttls").onclick = function (e) {
                    var x = document.getElementById("frm_ls").style.display;
                    if (x == "none") {
                        document.getElementById("frm_ls").style.display = "block";
                    }
                    else {
                        document.getElementById("frm_ls").style.display = "none";
                    }
                };
            </script>
                <div class="row" style="">
                <div class="col-xl-12">
                    <div class="card card-custom gutter-b example example-compact" style="border: 1px solid #60aee4;">
                        <div class="card-header">
                            <div class="checkbox-inline">
                                <label class="checkbox checkbox-lg">
                                    <input type="checkbox" data-val="true" data-val-required="The BM field is required." id="BM" name="BM" value="true"><span></span>
                                    <label class="card-title">
                                         <span class="label label-danger label-dot mr-2"></span>
                                        Bà mẹ Việt Nam anh hùng
                                    </label>
                                </label>
                            </div>
                            <div class="card-toolbar">
                                <button type="button" class="btn btn-clean btn-sm btn-icon" id="btn_ttbm" title="Thu gọn/ Hiển thị">
                                    <i class="ki ki-bold-more-hor"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body" style="display: none" id="frm_bm">
                            <div class="row">
                                <div class="col-xl-3">
                                    <div class="form-group">
                                        <label>Danh hiệu</label>
                                        <span class="form-control">Bà mẹ Việt Nam anh hùng</span>
                                    </div>
                                </div>
                                <div class="col-xl-9">
                                    <div class="form-group">
                                        <label>Tình hình hiện nay:</label>
                                        <input type="text" class="form-control" id="BMTinhHinhHienTai" name="BMTinhHinhHienTai" value="">
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="form-group">
                                        <label>Thông tin quyết định</label>
                                        <input type="text" class="form-control" id="BMThongTinQuyetDinh" name="BMThongTinQuyetDinh" value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                document.getElementById('BM').onclick = function (e) {
                    if (this.checked) {
                        document.getElementById("frm_bm").style.display = "block";
                    }
                    else {
                        document.getElementById("frm_bm").style.display = "none";
                    }
                };
                document.getElementById("btn_ttbm").onclick = function (e) {
                    var x = document.getElementById("frm_bm").style.display;
                    if (x == "none") {
                        document.getElementById("frm_bm").style.display = "block";
                    }
                    else {
                        document.getElementById("frm_bm").style.display = "none";
                    }
                };
            </script>
                <div class="row" style="">
                <div class="col-xl-12">
                    <div class="card card-custom gutter-b example example-compact" style="border: 1px solid #60aee4;">
                        <div class="card-header">
                            <div class="checkbox-inline">
                                <label class="checkbox checkbox-lg">
                                    <input type="checkbox" data-val="true" data-val-required="The AH field is required." id="AH" name="AH" value="true"><span></span>
                                    <label class="card-title">
                                         <span class="label label-danger label-dot mr-2"></span>
                                        Anh hùng lực lượng vũ trang nhân dân, Anh hùng lao động trong thời kỳ kháng chiến
                                    </label>
                                </label>
                            </div>
                            <div class="card-toolbar">
                                <button type="button" class="btn btn-clean btn-sm btn-icon" id="btn_ttah" title="Thu gọn/ Hiển thị">
                                    <i class="ki ki-bold-more-hor"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body" style="display: none" id="frm_ah">
                            <div class="row">
                                <div class="col-xl-7">
                                    <div class="form-group">
                                        <label>Đơn vị công tác</label>
                                        <input type="text" class="form-control" id="AHDonViCongTac" name="AHDonViCongTac" value="">
                                    </div>
                                </div>
                                <div class="col-xl-5">
                                    <div class="form-group">
                                        <label>Danh hiệu</label>
                                        <select class="form-control" id="AHDanhHieu" name="AHDanhHieu">
                                            <option value="Anh hùng lực lượng vũ trang nhân dân">Anh hùng lực lượng vũ trang nhân dân</option>
                                            <option value="Anh hùng lao động trong thời kỳ kháng chiến">Anh hùng lao động trong thời kỳ kháng chiến</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="form-group">
                                        <label>Thông tin quyết định</label>
                                        <input type="text" class="form-control" id="AHThongTinQuyetDinh" name="AHThongTinQuyetDinh" value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                document.getElementById('AH').onclick = function (e) {
                    if (this.checked) {
                        document.getElementById("frm_ah").style.display = "block";
                    }
                    else {
                        document.getElementById("frm_ah").style.display = "none";
                    }
                };
                document.getElementById("btn_ttah").onclick = function (e) {
                    var x = document.getElementById("frm_ah").style.display;
                    if (x == "none") {
                        document.getElementById("frm_ah").style.display = "block";
                    }
                    else {
                        document.getElementById("frm_ah").style.display = "none";
                    }
                };
            </script>
                <div class="row" style="">
                <div class="col-xl-12">
                    <div class="card card-custom gutter-b example example-compact" style="border: 1px solid #60aee4;">
                        <div class="card-header">
                            <div class="checkbox-inline">
                                <label class="checkbox checkbox-lg">
                                    <input type="checkbox" data-val="true" data-val-required="The TB field is required." id="TB" name="TB" value="true"><span></span>
                                    <label class="card-title">
                                         <span class="label label-danger label-dot mr-2"></span>
                                        Thương binh, người hưởng chính sách như thương binh, thương binh loại B
                                    </label>
                                </label>
                            </div>
                            <div class="card-toolbar">
                                <button type="button" class="btn btn-clean btn-sm btn-icon" id="btn_tttb" title="Thu gọn/ Hiển thị">
                                    <i class="ki ki-bold-more-hor"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body" style="display: none" id="frm_tb">
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>Chức vụ:</label>
                                        <input type="text" class="form-control" id="TBChucVu" name="TBChucVu" value="">
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>Cấp bậc:</label>
                                        <input type="text" class="form-control" id="TBCapBac" name="TBCapBac" value="">
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>Cơ quan đơn vị:</label>
                                        <input type="text" class="form-control" id="TBCoQuanDonVi" name="TBCoQuanDonVi" value="">
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>Loại thương binh:</label>
                                        <select type="text" class="form-control" id="TBLoaiThuongBinh" name="TBLoaiThuongBinh">
                                            <option value="Thương binh loại A">Thương binh loại A</option>
                                            <option value="Thương binh loại B">Thương binh loại B</option>
                                            <option value="Người hưởng chính sách như thương binh">Người hưởng chính sách như thương binh</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>Ngày nhập ngũ</label>
                                        <div class="input-group">
                                            <select class="form-control" id="TBNgayNhapNgu" name="TBNgayNhapNgu">
                                                <option value="">---Chọn ngày---</option>
                                                    <option value="01">01</option>
                                                    <option value="02">02</option>
                                                    <option value="03">03</option>
                                                    <option value="04">04</option>
                                                    <option value="05">05</option>
                                                    <option value="06">06</option>
                                                    <option value="07">07</option>
                                                    <option value="08">08</option>
                                                    <option value="09">09</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                    <option value="12">12</option>
                                                    <option value="13">13</option>
                                                    <option value="14">14</option>
                                                    <option value="15">15</option>
                                                    <option value="16">16</option>
                                                    <option value="17">17</option>
                                                    <option value="18">18</option>
                                                    <option value="19">19</option>
                                                    <option value="20">20</option>
                                                    <option value="21">21</option>
                                                    <option value="22">22</option>
                                                    <option value="23">23</option>
                                                    <option value="24">24</option>
                                                    <option value="25">25</option>
                                                    <option value="26">26</option>
                                                    <option value="27">27</option>
                                                    <option value="28">28</option>
                                                    <option value="29">29</option>
                                                    <option value="30">30</option>
                                                    <option value="31">31</option>
                                            </select>
                                            <select class="form-control" id="TBThangNhapNgu" name="TBThangNhapNgu">
                                                <option value="">---Chọn tháng---</option>
                                                    <option value="01">01</option>
                                                    <option value="02">02</option>
                                                    <option value="03">03</option>
                                                    <option value="04">04</option>
                                                    <option value="05">05</option>
                                                    <option value="06">06</option>
                                                    <option value="07">07</option>
                                                    <option value="08">08</option>
                                                    <option value="09">09</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                    <option value="12">12</option>
                                            </select>
                                            <select class="form-control" id="TBNamNhapNgu" name="TBNamNhapNgu">
                                                <option value="">---Chọn năm---</option>
                                                    <option value="1900">1900</option>
                                                    <option value="1901">1901</option>
                                                    <option value="1902">1902</option>
                                                    <option value="1903">1903</option>
                                                    <option value="1904">1904</option>
                                                    <option value="1905">1905</option>
                                                    <option value="1906">1906</option>
                                                    <option value="1907">1907</option>
                                                    <option value="1908">1908</option>
                                                    <option value="1909">1909</option>
                                                    <option value="1910">1910</option>
                                                    <option value="1911">1911</option>
                                                    <option value="1912">1912</option>
                                                    <option value="1913">1913</option>
                                                    <option value="1914">1914</option>
                                                    <option value="1915">1915</option>
                                                    <option value="1916">1916</option>
                                                    <option value="1917">1917</option>
                                                    <option value="1918">1918</option>
                                                    <option value="1919">1919</option>
                                                    <option value="1920">1920</option>
                                                    <option value="1921">1921</option>
                                                    <option value="1922">1922</option>
                                                    <option value="1923">1923</option>
                                                    <option value="1924">1924</option>
                                                    <option value="1925">1925</option>
                                                    <option value="1926">1926</option>
                                                    <option value="1927">1927</option>
                                                    <option value="1928">1928</option>
                                                    <option value="1929">1929</option>
                                                    <option value="1930">1930</option>
                                                    <option value="1931">1931</option>
                                                    <option value="1932">1932</option>
                                                    <option value="1933">1933</option>
                                                    <option value="1934">1934</option>
                                                    <option value="1935">1935</option>
                                                    <option value="1936">1936</option>
                                                    <option value="1937">1937</option>
                                                    <option value="1938">1938</option>
                                                    <option value="1939">1939</option>
                                                    <option value="1940">1940</option>
                                                    <option value="1941">1941</option>
                                                    <option value="1942">1942</option>
                                                    <option value="1943">1943</option>
                                                    <option value="1944">1944</option>
                                                    <option value="1945">1945</option>
                                                    <option value="1946">1946</option>
                                                    <option value="1947">1947</option>
                                                    <option value="1948">1948</option>
                                                    <option value="1949">1949</option>
                                                    <option value="1950">1950</option>
                                                    <option value="1951">1951</option>
                                                    <option value="1952">1952</option>
                                                    <option value="1953">1953</option>
                                                    <option value="1954">1954</option>
                                                    <option value="1955">1955</option>
                                                    <option value="1956">1956</option>
                                                    <option value="1957">1957</option>
                                                    <option value="1958">1958</option>
                                                    <option value="1959">1959</option>
                                                    <option value="1960">1960</option>
                                                    <option value="1961">1961</option>
                                                    <option value="1962">1962</option>
                                                    <option value="1963">1963</option>
                                                    <option value="1964">1964</option>
                                                    <option value="1965">1965</option>
                                                    <option value="1966">1966</option>
                                                    <option value="1967">1967</option>
                                                    <option value="1968">1968</option>
                                                    <option value="1969">1969</option>
                                                    <option value="1970">1970</option>
                                                    <option value="1971">1971</option>
                                                    <option value="1972">1972</option>
                                                    <option value="1973">1973</option>
                                                    <option value="1974">1974</option>
                                                    <option value="1975">1975</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>Ngày xuất ngũ</label>
                                        <div class="input-group">
                                            <select class="form-control" id="TBNgayXuatNgu" name="TBNgayXuatNgu">
                                                <option value="">---Chọn ngày---</option>
                                                    <option value="01">01</option>
                                                    <option value="02">02</option>
                                                    <option value="03">03</option>
                                                    <option value="04">04</option>
                                                    <option value="05">05</option>
                                                    <option value="06">06</option>
                                                    <option value="07">07</option>
                                                    <option value="08">08</option>
                                                    <option value="09">09</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                    <option value="12">12</option>
                                                    <option value="13">13</option>
                                                    <option value="14">14</option>
                                                    <option value="15">15</option>
                                                    <option value="16">16</option>
                                                    <option value="17">17</option>
                                                    <option value="18">18</option>
                                                    <option value="19">19</option>
                                                    <option value="20">20</option>
                                                    <option value="21">21</option>
                                                    <option value="22">22</option>
                                                    <option value="23">23</option>
                                                    <option value="24">24</option>
                                                    <option value="25">25</option>
                                                    <option value="26">26</option>
                                                    <option value="27">27</option>
                                                    <option value="28">28</option>
                                                    <option value="29">29</option>
                                                    <option value="30">30</option>
                                                    <option value="31">31</option>
                                            </select>
                                            <select class="form-control" id="TBThangXuatNgu" name="TBThangXuatNgu">
                                                <option value="">---Chọn tháng---</option>
                                                    <option value="01">01</option>
                                                    <option value="02">02</option>
                                                    <option value="03">03</option>
                                                    <option value="04">04</option>
                                                    <option value="05">05</option>
                                                    <option value="06">06</option>
                                                    <option value="07">07</option>
                                                    <option value="08">08</option>
                                                    <option value="09">09</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                    <option value="12">12</option>
                                            </select>
                                            <select class="form-control" id="TBNamXuatNgu" name="TBNamXuatNgu">
                                                <option value="">---Chọn năm---</option>
                                                    <option value="1900">1900</option>
                                                    <option value="1901">1901</option>
                                                    <option value="1902">1902</option>
                                                    <option value="1903">1903</option>
                                                    <option value="1904">1904</option>
                                                    <option value="1905">1905</option>
                                                    <option value="1906">1906</option>
                                                    <option value="1907">1907</option>
                                                    <option value="1908">1908</option>
                                                    <option value="1909">1909</option>
                                                    <option value="1910">1910</option>
                                                    <option value="1911">1911</option>
                                                    <option value="1912">1912</option>
                                                    <option value="1913">1913</option>
                                                    <option value="1914">1914</option>
                                                    <option value="1915">1915</option>
                                                    <option value="1916">1916</option>
                                                    <option value="1917">1917</option>
                                                    <option value="1918">1918</option>
                                                    <option value="1919">1919</option>
                                                    <option value="1920">1920</option>
                                                    <option value="1921">1921</option>
                                                    <option value="1922">1922</option>
                                                    <option value="1923">1923</option>
                                                    <option value="1924">1924</option>
                                                    <option value="1925">1925</option>
                                                    <option value="1926">1926</option>
                                                    <option value="1927">1927</option>
                                                    <option value="1928">1928</option>
                                                    <option value="1929">1929</option>
                                                    <option value="1930">1930</option>
                                                    <option value="1931">1931</option>
                                                    <option value="1932">1932</option>
                                                    <option value="1933">1933</option>
                                                    <option value="1934">1934</option>
                                                    <option value="1935">1935</option>
                                                    <option value="1936">1936</option>
                                                    <option value="1937">1937</option>
                                                    <option value="1938">1938</option>
                                                    <option value="1939">1939</option>
                                                    <option value="1940">1940</option>
                                                    <option value="1941">1941</option>
                                                    <option value="1942">1942</option>
                                                    <option value="1943">1943</option>
                                                    <option value="1944">1944</option>
                                                    <option value="1945">1945</option>
                                                    <option value="1946">1946</option>
                                                    <option value="1947">1947</option>
                                                    <option value="1948">1948</option>
                                                    <option value="1949">1949</option>
                                                    <option value="1950">1950</option>
                                                    <option value="1951">1951</option>
                                                    <option value="1952">1952</option>
                                                    <option value="1953">1953</option>
                                                    <option value="1954">1954</option>
                                                    <option value="1955">1955</option>
                                                    <option value="1956">1956</option>
                                                    <option value="1957">1957</option>
                                                    <option value="1958">1958</option>
                                                    <option value="1959">1959</option>
                                                    <option value="1960">1960</option>
                                                    <option value="1961">1961</option>
                                                    <option value="1962">1962</option>
                                                    <option value="1963">1963</option>
                                                    <option value="1964">1964</option>
                                                    <option value="1965">1965</option>
                                                    <option value="1966">1966</option>
                                                    <option value="1967">1967</option>
                                                    <option value="1968">1968</option>
                                                    <option value="1969">1969</option>
                                                    <option value="1970">1970</option>
                                                    <option value="1971">1971</option>
                                                    <option value="1972">1972</option>
                                                    <option value="1973">1973</option>
                                                    <option value="1974">1974</option>
                                                    <option value="1975">1975</option>
                                                    <option value="1976">1976</option>
                                                    <option value="1977">1977</option>
                                                    <option value="1978">1978</option>
                                                    <option value="1979">1979</option>
                                                    <option value="1980">1980</option>
                                                    <option value="1981">1981</option>
                                                    <option value="1982">1982</option>
                                                    <option value="1983">1983</option>
                                                    <option value="1984">1984</option>
                                                    <option value="1985">1985</option>
                                                    <option value="1986">1986</option>
                                                    <option value="1987">1987</option>
                                                    <option value="1988">1988</option>
                                                    <option value="1989">1989</option>
                                                    <option value="1990">1990</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>Loại đối tượng:</label>
                                        <select type="text" class="form-control" id="TBLoaiDoiTuong" name="TBLoaiDoiTuong">
                                            <option value="QN">Quân nhân</option>
                                            <option value="TNXP">Thanh niên xung phong</option>
                                            <option value="CNVC">Công nhân viên chức</option>
                                            <option value="DTK">Đối tượng khác</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>Thời gian bị thương:</label>
                                        <div class="input-group">
                                            <select class="form-control" id="TBNgayBiThuong" name="TBNgayBiThuong">
                                                <option value="">---Chọn ngày---</option>
                                                    <option value="01">01</option>
                                                    <option value="02">02</option>
                                                    <option value="03">03</option>
                                                    <option value="04">04</option>
                                                    <option value="05">05</option>
                                                    <option value="06">06</option>
                                                    <option value="07">07</option>
                                                    <option value="08">08</option>
                                                    <option value="09">09</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                    <option value="12">12</option>
                                                    <option value="13">13</option>
                                                    <option value="14">14</option>
                                                    <option value="15">15</option>
                                                    <option value="16">16</option>
                                                    <option value="17">17</option>
                                                    <option value="18">18</option>
                                                    <option value="19">19</option>
                                                    <option value="20">20</option>
                                                    <option value="21">21</option>
                                                    <option value="22">22</option>
                                                    <option value="23">23</option>
                                                    <option value="24">24</option>
                                                    <option value="25">25</option>
                                                    <option value="26">26</option>
                                                    <option value="27">27</option>
                                                    <option value="28">28</option>
                                                    <option value="29">29</option>
                                                    <option value="30">30</option>
                                                    <option value="31">31</option>
                                            </select>
                                            <select class="form-control" id="TBThangBiThuong" name="TBThangBiThuong">
                                                <option value="">---Chọn tháng---</option>
                                                    <option value="01">01</option>
                                                    <option value="02">02</option>
                                                    <option value="03">03</option>
                                                    <option value="04">04</option>
                                                    <option value="05">05</option>
                                                    <option value="06">06</option>
                                                    <option value="07">07</option>
                                                    <option value="08">08</option>
                                                    <option value="09">09</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                    <option value="12">12</option>
                                            </select>
                                            <select class="form-control" id="TBNamBiThuong" name="TBNamBiThuong">
                                                <option value="">---Chọn năm---</option>
                                                    <option value="1900">1900</option>
                                                    <option value="1901">1901</option>
                                                    <option value="1902">1902</option>
                                                    <option value="1903">1903</option>
                                                    <option value="1904">1904</option>
                                                    <option value="1905">1905</option>
                                                    <option value="1906">1906</option>
                                                    <option value="1907">1907</option>
                                                    <option value="1908">1908</option>
                                                    <option value="1909">1909</option>
                                                    <option value="1910">1910</option>
                                                    <option value="1911">1911</option>
                                                    <option value="1912">1912</option>
                                                    <option value="1913">1913</option>
                                                    <option value="1914">1914</option>
                                                    <option value="1915">1915</option>
                                                    <option value="1916">1916</option>
                                                    <option value="1917">1917</option>
                                                    <option value="1918">1918</option>
                                                    <option value="1919">1919</option>
                                                    <option value="1920">1920</option>
                                                    <option value="1921">1921</option>
                                                    <option value="1922">1922</option>
                                                    <option value="1923">1923</option>
                                                    <option value="1924">1924</option>
                                                    <option value="1925">1925</option>
                                                    <option value="1926">1926</option>
                                                    <option value="1927">1927</option>
                                                    <option value="1928">1928</option>
                                                    <option value="1929">1929</option>
                                                    <option value="1930">1930</option>
                                                    <option value="1931">1931</option>
                                                    <option value="1932">1932</option>
                                                    <option value="1933">1933</option>
                                                    <option value="1934">1934</option>
                                                    <option value="1935">1935</option>
                                                    <option value="1936">1936</option>
                                                    <option value="1937">1937</option>
                                                    <option value="1938">1938</option>
                                                    <option value="1939">1939</option>
                                                    <option value="1940">1940</option>
                                                    <option value="1941">1941</option>
                                                    <option value="1942">1942</option>
                                                    <option value="1943">1943</option>
                                                    <option value="1944">1944</option>
                                                    <option value="1945">1945</option>
                                                    <option value="1946">1946</option>
                                                    <option value="1947">1947</option>
                                                    <option value="1948">1948</option>
                                                    <option value="1949">1949</option>
                                                    <option value="1950">1950</option>
                                                    <option value="1951">1951</option>
                                                    <option value="1952">1952</option>
                                                    <option value="1953">1953</option>
                                                    <option value="1954">1954</option>
                                                    <option value="1955">1955</option>
                                                    <option value="1956">1956</option>
                                                    <option value="1957">1957</option>
                                                    <option value="1958">1958</option>
                                                    <option value="1959">1959</option>
                                                    <option value="1960">1960</option>
                                                    <option value="1961">1961</option>
                                                    <option value="1962">1962</option>
                                                    <option value="1963">1963</option>
                                                    <option value="1964">1964</option>
                                                    <option value="1965">1965</option>
                                                    <option value="1966">1966</option>
                                                    <option value="1967">1967</option>
                                                    <option value="1968">1968</option>
                                                    <option value="1969">1969</option>
                                                    <option value="1970">1970</option>
                                                    <option value="1971">1971</option>
                                                    <option value="1972">1972</option>
                                                    <option value="1973">1973</option>
                                                    <option value="1974">1974</option>
                                                    <option value="1975">1975</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>Nơi bị thương:</label>
                                        <input type="text" class="form-control" id="TBNoiBiThuong" name="TBNoiBiThuong" value="">
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>Cơ quan đơn vị khi bị thương:</label>
                                        <input type="text" class="form-control" id="TBCoQuanBiThuong" name="TBCoQuanBiThuong" value="">
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>Chức vụ cấp bậc khi bị thương:</label>
                                        <input type="text" class="form-control" id="TBChucVuCapBacBiThuong" name="TBChucVuCapBacBiThuong" value="">
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>Loại thương tật:</label>
                                        <select class="form-control" id="TBLoaiThuongTat" name="TBLoaiThuongTat">
                                            <option value="Vĩnh viễn">Vĩnh viễn</option>
                                            <option value="Tạm thời">Tạm thời</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>Tỷ lệ thương tật (%):</label>
                                        <select class="form-control" id="TBTyLeThuongTat" name="TBTyLeThuongTat">
                                            <option value="0">---Chọn---</option>
                                                <option value="20">20</option>
                                                <option value="21">21</option>
                                                <option value="22">22</option>
                                                <option value="23">23</option>
                                                <option value="24">24</option>
                                                <option value="25">25</option>
                                                <option value="26">26</option>
                                                <option value="27">27</option>
                                                <option value="28">28</option>
                                                <option value="29">29</option>
                                                <option value="30">30</option>
                                                <option value="31">31</option>
                                                <option value="32">32</option>
                                                <option value="33">33</option>
                                                <option value="34">34</option>
                                                <option value="35">35</option>
                                                <option value="36">36</option>
                                                <option value="37">37</option>
                                                <option value="38">38</option>
                                                <option value="39">39</option>
                                                <option value="40">40</option>
                                                <option value="41">41</option>
                                                <option value="42">42</option>
                                                <option value="43">43</option>
                                                <option value="44">44</option>
                                                <option value="45">45</option>
                                                <option value="46">46</option>
                                                <option value="47">47</option>
                                                <option value="48">48</option>
                                                <option value="49">49</option>
                                                <option value="50">50</option>
                                                <option value="51">51</option>
                                                <option value="52">52</option>
                                                <option value="53">53</option>
                                                <option value="54">54</option>
                                                <option value="55">55</option>
                                                <option value="56">56</option>
                                                <option value="57">57</option>
                                                <option value="58">58</option>
                                                <option value="59">59</option>
                                                <option value="60">60</option>
                                                <option value="61">61</option>
                                                <option value="62">62</option>
                                                <option value="63">63</option>
                                                <option value="64">64</option>
                                                <option value="65">65</option>
                                                <option value="66">66</option>
                                                <option value="67">67</option>
                                                <option value="68">68</option>
                                                <option value="69">69</option>
                                                <option value="70">70</option>
                                                <option value="71">71</option>
                                                <option value="72">72</option>
                                                <option value="73">73</option>
                                                <option value="74">74</option>
                                                <option value="75">75</option>
                                                <option value="76">76</option>
                                                <option value="77">77</option>
                                                <option value="78">78</option>
                                                <option value="79">79</option>
                                                <option value="80">80</option>
                                                <option value="81">81</option>
                                                <option value="82">82</option>
                                                <option value="83">83</option>
                                                <option value="84">84</option>
                                                <option value="85">85</option>
                                                <option value="86">86</option>
                                                <option value="87">87</option>
                                                <option value="88">88</option>
                                                <option value="89">89</option>
                                                <option value="90">90</option>
                                                <option value="91">91</option>
                                                <option value="92">92</option>
                                                <option value="93">93</option>
                                                <option value="94">94</option>
                                                <option value="95">95</option>
                                                <option value="96">96</option>
                                                <option value="97">97</option>
                                                <option value="98">98</option>
                                                <option value="99">99</option>
                                                <option value="100">100</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>Trường hợp bị thương:</label>
                                        <input type="text" class="form-control" id="TBTruongHopBiThuong" name="TBTruongHopBiThuong" value="">
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>Vết thương thực thể:</label>
                                        <input type="text" class="form-control" id="TBVetThuongThucThe" name="TBVetThuongThucThe" value="">
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>Tình trạng thương tật:</label>
                                        <input type="text" class="form-control" id="TBTinhTrangThuongTat" name="TBTinhTrangThuongTat" value="">
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>Tỷ lệ tổn thương cơ thể:</label>
                                        <select class="form-control" id="TBTyLeTonThuongCoThe" name="TBTyLeTonThuongCoThe">
                                            <option value="0">---Chọn---</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                                <option value="10">10</option>
                                                <option value="11">11</option>
                                                <option value="12">12</option>
                                                <option value="13">13</option>
                                                <option value="14">14</option>
                                                <option value="15">15</option>
                                                <option value="16">16</option>
                                                <option value="17">17</option>
                                                <option value="18">18</option>
                                                <option value="19">19</option>
                                                <option value="20">20</option>
                                                <option value="21">21</option>
                                                <option value="22">22</option>
                                                <option value="23">23</option>
                                                <option value="24">24</option>
                                                <option value="25">25</option>
                                                <option value="26">26</option>
                                                <option value="27">27</option>
                                                <option value="28">28</option>
                                                <option value="29">29</option>
                                                <option value="30">30</option>
                                                <option value="31">31</option>
                                                <option value="32">32</option>
                                                <option value="33">33</option>
                                                <option value="34">34</option>
                                                <option value="35">35</option>
                                                <option value="36">36</option>
                                                <option value="37">37</option>
                                                <option value="38">38</option>
                                                <option value="39">39</option>
                                                <option value="40">40</option>
                                                <option value="41">41</option>
                                                <option value="42">42</option>
                                                <option value="43">43</option>
                                                <option value="44">44</option>
                                                <option value="45">45</option>
                                                <option value="46">46</option>
                                                <option value="47">47</option>
                                                <option value="48">48</option>
                                                <option value="49">49</option>
                                                <option value="50">50</option>
                                                <option value="51">51</option>
                                                <option value="52">52</option>
                                                <option value="53">53</option>
                                                <option value="54">54</option>
                                                <option value="55">55</option>
                                                <option value="56">56</option>
                                                <option value="57">57</option>
                                                <option value="58">58</option>
                                                <option value="59">59</option>
                                                <option value="60">60</option>
                                                <option value="61">61</option>
                                                <option value="62">62</option>
                                                <option value="63">63</option>
                                                <option value="64">64</option>
                                                <option value="65">65</option>
                                                <option value="66">66</option>
                                                <option value="67">67</option>
                                                <option value="68">68</option>
                                                <option value="69">69</option>
                                                <option value="70">70</option>
                                                <option value="71">71</option>
                                                <option value="72">72</option>
                                                <option value="73">73</option>
                                                <option value="74">74</option>
                                                <option value="75">75</option>
                                                <option value="76">76</option>
                                                <option value="77">77</option>
                                                <option value="78">78</option>
                                                <option value="79">79</option>
                                                <option value="80">80</option>
                                                <option value="81">81</option>
                                                <option value="82">82</option>
                                                <option value="83">83</option>
                                                <option value="84">84</option>
                                                <option value="85">85</option>
                                                <option value="86">86</option>
                                                <option value="87">87</option>
                                                <option value="88">88</option>
                                                <option value="89">89</option>
                                                <option value="90">90</option>
                                                <option value="91">91</option>
                                                <option value="92">92</option>
                                                <option value="93">93</option>
                                                <option value="94">94</option>
                                                <option value="95">95</option>
                                                <option value="96">96</option>
                                                <option value="97">97</option>
                                                <option value="98">98</option>
                                                <option value="99">99</option>
                                                <option value="100">100</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>Nơi điều trị:</label>
                                        <input type="text" class="form-control" id="TBNoiDieuTri" name="TBNoiDieuTri" value="">
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>Thời gian điều trị:</label>
                                        <input type="text" class="form-control" id="TBThoiGianDieuTri" name="TBThoiGianDieuTri" value="">
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="form-group">
                                        <label>Thông tin giấy chứng nhận:</label>
                                        <input type="text" class="form-control" id="TBGiayChungNhan" name="TBGiayChungNhan" value="">
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="form-group">
                                        <label>Thông tin giấy giám định:</label>
                                        <input type="text" class="form-control" id="TBGiayGiamDinh" name="TBGiayGiamDinh" value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                document.getElementById('TB').onclick = function (e) {
                    if (this.checked) {
                        document.getElementById("frm_tb").style.display = "block";
                    }
                    else {
                        document.getElementById("frm_tb").style.display = "none";
                    }
                };
                document.getElementById("btn_tttb").onclick = function (e) {
                    var x = document.getElementById("frm_tb").style.display;
                    if (x == "none") {
                        document.getElementById("frm_tb").style.display = "block";
                    }
                    else {
                        document.getElementById("frm_tb").style.display = "none";
                    }
                };
            </script>
                <div class="row" style="">
                <div class="col-xl-12">
                    <div class="card card-custom gutter-b example example-compact" style="border: 1px solid #60aee4;">
                        <div class="card-header">
                            <div class="checkbox-inline">
                                <label class="checkbox checkbox-lg">
                                    <input type="checkbox" data-val="true" data-val-required="The BB field is required." id="BB" name="BB" value="true"><span></span>
                                    <label class="card-title">
                                         <span class="label label-danger label-dot mr-2"></span>
                                        Bệnh binh
                                    </label>
                                </label>
                            </div>
                            <div class="card-toolbar">
                                <button type="button" class="btn btn-clean btn-sm btn-icon" id="btn_ttbb" title="Thu gọn/ Hiển thị">
                                    <i class="ki ki-bold-more-hor"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body" style="display: none" id="frm_bb">
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>Ngày tháng năm nhập ngũ</label>
                                        <div class="input-group">
                                            <select class="form-control" id="BBNgayNhapNgu" name="BBNgayNhapNgu">
                                                <option value="">---Chọn ngày---</option>
                                                    <option value="01">01</option>
                                                    <option value="02">02</option>
                                                    <option value="03">03</option>
                                                    <option value="04">04</option>
                                                    <option value="05">05</option>
                                                    <option value="06">06</option>
                                                    <option value="07">07</option>
                                                    <option value="08">08</option>
                                                    <option value="09">09</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                    <option value="12">12</option>
                                                    <option value="13">13</option>
                                                    <option value="14">14</option>
                                                    <option value="15">15</option>
                                                    <option value="16">16</option>
                                                    <option value="17">17</option>
                                                    <option value="18">18</option>
                                                    <option value="19">19</option>
                                                    <option value="20">20</option>
                                                    <option value="21">21</option>
                                                    <option value="22">22</option>
                                                    <option value="23">23</option>
                                                    <option value="24">24</option>
                                                    <option value="25">25</option>
                                                    <option value="26">26</option>
                                                    <option value="27">27</option>
                                                    <option value="28">28</option>
                                                    <option value="29">29</option>
                                                    <option value="30">30</option>
                                                    <option value="31">31</option>
                                            </select>
                                            <select class="form-control" id="BBThangNhapNgu" name="BBThangNhapNgu">
                                                <option value="">---Chọn tháng---</option>
                                                    <option value="01">01</option>
                                                    <option value="02">02</option>
                                                    <option value="03">03</option>
                                                    <option value="04">04</option>
                                                    <option value="05">05</option>
                                                    <option value="06">06</option>
                                                    <option value="07">07</option>
                                                    <option value="08">08</option>
                                                    <option value="09">09</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                    <option value="12">12</option>
                                            </select>
                                            <select class="form-control" id="BBNamNhapNgu" name="BBNamNhapNgu">
                                                <option value="">---Chọn năm---</option>
                                                    <option value="1900">1900</option>
                                                    <option value="1901">1901</option>
                                                    <option value="1902">1902</option>
                                                    <option value="1903">1903</option>
                                                    <option value="1904">1904</option>
                                                    <option value="1905">1905</option>
                                                    <option value="1906">1906</option>
                                                    <option value="1907">1907</option>
                                                    <option value="1908">1908</option>
                                                    <option value="1909">1909</option>
                                                    <option value="1910">1910</option>
                                                    <option value="1911">1911</option>
                                                    <option value="1912">1912</option>
                                                    <option value="1913">1913</option>
                                                    <option value="1914">1914</option>
                                                    <option value="1915">1915</option>
                                                    <option value="1916">1916</option>
                                                    <option value="1917">1917</option>
                                                    <option value="1918">1918</option>
                                                    <option value="1919">1919</option>
                                                    <option value="1920">1920</option>
                                                    <option value="1921">1921</option>
                                                    <option value="1922">1922</option>
                                                    <option value="1923">1923</option>
                                                    <option value="1924">1924</option>
                                                    <option value="1925">1925</option>
                                                    <option value="1926">1926</option>
                                                    <option value="1927">1927</option>
                                                    <option value="1928">1928</option>
                                                    <option value="1929">1929</option>
                                                    <option value="1930">1930</option>
                                                    <option value="1931">1931</option>
                                                    <option value="1932">1932</option>
                                                    <option value="1933">1933</option>
                                                    <option value="1934">1934</option>
                                                    <option value="1935">1935</option>
                                                    <option value="1936">1936</option>
                                                    <option value="1937">1937</option>
                                                    <option value="1938">1938</option>
                                                    <option value="1939">1939</option>
                                                    <option value="1940">1940</option>
                                                    <option value="1941">1941</option>
                                                    <option value="1942">1942</option>
                                                    <option value="1943">1943</option>
                                                    <option value="1944">1944</option>
                                                    <option value="1945">1945</option>
                                                    <option value="1946">1946</option>
                                                    <option value="1947">1947</option>
                                                    <option value="1948">1948</option>
                                                    <option value="1949">1949</option>
                                                    <option value="1950">1950</option>
                                                    <option value="1951">1951</option>
                                                    <option value="1952">1952</option>
                                                    <option value="1953">1953</option>
                                                    <option value="1954">1954</option>
                                                    <option value="1955">1955</option>
                                                    <option value="1956">1956</option>
                                                    <option value="1957">1957</option>
                                                    <option value="1958">1958</option>
                                                    <option value="1959">1959</option>
                                                    <option value="1960">1960</option>
                                                    <option value="1961">1961</option>
                                                    <option value="1962">1962</option>
                                                    <option value="1963">1963</option>
                                                    <option value="1964">1964</option>
                                                    <option value="1965">1965</option>
                                                    <option value="1966">1966</option>
                                                    <option value="1967">1967</option>
                                                    <option value="1968">1968</option>
                                                    <option value="1969">1969</option>
                                                    <option value="1970">1970</option>
                                                    <option value="1971">1971</option>
                                                    <option value="1972">1972</option>
                                                    <option value="1973">1973</option>
                                                    <option value="1974">1974</option>
                                                    <option value="1975">1975</option>
                                                    <option value="1976">1976</option>
                                                    <option value="1977">1977</option>
                                                    <option value="1978">1978</option>
                                                    <option value="1979">1979</option>
                                                    <option value="1980">1980</option>
                                                    <option value="1981">1981</option>
                                                    <option value="1982">1982</option>
                                                    <option value="1983">1983</option>
                                                    <option value="1984">1984</option>
                                                    <option value="1985">1985</option>
                                                    <option value="1986">1986</option>
                                                    <option value="1987">1987</option>
                                                    <option value="1988">1988</option>
                                                    <option value="1989">1989</option>
                                                    <option value="1990">1990</option>
                                                    <option value="1991">1991</option>
                                                    <option value="1992">1992</option>
                                                    <option value="1993">1993</option>
                                                    <option value="1994">1994</option>
                                                    <option value="1995">1995</option>
                                                    <option value="1996">1996</option>
                                                    <option value="1997">1997</option>
                                                    <option value="1998">1998</option>
                                                    <option value="1999">1999</option>
                                                    <option value="2000">2000</option>
                                                    <option value="2001">2001</option>
                                                    <option value="2002">2002</option>
                                                    <option value="2003">2003</option>
                                                    <option value="2004">2004</option>
                                                    <option value="2005">2005</option>
                                                    <option value="2006">2006</option>
                                                    <option value="2007">2007</option>
                                                    <option value="2008">2008</option>
                                                    <option value="2009">2009</option>
                                                    <option value="2010">2010</option>
                                                    <option value="2011">2011</option>
                                                    <option value="2012">2012</option>
                                                    <option value="2013">2013</option>
                                                    <option value="2014">2014</option>
                                                    <option value="2015">2015</option>
                                                    <option value="2016">2016</option>
                                                    <option value="2017">2017</option>
                                                    <option value="2018">2018</option>
                                                    <option value="2019">2019</option>
                                                    <option value="2020">2020</option>
                                                    <option value="2021">2021</option>
                                                    <option value="2022">2022</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>Đơn vị khi nhập ngũ</label>
                                        <input type="text" class="form-control" id="BBDonViNhapNgu" name="BBDonViNhapNgu" value="">
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>Ngày tháng năm xuất ngũ</label>
                                        <div class="input-group">
                                            <select class="form-control" id="BBNgayXuatNgu" name="BBNgayXuatNgu">
                                                <option value="">---Chọn ngày---</option>
                                                    <option value="01">01</option>
                                                    <option value="02">02</option>
                                                    <option value="03">03</option>
                                                    <option value="04">04</option>
                                                    <option value="05">05</option>
                                                    <option value="06">06</option>
                                                    <option value="07">07</option>
                                                    <option value="08">08</option>
                                                    <option value="09">09</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                    <option value="12">12</option>
                                                    <option value="13">13</option>
                                                    <option value="14">14</option>
                                                    <option value="15">15</option>
                                                    <option value="16">16</option>
                                                    <option value="17">17</option>
                                                    <option value="18">18</option>
                                                    <option value="19">19</option>
                                                    <option value="20">20</option>
                                                    <option value="21">21</option>
                                                    <option value="22">22</option>
                                                    <option value="23">23</option>
                                                    <option value="24">24</option>
                                                    <option value="25">25</option>
                                                    <option value="26">26</option>
                                                    <option value="27">27</option>
                                                    <option value="28">28</option>
                                                    <option value="29">29</option>
                                                    <option value="30">30</option>
                                                    <option value="31">31</option>
                                            </select>
                                            <select class="form-control" id="BBThangXuatNgu" name="BBThangXuatNgu">
                                                <option value="">---Chọn tháng---</option>
                                                    <option value="01">01</option>
                                                    <option value="02">02</option>
                                                    <option value="03">03</option>
                                                    <option value="04">04</option>
                                                    <option value="05">05</option>
                                                    <option value="06">06</option>
                                                    <option value="07">07</option>
                                                    <option value="08">08</option>
                                                    <option value="09">09</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                    <option value="12">12</option>
                                            </select>
                                            <select class="form-control" id="BBNamXuatNgu" name="BBNamXuatNgu">
                                                <option value="">---Chọn năm---</option>
                                                    <option value="1900">1900</option>
                                                    <option value="1901">1901</option>
                                                    <option value="1902">1902</option>
                                                    <option value="1903">1903</option>
                                                    <option value="1904">1904</option>
                                                    <option value="1905">1905</option>
                                                    <option value="1906">1906</option>
                                                    <option value="1907">1907</option>
                                                    <option value="1908">1908</option>
                                                    <option value="1909">1909</option>
                                                    <option value="1910">1910</option>
                                                    <option value="1911">1911</option>
                                                    <option value="1912">1912</option>
                                                    <option value="1913">1913</option>
                                                    <option value="1914">1914</option>
                                                    <option value="1915">1915</option>
                                                    <option value="1916">1916</option>
                                                    <option value="1917">1917</option>
                                                    <option value="1918">1918</option>
                                                    <option value="1919">1919</option>
                                                    <option value="1920">1920</option>
                                                    <option value="1921">1921</option>
                                                    <option value="1922">1922</option>
                                                    <option value="1923">1923</option>
                                                    <option value="1924">1924</option>
                                                    <option value="1925">1925</option>
                                                    <option value="1926">1926</option>
                                                    <option value="1927">1927</option>
                                                    <option value="1928">1928</option>
                                                    <option value="1929">1929</option>
                                                    <option value="1930">1930</option>
                                                    <option value="1931">1931</option>
                                                    <option value="1932">1932</option>
                                                    <option value="1933">1933</option>
                                                    <option value="1934">1934</option>
                                                    <option value="1935">1935</option>
                                                    <option value="1936">1936</option>
                                                    <option value="1937">1937</option>
                                                    <option value="1938">1938</option>
                                                    <option value="1939">1939</option>
                                                    <option value="1940">1940</option>
                                                    <option value="1941">1941</option>
                                                    <option value="1942">1942</option>
                                                    <option value="1943">1943</option>
                                                    <option value="1944">1944</option>
                                                    <option value="1945">1945</option>
                                                    <option value="1946">1946</option>
                                                    <option value="1947">1947</option>
                                                    <option value="1948">1948</option>
                                                    <option value="1949">1949</option>
                                                    <option value="1950">1950</option>
                                                    <option value="1951">1951</option>
                                                    <option value="1952">1952</option>
                                                    <option value="1953">1953</option>
                                                    <option value="1954">1954</option>
                                                    <option value="1955">1955</option>
                                                    <option value="1956">1956</option>
                                                    <option value="1957">1957</option>
                                                    <option value="1958">1958</option>
                                                    <option value="1959">1959</option>
                                                    <option value="1960">1960</option>
                                                    <option value="1961">1961</option>
                                                    <option value="1962">1962</option>
                                                    <option value="1963">1963</option>
                                                    <option value="1964">1964</option>
                                                    <option value="1965">1965</option>
                                                    <option value="1966">1966</option>
                                                    <option value="1967">1967</option>
                                                    <option value="1968">1968</option>
                                                    <option value="1969">1969</option>
                                                    <option value="1970">1970</option>
                                                    <option value="1971">1971</option>
                                                    <option value="1972">1972</option>
                                                    <option value="1973">1973</option>
                                                    <option value="1974">1974</option>
                                                    <option value="1975">1975</option>
                                                    <option value="1976">1976</option>
                                                    <option value="1977">1977</option>
                                                    <option value="1978">1978</option>
                                                    <option value="1979">1979</option>
                                                    <option value="1980">1980</option>
                                                    <option value="1981">1981</option>
                                                    <option value="1982">1982</option>
                                                    <option value="1983">1983</option>
                                                    <option value="1984">1984</option>
                                                    <option value="1985">1985</option>
                                                    <option value="1986">1986</option>
                                                    <option value="1987">1987</option>
                                                    <option value="1988">1988</option>
                                                    <option value="1989">1989</option>
                                                    <option value="1990">1990</option>
                                                    <option value="1991">1991</option>
                                                    <option value="1992">1992</option>
                                                    <option value="1993">1993</option>
                                                    <option value="1994">1994</option>
                                                    <option value="1995">1995</option>
                                                    <option value="1996">1996</option>
                                                    <option value="1997">1997</option>
                                                    <option value="1998">1998</option>
                                                    <option value="1999">1999</option>
                                                    <option value="2000">2000</option>
                                                    <option value="2001">2001</option>
                                                    <option value="2002">2002</option>
                                                    <option value="2003">2003</option>
                                                    <option value="2004">2004</option>
                                                    <option value="2005">2005</option>
                                                    <option value="2006">2006</option>
                                                    <option value="2007">2007</option>
                                                    <option value="2008">2008</option>
                                                    <option value="2009">2009</option>
                                                    <option value="2010">2010</option>
                                                    <option value="2011">2011</option>
                                                    <option value="2012">2012</option>
                                                    <option value="2013">2013</option>
                                                    <option value="2014">2014</option>
                                                    <option value="2015">2015</option>
                                                    <option value="2016">2016</option>
                                                    <option value="2017">2017</option>
                                                    <option value="2018">2018</option>
                                                    <option value="2019">2019</option>
                                                    <option value="2020">2020</option>
                                                    <option value="2021">2021</option>
                                                    <option value="2022">2022</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>Đơn vị khi xuất ngũ</label>
                                        <input type="text" class="form-control" id="BBDonViXuatNgu" name="BBDonViXuatNgu" value="">
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>Chức vụ khi xuất ngũ:</label>
                                        <input type="text" class="form-control" id="BBChucVuXuatNgu" name="BBChucVuXuatNgu" value="">
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>Cấp bậc khi xuất ngũ:</label>
                                        <input type="text" class="form-control" id="BBCapBacXuatNgu" name="BBCapBacXuatNgu" value="">
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>Ngày tháng năm bị bệnh</label>
                                        <div class="input-group">
                                            <select class="form-control" id="BBNgayBiBenh" name="BBNgayBiBenh">
                                                <option value="">---Chọn ngày---</option>
                                                    <option value="01">01</option>
                                                    <option value="02">02</option>
                                                    <option value="03">03</option>
                                                    <option value="04">04</option>
                                                    <option value="05">05</option>
                                                    <option value="06">06</option>
                                                    <option value="07">07</option>
                                                    <option value="08">08</option>
                                                    <option value="09">09</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                    <option value="12">12</option>
                                                    <option value="13">13</option>
                                                    <option value="14">14</option>
                                                    <option value="15">15</option>
                                                    <option value="16">16</option>
                                                    <option value="17">17</option>
                                                    <option value="18">18</option>
                                                    <option value="19">19</option>
                                                    <option value="20">20</option>
                                                    <option value="21">21</option>
                                                    <option value="22">22</option>
                                                    <option value="23">23</option>
                                                    <option value="24">24</option>
                                                    <option value="25">25</option>
                                                    <option value="26">26</option>
                                                    <option value="27">27</option>
                                                    <option value="28">28</option>
                                                    <option value="29">29</option>
                                                    <option value="30">30</option>
                                                    <option value="31">31</option>
                                            </select>
                                            <select class="form-control" id="BBThangBiBenh" name="BBThangBiBenh">
                                                <option value="">---Chọn tháng---</option>
                                                    <option value="01">01</option>
                                                    <option value="02">02</option>
                                                    <option value="03">03</option>
                                                    <option value="04">04</option>
                                                    <option value="05">05</option>
                                                    <option value="06">06</option>
                                                    <option value="07">07</option>
                                                    <option value="08">08</option>
                                                    <option value="09">09</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                    <option value="12">12</option>
                                            </select>
                                            <select class="form-control" id="BBNamBiBenh" name="BBNamBiBenh">
                                                <option value="">---Chọn năm---</option>
                                                    <option value="1900">1900</option>
                                                    <option value="1901">1901</option>
                                                    <option value="1902">1902</option>
                                                    <option value="1903">1903</option>
                                                    <option value="1904">1904</option>
                                                    <option value="1905">1905</option>
                                                    <option value="1906">1906</option>
                                                    <option value="1907">1907</option>
                                                    <option value="1908">1908</option>
                                                    <option value="1909">1909</option>
                                                    <option value="1910">1910</option>
                                                    <option value="1911">1911</option>
                                                    <option value="1912">1912</option>
                                                    <option value="1913">1913</option>
                                                    <option value="1914">1914</option>
                                                    <option value="1915">1915</option>
                                                    <option value="1916">1916</option>
                                                    <option value="1917">1917</option>
                                                    <option value="1918">1918</option>
                                                    <option value="1919">1919</option>
                                                    <option value="1920">1920</option>
                                                    <option value="1921">1921</option>
                                                    <option value="1922">1922</option>
                                                    <option value="1923">1923</option>
                                                    <option value="1924">1924</option>
                                                    <option value="1925">1925</option>
                                                    <option value="1926">1926</option>
                                                    <option value="1927">1927</option>
                                                    <option value="1928">1928</option>
                                                    <option value="1929">1929</option>
                                                    <option value="1930">1930</option>
                                                    <option value="1931">1931</option>
                                                    <option value="1932">1932</option>
                                                    <option value="1933">1933</option>
                                                    <option value="1934">1934</option>
                                                    <option value="1935">1935</option>
                                                    <option value="1936">1936</option>
                                                    <option value="1937">1937</option>
                                                    <option value="1938">1938</option>
                                                    <option value="1939">1939</option>
                                                    <option value="1940">1940</option>
                                                    <option value="1941">1941</option>
                                                    <option value="1942">1942</option>
                                                    <option value="1943">1943</option>
                                                    <option value="1944">1944</option>
                                                    <option value="1945">1945</option>
                                                    <option value="1946">1946</option>
                                                    <option value="1947">1947</option>
                                                    <option value="1948">1948</option>
                                                    <option value="1949">1949</option>
                                                    <option value="1950">1950</option>
                                                    <option value="1951">1951</option>
                                                    <option value="1952">1952</option>
                                                    <option value="1953">1953</option>
                                                    <option value="1954">1954</option>
                                                    <option value="1955">1955</option>
                                                    <option value="1956">1956</option>
                                                    <option value="1957">1957</option>
                                                    <option value="1958">1958</option>
                                                    <option value="1959">1959</option>
                                                    <option value="1960">1960</option>
                                                    <option value="1961">1961</option>
                                                    <option value="1962">1962</option>
                                                    <option value="1963">1963</option>
                                                    <option value="1964">1964</option>
                                                    <option value="1965">1965</option>
                                                    <option value="1966">1966</option>
                                                    <option value="1967">1967</option>
                                                    <option value="1968">1968</option>
                                                    <option value="1969">1969</option>
                                                    <option value="1970">1970</option>
                                                    <option value="1971">1971</option>
                                                    <option value="1972">1972</option>
                                                    <option value="1973">1973</option>
                                                    <option value="1974">1974</option>
                                                    <option value="1975">1975</option>
                                                    <option value="1976">1976</option>
                                                    <option value="1977">1977</option>
                                                    <option value="1978">1978</option>
                                                    <option value="1979">1979</option>
                                                    <option value="1980">1980</option>
                                                    <option value="1981">1981</option>
                                                    <option value="1982">1982</option>
                                                    <option value="1983">1983</option>
                                                    <option value="1984">1984</option>
                                                    <option value="1985">1985</option>
                                                    <option value="1986">1986</option>
                                                    <option value="1987">1987</option>
                                                    <option value="1988">1988</option>
                                                    <option value="1989">1989</option>
                                                    <option value="1990">1990</option>
                                                    <option value="1991">1991</option>
                                                    <option value="1992">1992</option>
                                                    <option value="1993">1993</option>
                                                    <option value="1994">1994</option>
                                                    <option value="1995">1995</option>
                                                    <option value="1996">1996</option>
                                                    <option value="1997">1997</option>
                                                    <option value="1998">1998</option>
                                                    <option value="1999">1999</option>
                                                    <option value="2000">2000</option>
                                                    <option value="2001">2001</option>
                                                    <option value="2002">2002</option>
                                                    <option value="2003">2003</option>
                                                    <option value="2004">2004</option>
                                                    <option value="2005">2005</option>
                                                    <option value="2006">2006</option>
                                                    <option value="2007">2007</option>
                                                    <option value="2008">2008</option>
                                                    <option value="2009">2009</option>
                                                    <option value="2010">2010</option>
                                                    <option value="2011">2011</option>
                                                    <option value="2012">2012</option>
                                                    <option value="2013">2013</option>
                                                    <option value="2014">2014</option>
                                                    <option value="2015">2015</option>
                                                    <option value="2016">2016</option>
                                                    <option value="2017">2017</option>
                                                    <option value="2018">2018</option>
                                                    <option value="2019">2019</option>
                                                    <option value="2020">2020</option>
                                                    <option value="2021">2021</option>
                                                    <option value="2022">2022</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>Nơi bị bệnh: </label>
                                        <input type="text" class="form-control" id="BBNoiBiBenh" name="BBNoiBiBenh" value="">
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>Tình trạng bệnh tật: </label>
                                        <input type="text" class="form-control" id="BBTinhTrangBenh" name="BBTinhTrangBenh" value="">
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>Tỷ lệ tổn thương cơ thể (%)</label>
                                        <select class="form-control" id="BBTyLeTonThuongCoThe" name="BBTyLeTonThuongCoThe">
                                            <option value="0">---Chọn---</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                                <option value="10">10</option>
                                                <option value="11">11</option>
                                                <option value="12">12</option>
                                                <option value="13">13</option>
                                                <option value="14">14</option>
                                                <option value="15">15</option>
                                                <option value="16">16</option>
                                                <option value="17">17</option>
                                                <option value="18">18</option>
                                                <option value="19">19</option>
                                                <option value="20">20</option>
                                                <option value="21">21</option>
                                                <option value="22">22</option>
                                                <option value="23">23</option>
                                                <option value="24">24</option>
                                                <option value="25">25</option>
                                                <option value="26">26</option>
                                                <option value="27">27</option>
                                                <option value="28">28</option>
                                                <option value="29">29</option>
                                                <option value="30">30</option>
                                                <option value="31">31</option>
                                                <option value="32">32</option>
                                                <option value="33">33</option>
                                                <option value="34">34</option>
                                                <option value="35">35</option>
                                                <option value="36">36</option>
                                                <option value="37">37</option>
                                                <option value="38">38</option>
                                                <option value="39">39</option>
                                                <option value="40">40</option>
                                                <option value="41">41</option>
                                                <option value="42">42</option>
                                                <option value="43">43</option>
                                                <option value="44">44</option>
                                                <option value="45">45</option>
                                                <option value="46">46</option>
                                                <option value="47">47</option>
                                                <option value="48">48</option>
                                                <option value="49">49</option>
                                                <option value="50">50</option>
                                                <option value="51">51</option>
                                                <option value="52">52</option>
                                                <option value="53">53</option>
                                                <option value="54">54</option>
                                                <option value="55">55</option>
                                                <option value="56">56</option>
                                                <option value="57">57</option>
                                                <option value="58">58</option>
                                                <option value="59">59</option>
                                                <option value="60">60</option>
                                                <option value="61">61</option>
                                                <option value="62">62</option>
                                                <option value="63">63</option>
                                                <option value="64">64</option>
                                                <option value="65">65</option>
                                                <option value="66">66</option>
                                                <option value="67">67</option>
                                                <option value="68">68</option>
                                                <option value="69">69</option>
                                                <option value="70">70</option>
                                                <option value="71">71</option>
                                                <option value="72">72</option>
                                                <option value="73">73</option>
                                                <option value="74">74</option>
                                                <option value="75">75</option>
                                                <option value="76">76</option>
                                                <option value="77">77</option>
                                                <option value="78">78</option>
                                                <option value="79">79</option>
                                                <option value="80">80</option>
                                                <option value="81">81</option>
                                                <option value="82">82</option>
                                                <option value="83">83</option>
                                                <option value="84">84</option>
                                                <option value="85">85</option>
                                                <option value="86">86</option>
                                                <option value="87">87</option>
                                                <option value="88">88</option>
                                                <option value="89">89</option>
                                                <option value="90">90</option>
                                                <option value="91">91</option>
                                                <option value="92">92</option>
                                                <option value="93">93</option>
                                                <option value="94">94</option>
                                                <option value="95">95</option>
                                                <option value="96">96</option>
                                                <option value="97">97</option>
                                                <option value="98">98</option>
                                                <option value="99">99</option>
                                                <option value="100">100</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>Nơi điều trị: </label>
                                        <input type="text" class="form-control" id="BBNoiDieuTri" name="BBNoiDieuTri" value="">
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>Thời gian điều trị </label>
                                        <input type="text" class="form-control" id="BBThoiGianDieuTri" name="BBThoiGianDieuTri" value="">
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="form-group">
                                        <label>Thông tin giấy chứng nhận: </label>
                                        <input type="text" class="form-control" id="BBGiayChungNhan" name="BBGiayChungNhan" value="">
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="form-group">
                                        <label>Thông tin biên bản giám định y khoa: </label>
                                        <input type="text" class="form-control" id="BBGiayGiamDinh" name="BBGiayGiamDinh" value="">
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>Thời gian phục vụ trong quân đội, công an:</label>
                                        <div class="input-group">
                                            <select class="form-control" id="BBNamQDCA" name="BBNamQDCA">
                                                <option value="">---Chọn năm ---</option>
                                                    <option value="1">1 (năm)</option>
                                                    <option value="2">2 (năm)</option>
                                                    <option value="3">3 (năm)</option>
                                                    <option value="4">4 (năm)</option>
                                                    <option value="5">5 (năm)</option>
                                                    <option value="6">6 (năm)</option>
                                                    <option value="7">7 (năm)</option>
                                                    <option value="8">8 (năm)</option>
                                                    <option value="9">9 (năm)</option>
                                                    <option value="10">10 (năm)</option>
                                                    <option value="11">11 (năm)</option>
                                                    <option value="12">12 (năm)</option>
                                                    <option value="13">13 (năm)</option>
                                                    <option value="14">14 (năm)</option>
                                                    <option value="15">15 (năm)</option>
                                                    <option value="16">16 (năm)</option>
                                                    <option value="17">17 (năm)</option>
                                                    <option value="18">18 (năm)</option>
                                                    <option value="19">19 (năm)</option>
                                                    <option value="20">20 (năm)</option>
                                                    <option value="21">21 (năm)</option>
                                                    <option value="22">22 (năm)</option>
                                                    <option value="23">23 (năm)</option>
                                                    <option value="24">24 (năm)</option>
                                                    <option value="25">25 (năm)</option>
                                                    <option value="26">26 (năm)</option>
                                                    <option value="27">27 (năm)</option>
                                                    <option value="28">28 (năm)</option>
                                                    <option value="29">29 (năm)</option>
                                                    <option value="30">30 (năm)</option>
                                                    <option value="31">31 (năm)</option>
                                                    <option value="32">32 (năm)</option>
                                                    <option value="33">33 (năm)</option>
                                                    <option value="34">34 (năm)</option>
                                                    <option value="35">35 (năm)</option>
                                                    <option value="36">36 (năm)</option>
                                                    <option value="37">37 (năm)</option>
                                                    <option value="38">38 (năm)</option>
                                                    <option value="39">39 (năm)</option>
                                                    <option value="40">40 (năm)</option>
                                                    <option value="41">41 (năm)</option>
                                                    <option value="42">42 (năm)</option>
                                                    <option value="43">43 (năm)</option>
                                                    <option value="44">44 (năm)</option>
                                                    <option value="45">45 (năm)</option>
                                                    <option value="46">46 (năm)</option>
                                                    <option value="47">47 (năm)</option>
                                                    <option value="48">48 (năm)</option>
                                                    <option value="49">49 (năm)</option>
                                                    <option value="50">50 (năm)</option>
                                                    <option value="51">51 (năm)</option>
                                                    <option value="52">52 (năm)</option>
                                                    <option value="53">53 (năm)</option>
                                                    <option value="54">54 (năm)</option>
                                                    <option value="55">55 (năm)</option>
                                                    <option value="56">56 (năm)</option>
                                                    <option value="57">57 (năm)</option>
                                                    <option value="58">58 (năm)</option>
                                                    <option value="59">59 (năm)</option>
                                                    <option value="60">60 (năm)</option>
                                                    <option value="61">61 (năm)</option>
                                                    <option value="62">62 (năm)</option>
                                                    <option value="63">63 (năm)</option>
                                                    <option value="64">64 (năm)</option>
                                                    <option value="65">65 (năm)</option>
                                                    <option value="66">66 (năm)</option>
                                                    <option value="67">67 (năm)</option>
                                                    <option value="68">68 (năm)</option>
                                                    <option value="69">69 (năm)</option>
                                                    <option value="70">70 (năm)</option>
                                            </select>
                                            <select class="form-control" id="BBThangQDCA" name="BBThangQDCA">
                                                <option value="">---Chọn tháng---</option>
                                                    <option value="1">1 (tháng)</option>
                                                    <option value="2">2 (tháng)</option>
                                                    <option value="3">3 (tháng)</option>
                                                    <option value="4">4 (tháng)</option>
                                                    <option value="5">5 (tháng)</option>
                                                    <option value="6">6 (tháng)</option>
                                                    <option value="7">7 (tháng)</option>
                                                    <option value="8">8 (tháng)</option>
                                                    <option value="9">9 (tháng)</option>
                                                    <option value="10">10 (tháng)</option>
                                                    <option value="11">11 (tháng)</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>Thời gian ở chiến trường:</label>
                                        <div class="input-group">
                                            <select class="form-control" id="BBNamChienTruong" name="BBNamChienTruong">
                                                <option value="">---Chọn năm ---</option>
                                                    <option value="1">1 (năm)</option>
                                                    <option value="2">2 (năm)</option>
                                                    <option value="3">3 (năm)</option>
                                                    <option value="4">4 (năm)</option>
                                                    <option value="5">5 (năm)</option>
                                                    <option value="6">6 (năm)</option>
                                                    <option value="7">7 (năm)</option>
                                                    <option value="8">8 (năm)</option>
                                                    <option value="9">9 (năm)</option>
                                                    <option value="10">10 (năm)</option>
                                                    <option value="11">11 (năm)</option>
                                                    <option value="12">12 (năm)</option>
                                                    <option value="13">13 (năm)</option>
                                                    <option value="14">14 (năm)</option>
                                                    <option value="15">15 (năm)</option>
                                                    <option value="16">16 (năm)</option>
                                                    <option value="17">17 (năm)</option>
                                                    <option value="18">18 (năm)</option>
                                                    <option value="19">19 (năm)</option>
                                                    <option value="20">20 (năm)</option>
                                                    <option value="21">21 (năm)</option>
                                                    <option value="22">22 (năm)</option>
                                                    <option value="23">23 (năm)</option>
                                                    <option value="24">24 (năm)</option>
                                                    <option value="25">25 (năm)</option>
                                                    <option value="26">26 (năm)</option>
                                                    <option value="27">27 (năm)</option>
                                                    <option value="28">28 (năm)</option>
                                                    <option value="29">29 (năm)</option>
                                                    <option value="30">30 (năm)</option>
                                                    <option value="31">31 (năm)</option>
                                                    <option value="32">32 (năm)</option>
                                                    <option value="33">33 (năm)</option>
                                                    <option value="34">34 (năm)</option>
                                                    <option value="35">35 (năm)</option>
                                                    <option value="36">36 (năm)</option>
                                                    <option value="37">37 (năm)</option>
                                                    <option value="38">38 (năm)</option>
                                                    <option value="39">39 (năm)</option>
                                                    <option value="40">40 (năm)</option>
                                                    <option value="41">41 (năm)</option>
                                                    <option value="42">42 (năm)</option>
                                                    <option value="43">43 (năm)</option>
                                                    <option value="44">44 (năm)</option>
                                                    <option value="45">45 (năm)</option>
                                                    <option value="46">46 (năm)</option>
                                                    <option value="47">47 (năm)</option>
                                                    <option value="48">48 (năm)</option>
                                                    <option value="49">49 (năm)</option>
                                                    <option value="50">50 (năm)</option>
                                                    <option value="51">51 (năm)</option>
                                                    <option value="52">52 (năm)</option>
                                                    <option value="53">53 (năm)</option>
                                                    <option value="54">54 (năm)</option>
                                                    <option value="55">55 (năm)</option>
                                                    <option value="56">56 (năm)</option>
                                                    <option value="57">57 (năm)</option>
                                                    <option value="58">58 (năm)</option>
                                                    <option value="59">59 (năm)</option>
                                                    <option value="60">60 (năm)</option>
                                                    <option value="61">61 (năm)</option>
                                                    <option value="62">62 (năm)</option>
                                                    <option value="63">63 (năm)</option>
                                                    <option value="64">64 (năm)</option>
                                                    <option value="65">65 (năm)</option>
                                                    <option value="66">66 (năm)</option>
                                                    <option value="67">67 (năm)</option>
                                                    <option value="68">68 (năm)</option>
                                                    <option value="69">69 (năm)</option>
                                                    <option value="70">70 (năm)</option>
                                            </select>
                                            <select class="form-control" id="BBThangChienTruong" name="BBThangChienTruong">
                                                <option value="">---Chọn tháng---</option>
                                                    <option value="1">1 (tháng)</option>
                                                    <option value="2">2 (tháng)</option>
                                                    <option value="3">3 (tháng)</option>
                                                    <option value="4">4 (tháng)</option>
                                                    <option value="5">5 (tháng)</option>
                                                    <option value="6">6 (tháng)</option>
                                                    <option value="7">7 (tháng)</option>
                                                    <option value="8">8 (tháng)</option>
                                                    <option value="9">9 (tháng)</option>
                                                    <option value="10">10 (tháng)</option>
                                                    <option value="11">11 (tháng)</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>Thời gian ở vùng đặc biệt gian khổ:</label>
                                        <div class="input-group">
                                            <select class="form-control" id="BBNamVungKKGK" name="BBNamVungKKGK">
                                                <option value="">---Chọn năm ---</option>
                                                    <option value="1">1 (năm)</option>
                                                    <option value="2">2 (năm)</option>
                                                    <option value="3">3 (năm)</option>
                                                    <option value="4">4 (năm)</option>
                                                    <option value="5">5 (năm)</option>
                                                    <option value="6">6 (năm)</option>
                                                    <option value="7">7 (năm)</option>
                                                    <option value="8">8 (năm)</option>
                                                    <option value="9">9 (năm)</option>
                                                    <option value="10">10 (năm)</option>
                                                    <option value="11">11 (năm)</option>
                                                    <option value="12">12 (năm)</option>
                                                    <option value="13">13 (năm)</option>
                                                    <option value="14">14 (năm)</option>
                                                    <option value="15">15 (năm)</option>
                                                    <option value="16">16 (năm)</option>
                                                    <option value="17">17 (năm)</option>
                                                    <option value="18">18 (năm)</option>
                                                    <option value="19">19 (năm)</option>
                                                    <option value="20">20 (năm)</option>
                                                    <option value="21">21 (năm)</option>
                                                    <option value="22">22 (năm)</option>
                                                    <option value="23">23 (năm)</option>
                                                    <option value="24">24 (năm)</option>
                                                    <option value="25">25 (năm)</option>
                                                    <option value="26">26 (năm)</option>
                                                    <option value="27">27 (năm)</option>
                                                    <option value="28">28 (năm)</option>
                                                    <option value="29">29 (năm)</option>
                                                    <option value="30">30 (năm)</option>
                                                    <option value="31">31 (năm)</option>
                                                    <option value="32">32 (năm)</option>
                                                    <option value="33">33 (năm)</option>
                                                    <option value="34">34 (năm)</option>
                                                    <option value="35">35 (năm)</option>
                                                    <option value="36">36 (năm)</option>
                                                    <option value="37">37 (năm)</option>
                                                    <option value="38">38 (năm)</option>
                                                    <option value="39">39 (năm)</option>
                                                    <option value="40">40 (năm)</option>
                                                    <option value="41">41 (năm)</option>
                                                    <option value="42">42 (năm)</option>
                                                    <option value="43">43 (năm)</option>
                                                    <option value="44">44 (năm)</option>
                                                    <option value="45">45 (năm)</option>
                                                    <option value="46">46 (năm)</option>
                                                    <option value="47">47 (năm)</option>
                                                    <option value="48">48 (năm)</option>
                                                    <option value="49">49 (năm)</option>
                                                    <option value="50">50 (năm)</option>
                                                    <option value="51">51 (năm)</option>
                                                    <option value="52">52 (năm)</option>
                                                    <option value="53">53 (năm)</option>
                                                    <option value="54">54 (năm)</option>
                                                    <option value="55">55 (năm)</option>
                                                    <option value="56">56 (năm)</option>
                                                    <option value="57">57 (năm)</option>
                                                    <option value="58">58 (năm)</option>
                                                    <option value="59">59 (năm)</option>
                                                    <option value="60">60 (năm)</option>
                                                    <option value="61">61 (năm)</option>
                                                    <option value="62">62 (năm)</option>
                                                    <option value="63">63 (năm)</option>
                                                    <option value="64">64 (năm)</option>
                                                    <option value="65">65 (năm)</option>
                                                    <option value="66">66 (năm)</option>
                                                    <option value="67">67 (năm)</option>
                                                    <option value="68">68 (năm)</option>
                                                    <option value="69">69 (năm)</option>
                                                    <option value="70">70 (năm)</option>
                                            </select>
                                            <select class="form-control" id="BBThangVungKKGK" name="BBThangVungKKGK">
                                                <option value="">---Chọn tháng---</option>
                                                    <option value="1">1 (tháng)</option>
                                                    <option value="2">2 (tháng)</option>
                                                    <option value="3">3 (tháng)</option>
                                                    <option value="4">4 (tháng)</option>
                                                    <option value="5">5 (tháng)</option>
                                                    <option value="6">6 (tháng)</option>
                                                    <option value="7">7 (tháng)</option>
                                                    <option value="8">8 (tháng)</option>
                                                    <option value="9">9 (tháng)</option>
                                                    <option value="10">10 (tháng)</option>
                                                    <option value="11">11 (tháng)</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                document.getElementById('BB').onclick = function (e) {
                    if (this.checked) {
                        document.getElementById("frm_bb").style.display = "block";
                    }
                    else {
                        document.getElementById("frm_bb").style.display = "none";
                    }
                };
                document.getElementById("btn_ttbb").onclick = function (e) {
                    var x = document.getElementById("frm_bb").style.display;
                    if (x == "none") {
                        document.getElementById("frm_bb").style.display = "block";
                    }
                    else {
                        document.getElementById("frm_bb").style.display = "none";
                    }
                };
            </script>
            
                <div class="row" style="">
                <div class="col-xl-12">
                    <div class="card card-custom gutter-b example example-compact" style="border: 1px solid #60aee4;">
                        <div class="card-header">
                            <div class="checkbox-inline">
                                <label class="checkbox checkbox-lg">
                                    <input type="checkbox" data-val="true" data-val-required="The HH field is required." id="HH" name="HH" value="true"><span></span>
                                    <label class="card-title">
                                         <span class="label label-danger label-dot mr-2"></span>
                                        Người hoạt động kháng chiến nhiễm chất độc hoá học
                                    </label>
                                </label>
                            </div>
                            <div class="card-toolbar">
                                <button type="button" class="btn btn-clean btn-sm btn-icon" id="btn_tthh" title="Thu gọn/ Hiển thị">
                                    <i class="ki ki-bold-more-hor"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body" style="display: none" id="frm_hh">
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>Ngày tháng năm công tác/nhập ngũ:</label>
                                        <input type="text" class="form-control" id="HHNgayThamGiaCM" name="HHNgayThamGiaCM" value="">
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>Cơ quan, đơn vị hoạt động:</label>
                                        <input type="text" class="form-control" id="HHCoQuanDonViHoatDong" name="HHCoQuanDonViHoatDong" value="">
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>Địa bàn hoạt động:</label>
                                        <input type="text" class="form-control" id="HHDiaBanHoatDong" name="HHDiaBanHoatDong" value="">
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>Trường hợp nhiễm CĐHH:</label>
                                        <input type="text" class="form-control" id="HHTruongHopNhiemCDHH" name="HHTruongHopNhiemCDHH" value="">
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>Giấy tờ chứng minh có thời gian hoạt động ở chiến trường:</label>
                                        <input type="text" class="form-control" id="HHGiayCNXNSo" name="HHGiayCNXNSo" value="">
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>Ngày cấp giấy tờ chứng minh có thời gian hoạt động ở chiến trường:</label>
                                        <input type="text" class="form-control" id="HHNgayCapGiayCNXN" name="HHNgayCapGiayCNXN" value="">
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>Đơn vị cấp giấy tờ chứng minh có thời gian hoạt động ở chiến trường :</label>
                                        <input type="text" class="form-control" id="HHDonViCapGiayCNXN" name="HHDonViCapGiayCNXN" value="">
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>Biên bản giám định y khoa:</label>
                                        <input type="text" class="form-control" id="HHBienBanGDBT" name="HHBienBanGDBT" value="">
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>Ngày cấp biên bản giám định y khoa:</label>
                                        <input type="text" class="form-control" id="HHBienBanGDBTNgay" name="HHBienBanGDBTNgay" value="">
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>Đơn vị cấp biên bản giám định y khoa:</label>
                                        <input type="text" class="form-control" id="HHBienBanGDBTDonViBH" name="HHBienBanGDBTDonViBH" value="">
                                    </div>
                                </div>
                                <div class="col-xl-10">
                                    <div class="form-group">
                                        <label>Tình trạng bệnh tật theo hồ sơ:</label>
                                        <input type="text" class="form-control" id="HHTinhTrangBenhTat" name="HHTinhTrangBenhTat" value="">
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="form-group">
                                        <label>Quá trình tham gia hoạt động kháng chiến</label>
                                        <textarea class="form-control autosize" rows="5" placeholder="VD: 10/1930 đến 10/1932: Tiểu đoàn 307 - Thượng sỹ - Mặt trận phía Nam" id="HHQuaTrinhHoatDongCM" name="HHQuaTrinhHoatDongCM"></textarea>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>Số quyết định trợ cấp:</label>
                                        <input type="text" class="form-control" id="HHQuyetDinhTCSo" name="HHQuyetDinhTCSo" value="">
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>Ngày quyết định trợ cấp:</label>
                                        <input type="text" class="form-control" id="HHQuyetDinhTCNgay" name="HHQuyetDinhTCNgay" value="">
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>Ngày hưởng trợ cấp:</label>
                                        <input type="date" class="form-control" data-val="true" data-val-required="The HHHuongTCNgay field is required." id="HHHuongTCNgay" name="HHHuongTCNgay" value="0001-01-01">
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label>Cơ quan/Đơn vị cấp quyết định trợ cấp:</label>
                                        <input type="text" class="form-control" id="HHQuyetDinhTCCoQuanCap" name="HHQuyetDinhTCCoQuanCap" value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                document.getElementById('HH').onclick = function (e) {
                    if (this.checked) {
                        document.getElementById("frm_hh").style.display = "block";
                    }
                    else {
                        document.getElementById("frm_hh").style.display = "none";
                    }
                };
                document.getElementById("btn_tthh").onclick = function (e) {
                    var x = document.getElementById("frm_hh").style.display;
                    if (x == "none") {
                        document.getElementById("frm_hh").style.display = "block";
                    }
                    else {
                        document.getElementById("frm_hh").style.display = "none";
                    }
                };
            </script>
                <div class="row" style="">
                <div class="col-xl-12">
                    <div class="card card-custom gutter-b example example-compact" style="border: 1px solid #60aee4;">
                        <div class="card-header">
                            <div class="checkbox-inline">
                                <label class="checkbox checkbox-lg">
                                    <input type="checkbox" data-val="true" data-val-required="The TD field is required." id="TD" name="TD" value="true"><span></span>
                                    <label class="card-title">
                                         <span class="label label-danger label-dot mr-2"></span>
                                        Người hoạt động cách mạng, kháng chiến, bảo vệ Tổ quốc, làm nghĩa vị quốc tế bị địch bắt tù, đầy
                                    </label>
                                </label>
                            </div>
                            <div class="card-toolbar">
                                <button type="button" class="btn btn-clean btn-sm btn-icon" id="btn_tttd" title="Thu gọn/ Hiển thị">
                                    <i class="ki ki-bold-more-hor"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body" style="display: none" id="frm_td">
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="form-group">
                                        <label>Quá trình tham gia hoạt động Cách mạng</label>
                                        <textarea class="form-control autosize" rows="5" placeholder="VD: 10/1930 đến 10/1932: Tiểu đoàn 307 - Thượng sỹ - Mặt trận phía Nam" id="TDQuaTrinhHoatDongCM" name="TDQuaTrinhHoatDongCM"></textarea>
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="form-group">
                                        <label>Quá trình bị địch bắt tù, đày</label>
                                        <textarea class="form-control" rows="5" placeholder="VD: 10/1930 đến 10/1932: nhà tù Côn Đảo - Trung đoàn 102" id="TDQuaTrinhHoatDongCM" name="TDQuaTrinhHoatDongCM"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                document.getElementById('TD').onclick = function (e) {
                    if (this.checked) {
                        document.getElementById("frm_td").style.display = "block";
                    }
                    else {
                        document.getElementById("frm_td").style.display = "none";
                    }
                };
                document.getElementById("btn_tttd").onclick = function (e) {
                    var x = document.getElementById("frm_td").style.display;
                    if (x == "none") {
                        document.getElementById("frm_td").style.display = "block";
                    }
                    else {
                        document.getElementById("frm_td").style.display = "none";
                    }
                };
            </script>
                <div class="row" style="">
                <div class="col-xl-12">
                    <div class="card card-custom gutter-b example example-compact" style="border: 1px solid #60aee4;">
                        <div class="card-header">
                            <div class="checkbox-inline">
                                <label class="checkbox checkbox-lg">
                                    <input type="checkbox" checked="checked" data-val="true" data-val-required="The KC field is required." id="KC" name="KC" value="true"><span></span>
                                    <label class="card-title">
                                         <span class="label label-danger label-dot mr-2"></span>
                                        Hoạt động kháng chiến giải phóng dân tộc, bảo vệ Tổ quốc, làm nghĩa vụ quốc tế
                                    </label>
                                </label>
                            </div>
                            <div class="card-toolbar">
                                <button type="button" class="btn btn-clean btn-sm btn-icon" id="btn_ttkc" title="Thu gọn/ Hiển thị">
                                    <i class="ki ki-bold-more-hor"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body" style="" id="frm_kc">
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="col-xl-12">
                                        <div class="form-group">
                                            <label>Tham gia từ ngày</label>
                                            <div class="input-group">
                                                <select class="form-control" id="KCNgayTu" name="KCNgayTu">
                                                    <option value="">---Chọn ngày---</option>
                                                        <option value="01">01</option>
                                                        <option value="02">02</option>
                                                        <option value="03">03</option>
                                                        <option value="04">04</option>
                                                        <option value="05">05</option>
                                                        <option value="06">06</option>
                                                        <option value="07">07</option>
                                                        <option value="08">08</option>
                                                        <option value="09">09</option>
                                                        <option value="10">10</option>
                                                        <option value="11">11</option>
                                                        <option value="12">12</option>
                                                        <option value="13">13</option>
                                                        <option value="14">14</option>
                                                        <option value="15">15</option>
                                                        <option value="16">16</option>
                                                        <option value="17">17</option>
                                                        <option value="18" selected="selected">18</option>
                                                        <option value="19">19</option>
                                                        <option value="20">20</option>
                                                        <option value="21">21</option>
                                                        <option value="22">22</option>
                                                        <option value="23">23</option>
                                                        <option value="24">24</option>
                                                        <option value="25">25</option>
                                                        <option value="26">26</option>
                                                        <option value="27">27</option>
                                                        <option value="28">28</option>
                                                        <option value="29">29</option>
                                                        <option value="30">30</option>
                                                        <option value="31">31</option>
                                                </select>
                                                <select class="form-control" id="KCThangTu" name="KCThangTu">
                                                    <option value="">---Chọn tháng---</option>
                                                        <option value="01">01</option>
                                                        <option value="02">02</option>
                                                        <option value="03">03</option>
                                                        <option value="04">04</option>
                                                        <option value="05">05</option>
                                                        <option value="06">06</option>
                                                        <option value="07">07</option>
                                                        <option value="08">08</option>
                                                        <option value="09">09</option>
                                                        <option value="10" selected="selected">10</option>
                                                        <option value="11">11</option>
                                                        <option value="12">12</option>
                                                </select>
                                                <select class="form-control" id="KCNamTu" name="KCNamTu">
                                                    <option value="">---Chọn năm---</option>
                                                        <option value="1900">1900</option>
                                                        <option value="1901">1901</option>
                                                        <option value="1902">1902</option>
                                                        <option value="1903">1903</option>
                                                        <option value="1904">1904</option>
                                                        <option value="1905">1905</option>
                                                        <option value="1906">1906</option>
                                                        <option value="1907">1907</option>
                                                        <option value="1908">1908</option>
                                                        <option value="1909">1909</option>
                                                        <option value="1910">1910</option>
                                                        <option value="1911">1911</option>
                                                        <option value="1912">1912</option>
                                                        <option value="1913">1913</option>
                                                        <option value="1914">1914</option>
                                                        <option value="1915">1915</option>
                                                        <option value="1916">1916</option>
                                                        <option value="1917">1917</option>
                                                        <option value="1918">1918</option>
                                                        <option value="1919">1919</option>
                                                        <option value="1920">1920</option>
                                                        <option value="1921">1921</option>
                                                        <option value="1922">1922</option>
                                                        <option value="1923">1923</option>
                                                        <option value="1924">1924</option>
                                                        <option value="1925">1925</option>
                                                        <option value="1926">1926</option>
                                                        <option value="1927">1927</option>
                                                        <option value="1928">1928</option>
                                                        <option value="1929">1929</option>
                                                        <option value="1930">1930</option>
                                                        <option value="1931">1931</option>
                                                        <option value="1932">1932</option>
                                                        <option value="1933">1933</option>
                                                        <option value="1934">1934</option>
                                                        <option value="1935">1935</option>
                                                        <option value="1936">1936</option>
                                                        <option value="1937">1937</option>
                                                        <option value="1938">1938</option>
                                                        <option value="1939">1939</option>
                                                        <option value="1940">1940</option>
                                                        <option value="1941">1941</option>
                                                        <option value="1942">1942</option>
                                                        <option value="1943">1943</option>
                                                        <option value="1944">1944</option>
                                                        <option value="1945">1945</option>
                                                        <option value="1946">1946</option>
                                                        <option value="1947">1947</option>
                                                        <option value="1948">1948</option>
                                                        <option value="1949">1949</option>
                                                        <option value="1950">1950</option>
                                                        <option value="1951">1951</option>
                                                        <option value="1952">1952</option>
                                                        <option value="1953">1953</option>
                                                        <option value="1954">1954</option>
                                                        <option value="1955">1955</option>
                                                        <option value="1956">1956</option>
                                                        <option value="1957">1957</option>
                                                        <option value="1958">1958</option>
                                                        <option value="1959">1959</option>
                                                        <option value="1960">1960</option>
                                                        <option value="1961">1961</option>
                                                        <option value="1962">1962</option>
                                                        <option value="1963">1963</option>
                                                        <option value="1964">1964</option>
                                                        <option value="1965">1965</option>
                                                        <option value="1966">1966</option>
                                                        <option value="1967">1967</option>
                                                        <option value="1968">1968</option>
                                                        <option value="1969">1969</option>
                                                        <option value="1970">1970</option>
                                                        <option value="1971" selected="selected">1971</option>
                                                        <option value="1972">1972</option>
                                                        <option value="1973">1973</option>
                                                        <option value="1974">1974</option>
                                                        <option value="1975">1975</option>
                                                        <option value="1976">1976</option>
                                                        <option value="1977">1977</option>
                                                        <option value="1978">1978</option>
                                                        <option value="1979">1979</option>
                                                        <option value="1980">1980</option>
                                                        <option value="1981">1981</option>
                                                        <option value="1982">1982</option>
                                                        <option value="1983">1983</option>
                                                        <option value="1984">1984</option>
                                                        <option value="1985">1985</option>
                                                        <option value="1986">1986</option>
                                                        <option value="1987">1987</option>
                                                        <option value="1988">1988</option>
                                                        <option value="1989">1989</option>
                                                        <option value="1990">1990</option>
                                                        <option value="1991">1991</option>
                                                        <option value="1992">1992</option>
                                                        <option value="1993">1993</option>
                                                        <option value="1994">1994</option>
                                                        <option value="1995">1995</option>
                                                        <option value="1996">1996</option>
                                                        <option value="1997">1997</option>
                                                        <option value="1998">1998</option>
                                                        <option value="1999">1999</option>
                                                        <option value="2000">2000</option>
                                                        <option value="2001">2001</option>
                                                        <option value="2002">2002</option>
                                                        <option value="2003">2003</option>
                                                        <option value="2004">2004</option>
                                                        <option value="2005">2005</option>
                                                        <option value="2006">2006</option>
                                                        <option value="2007">2007</option>
                                                        <option value="2008">2008</option>
                                                        <option value="2009">2009</option>
                                                        <option value="2010">2010</option>
                                                        <option value="2011">2011</option>
                                                        <option value="2012">2012</option>
                                                        <option value="2013">2013</option>
                                                        <option value="2014">2014</option>
                                                        <option value="2015">2015</option>
                                                        <option value="2016">2016</option>
                                                        <option value="2017">2017</option>
                                                        <option value="2018">2018</option>
                                                        <option value="2019">2019</option>
                                                        <option value="2020">2020</option>
                                                        <option value="2021">2021</option>
                                                        <option value="2022">2022</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="col-xl-12">
                                        <div class="form-group">
                                            <label>Tham gia đến ngày</label>
                                            <div class="input-group">
                                                <select class="form-control" id="KCNgayDen" name="KCNgayDen">
                                                    <option value="">---Chọn ngày---</option>
                                                        <option value="01">01</option>
                                                        <option value="02">02</option>
                                                        <option value="03">03</option>
                                                        <option value="04">04</option>
                                                        <option value="05">05</option>
                                                        <option value="06">06</option>
                                                        <option value="07">07</option>
                                                        <option value="08">08</option>
                                                        <option value="09">09</option>
                                                        <option value="10">10</option>
                                                        <option value="11">11</option>
                                                        <option value="12">12</option>
                                                        <option value="13">13</option>
                                                        <option value="14">14</option>
                                                        <option value="15">15</option>
                                                        <option value="16">16</option>
                                                        <option value="17">17</option>
                                                        <option value="18" selected="selected">18</option>
                                                        <option value="19">19</option>
                                                        <option value="20">20</option>
                                                        <option value="21">21</option>
                                                        <option value="22">22</option>
                                                        <option value="23">23</option>
                                                        <option value="24">24</option>
                                                        <option value="25">25</option>
                                                        <option value="26">26</option>
                                                        <option value="27">27</option>
                                                        <option value="28">28</option>
                                                        <option value="29">29</option>
                                                        <option value="30">30</option>
                                                        <option value="31">31</option>
                                                </select>
                                                <select class="form-control" id="KCThangDen" name="KCThangDen">
                                                    <option value="">---Chọn tháng---</option>
                                                        <option value="01" selected="selected">01</option>
                                                        <option value="02">02</option>
                                                        <option value="03">03</option>
                                                        <option value="04">04</option>
                                                        <option value="05">05</option>
                                                        <option value="06">06</option>
                                                        <option value="07">07</option>
                                                        <option value="08">08</option>
                                                        <option value="09">09</option>
                                                        <option value="10">10</option>
                                                        <option value="11">11</option>
                                                        <option value="12">12</option>
                                                </select>
                                                <select class="form-control" id="KCNamDen" name="KCNamDen">
                                                    <option value="">---Chọn năm---</option>
                                                        <option value="1900">1900</option>
                                                        <option value="1901">1901</option>
                                                        <option value="1902">1902</option>
                                                        <option value="1903">1903</option>
                                                        <option value="1904">1904</option>
                                                        <option value="1905">1905</option>
                                                        <option value="1906">1906</option>
                                                        <option value="1907">1907</option>
                                                        <option value="1908">1908</option>
                                                        <option value="1909">1909</option>
                                                        <option value="1910">1910</option>
                                                        <option value="1911">1911</option>
                                                        <option value="1912">1912</option>
                                                        <option value="1913">1913</option>
                                                        <option value="1914">1914</option>
                                                        <option value="1915">1915</option>
                                                        <option value="1916">1916</option>
                                                        <option value="1917">1917</option>
                                                        <option value="1918">1918</option>
                                                        <option value="1919">1919</option>
                                                        <option value="1920">1920</option>
                                                        <option value="1921">1921</option>
                                                        <option value="1922">1922</option>
                                                        <option value="1923">1923</option>
                                                        <option value="1924">1924</option>
                                                        <option value="1925">1925</option>
                                                        <option value="1926">1926</option>
                                                        <option value="1927">1927</option>
                                                        <option value="1928">1928</option>
                                                        <option value="1929">1929</option>
                                                        <option value="1930">1930</option>
                                                        <option value="1931">1931</option>
                                                        <option value="1932">1932</option>
                                                        <option value="1933">1933</option>
                                                        <option value="1934">1934</option>
                                                        <option value="1935">1935</option>
                                                        <option value="1936">1936</option>
                                                        <option value="1937">1937</option>
                                                        <option value="1938">1938</option>
                                                        <option value="1939">1939</option>
                                                        <option value="1940">1940</option>
                                                        <option value="1941">1941</option>
                                                        <option value="1942">1942</option>
                                                        <option value="1943">1943</option>
                                                        <option value="1944">1944</option>
                                                        <option value="1945">1945</option>
                                                        <option value="1946">1946</option>
                                                        <option value="1947">1947</option>
                                                        <option value="1948">1948</option>
                                                        <option value="1949">1949</option>
                                                        <option value="1950">1950</option>
                                                        <option value="1951">1951</option>
                                                        <option value="1952">1952</option>
                                                        <option value="1953">1953</option>
                                                        <option value="1954">1954</option>
                                                        <option value="1955">1955</option>
                                                        <option value="1956">1956</option>
                                                        <option value="1957">1957</option>
                                                        <option value="1958">1958</option>
                                                        <option value="1959">1959</option>
                                                        <option value="1960">1960</option>
                                                        <option value="1961">1961</option>
                                                        <option value="1962">1962</option>
                                                        <option value="1963">1963</option>
                                                        <option value="1964">1964</option>
                                                        <option value="1965">1965</option>
                                                        <option value="1966">1966</option>
                                                        <option value="1967">1967</option>
                                                        <option value="1968">1968</option>
                                                        <option value="1969">1969</option>
                                                        <option value="1970">1970</option>
                                                        <option value="1971">1971</option>
                                                        <option value="1972">1972</option>
                                                        <option value="1973">1973</option>
                                                        <option value="1974">1974</option>
                                                        <option value="1975">1975</option>
                                                        <option value="1976">1976</option>
                                                        <option value="1977">1977</option>
                                                        <option value="1978">1978</option>
                                                        <option value="1979">1979</option>
                                                        <option value="1980">1980</option>
                                                        <option value="1981" selected="selected">1981</option>
                                                        <option value="1982">1982</option>
                                                        <option value="1983">1983</option>
                                                        <option value="1984">1984</option>
                                                        <option value="1985">1985</option>
                                                        <option value="1986">1986</option>
                                                        <option value="1987">1987</option>
                                                        <option value="1988">1988</option>
                                                        <option value="1989">1989</option>
                                                        <option value="1990">1990</option>
                                                        <option value="1991">1991</option>
                                                        <option value="1992">1992</option>
                                                        <option value="1993">1993</option>
                                                        <option value="1994">1994</option>
                                                        <option value="1995">1995</option>
                                                        <option value="1996">1996</option>
                                                        <option value="1997">1997</option>
                                                        <option value="1998">1998</option>
                                                        <option value="1999">1999</option>
                                                        <option value="2000">2000</option>
                                                        <option value="2001">2001</option>
                                                        <option value="2002">2002</option>
                                                        <option value="2003">2003</option>
                                                        <option value="2004">2004</option>
                                                        <option value="2005">2005</option>
                                                        <option value="2006">2006</option>
                                                        <option value="2007">2007</option>
                                                        <option value="2008">2008</option>
                                                        <option value="2009">2009</option>
                                                        <option value="2010">2010</option>
                                                        <option value="2011">2011</option>
                                                        <option value="2012">2012</option>
                                                        <option value="2013">2013</option>
                                                        <option value="2014">2014</option>
                                                        <option value="2015">2015</option>
                                                        <option value="2016">2016</option>
                                                        <option value="2017">2017</option>
                                                        <option value="2018">2018</option>
                                                        <option value="2019">2019</option>
                                                        <option value="2020">2020</option>
                                                        <option value="2021">2021</option>
                                                        <option value="2022">2022</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="col-xl-12">
                                        <div class="form-group">
                                            <label>Thời gian thực tế</label>
                                            <div class="input-group">
                                                <select class="form-control" id="KCNamThucTe" name="KCNamThucTe">
                                                    <option value="">---Chọn năm---</option>
                                                        <option value="1">1 Năm</option>
                                                        <option value="2">2 Năm</option>
                                                        <option value="3">3 Năm</option>
                                                        <option value="4">4 Năm</option>
                                                        <option value="5">5 Năm</option>
                                                        <option value="6">6 Năm</option>
                                                        <option value="7">7 Năm</option>
                                                        <option value="8">8 Năm</option>
                                                        <option value="9">9 Năm</option>
                                                        <option value="10" selected="selected">10 Năm</option>
                                                        <option value="11">11 Năm</option>
                                                        <option value="12">12 Năm</option>
                                                        <option value="13">13 Năm</option>
                                                        <option value="14">14 Năm</option>
                                                        <option value="15">15 Năm</option>
                                                        <option value="16">16 Năm</option>
                                                        <option value="17">17 Năm</option>
                                                        <option value="18">18 Năm</option>
                                                        <option value="19">19 Năm</option>
                                                        <option value="20">20 Năm</option>
                                                        <option value="21">21 Năm</option>
                                                        <option value="22">22 Năm</option>
                                                        <option value="23">23 Năm</option>
                                                        <option value="24">24 Năm</option>
                                                        <option value="25">25 Năm</option>
                                                        <option value="26">26 Năm</option>
                                                        <option value="27">27 Năm</option>
                                                        <option value="28">28 Năm</option>
                                                        <option value="29">29 Năm</option>
                                                        <option value="30">30 Năm</option>
                                                        <option value="31">31 Năm</option>
                                                        <option value="32">32 Năm</option>
                                                        <option value="33">33 Năm</option>
                                                        <option value="34">34 Năm</option>
                                                        <option value="35">35 Năm</option>
                                                        <option value="36">36 Năm</option>
                                                        <option value="37">37 Năm</option>
                                                        <option value="38">38 Năm</option>
                                                        <option value="39">39 Năm</option>
                                                        <option value="40">40 Năm</option>
                                                        <option value="41">41 Năm</option>
                                                        <option value="42">42 Năm</option>
                                                        <option value="43">43 Năm</option>
                                                        <option value="44">44 Năm</option>
                                                        <option value="45">45 Năm</option>
                                                        <option value="46">46 Năm</option>
                                                        <option value="47">47 Năm</option>
                                                        <option value="48">48 Năm</option>
                                                        <option value="49">49 Năm</option>
                                                        <option value="50">50 Năm</option>
                                                        <option value="51">51 Năm</option>
                                                        <option value="52">52 Năm</option>
                                                        <option value="53">53 Năm</option>
                                                        <option value="54">54 Năm</option>
                                                        <option value="55">55 Năm</option>
                                                        <option value="56">56 Năm</option>
                                                        <option value="57">57 Năm</option>
                                                        <option value="58">58 Năm</option>
                                                        <option value="59">59 Năm</option>
                                                        <option value="60">60 Năm</option>
                                                        <option value="61">61 Năm</option>
                                                        <option value="62">62 Năm</option>
                                                        <option value="63">63 Năm</option>
                                                        <option value="64">64 Năm</option>
                                                        <option value="65">65 Năm</option>
                                                        <option value="66">66 Năm</option>
                                                        <option value="67">67 Năm</option>
                                                        <option value="68">68 Năm</option>
                                                        <option value="69">69 Năm</option>
                                                        <option value="70">70 Năm</option>
                                                        <option value="71">71 Năm</option>
                                                        <option value="72">72 Năm</option>
                                                        <option value="73">73 Năm</option>
                                                        <option value="74">74 Năm</option>
                                                        <option value="75">75 Năm</option>
                                                        <option value="76">76 Năm</option>
                                                        <option value="77">77 Năm</option>
                                                        <option value="78">78 Năm</option>
                                                        <option value="79">79 Năm</option>
                                                        <option value="80">80 Năm</option>
                                                        <option value="81">81 Năm</option>
                                                        <option value="82">82 Năm</option>
                                                        <option value="83">83 Năm</option>
                                                        <option value="84">84 Năm</option>
                                                        <option value="85">85 Năm</option>
                                                        <option value="86">86 Năm</option>
                                                        <option value="87">87 Năm</option>
                                                        <option value="88">88 Năm</option>
                                                        <option value="89">89 Năm</option>
                                                        <option value="90">90 Năm</option>
                                                        <option value="91">91 Năm</option>
                                                        <option value="92">92 Năm</option>
                                                        <option value="93">93 Năm</option>
                                                        <option value="94">94 Năm</option>
                                                        <option value="95">95 Năm</option>
                                                        <option value="96">96 Năm</option>
                                                        <option value="97">97 Năm</option>
                                                        <option value="98">98 Năm</option>
                                                        <option value="99">99 Năm</option>
                                                </select>
                                                <select class="form-control" id="KCThangThucTe" name="KCThangThucTe">
                                                    <option value="">---Chọn tháng---</option>
                                                        <option value="1">1 tháng</option>
                                                        <option value="2">2 tháng</option>
                                                        <option value="3" selected="selected">3 tháng</option>
                                                        <option value="4">4 tháng</option>
                                                        <option value="5">5 tháng</option>
                                                        <option value="6">6 tháng</option>
                                                        <option value="7">7 tháng</option>
                                                        <option value="8">8 tháng</option>
                                                        <option value="9">9 tháng</option>
                                                        <option value="10">10 tháng</option>
                                                        <option value="11">11 tháng</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="col-xl-12" style="text-align:center">
                                        <div class="form-group">
                                            <label style="font-weight: bold; color: blue">Thời kỳ kháng chiến chống Pháp</label>
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="form-group">
                                            <label>Huân chương</label>
                                            <select class="form-control" id="KCHuanChuongPhap" name="KCHuanChuongPhap">
                                                <option value="">--Chọn huân chương---</option>
                                                <option value="Huân chương Kháng chiến chống Pháp cứu nước hạng nhất">Huân chương Kháng chiến chống Pháp cứu nước hạng nhất</option>
                                                <option value="Huân chương Kháng chiến chống Pháp cứu nước hạng nhì">Huân chương Kháng chiến chống Pháp cứu nước hạng nhì</option>
                                                <option value="Huân chương Kháng chiến chống Pháp cứu nước hạng ba">Huân chương Kháng chiến chống Pháp cứu nước hạng ba</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="form-group">
                                            <label>Huy chương</label>
                                            <select class="form-control" id="KCHuyChuongPhap" name="KCHuyChuongPhap">
                                                <option value="">--Chọn huy chương---</option>
                                                <option value="Huy chương Kháng chiến chống Pháp cứu nước hạng nhất">Huy chương Kháng chiến chống Pháp cứu nước hạng nhất</option>
                                                <option value="Huy chương Kháng chiến chống Pháp cứu nước hạng nhì">Huy chương Kháng chiến chống Pháp cứu nước hạng nhì</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="col-xl-12" style="text-align:center">
                                        <div class="form-group">
                                            <label style="font-weight: bold; color: blue">Thời kỳ kháng chiến chống Mỹ</label>
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="form-group">
                                            <label>Huân chương</label>
                                            <select class="form-control" id="KCHuanChuongMy" name="KCHuanChuongMy">
                                                <option value="">--Chọn huân chương---</option>
                                                <option value="Huân chương Kháng chiến chống Mỹ cứu nước hạng nhất" selected="selected">Huân chương Kháng chiến chống Mỹ cứu nước hạng nhất</option>
                                                <option value="Huân chương Kháng chiến chống Mỹ cứu nước hạng nhì">Huân chương Kháng chiến chống Mỹ cứu nước hạng nhì</option>
                                                <option value="Huân chương Kháng chiến chống Mỹ cứu nước hạng ba">Huân chương Kháng chiến chống Mỹ cứu nước hạng ba</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="form-group">
                                            <label>Huy chương</label>
                                            <select class="form-control" id="KCHuyChuongMy" name="KCHuyChuongMy">
                                                <option value="">--Chọn huy chương---</option>
                                                <option value="Huy chương Kháng chiến chống Mỹ cứu nước hạng nhất" selected="selected">Huy chương Kháng chiến chống Mỹ cứu nước hạng nhất</option>
                                                <option value="Huy chương Kháng chiến chống Mỹ cứu nước hạng nhì">Huy chương Kháng chiến chống Mỹ cứu nước hạng nhì</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="col-xl-12">
                                        <div class="form-group">
                                            <label>Thông tin quyết định</label>
                                            <input class="form-control" type="text" id="KCThongTinQuyetDinh" name="KCThongTinQuyetDinh" value="QĐHCM">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                document.getElementById('KC').onclick = function (e) {
                    if (this.checked) {
                        document.getElementById("frm_kc").style.display = "block";
                    }
                    else {
                        document.getElementById("frm_kc").style.display = "none";
                    }
                };
                document.getElementById("btn_ttkc").onclick = function (e) {
                    var x = document.getElementById("frm_kc").style.display;
                    if (x == "none") {
                        document.getElementById("frm_kc").style.display = "block";
                    }
                    else {
                        document.getElementById("frm_kc").style.display = "none";
                    }
                };
            </script>
                <div class="row" style="">
                <div class="col-xl-12">
                    <div class="card card-custom gutter-b example example-compact" style="border: 1px solid #60aee4;">
                        <div class="card-header">
                            <div class="checkbox-inline">
                                <label class="checkbox checkbox-lg">
                                    <input type="checkbox" data-val="true" data-val-required="The CC field is required." id="CC" name="CC" value="true"><span></span>
                                    <label class="card-title">
                                         <span class="label label-danger label-dot mr-2"></span>
                                        Người có công giúp đỡ cách mạng
                                    </label>
                                </label>
                            </div>
                            <div class="card-toolbar">
                                <button type="button" class="btn btn-clean btn-sm btn-icon" id="btn_ttcc" title="Thu gọn/ Hiển thị">
                                    <i class="ki ki-bold-more-hor"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body" style="display: none" id="frm_cc">
                            <div class="row">
                                <div class="col-xl-7">
                                    <div class="form-group">
                                        <label>Tình hình hiện nay:</label>
                                        <input type="text" class="form-control" id="CCTinhHinhHienTai" name="CCTinhHinhHienTai" value="">
                                    </div>
                                </div>
                                <div class="col-xl-5">
                                    <div class="form-group">
                                        <label>Danh hiệu</label>
                                        <input type="text" class="form-control" id="CCDanhHieu" name="CCDanhHieu" value="">
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="form-group">
                                        <label>Thông tin quyết định</label>
                                        <input type="text" class="form-control" id="CCThongTinQuyetDinh" name="CCThongTinQuyetDinh" value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                document.getElementById('CC').onclick = function (e) {
                    if (this.checked) {
                        document.getElementById("frm_cc").style.display = "block";
                    }
                    else {
                        document.getElementById("frm_cc").style.display = "none";
                    }
                };
                document.getElementById("btn_ttcc").onclick = function (e) {
                    var x = document.getElementById("frm_cc").style.display;
                    if (x == "none") {
                        document.getElementById("frm_cc").style.display = "block";
                    }
                    else {
                        document.getElementById("frm_cc").style.display = "none";
                    }
                };
            </script>
            </div>
        </div>

        <div class="card-footer">
            <div class="row text-center">
                <div class="col-lg-12">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>Tìm kiếm</button>
                </div>
            </div>

        </div>

    </div>
    {!! Form::close() !!}
    <!--end::Card-->

    @if ($model != null)
        <div class="card card-custom">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label text-uppercase">Thông tin kết quả tìm kiếm</h3>
                </div>
                <div class="card-toolbar">
                    <!--begin::Button-->
                    <!--end::Button-->
                </div>
            </div>

            {!! Form::model($model, ['url' => '', 'class' => 'form', 'id' => 'frm_ThayDoi']) !!}
            <div class="card-body">
                <h4 class="text-dark font-weight-bold mb-10">Thông tin chung</h4>
                <div class="form-group row">
                    <div class="col-lg-6">
                        <label>Tên đối tượng</label>
                        {!! Form::text('tendoituong', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-lg-6">
                        <label>Tên đơn vị</label>
                        {!! Form::text('tendonvi', null, ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-3">
                        <label class="form-control-label">Ngày sinh</label>
                        {!! Form::input('date', 'ngaysinh', null, ['id' => 'ngaysinh', 'class' => 'form-control']) !!}
                    </div>

                    <div class="col-md-3">
                        <label class="form-control-label">Giới tính</label>
                        {!! Form::select('gioitinh', getGioiTinh(), null, ['id' => 'gioitinh', 'class' => 'form-control']) !!}
                    </div>

                    <div class="col-md-3">
                        <label class="form-control-label">Chức vụ/Chức danh</label>
                        {!! Form::text('chucvu', null, ['id' => 'chucvu', 'class' => 'form-control']) !!}
                    </div>
                    <div class="col-md-3">
                        <label class="form-control-label">Mã CCVC</label>
                        {!! Form::text('maccvc', null, ['id' => 'maccvc', 'class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="separator separator-dashed my-5"></div>
                <h4 class="text-dark font-weight-bold mb-10">Danh sách danh hiệu thi đua</h4>

                <div class="row" id="dskhenthuong">
                    <div class="col-md-12">
                        <table class="table table-striped table-bordered table-hover dulieubang">
                            <thead>
                                <tr class="text-center">
                                    <th width="10%">STT</th>
                                    <th>Tên danh hiệu thi đua</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach ($model_danhhieu as $key => $tt)
                                    <tr class="odd gradeX">
                                        <td class="text-center">{{ $i++ }}</td>
                                        <td>{{ $a_danhhieu[$tt->madanhhieutd] ?? '' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="separator separator-dashed my-5"></div>
                <h4 class="text-dark font-weight-bold mb-10">Danh sách khen thưởng</h4>

                <div class="row" id="dskhenthuongtapthe">
                    <div class="col-md-12">
                        <table class="table table-striped table-bordered table-hover dulieubang">
                            <thead>
                                <tr class="text-center">
                                    <th width="10%">STT</th>
                                    <th>Hình thức khen thưởng</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach ($model_khenthuong as $key => $tt)
                                    <tr class="odd gradeX">
                                        <td class="text-center">{{ $i++ }}</td>
                                        <td>{{ $a_hinhthuckt[$tt->mahinhthuckt] ?? '' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="separator separator-dashed my-5"></div>
                <h4 class="text-dark font-weight-bold mb-10">Danh sách đề tài, sáng kiến</h4>

                <div class="row" id="dskhenthuongtapthe">
                    <div class="col-md-12">
                        <table class="table table-striped table-bordered table-hover dulieubang">
                            <thead>
                                <tr class="text-center">
                                    <th width="10%">STT</th>
                                    <th>Tên đề tài, sang kiến</th>
                                    <th>Thành tích đạt được</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach ($model_detai as $key => $tt)
                                    <tr class="odd gradeX">
                                        <td class="text-center">{{ $i++ }}</td>
                                        <td>{{ $tt->tensangkien }}</td>
                                        <td>{{ $tt->thanhtichdatduoc }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row text-center">

                </div>
                {!! Form::close() !!}
            </div>
    @endif
@stop
