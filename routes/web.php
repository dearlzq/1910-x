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
//测试

Route::get('/user/reg','User\IndexController@reg');     //用户注册
Route::post('/user/reg','User\IndexController@regDo');  //执行注册
Route::get('/user/login','User\IndexController@login');             //用户登录
Route::post('/user/login','User\IndexController@loginDo');          //执行登录
Route::get('/user/centers','User\IndexController@centers');           //个人中心



















//Api
Route::post('/api/user/reg','Api\UserController@reg');          //执行注册
Route::post('/api/user/login','Api\UserController@login');      //执行注册
Route::get('/api/user/center','Api\UserController@center')->middleware('check.pri');  //执行注册
Route::get('/api/my/orders','Api\UserController@orders')->middleware('check.pri');    //我的订单
Route::get('/api/my/carts','Api\UserController@carts')->middleware('check.pri');      //购物车

Route::get('/api/a','Api\TextController@a')->middleware('check.pri','access.filter');
Route::get('/api/b','Api\TextController@b')->middleware('check.pri','access.filter');
Route::get('/api/c','Api\TextController@c')->middleware('check.pri','access.filter');
//路由分组
Route::middleware('check.pri','access.filter')->group(function(){
    Route::get('/api/x','Api\TestController@x');
    Route::get('/api/y','Api\TestController@y');
    Route::get('/api/z','Api\TestController@z');
});



