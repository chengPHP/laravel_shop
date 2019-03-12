@extends('layouts.admin')

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>个人博客后台</h2>
{{--            {!! Breadcrumbs::render('role'); !!}--}}
        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">

                    <div class="ibox-title">
                        {{--<h5>角色管理列表</h5>--}}
                        <button onclick="add()" class="btn btn-m btn-primary" id="add-btn" data-toggle="modal" data-target=".bs-example-modal-md"><i class="fa fa-plus"></i> 添加</button>
                        <button onclick="delRoles()" class="btn btn-m btn-danger" id="add-btn"><i class="fa fa-trash-o"></i> 删除</button>

                        <div class="col-sm-5" style="float: right;" >
                            <div class="input-group">
                                <input type="text" id="search-text" placeholder="角色名称" value="{{$search}}" class="form-control">
                                <span class="input-group-btn">
                                  <button type="button" class="btn blue" id="simple-search"><i class="fa fa-search"></i> 查询</button>
                                  <a href="javascript:;" class="btn btn-outline btn-default" id="refreshTable"><i class="fa fa-refresh"></i> 刷新</a>
                                </span>
                            </div>
                        </div>

                    </div>
                    <div class="ibox-content">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th><input class="icheck_input_all" type="checkbox"></th>
                                    <th>id</th>
                                    <th>状态</th>
                                    <th>角色名称</th>
                                    <th>角色别名</th>
                                    <th>guard_name</th>
                                    <th>设置</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($list as $v)
                                    <tr>
                                        <td><input class="icheck_input" type="checkbox" value="{{$v['id']}}"></td>
                                        <td>{{$v['id']}}</td>
                                        <td>
                                            @if($v['status']==0)
                                                禁用
                                            @else
                                                启用
                                            @endif
                                        </td>
                                        <td>{{$v['name']}}</td>
                                        <td>{{$v['display_name']?$v['display_name']:'暂无'}}</td>
                                        <td>{{$v['guard_name']}}</td>
                                        <td>
                                            <span class="btn btn-xs btn-info" title="修改角色信息" onclick="updateRole('{{$v['id']}}')" data-toggle="modal" data-target=".bs-example-modal-md"><i class="fa fa-wrench"></i> 修改</span>
                                            <span class="btn btn-xs btn-danger" title="删除角色" onclick="deleteRole('{{$v['id']}}')"><i class="fa fa-trash-o" ></i> 删除</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{$list->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" >

        $(document).ready(function(){
            $('.icheck_input,.icheck_input_all').on('ifCreated ifClicked ifChanged ifChecked ifUnchecked ifDisabled ifEnabled ifDestroyed', function(event){
            }).iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%'
            });

            //全选
            $('.icheck_input_all').on('ifChecked', function(event){
                $('.icheck_input').iCheck('check')
            });

            //全不选
            $('.icheck_input_all').on('ifUnchecked', function(event){
                $('.icheck_input').iCheck('uncheck')
            });
        });

        function add() {
            $(".bs-example-modal-md .modal-content").html();
            $.ajax({
                url: "{{ url('admin/role/create') }}",
                type: 'GET',
                dataType: 'HTML',
                cache:false,
                beforeSend: function () {
                },
                success: function (data, textStatus, xhr) {
                    $(".bs-example-modal-md .modal-content").html(data);
                }
            });
        }

        function updateRole(id) {
            $(".bs-example-modal-md .modal-content").html();
            $.ajax({
                url: "{{url('admin/role')}}/"+id+'/edit',
                type: 'GET',
                dataType: 'HTML',
                cache:false,
                beforeSend: function () {
                },
                success: function (data, textStatus, xhr) {
                    $(".bs-example-modal-md .modal-content").html(data);
                }
            });
        }

        function deleteItems(ids,url,title) {
            swal({
                    title: title,
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    cancelButtonText: "取消",
                    confirmButtonText: "确认",
                    closeOnConfirm: false
                },
                function(){
                    $.ajax({
                        url: url+'/'+ids,
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            "_token": '{{csrf_token()}}',
                            '_method': 'delete'
                        },
                        beforeSend: function () {
                        },
                        success: function (data, textStatus, xhr) {
                            if(data.code==1){
                                swal({
                                    title: "",
                                    text: data.message,
                                    type: "success",
                                    timer: 1000
                                },function () {
                                    window.location.reload();
                                });
                            }else if (data.code==0){
                                swal({
                                    title: "",
                                    text: data.message,
                                    type: 'error',
                                    confirmButtonText: "确定"
                                },function () {
                                    window.location.reload();
                                });
                            }
                        }
                    });
                });
        }


        function deleteRole(id) {
            deleteItems(id,"{{url('admin/role')}}","确定删除该角色吗？");
        }

        function delRoles() {
            var checkStatus = $("tbody input[type='checkbox']:checked");
            if(checkStatus.length >= 1){
                var ids = [];
                $.each(checkStatus,function(i,v){
                    ids.push(v.value);
                });
                ids = ids.toString();
                deleteItems(ids,"{{url('admin/role')}}","确定删除这些角色吗？");

            }else{
                swal("请选择至少一条数据！", "", "warning");
            }

        }

        $("#simple-search").on('click',function () {
            window.location.href = "{{url('admin/role')}}?search="+$("#search-text").val();
        });



    </script>

@endsection