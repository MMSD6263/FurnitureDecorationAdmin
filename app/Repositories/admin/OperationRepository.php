<?php

namespace App\Repositories\admin;

use App\Models\Operation;
use App\Repositories\commonclass\whereserach;
use Illuminate\Support\Facades\DB;

/*
 * 文章
 */

class OperationRepository
{
    private $_operation;

    public function __construct()
    {
        $this->_operation = new Operation();
    }


    /**
     * 获取数据列表
     * @param $request
     * @return array
     */
    public function ajaxAuditorData($request)
    {
        $limit  = $request['limit'];
        $offset = $request['offset'];

        if(isset($request['sort'])){
            $sort = $request['sort'];
        }else{
            $sort = 'time';
        }

        if(isset($request['order'])){
            $order = $request['order'];
        }else{
            $order = 'desc';
        }

        if (!empty($request['start']) || !empty($request['end'])) {
            if(!empty($request)){
                $start = strtotime($request['start']);
            }
            if(!empty($request['end'])){
                $end   = strtotime($request['end']);
            }
            $this->_operation = whereserach::wheredate($this->_operation, 'time', $start, $end);
        }

        $lists = $this->_operation
            ->orderBy($sort,$order)
            ->offset($offset)
            ->limit($limit)
            ->get();

        $count = $this->_operation->count('id');
        $sum_new_user = $this->_operation->sum('new_user');
        $sum_active_user = $this->_operation->sum('active_user');
        $sum_keep_user = $this->_operation->sum('keep_user');
        $sum_call_user = $this->_operation->sum('call_user');
        if(!empty($lists)){
            $lists = $lists->toArray();
            foreach($lists as &$value){
                $value['sum_new_user']    = $sum_new_user;
                $value['sum_active_user'] = $sum_active_user;
                $value['sum_keep_user']   = $sum_keep_user;
                $value['sum_call_user']   = $sum_call_user;
                $value['time'] = date('Y-m-d H:i:s',$value['time']);
            }
            $result = [
                'rows'  => $lists,
                'total' => $count,
            ];
            return $result;
        }

    }


}
