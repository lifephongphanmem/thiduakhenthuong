@extends('HeThong.main_baocao')

@section('content')

    <table id="data_header" class="header" width="96%" border="0" cellspacing="0" cellpadding="8"
        style="margin:0 auto 25px; text-align: center;font-size:12px">
        <tr>
            <td style="text-align: left;width: 60%">
               <b> Biểu số: 0603.N/BNV-TĐKT</b>
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
            </td>
        </tr>
        {{-- <tr>
            <td style="text-align: left;width: 60%">
                Ngày nhận báo cáo:<br/>
                Ngày 15 tháng 12 năm báo cáo
                
            </td>
            <td style="text-align: center; font-style: italic">
               
            </td>
        </tr> --}}
    </table>
    <p id="data_body" style="text-align: center; font-weight: bold; font-size: 20px;">SỐ LƯỢNG KHEN THƯỞNG CẤP BỘ, BAN, NGÀNH, ĐOÀN THỂ TRUNG ƯƠNG VÀ TỈNH, THÀNH PHỐ TRỰC TRUNG ƯƠNG </p>
    {{-- <p id="data_body1" style="text-align: center; font-style: italic">(Ban hành kèm theo Thông tư số 67/2017/TT-BTC)</p> --}}
    <p id="data_body1" style="text-align: center; font-style: italic">Năm...</p>
    {{-- <p id="data_body2" style="text-align: right; font-style: italic">Đơn vị tính: Phong trào</p> --}}
    <table id="data_body3" cellspacing="0" cellpadding="0" border="1"
        style="margin: 20px auto; border-collapse: collapse;">
        <tr style="padding-left: 2px;padding-right: 2px">
            <th style="width: 10%;padding-left: 2px;padding-right: 2px" rowspan="2"></th>
            <th style="width:2%" rowspan="2">Mã số </th>
            <th style="width:2%" rowspan="2">Đơn vị tính </th>
            <th style="width: 2%;padding-left: 2px;padding-right: 2px" rowspan="2">Tổng số</th>
            <th colspan="4" style="width: 6%;padding-left: 2px;padding-right: 2px">Chia ra</th>
        </tr>
<tr>
    <th >
        Bằng khen
    </th>
    <th >Chiến sĩ thi đua cấp bộ, cấp tỉnh</th>
    <th >Cờ thi đua của bộ, ban, ngành, đoàn thể Trung ương, tỉnh, thành phố trực thuộc Trung ương</th>
    <th >Huy hiệu (kỷ niệm chương) của bộ, ban, ngành, đoàn thể Trung ương, tỉnh, thành phố trực thuộc Trung ương</th>
    
</tr>

        <tr style="font-weight: bold;text-align:center">
            <td>A</td>
            <td>B</td>
            <td>C</td>
            <td>1</td>
            <td>2</td>
            <td>3</td>
            <td>4</td>
            <td>5</td>
        </tr>
        <tr style="font-weight: bold;text-align:left">
            <td  style="text-align:left">Tổng số</td>
            <td style="text-align:center">01</td>
            <td></td>
            <td></td>
            <td></td>   
            <td></td>   
            <td></td>   
            <td></td>   
                          
        </tr>
        <tr>
            <td style="font-weight: bold;text-align:left">1. Chia theo đôi tượng khen thưởng</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>   
            <td></td>   
            <td></td>   
            <td></td>               
        </tr>
        <tr>
            <td style="text-align:left">- Tập thể</td>
            <td style="text-align:center">02</td>
            <td style="text-align:center">Tập thể</td>
            <td ></td>
            <td></td>   
            <td></td>   
            <td></td>   
            <td></td>             
        <tr>
            <td style="text-align:left">Trong đó:
                Doanh nghiệp
                </td>
            <td style="text-align:center">03</td>
            <td style="text-align:center">Doanh
                nghiệp
                </td>
                <td ></td>
                <td></td>   
                <td></td>   
                <td></td>   
                <td></td>   
        </tr>
        <tr>
            <td style="text-align:left">- Hộ gia đình
                </td>
            <td style="text-align:center">04</td>
            <td style="text-align:center">Hộ</td>
            <td ></td>
            <td></td>   
            <td></td>   
            <td></td>   
            <td></td>   
        </tr>
        <tr>
            <td style="text-align:left">- Cá nhân
                </td>
            <td style="text-align:center">05</td>
            <td style="text-align:center">Người</td>
            <td ></td>
            <td></td>   
            <td></td>   
            <td></td>   
            <td></td>   
        </tr>
        <tr>
            <td style="text-align:left">+ Lãnh đạo cấp bộ, cấp tỉnh và tương đương trở lên
                </td>
            <td style="text-align:center">06</td>
            <td style="text-align:center">Người</td>
            <td ></td>
            <td></td>   
            <td></td>   
            <td></td>   
            <td></td>     
        </tr>
        <tr>
            <td style="text-align:left">+ Lãnh đạo cấp vụ, sở, ngành và tương đương
                </td>
            <td style="text-align:center">07</td>
            <td style="text-align:center">Người</td>
            <td ></td>
            <td></td>   
            <td></td>   
            <td></td>   
            <td></td>    
        </tr>
        <tr>
            <td style="text-align:left">+ Doanh nhân
                </td>
            <td style="text-align:center">08</td>
            <td style="text-align:center">Người</td>
            <td ></td>
            <td></td>   
            <td></td>   
            <td></td>   
            <td></td>      
        </tr>
        <tr>
            <td style="text-align:left">+ Các cấp lãnh đạo khác từ phó phòng trở lên
                </td>
            <td style="text-align:center">09</td>
            <td style="text-align:center">Người</td>
            <td ></td>
            <td></td>   
            <td></td>   
            <td></td>   
            <td></td>   
        </tr>
        <tr>
            <td style="text-align:left">+ Người trực tiếp công tác, lao động, học tập, chiến đấu và phục vụ chiến đấu (công nhân, nông dân,...)
                </td>
            <td style="text-align:center">10</td>
            <td style="text-align:center">Người</td>
            <td ></td>
            <td></td>   
            <td></td>   
            <td></td>   
            <td></td>      
        </tr>
        <tr>
            <td style="font-weight: bold;text-align:left">3. Chia theo phương thức khen thưởng</td>
            <td></td>
            <td></td>
            <td ></td>
            <td></td>   
            <td></td>   
            <td></td>   
            <td></td>   
        </tr>
        <tr>
            <td style="text-align:left">- Thường xuyên
                </td>
            <td style="text-align:center">11</td>
            <td></td>
            <td ></td>
            <td></td>   
            <td></td>   
            <td></td>   
            <td></td>    
        </tr>
        <tr>
            <td style="text-align:left">- Chuyên đề
                </td>
            <td style="text-align:center">12</td>
            <td></td>
            <td ></td>
            <td></td>   
            <td></td>   
            <td></td>   
            <td></td>   
        </tr>
        <tr>
            <td style="text-align:left">- Đột xuất
                </td>
            <td style="text-align:center">13</td>
            <td></td>
            <td ></td>
            <td></td>   
            <td></td>   
            <td></td>   
            <td></td>     
        </tr>
        <tr>
            <td style="text-align:left">- Đối ngoại
                </td>
            <td style="text-align:center">14</td>
            <td></td>
            <td ></td>
            <td></td>   
            <td></td>   
            <td></td>   
            <td></td>    
        </tr>
        <tr>
            <td style="text-align:left">- Cống hiến.
                </td>
            <td style="text-align:center">15</td>
            <td></td>
            <td ></td>
            <td></td>   
            <td></td>   
            <td></td>   
            <td></td>   
        </tr>
        <tr>
            <td style="text-align:left">- Niên hạn
                </td>
            <td style="text-align:center">16</td>
            <td></td>
            <td ></td>
            <td></td>   
            <td></td>   
            <td></td>   
            <td></td>   
        </tr>
        <tr>
            <td style="text-align:left">- Kháng chiến
                </td>
            <td style="text-align:center">17</td>
            <td></td>
            <td ></td>
            <td></td>   
            <td></td>   
            <td></td>   
            <td></td>   
        </tr>
      
    </table>
@stop
