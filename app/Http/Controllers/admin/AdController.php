<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\admin\AdRepository;

class AdController extends Controller
{
    private $_ad;

    public function __construct()
    {
        $this->_ad = new AdRepository();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 用户首页
     */
    public function index()
    {
        return view('admin.ad.index');
    }


    /**
     * @param Request $request
     * @return array
     * 用户列表
     */
    public function ajaxData(Request $request)
    {
        $data   = $request->except(['_token']);
        $result = $this->_ad->ajaxData($data);
        return $result;
    }

    /**
     * 更改用户状态
     */
    public function changeStatus(Request $request)
    {
        $data   = $request->except(['_token']);
        $result = $this->_ad->changeStatus($data);
        return $result;
    }


    /**
     * 更改用户沟通状态
     */
    public function beCalled(Request $request)
    {
        $data   = $request->except(['_token']);
        $result = $this->_ad->beCalled($data);
        return $result;
    }

}
