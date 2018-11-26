<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;

/**
 * 模板消息
 * 发送模板消息
 * Class TemplateController
 * @package App\Http\Controllers\api
 */
class TemplateController extends Controller
{

    public $token;
    public $accessTokenKey = "tmp_token";
    public $appId;
    public $AppSecRet;
    public $template;
    public $openId;
    public $type;

    public function __construct()
    {
        $this->appId     = trim(getenv("WX_APPID"));
        $this->AppSecRet = trim(getenv("WX_APPSECRET"));
        $this->token     = $this->getAccessToken();
    }

    /**
     * 发送模板消息
     * @param $data
     * @param $type
     */
    public function send($data, $users)
    {
        $this->type = empty($data['type']) ? 1 : $data['type'];
        foreach ($users as $value) {
            $this->openId = $value;
            //发送模板消息
            $return = $this->doSendFromCoupon($data);
        }
    }

    /**
     * 模板类型
     */
    public function template($data)
    {
        switch ($this->type) {
            case 1:
                $this->template = $this->statistical($data);
                break;
            default:
                $this->template = $this->statistical($data);
                break;
        }
    }

    public function doSendFromCoupon($data)
    {
        $this->template($data);
        $json_template = json_encode($this->template);
        $url           = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=" . $this->token;
        return http_request($url, urldecode($json_template));
    }

    /**
     * 获取accessToken
     * @return mixed
     */
    private function getAccessToken()
    {
        if (Redis::exists($this->accessTokenKey)) {
            $access_token = Redis::get($this->accessTokenKey);
        } else {
            $url          = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->appId&secret=$this->AppSecRet";
            $result       = curl_get($url);
            $res          = json_decode($result);
            $access_token = $res->access_token;
            Redis::set($this->accessTokenKey, $access_token);
            Redis::expire($this->accessTokenKey, 3600);
        }
        return $access_token;
    }

    /**
     * 模板类型一
     * 模板统计
     */
    public function statistical($data)
    {

        $data = array(
            "first"    => array("value" => $data['title'], "color" => "#173177"),
            "keyword1" => array("value" => $data['level'], "color" => "#ff0033"),
            "keyword2" => array("value" => $data['type'], "color" => "#173177"),
            "keyword3" => array("value" => $data['content'], "color" => "#ff0033"),
            "remark"   => array("value" => "==============>", "color" => "#173177"),
        );

        $template = array(
            'touser'      => $this->openId,
            'template_id' => 'LMddjj54bRxWRKHMPXG5mMJk8WN5LHkNEJF_uuVicJs',
            'url'         => "https://yun.98dongman.com/api/wxLogin",
            'topcolor'    => "#7B68EE",
            'data'        => $data,
        );
        return $template;
    }

    /**
     * 获取用户信息
     * 判断有序集合（不存在，重新添加）
     */
    public function getUserDetails()
    {
        //获取获取用户的openId
        $url    = "https://api.weixin.qq.com/cgi-bin/user/get?access_token={$this->token}";
        $output = curl_get($url);
        return json_decode($output, true)['data']['openid'];
    }

    public function getUserInfo()
    {
        $details = $this->getUserDetails();
        $return  = [];
        foreach ($details as $value) {
            $url      = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=$this->token&openid=$value&lang=zh_CN";
            $userInfo = curl_get($url);
            $return[] = $userInfo;
        }
        return $return;
    }

    /**
     * 自定义菜单
     * $data = '{
     * "button":[
     * {
     * "type":"view",
     * "name":"交易平台",
     * "url":"https://yun.98dongman.com/api/wxLogin"
     * },
     * {
     * "name": "功能菜单",
     * "sub_button": [
     * {
     * "type": "click",
     * "name": "机器人状态",
     * "key": "V1001"
     * }
     * ]
     * },
     * {
     * "name": "帮助中心",
     * "sub_button": [
     * {
     * "type": "click",
     * "name": "常用命令",
     * "key": "V1002"
     * },
     * {
     * "type": "click",
     * "name": "关于我们",
     * "key": "V1002"
     * }
     * ]
     * }
     * ]
     * }';
     */
    public function createMenu($data)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=" . $this->token);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $tmpInfo = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }

        curl_close($ch);
        return $tmpInfo;

    }

//获取菜单
    public function getMenu()
    {
        return file_get_contents("https://api.weixin.qq.com/cgi-bin/menu/get?access_token=" . $this->token);
    }

//删除菜单
    public function deleteMenu()
    {
        return file_get_contents("https://api.weixin.qq.com/cgi-bin/menu/delete?access_token=" . $this->token);
    }

    public function setTplData($key, $message)
    {
        $return = false;
        if ($key && $message) {
            $score = mSecTime();
            if (is_array($message)) {
                $message = json_encode($message);
                $return  = Redis::zAdd($key, $score, $message);
            }
        }
        return $return;
    }
}