<?php

namespace App\Repositories\admin;

use App\Models\Ad;
use App\Repositories\commonclass\whereserach;
use Illuminate\Support\Facades\DB;

/*
 * 文章
 */

class AdRepository
{
    private $_ad;

    public function __construct()
    {
        $this->_ad = new Ad();
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

        if (!empty($request['start']) || !empty($request['end'])) {
            if(!empty($request)){
                $start = strtotime($request['start']);
            }
            if(!empty($request['end'])){
                $end   = strtotime($request['end']);
            }
            $this->_ad = whereserach::wheredate($this->_ad, 'time', $start, $end);
        }
        $count = $this->_ad->count('id');
        $lists = $this->_ad
            ->offset($offset)
            ->limit($limit)
            ->get();
        if(!empty($lists)){
            $lists = $lists->toArray();
//            foreach($lists as &$value){
//                $value['sum_new_user']    = $sum_new_user;
//                $value['sum_active_user'] = $sum_active_user;
//                $value['sum_keep_user']   = $sum_keep_user;
//                $value['sum_call_user']   = $sum_call_user;
//                $value['time'] = date('Y-m-d H:i:s',$value['time']);
//            }
            $result = [
                'rows'  => $lists,
                'total' => $count,
            ];
            return $result;
        }

    }


}
