<?php
/**
 * Created by PhpStorm.
 * User: Miracle
 * Date: 2017/4/12
 * Time: 19:16
 */

namespace App\Http\Middleware;

use Closure;

class CheckLogin
{
    /**
     * 返回请求过滤器
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    //写好中间件后在路由中注册 Kernel.php $routeMiddleware
    public function handle($request, Closure $next)
    {
        //获取上一次访问的地址 PHP内置方法

            $member = $request->session()->get('member','');//从session中获取信息
            if($member == ''){//如果没有重定向到登录
                $return_url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
                return redirect('/login?return_url='. urlencode($return_url));
            }

        return $next($request);
    }

}