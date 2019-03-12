<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">修改用户信息</h4>
</div>
<form method="post" class="form-horizontal" action="{{url('admin/user')}}/{{$info->id}}">
    <div class="modal-body">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <input type="hidden" name="_method" value="PUT">
        <div class="form-group">
            <label for="name" class="col-sm-2 control-label">姓名</label>
            <div class="col-sm-10">
                <input id="name" type="text" name="name" value="{{$info->name}}" class="form-control">
            </div>
        </div>
        <div class="hr-line-dashed"></div>
        <div class="form-group">
            <label for="phone" class="col-sm-2 control-label">手机号</label>
            <div class="col-sm-10">
                <input id="phone" type="email" name="phone" value="{{$info->phone}}" class="form-control">
            </div>
        </div>
        <div class="hr-line-dashed"></div>
        <div class="form-group">
            <label for="email" class="col-sm-2 control-label">邮箱</label>
            <div class="col-sm-10">
                <input id="email" type="email" name="email" value="{{$info->email}}" class="form-control">
            </div>
        </div>
        <div class="hr-line-dashed"></div>
        <div class="form-group">
            <label for="password" class="col-sm-2 control-label">密码</label>
            <div class="col-sm-10">
                <input id="password" type="password" name="password" value="" class="form-control">
                <span class="help-block dw-fontsize-8">* 密码为空，则不修改密码</span>
            </div>
        </div>
        <div class="hr-line-dashed"></div>
        <div class="form-group">
            <label for="repassword" class="col-sm-2 control-label">确认密码</label>
            <div class="col-sm-10">
                <input id="repassword" type="password" name="repassword" value="" class="form-control">
            </div>
        </div>
        <div class="hr-line-dashed"></div>
        <div class="form-group">
            <label for="role_id" class="col-sm-2 control-label">角色</label>
            <div class="col-sm-10">
                <select id="role_id" class="form-control m-b select2" multiple="multiple" name="role_id[]">
                    {!! role_select($info->roles->pluck('id')->all(),0) !!}
                </select>
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

<script type="text/javascript" >
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
    function tijiao(obj) {
        $.ajax({
            type: "post",
            url: "{{url('admin/user')}}/{{$info->id}}",
            data: $('.form-horizontal').serialize(),
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

