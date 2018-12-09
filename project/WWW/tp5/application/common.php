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


/**
 * @param $status
 * @return string
 */
function status($status){
    switch ($status){
        case 1:
            return '<span class = "label label-success radius">正常</span>';
            break;
        case 0:
            return '<span class = "label label-danger radius">待审</span>';
            break;
        case -1:
            return '<span class = "label label-danger radius">删除</span>';
            break;
        default:
            return '<span class = "label label-danger radius">错误</span>';
    }
}


function doCurl($url){
    //初始化
    $ch = curl_init();
    //设置参数
    curl_setopt($ch , CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);  //设置返回值不直接打印
    curl_setopt($ch,CURLOPT_HEADER,false);    //设置不输出header头
    //执行会话
    $output = curl_exec($ch);
    //关闭会话
    curl_close($ch);
    return $output;
}

function bisStatusString($status){
    switch ($status){
        case 0:
            return '待审核，审核方会发送邮件通知，请关注邮件';
        case 1:
            return '入驻申请成功';
        case 2:
            return '非常抱歉，您提交的材料不符合条件，请重新提交';
        case -1:
            return '您的提交已被删除';
    }
}

function render($obj){
    if(empty($obj)) {
        return '';
    }
    $params = request()->param();
    return "<div class = 'c1 pd-5 bg-1 bk-gray mt20 tp5-o2o' >".$obj ->appends($params)-> render()."</div>";
}

function getSecondCityByPath($cityPath){
    if(empty($cityPath)){
        return '';
    }

    if(preg_match('/,/',$cityPath)){        //如果匹配到逗号
        $cityArry = explode(',',$cityPath);
        $secondCityID = $cityArry[1];

    }else{
        return '市区';
    }

    $secondCity = model('common/City')->get($secondCityID);
    return $secondCity;
}



function getSecondCategoryByPath($categoryPath){
    if(empty($categoryPath)){
        return '';
    }

    if(preg_match('/|/',$categoryPath)){        //如果匹配到逗号
        $categoryArray = explode('|',$categoryPath);
    }else{
        return '';
    }

    $cateHtml = '';
    for($i=1;$i<count($categoryArray);$i++){
        $vo = $categoryArray[$i];
        $secondCategory = model('common/Category')->get($vo);
        $cateHtml .= "<lablel><input id = 'checkbox-moban' type = 'checkbox' checked = 'cheecked'";
        $cateHtml .= "' /> ";
        $cateHtml .=  $secondCategory['name'] ;
        $cateHtml .= "&nbsp</lablel>";
    }
    return $cateHtml;
}

/*
 * 跳到当前模块下的任意一个页面
 * param $urlString 直接写模块下的另一个目录，不可以加模块名
 */
function jumpTo($urlString){
    $url = 'localhost:8888/index.php/'.$urlString;
    Header("Location:".$url);
}

function getLocationCount($location_ids){
    return count(explode('|',$location_ids));
}

/**
 * @return string 返回一个固定位数的随机订单编号
 */
function setOrderNum(){
    list($micro_second,$time_stamp) = explode(" ",microtime());
    $str= explode('.',$micro_second * 10000);
    return $time_stamp.$str[0].mt_rand(10000,99999);
}

