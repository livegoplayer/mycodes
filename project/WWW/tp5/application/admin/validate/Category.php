<?php
/**
 * Created by PhpStorm.
 * User: xjyplayer
 * Date: 2018/11/3
 * Time: 15:26
 */

namespace app\admin\validate;

use think\Validate;

class Category extends Validate
{
    protected $rule = [
        'id' => 'require',
        'name' => 'require|max:10',                     //验证名 => 验证规则
        'parent_id' => 'number',
        'listorder' => 'number',
        'status' => 'number|in -1,0,1'
    ];

//    protected $msg = [         //提示的错误信息
//        'name.require' => '',               //验证变量.验证规则 => 提示信息
//        'parent_id.number' =>
//    ];

    protected $scene = [        //验证场景
        'save' => ['name','parent_id'],           //自定义验证的场景名 => 场景下需要验证的变量数组
        'order' => ['id','listorder'],
        'change_status' => ['id','status' => 'number|in:0,1'],
        'delete_status' => ['id','status'=> 'number|eq:-1' ]
    ];

    protected $field = [
        'name' => '分类名',                //设置变量描述信息，错误信息汇报会采用该信息
        'parent_id' => '分类栏目',
        'id' => '分类id',
        'listorder' => '表格内顺序',
        'status' => '审核状态'
    ];

}
