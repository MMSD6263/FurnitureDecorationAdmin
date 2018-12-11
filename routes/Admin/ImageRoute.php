<?php
/**
 * Created by PhpStorm.
 * User: zxf
 * Date: 2016/8/23
 * Time: 11:35
 */

$router->group(['prefix' => 'image'], function($router){
    $router->get('index','ImageController@index');
    $router->get('add','ImageController@add');
    $router->any('ajaxData','ImageController@ajaxData');
    $router->any('saveData','ImageController@saveData');
    $router->any('deleteData','ImageController@deleteData');
    $router->any('uploadImage','ImageController@uploadImage');
    $router->any('dataInfo','ImageController@dataInfo');
    $router->any('test','ImageController@test');
});