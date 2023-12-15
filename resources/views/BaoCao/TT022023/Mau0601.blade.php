@extends('HeThong.main_baocao')

@section('content')

    <table id="data_header" class="header" width="96%" border="0" cellspacing="0" cellpadding="8"
        style="margin:0 auto 25px; text-align: center;font-size:12px">
        <tr>
            <td style="text-align: left;width: 60%">
               <b> Biểu số: 0601.N/BNV-TĐKT</b>
            </td>
            <td style="text-align: center;">
                Đơn vị báo cáo:
            </td>
        </tr>
        <tr>
            <td style="text-align: left;width: 60%">
                Ban hành theo Thông tư số 2/2023/TT-BNV ngày 23/3/2023
            </td>
            <td style="text-align: center;">
                Đơn vị nhận báo cáo:
            </td>
        </tr>
        <tr>
            <td style="text-align: left;width: 60%">
                Ngày nhận báo cáo:<br/>
                Ngày 15 tháng 12 năm báo cáo
                
            </td>
            <td style="text-align: center; font-style: italic">
               
            </td>
        </tr>
    </table>
    <p id="data_body" style="text-align: center; font-weight: bold; font-size: 20px;">SỐ PHONG TRÀO THI ĐUA</p>
    {{-- <p id="data_body1" style="text-align: center; font-style: italic">(Ban hành kèm theo Thông tư số 67/2017/TT-BTC)</p> --}}
    <p id="data_body1" style="text-align: center; font-style: italic">Năm...</p>
    <p id="data_body2" style="text-align: right; font-style: italic">Đơn vị tính: Phong trào</p>
    <table id="data_body3" cellspacing="0" cellpadding="0" border="1"
        style="margin: 20px auto; border-collapse: collapse;">
        <tr style="padding-left: 2px;padding-right: 2px">
            <th style="width: 10%;padding-left: 2px;padding-right: 2px" rowspan="2"></th>
            <th style="width:2%" rowspan="2">Mã số </th>
            <th style="width: 6%;padding-left: 2px;padding-right: 2px" rowspan="2">Tổng số</th>
            <th colspan="3" style="width: 6%;padding-left: 2px;padding-right: 2px">Số phong trào thi đua chia theo cấp chủ trì phát động thi đua</th>
        </tr>
<tr>
    <th>
        Cấp Trung ương (Hội đồng Thi đua - Khen thưởng Trung ương)
    </th>
    <th>Cấp bộ, ban ngành đoàn thể trung ương, tỉnh, thành phố trực thuộc Trung ương</th>
    <th>Cơ quan, tổ chức, đơn vị</th>
</tr>
        <tr style="font-weight: bold;text-align:center">
            <td>A</td>
            <td>B</td>
            <td>1=(2+3+4)</td>
            <td>2</td>
            <td>3</td>
            <td>4</td>
        </tr>
        <tr style="font-weight: bold;text-align:left">
            <td  style="text-align:left">Tổng số</td>
            <td style="text-align:center">01</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>            
        </tr>
        <tr>
            <td style="font-weight: bold;text-align:left">1. Chia theo phạm vi tổ chức thi đua</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>   
        </tr>
        <tr>
            <td style="text-align:left">- Toàn quốc</td>
            <td style="text-align:center">02</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>   
        </tr>
        <tr>
            <td style="text-align:left">- Bộ, ban, ngành đoàn thể, địa phương</td>
            <td style="text-align:center">03</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>   
        </tr>
        <tr>
            <td style="text-align:left">- Cụm, khối thi đua do Hội đồng Thi đua - Khen thưởng các cấp tổ chức</td>
            <td style="text-align:center">04</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>   
        </tr>
        <tr>
            <td style="text-align:left">- Cơ quan, tổ chức, đơn vị</td>
            <td style="text-align:center">05</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>   
        </tr>
        <tr>
            <td style="font-weight: bold;text-align:left">2. Chia theo thời hạn thi đua</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>   
        </tr>
        <tr>
            <td style="text-align:left">- Dưới 1 năm</td>
            <td style="text-align:center">06</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>   
        </tr>
        <tr>
            <td style="text-align:left">- 1 năm</td>
            <td style="text-align:center">07</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>   
        </tr>
        <tr>
            <td style="text-align:left">- Từ 1 năm đến dưới 3 năm</td>
            <td style="text-align:center">08</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>   
        </tr>
        <tr>
            <td style="text-align:left">- Từ 3 năm đến dưới 5 năm</td>
            <td style="text-align:center">09</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>   
        </tr>
        <tr>
            <td style="text-align:left">- Từ 5 năm trở lên</td>
            <td style="text-align:center">10</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>   
        </tr>
        <tr>
            <td style="font-weight: bold;text-align:left">3. Chia theo phương thức tổ chức phong trào thi đua</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>   
        </tr>
        <tr>
            <td style="text-align:left">- Thi đua theo chuyên đề</td>
            <td style="text-align:center">11</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>   
        </tr>
        <tr>
            <td style="text-align:left">- Thi đua thường xuyên hàng năm</td>
            <td style="text-align:center">12</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>   
        </tr>
    </table>
@stop
