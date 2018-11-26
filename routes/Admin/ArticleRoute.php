<?php
/**
 * Created by PhpStorm.
 * User: zxf
 * Date: 2016/8/23
 * Time: 11:35
 */

$router->group(['prefix' => 'article'], function ($router) {
    $router->any('index', 'ArticleController@index');//首页
    $router->any('ajaxData','ArticleController@ajaxData');//加载文章分类数据
    $router->any('deleteArticle','ArticleController@deleteData');//加载文章分类数据
    $router->any('editData','ArticleController@editData');//加载文章分类数据
    $router->any('changeStatus','ArticleController@changeStatus');//加载文章分类数据
    $router->any('catch','ArticleController@fetch');//加载文章分类数据
    $router->any('downLoadData','ArticleController@downLoadData');//加载文章分类数据
    $router->any('uploadImage','ArticleController@uploadImage');
    $router->any('saveArticle','ArticleController@saveArticle');
    $router->any('auditing','ArticleController@auditing');
    $router->any('auditingData','ArticleController@auditingData');
    $router->any('getRelatedType','ArticleController@getRelatedType');
    $router->any('saveRedis','ArticleController@saveRedis');
    $router->get('rsync','ArticleController@rsync');
});