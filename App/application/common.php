<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
/**
 * @param $status   返回状态 1表示正常 0表示不正常
 * @param string $message   返回提示消息 描述正常信息或者错误信息
 * @param array $data   返回的附加数据
 * @return array    把该以上三个变量封装成数组返回
 */
function show($status, $message='' , $data=[]) {       //返回规范的数组
    return [
        'status' => intval($status),
        'message' => $message,
        'data' => $data,
    ];
}

/**
 * @param $obj  传入的分页对象
 * @return string   返回的分页格式
 */
function render($obj){
    if(empty($obj)) {
        return '';
    }
    $params = request()->param();
    return "<div class = 'c1 pd-5 bg-1 bk-gray mt20 tp5-o2o' >".$obj ->appends($params)-> render()."</div>";
}

/**
 * 描写管理员状态的方法
 * @param $status
 * @return string
 */
function adminStatus($status){
    switch ($status){
        case config("code.status_normal"):
            return '<span class = "label label-primary radius">管理员</span>';
            break;
        case config("code.status_delete"):
            return '<span class = "label label-danger radius">删除</span>';
            break;
        case config("code.status_greater"):
            return '<span class = "label label-secondary radius">高级管理员</span>';
    }
}

/**
 * 获取状态的文字描述
 * @param $status
 * @return string
 */
function newsStatus($status){
    switch ($status){
        case config("code.status_normal"):
            return '<span class = "label label-success radius">通过</span>';
            break;
        case config("code.status_delete"):
            return '<span class = "label label-danger radius">删除</span>';
            break;
        case config("code.status_padding"):
            return '<span class = "label label-danger radius">审核</span>';
    }
}

/**
 * 获取ID的文字描述
 * @param $id
 * @return mixed
 */
function getIDString($id){
    $list = config("cat.lists");
    return $list[$id];
}

/**
 * 获取是否推荐状态
 * @param $is_allow_comments
 * @return string
 */
function newIsAllowComments($is_allow_comments){
    switch ($is_allow_comments){
        case 1:
            return '<span class = "label label-success radius">推荐</span>';
            break;
        case 0:
            return '<span class = "label label-danger radius">不推荐</span>';
            break;
    }
}


/**
 * @param int $status    业务返回状态
 * @param string $message  业务信息
 * @param array $data     业务返回数据
 * @param int $httpcode   http状态码
 * @return \think\response\Json  返回标准格式
 */
function httpResult($status, $message='' , $data=[], $httpcode = 200){
    $data = [
        'status' => intval($status),
        'message' => $message,
        'data' => $data,
    ];
    return json($data,$httpcode);
}


