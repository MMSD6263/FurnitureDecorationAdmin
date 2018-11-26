<?php

namespace App\Repositories\admin;

use Illuminate\Support\Facades\Redis;
use App\Repositories\commonclass\whereserach;
use App\Models\Exchange;

/*
 * 文章
 */

class ExchangeRepository
{
    private $_model;

    public function __construct()
    {
        $this->_model = new Exchange();
    }

    public function ajaxData($request)
    {
        $limit  = $request['limit'];
        $offset = $request['offset'];

        if (!empty($request['exchange_username'])) {
            $this->_model = whereserach::whereNames($this->_model, 'exchange_username', $request['exchange_username'], true);
        }

        $count = $this->_model->count();
        $list  = $this->_model
            ->offset($offset)
            ->limit($limit)
            ->get();


        $result = [
            'rows' => $list,
            'total' => $count,
        ];

        return json_encode($result);
    }

    /**
     * 添加文章列表
     * @param $request
     */
    public function saveData($request)
    {
        $saveData = [];
        $saveData['http_address'] = $request['http_address'];
        $saveData['exchange_username'] = $request['exchange_username'];
        $saveData['status'] = $request['status'];
        $saveData['note'] = $request['note'];
        if(!empty($request['jid'])){
            if($this->_model->where(['jid'=>$request['jid']])->update($saveData)){
                return message(true,'修改成功！');
            }else{
                return message(false,'修改失败！');
            }
        }else{
            if($this->_model->insertGetId($saveData)){
                return message(true,'添加成功！');
            }else{
                return message(false,'添加失败！');
            }
        }
    }

    public function deleteData($request)
    {
        if(!$request['jid']){
            return message(false,'id不存在，数据不完整！');
        }else{
            if($this->_model->where(['jid'=>$request['jid']])->delete()){
                return message(true,'删除成功！');
            }else{
                return message(false,'删除失败！');
            }
        }
    }

    public function exchangeInfo($request)
    {
        if(!$request['jid']){
            return message(false,'id不存在，数据不完整！');
        }else{
            $info = $this->_model->where(['jid'=>$request['jid']])->first();
            return message(true,$info);
        }
    }

    public function getList()
    {
        $list = $this->_model->where(['status'=>1])->get();
        return $list;
    }
}
