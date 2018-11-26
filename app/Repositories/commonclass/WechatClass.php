<?php

namespace App\Repositories\commonclass;

use Illuminate\Support\Facades\Redis;
use App\Models\Component;
use App\Models\Gongzhonghao;

/**
 * 获取公众账号的授权ID
 */
class WechatClass
{
    public function getAuthToken($request)
    {

        $key   = $request['gAppId'] . '|authorizer_access_token';
        $token = Redis::get($key);

        if (!$token) {
            $gzh = Gongzhonghao::where(['id' => $request['gid']])->first(['appid', 'authorizer_refresh_token'])->toarray();

            $token = $this->getComponentAccessToken($request);

            $url = "https://api.weixin.qq.com/cgi-bin/component/api_authorizer_token?component_access_token={$token}";

            $data = [
                'component_appid'          => $request['cAppId'],
                'authorizer_appid'         => $request['gAppId'],
                'authorizer_refresh_token' => $gzh['authorizer_refresh_token'],
            ];


            $resultTmp = http_request($url, json_encode($data));
            var_dump($resultTmp);
            $result = json_decode($resultTmp, true);

            $token = $result['authorizer_access_token'];
            if ($token) {
                Redis::set($key, $token);
                Redis::EXPIRE($key, 3600);
            }
        }

        return $token;
    }

    /**
     * 获取 component_access_token
     * @return mixed
     */
    public function getComponentAccessToken($request)
    {
        $tokenKey = $request['cAppId'] . '|component_access_token';
        $token    = Redis::get($tokenKey);
        if (!$token) {

            $info    = Component::find($request['cid'])->toarray();
            $linkurl = "https://api.weixin.qq.com/cgi-bin/component/api_component_token";

            $data = [
                'component_appid'         => $info['appId'],
                'component_appsecret'     => $info['appSecret'],
                'component_verify_ticket' => $info['component_verify_ticket'],
            ];

            $resulttmp = http_request($linkurl, json_encode($data));
            $result    = json_decode($resulttmp, 1);

            $token = $result['component_access_token'];
            Redis::set($tokenKey, $token);
            Redis::EXPIRE($tokenKey, 3500);
        }
        return $token;
    }

    /**
     * 获取用户openid
     * @param $token
     * @return mixed
     */
    public function getUserOpnId($token)
    {

        if (!($output = Redis::get("sendTpl"))) {
            $url    = "https://api.weixin.qq.com/cgi-bin/user/get?access_token={$token}";
            $output = curl_get($url);
            Redis::set("sendTpl", $output);
            Redis::expire("sendTpl", 300);
        }

        return json_decode($output, true)['data']['openid'];
    }
}