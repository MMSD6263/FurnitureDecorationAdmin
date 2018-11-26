<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Repositories\admin\AdminRepository;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index()
    {

        //获取角色ID
        $role     = new Role();
        $rolerows = $role->get()->toarray();
        return view('admin.admin.index', compact(['rolerows']));
    }

    public function ajaxData(Request $request)
    {
        $data = AdminRepository::ajaxData($request->except(['_token']));
        return $data;
    }

    public function adminAdd(Request $request)
    {
        $data = AdminRepository::adminAdd($request->except(['_token']));
        return $data;
    }

    public function adminEdit(Request $request)
    {
        $data = AdminRepository::adminEdit($request->except(['_token']));
        return $data;
    }

    public function adminDelete(Request $request)
    {
        $data = AdminRepository::adminDelete($request->except(['_token']));
        return $data;
    }

    public function userInfo()
    {
        $id   = $_GET['id'];
        $data = AdminRepository::userInfo($id);
        return view('admin.admin.userInfo', compact(['data']));
    }

    public function edit(Request $request)
    {
        AdminRepository::edit($request->except(['_token']));
        return redirect('admin/index');
    }


    public function userCenter()
    {
//        $operate      = new OperatelogRepository();
        $username     = session('admin.username');
        $last_time    = date('Y-m-d H:i:s',session('admin.last_time'));
        $loginCount   = 20;
        $operateCount = 15;
        $headImage    = AdminRepository::userInfo(session('admin.id'))['picpath'];
        $colors       = AdminRepository::getFrameColors();
        if($headImage){
            return view('admin.admin.usercenter',['username'=>$username,'last_time'=>$last_time,'loginCount'=>$loginCount,'operateCount'=>$operateCount,'headImage'=>$headImage,'colors'=>$colors]);
        }else{
            return view('admin.admin.usercenter',['username'=>$username,'last_time'=>$last_time,'loginCount'=>$loginCount,'operateCount'=>$operateCount,'colors'=>$colors]);
        }
    }

    public function uploadImg(Request $request)
    {
        $file = $request->file('file');
        if ($file->isValid()) {
            //获取原文件名
            $originalName = $file->getClientOriginalName();
            //扩展名
            $ext = $file->getClientOriginalExtension();
            //文件类型
            $type = $file->getClientMimeType();
            //临时绝对路径
            $realPath = $file->getRealPath();
            $filename = '/userImage/'.time().mt_rand(10000,99999).'.'.$ext;
            $dir = '/src/upload/userImage/';
            mkdirs($dir);
            $bool = Storage::disk('uploads')->put($filename, file_get_contents($realPath));
            if ($bool) {
                AdminRepository::saveUserImage('/src/upload'.$filename);
                session('admin.picpath','/src/upload'.$filename);
                $result = message(true,'/src/upload'.$filename);
            } else {
                $result = message(false, '视频上传失败');
            }
        } else {
            $result = message(false, '上传类型不正确');
        }
        return $result;
    }

    public function changePwd(Request $request)
    {
        $data = $request->except(['_token']);
        $res  = AdminRepository::changePwd($data);
        return $res;
    }


    public function changeFrameColor(Request $request)
    {
        $data = $request->except(['_token']);
        $res  = AdminRepository::changeFrameColor($data);
        return $res;
    }
}
