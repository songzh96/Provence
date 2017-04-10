{{--
  Created by PhpStorm.
 User: Miracle
  Date: 2017/4/9
  Time: 21:42
 --}}
@extends('master')

@section('title', '书籍列表')

@section('content')
    <div class="weui-cells">
        @foreach($products as $product)
            <a class="weui-cell  weui-cells_access" href="/product/{{$product->id}}">
                <div class="weui-cell__hd"><img class="bk_preview" src="{{$product->preview}}"></div>
                <div class="weui-cell__bd ">
                    <div style="margin-bottom: 10px;">
                        <span class="bk_title">{{$product->name}}</span>
                        <span class="bk_price" style="float: right;">￥ {{$product->price}}</span>
                    </div>
                    <p class="bk_summary">{{$product->summary}}</p>
                </div>
                <div class="weui-cell__ft"></div>
            </a>
        @endforeach
    </div>
@endsection

@section('my-js')

@endsection