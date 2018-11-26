<?php
/**
 * Created by PhpStorm.
 * User: zxf
 * Date: 2016/8/23
 * Time: 11:35
 */

$router->group(['prefix' => 'source'], function ($router) {
    $router->any('index', 'SourceController@index');//首页
    $router->any('ajaxData','SourceController@AjaxData');//加载文章分类数据

});