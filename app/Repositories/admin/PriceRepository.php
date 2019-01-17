<?php

namespace App\Repositories\admin;

use App\Models\Price;
use App\Repositories\commonclass\whereserach;
use Illuminate\Support\Facades\DB;

/*
 * 文章
 */

class PriceRepository
{
    private $_price;

    public function __construct()
    {
        $this->_price = new Price();
    }


    /**
     * 获取数据列表
     * @param $request
     * @return array
     */
    public function ajaxData($request)
    {
        $limit  = $request['limit'];
        $offset = $request['offset'];

        if(!empty($request['size'])){
            $this->_price = whereserach::whereid($this->_price,'size',$request['size']);
        }
        $count = $this->_price->count('id');
        $lists = $this->_price
            ->offset($offset)
            ->limit($limit)
            ->orderBy('updated_at','desc')
            ->get();
        if(!empty($lists)){
            $lists = $lists->toArray();
            $result = [
                'rows'  => $lists,
                'total' => $count,
            ];
            return $result;
        }
    }


    public function deleteData($request)
    {
        if(empty($request['id'])){
            return message(false,'id不能为空！');
        } else {
            if($this->_price->where(['id'=>$request['id']])->delete()){
                return message(true,'删除成功！');
            }else{
                return message(false,'删除失败！');
            }
        }
    }


    public function saveData($request)
    {
        $saveData = [];
        $saveData['size'] = $request['size'];
        $saveData['fee_human'] = $request['fee_human'];
        $saveData['fee_material'] = $request['fee_material'];
        $saveData['fee_check'] = $request['fee_check'];
        $saveData['fee_design'] = $request['fee_design'];
        $saveData['fee_others'] = $request['fee_others'];
        if(!empty($request['id'])){
            if($this->_price->where(['id'=>$request['id']])->update($saveData)){
                return message(true,'修改成功');
            }else{
                return message(false,'修改失败');
            }
        }else{
            if($this->_price->insertGetId($saveData)){
                return message(true,'添加成功');
            }else{
                return message(false,'添加失败');
            }
        }
    }


}
