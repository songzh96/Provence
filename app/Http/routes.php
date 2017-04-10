<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
use App\Entity\Member;

Route::get('/', function () {
    return view('login');
});


//建议尽量不要在路由中写function，一定要将function放到Controller里，因为这样可以方便项目的管理
Route::any('login/', 'View\MemberController@toLogin');
Route::any('register/', 'View\MemberController@toRegister');

Route::get('category/','View\BookController@toCategory');
Route::get('product/category_id/{category_id}','View\BookController@toProduct');

//路由分组-url前缀
//路由分组是为了便于后期管理
Route::group(['prefix' => 'service'], function () {
/*    Route::get('users', function ()    {
        // 匹配 "/admin/users" URL
    });*/
    Route::get('validatecode/', 'Service\ValidateCodeController@create');
    Route::post('validate_phone/send', 'Service\ValidateCodeController@sendSMS');
    Route::post('register', 'Service\MemberController@register');
    Route::post('login', 'Service\MemberController@login');
    Route::post('validate_email', 'Service\ValidateCodeController@validateEmail');
    //{}由于ajax要传入一个parent_id,所以这里就可以用一个括号来表示后面传的参数。 这个参数是控制器中获取的参数
    Route::get('category/parent_id/{parent_id}', 'Service\BookController@getCategoryByParentId');
});