<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['namespace' => 'api', 'middleware' => ['api']], function ($router) {
    $router->get('wxLogin', 'IndexController@wxLogin');
    $router->get('imageList', 'ImageController@imageList');
    $router->post('stylePrice','IndexController@stylePrice');
    $router->post('test','IndexController@test');
});