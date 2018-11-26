<?php
/**
 * Created by PhpStorm.
 * User: zxf
 * Date: 2016/8/23
 * Time: 11:35
 */

$router->group(['prefix' => 'video'], function ($router) {
    $router->any('index', 'VideoController@index');//首页
    $router->any('ajaxVideoData','VideoController@ajaxVideoData');//加载文章分类数据
    $router->any('changeStatus','VideoController@changeStatus');//加载文章分类数据
    $router->any('editData','VideoController@editData');
    $router->any('catch','VideoController@videoCatch');
});