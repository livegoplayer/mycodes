<?php
/**
 * Created by PhpStorm.
 * User=> xjyplayer
 * Date=> 2018/11/13
 * Time=> 22=>33
 */

namespace app\common\validate;

use think\Validate;

class User extends Validate
{
    protected $rule = [
        "username" => "require",
        "email" => "require|email",
        "password" => "require",
        "repassword" => "require|confirm:password",
        "verifycode" => "require|captcha"
    ];

    protected $scene = [        //验证场景
        'all' => [
            "username" ,
            "email" ,
            "password" ,
            "repassword" ,
            "verifycode"
        ],
        'login' => [
            "username" ,
            "password" ,
        ]
    ];

    protected $field = [
        "username" => "用户名",
        "email" => "邮箱",
        "password" => "密码",
        "repassword" => "重复密码",
        "verifycode" => "验证码"
    ];
}