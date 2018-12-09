<?php
/**
 * 密钥处理授权相关类.用户登录token生成
 * User: xjyplayer
 * Date: 2018/11/24
 * Time: 15:25
 */

namespace app\api\lib;

use app\api\exception\APIException;
use think\Exception;
use app\api\lib\Aes;

abstract class IAuth
{
    /**
     * 密钥加密盐处理
     * @param $keySalt
     * @param $length
     * @return bool|string
     */
    public static function keyParse($keySalt,$length = 16)
    {
        return substr(md5($keySalt),0,$length);
    }

    /**
     * iv加密盐处理
     * @param $ivSalt
     * @param $length
     * @return bool|string
     */
    public static function ivParse($ivSalt, $length =16)
    {
        return substr(md5($ivSalt),0,$length);
    }

    /**
     * 解析sign密文
     * @param $string
     * @return mixed
     * @throws \Exception
     */
    public static function signParse($string)
    {
        $decrycode = (new Aes)->decrypt($string);
        return self::strToArray($decrycode);
    }

    /**
     * 加密sign
     * @param $data
     * @return string
     * @throws \Exception
     */
    public static function signCreate($data)
    {
        $string = self::ArrayToStr($data);
        return (new Aes())->encrypt($string);
    }

    /**
     * 数组转url字符串
     * @param $data
     * @return string
     * @throws \Exception
     */
    public static function ArrayToStr($data)
    {
        if(!is_array($data)){
            Exception("数组为空");
        }
        //数组排序
        ksort($data);
        //数组转字符串
        $string = http_build_query($data);
        return $string;
    }

    /**
     * 字符串转数组
     * @param $string
     * @return mixed
     * @throws \Exception
     */
    public static function strToArray($string)
    {
        if(empty($string)){
            Exception("字符串为空");
        }
        //字符串转数组
        parse_str($string,$array);
        return $array;
    }

    /**获得一个唯一的token，用于用户登录 40位
     * @return string
     */
    public static function CreateToken()
    {
        //以当前微秒数返回一个唯一id
        return sha1(md5(uniqid(microtime(true),true)));
    }
}