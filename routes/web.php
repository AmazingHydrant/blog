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

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
/**for test
//用戶添加路由
Route::get('user/add', 'UserController@add');

//執行用戶添加路由
Route::post('user/store', 'UserController@store');

//用戶列表頁面
Route::get('user/index', 'UserController@index');

//用戶修改頁面
Route::get('user/edit/{id}', 'UserController@edit');

//執行用戶修改
Route::post('user/update', 'UserController@update');

//執行用戶刪除
Route::any('user/del/{id}', 'UserController@del');
 ***/

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
    //後臺登錄首頁
    Route::get('login', 'LoginController@login');
    //處理後臺登錄操作
    Route::post('dologin', 'LoginController@dologin');
});

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'isLogin'], function () {
    //後臺首頁
    Route::get('index', 'LoginController@index');
    //後臺歡迎頁面
    Route::get('welcome', 'LoginController@welcome');
    //統計頁面
    Route::get('welcome1', 'LoginController@welcome1');
    //登出後臺
    Route::get('logout', 'LoginController@logout');
    //後臺用戶相關
    Route::resource('user', 'UserController');
    //用戶批量刪除
    Route::post('user/del', 'UserController@delAll');
});
