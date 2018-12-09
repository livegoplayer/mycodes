<?php
/**
 * Created by PhpStorm.
 * User: xjyplayer
 * Date: 2018/11/26
 * Time: 14:12
 */

namespace app\common\validate;

use think\Validate;

class Header extends Validate
{
    protected $rule = [
        "app-type" => "require",
        "model" => "require",
        "version" => "require|number",
        "sign" => "require",
        "did" => "require",
        "access-user-token" => "require"
    ];

    protected $msg = [         //提示的错误信息
        '' => '',               //验证变量.验证规则 => 提示信息
    ];

    protected $scene = [        //验证场景
        'version' => [
            "app-type",
            "model" ,
            "version",
            "did"
            ],

        'is_login' => [
            "access_user_token"
        ]


    ];

    protected $field = [
        "app-type" => "app类型",
        "model" => "模式",
        "version" => "app版本号",
        "sign" => "签名",
        "did" => "设备类型",
        "access-user-token" => "用户token"
    ];
}