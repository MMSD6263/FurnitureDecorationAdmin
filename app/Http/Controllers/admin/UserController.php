<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\admin\UserRepository;

class UserController extends Controller
{
    private $_user;

    public function __construct()
    {
        $this->_user = new UserRepository();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 用户首页
     */
    public function index()
    {
        return view('admin.user.index');
    }


    /**
     * @param Request $request
     * @return array
     * 用户列表
     */
    public function ajaxData(Request $request)
    {
        $data   = $request->except(['_token']);
        $result = $this->_user->ajaxData($data);
        return $result;
    }

    /**
     * 更改用户状态
     */
    public function changeStatus(Request $request)
    {
        $data   = $request->except(['_token']);
        $result = $this->_user->changeStatus($data);
        return $result;
    }


    /**
     * 更改用户沟通状态
     */
    public function beCalled(Request $request)
    {
        $data   = $request->except(['_token']);
        $result = $this->_user->beCalled($data);
        return $result;
    }

}
