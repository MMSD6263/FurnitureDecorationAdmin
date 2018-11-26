<?php

namespace App\Libs\mobileMessage;

class TelClass
{
    private $_appId;
    private $_appKey;
    private $_url;

    public function __construct()
    {
        $this->_appId  = 'VM43498582';
        $this->_appKey = '5e1104a101b77eaea1c97ca96168f197';
        $this->_url    = 'http://api.vm.ihuyi.com/webservice/voice.php?method=Submit';
    }

    /**
     * 拨打电话
     * @param $curlPost
     * @param $url
     * @return mixed
     */
    public static function Post($curlPost, $url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_NOBODY, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $curlPost);
        $return_str = curl_exec($curl);
        curl_close($curl);
        return $return_str;
    }

    /**
     * 解析成xml
     * @param $xml
     * @return mixed
     */
    public static function xml_to_array($xml)
    {
        $arr = [];
        $reg = "/<(\w+)[^>]*>([\\x00-\\xFF]*)<\\/\\1>/";
        if (preg_match_all($reg, $xml, $matches)) {
            $count = count($matches[0]);
            for ($i = 0; $i < $count; $i++) {
                $subxml = $matches[2][$i];
                $key    = $matches[1][$i];
                if (preg_match($reg, $subxml)) {
                    $arr[$key] = self::xml_to_array($subxml);
                } else {
                    $arr[$key] = $subxml;
                }
            }
        }
        return $arr;
    }

    public function send($mobile, $content)
    {
        if (!empty($mobile) && !empty($content)) {

            $post_data = "account={$this->_appId}&password={$this->_appKey}&mobile=" . $mobile . "&content={$content}";
            $gets      = self::xml_to_array(self::Post($post_data, $this->_url));
            var_dump($gets);
            if ($gets['SubmitResult']['code'] == 2) {
                $return = ['success' => true, 'message' => json_encode($gets)];
            } else {
                $return = ['success' => false, 'message' => json_encode($gets)];
            }
        } else {
            $return = ['success' => false, 'message' => '-1103'];
        }

        return $return;
    }

}