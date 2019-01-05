<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\api\IndexRepository;

/**
 * 模板消息
 * 发送模板消息
 * Class TemplateController
 * @package App\Http\Controllers\api
 */
class IndexController extends Controller
{
    private $_repository;
    public function __construct()
    {
        $this->_repository = new IndexRepository();
    }
    public function wxLogin(Request $request)
    {
        if(empty($request['code'])){
            return message(false,'参数code不能为空');
        }else{
            $res =  $this->_repository->wxLogin($request);
            return $res;
        }
    }
}