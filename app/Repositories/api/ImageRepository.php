<?php
namespace App\Repositories\api;

use App\Models\Image;
use App\Repositories\commonclass\whereserach;

class ImageRepository
{
    private $_image;
    public function __construct()
    {
        $this->_image = new Image();
    }


   public function imageList($request)
   {
       $limit  = 20;
       $offset = $limit * $request['page'];
       if(isset($request['type'])){
//           $this->_image = whereserach::whereid($this->_image,'type',$request['type']);
           if($request['type'] == 0){
               $this->_image = whereserach::whereid($this->_image,'type',2);
           }else{
               $this->_image = whereserach::whereid($this->_image,'type',2);
           }
       }
//        if(isset($reqeust['style_id'])){
//            $this->_image = whereserach::whereid($this->_image,'style_id',$request['style_id']);
//        }
//       if(isset($reqeust['style_id'])){
//           $this->_image = whereserach::whereid($this->_image,'style_id',$request['style_id']);
//       }
//       if(isset($reqeust['color_id'])){
//           $this->_image = whereserach::whereid($this->_image,'color_id',$request['color_id']);
//       }
//       if(isset($reqeust['room_id'])){
//           $this->_image = whereserach::whereid($this->_image,'style_id',$request['room_id']);
//       }
       $list = $this->_image->select(['id','picUrl','views','favors','type'])->limit($limit)->offset($offset)->orderby('views','desc')->get();
       if(!empty($list)){
           $list = $list->toArray();
           $arr = [];
           foreach($list as &$value){
               $value['thumbCover'] = getenv('DOMAIN').json_decode($value['picUrl'],true)[0];
               $value['picUrl'] = json_decode($value['picUrl'],true);
               $arr[$value['id']] = $value;
           }
           dd($arr);
           return ['lists'=>$arr,'total'=>count($arr)];
       }else{
           return [];
       }


   }
}