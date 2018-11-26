<?php
/**
 * Created by PhpStorm.
 * User: zxf
 * Date: 2016/8/23
 * Time: 11:35
 */

$router->group(['prefix' => 'operation'], function($router){
    $router->get('index','OperationController@index');
    $router->any('ajaxData','OperationController@ajaxData');
});
