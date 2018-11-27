<?php
/**
 * Created by PhpStorm.
 * User: zxf
 * Date: 2016/8/23
 * Time: 11:35
 */

$router->group(['prefix' => 'ad'], function($router){
    $router->get('index','AdController@index');
    $router->any('ajaxData','AdController@ajaxData');
    $router->any('test','AdController@test');
});
