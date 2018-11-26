<?php

namespace App\Repositories\admin;

use App\Models\Admin;
use App\Models\Operation;

/*
 * 取出运营总表的数据
 */

class IndexRepository
{
    public static function index()
    {
        //获取用户详情
        $user = 0;
        $userInfo = getUserInfo();
        //在线机器人数目
        $taskCount = 1;
        //在线策略数目
        $strategy = 2;
        //在线服务器数目
        $server = 3;
        if (super_authority()) {
            //获取当前的用户数据
            $user = Admin::where(['status' =>1])->count();
        }
        $user = 3;
        return [
            'taskCount' => $taskCount,
            'strategy'  => $strategy,
            'server'=>$server,
            'user'=>$user
        ];
    }

    public function getData()
    {
        $operate = new Operation();
        $res  = $operate->orderBy('id','desc')->get();
        $data = [];
        if(!empty($res)) {
            $res = $res->toArray();
            foreach ($res as $key => $value) {
                $data['new_user'][$key] = $value['new_user'];
                $data['keep_user'][$key] = $value['keep_user'];
                $data['active_user'][$key] = $value['active_user'];
                $data['call_user'][$key] = $value['call_user'];
                $data['datetimeArr'][$key] = date('Y-m-d', $value['time']);
            }
        }
        $start = mktime(0,0,0,date('m'),date('d'),date('Y'))-1;
        $end   =  mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
        $condition[] = array('time','>',$start);
        $condition[] = array('time','<',$end);
        $count  = $operate->where($condition)->first();
        if(!empty($count)){
            $count = $count->toArray();
        }else{
            $count['new_user'] = 100;
            $count['keep_user'] = 100;
            $count['active_user'] = 100;
            $count['call_user'] = 100;
        }
        return json_encode(['count'=>$count,'data'=>$data]);
    }
}