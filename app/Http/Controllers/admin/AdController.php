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
        Redis::select(1);
        $redis_key = 'test';
        $data = array(
            'artTypeId'=>2,
            'author'=>'zhongxiang',
            'editor'=>'admin',
            'artTitle'=>'sdsdsdsdsd'
        );
        foreach($data as $key=>$value){
            Redis::hset($redis_key,$key,$value);
        }
    }


    public function goEasyOTP($secretKey){
        $key = $secretKey;
        //$key=86726e4356dce2d3;
        list($t1, $t2) = explode(' ', microtime());
        $text=(float)sprintf('%.0f',(floatval($t1)+floatval($t2))*1000);
        $text = "000".$text;
        //$text = "0001490325990593";
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $crypttext =base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $text, MCRYPT_MODE_ECB, $iv));
        return $crypttext;
    }


    public function test1()
    {
        echo 'this is a test';
    }




}
