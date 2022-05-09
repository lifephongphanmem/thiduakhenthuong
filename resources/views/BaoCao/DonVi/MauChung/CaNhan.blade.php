<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="vi">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{$pageTitle}}</title>
    <style type="text/css">
        body {
            font: normal 14px/16px time, serif;
        }

        table, p {
            width: 98%;
            /*margin: auto;*/
        }

        td, th {
            padding: 5px;
        }
        p{
            padding: 5px;
        }
        span{
            text-transform: uppercase;
            font-weight: bold;
        }
    </style>
</head>
<body style="font:normal 14px Times, serif;">
    <p style="text-align: center; font-weight: bold; font-size: 20px;">THÔNG TIN HỒ SƠ CÁN BỘ</p>

    <table width="96%" border="0" cellspacing="0">
        <tr>
            <td style="width: 5%"></td>
            <td style="width: 25%">Họ và tên:</td><td>{{$model->tendt}}</td>
        </tr>

        <tr>
            <td style="width: 5%"></td>
            <td>Ngày sinh:</td><td>{{getDayVn($model->ngaysinh)}}</td>
        </tr>

        <tr>
            <td style="width: 5%"></td>
            <td>Giới tính:</td><td>{{$model->gioitinh == 'NAM' ? 'Nam' : 'Nữ'}}</td>
        </tr>

        <tr>
            <td style="width: 5%"></td>
            <td>Chức vụ (chức danh):</td><td>{{$model->chucvu}}</td>
        </tr>

        <tr>
            <td style="width: 5%"></td>
            <td>Lãnh đạo đơn vị:</td><td>{{$model->lanhdao == 1 ? 'Có': 'Không'}}</td>
        </tr>

        <tr>
            <td style="width: 5%"></td>
            <td>Mã số công chức, viên chức:</td><td>{{$model->maccvc}}</td>
        </tr>
    </table>

    <p style="text-align: left; font-weight: bold; font-size: 14px;padding-left: 20px">Thông tin kết quả phong trào thi đua khen thưởng của cán bộ từ {{getDayVn($inputs['ngaytu'])}} đến {{getDayVn($inputs['ngayden'])}}</p>
    <table cellspacing="0" cellpadding="0" border="1" style="margin: 20px auto; border-collapse: collapse;">
        <tr>
            <th style="width: 10%">STT</th>
            <th>Tên phong trào thi đua</th>
            <th>Danh hiệu đạt được</th>
            <th style="width: 15%">Ngày bắt đầu</th>
            <th style="width: 15%">Ngày kết thúc</th>
        </tr>
        <?php $i=1; ?>
        @foreach($m_khenthuong as $pc)
            <tr>
                <td style="text-align: center">{{$i++}}</td>
                <td>{{$pc->noidung ?? ''}}</td>
                <td>{{$a_danhhieu[$pc->madanhhieutd  ?? '']  ?? ''}}</td>
                <td style="text-align: center">{{getDayVn($pc->tungay  ?? '')  ?? ''}}</td>
                <td style="text-align: center">{{getDayVn($pc->denngay  ?? '')  ?? ''}}</td>
            </tr>
        @endforeach

    </table>

    <table width="96%" border="0" cellspacing="0" style="text-align: center">
        <tr>
            <td style="width: 50%">&nbsp;</td>
            <td style="width: 50%">…………, Ngày…...tháng……năm……</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>Họ và tên cán bộ</td>
        </tr>

        <tr>
            <td>
                <br><br><br><br>
            </td>
        <tr>
            <td>&nbsp;</td>
            <td>{{$model->tencanbo}}</td>
        </tr>
    </table>
    <p style="page-break-before: always">

</body>
</html>