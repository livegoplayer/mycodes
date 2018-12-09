<?php
/**
 * Created by PhpStorm.
 * User: xjyplayer
 * Date: 2018/11/18
 * Time: 22:41
 */

namespace app\common\validate;

use think\Validate;

class AdminUser extends Validate
{
    protected $rule = [
        "username" => "require|/^[A-Za-z]\w{5,16}$/i",
        "password" => "require|/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{5,16}$/",
        "repassword" => "require|confirm:password",
        "verifycode" => "require|captcha"
    ];

//    protected $msg = [         //提示的错误信息
//                     //验证变量.验证规则 => 提示信息
//    ];
////
    protected $scene = [        //验证场景
        'add' => ['username', 'username','repassword'],
        'login' => ['username', 'username','verifycode'],
    ];

    protected $field = [
        'username' => '用户名',                //设置变量描述信息，错误信息汇报会采用该信息
        'password' => '密码',
        'repassword' => '确认密码'
    ];
}
