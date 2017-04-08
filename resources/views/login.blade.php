{{--

  Created by PhpStorm.
  User: Miracle
  Date: 2017/4/5
  Time: 17:00
 --}}

@extends('master')



@section('title','登录')



@section('content')
    <div class="weui-cells weui-cells_form">
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">账号</label></div>
            <div class="weui-cell__bd">
                <input class="weui-input" type="tel"  placeholder="手机号或邮箱" name="username"/>
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">密码</label></div>
            <div class="weui-cell__bd">
                <input class="weui-input" type="password"  placeholder="不少于6位" name="password"/>
            </div>
        </div>
        <div class="weui-cell weui-cell_vcode">
            <div class="weui-cell__hd"><label class="weui-label">验证码</label></div>
            <div class="weui-cell__bd">
                <input class="weui-input" type="text" placeholder="请输入验证码" name="validate_code"/>
            </div>
            <div class="weui-cell__ft">
                <img src="service/validatecode" class="weui-vcode-img"  />
            </div>
        </div>
    </div>
    <div class="weui-cells" >
        <a href="javascript:;" class="weui-btn weui-btn_plain-primary" onclick="onLoginClick()">登录</a>
    </div>
    <a href="register" class="bk_bottom_tips bk_important">没有账号？去注册</a>
@endsection

@section('my-js')
    <script type="text/javascript">
        //这里利用jquery的点击函数，点一下验证码图片，就会自动刷新。为了防止浏览器从缓存中读取图片，所以要为此添加
        //随机数
        //获取图片路径
        $('.weui-vcode-img').click(function () {
            $(this).attr('src','service/validatecode?random='+Math.random());
        });

        //验证信息
        function onLoginClick() {
            //账号验证
            var username = $('input[name=username]').val();
            if (username.length == 0){
                $('.bk_toptips').show();
                $('.bk_toptips span').html('账号不能为空');
                setTimeout(function () {
                    $('.bk_toptips').hide();
                },2000);
                return;
            }
            if (username.indexOf('@') == -1){ //如果没有出现@ 符号 执行下面语句
                //手机号格式验证
                if(username.length != 11 || username[0] != 1){
                    $('.bk_toptips').show();
                    $('.bk_toptips span').html('账号格式不对');
                    setTimeout(function () {
                        $('.bk_toptips').hide();
                    },2000);
                    return;
                }

            }
            else {
                if (username.indexOf('.') == -1){ //出现了@符号但没出现. 符号 邮箱账号格式出错
                    $('.bk_toptips').show();
                    $('.bk_toptips span').html('账号格式不对');
                    setTimeout(function () {
                        $('.bk_toptips').hide();
                    },2000);
                    return;
                }

            }
            //密码格式验证
            var password = $('input[name=password]').val();
            if (password.length == 0){
                $('.bk_toptips').show();
                $('.bk_toptips span').html('密码不能为空');
                setTimeout(function () {
                    $('.bk_toptips').hide();
                },2000);
                return;
            }
            if (password.length < 6){
                $('.bk_toptips').show();
                $('.bk_toptips span').html('密码不能少于6位');
                setTimeout(function () {
                    $('.bk_toptips').hide();
                },2000);
                return;
            }
            //验证码格式验证
            var validate_code = $('input[name=validate_code]').val();
            if (validate_code == 0){
                $('.bk_toptips').show();
                $('.bk_toptips span').html('验证码不能为空');
                setTimeout(function () {
                    $('.bk_toptips').hide();
                },2000);
                return;
            }
            if (password.length < 4){
                $('.bk_toptips').show();
                $('.bk_toptips span').html('验证码不能少于4 位');
                setTimeout(function () {
                    $('.bk_toptips').hide();
                },2000);
                return;
            }
            $.ajax({
                type: "POST",
                url: 'service/login',
                dataType: 'json',
                cache: false,
                data: {
                    username:username,
                    password:password,
                    validate_code:validate_code,
                    _token: "{{csrf_token()}}"
                },
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

                    $('.bk_toptips').show();
                    $('.bk_toptips span').html('登录成功');
                    setTimeout(function () {
                        $('.bk_toptips').hide();
                    }, 2000);

                    //跳转页面建议放在视图中进行跳转 最好不要放在控制器中
                    location.href="categroy";
                },
                error: function (xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                }
            });
        }
    </script>
@endsection