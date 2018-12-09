<?php
/**
 * 加密解密封装
 * User: xjyplayer
 * Date: 2018/11/23
 * Time: 20:27
 */

namespace app\api\lib;

use app\api\lib\IAuth;
use think\Exception;

class Aes
{
    /**
     * @var null 密钥
     */
    private $key = null;
    /**
     * @var null 偏移
     */
    private $iv = null;
    /**
     * @var null
     */
    private $method = null;
    /**
     * @var mixed|null
     */
    private $padding = null;

    /**
     * 初始化
     */
    public function __construct()
    {
        $this->key = IAuth::keyParse(config("app.keySalt"),openssl_cipher_iv_length(config("app.method")));
        $this->iv =  IAuth::ivParse(config("app.ivSalt"),openssl_cipher_iv_length(config("app.method")));
        $this->method = config("app.method");
        $this->padding = config("app.padding");
        if (empty($this->key)||empty($this->iv)||empty($this->method)||!isset($this->padding)) {
           Exception("请配置好app中加密相关参数");
        }
    }

    /**
     * 加密函数
     * @param $data
     * @return string
     * @throws \Exception
     */
    public function encrypt($data)
    {
        if(empty($data)){
            Exception("传入加密字符串为空");
        }
        if (in_array($this->method,openssl_get_cipher_methods())) {
            $encrycode = openssl_encrypt($data, $this->method, $this->key ,intval($this->padding),$this->iv);
        }else{
            Exception("请配置好app中的密钥相关参数");
        }
        if(!empty($encrycode)){
            $encrycode = base64_encode($encrycode);
            return $encrycode;
        }else{
            Exception("加密失败");
        }
    }


    /**
     * 解密函数
     * @param $encrycode
     * @return bool|string
     * @throws \Exception
     */
    public function decrypt($encrycode)
    {
        if(empty($encrycode)){
            Exception("传入解密字符串为空");
        }
        $decrycode = base64_decode($encrycode);
        if (in_array($this->method,openssl_get_cipher_methods())) {
            $decrycode = openssl_decrypt($decrycode,$this->method,$this->key,intval($this->padding),$this->iv);
        }else{
            Exception("请配置好app中的密钥相关参数");
        }
        if(!empty($encrycode)){
            return $decrycode;
        }else{
            Exception("解密失败");
        }
    }
}
