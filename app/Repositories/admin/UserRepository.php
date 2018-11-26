<?php

namespace App\Repositories\admin;

use App\Models\User;
use App\Repositories\commonclass\whereserach;
use Illuminate\Support\Facades\DB;

/*
 * 文章
 */

class UserRepository
{
    private $_user;

    public function __construct()
    {
        $this->_user    = new User();
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
        if(isset($request['nickName'])){
            $this->_user = whereserach::whereName($this->_user,'nickName',trim($request['nickName']),true);
        }
        if(isset($request['mobile'])){
            $this->_user = whereserach::whereName($this->_user,'mobile',trim($request['mobile']),true);
        }
        $lists = $this->_user
            ->orderBy('create_at','desc')
            ->limit($limit)
            ->offset($offset)
            ->get();
        $count = $this->_user->count('uid');
        if(!empty($lists)){
            $lists = $lists->toArray();
            foreach($lists as &$value){
                $value['avatar'] = '<img style="width:40px;height:40px;" src="'.$value['avatar'].'">';
            }
        }else{
            $lists = [];
        }
        $result = [
            'rows'  => $lists,
            'total' => $count,
        ];
        return $result;
    }

    /**
     * @param $data
     * @return string
     * 更改用户状态
     */
    public function changeStatus($data)
    {
        if(!empty($data['uid'])){
            if($data['status'] == 1){
                $status = 2;
            }else if($data['status'] == 2){
                $status = 1;
            }
            if($this->_user->where(['uid'=>$data['uid']])->update(['status'=>$status])){
                return message(true,'修改成功');
            }else{
                return message(false,'修改失败！');
            }
        }
    }

    /**
     * @param $data
     * @return string
     * 更改用户沟通状态
     */
    public function beCalled($data)
    {
        if(!empty($data['uid'])){
            $beCalled = 2;
            if($this->_user->where(['uid'=>$data['uid']])->update(['beCalled'=>$beCalled])){
                return message(true,'修改成功');
            }else{
                return message(false,'修改失败！');
            }
        }
    }

}
