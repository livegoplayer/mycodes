<?php
/**
 * Created by PhpStorm.
 * User: xjyplayer
 * Date: 2018/11/13
 * Time: 19:17
 */

namespace app\common\validate;

use think\Validate;

class Featured extends Validate
{
    protected $rule = [
        'title' => 'require',             //验证名 => 验证规则
        'image' => 'require',
        'type' => 'require',
        'url' => 'require',
        'description' => 'require'
    ];

    protected $scene = [        //验证场景
        'all' => [
            'title',
            'image',
            'type' ,
            'url',
            'description'
        ],
    ];

    protected $field = [
        'title' => '标题',             //验证名 => 验证规则
        'image' => '图片',
        'type' => '类型',
        'url' => '跳转url',
        'description' => '描述'
    ];
}