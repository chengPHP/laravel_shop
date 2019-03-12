{{--菜单栏--}}
<li class="{{ active_class(if_uri_pattern('admin/index')) }}">
    <a href="{{url('admin/index')}}"><i class="fa fa-desktop"></i> <span class="nav-label">控制面板</span></a>
</li>
<li class="{{ active_class(if_uri_pattern('admin/manager*')) }}">
    <a href="{{url('admin/manager')}}"><i class="fa fa-desktop"></i> <span class="nav-label">后台用户管理</span></a>
</li>
<li class="{{ active_class(if_uri_pattern('admin/role*')) }}">
    <a href="{{url('admin/role')}}"><i class="fa fa-desktop"></i> <span class="nav-label">角色管理</span></a>
</li>
<li class="{{ active_class(if_uri_pattern('admin/permission*')) }}">
    <a href="{{url('admin/permission')}}"><i class="fa fa-desktop"></i> <span class="nav-label">权限管理</span></a>
</li>
{{--
<li class="">
    <a href="{{url('admin/work')}}"><i class="fa fa-folder-open"></i> <span class="nav-label">后台用户管理</span> <span
                class="fa arrow"></span></a>
    <ul class="nav nav-second-level">
        <li class="">
            <a href="{{url('admin/work')}}"><i class="fa fa-envelope"></i> <span class="nav-label">工作内容管理</span></a>
        </li>
        <li class="">
            <a href="{{url('admin/work/create')}}"><i class="fa fa-pencil"></i> <span class="nav-label">添加工作计划</span></a>
        </li>
    </ul>
</li>--}}
