<?php
/**
 * Created by PhpStorm.
 * User: Miracle
 * Date: 2017/4/17
 * Time: 20:07
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;


class IndexController extends Controller
{

    public function login($value='')
    {
        return redirect('/admin/index');
    }

    public function toLogin($value= '')
    {
        return view('admin.login');
    }
    public function toIndex($value='')
    {
        return view('admin.index');
    }

}
