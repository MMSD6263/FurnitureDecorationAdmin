<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\api\IndexRepository;

/**
 * Class IndexController
 * @package App\Http\Controllers\api
 * 用户相关
 */

class IndexController extends Controller
{
    private $_repository;
    public function __construct()
    {
        $this->_repository = new IndexRepository();
    }

    /**
     * @param Request $request
     * @return string
     * 用户登录获取openid
     */
    public function wxLogin(Request $request)
    {
        if(empty($request['code'])){
            return message(false,'参数code不能为空');
        }else{
            $res =  $this->_repository->wxLogin($request);
            return $res;
        }
    }

    public function stylePrice(Request $request)
    {
        return $request;
    }


}