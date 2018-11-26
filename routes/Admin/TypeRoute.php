<?php
/**
 * Created by PhpStorm.
 * User: zxf
 * Date: 2016/8/23
 * Time: 11:35
 */

$router->group(['prefix' => 'type'], function ($router) {
    $router->any('index', 'TypeController@index');//首页
    $router->any('ajaxData','TypeController@AjaxData');//加载文章分类数据
    $router->post('saveData','TypeController@saveData');//文章分类保存
    $router->any('deleteData','TypeController@deleteData');//删除文章分类的操作

});