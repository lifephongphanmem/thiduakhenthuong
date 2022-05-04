<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="vi">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ $pageTitle }}</title>
    <style type="text/css">
        body {
            font: normal 14px/16px time, serif;
        }

        table,
        p {
            width: 90%;
            margin: auto;
        }

        td,
        th {
            //padding: 5px;
        }

        p {
            padding: 5px;
        }

        .sangtrangmoi { page-break-before: always }
        span {
            text-transform: uppercase;
            font-weight: bold;
        }

    </style>
</head>

<body style="font:normal 14px Times, serif;">
    {!! html_entity_decode($model->thongtinquyetdinh) !!}
</body>

</html>
