<?php

namespace App\Repositories\admin;

use App\Models\Type;
use App\Models\Article;
use Illuminate\Support\Facades\Redis;
use App\Repositories\commonclass\whereserach;
use Illuminate\Support\Facades\DB;

/*
 * 文章
 */

class TypeRepository
{
    private $_type;
    private $_article;

    public function __construct()
    {
        $this->_type    = new Type();
        $this->_article = new Article();
    }

    /**
     * 获取数据列表
     * @param $request
     * @return array
     */
    public function ajaxData($request)
    {
       if(isset($request['typeName']) && $request['typeName']!= ''){
           $this->_type = whereserach::whereName($this->_type,'artTypeName',$request['typeName']);
       }
        $limit  = $request['limit'];
        $offset = $request['offset'];
        $count  = $this->_type->count();
        $list   = $this->_type
            ->orderBy('create_at','desc')
            ->offset($offset)
            ->limit($limit)
            ->get()
            ->toArray();
        $result = [
            'rows'  => $list,
            'total' => $count,
        ];
        return $result;
    }

    /**
     * @param $data
     * @return string
     * 保存数据
     */
    public function saveData($data)
    {
        $list = $this->_type->where(['artTypeName'=> trim($data['artTypeName'])])->first();
        if(empty($list)){
            $saveData = [];
            $saveData['artType'] = $data['artType'];
            $saveData['artTypeName'] = $data['artTypeName'];
            if(!empty($data['artTypeId'])){
                if($this->_type->where(['artTypeId'=>$data['artTypeId']])->update($saveData)){
                    return message(true,'修改成功');
                }else{
                    return message(false,'修改失败');
                }
            }else{
                if($insertId = $this->_type->insertGetId($saveData)){
                    return message(true,'添加成功');
                }else{
                    return message(false,'添加失败');
                }
            }
        }else{
            return message(false,'该栏目已添加，请勿重复！');
        }

    }

    /**
     * @param $data
     * @return string
     * 删除数据
     */
    public function deleteData($data)
    {
        if($this->hasArticle($data['artTypeId'])){
            return message(10001,'该栏目下有文章或视频，无法删除');
        }else{
            if($this->_type->where(['artTypeId'=>$data['artTypeId']])->delete()){
                return message(10000,'删除成功！');
            }else{
                return message(10002,'删除失败！');
            }
        }
    }

    /**
     * @param $typeId
     * @return bool
     * 判断是否有文章
     */
    private function hasArticle($typeId)
    {
        $count = $this->_article->where(['artTypeId'=>$typeId])->count();
        if($count > 0){
            return true;
        } else {
            return false;
        }
    }
}
