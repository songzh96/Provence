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
    return view('master');
});


//建议尽量不要在路由中写function，一定要将function放到Controller里，因为这样可以方便项目的管理
Route::get('/login/', 'View\MemberController@toLogin');
Route::get('/register/', 'View\MemberController@toRegister');

Route::get('/category/','View\BookController@toCategory');
Route::get('/product/category_id/{category_id}','View\BookController@toProduct');
Route::get('/product/{product_id}','View\BookController@toProcontent');

Route::get('/cart','View\CartController@toCart');

//路由分组-url前缀
//路由分组是为了便于后期管理
Route::group(['prefix' => 'service'], function () {
    Route::get('validatecode/', 'Service\ValidateCodeController@create');
    Route::post('validate_phone/send', 'Service\ValidateCodeController@sendSMS');
    Route::post('validate_email', 'Service\ValidateCodeController@validateEmail');

    Route::post('register', 'Service\MemberController@register');
    Route::post('login', 'Service\MemberController@login');

    //{}由于ajax要传入一个parent_id,所以这里就可以用一个括号来表示后面传的参数。 这个参数是控制器中获取的参数
    Route::get('category/parent_id/{parent_id}', 'Service\BookController@getCategoryByParentId');
    Route::get('cart/add/{product_id}', 'Service\CartController@addCart');
    Route::get('cart/delete', 'Service\CartController@deleteCart');

    Route::post('alipay', 'Service\PayController@alipay');
    Route::post('notify', 'Service\PayController@notify');

    Route::post('upload/{type}', 'Service\UploadController@uploadFile');
});

Route::group(['middleware' => 'check.login'], function () {//中间件路由组 中间件==拦截器（java）
    Route::post('/order_commit','View\OrderController@toOrderCommit');
    Route::get('/order_list/','View\OrderController@toOrderList');
});


/***********************************后台相关***********************************/
Route::group(['prefix' => 'admin'], function () {

    Route::post('login', 'Admin\IndexController@login');
    Route::get('exit', 'Admin\IndexController@toExit');

   // Route::group(['middleware' => 'check.admin.login'], function () {
        Route::group(['prefix' => 'service'], function () {
            Route::post('category/add', 'Admin\CategoryController@CategoryAdd');
            Route::post('category/del', 'Admin\CategoryController@CategoryDelete');
            Route::post('category/edit', 'Admin\CategoryController@CategoryEdit');

            Route::post('product/add', 'Admin\ProductController@productAdd');
            Route::post('product/del', 'Admin\ProductController@productDel');
            Route::post('product/edit', 'Admin\ProductController@productEdit');

            Route::post('member/edit', 'Admin\MemberController@memberEdit');
            Route::post('member/del', 'Admin\MemberController@memberDel');

            Route::post('order/edit', 'Admin\OrderController@orderEdit');
        });
   // });

    Route::get('/login','Admin\IndexController@toLogin');

    Route::get('/index','Admin\IndexController@toIndex');

    Route::get('/category_add','Admin\CategoryController@toCategoryAdd');
    Route::get('/category_edit','Admin\CategoryController@toCategoryEdit');
    Route::get('/category','Admin\CategoryController@toCategory');

    Route::get('product', 'Admin\ProductController@toProduct');
    Route::get('product_info', 'Admin\ProductController@toProductInfo');
    Route::get('product_add', 'Admin\ProductController@toProductAdd');
    Route::get('product_edit', 'Admin\ProductController@toProductEdit');

    Route::get('member', 'Admin\MemberController@toMember');
    Route::get('member_edit', 'Admin\MemberController@toMemberEdit');

    Route::get('order', 'Admin\OrderController@toOrder');
    Route::get('order_edit', 'Admin\OrderController@toOrderEdit');
});