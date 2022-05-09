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
    <p style="text-align: center; font-weight: bold; font-size: 20px;">THÔNG TIN PHONG TRÀO THI ĐUA KHEN THƯỞNG</p>

    <table width="96%" border="0" cellspacing="0">
        <tr>
            <td style="width: 5%"></td>
            <td style="width: 25%">Đơn vị phát động:</td><td>{{$a_donvi[$model->madonvi] ?? ''}}</td>
        </tr>

        <tr>
            <td style="width: 5%"></td>
            <td style="width: 25%">Mô tả phong trào:</td><td>{{$model->noidung}}</td>
        </tr>

        <tr>
            <td style="width: 5%"></td>
            <td>Phạm vi phát động:</td><td>{{$model->phamviapdung}}</td>
        </tr>

        <tr>
            <td style="width: 5%"></td>
            <td>Ngày bắt đầu:</td><td>{{getDayVn($model->tungay)}}</td>
        </tr>

        <tr>
            <td style="width: 5%"></td>
            <td>Ngày kết thúc:</td><td>{{getDayVn($model->denngay)}}</td>
        </tr>

    </table>

    <p style="text-align: left; font-weight: bold; font-size: 14px;padding-left: 20px">Danh sách cá nhân tham gia</p>
    <table cellspacing="0" cellpadding="0" border="1" style="margin: 20px auto; border-collapse: collapse;">
        <tr>
            <th style="width: 10%">STT</th>
            <th>Tên đơn vị</th>
            <th>Tên đối tượng</th>
            <th>Danh hiệu đăng ký</th>
        </tr>
        <?php $i=1; ?>
        @foreach($m_canhan as $pc)
            <tr>
                <td style="text-align: center">{{$i++}}</td>
                <td>{{$a_donvi[$pc->madonvi] ?? ''}}</td>
                <td>{{$pc->tendt}}</td>
                <td>{{$a_danhhieu[$pc->madanhhieutd]}}</td>

            </tr>
        @endforeach

    </table>

    <p style="text-align: left; font-weight: bold; font-size: 14px;padding-left: 20px">Danh sách tập thể tham gia</p>
    <table cellspacing="0" cellpadding="0" border="1" style="margin: 20px auto; border-collapse: collapse;">
        <tr>
            <th style="width: 10%">STT</th>
            <th>Tên đơn vị</th>
            <th>Danh hiệu đăng ký</th>
        </tr>
        <?php $i=1; ?>
        @foreach($m_tapthe as $pc)
            <tr>
                <td style="text-align: center">{{$i++}}</td>
                <td>{{$pc->tendonvi}}</td>
                <td>{{$a_danhhieu[$pc->madanhhieutd]}}</td>

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
            <td>Họ và tên người lập</td>
        </tr>

        <tr>
            <td>
                <br><br><br><br>
            </td>
        <tr>
            <td>&nbsp;</td>
            <td></td>
        </tr>
    </table>
    <p style="page-break-before: always">

</body>
</html>