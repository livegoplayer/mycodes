<?php
/**
 * Created by PhpStorm.
 * User: xjyplayer
 * Date: 2018/11/22
 * Time: 13:47
 */

namespace app\common\validate;

use think\Validate;

class News extends Validate
{
    protected $rule = [
        "title" => "require|length:10,20",
        "small_title" => "require|length:10,20",
        "catid" => "require|number",
        "description" => "require",
        "image" => "require",
        "content" => "require"
    ];

    protected $msg = [         //提示的错误信息
        '' => '',               //验证变量.验证规则 => 提示信息
    ];

    protected $scene = [        //验证场景
        'add' => [
            "title" ,
            "small_title",
            "catid" ,
            "description" ,
            "image" ,
            "content"
        ],           //自定义验证的场景名 => 场景下需要验证的变量数组]
        'read' => [
            "catid" => "number",
            "size" => "number",
            "page" => "number"
        ]
    ];

    protected $field = [
        "title" => "文章标题",
        "small_title" => "小标题",
        "catid" => "种类",
        "description" => "描述",
        "image" => "新闻图片",
        "content" => "新闻内容"
    ];
}