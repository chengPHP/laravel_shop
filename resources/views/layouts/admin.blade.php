<!doctype html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>后台管理 Laravel电商实战</title>

    <link rel="shortcut icon" type="image/x-icon" href="{{asset('home/images/laozhang_avatar.png')}}" >

    {{-- jeDate --}}
    <link type="text/css" rel="stylesheet" href="{{asset('admin/js/plugins/jeDate/test/jeDate-test.css')}}">
    <link type="text/css" rel="stylesheet" href="{{asset('admin/js/plugins/jeDate/skin/jedate.css')}}">

    {{-- loading --}}
    <link rel="stylesheet" href="{{asset('admin/js/plugins/loading/css/animate.css')}}">
    <link rel="stylesheet" href="{{asset('admin/js/plugins/loading/css/global.css')}}">
    <link rel="stylesheet" href="{{asset('admin/js/plugins/loading/css/loading.css')}}">

    <link href="{{asset('admin/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('admin/font-awesome/css/font-awesome.css')}}" rel="stylesheet">

    <!-- icheck style-->
    <link href="{{asset('admin/js/plugins/iCheck/skins/all.css')}}" rel="stylesheet">

    <!-- select2 style-->
    <link href="{{ asset('admin/js/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/js/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet">

    <link href="{{asset('admin/css/animate.css')}}" rel="stylesheet">
    <link href="{{asset('admin/css/style.css')}}" rel="stylesheet">


    <!-- webuploader -->
    <link href="{{asset('admin/js/plugins/webuploader/webuploader.css')}}" rel="stylesheet">

    {{--图片预览--}}
    <link href="{{asset('admin/js/plugins/lightbox2/dist/css/lightbox.min.css')}}" rel="stylesheet">

    <!-- bootstrap-datepicker -->
    <link href="{{asset('admin/js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')}}" rel="stylesheet">

    <!-- Mainly scripts -->
    <script src="{{asset('admin/js/jquery-3.1.1.min.js')}}"></script>
    <script src="{{asset('admin/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('admin/js/plugins/metisMenu/jquery.metisMenu.js')}}"></script>
    <script src="{{asset('admin/js/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>

    {{--sweetalert--}}
    <link href="{{asset('admin/css/plugins/sweetalert/sweetalert.css')}}" rel="stylesheet">
    <script src="{{asset('admin/js/plugins/sweetalert/sweetalert.min.js')}}" ></script>

    <!-- ztree -->
    <link rel="stylesheet" href="{{asset('admin/js/plugins/zTree/css/zTreeStyle2/zTreeStyle2.css')}}"  media="all">

    <!-- ztree -->
    <link rel="stylesheet" href="{{asset('admin/css/plugins/text-spinners/spinners.css')}}"  media="all">



    {{--custom--}}
    <link href="{{asset('admin/css/custom.css')}}" rel="stylesheet">

    {{--百度编辑器--}}
    <script type="text/javascript" charset="utf-8" src="{{asset('admin/js/plugins/ueditor/ueditor.config.js')}}"></script>
    <script type="text/javascript" charset="utf-8" src="{{asset('admin/js/plugins/ueditor/ueditor.all.min.js')}}"> </script>
    <!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
    <!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
    <script type="text/javascript" charset="utf-8" src="{{asset('admin/js/plugins/ueditor/lang/zh-cn/zh-cn.js')}}"></script>

    {{--图片预览--}}
    <script src="{{asset('admin/js/plugins/lightbox2/dist/js/lightbox.min.js')}}" ></script>

    <style>
        /*这段CSS样式是修复bootstrap3 模态框关闭，body边距bug*/
        body{
            padding-right: inherit !important;
        }
    </style>

</head>

<body class="pace-done fixed-sidebar skin-1 fixed-nav fixed-nav-basic">

<div id="wrapper">

    {{--菜单栏部分--}}
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element"> <span>
                            @if(auth('admin')->user()->head_portrait)
                                <img alt="image" class="img-circle" src="{{asset(auth('admin')->user()->head_portrait)}}" style="max-height: 48px;max-width: 48px;"/>
                            @else
                                <img alt="image" class="img-circle" src="{{asset('admin/img/profile_small.jpg')}}" />
                            @endif
                             </span>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">{{ auth('admin')->user()->name }}</strong>
                             </span> <span class="text-muted text-xs block">个人信息 <b class="caret"></b></span> </span> </a>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                            <li><a href="profile.html">Profile</a></li>
                            <li><a href="contacts.html">Contacts</a></li>
                            <li><a href="mailbox.html">Mailbox</a></li>
                            <li class="divider"></li>
                            <li>
                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    退出
                                </a>

                                <form id="logout-form" action="{{ url('admin/logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </div>
                    <div class="logo-element">
                        CCM
                    </div>
                </li>
                @include('layouts.menu')
            </ul>
        </div>
    </nav>

    <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
            {{--<nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">--}}
            <nav class="navbar navbar-fixed-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                </div>
                <ul class="nav navbar-top-links navbar-right">
                    <li>
                        <span class="m-r-sm text-muted welcome-message">欢迎来到程传民个人博客后台管理.</span>
                    </li>

                    <li class="dropdown">
                        <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                            <i class="fa fa-envelope"></i>  <span class="label label-warning">16</span>
                        </a>
                        <ul class="dropdown-menu dropdown-messages">
                            <li>
                                <div class="dropdown-messages-box">
                                    <a href="profile.html" class="pull-left">
                                        <img alt="image" class="img-circle" src="{{asset('admin/img/a7.jpg')}}">
                                    </a>
                                    <div class="media-body">
                                        <small class="pull-right">46h ago</small>
                                        <strong>Mike Loreipsum</strong> started following <strong>Monica Smith</strong>. <br>
                                        <small class="text-muted">3 days ago at 7:58 pm - 10.06.2014</small>
                                    </div>
                                </div>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <div class="dropdown-messages-box">
                                    <a href="profile.html" class="pull-left">
                                        <img alt="image" class="img-circle" src="{{asset('admin/img/a4.jpg')}}">
                                    </a>
                                    <div class="media-body ">
                                        <small class="pull-right text-navy">5h ago</small>
                                        <strong>Chris Johnatan Overtunk</strong> started following <strong>Monica Smith</strong>. <br>
                                        <small class="text-muted">Yesterday 1:21 pm - 11.06.2014</small>
                                    </div>
                                </div>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <div class="dropdown-messages-box">
                                    <a href="profile.html" class="pull-left">
                                        <img alt="image" class="img-circle" src="{{asset('admin/img/profile.jpg')}}">
                                    </a>
                                    <div class="media-body ">
                                        <small class="pull-right">23h ago</small>
                                        <strong>Monica Smith</strong> love <strong>Kim Smith</strong>. <br>
                                        <small class="text-muted">2 days ago at 2:30 am - 11.06.2014</small>
                                    </div>
                                </div>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <div class="text-center link-block">
                                    <a href="mailbox.html">
                                        <i class="fa fa-envelope"></i> <strong>Read All Messages</strong>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                            <i class="fa fa-bell"></i>  <span class="label label-primary">8</span>
                        </a>
                        <ul class="dropdown-menu dropdown-alerts">
                            <li>
                                <a href="mailbox.html">
                                    <div>
                                        <i class="fa fa-envelope fa-fw"></i> You have 16 messages
                                        <span class="pull-right text-muted small">4 minutes ago</span>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="profile.html">
                                    <div>
                                        <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                        <span class="pull-right text-muted small">12 minutes ago</span>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="grid_options.html">
                                    <div>
                                        <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                        <span class="pull-right text-muted small">4 minutes ago</span>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <div class="text-center link-block">
                                    <a href="notifications.html">
                                        <strong>See All Alerts</strong>
                                        <i class="fa fa-angle-right"></i>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="{{url('/')}}"><i class="fa fa-desktop"></i> 前台</a>
                    </li>

                    <li>
                        <a href="{{ url('admin/logout') }}"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            <i class="fa fa-sign-out"></i>
                                退出

                            {{--<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">--}}
                                {{--{{ csrf_field() }}--}}
                            {{--</form>--}}
                        </a>
                    </li>
                </ul>

            </nav>
        </div>


        @yield('content')


        <div class="footer fixed" >
            {{--<div class="pull-right">
                10GB of <strong>250GB</strong> Free.
            </div>--}}
            <div>
                <strong>Copyright</strong> Example Company &copy; 2014-2017
            </div>
        </div>

    </div>
</div>


<!-- Large modal -->
<div class="modal bs-example-modal-lg  animated bounceInDown" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="progress m-b-none">
                <div class="progress-bar progress-bar-info progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                    <span class="sr-only">100% Complete</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- md-modal -->
<div id="md-modal" class="modal bs-example-modal-md  animated bounceInDown" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="progress m-b-none">
                <div class="progress-bar progress-bar-info progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                    <span class="sr-only">100% Complete</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!--sm-modal -->
<div class="modal bs-example-modal-sm  animated bounceInDown"  role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="progress m-b-none">
                <div class="progress-bar progress-bar-info progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                    <span class="sr-only">100% Complete</span>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Custom and plugin javascript -->
<script src="{{asset('admin/js/inspinia.js')}}"></script>
<script src="{{asset('admin/js/plugins/pace/pace.min.js')}}"></script>
<script src="{{asset('admin/js/plugins/iCheck/icheck.min.js')}}"></script>
<!-- webuploader -->
<script type="text/javascript" src="{{asset('admin/js/plugins/webuploader/webuploader.min.js')}}"></script>

<!-- ztree -->
<script type="text/javascript" src="{{asset('admin/js/plugins/zTree/js/jquery.ztree.all.min.js')}}"></script>
<script type="text/javascript" src="{{asset('admin/js/plugins/zTree/js/jquery.ztree.exhide.min.js')}}"></script>

<!-- icheck -->
<script type="text/javascript" src="{{asset('admin/js/plugins/iCheck/icheck.js') }}"></script>
<script type="text/javascript" src="{{asset('admin/js/plugins/iCheck/js/custom.min.js')}}"></script>
<!-- select2 -->
<script type="text/javascript" src="{{ asset('admin/js/plugins/select2/js/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('admin/js/plugins/select2/js/i18n/zh-CN.js') }}"></script>

<!-- bootstrap-datepicker -->
<script type="text/javascript" src="{{asset('admin/js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
<script type="text/javascript" src="{{asset('admin/js/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.zh-CN.min.js')}}"></script>

{{-- jeDate --}}
<script type="text/javascript" src="{{asset('admin/js/plugins/jeDate/src/jedate.js')}}"></script>


{{-- loading --}}
<script src="{{asset('admin/js/plugins/loading/js/loading.js')}}"></script>
<script src="{{asset('admin/js/style.js')}}" ></script>

<script>
    $("#refreshTable").on("click",function () {
        window.location.reload();
    });
</script>



<script type="text/javascript">
    // Config box
    if (localStorageSupport){
        localStorage.setItem("fixedfooter",'on');
        localStorage.setItem("fixedsidebar",'on');
        localStorage.setItem("fixednavbar",'off');
        localStorage.setItem("fixednavbar2",'off');
    }

</script>
</body>

</html>
