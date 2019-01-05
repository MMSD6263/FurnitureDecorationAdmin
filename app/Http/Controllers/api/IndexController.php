<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;

/**
 * 模板消息
 * 发送模板消息
 * Class TemplateController
 * @package App\Http\Controllers\api
 */
class IndexController extends Controller
{
    public function wxLogin()
    {
        return message(true,'this is a test');
    }
}