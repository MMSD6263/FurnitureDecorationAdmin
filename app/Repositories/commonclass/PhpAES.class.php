<?php
namespace App\Repositories\commonclass;

class PhpAES
{
    /**向量
     * @var string
     */
    const IV = "1234567890123412";//16位
    /**
     * 默认秘钥
     */
    const KEY = '201707eggplant99';//16位

    /**
     * 解密字符串
     * @param string $data 字符串
     * @param string $key 加密key
     * @return string
     */
    public function AesDecrypt($data, $key = self::KEY, $iv = self::IV)
    {
        return openssl_decrypt(base64_decode($data), "AES-128-CBC", $key, OPENSSL_RAW_DATA, $iv);
    }

    /**
     * 加密字符串
     * 参考网站： https://segmentfault.com/q/1010000009624263
     * @param string $data 字符串
     * @param string $key 加密key
     * @return string
     */
    public function AesEncrypt($data, $key = self::KEY, $iv = self::IV)
    {
        return base64_encode(openssl_encrypt($data, "AES-128-CBC", $key, OPENSSL_RAW_DATA, $iv));
    }
}
