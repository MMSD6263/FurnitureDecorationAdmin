<?php
/**
 * Created by PhpStorm.
 * User: zxf
 * Date: 2016/8/23
 * Time: 11:35
 */

$router->group(['prefix' => 'admin'], function($router){
    $router->get('index','AdminController@index');
    $router->any('ajaxData','AdminController@ajaxData');
    $router->any('adminAdd','AdminController@adminAdd');
    $router->any('adminEdit','AdminController@adminEdit');
    $router->any('adminDelete','AdminController@adminDelete');
    $router->any('userInfo','AdminController@userInfo');
    $router->any('edit','AdminController@edit');
    $router->any('userCenter','AdminController@userCenter');        //用户中心
    $router->any('uploadImg','AdminController@uploadImg');          //用户上传头像
    $router->any('changePwd','AdminController@changePwd');           //用户修改密码
    $router->any('changeFrameColor','AdminController@changeFrameColor');           //修改框架背景颜色
});
