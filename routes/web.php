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
//数据管理
Route::get('/', 'admin\\LoginController@login');
Route::get('login', 'admin\\LoginController@login');
Route::any('/test', 'admin\\IndexController@test');
Route::any('/i', 'admin\\LoginController@i');     //单用户登录

//后台管理系统
Route::group(['prefix' => 'admin', 'namespace' => 'admin', 'middleware' => ['web', 'admin.login', 'sso']], function ($router) {
    $router->any('index', 'IndexController@index');
    $router->any('/', 'LoginController@index');
    $router->any('login', 'LoginController@login');
    $router->any('index_v1', 'IndexController@index_v1');
    $router->any('ajaxData', 'IndexController@ajaxData');
    $router->any('tableData', 'IndexController@tableData');

    require(__DIR__ . '/Admin/PowersRoute.php');
    require(__DIR__ . '/Admin/RoleRoute.php');
    require(__DIR__ . '/Admin/AdminRoute.php');                     //后台用户
    require(__DIR__ . '/Admin/AdRoute.php');//用户信息
    require(__DIR__ . '/Admin/OperationRoute.php');//系统目录
    require(__DIR__ . '/Admin/UserRoute.php');//系统目录
    require(__DIR__ . '/Admin/ImageRoute.php');//图例列表
    require(__DIR__ . '/Admin/PriceRoute.php');//报价列表


});
//登录页面
Route::group(['middleware' => ['web', 'admin.login']], function ($router) {
    $router->any('admin/login/index', 'admin\\LoginController@index');
    $router->any('admin/login', 'admin\\LoginController@login');
    $router->get('admin/logout', 'admin\\LoginController@logout');
});
