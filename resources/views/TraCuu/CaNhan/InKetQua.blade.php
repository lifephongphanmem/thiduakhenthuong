@extends('BaoCao.main_baocao')

@section('content')
    <table id="data_header" class="header" width="96%" border="0" cellspacing="0" cellpadding="8"
        style="margin:0 auto 25px; text-align: center;">
        <tr>
            <td colspan="2" style="font-weight: bold;">
                <h4> THÔNG TIN KẾT QUẢ TÌM KIẾM</h4>
            </td>
        </tr>
    </table>



    @if (count($model_khenthuong) > 0)
        <p style="text-left: center; font-size: 18px;">Danh sách khen thưởng</p>
        <table id="data_body1" class="money" cellspacing="0" cellpadding="0" border="1"
            style="margin: 5px auto; border-collapse: collapse;font:normal 12px Times, serif;">
            <thead>
                <tr class="text-center">
                    <th rowspan="2" width="5%">STT</th>
                    <th colspan="3">Quyết định</th>
                    <th colspan="2">Tờ trình</th>
                    <th rowspan="2">Họ tên cán bộ</th>
                    <th rowspan="2">Phân loại cán bộ</th>
                    <th rowspan="2">Thông tin công tác</th>
                    <th rowspan="2">Loại hình khen thưởng</th>
                    <th rowspan="2">Danh hiệu thi đua</th>
                    <th rowspan="2">Hình thức khen thưởng</th>

                </tr>
                <tr class="text-center">
                    <th>Số QĐ</th>
                    <th>Ngày tháng</th>
                    <th>Cấp độ</th>
                    <th>Số TT</th>
                    <th>Ngày tháng</th>
                </tr>
            </thead>
            <?php $i = 1; ?>
            @foreach ($model_khenthuong as $key => $tt)
                <tr class="odd gradeX">
                    <td class="text-center">{{ $i++ }}</td>
                    <td class="text-center">{{ $tt->soqd }}</td>
                    <td class="text-center">{{ getDayVn($tt->ngayqd) }}</td>
                    <td class="text-center">{{ $tt->capkhenthuong }}</td>
                    <td class="text-center">{{ $tt->sototrinh }}</td>
                    <td class="text-center">{{ getDayVn($tt->ngayhoso) }}</td>
                    <td>{{ $tt->tendoituong }}</td>
                    <td>{{ $a_canhan[$tt->maphanloaicanbo] ?? '' }}</td>
                    <td>{{ $tt->chucvu . ',' . $tt->tenphongban . ',' . $tt->tencoquan }}</td>
                    <td>{{ $a_loaihinhkt[$tt->maloaihinhkt] ?? '' }}</td>
                    <td>{{ $a_danhhieu[$tt->madanhhieutd] ?? '' }}</td>
                    <td>{{ $a_hinhthuckt[$tt->mahinhthuckt] ?? '' }}</td>
                </tr>
            @endforeach
        </table>
    @endif

    @if (count($model_detai) > 0)
        <p style="text-left: center; font-size: 18px;">Danh sách đề tài, sáng kiến</p>
        <table id="data_body2" class="money" cellspacing="0" cellpadding="0" border="1"
            style="margin: 5px auto; border-collapse: collapse;font:normal 12px Times, serif;">
            <thead>
                <tr class="text-center">
                    <th width="10%">STT</th>
                    <th>Tên đề tài, sáng kiến</th>
                    <th>Thành tích đạt được</th>
                    <th>Thông tin tác giả</th>
                </tr>
            </thead>
            <?php $i = 1; ?>
            @foreach ($model_detai as $key => $tt)
                <tr class="odd gradeX">
                    <td class="text-center">{{ $i++ }}</td>
                    <td>{{ $tt->tensangkien }}</td>
                    <td>{{ $tt->thanhtichdatduoc }}</td>
                    <td>{{ $tt->thanhtichdatduoc }}</td>
                </tr>
            @endforeach
        </table>
    @endif

    {{-- <table id="data_footer" class="header" width="96%" border="0" cellspacing="0" cellpadding="8"
        style="margin:20px auto; text-align: center;">
        <tr>
            <td style="text-align: left;" width="50%"></td>
            <td style="text-align: center; font-style: italic" width="50%">
                {{ $m_donvi->diadanh . ', ' . Date2Str($model->ngayhoso) }}</td>
        </tr>
        <tr style="font-weight: bold">
            <td style="text-align: center;" width="50%">Người lập biểu</td>
            <td style="text-align: center;" width="50%">{{ $m_donvi->cdlanhdao }}</td>
        </tr>
        <tr style="font-style: italic">
            <td style="text-align: center;" width="50%">(Ghi rõ họ tên)</td>
            <td style="text-align: center;" width="50%">(Ký tên, đóng dấu)</td>
        </tr>
        <tr>
            <td style="border-top: 100px"></td>
        </tr>

        <tr>
            <td style="text-align: center;" width="50%">{{ $m_donvi->nguoilapbieu }}</td>
            <td style="text-align: center;" width="50%">{{ $m_donvi->lanhdao }}</td>
        </tr>
    </table> --}}
@stop