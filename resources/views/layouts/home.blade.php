<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CCM 个人博客</title>
    <meta name="keywords" content="CCM 个人博客">
    <meta name="description" content="CCM 个人博客">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, height=device-height, user-scalable=no, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('home/images/laozhang_avatar.png')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('home/layui/css/layui.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('home/css/style.css')}}">
    <script type="text/javascript" src="{{asset('home/layui/layui.js')}}"></script>
</head>
<body>
<!-- 头部 开始 -->
<div class="layui-header header trans_3">
    <div class="main index_main">
        <a class="logo" href="{{url('/')}}"><img src="{{asset('home/images/logo.png')}}" alt="老张博客前台模版"></a>
        <ul class="layui-nav" lay-filter="top_nav">
            @foreach($navs as $k=>$v)
                @if(!empty($v["_child"]))
                    <li class="layui-nav-item">
                        <a href="javascript:;">{{$v['name']}}</a>
                        <dl class="layui-nav-child"> <!-- 二级菜单 -->
                            @foreach($v['_child'] as $k1=>$v1)
                                <dd><a href="{{url($v1['url'])}}">{{$v1['name']}}</a></dd>
                            @endforeach
                        </dl>
                    </li>
                @else
                    <li class="layui-nav-item home"><a href="{{url($v['url'])}}">{{$v['name']}}</a></li>
                @endif
            @endforeach
        </ul>
        <div class="title">CCM 个人博客</div>
        <!--<form action="" mothod="post" class="head_search trans_3 layui-form">
            <div class="layui-form-item trans_3">
                <span class="close trans_3"><i class="layui-icon">&#x1006;</i> </span>
                <div class="layui-input-inline trans_3">
                    <select name="model_id trans_3">
                        <option value="1" selected >文章模型</option>
                        <option value="2">图集模型</option>
                    </select>
                </div>
                <input type="text" name="keywords" placeholder="搜索" autocomplete="off" class="search_input trans_3">
                <button class="layui-btn" lay-submit="" style="display: none;"></button>
            </div>
        </form>-->
    </div>
</div>
<div class="header_back"></div>
<!-- 头部 结束 -->
<!-- 左边导航 开始 -->
<div class="layui-side layui-bg-black left_nav trans_2">
    <div class="layui-side-scroll">
        <ul class="layui-nav layui-nav-tree"  lay-filter="left_nav">
            @foreach($navs as $k=>$v)
                @if(!empty($v['_child']))
                    <li class="layui-nav-item">
                        <a href="javascript:;">{{$v['name']}}</a>
                        <dl class="layui-nav-child"> <!-- 二级菜单 -->
                            @foreach($v['_child'] as $k1=>$v1)
                                <dd><a href="{{url($v1['url'])}}">{{$v1['name']}}</a></dd>
                            @endforeach
                        </dl>
                    </li>
                @else
                    <li class="layui-nav-item home"><a href="{{url($v['url'])}}">{{$v['name']}}</a></li>
                @endif

            @endforeach
        </ul>
    </div>
</div>
<div class="left_nav_mask"></div>
<div class="left_nav_btn"><i class="layui-icon">&#xe602;</i></div>
<!-- 左边导航 结束 -->

@yield('content')

<!-- 底部 开始 -->
<ul class="layui-fixbar">
    <li class="layui-icon layui-fixbar-top" id="to_top">&#xe604;</li>
</ul>
<div class="layui-footer footer">
    <div class="main index_main">
        <p><a href="javascript:;">xxxxx</a> © xxxxx</p>
        <p class="beian">
            <a class="gongan" target="_blank" href="">
{{--                <img src="{{asset('home/images/gonganbeian.png')}}" alt="xxxxxxxxxxxxx">--}}
                xxxxxxxxxxxxxxxxx
            </a>
            <a class="icp" target="_blank" href="http://www.miitbeian.gov.cn">xxxxxxxxxxxxxxxx</a>
        </p>
    </div>
</div>
<script src="{{asset('admin/js/jquery-3.1.1.min.js')}}"></script>
<!-- 底部 结束 -->
<script type="text/javascript">
    layui.use(['form','element'], function(){
        var layer = layui.layer,
            form = layui.form(),
            element = layui.element(),
            $ = layui.jquery;

        //左边导航点击显示
        $('.left_nav_btn').click(function(){
            $('.left_nav_mask').show();
            $('.left_nav').addClass('left_nav_show');
        });
        //左边导航点击消失
        $('.left_nav_mask').click(function(){
            $('.left_nav').removeClass('left_nav_show');
            $('.left_nav_mask').hide();
        });

        //搜索框特效
        $('.header .head_search .search_input').focus(function(){
            $('.header .head_search').addClass('focus');
            $(this).attr('placeholder','输入关键词搜索');
        });
        $(document).click(function(){
            $('.header .head_search').removeClass('focus');
            $('.header .head_search .search_input').attr('placeholder','搜索');
        });
        $('.header .head_search').click(function(e){
            $(this).addClass('focus');
            e.stopPropagation();
        });
        /*$('.header .head_search .close').click(function(){
         $('.header .head_search').removeClass('focus');
         $('.header .head_search .search_input').attr('placeholder','搜索');
         });*/

        //回到顶部
        $("#to_top").click(function() {
            $("html,body").animate({scrollTop:0}, 200);
        });
        $(document).scroll(function(){
            var	scroll_top = $(document).scrollTop();
            if(scroll_top > 500){
                $("#to_top").show();
            }else{
                $("#to_top").hide();
            }
        });
        //底部版权始终在底部
        /*var win_height = $(window).height();
         var body_height = $('body').height();
         var footer_height = $('.footer').height();
         if(body_height - win_height < 0){
         $('.footer').addClass('footer_fixed');
         } */
    });
</script>
</body>
</html>