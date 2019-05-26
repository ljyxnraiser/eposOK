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
    //get post
Route::get('/', function () {
    return view('welcome');
});
             //地址，//控制器controller 控制器名称@方法
Route::get('/user','userController@User');//测试

Route::any('/geturl','userController@uniqIDfunction');//测试
Route::any('/clientlogon','clientController@SignUp');//注册
Route ::any('/login','clientController@SignIn');//登录
//验证用户
Route:: any('/vif','clientController@VerifyClient');
//登出
Route:: any('/loginout','clientController@SignOut');
Route:: any('/loadMenu','menuController@MenuSearch');//加载菜单
Route:: any('/chargeMoney','clientController@ChargeMoney');//充值

Route:: post('/buy','clientController@Buy');//购买
Route:: post('/insertdish2menu','clientController@Insert2MenuInfo');//插入菜品id到menu_info

Route:: post('/changepasswd','clientController@changePasswd');//修改密码