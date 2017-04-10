

{{--
  Created by PhpStorm.
  User: Miracle
  Date: 2017/4/5
  Time: 22:02
 --}}

@extends('master')
@section('title','注册')
@section('content')
    <div class="page__bd">
    <div class="weui-cells__title">注册方式</div>
    <div class="weui-cells weui-cells_radio">
        <label class="weui-cell weui-check__label" for="x11">
            <div class="weui-cell__bd">
                <p>手机号注册</p>
            </div>
            <div class="weui-cell__ft">
                <input type="radio" class="weui-check" name="register_type" id="x11" checked="checked">
                <span class="weui-icon-checked" id="checked1"></span>
            </div>
        </label>
        <label class="weui-cell weui-check__label" for="x12">
            <div class="weui-cell__bd">
                <p>邮箱注册</p>
            </div>
            <div class="weui-cell__ft">
                <input type="radio" name="register_type" class="weui-check" id="x12" >
                <span class="weui-icon-checked" id="checked2"></span>
            </div>
        </label>
    </div>
    <div class="weui-cells weui-cells_form">
        <div class="weui-cell weui-cell_vcode">
            <div class="weui-cell__hd">
                <label class="weui-label">手机号</label>
            </div>
            <div class="weui-cell__bd">
                <input class="weui-input" type="number" placeholder="请输入手机号" name="phone"/>
            </div>
            <div class="weui-cell__ft">
                <button class="weui-vcode-btn bk_phone_code_send">获取验证码</button>
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">密码</label></div>
            <div class="weui-cell__bd">
                <input class="weui-input" type="password"  placeholder="不少于6位" name="passwd_phone"/>
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">确认密码</label></div>
            <div class="weui-cell__bd">
                <input class="weui-input" type="password"  placeholder="不少于6位" name="passwd_phone_cfm"/>
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">手机验证码</label></div>
            <div class="weui-cell__bd">
                <input class="weui-input" type="number"  placeholder="手机验证码" name="phone_code"/>
            </div>
        </div>
    </div>
    <div class="weui-cells weui-cells_form" style="display: none">
        <div class="weui-cell ">
            <div class="weui-cell__hd">
                <label class="weui-label">邮箱</label>
            </div>
            <div class="weui-cell__bd">
                <input class="weui-input" type="email" placeholder="请输入邮箱" name="email"/>
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">密码</label></div>
            <div class="weui-cell__bd">
                <input class="weui-input" type="password"  placeholder="不少于6位" name="passwd_email"/>
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">确认密码</label></div>
            <div class="weui-cell__bd">
                <input class="weui-input" type="password"  placeholder="不少于6位" name="passwd_email_cfm"/>
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
        <a href="javascript:;" class="weui-btn weui-btn_plain-primary" onclick="OnRegisterClick();">注册</a>
    </div>
        <a href="login" class="bk_bottom_tips bk_important">已有账号？去登录</a>
@endsection

@section('my-js')
    <script type="text/javascript">

        //这里利用jquery的点击函数，点一下验证码图片，就会自动刷新。为了防止浏览器从缓存中读取图片，所以要为此添加
        //随机数
        //获取图片路径
        $('.weui-vcode-img').click(function () {
            $(this).attr('src','service/validatecode?random='+Math.random());
        });
        //注册方式表单处理
        $('#x12').next().hide();
        $('input:radio[name=register_type]').click(function(event) {
            $('input:radio[name=register_type]').attr('checked', false);
            $(this).attr('checked', true);
            if($(this).attr('id') == 'x11') {
                $('#x11').next().show();
                $('#x12').next().hide();
                $('.weui-cells_form').eq(0).show();
                $('.weui-cells_form').eq(1).hide();
            } else if($(this).attr('id') == 'x12') {
                $('#x12').next().show();
                $('#x11').next().hide();
                $('.weui-cells_form').eq(1).show();
                $('.weui-cells_form').eq(0).hide();
            }
        });
    </script>
        <script type="text/javascript">
        //手机发送验证码事件前端
        var enable=true;//是否允许发送验证短信
        $('.bk_phone_code_send').click(function (event) {
            //发送验证码
            if(enable == false){
                return;//直接返回不会调用发送短信的接口
            }
            var phone = $('input[name=phone]').val();//获取参数
            // 手机号不为空
            if(phone == '') {
                $('.bk_toptips').show();
                $('.bk_toptips span').html('请输入手机号');
                setTimeout(function() {$('.bk_toptips').hide();}, 2000);
                return;
            }
            // 手机号格式
            if(phone.length != 11 || phone[0] != '1') {
                $('.bk_toptips').show();
                $('.bk_toptips span').html('手机格式不正确');
                setTimeout(function() {$('.bk_toptips').hide();}, 2000);
                return;
            }
            //改变计时文字的颜色
            $(this).removeClass('bk_important');
            $(this).addClass('bk_summary');
            enable = false;//一旦点击将其置为false
            var time = 60;//允许多长时间后重新发送
            var interval = window.setInterval(function () { //定义一个计时器
                $('.bk_phone_code_send').html(--time+'s 重新发送'); //改变按钮的状态，并改变上面的文字
                if (time == 0){//当计时器为0时可重新发送
                    $('.bk_phone_code_send').addClass('bk_important');
                    $('.bk_phone_code_send').removeClass('bk_summary');
                    enable = true;
                    window.clearInterval(interval);
                    $('.bk_phone_code_send').html('重新发送');
                }
            },1000);
            //手机发送验证码事件后端（ajax）
            $.ajax({
                type: "POST",
                url:'service/validate_phone/send',//url
                dataType:'json',//数据类型
                cache:false,//是否缓存
                data:{phone:phone,
                    _token: "{{csrf_token()}}"},//传递的参数
                //成功返回的信息
                success:function (data) {
                    //参数错误处理
                    if (data.status != 0){
                        $('.bk_toptips').show();
                        $('.bk_toptips span').html(data.message);
                        setTimeout(function () {
                            $('.bk_toptips').hide();
                        },2000);
                        return;
                    }
                    //成功处理
                    $('.bk_toptips').show();
                    $('.bk_toptips span').html('发送成功');
                    setTimeout(function () {
                        $('.bk_toptips').hide();
                    },2000);
                    return;
                },
                //失败返回的信息
                error:function (xhr,status,message) {
                    console.log(xhr);
                    console.log(status);
                    console.log(message);
                }
            })
        })
    </script>
    <script type="text/javascript">
        //点击注册按钮验证事件
        function OnRegisterClick() {
            $('input:radio[name=register_type]').each(function (index, el) {
                if ($(this).attr('checked') != 'checked') {
                } else {
                    var email = '';
                    var phone = '';
                    var password = '';
                    var confirm = '';
                    var phone_code = '';
                    var validate_code = '';

                    var id = $(this).attr('id');
                    if (id == 'x11') {
                        phone = $('input[name=phone]').val();
                        password = $('input[name=passwd_phone]').val();
                        confirm = $('input[name=passwd_phone_cfm]').val();
                        phone_code = $('input[name=phone_code]').val();
                        if (verifyPhone(phone, password, confirm, phone_code) == false) {
                            return;
                        }
                    } else if (id == 'x12') {
                        email = $('input[name=email]').val();
                        password = $('input[name=passwd_email]').val();
                        confirm = $('input[name=passwd_email_cfm]').val();
                        validate_code = $('input[name=validate_code]').val();
                        if (verifyEmail(email, password, confirm, validate_code) == false) {
                            return;
                        }
                    }

                    $.ajax({
                        type: "POST",
                        url: 'service/register',
                        dataType: 'json',
                        cache: false,
                        data: {
                            phone: phone,
                            email: email,
                            password: password,
                            confirm: confirm,
                            phone_code: phone_code,
                            validate_code: validate_code,
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
                            $('.bk_toptips span').html('注册成功');
                            setTimeout(function () {
                                $('.bk_toptips').hide();
                            }, 2000);
                        },
                        error: function (xhr, status, error) {
                            console.log(xhr);
                            console.log(status);
                            console.log(error);
                        }
                    });
                }
            });
        }
            //手机号验证处理逻辑（前端校验）
            function verifyPhone(phone, password, confirm, phone_code) {
                // 手机号不为空
                if (phone == '') {
                    $('.bk_toptips').show();
                    $('.bk_toptips span').html('请输入手机号');
                    setTimeout(function () {
                        $('.bk_toptips').hide();
                    }, 2000);
                    return false;
                }
                // 手机号格式
                if (phone.length != 11 || phone[0] != '1') {
                    $('.bk_toptips').show();
                    $('.bk_toptips span').html('手机格式不正确');
                    setTimeout(function () {
                        $('.bk_toptips').hide();
                    }, 2000);
                    return false;
                }
                if (password == '' || confirm == '') {
                    $('.bk_toptips').show();
                    $('.bk_toptips span').html('密码不能为空');
                    setTimeout(function () {
                        $('.bk_toptips').hide();
                    }, 2000);
                    return false;
                }
                if (password.length < 6 || confirm.length < 6) {
                    $('.bk_toptips').show();
                    $('.bk_toptips span').html('密码不能少于6位');
                    setTimeout(function () {
                        $('.bk_toptips').hide();
                    }, 2000);
                    return false;
                }
                if (password != confirm) {
                    $('.bk_toptips').show();
                    $('.bk_toptips span').html('两次密码不相同!');
                    setTimeout(function () {
                        $('.bk_toptips').hide();
                    }, 2000);
                    return false;
                }
                if (phone_code == '') {
                    $('.bk_toptips').show();
                    $('.bk_toptips span').html('手机验证码不能为空!');
                    setTimeout(function () {
                        $('.bk_toptips').hide();
                    }, 2000);
                    return false;
                }
                if (phone_code.length != 6) {
                    $('.bk_toptips').show();
                    $('.bk_toptips span').html('手机验证码为6位!');
                    setTimeout(function () {
                        $('.bk_toptips').hide();
                    }, 2000);
                    return false;
                }
                return true;
            }

            //邮箱验证处理逻辑（前端校验）
            function verifyEmail(email, password, confirm, validate_code) {
                // 邮箱不为空
                if (email == '') {
                    $('.bk_toptips').show();
                    $('.bk_toptips span').html('请输入邮箱');
                    setTimeout(function () {
                        $('.bk_toptips').hide();
                    }, 2000);
                    return false;
                }
                // 邮箱格式
                if (email.indexOf('@') == -1 || email.indexOf('.') == -1) {
                    $('.bk_toptips').show();
                    $('.bk_toptips span').html('邮箱格式不正确');
                    setTimeout(function () {
                        $('.bk_toptips').hide();
                    }, 2000);
                    return false;
                }
                if (password == '' || confirm == '') {
                    $('.bk_toptips').show();
                    $('.bk_toptips span').html('密码不能为空');
                    setTimeout(function () {
                        $('.bk_toptips').hide();
                    }, 2000);
                    return false;
                }
                if (password.length < 6 || confirm.length < 6) {
                    $('.bk_toptips').show();
                    $('.bk_toptips span').html('密码不能少于6位');
                    setTimeout(function () {
                        $('.bk_toptips').hide();
                    }, 2000);
                    return false;
                }
                if (password != confirm) {
                    $('.bk_toptips').show();
                    $('.bk_toptips span').html('两次密码不相同!');
                    setTimeout(function () {
                        $('.bk_toptips').hide();
                    }, 2000);
                    return false;
                }
                if (validate_code == '') {
                    $('.bk_toptips').show();
                    $('.bk_toptips span').html('验证码不能为空!');
                    setTimeout(function () {
                        $('.bk_toptips').hide();
                    }, 2000);
                    return false;
                }
                if (validate_code.length != 4) {
                    $('.bk_toptips').show();
                    $('.bk_toptips span').html('验证码为4位!');
                    setTimeout(function () {
                        $('.bk_toptips').hide();
                    }, 2000);
                    return false;
                }
                return true;
            }

    </script>
@endsection