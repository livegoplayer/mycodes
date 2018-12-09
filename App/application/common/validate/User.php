<?php
/**
 * Created by PhpStorm.
 * User: xjyplayer
 * Date: 2018/11/26
 * Time: 20:49
 */

namespace app\common\validate;

use think\Validate;

class User extends Validate
{
    protected $rule = [
        "username" => "require",
        "phone" => "require|length:11|number",
        "password" => "require",
        "repassword" => "require|confirm:password",
        "sex" => "require|in:1,0",
        "code" => "require|number|length:6",
    ];

    protected $msg = [         //提示的错误信息
        '' => '',               //验证变量.验证规则 => 提示信息
    ];

    protected $scene = [        //验证场景
        'phone_add' => [
            "phone"
        ],
        'login' => [
            "phone",
            "code" => "number|length:6",
        ],
        'update' => [
            "phone" =>  "length:11|number",
            "sex" => "in:1,0"
        ],
        'checkUsername' => [
            "username"
        ]
    ];

    protected $field = [
        "username" => "用户名",
        "phone" => "手机号",
        "password" => "密码",
        "repassword" => "重复密码",
        "sex" => "性别",
        "code" => "验证码"
    ];
}