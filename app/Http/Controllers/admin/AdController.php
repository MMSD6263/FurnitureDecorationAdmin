<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\admin\AdRepository;
use Illuminate\Support\Facades\Redis;

class AdController extends Controller
{
    private $_ad;

    public function __construct()
    {
        $this->_ad = new AdRepository();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 用户首页
     */
    public function index()
    {
        return view('admin.ad.index');
    }


    /**
     * @param Request $request
     * @return array
     * 用户列表
     */
    public function ajaxData(Request $request)
    {
        $data   = $request->except(['_token']);
        $result = $this->_ad->ajaxData($data);
        return $result;
    }

    public function test()
    {
        $file = 'http://video.yidianzixun.com/video/get-url?key=user_upload/1543458185676462743949424c54b6a4798c1e301da39.mp4';
//        if(exec("cd /usr/local/ffmpeg/bin")){
        if($time = exec("/usr/local/ffmpeg/bin/ffmpeg -i ".$file." 2>&1 | grep 'Duration' | cut -d ' ' -f 4 | sed s/,//")){
            echo $time;
        }else{
            echo 'no action';
        }
//        $vtime = exec("ffmpeg -i ".$file." 2>&1 | grep 'Duration' | cut -d ' ' -f 4 | sed s/,//");//总长度
//        echo 111111;
//        echo ($vtime);
//        $duration = explode(":",$time);
//         $duration_in_seconds = $duration[0]*3600 + $duration[1]*60+ round($duration[2]);//转化为秒
    }




}
