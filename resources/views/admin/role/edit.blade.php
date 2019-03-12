<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">修改角色信息</h4>
</div>
<form method="post" class="form-horizontal" action="{{url('admin/role')}}/{{$info->id}}">
    <div class="modal-body">
        {{--错误信息提示--}}
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <div class="form-group">
            <label for="name" class="col-sm-2 control-label">角色名称</label>
            <div class="col-sm-10">
                <input id="name" type="text" name="name" value="{{$info->name}}" class="form-control">
            </div>
        </div>
        <div class="hr-line-dashed"></div>

        <div class="form-group">
            <label for="permission" class="col-sm-2 control-label">选择权限</label>
            <div class="col-sm-10">
                <ul id="power-tree" class="ztree">
                </ul>
            </div>
        </div>

        <div class="hr-line-dashed"></div>
        <div class="form-group">
            <label for="phone" class="col-sm-2 control-label">角色别名</label>
            <div class="col-sm-10">
                <input id="display_name" type="text" name="display_name" value="{{$info->display_name}}" class="form-control">
            </div>
        </div>
        <div class="hr-line-dashed"></div>
        <div class="form-group">
            <label class="col-sm-2 control-label">状态</label>
            <div class="col-sm-10">
                <div class="radio radio-info radio-inline">
                    <input class="icheck_input" type="radio" id="inlineRadio1" value="1" name="status" {{$info->status==1 ? 'checked': ''}}>
                    <label for="inlineRadio1">启用 </label>
                </div>
                <div class="radio radio-inline">
                    <input class="icheck_input" type="radio" id="inlineRadio2" value="0" name="status" {{$info->status==0 ? 'checked': ''}}>
                    <label for="inlineRadio2">禁用 </label>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <button type="button" onclick="tijiao(this)" class="btn btn-primary">提交</button>
    </div>
</form>
<script type="text/javascript">

    //页面加载完成后初始化select2控件
    $(document).ready(function() {
        blog.handleSelect2();

        $('.icheck_input').on('ifCreated ifClicked ifChanged ifChecked ifUnchecked ifDisabled ifEnabled ifDestroyed', function(event){
        }).iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%'
        });
    });

    var powerSetting = {
        check: {
            enable: true
        },
        data: {
            simpleData: {
                enable: true,
                idKey: "id",
                pIdKey: "pid"
            },
            key: {
                checked: "checked",
                name: "display_name"
            }
        },
        view:{showIcon:false}
    };

    var powerNodes = {!! json_encode($permissions) !!};

    $(document).ready(function () {
        $.fn.zTree.init($("#power-tree"), powerSetting, powerNodes);
    })
</script>
<script type="text/javascript" >
    function tijiao(obj) {

        var nodes =  $.fn.zTree.getZTreeObj("power-tree").getCheckedNodes(true);
        var nodesValue = [];
        $.each(nodes,function(i,value){
            nodesValue.push(value.id);
        });

        $.ajax({
            type: "post",
            url: "{{url('admin/role')}}/{{$info->id}}",
//            data: $('.form-horizontal').serialize(),
            data: {
                'name' : $("#name").val(),
                'permissions' : nodesValue,
                'display_name': $("#display_name").val(),
                'description' : $("#description").val(),
                'status': $("input[name=status]").val(),
                '_token': "{{csrf_token()}}",
                '_method': "PUT"
            },
            dataType:"json",
            beforeSend:function () {
                // 禁用按钮防止重复提交
                $(obj).attr({ disabled: "disabled" });
                blog.loading('正在提交，请稍等...');
            },
            success: function (data) {
                if(data.code==1){
                    swal({
                        title: "",
                        text: data.message,
                        type: "success",
                        timer: 1000,
                    },function () {
                        window.location.reload();
                    });
                }else{
                    swal("", data.message, "error");
                }
            },
            complete:function () {
                $(obj).removeAttr("disabled");
                removeLoading('loading');
            },
            error:function (jqXHR, textStatus, errorThrown) {
                blog.errorPrompt(jqXHR, textStatus, errorThrown);
            }
        });
    }

</script>

