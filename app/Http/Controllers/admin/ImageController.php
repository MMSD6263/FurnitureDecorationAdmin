<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\admin\ImageRepository;
use Images;

/**
 * Class ArticleController
 * @package App\Http\Controllers\admin
 * 文章控制器
 */
class ImageController extends Controller
{
    private $_image;

    public function __construct()
    {
        $this->_image = new ImageRepository();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 文章列表页面
     */
    public function index()
    {
        $sizeList = $this->_image->getSizeList();
        $roomList = $this->_image->getRoomList();
        $colorList = $this->_image->getColorList();
        $styleList = $this->_image->getStyleList();
        return view('admin.image.index',['sizeList'=>$sizeList,'roomList'=>$roomList,'colorList'=>$colorList,'styleList'=>$styleList]);
    }

    public function ajaxData(Request $request)
    {
        $data = $request->except(['_token']);
        $res = $this->_image->ajaxData($data);
        return $res;
    }

    public function  add()
    {
        $sizeList = $this->_image->getSizeList();
        $roomList = $this->_image->getRoomList();
        $colorList = $this->_image->getColorList();
        $styleList = $this->_image->getStyleList();
        return view('admin.image.add',['sizeList'=>$sizeList,'roomList'=>$roomList,'colorList'=>$colorList,'styleList'=>$styleList]);
    }

    public function uploadImage(Request $request)
    {
        $file = $request->file('file');
        if($file->isValid()){
            $originalName = $file->getClientOriginalName();
            $ext = $file->getClientOriginalExtension();
            $path = $file->getRealPath();
            $public_dir = base_path().'/public';
            $save_dir = '/src/upload/'.date('Ymd',time()).'/';
            $dir = $public_dir.$save_dir;
            mkdirs($dir);
            $newName  = time().mt_rand(1000,9999).'.'.$ext;
            $bool = file_put_contents($dir.$newName,file_get_contents($path));
            $img = new Images($dir);
            $res = $img->thumb($newName,400,254);
            unlink($dir.$newName);
            if(file_exists($dir.$res)){
                return array('success'=>true,'message'=>$save_dir.$res);
            }else{
                return array('success'=>false,'message'=>'failure');
            }
        }
    }

    public function saveData(Request $request)
    {
        $data = $request->except(['_token']);
        $res = $this->_image->saveData($data);
        return $res;
    }

    public function dataInfo(Request $request)
    {
        $data = $request->except(['_token']);
        $res = $this->_image->dataInfo($data);
        return $res;
    }

    public function deleteData(Request $request)
    {
        $data = $request->except(['_token']);
        $result = $this->_image->deleteData($data);
        return $result;
    }

    public function test()
    {
        shell_exec('convert 1547777186656607645.png  1547777186656607645.jpg');
    }
}
