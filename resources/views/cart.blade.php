
{{--
///
//  Created by PhpStorm.
//  User: Miracle
//  Date: 2017/4/12
//  Time: 16:03
// /--}}
@extends('master')

@section('title', '购物车')

@section('content')
    <div class="page bk_content" style="top: 0;">
        <div class="weui-cells weui-cells_checkbox">
            @foreach($cart_items as $cart_item)
                <label class="weui-cell weui-check__label" for="{{$cart_item->product->id}}">
                    <div class="weui-cell__hd" style="width: 23px;">
                        <input type="checkbox" class="weui-check" name="cart_item" id="{{$cart_item->product->id}}" checked="checked">
                        <i class="weui-icon-success-no-circle"></i>
                    </div>
                    <div class="weui-cell__bd weui-cell_primary">
                        <div style="position: relative;">
                            <img class="bk_preview" src="{{$cart_item->product->preview}}" class="m3_preview" onclick="_toProduct({{$cart_item->product->id}});"/>
                            <div style="position: absolute; left: 100px; right: 0; top: 0">
                                <p>{{$cart_item->product->name}}</p>
                                <p class="bk_time" style="margin-top: 15px;">数量: <span class="bk_summary">x{{$cart_item->count}}</span></p>
                                <p class="bk_time">总计: <span class="bk_price">￥{{$cart_item->product->price * $cart_item->count}}</span></p>
                            </div>
                        </div>
                    </div>
                </label>
            @endforeach
        </div>
        <form action="/order_commit" id="order_commit" method="post">
          {{ csrf_field() }}
          <input type="hidden" name="product_ids" value="" />

        </form>
        <div class="bk_fix_bottom">
            <div class="bk_half_area">
                <button class="weui-btn weui-btn_primary" onclick="_toCharge();">结算</button>
            </div>
            <div class="bk_half_area">
                <button class="weui-btn weui-btn_default" onclick="_onDelete();">删除</button>
            </div>
        </div>
    </div>
@endsection

@section('my-js')
    <script type="text/javascript">
        $('input:checkbox[name=cart_item]').click(function (event) {
            //选择的状态
            var checked = $(this).attr('checked');
            //当它被选中时 将其转换为未被选中的状态
            if (checked == 'checked'){
                $(this).attr('checked',false);
                $(this).next().removeClass('weui-icon-success-no-circle');
            }
            else {
                $(this).attr('checked','checked');
                $(this).next().addClass('weui-icon-success-no-circle');
            }

        });
        function _onDelete() {
            //删除函数处理
            var product_ids_arr = [];
            //遍历
            $('input:checkbox[name=cart_item]').each(function (index,el) {
                //判断里面的属性是否被选择
                if ($(this).attr('checked') == 'checked'){
                    //被选中，将其存放至一个数组中
                    product_ids_arr.push($(this).attr('id'));
                }

            });

            if (product_ids_arr.length ==0){
                $('.bk_toptips').show();
                $('.bk_toptips span').html('请选择删除项');
                setTimeout(function() {$('.bk_toptips').hide();}, 2000);
                return;
            }

            $.ajax({
                type: "GET",
                url: 'service/cart/delete',
                dataType: 'json',
                cache: false,
                data: {product_ids:product_ids_arr+''},
                success: function (data) {
                    if (data == null) {
                        $('.bk_toptips').show();
                        $('.bk_toptips span').html('服务端错误');
                        setTimeout(function() {
                            $('.bk_toptips').hide();
                        }, 2000);
                        return;
                    }
                    if (data.status != 0) {
                        $('.bk_toptips').show();
                        $('.bk_toptips span').html(data.message);
                        setTimeout(function() {
                            $('.bk_toptips').hide();
                        }, 2000);
                        return;
                    }
                    location.reload();//刷新页面
                },
                error: function (xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                }
            });
        }

        function _toCharge() {
            //结算购物单处理
            var product_ids_arr = [];
            //遍历
            $('input:checkbox[name=cart_item]').each(function (index,el) {
                //判断里面的属性是否被选择
                if ($(this).attr('checked') == 'checked'){
                    //被选中，将其存放至一个数组中
                    product_ids_arr.push($(this).attr('id'));
                }
                if (product_ids_arr.length ==0){
                    $('.bk_toptips').show();
                    $('.bk_toptips span').html('请选择提交项');
                    setTimeout(function() {$('.bk_toptips').hide();}, 2000);
                    return;
                }

            });

            //location.href='/order_commit/'+product_ids_arr;//参数为购物车选中的产品id列表
             $('input[name=product_ids]').val(product_ids_arr+'');
             $('#order_commit').submit();
        }
    </script>
@endsection