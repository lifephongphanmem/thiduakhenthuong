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
    <title>{{ $pageTitle }} | TDKT</title>
    <link rel="shortcut icon" href="{{ url('assets/media/logos/LIFESOFT.png') }}" />
    <style type="text/css">
        /* .header tr td {
            padding-top: 0px;
            padding-bottom: 5px;
        }        */

        /* table tr td:first-child {
            text-align: center;
        } */

        table,
        p {
            width: 100%;
            margin: auto;
        }

        button {
            border-width: 0px;
            /* margin: auto; */
        }
        th {
            text-align: center;
        }

        /* td,th {
            padding: 5px;
        } */

        /* p {
            padding: 5px;
        } */

        .sangtrangmoi {
            page-break-before: always
        }

        /* span {
            text-transform: uppercase;
            font-weight: bold;
        } */

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
            height: 35px;
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
            margin-left: 20px;
            margin-top: 1px;
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
    </style>
    @yield('style_css')
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
            var tableHTML = '';
            //Tiêu đề
            var data_header = document.getElementById('data_header');
            if (data_header) {
                tableHTML = tableHTML + data_header.outerHTML.replace(/ /g, '%20');
            }

            //Nội dung 1
            var data_body = document.getElementById('data_body');
            if (data_body) {
                tableHTML = tableHTML + data_body.outerHTML.replace(/ /g, '%20');
            }
            //Nội dung 2
            var data_body1 = document.getElementById('data_body1');
            if (data_body1) {
                tableHTML = tableHTML + data_body1.outerHTML.replace(/ /g, '%20');
            }
            //Nội dung 3
            var data_body2 = document.getElementById('data_body2');
            if (data_body2) {
                tableHTML = tableHTML + data_body2.outerHTML.replace(/ /g, '%20');
            }
            //Nội dung 4
            var data_body3 = document.getElementById('data_body3');
            if (data_body3) {
                tableHTML = tableHTML + data_body3.outerHTML.replace(/ /g, '%20');
            }
            //Nội dung 5
            var data_body4 = document.getElementById('data_body4');
            if (data_body4) {
                tableHTML = tableHTML + data_body4.outerHTML.replace(/ /g, '%20');
            }
            //Nội dung 6
            var data_body5 = document.getElementById('data_body5');
            if (data_body5) {
                tableHTML = tableHTML + data_body5.outerHTML.replace(/ /g, '%20');
            }

            //Chữ ký
            var data_footer = document.getElementById('data_footer');
            if (data_footer) {
                tableHTML = tableHTML + data_footer.outerHTML.replace(/ /g, '%20');
            }
            //Xác nhận
            var data_footer1 = document.getElementById('data_footer1');
            if (data_footer1) {
                tableHTML = tableHTML + data_footer1.outerHTML.replace(/ /g, '%20');
            }

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
    </script>

    <script>
        function ClickDelete() {
            $('#frm_delete').submit();
        }
        $(document).ready(function() {
            $("#luutoado").click(function() {
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                var x1 = $("#flying1").position();
                var x2 = $("#flying2").position();
                var x3 = $("#flying3").position();
                var x4 = $("#flying4").position();
                var x5 = $("#flying5").position();
                var x6 = $("#flying6").position();
                var x7 = $("#flying7").position();
                var x8 = $("#flying8").position();
                var x9 = $("#flying9").position();
                var x10 = $("#flying10").position();
                var x11 = $("#flying11").position();
                var x12 = $("#flying12").position();
                var x13 = $("#flying13").position();
                var x14 = $("#flying14").position();
                var x15 = $("#flying15").position();
                var x16 = $("#flying16").position();
                var x17 = $("#flying17").position();
                var x18 = $("#flying18").position();
                var x19 = $("#flying19").position();
                var x20 = $("#flying20").position();
                var x21 = $("#flying21").position();
                var x22 = $("#flying22").position();
                var x23 = $("#flying23").position();
                var x24 = $("#flying24").position();
                var x25 = $("#flying25").position();
                $.ajax({
                    type: 'GET',
                    url: '/ajaxluutoado',
                    data: {
                        _token: CSRF_TOKEN,
                        toado1: 'top:' + x1.top + 'px;left:' + x1.left + 'px',
                        toado2: 'top:' + x2.top + 'px;left:' + x2.left + 'px',
                        toado3: 'top:' + x3.top + 'px;left:' + x3.left + 'px',
                        toado4: 'top:' + x4.top + 'px;left:' + x4.left + 'px',
                        toado5: 'top:' + x5.top + 'px;left:' + x5.left + 'px',
                        toado6: 'top:' + x6.top + 'px;left:' + x6.left + 'px',
                        toado7: 'top:' + x7.top + 'px;left:' + x7.left + 'px',
                        toado8: 'top:' + x8.top + 'px;left:' + x8.left + 'px',
                        toado9: 'top:' + x9.top + 'px;left:' + x9.left + 'px',
                        toado10: 'top:' + x10.top + 'px;left:' + x10.left + 'px',
                        toado11: 'top:' + x11.top + 'px;left:' + x11.left + 'px',
                        toado12: 'top:' + x12.top + 'px;left:' + x12.left + 'px',
                        toado13: 'top:' + x13.top + 'px;left:' + x13.left + 'px',
                        toado14: 'top:' + x14.top + 'px;left:' + x14.left + 'px',
                        toado15: 'top:' + x15.top + 'px;left:' + x15.left + 'px',
                        toado16: 'top:' + x16.top + 'px;left:' + x16.left + 'px',
                        toado17: 'top:' + x17.top + 'px;left:' + x17.left + 'px',
                        toado18: 'top:' + x18.top + 'px;left:' + x18.left + 'px',
                        toado19: 'top:' + x19.top + 'px;left:' + x19.left + 'px',
                        toado20: 'top:' + x20.top + 'px;left:' + x20.left + 'px',
                        toado21: 'top:' + x21.top + 'px;left:' + x21.left + 'px',
                        toado22: 'top:' + x22.top + 'px;left:' + x22.left + 'px',
                        toado23: 'top:' + x23.top + 'px;left:' + x23.left + 'px',
                        toado24: 'top:' + x24.top + 'px;left:' + x24.left + 'px',
                        toado25: 'top:' + x25.top + 'px;left:' + x25.left + 'px',
                        phanloai: 'GKS'
                    },
                    success: function(respond) {
                        location.reload();
                    }

                });
            });
        });
    </script>
    
    <style>
        #flying,
        #flying1,
        #flying2,
        #flying3,
        #flying4,
        #flying5,
        #flying6,
        #flying7,
        #flying8,
        #flying9,
        #flying10,
        #flying11,
        #flying12,
        #flying13,
        #flying14,
        #flying15,
        #flying16,
        #flying17,
        #flying18,
        #flying19,
        #flying20,
        #flying21,
        #flying22,
        #flying23,
        #flying24,
        #flying25 {
            position: absolute;
            /* position: absolute; */
        }
    </style>

    <script>
        function byId(e) {
            return document.getElementById(e);
        }

        window.addEventListener('load', myInitFunc, false);

        function myInitFunc() {
            //byId('flying').addEventListener('mousedown', onImgMouseDown, false);
            byId('flying1').addEventListener('mousedown', onImgMouseDown, false);
            byId('flying2').addEventListener('mousedown', onImgMouseDown, false);
            byId('flying3').addEventListener('mousedown', onImgMouseDown, false);
            byId('flying4').addEventListener('mousedown', onImgMouseDown, false);
            byId('flying5').addEventListener('mousedown', onImgMouseDown, false);
            byId('flying6').addEventListener('mousedown', onImgMouseDown, false);
            byId('flying7').addEventListener('mousedown', onImgMouseDown, false);
            byId('flying8').addEventListener('mousedown', onImgMouseDown, false);
            byId('flying9').addEventListener('mousedown', onImgMouseDown, false);
            byId('flying10').addEventListener('mousedown', onImgMouseDown, false);
            byId('flying11').addEventListener('mousedown', onImgMouseDown, false);
            byId('flying12').addEventListener('mousedown', onImgMouseDown, false);
            byId('flying13').addEventListener('mousedown', onImgMouseDown, false);
            byId('flying14').addEventListener('mousedown', onImgMouseDown, false);
            byId('flying15').addEventListener('mousedown', onImgMouseDown, false);
            byId('flying16').addEventListener('mousedown', onImgMouseDown, false);
            byId('flying17').addEventListener('mousedown', onImgMouseDown, false);
            byId('flying18').addEventListener('mousedown', onImgMouseDown, false);
            byId('flying19').addEventListener('mousedown', onImgMouseDown, false);
            byId('flying20').addEventListener('mousedown', onImgMouseDown, false);
            byId('flying21').addEventListener('mousedown', onImgMouseDown, false);
            byId('flying22').addEventListener('mousedown', onImgMouseDown, false);
            byId('flying23').addEventListener('mousedown', onImgMouseDown, false);
            byId('flying24').addEventListener('mousedown', onImgMouseDown, false);
            byId('flying25').addEventListener('mousedown', onImgMouseDown, false);
        }

        function onImgMouseDown(e) {
            e = e || event;
            var mElem = this;
            var initMx = e.pageX;
            var initMy = e.pageY;
            var initElemX = this.offsetLeft;
            var initElemY = this.offsetTop;

            var dx = initMx - initElemX;
            var dy = initMy - initElemY;

            document.onmousemove = function(e) {
                e = e || event;
                mElem.style.left = e.pageX - dx + 'px';
                mElem.style.top = e.pageY - dy + 'px';
            }
            this.onmouseup = function() {
                document.onmousemove = null;
            }

            this.ondragstart = function() {
                return false;
            }

        }
    </script>
</head>

<body>
    <div class="in">
        <nav id="fixNav">
            <ul>
                <li>
                    <button type="button" class="btn btn-success btn-xs text-right"
                        style="border-radius: 20px; margin-left: 50px" onclick="window.print()">
                        <i class="fa fa-print"></i> In dữ liệu
                    </button>
                </li>
                <li>
                    <button type="button" class="btn btn-primary btn-xs" style="border-radius: 20px;"
                        onclick="ExDoc()">
                        <i class="fa fa-file-word-o"></i> File Word
                    </button>
                </li>
                <li>
                    <button type="button" class="btn btn-info btn-xs" style="border-radius: 20px;"
                        onclick="exportTableToExcel()">
                        <i class="fa fa-file-excel-o"></i> Lưu tọa độ
                    </button>
                </li>
                <li>
                    <button type="button" class="btn btn-info btn-xs" style="border-radius: 20px;"
                        onclick="exportTableToExcel()">
                        <i class="fa fa-file-excel-o"></i> Đặt làm mặc định++++++
                    </button>
                </li>
            </ul>
        </nav>
    </div>

    <div id="data" style="position: relative; margin-top: 35px;">
        @yield('content')
    </div>
</body>

<script>
    function setNoiDung(){
        alert('ok');
    }
</script>
</html>
