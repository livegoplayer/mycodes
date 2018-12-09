<?php
/**
 * app用到的配置文件
 * User: xjyplayer
 * Date: 2018/11/23
 * Time: 20:30
 */
return [
    //api返回状态
    'result_ok' => '1',
    'result_error' => '0',
    //api加密安全相关
    'keySalt' => "xjyplayer",  //aes加密密钥加密盐
    "ivSalt" => "app",   //aes加密偏移向量加密盐
    "method" => "AES-128-CFB",
    "padding" => 0,                    //填充方式0为PKCS7填充，1为0填充
    //api时间戳验证相关,以秒为单位
    "sign_timeout" => 10,       //sign失效时间
    "time_stamp_length" => 13,    //sign中的时间戳位数
    "cache_timeout" => 40,             //sign缓存失效时间
    //token相关
    "token_time_out" => 7,      //token失效时间
];