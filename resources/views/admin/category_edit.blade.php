<?php
/**
 * Created by PhpStorm.
 * User: Miracle
 * Date: 2017/4/18
 * Time: 16:30
 */?>
@extends('admin.master')
@section('content')
<article class="page-container">
    <form action="" method="post" class="form form-horizontal" id="form-category-edit">
        {{csrf_field()}}
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>名称：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="{{$category->name}}" placeholder= ""  name="name" >
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>序号：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="number" class="input-text" value="{{$category->category_no}}" placeholder=""  name="category_no">
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3">父类别：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <span class="select-box">
				<select class="select" size="1" name="parent_id">
					<option value="{{$category->parent_id}}" >无</option>
                    @foreach($categories as $temp)
                        {
                    @if($temp->id == $category->parent_id){
                        <option selected value="{{$temp->id}}">{{$temp->name}}</option>
                        }
                        @else{
                        <option value="{{$temp->id}}">{{$temp->name}}</option>
                        }
                    }
                    @endif
                    @endforeach
				</select>
				</span>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3">预览图：</label>
            <div class="formControls col-xs-8 col-sm-9">
                @if($category->preview != null)
                    <img id="preview_id" src="{{$category->preview}}" style="border: 1px solid #B8B9B9; width: 100px; height: 100px;" onclick="$('#input_id').click()" />
                @else
                    <img id="preview_id" src="/admin/images/icon-add.png" style="border: 1px solid #B8B9B9; width: 100px; height: 100px;" onclick="$('#input_id').click()" />
                @endif

                <input type="file" name="file" id="input_id" style="display: none;" onchange="return uploadImageToServer('input_id','images', 'preview_id');" />
            </div>
        </div>
        <div class="row cl">
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
            </div>
        </div>
    </form>
</article>
@endsection
@section('my-js')
    <script type="text/javascript">
        $("#form-category-edit").validate({
            rules:{
                name:{
                    required:true,
                    minlength:2,
                    maxlength:16
                },
                category_no:{
                    required:true,
                    isMobile:false,
                },
            },
            onkeyup:false,
            focusCleanup:true,
            success:"valid",
            submitHandler:function(form){
//                //$(form).ajaxSubmit();
//                var index = parent.layer.getFrameIndex(window.name);
//                //parent.$('.btn-refresh').click();
//                parent.layer.close(index);
                $('#form-category-edit').ajaxSubmit({
                    type: 'post', // 提交方式 get/post
                    url: '/admin/service/category/edit', // 需要提交的 url
                    dataType: 'json',
                    data: {
                        id:"{{$category->id}}",
                        name: $('input[name=name]').val(),
                        category_no: $('input[name=category_no]').val(),
                        parent_id: $('select[name=parent_id] option:selected').val(),
                        preview: ($('#preview_id').attr('src')!='/admin/images/icon-add.png'?$('#preview_id').attr('src'):''),
                        _token: "{{csrf_token()}}"
                    },
                    success: function(data) {
                        if(data == null) {
                            layer.msg('服务端错误', {icon:2, time:2000});
                            return;
                        }
                        if(data.status != 0) {
                            layer.msg(data.message, {icon:2, time:2000});
                            return;
                        }

                        layer.msg(data.message, {icon:1, time:2000});
                        parent.location.reload();//刷新父窗口
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr);
                        console.log(status);
                        console.log(error);
                        layer.msg('ajax error', {icon:2, time:2000});//h-ui框架提示信息
                    },
                    beforeSend: function(xhr){
                        layer.load(0, {shade: false});
                    },
                });

                return false;
            }

        });
    </script>
@endsection