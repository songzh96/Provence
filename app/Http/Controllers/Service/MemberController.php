<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Models\M3Email;
use App\Tool\UUID;
use Illuminate\Http\Request;
use App\Models\M3Result;
use App\Entity\TempPhone;
use App\Entity\TempEmail;
use App\Entity\Member;
use Illuminate\Support\Facades\Mail;

class MemberController extends Controller
{
    /**
     * @param Request $request
     * @return string
     */
    public function register(Request $request){
        $email = $request->input('email','');
        $phone = $request->input('phone','');
        $password = $request->input('password','');
        $confirm = $request->input('confirm','');
        $phone_code = $request->input('phone_code','');
        $validate_code = $request->input('validate_code','');

        $m3_result = new M3Result();
        //校验
       if($email == '' && $phone == '') {
            $m3_result->status = 1;
            $m3_result->message = '手机号或邮箱不能为空';
            return $m3_result->toJson();
        }
        if($password == '' || strlen($password) < 6) {
            $m3_result->status = 2;
            $m3_result->message = '密码不少于6位';
            return $m3_result->toJson();
        }
        if($confirm == '' || strlen($confirm) < 6) {
            $m3_result->status = 3;
            $m3_result->message = '确认密码不少于6位';
            return $m3_result->toJson();
        }
        if($password != $confirm) {
            $m3_result->status = 4;
            $m3_result->message = '两次密码不相同';
            return $m3_result->toJson();
        }

    //手机号注册
    if($phone != ''){
        if( $phone_code == '' ||strlen($phone_code) !=6) {
            $m3_result->status = 5;
            $m3_result->message = '手机验证码为6位';
            return $m3_result->toJson();

        }
        //查询手机号
        //参数1 要查询的字段名称  第二个参数 不写的话默认为= 如果要判断大小需要将其添加上 第三个是传进来的值
        $tempPhone = TempPhone::where('phone_number','=',$phone)->first();
        //判断验证码处理逻辑
        //判断数据库中的验证码是否和输入的一致
        if($tempPhone->code == $phone_code){
            //如果一致再进行验证码是否过期判断
            if(time() > strtotime($tempPhone->deadline)){ //strtotime将时间字符串转换为时间戳
                $m3_result->status = 7;
                $m3_result->message = '手机验证码不正确';
                return $m3_result->toJson();
            }
            //验证格式验证正确后 处理逻辑
            $member = new Member();
            $member->phone = $phone;//传手机号
            $member->password = md5('bk'+$password);//传密码  md5加密
            $member->save();//将数据存到数据表中

            $m3_result->status = 0;
            $m3_result->message = '注册成功';
            return $m3_result->toJson();

        }
            else{
                $m3_result->status = 7;
                $m3_result->message = '手机验证码不正确';
                return $m3_result->toJson();
            }

    }
    //邮箱注册
    else
        {
        if( $validate_code == '' ||strlen($validate_code) !=4){
            $m3_result->status =6;
            $m3_result->message = '验证码为四位';
            return $m3_result->toJson();
        }
        //注意 使用session时一定要统一，不能同时用laravel和php原生的session 这样会出错 而且错误并不好找
        $validate_code_session = $request->session()->get('validate_code','');
        //判断session中的验证码是否和客户端输入的一致
       if($validate_code_session != $validate_code) {
            $m3_result->status = 8;
            $m3_result->message = '验证码不正确';
            return $m3_result->toJson();
        }

        //验证格式验证正确后 处理逻辑
        $member = new Member();
        $member->email = $email;//传邮箱账号
        $member->password = md5('bk'+$password);//传密码  md5加密
        $member->save();//将数据存到数据表中

        //发送邮件
        $uuid = UUID::create();//生成uuid

        $m3_email = new M3Email();
        $m3_email->to = $email;
        $m3_email->cc = '18256929575@163.com';//抄送
        $m3_email->subject = '邮箱验证';
        $m3_email->content = '请于24小时内点击该链接完成验证。
                                http://127.0.0.1/laravel/public/service/validate_email'
                                . '?member_id=' . $member->id
                                . '&code=' . $uuid;
        //将信息存放到数据表中
            $tempEmail = new TempEmail();
            $tempEmail->member_id = $member->id;
            $tempEmail->code = $uuid;
            $tempEmail->deadline =date('Y-m-d H-i-s',time()+24*60*60);
            $tempEmail->save();
        //use 的作用：由于function是闭包函数当我们需要使用外部变量的时候 我们需要通过使用use 才能将外部参数传进来
        Mail::send('email_register', ['m3_email'=> $m3_email], function ($message) use ($m3_email) {
            $message->to($m3_email->to,'尊敬的用户')
                ->cc($m3_email->cc)
                ->subject($m3_email->subject);
        });
        $m3_result->status = 0;
        $m3_result->message = '注册成功';
        return $m3_result->toJson();
        }
    }
    public function login(Request $request){
        $username = $request->get('username','');
        $password = $request->get('password','');
        $validate_code = $request->get('validate_code','');

        $m3_result = new M3Result();
        //校验

        //判断
        //验证码判断
        $validate_code_session = $request->session()->get('validate_code','');
        if($validate_code_session != $validate_code) {
            $m3_result->status = 1;
            $m3_result->message = '验证码不正确';
            return $m3_result->toJson();
        }
        //建议把字符串判断放在数据库判断前面进行判断 因为这样减少了访问数据库的次数

        //判断邮箱还是手机号
        if(strpos($username,'@') == true){
            $member =Member::where('email',$username)->first();
        }else{
            $member = Member::where('phone',$username)->first();
        }
        //判断账号是否存在
        if ($member == null )
        {
            $m3_result->status = 2;
            $m3_result->message = '该用户不存在';
            return $m3_result->toJson();
        }
        else{
            //如果存在判断密码是否正确
            if(md5('bk'+$password) != $member->password ){
                $m3_result->status = 3;
                $m3_result->message = '密码不正确';
                return $m3_result->toJson();
            }
        }

        //登录成功后将登录信息存放至session中
        $request->session()->put('member',$member);

        $m3_result->status = 0;
        $m3_result->message = '登录成功';
        return $m3_result->toJson();
    }
}
