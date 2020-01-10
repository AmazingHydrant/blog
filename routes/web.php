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

//無權限頁面
Route::get('noAccess', 'Admin\PermissionController@noAccess');
//權限重寫入session
Route::get('rePerm', 'Admin\PermissionController@rePerm');

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['isLogin']], function () {
    //登出後臺
    Route::get('logout', 'LoginController@logout');
});
Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['hasPerm', 'isLogin']], function () {
    //後臺首頁
    Route::get('index', 'LoginController@index');
    //後臺歡迎頁面
    Route::get('welcome', 'LoginController@welcome');
    //統計頁面
    Route::get('welcome1', 'LoginController@welcome1');
    //登出後臺
    Route::resource('user', 'UserController');
    //用戶批量刪除
    Route::post('user/del', 'UserController@delAll');
    //角色相關
    Route::resource('role', 'RoleController');
    //角色權限頁面
    Route::get('role/auth/{id}', 'RoleController@auth');
    //執行角色權限修改
    Route::post('role/doauth', 'RoleController@doauth');
    //權限相關
    Route::resource('permission', 'PermissionController');
    //文章相關
    Route::resource('cate', 'CateController');
});
