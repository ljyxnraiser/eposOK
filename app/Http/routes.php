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
Route::get('/user','userController@User');

Route::post('/geturl','userController@GetUrl');
Route::any('/clientlogon','clientController@postRegister');