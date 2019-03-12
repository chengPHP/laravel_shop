<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>登录页 {{config("program.title")}}</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('home/images/laozhang_avatar.png')}}">
    <link href="{{asset('admin/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('admin/font-awesome/css/font-awesome.css')}}" rel="stylesheet">

    <link href="{{asset('admin/css/animate.css')}}" rel="stylesheet">
    <link href="{{asset('admin/css/style.css')}}" rel="stylesheet">

</head>

<body class="gray-bg">

<div class="middle-box text-center loginscreen animated fadeInDown">
    <div>
        <div>
            <h1 class="logo-name" style="font-size: 130px;padding-bottom: 80px;" >EDU</h1>
        </div>

        <form class="form-horizontal m-t" role="form" method="POST" action="{{ route('admin.login') }}">

            {{ csrf_field() }}

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <div class="col-md-12">
                    <input type="text" class="form-control" name="email" placeholder="邮箱" value="{{ old('email') }}" required autofocus>
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <div class="col-md-12">
                    <input type="password" class="form-control" name="password" placeholder="密码" required>
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <button type="submit" class="btn btn-primary block full-width m-b">登录</button>
            <a class="btn btn-sm btn-white btn-block" href="">注册一个新用户</a>
        </form>
        <p class="m-t"> <small>Inspinia we app framework base on Bootstrap 3 &copy; 2014</small> </p>
    </div>
</div>

<!-- Mainly scripts -->
<script src="{{asset('admin/js/jquery-3.1.1.min.js')}}"></script>
<script src="{{asset('admin/js/bootstrap.min.js')}}"></script>
<script>

    function updateImg() {
        $("#captcha").attr("src",'/captcha/default?'+Math.random());
    }

</script>
</body>

</html>