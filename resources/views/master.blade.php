{{--
  Created by PhpStorm.
  User: Miracle
  Date: 2017/4/5
  Time: 16:55
 --}}
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="/css/weui.css" type="text/css">
    <link rel="stylesheet" href="/css/book.css" type="text/css">
</head>
<body>
    <div class="bk_title_bar">
        <img class="bk_back" src="/img/back.png" alt="" onclick="history.go(-1)">
        <p class="bk_title_content"></p>
        <img class="bk_menu" src="/img/menu.png" alt="" id="showIOSActionSheet">
    </div>
    <div class="page">
        @yield('content')
    </div>
    <!--BEGIN actionSheet-->
    <div>
        <div class="weui-mask" id="iosMask" style="display: none"></div>
        <div class="weui-actionsheet" id="iosActionsheet">
            <div class="weui-actionsheet__menu">
                <div class="weui-actionsheet__cell" onclick="onMenuItemClick(1)">主页</div>
                <div class="weui-actionsheet__cell" onclick="onMenuItemClick(2)">书籍类别</div>
                <div class="weui-actionsheet__cell" onclick="onMenuItemClick(3)">购物车</div>
                <div class="weui-actionsheet__cell" onclick="onMenuItemClick(4)">我的订单</div>
            </div>
            <div class="weui-actionsheet__action">
                <div class="weui-actionsheet__cell" id="iosActionsheetCancel">取消</div>
            </div>
        </div>
    </div>
    <!-- tooltips -->
    <div class="bk_toptips"><span></span></div>
</body>
<script src="/js/jquery-1.11.2.min.js"></script>
<script type="text/javascript">
    $(function(){
        var $iosActionsheet = $('#iosActionsheet');
        var $iosMask = $('#iosMask');

        function hideActionSheet() {
            $iosActionsheet.removeClass('weui-actionsheet_toggle');
            $iosMask.fadeOut(200);
        }

        $iosMask.on('click', hideActionSheet);
        $('#iosActionsheetCancel').on('click', hideActionSheet);
        $("#showIOSActionSheet").on("click", function(){
            $iosActionsheet.addClass('weui-actionsheet_toggle');
            $iosMask.fadeIn(200);
        });

    });

    function onMenuItemClick(index) {
        if(index == 1) {
            $('.bk_toptips').show();
            $('.bk_toptips span').html("敬请期待!");
            setTimeout(function() {$('.bk_toptips').hide();}, 2000);
            } else if(index == 2) {
                location.href = '/category';
            } else if(index == 3){
                location.href = '/cart';
            } else if(index == 4){
                location.href = '/order_list';
            }
    }
    //将标题栏和标题保持一致
    $('.bk_title_content').html(document.title);
</script>

@yield('my-js')
</html>