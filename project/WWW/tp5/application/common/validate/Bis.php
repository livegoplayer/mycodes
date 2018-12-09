<?php
/**
 * Created by PhpStorm.
 * User: xjyplayer
 * Date: 2018/11/8
 * Time: 19:55
 */

namespace app\common\validate;

use think\Validate;

class Bis extends Validate
{
    protected $rule = [
        /*
         * 基本信息
         */
        'name' => 'require|max:25 ',
        'email' => 'email',
        'city_id' => 'require' ,
        'se_city_id' => 'require',
        'logo' => 'require',
        'licence_logo' => 'require',
        'bank_info' => 'require',
        'bank_name' => 'require',
        'bank_user' => 'require',
        'faren' => 'require',
        'faren_tel' => 'require',
        /*
         * 总店信息
         */
        'address' => 'require',
        'tel' => 'require|number',
        'contract' => 'require',
        'category_id' => 'require',
        /*
         * 账户相关
         */
        'username' => 'require',
        'password' => 'require',
        'open_time' => 'require',
    ];

//    protected $msg = [         //提示的错误信息
//        '' => '',               //验证变量.验证规则 => 提示信息
//    ];

    protected $scene = [        //验证场景
        'basic' => [                //基本信息验证
            'name',
            'email' ,
            'city_id',
            'se_city_id',
            'logo' ,
            'licence_logo',
            'bank_info',
            'bank_name',
            'bank_user',
            'faren' ,
            'faren_tel',
        ],

        'home' => [                 //总店信息
            'address',
            'tel',
            'contact',
            'category_id'
        ],
        'user' => [                 //商户账号
            'username',
            'password',
            'open_time'
        ],

        'statusChange' => [
            'id' => 'require',
            'status'
        ],

        'bis_location' => [
            'name',
            'city_id' ,
            'se_city_id' ,
            'logo' ,
            'category_id' ,
            'se_category_id' ,
            'address' ,
            'tel',
            'contract',
        ]

    ];

    protected $field = [
        /*
         * 基本信息
         */
        'name' => '商户名称',
        'city_id' => '所属城市',
        'se_city_id' => '所属区县或者市区',
        'logo' => '店铺logo',
        'licence_logo' => '营业执照',
        'email' => '电子邮件',
        'bank_info' => '银行账号',
        'bank_name' => '银行名称',
        'bank_user' => '银行用户名',
        'faren' => '法人',
        'faren_tel' => '法人电话',
        /*
         * 总店相关
         */
        'tel' => '总店电话',
        'contact' => '总店联系人',
        'address' => '总店地址',
        'category_id' => '服务类型',
        /*
         * 账户相关
         */
        'username' => '商家用户名',
        'password' => '密码',
        'open_time' => '申请时间',
        /*
         * 审核相关
         */
        'id' => '账号记录'

    ];
}