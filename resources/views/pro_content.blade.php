{{--
  Created by PhpStorm.
 User: Miracle
  Date: 2017/4/9
  Time: 21:42
 --}}
@extends('master')
<link rel="stylesheet" href="/css/swipe.css" type="text/css">
{{--title取数据表中的数据  需要双花括号进行解析的是在blade模板html标签内--}}
@section('title', $product->name)

@section('content')

    <div class="addWrap">
        <div class="swipe" id="mySwipe">
            <div class="swipe-wrap">
                @foreach($pro_imgs as $pro_image)
                    <div>
                        <a href=""><img class="img-responsive" src="{{$pro_image->img_path}}"></a>
                    </div>
                @endforeach
            </div>
        </div>
        <ul id="position">
            @foreach($pro_imgs as $index => $pro_image)
                <li class="{{$index == 0 ? 'cur' : ''}}"></li>
            @endforeach
        </ul>
    </div>

    <div class="weui-cells__title">
        <span class="bk_title">{{$product->name}}</span>
        <span class="bk_price" style="float: right">￥ {{$product->price}}</span>
    </div>
    <div class="weui-cells">
        <div class="weui-cell">
            <p class="bk_summary">{{$product->summary}}</p>
        </div>
    </div>

    <div class="weui-cells__title">详细介绍</div>
    <div class="weui-cells">
        <div class="weui-cell">
            @if($pro_content != null)
                {{--不希望html标签被转义，要使用{！！'内容'！！}--}}
                {!! $pro_content->content !!}
            @else

            @endif
        </div>
    </div>

    <div class="bk_fix_bottom">
        <div class="bk_half_area">
            <button class="weui-btn weui-btn_primary" onclick="addCart()">加入购物车</button>
        </div>
        <div class="bk_half_area">
            <button class="weui-btn weui-btn_default" onclick="toCart()">查看购物车(<span id="cart_num" class="m3_price">{{$count}}</span>)</button>
        </div>
    </div>
@endsection

@section('my-js')
    <script src="/js/swipe.min.js" charset="utf-8"></script>
    <script>
        var bullets = document.getElementById('position').getElementsByTagName('li');
        Swipe(document.getElementById('mySwipe'),{
            auto:2000,//延时
            continuous:true,
            disableScroll:false,
            callback:function (pos) {
                var i = bullets.length;
                while (i--) {
                    bullets[i].className = '';
                }
                bullets[pos].className = 'cur';
                }
        });
        //添加到购物车方法
        function addCart(){
            var product_id = "{{$product->id}}";
            $.ajax({
                type: "GET",
                url: '/service/cart/add/'+ product_id,
                dataType: 'json',
                cache: false,
                success: function (data) {
                    if (data == null) {
                        $('.bk_toptips').show();
                        $('.bk_toptips span').html('服务端错误');
                        setTimeout(function () {
                            $('.bk_toptips').hide();
                        }, 2000);
                        return;
                    }
                    if (data.status != 0) {
                        $('.bk_toptips').show();
                        $('.bk_toptips span').html(data.message);
                        setTimeout(function () {
                            $('.bk_toptips').hide();
                        }, 2000);
                        return;
                    }

                var num = $('#cart_num').html();
                    if (num == '') num = 0;
                    $('#cart_num').html(Number(num)+1);//Number()将字符串转为整形
                },
                error: function (xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                }
            });
        }

        //跳转到购物车页面
        function toCart() {
            location.href = '/cart';
        }
    </script>
@endsection