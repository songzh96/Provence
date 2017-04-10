{{--

 Created by PhpStorm.
 User: Miracle
 Date: 2017/4/8
 Time: 20:41

--}}
@extends('master')

@section('title','书籍类别')

@section('content')
    <div class="weui-cells__title">选择书籍类别</div>
     <div class="weui-cells">
         <div class="weui-cell weui-cell_select">
             <div class="weui-cell__bd">
                 <select class="weui-select" name="categroy">
                     {{--遍历数据库数据--}}
                     @foreach($categorys as $category)
                         <option value="{{$category->id}}">{{$category->name}}</option>
                     @endforeach
                 </select>
             </div>
         </div>
     </div>

     <div class="weui-cells aaa">
         <a class="weui-cell weui-cell_access" href="javascript:;">
             <div class="weui-cell__bd">
                 <p>cell standard</p>
             </div>
             <div class="weui-cell__ft">说明文字</div>
         </a>
         <a class="weui-cell weui-cell_access" href="javascript:;">
             <div class="weui-cell__bd">
                 <p>cell standard</p>
             </div>
             <div class="weui-cell__ft">说明文字</div>
         </a>
     </div>
@endsection

@section('my-js')
    <script type="text/javascript">
      _getCategory();
        //监听 select的方法
       $('.weui-select').change(function (event) {
           _getCategory();
       });
        function _getCategory() { //自定义方法最好以下划线定义，当以后看到就知道是自定义的了
            //获取parent_id
                var parent_id = $('.weui-select option:selected').val();
                console.log(parent_id)
            //获取二级类别信息
             $.ajax({
                 type: "GET",
                 url: 'service/category/parent_id/'+parent_id,
                 dataType: 'json',
                 cache: false,
                 success: function (data) {
                     //打印信息，以防出错好查找原因
                     console.log('获取类别数据');
                     console.log(data);
                 if (data == null) {
                 $('.bk_toptips').show();
                 $('.bk_toptips span').html('服务端错误');
                 setTimeout(function () {$('.bk_toptips').hide();}, 2000);
                 return;
                 }
                 if (data.status != 0) {
                 $('.bk_toptips').show();
                 $('.bk_toptips span').html(data.message);
                 setTimeout(function () {$('.bk_toptips').hide();}, 2000);
                 return;
                 }
                  $('.aaa').html('');//先清空对应类中的内容
                    for (var i=0;i<data.categorys.length;i++){
                     var next = 'product/category_id/'+data.categorys[i].id;
                     var node = '<a class="weui-cell weui-cell_access" href="'+next+'">'+
                                     '<div class="weui-cell__bd">'+
                                      '<p>'+data.categorys[i].name+'</p>'+
                                     '</div>'+
                                      '<div class="weui-cell__ft">商品列表</div>'+
                                '</a>';
                        $('.aaa').append(node);//插入节点中的内容
                    }



                 //跳转页面建议放在视图中进行跳转 最好不要放在控制器中

                 },
                 //控制台错误信息打印
                 error: function (xhr, status, error) {
                 console.log(xhr);
                 console.log(status);
                 console.log(error);
                 }
                 });
        }
    </script>
@endsection