<?php
namespace App\Repositories\api;

use App\Models\User;
class IndexRepository
{
    private $_userInfoUrl;
    private $_user;
    public function __construct()
    {
        $this->_userInfoUrl = "https://api.weixin.qq.com/sns/jscode2session";
        $this->_user = new User();
    }

    public function wxLogin($data)
    {
        $code = $data['code'];
        $appId = getenv("WX_APPID");
        $appSecret = getenv("WX_APPSECRET");
        $url = $this->_userInfoUrl."?appid={$appId}&secret={$appSecret}&js_code={$code}&grant_type=authorization_code";
        $res = http_request($url);
        $res = json_decode($res,true);
        $openid = $res['openid'];
        if($openid){
            $user_code = $this->_user->where(['openid'=>$openid])->value('user_code');
            if($user_code){
                return message(true,['user_code'=>$user_code]);
            }else{
                $addData = [];
                $addData['openid'] = $openid;
                $addData['user_code'] =  strtolower(mt_rand(1000, 9999).substr($res['openid'],10,4));
                $addData['nickName']  = $data['nickName'];
                $addData['avatar'] = $data['avatar'];
                $addData['sex']    = empty($data['sex']) ? 0 : $data['sex'];
                if($this->_user->insertGetId($addData)){
                    return message(true,['user_code'=>$addData['user_code']]);
                }else{
                    return message(false,'新用户添加失败');
                }
            }
        }else{
            return message(false,'请求微信接口，获取用户openid失败！');
        }
    }
}