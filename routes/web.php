<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

/**
 *
 */
Route::prefix('/test')->group(function(){
    Route::get('/hello',"TestController@hello");
    Route::get('/redis1',"TestController@redis1");
    Route::get('/test1',"TestController@test1");
    Route::get('/sign1',"TestController@sign1");
    Route::get('/www',"TestController@www");
    Route::get('/send-data',"TestController@sendData");
    Route::get('/postData',"TestController@postData");
    Route::get('/encrypt1',"TestController@encrypt1"); //对称加密
    Route::get('/rsa/encrypt1',"TestController@rsaEncrypt1"); //非对称加密

    Route::get('/rsa/send-b',"TestController@sendB"); //非对称加密
    Route::get('/rsaSign1/',"TestController@rsaSign1"); //非对称加密
    Route::get('/encrypt',"TestController@encrypt"); //对称加密
    Route::get('/yanqian1',"TestController@yanqian1"); //对称加密
    Route::get('/yanqian2',"TestController@yanqian2"); //对称加密
});


Route::get('/secret',"TestController@secret");


Route::get('/goods/detail',"Goods\GoodsController@detail");//商品详情


Route::get('/user/reg',"user\IndexController@reg");//前台注册
Route::post('/user/regDo',"user\IndexController@regDo");//前台注册
Route::get('/user/login',"user\IndexController@login");//前台用户登录
Route::post('/user/login',"user\IndexController@loginDo");//前台用户登录
Route::get('/user/center',"user\IndexController@center");//用户中心


//API
Route::get('/api/user/reg1',"Api\UserController@reg1");//注册
Route::get('/api/user/reg',"Api\UserController@reg");//注册
Route::post('/api/user/login',"Api\UserController@login");//登录
Route::get('/api/user/center',"Api\UserController@center")->middleware('check.pri');//个人中心
Route::get('/api/my/orders',"Api\UserController@orders")->middleware('check.pri');//我的订单
Route::get('/api/my/cart',"Api\UserController@cart")->middleware('check.pri');//我的购物车



//中间件防刷路由组
Route::middleware('check.pri','zjj.fs')->group(function(){
    Route::get('/api/a',"Api\TestController@a");
    Route::get('/api/b',"Api\TestController@b");
    Route::get('/api/c',"Api\TestController@c");
});



Route::get('/cs/zc',"Cs\UserController@zc");  //前台注册
Route::post('/cs/zc2',"Cs\UserController@zc2");  //前台注册
Route::get('/cs/login',"Cs\UserController@login");  //前台登录
Route::post('/cs/loginDo',"Cs\UserController@loginDo");  //前台登录逻辑
Route::post('/cs/centent',"Cs\UserController@centent");  //前台登录逻辑

Route::get('/login',"\YuekaoController@login");  //前台登录