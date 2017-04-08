<?php

namespace App\Http\Controllers\Service;

use App\Entity\Member;
use App\Entity\TempEmail;
use App\Entity\TempPhone;
use App\Models\M3Result;
use App\Tool\Validate\ValidateCode;
use App\Http\Controllers\Controller;
use App\Tool\SMS\SendTemplateSMS;
use Illuminate\Http\Request;
class ValidateCodeController extends Controller
    {
        //图片验证码
       public function create(Request $request){
        $validateCode = new validateCode;
        $request->session()->put('validate_code', $validateCode->getCode());//将验证码保存到session中
         return $validateCode->doimg();
       }
        //手机验证码

    /**
     * @param Request $request
     * @return string
     */
    public function sendSMS(Request $request)
    {
        $m3_result = new M3Result();

        $phone = $request->input('phone','');//获取输入框的手机号
        $sendTemplateSMS = new SendTemplateSMS();
        //生成6位随机验证码
        $charset='1234567890';//数据源
        $code = '';//声明
        //生成随机码的算法逻辑
        $_len = strlen($charset) - 1;
        for ($i = 0;$i < 6;++$i) {
            $code .= $charset[mt_rand(0, $_len)];
        }
        //测试的时候需要自己注册账号，并且更改模板里的一些文件
        //参数说明  要发送的手机号 （验证码，验证码存在的事件） 短信模板 1为测试模板 手机验证码最好为6位数字
        $m3_result =$sendTemplateSMS->sendTemplateSMS( $phone,array($code,60),1);
        if ($m3_result->status == 0){
            //将数据保存到数据表中
            $tempPhone = TempPhone::where('phone_number',$phone)->first();
            if($tempPhone == null){ //判断手机号是否已被注册
                $tempPhone = new TempPhone();
            }

            $tempPhone->phone_number = $phone;
            $tempPhone->code = $code;
            $tempPhone->deadline =date('Y-m-d H-i-s',time()+60*60);
            $tempPhone->save();

        }
        return $m3_result->toJson();
    }

    //验证邮箱链接
    public function validateEmail(Request $request){
        //获取数据
        $member_id = $request->input('member_id','');
        $code = $request->input('code','');
        if ($member_id == '' || $code==''){
            return '验证异常';
        }
        $tempemail = TempEmail::where('member_id',$member_id)->first();
        if ($tempemail == null){
            return '验证异常';
        }
        if ($tempemail->code == $code){
            if(time() > strtotime($tempemail->deadline)){ //strtotime将时间字符串转换为时间戳
                return '该链接已失效';
            }
            $member = Member::find($member_id);
            $member->active =1;
            $member->save();
            return redirect('login');
        }
        else{
           return '该链接已失效';
        }
    }
}
