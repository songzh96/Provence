
{{--
///
//  Created by PhpStorm.
//  User: Miracle
//  Date: 2017/4/14
//  Time: 21:03
// /--}}
@extends('master')

@section('title', '订单列表')

@section('content')
    {{--用户有多少条订单--}}
    @foreach($orders as $order)
        <div class="weui-cells__title">
            <span>订单号: {{$order->order_no}}</span>

            @if($order->status == 1)
                <span style="float: right;" class="bk_price">
            未支付
          </span>
            @else
                <span style="float: right;" class="bk_important">
            已支付
          </span>
            @endif

        </div>
        <div class="weui-cells">
            {{--这个订单所包含的产品信息--}}
            @foreach($order->order_items as $order_item)
                <div class="weui-cell">
                    <div class="weui-cell__hd">
                        <img src="{{$order_item->product->preview}}" alt="" class="bk_icon">
                    </div>
                    <div class="weui-cell__bd weui-cell_primary">
                        <p class="bk_summary">{{$order_item->product->name}}</p>
                    </div>
                    <div class="weui-cell__ft">
                        <span class="bk_summary">{{$order_item->product->price}}</span>
                        <span> x </span>
                        <span class="bk_important">{{$order_item->count}}</span>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="weui-cells__tips" style="text-align: right;">合计: <span class="bk_price">{{$order->total_price}}</span></div>
    @endforeach
@endsection

@section('my-js')

@endsection