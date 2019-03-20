<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">添加商品</h4>
</div>
<form id="signupForm" method="post" class="form-horizontal" action="{{url('admin/product')}}" enctype="multipart/form-data">
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

        {{csrf_field()}}
        <div class="form-group">
            <label for="name" class="col-sm-2 control-label">商品名称</label>
            <div class="col-sm-10">
                <input id="title" type="text" name="title" value="" class="form-control">
            </div>
        </div>
        <div class="hr-line-dashed"></div>
        <div class="form-group">
            <label for="category_id" class="col-sm-2 control-label">所属类别</label>
            <div class="col-sm-10">
                <select id="category_id" class="form-control m-b select2" name="category_id">
                    {!! category_select() !!}
                </select>
            </div>
        </div>
        <div class="hr-line-dashed"></div>
        <div class="form-group">
            <label for="phone" class="col-sm-2 control-label">商品详情</label>
            <div class="col-sm-10">
                <input id="description" type="text" name="description" value="" class="form-control">
            </div>
        </div>
        {{--<div class="hr-line-dashed"></div>
        <div class="form-group">
            <label for="phone" class="col-sm-2 control-label">SKU最低价格</label>
            <div class="col-sm-10">
                <input id="price" type="text" name="price" value="" class="form-control">
            </div>
        </div>--}}

        <div class="hr-line-dashed"></div>
        <div class="form-group">
            <label for="Comment" class="col-sm-2 control-label">商品图片</label>
            <div class="col-sm-10">

                <div id="uploader-demo">
                    <!--用来存放item-->
                    <img id="thumb_img" src="{{url('img/nopicture.jpg')}}" alt="" class="img-lg">
                    <div id="fileList" class="uploader-list"></div>
                    <div id="filePicker">选择图片</div>
                </div>

            </div>
        </div>
        <div class="hr-line-dashed"></div>
        <div class="form-group">
            <label class="col-sm-2 control-label">售卖状态</label>
            <div class="col-sm-10">
                <div class="radio radio-info radio-inline">
                    <input class="icheck_input" type="radio" id="inlineRadio1" value="1" name="on_sale" checked="">
                    <label for="inlineRadio1">是 </label>
                </div>
                <div class="radio radio-inline">
                    <input class="icheck_input" type="radio" id="inlineRadio2" value="0" name="on_sale">
                    <label for="inlineRadio2">否 </label>
                </div>
            </div>
        </div>

        <div class="row" >
            <div class="col-md-12" >
                <a href="javascript:;" class="add btn btn-md btn-success" >增加一栏</a>
                <a href="javascript:;" class="reduce btn btn-md btn-danger" >减去指定栏</a>
                <table class="table table-striped table-bordered SKU_table"  lay-filter="asset-table">
                    <thead>
                        <tr role="row">
                            <td><input type="checkbox" id="checkAll"></td>
                            <th>SKU名称<span style="color: red;" >*</span></th>
                            <th>SKU描述<span style="color: red;" >*</span></th>
                            <th>SKU价格<span style="color: red;" >*</span></th>
                            <th>库存<span style="color: red;" >*</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr >
                            <td><input type="checkbox" name="checks"></td>
                            <td><input class="form-control" type="text" name="SKU_title[]" data-error-container="#error-block" ></td>
                            <td><input class="form-control" type="text" name="SKU_description[]" data-error-container="#error-block" ></td>
                            <td><input class="form-control" type="text" name="SKU_price[]" data-error-container="#error-block" ></td>
                            <td><input class="form-control" type="text" name="SKU_stock[]" data-error-container="#error-block" ></td>
                        </tr>
                    </tbody>
                </table>
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


        // 初始化Web Uploader
        var uploader = WebUploader.create({

            // 选完文件后，是否自动上传。
            auto: true,

            // swf文件路径
            swf: '{{ asset("admin/js/plugins/webuploader/Uploader.swf") }}',

            // 文件接收服务端。
            server: "{{ route('image.upload') }}",

            formData: {
                '_token':'{{ csrf_token() }}'
            },

            // 选择文件的按钮。可选。
            // 内部根据当前运行是创建，可能是input元素，也可能是flash.
            pick: '#filePicker',

            // 只允许选择图片文件。
            accept: {
                title: 'Images',
                extensions: 'gif,jpg,jpeg,bmp,png',
                mimeTypes: 'image/*'
            }
        });

        // 文件上传过程中创建进度条实时显示。
        uploader.on( 'uploadProgress', function( file, percentage ) {
            /*var $li = $( '#'+file.id ),
                $percent = $li.find('.progress span');

            // 避免重复创建
            if ( !$percent.length ) {
                $percent = $('<p class="progress"><span></span></p>')
                    .appendTo( $li )
                    .find('span');
            }

            $percent.css( 'width', percentage * 100 + '%' );*/
        });

        // 文件上传成功，给item添加成功class, 用样式标记上传成功。
        uploader.on( 'uploadSuccess', function( file, response ) {
            // $( '#'+file.id ).addClass('upload-state-done');
            var img_path = response.ids.path;
            $('#thumb_img').attr('src',"http://laravel_shop.me/"+img_path);
            var id = response.ids.id;
            // $('#uploader-demo').append('<input type="hidden" name="file_id" value="'+id+'">');
            $('#uploader-demo').append('<input type="hidden" name="image" value="'+img_path+'">');
        });

        // 文件上传失败，显示上传出错。
        uploader.on( 'uploadError', function( file ) {
            var $li = $( '#'+file.id ),
                $error = $li.find('div.error');

            // 避免重复创建
            if ( !$error.length ) {
                $error = $('<div class="error"></div>').appendTo( $li );
            }

            $error.text('上传失败');
        });

        // 完成上传完了，成功或者失败，先删除进度条。
        uploader.on( 'uploadComplete', function( file ) {
            $( '#'+file.id ).find('.progress').remove();
        });



        $(".add").click(function () {
            $(".SKU_table tbody").append(
                '<tr>' +
                '<td><input type="checkbox" name="checks"></td>' +
                '<td><input class="form-control" type="text" name="SKU_title[]" data-error-container="#error-block"></td>' +
                '<td><input class="form-control" type="text" name="SKU_description[]" data-error-container="#error-block"></td>' +
                '<td><input class="form-control" type="text" name="SKU_price[]" data-error-container="#error-block"></td>'+
                '<td><input class="form-control" type="text" name="SKU_stock[]" data-error-container="#error-block"></td>'+
                '</tr>'
            );
            $('.datepicker').datepicker({
                language: "zh-CN",
                format: 'yyyy-mm-dd',
                autoclose:true
            });
            $(".select2").select2();
        });
        $(".reduce").click(function () {
            $(".table-bordered tbody tr input:checked").parents("tr").remove();
        });


    });
    function tijiao(obj) {
        $.ajax({
            type: "post",
            url: "{{url('admin/product')}}",
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

