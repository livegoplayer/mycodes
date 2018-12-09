<?php
/**
 * Created by PhpStorm.
 * User: xjyplayer
 * Date: 2018/11/25
 * Time: 19:57
 */

namespace app\common\validate;

use think\Validate;

class Version extends Validate
{
    protected $rule = [
        "version" => "require|number",
        "version_code" => "require",
        "app_type"=> "require",
        "apk_url" => "require|activeUrl",
        "upgrade_point"=> "require"
    ];

//    protected $msg = [         //提示的错误信息
//        '' => '',               //验证变量.验证规则 => 提示信息
//    ];

    protected $scene = [        //验证场景
        'add' => [
            "version" ,
            "version_code" ,
            "app_type",
            "apk_url",
            "upgrade_point"
        ],
    ];

    protected $field = [
        "version" => "内部版本号",
        "version_code" => "外部",
        "app_type"=> "app类型",
        "apk_url" => "apk地址",
        "upgrade_point"=> "升级提示"
    ];
}