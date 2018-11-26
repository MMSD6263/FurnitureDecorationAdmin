<?php
/**
 * Created by PhpStorm.
 * User: zxf
 * Date: 2016/8/23
 * Time: 11:35
 */

$router->group(['prefix' => 'user'], function ($router) {
    $router->any('index', 'UserController@index');//首页
    $router->any('ajaxData','UserController@AjaxData');//加载用户数据
    $router->any('changeStatus','UserController@changeStatus');//更改状态
    $router->any('beCalled','UserController@beCalled');//更改沟通状态

});