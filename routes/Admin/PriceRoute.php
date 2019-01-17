<?php
/**
 * Created by PhpStorm.
 * User: zxf
 * Date: 2016/8/23
 * Time: 11:35
 */

$router->group(['prefix' => 'price'], function($router){
    $router->get('index','PriceController@index');
    $router->any('ajaxData','PriceController@ajaxData');
    $router->any('deleteData','PriceController@deleteData');
    $router->any('saveData','PriceController@saveData');
});
