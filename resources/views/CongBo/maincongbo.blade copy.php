<!DOCTYPE html>
<!--
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.4
Version: 3.9.0
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>

    <meta charset="utf-8"/>
    <title>{{$pageTitle}}</title>
    {{--<meta http-equiv="X-UA-Compatible" content="IE=edge">--}}
    <meta http-equiv="Content-Security-Policy" content="script-src 'self' 'unsafe-inline' 'unsafe-eval' www.googletagmanager.com connect.facebook.net www.googleadservices.com www.google-analytics.com googleads.g.doubleclick.net onesignal.com tpc.googlesyndication.com;">
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <meta content="" name="description"/>
    <meta content="" name="author"/>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
    <link href="{{url('assets/global/plugins/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{url('assets/global/plugins/simple-line-icons/simple-line-icons.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{url('assets/global/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{url('assets/global/plugins/uniform/css/uniform.default.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{url('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')}}" rel="stylesheet" type="text/css"/>
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL PLUGIN STYLES -->
    <!--link href="{{url('assets/global/plugins/morris/morris.css')}}" rel="stylesheet" type="text/css"-->
    <link href="{{url('assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{url('assets/global/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet')}}" type="text/css"/>
    <link href="{{url('assets/global/plugins/jqvmap/jqvmap/jqvmap.css')}}" rel="stylesheet" type="text/css"/>
    <!-- END PAGE LEVEL PLUGIN STYLES -->
    <!-- BEGIN PAGE STYLES -->
    <link href="{{url('assets/admin/pages/css/tasks.css')}}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css')}}"/>


    @yield('custom-style-cb')
    <!-- END PAGE STYLES -->
    <!-- BEGIN THEME STYLES -->
    <link href="{{url('assets/global/css/components.css')}}" id="style_components" rel="stylesheet" type="text/css"/>
    <link href="{{url('assets/global/css/plugins-md.css')}}" rel="stylesheet" type="text/css">
    <link href="{{url('assets/admin/layout3/css/layout.css')}}" rel="stylesheet" type="text/css">
    <link href="{{url('assets/admin/layout3/css/themes/default.css')}}" rel="stylesheet" type="text/css" id="style_color">
    <link href="{{url('assets/admin/layout3/css/custom.css')}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="{{url('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}"/>
    <!-- END THEME STYLES -->
    <!--link rel="shortcut icon" href="favicon.ico"/-->
    <link rel="shortcut icon" href="{{ url('images/LIFESOFT.png')}}" type="image/x-icon">
    <script src="{{url('assets/global/plugins/respond.min.js')}}"></script>
    <script src="{{url('assets/global/plugins/excanvas.min.js')}}"></script>
    <![endif]-->
    <script src="{{url('assets/global/plugins/jquery.min.js')}}" type="text/javascript"></script>
    <script src="{{url('assets/global/plugins/jquery-migrate.min.js')}}" type="text/javascript"></script>
    <!-- IMPORTANT! Load jquery-ui.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
    <script src="{{url('assets/global/plugins/jquery-ui/jquery-ui.min.js')}}" type="text/javascript"></script>
    <script src="{{url('assets/global/plugins/bootstrap/js/bootstrap.min.js')}}" type="text/javascript"></script>
    <script src="{{url('assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js')}}" type="text/javascript"></script>
    <script src="{{url('assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js')}}" type="text/javascript"></script>
    <script src="{{url('assets/global/plugins/jquery.blockui.min.js')}}" type="text/javascript"></script>
    <script src="{{url('assets/global/plugins/jquery.cokie.min.js')}}" type="text/javascript"></script>
    <script src="{{url('assets/global/plugins/uniform/jquery.uniform.min.js')}}" type="text/javascript"></script>
    <!-- END CORE PLUGINS -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
   
    <!-- IMPORTANT! fullcalendar depends on jquery-ui.min.js for drag & drop support -->
    <!--script src="{{url('assets/global/plugins/morris/morris.min.js')}}" type="text/javascript"></script>
    <script src="{{url('assets/global/plugins/morris/raphael-min.js')}}" type="text/javascript"></script-->
    <script src="{{url('assets/global/plugins/jquery.sparkline.min.js')}}" type="text/javascript"></script>
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="{{url('assets/global/scripts/metronic.js')}}" type="text/javascript"></script>
    <script src="{{url('assets/admin/layout3/scripts/layout.js')}}" type="text/javascript"></script>
    <script src="{{url('assets/admin/layout3/scripts/demo.js')}}" type="text/javascript"></script>
    <script src="{{url('assets/admin/pages/scripts/index3.js')}}" type="text/javascript"></script>
    <script src="{{url('assets/admin/pages/scripts/tasks.js')}}" type="text/javascript"></script>

    <script>
        jQuery(document).ready(function() {
            Metronic.init(); // init metronic core componets
            Layout.init(); // init layout
            Demo.init(); // init demo(theme settings page)
            //Index.init(); // init index page
            //Tasks.initDashboardWidget(); // init tash dashboard widget
        });
    </script>
    <!-- END JAVASCRIPTS -->

    <script type="text/javascript">
        function time() {
            var today = new Date();
            var weekday=new Array(7);
            weekday[0]="Chủ nhật";
            weekday[1]="Thứ hai";
            weekday[2]="Thứ ba";
            weekday[3]="Thứ tư";
            weekday[4]="Thứ năm";
            weekday[5]="Thứ sáu";
            weekday[6]="Thứ bảy";
            var day = weekday[today.getDay()];
            var dd = today.getDate();
            var mm = today.getMonth()+1; //January is 0!
            var yyyy = today.getFullYear();
            var h=today.getHours();
            var m=today.getMinutes();
            var s=today.getSeconds();
            m=checkTime(m);
            s=checkTime(s);
            nowTime = h+":"+m+":"+s;
            if(dd<10){dd='0'+dd} if(mm<10){mm='0'+mm} today = day+', '+ dd+'/'+mm+'/'+yyyy;

            tmp='<span class="date"> '+today+' | '+nowTime+'</span>';

            document.getElementById("clock").innerHTML=tmp;

            clocktime=setTimeout("time()","1000","JavaScript");
            function checkTime(i)
            {
                if(i<10){
                    i="0" + i;
                }
                return i;
            }
        }
    </script>    
    @yield('custom-script-cb')
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<!-- DOC: Apply "page-header-menu-fixed" class to set the mega menu fixed  -->
<!-- DOC: Apply "page-header-top-fixed" class to set the top menu fixed  -->
<body style="" class="page-header-fixed page-quick-sidebar-over-content page-sidebar-closed-hide-logo page-container-bg-solid" onload="time()">
<!-- BEGIN HEADER -->
<div class="page-header">
    <!-- BEGIN HEADER TOP -->
    <div class="page-header-top" style="">
        <div class="container">
            <!-- BEGIN LOGO -->
            <div class="page-logo">
                <a href="{{url('/CongBo/VanBan')}}">
                <h3 style="text-transform: uppercase;"><b style="color: #25aae2">THI ĐUA KHEN THƯỞNG</b></h3>

            </div>
            <!-- END LOGO -->
            <!-- BEGIN RESPONSIVE MENU TOGGLER -->
            <a href="javascript:;" class="menu-toggler"></a>
            <!-- END RESPONSIVE MENU TOGGLER -->
            <!-- BEGIN TOP NAVIGATION MENU -->
            <div class="top-menu">
                <b style="color: #25aae2"><div id="clock"></div></b>
                @if(Illuminate\Support\Facades\Session::has('admin'))
                    <a class="text-bold text-white no-underline" href="{{url('')}}" data-ga-click="(Logged out) Header, clicked Sign in, text:sign-in">Vào chương trình</a>
                @else
                   <b><a class="text-bold text-white no-underline" href="{{url('/DangNhap')}}" data-ga-click="(Logged out) Header, clicked Sign in, text:sign-in">Đăng nhập</a></b>
                @endif
            </div>
            <!-- END TOP NAVIGATION MENU -->
        </div>

    </div>

    <!-- END HEADER TOP -->
    <!-- BEGIN HEADER MENU -->
    <div class="page-header-menu">
        <div class="container">
            <!-- BEGIN MEGA MENU -->
            <!-- DOC: Apply "hor-menu-light" class after the "hor-menu" class below to have a horizontal menu with white background -->
            <!-- DOC: Remove data-hover="dropdown" and data-close-others="true" attributes below to disable the dropdown opening on mouse hover -->
            <div class="hor-menu ">
                <ul class="nav navbar-nav">
                    <li class="menu-dropdown classic-menu-dropdown">
                        <a data-hover="megamenu-dropdown" data-close-others="true" href="{{url('/CongBo/VanBan')}}">Văn bản pháp lý</a>
                    </li>                    
                    <li class="menu-dropdown classic-menu-dropdown">
                        <a data-hover="megamenu-dropdown" data-close-others="true" href="{{url('/CongBo/QuyetDinh')}}">Quyết định khen thưởng</a>
                    </li>

                    <li class="menu-dropdown classic-menu-dropdown ">
                        <a data-hover="megamenu-dropdown" data-close-others="true" data-toggle="dropdown" href="javascript:;">&nbsp;Hỗ trợ<i class="fa fa-angle-down"></i></a>
                        <ul class="dropdown-menu pull-left">
                            <li><a href="{{url('/danhsachusertaphuan')}}"><i class="icon-folder"></i>&nbsp;Danh sách tài khoản tập huấn</a></li>
                            <li><a href="{{url('/thongtinhotro')}}" target="_blank"><i class="icon-folder"></i> &nbsp;Thông tin hỗ trợ</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <!-- END MEGA MENU -->
        </div>
    </div>
    <!-- END HEADER MENU -->
</div>
<!-- END HEADER -->
<!-- BEGIN PAGE CONTAINER -->
<div class="page-container">
    <!-- BEGIN PAGE HEAD -->
    <!-- END PAGE HEAD -->
    <!-- BEGIN PAGE CONTENT -->
    <div class="page-content" style="">
        <br>
        @yield('content-cb')
    </div>
    <!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->
<!-- BEGIN PRE-FOOTER -->
<!-- END PRE-FOOTER -->
<!-- BEGIN FOOTER -->
<div class="page-prefooter">
    <div class="container">
        <div class="row">
            {{-- <div class="col-md-12 footer-block" style="text-align: center">
                <h2><strong>Giá hàng hóa dịch vụ {{isset(getGeneralConfigs()['diadanh']) ? getGeneralConfigs()['diadanh'] : ''}}</strong></h2>
                <p>Bản quyền thuộc về &nbsp;<b style="color: #25aae2">{{isset(getGeneralConfigs()['tendonvi']) ? getGeneralConfigs()['tendonvi'] : ''}}</b></p>
                <p>Địa chỉ: &nbsp;<b style="color: #25aae2">{{isset(getGeneralConfigs()['diachi']) ? getGeneralConfigs()['diachi'] : ''}}</b></p>
                <p>Thông tin liên hệ: &nbsp;<b style="color: #25aae2">{{isset(getGeneralConfigs()['tel']) ? getGeneralConfigs()['tel'] : ''}}</b></p>
            </div> --}}
        </div>
    </div>
</div>

<div class="page-footer">
    <div class="container">
        <div class="col-md-12">
            Copyright &copy;  2016 - {{date('Y')}} LifeSoft <a href="" >Tiện ích hơn - Hiệu quả hơn</a>
        </div>
    </div>
</div>
<div class="scroll-to-top">
    <i class="icon-arrow-up"></i>
</div>
<!--end::Global Config-->

<!-- END FOOTER -->
<!-- BEGIN JAVASCRIPTS (Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]-->
</body>
<!-- END BODY -->
</html>