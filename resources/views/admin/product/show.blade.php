<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">商品详情信息</h4>
</div>
<form id="signupForm" method="post" class="form-horizontal"  enctype="multipart/form-data">
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
                <input id="title" type="text" name="title" value="{{$info->title}}" disabled class="form-control">
            </div>
        </div>
        <div class="hr-line-dashed"></div>
        <div class="form-group">
            <label for="phone" class="col-sm-2 control-label">商品详情</label>
            <div class="col-sm-10">
                <input id="description" type="text" name="description" value="{{$info->description}}" disabled class="form-control">
            </div>
        </div>
        <div class="hr-line-dashed"></div>
        <div class="form-group">
            <label for="phone" class="col-sm-2 control-label">SKU最低价格</label>
            <div class="col-sm-10">
                <input id="price" type="text" name="price" value="{{$info->price}}" disabled class="form-control">
            </div>
        </div>

        <div class="hr-line-dashed"></div>
        <div class="form-group">
            <label for="Comment" class="col-sm-2 control-label">商品图片</label>
            <div class="col-sm-10">

                <div id="uploader-demo">
                    <!--用来存放item-->
                    {{--<img id="thumb_img" src="{{url('img/nopicture.jpg')}}" alt="" class="img-lg">--}}

                    @if($info->image)
                        <img id="thumb_img" src="{{url($info->image)}}" alt="" class="img-lg">
                    @else
                        <img id="thumb_img" src="{{url('img/nopicture.jpg')}}" alt="" class="img-lg">
                    @endif

                    {{--<div id="fileList" class="uploader-list"></div>--}}
                    {{--<div id="filePicker">选择图片</div>--}}
                </div>

            </div>
        </div>
        <div class="hr-line-dashed"></div>
        <div class="form-group">
            <label class="col-sm-2 control-label">售卖状态</label>
            <div class="col-sm-10">
                <div class="radio radio-info radio-inline">
                    <input class="icheck_input" type="radio" id="inlineRadio1" value="1" name="on_sale" {{$info->on_sale == 1? 'checked':''}} disabled>
                    <label for="inlineRadio1">是 </label>
                </div>
                <div class="radio radio-inline">
                    <input class="icheck_input" type="radio" id="inlineRadio2" value="0" name="on_sale" {{$info->on_sale == 0? 'checked':''}} disabled>
                    <label for="inlineRadio2">否 </label>
                </div>
            </div>
        </div>

        <div class="row" >
            <div class="col-md-12" >
                {{--<a href="javascript:;" class="add btn btn-md btn-success" >增加一栏</a>--}}
                {{--<a href="javascript:;" class="reduce btn btn-md btn-danger" >减去指定栏</a>--}}
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
                        @foreach($info->skus as $k=>$v)
                            <tr>
                                <td><input disabled type="checkbox" name="checks"></td>
                                <td><input disabled class="form-control" type="text" name="SKU_title[{{$k}}]" value="{{$v->title}}" data-error-container="#error-block" ></td>
                                <td><input disabled class="form-control" type="text" name="SKU_description[{{$k}}]" value="{{$v->description}}" data-error-container="#error-block" ></td>
                                <td><input disabled class="form-control" type="text" name="SKU_price[{{$k}}]" value="{{$v->price}}" data-error-container="#error-block" ></td>
                                <td><input disabled class="form-control" type="text" name="SKU_stock[{{$k}}]" value="{{$v->stock}}" data-error-container="#error-block" ></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
    <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn btn-primary">关闭</button>
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

</script>

