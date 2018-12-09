<?php
/**
 * Created by PhpStorm.
 * User: xjyplayer
 * Date: 2018/11/13
 * Time: 0:37
 */

namespace app\common\validate;

use think\Validate;

class Deal extends Validate
{
    protected $rule = [
        "name" => "require",
        "city_id" => "require",
        "se_city_id" => "require",
        "category_id" => "require",
        "se_category_id" => "require",
        "image" => "require",
        "start_time" => "require",
        "end_time" => "require",
        "total_count" => "require",
        "origin_price" => "require",
        "current_price" => "require",
        "coupons_begin_time" => "require",
        "coupons_end_time" => "require",
        "locations" => "require"
    ];

    protected $msg = [         //提示的错误信息
        '' => '',               //验证变量.验证规则 => 提示信息
    ];

    protected $scene = [        //验证场景
        'all' => [
            "name" ,
            "city_id",
            "se_city_id",
            "category_id" ,
            "se_category_id" ,
            "image" ,
            "start_time" ,
            "end_time",
            "total_count" ,
            "origin_price" ,
            "current_price" ,
            "coupons_begin_time" ,
            "coupons_end_time",
            "locations"

        ]
    ];

    protected $field = [
        "name" => "团购名称",
        "city_id" => "限制城市",
        "se_city_id" => "所属区县",
        "category_id" => "团购大种类",
        "se_category_id" => "团购具体种类",
        "image" => "团购图片",
        "start_time" => "开始时间",
        "end_time" => "结束时间",
        "total_count" => "商品总数",
        "origin_price" => "原价",
        "current_price" => "团购价",
        "coupons_begin_time" => "优惠券有效开始时间",
        "coupons_end_time" => "优惠券有效结束时间",
        "locations" => "支持门店"
    ];
}