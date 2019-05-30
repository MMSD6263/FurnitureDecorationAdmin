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
       $offset = $request['page'];
       $limit  = 10;
//       if(isset($request['type_id'])){
//           $this->_image = whereserach::whereid($this->_image,'type_id',$request['type_id']);
//       }
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
           return $arr;
       }else{
           return [];
       }


   }
}