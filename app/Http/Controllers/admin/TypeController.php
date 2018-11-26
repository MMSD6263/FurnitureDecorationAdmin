<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\admin\TypeRepository;

class TypeController extends Controller
{
    private $_type;

    public function __construct()
    {
        $this->_type = new TypeRepository();
    }


    public function index()
    {
        return view('admin.type.index');
    }

    /**
     * 获取数据列表
     * @param Request $request
     * @return array
     */
    public function ajaxData(Request $request)
    {
        $data   = $request->except(['_token']);
        $result = $this->_type->ajaxData($data);
        return $result;
    }

    /**
     * @param Request $request
     * @return string
     * 保存数据
     */
    public function saveData(Request $request)
    {
        $data = $request->except(['_token']);
        $result = $this->_type->saveData($data);
        return $result;
    }

    /**
     * @param Request $request
     * @return string
     * 删除数据
     */
    public function deleteData(Request $request)
    {
        $data = $request->except(['_token']);
        $result = $this->_type->deleteData($data);
        return $result;
    }


}
