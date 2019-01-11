<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\api\ImageRepository;

/**
 * Class ImageController
 * @package App\Http\Controllers\api
 * 图片相关
 */
class ImageController extends Controller
{
    private $_repository;
    public function __construct()
    {
        $this->_repository = new ImageRepository();
    }


    public function imageList(Request $request)
    {
        $res = $this->_repository->imageList($request);
        return $res;
    }
}