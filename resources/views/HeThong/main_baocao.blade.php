<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="vi">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,500,600,700" />
    <meta name='viewport' content='width=device-width, initial-scale=1' />
    {{-- <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script> --}}
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <title>{{$pageTitle}} | TDKT</title>
    <link rel="shortcut icon" href="{{ url('assets/media/logos/LIFESOFT.png') }}" />
    <link href="{{ url('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/plugins/custom/prismjs/prismjs.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <style type="text/css">
        body {
            font: normal 14px/16px time, serif;
        }

        table,
        p {
            width: 90%;
            margin: auto;
        }

        /* tr {
            text-align: center;
        } */

        td,
        th {
            padding: 5px;
        }

        p {
            padding: 5px;
        }

        .sangtrangmoi {
            page-break-before: always
        }

        span {
            text-transform: uppercase;
            font-weight: bold;
        }

        @media print {
            .in {
                display: none !important;
            }

            #myBtn {
                display: none !important;
            }
        }

        #fixNav {
            /*background: #f7f7f7;*/
            background: #f9f9fa;
            width: 100%;
            height: 50px;
            display: block;
            box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.5);
            /*Đổ bóng cho menu*/
            position: fixed;
            /*Cho menu cố định 1 vị trí với top và left*/
            top: 0;
            /*Nằm trên cùng*/
            left: 0;
            /*Nằm sát bên trái*/
            z-index: 100000;
            /*Hiển thị lớp trên cùng*/
        }

        #fixNav ul {
            margin: 0;
            padding: 0;
        }

        #fixNav ul li {
            list-style: none inside;
            width: auto;
            float: left;
            line-height: 35px;
            /*Cho text canh giữa menu*/
            color: #fff;
            padding: 0;
            margin-left: 10px;
            margin-top: 5px;
            position: relative;
        }

        #fixNav ul li a {
            text-transform: uppercase;
            white-space: nowrap;
            /*Cho chữ trong menu không bị wrap*/
            padding: 0 10px;
            color: #fff;
            display: block;
            font-size: 0.8em;
            text-decoration: none;
        }


        #myBtn {
            display: none;
            position: fixed;
            bottom: 30px;
            right: 20px;
            justify-content: center;
            align-items: center;
            width: 36px;
            height: 36px;
            z-index: 100;
            font-size: 18px;
            border: none;
            outline: none;
            background-color: transparent;
            cursor: pointer;
            padding: 15px;
            color: black;
            /*border-radius: 4px ;*/
            border-radius: 0.42rem !important;
        }

        #myBtn:hover {
            color: #3699FF;
        }

    </style>
    <script>
        function ExDoc() {
            var sourceHTML = document.getElementById("data").innerHTML;
            var source = 'data:application/vnd.ms-word;charset=utf-8,' + encodeURIComponent(sourceHTML);
            var fileDownload = document.createElement("a");
            document.body.appendChild(fileDownload);
            fileDownload.href = source;
            fileDownload.download = $('#title').val() + '.doc';
            fileDownload.click();
            document.body.removeChild(fileDownload);
        }

        function exportTableToExcel() {
            var downloadLink;
            var dataType = 'application/vnd.ms-excel';
            var tableSelect = document.getElementById('data_render');
            var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');

            // Specify file name
            var filename = $('#title').val() + '.xls';

            // Create download link element
            downloadLink = document.createElement("a");

            document.body.appendChild(downloadLink);

            if (navigator.msSaveOrOpenBlob) {
                var blob = new Blob(['\ufeff', tableHTML], {
                    type: dataType
                });
                navigator.msSaveOrOpenBlob(blob, filename);
            } else {
                // Create a link to the file
                downloadLink.href = 'data:' + dataType + ', ' + tableHTML;

                // Setting the file name
                downloadLink.download = filename;

                //triggering the function
                downloadLink.click();
            }
        }

        //Get the button
        var mybutton = document.getElementById("myBtn");

        // When the user scrolls down 20px from the top of the document, show the button
        // window.onscroll = function () { scrollFunction() };

        // function scrollFunction() {
        //     if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        //         document.getElementById("myBtn").style.display = 'block';
        //     } else {
        //         document.getElementById("myBtn").style.display = 'none';
        //     }
        // }

        // // When the user clicks on the button, scroll to the top of the document
        // function topFunction() {
        //     document.body.scrollTop = 0;
        //     document.documentElement.scrollTop = 0;
        // }
    </script>
</head>

<body style="font:normal 14px Times, serif;">
    <div class="in">
        <nav id="fixNav">
            <ul>
                <li>
                    <button type="button" class="btn btn-success" border-radius:=border-radius: 30px=30px onclick="window.print()">
                        <i class="fas fa-print"></i>&ensp;In dữ liệu
                    </button>
                </li>
                <li>
                    <button type="button" class="btn btn-primary" onclick="ExDoc()">
                        <i class="far fa-file-word"></i>&ensp;Kết xuất file Doc
                    </button>
                </li>
                <li>
                    <button type="button" class="btn btn-primary" onclick="exportTableToExcel()">
                        <i class="far fa-file-excel"></i>&ensp;Export Excel
                    </button>
                </li>
            </ul>
        </nav>
    </div>

    <div id="data" style="position: relative; margin-top: 10px; margin-bottom:50px; font-size:14px">
        @yield('content')
    </div>
    
</body>

</html>
