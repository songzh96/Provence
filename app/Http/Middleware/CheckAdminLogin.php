<?php
/**
 * Created by PhpStorm.
 * User: Miracle
 * Date: 2017/4/18
 * Time: 20:55
 */
namespace App\Http\Middleware;

use Closure;

class CheckAdminLogin
{
    /**
     * Run the request filter.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $admin = $request->session()->get('admin', '');
        if($admin == '') {
            return redirect('/admin/login');
        }

        return $next($request);
    }

}