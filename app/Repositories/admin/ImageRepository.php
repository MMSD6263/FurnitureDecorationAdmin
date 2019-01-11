<?php

namespace App\Repositories\admin;

use App\Models\Image;
use App\Models\Style;
use App\Models\Color;
use App\Models\Room;
use App\Models\Size;
use App\Repositories\commonclass\whereserach;
use Illuminate\Support\Facades\DB;
use Images;

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
                $pic = json_decode($value['picUrl'],true);
                $value['small_pic'] = getenv('DOMAIN').$pic[0];
                $picArr = [];
                foreach($pic as $v){
                    array_push($picArr,getenv('DOMAIN').$v);
                }
                $value['picUrl'] = json_encode($picArr);
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

    public function test()
    {
        $im = new Images();
        $name = './src/upload/20190111/15471925283459.jpg';
        $width = '400';
        $height = '600';
        $res = $im->thumb($name, $width, $height, $qz="th_");
        return $res;
    }


    function resizeImage($im,$maxwidth,$maxheight,$name,$filetype)
    {
        $pic_width = imagesx($im);
        $pic_height = imagesy($im);
        if(($maxwidth && $pic_width > $maxwidth) || ($maxheight && $pic_height > $maxheight))
        {
            if($maxwidth && $pic_width>$maxwidth)
            {
                $widthratio = $maxwidth/$pic_width;
                $resizewidth_tag = true;
            }
            if($maxheight && $pic_height>$maxheight)
            {
                $heightratio = $maxheight/$pic_height;
                $resizeheight_tag = true;
            }
            if($resizewidth_tag && $resizeheight_tag)
            {
                if($widthratio<$heightratio)
                    $ratio = $widthratio;
                else
                    $ratio = $heightratio;
            }
            if($resizewidth_tag && !$resizeheight_tag)
                $ratio = $widthratio;
            if($resizeheight_tag && !$resizewidth_tag)
                $ratio = $heightratio;
            $newwidth = $pic_width * $ratio;
            $newheight = $pic_height * $ratio;
            if(function_exists("imagecopyresampled"))
            {
                $newim = imagecreatetruecolor($newwidth,$newheight);//PHP系统函数
                imagecopyresampled($newim,$im,0,0,0,0,$newwidth,$newheight,$pic_width,$pic_height);//PHP系统函数
            }
            else
            {
                $newim = imagecreate($newwidth,$newheight);
                imagecopyresized($newim,$im,0,0,0,0,$newwidth,$newheight,$pic_width,$pic_height);
            }
            $name = $name.$filetype;
            imagejpeg($newim,$name);
            imagedestroy($newim);
        }
        else
        {
            $name = $name.$filetype;
            imagejpeg($im,$name);
        }
    }


}
