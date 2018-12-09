<?php
/**
 * Created by PhpStorm.
 * User: xjyplayer
 * Date: 2018/11/27
 * Time: 20:41
 */

namespace app\common\validate;

use think\Validate;

class Comment extends Validate
{
    protected $rule = [
        "id" => "require|number",
        "content" => "require",
    ];

    protected $msg = [         //提示的错误信息
        '' => '',               //验证变量.验证规则 => 提示信息
    ];

    protected $scene = [        //验证场景
        'add' => [
            "id",
            "content" ,
            ],
    ];

    protected $field = [
        "news_id" => "新闻id",
        "user_id" => "用户id",
        "content" => "评论内容",
    ];
}