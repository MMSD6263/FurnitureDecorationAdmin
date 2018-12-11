<?php

namespace App\Repositories\admin;

use App\Models\Image;
use App\Models\Style;
use App\Models\Color;
use App\Models\Room;
use App\Models\Size;
use App\Repositories\commonclass\whereserach;
use Illuminate\Support\Facades\DB;

/*
 * 文章
 */

class ImageRepository
{
    private $_image;

    public function __construct()
    {
        $this->_image    = new Image();
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
        if(isset($request['type'])){
            $this->_image = whereserach::whereid($this->_image,'type',$request['type']);
        }
        if(isset($request['style'])){
            $this->_image = whereserach::whereid($this->_image,'style_id',$request['style']);
        }
        if(isset($request['color'])){
            $this->_image = whereserach::whereid($this->_image,'color_id',$request['color']);
        }
        if(isset($request['size'])){
            $this->_image = whereserach::whereid($this->_image,'size_id',$request['size']);
        }
        if(isset($request['room'])){
            $this->_image = whereserach::whereid($this->_image,'room_id',$request['room']);
        }


        $lists = $this->_image
            ->orderBy('create_at','desc')
            ->limit($limit)
            ->offset($offset)
            ->get();
        $count = $this->_image->count('id');
        if(!empty($lists)){
            $lists = $lists->toArray();
            foreach($lists as &$value){
                $pic = json_decode($value['picUrl'],true)[0];
                $value['small_pic'] = '47.93.245.51:8001'.$pic;
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

    public function saveData($data)
    {
        $saveData = [];
        $saveData['style_id'] = $data['style'];
        $saveData['color_id'] = $data['color'];
        $saveData['size_id'] = $data['size'];
        $saveData['room_id'] = $data['room'];
        $saveData['type'] = $data['type'];
        $saveData['style_name'] = $data['style_name'];
        $saveData['color_name'] = $data['color_name'];
        $saveData['size_name'] = $data['size_name'];
        $saveData['room_name'] = $data['room_name'];
        $picArr = explode('##',$data['picUrl']);
        array_pop($picArr);
        $saveData['picUrl'] = json_encode($picArr);
        if(!empty($data['id'])){
            $id = $data['id'];
            $res = $this->_image->where(['id'=>$id])->update($saveData);
            if($res){
                return message(true,'修改成功');
            }else{
                return message(false,'修改失败');
            }
        }else{
            $res = $this->_image->insertGetId($saveData);
            if($res){
                return message(true,'添加成功');
            }else{
                return message(false,'添加失败');
            }
        }

    }

    public function dataInfo($data)
    {
        $info = $this->_image->where(['id'=>$data['id']])->select(['id','picUrl'])->first()->toArray();
        $pics = json_decode($info['picUrl'],true);
        $dataArr = [];
        foreach($pics as $key=>$value){
            $arr = [];
            $arr['alt'] = '图片'.($key+1);
            $arr['pid'] = $key;
            $arr['src'] = $value;
            $arr['thumb'] = $value;
            array_push($dataArr,$arr);
        }
        $dataInfo = array(
            'title' => '图片',
            'id'    => $data['id'],
            'start' => 0,
            'data'  => $dataArr
        );
        return json_encode($dataInfo);
    }

    public function deleteData($data)
    {
        $info = $this->_image->where(['id'=>$data['id']])->select(['picUrl'])->first()->toArray();
        $pics = json_decode($info['picUrl'],true);
        foreach($pics as $v){
            $file = './'.substr($v,1);
            if(!is_dir($file) && file_exists($file)){
                unlink($file);
            }
        }
        $res = $this->_image->where(['id'=>$data['id']])->delete();
        if($res){
            return message(true,'删除成功！');
        }else{
            return message(false,'删除失败！');
        }

    }

    public function getStyleList()
    {
        $style = new Style();
        $styleList = $style->get()->toArray();
        return $styleList;
    }

    public function getSizeList()
    {
        $size = new Size();
        $sizeList = $size->get()->toArray();
        return $sizeList;
    }

    public function getColorList()
    {
        $color = new Color();
        $colorList = $color->get()->toArray();
        return $colorList;
    }

    public function getRoomList()
    {
        $room = new Room();
        $roomList = $room->get()->toArray();
        return $roomList;
    }

//    public function test()
//    {
//        $url = './src/upload/20181210/15444364489967.jpg';
//        unlink($url);
//    }
}
