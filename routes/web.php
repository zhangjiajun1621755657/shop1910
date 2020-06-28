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
Route::get('/test/hello',"TestController@hello");
Route::get('/test/redis1',"TestController@redis1");
Route::get('/test1',"TestController@test1");


Route::get('/goods/detail',"Goods\GoodsController@detail");//商品详情


Route::get('/user/reg',"user\IndexController@reg");//前台注册
Route::post('/user/regDo',"user\IndexController@regDo");//前台注册
Route::get('/user/login',"user\IndexController@login");//前台用户登录
Route::post('/user/login',"user\IndexController@loginDo");//前台用户登录
Route::get('/user/center',"user\IndexController@center");//用户中心


//API
Route::post('/api/user/reg',"Api\UserController@reg");//注册
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