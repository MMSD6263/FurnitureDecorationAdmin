<?php
/**
 * Created by PhpStorm.
 * User: zxf
 * Date: 2016/8/23
 * Time: 11:35
 */

$router->group(['prefix' => 'template'], function ($router) {
    $router->any('index', 'TemplateController@index');//日志模板首页
    $router->any('ajaxData', 'TemplateController@ajaxData');//日志模板列表
    $router->any('addTemplate', 'TemplateController@addTemplate');//添加模板页面
    $router->any('saveData', 'TemplateController@saveData');//保存模板
    $router->any('deleteData', 'TemplateController@deleteData');//删除模板
    $router->any('editData', 'TemplateController@editData');//编辑模板
});