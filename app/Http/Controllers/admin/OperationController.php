<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\admin\OperationRepository;

class OperationController extends Controller
{
    private $_operation;

    public function __construct()
    {
        $this->_operation = new OperationRepository();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 文章审核列表
     */
    public function index()
    {
        return view('admin.operation.index');
    }


    /**
     * @param Request $request
     * @return array
     * 文章审核列表
     */
    public function ajaxData(Request $request)
    {
        $data   = $request->except(['_token']);
        $result = $this->_operation->ajaxAuditorData($data);
        return $result;
    }

}
