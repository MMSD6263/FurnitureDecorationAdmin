<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['namespace' => 'api', 'middleware' => ['api']], function ($router) {
    $router->get('test',function(){
        echo 1111111111222222;
    });
//    $router->get('wxLogin', 'ApiTemplateController@wxLogin');
//    $router->get('tasks', 'ApiTemplateController@tasks');
//    $router->any('detail', 'ApiTemplateController@detail');
//    $router->any('getLogData', 'ApiTemplateController@getLogData');
//    $router->get('profit', 'ApiTemplateController@profit');
//    $router->get('setting', 'ApiTemplateController@setting');
//    $router->get('operateTask', 'ApiTemplateController@operateTask');
//    $router->get('userInfo', 'ApiTemplateController@userInfo');
//    $router->any('saveMobile','ApiTemplateController@saveMobile');
//    $router->any('login',function(){
//        return view('api.login');
//    });
//
//    //微信通知信息
//    $router->any('message', 'WechatApiController@message');
});