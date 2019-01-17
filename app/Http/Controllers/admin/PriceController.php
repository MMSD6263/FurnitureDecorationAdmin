<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\admin\PriceRepository;

class PriceController extends Controller
{
    private $_price;

    public function __construct()
    {
        $this->_price = new PriceRepository();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 文章审核列表
     */
    public function index()
    {
        return view('admin.price.index');
    }


    /**
     * @param Request $request
     * @return array
     * 文章审核列表
     */
    public function ajaxData(Request $request)
    {
        $data   = $request->except(['_token']);
        $result = $this->_price->ajaxData($data);
        return $result;
    }

    public function deleteData(Request $request)
    {
        $data = $request->except(['_token']);
        $result = $this->_price->deleteData($data);
        return $result;
    }

    public function saveData(Request $request)
    {
        $data = $request->except(['_token']);
        $result = $this->_price->saveData($data);
        return $result;
    }

}
