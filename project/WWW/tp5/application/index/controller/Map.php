<?php
/**
 * Created by PhpStorm.
 * User: xjyplayer
 * Date: 2018/11/15
 * Time: 11:31
 */

namespace app\index\controller;

use think\Controller;

class Map extends Controller
{

    public function getMap()
    {
        //验证传递方式
        if(!request()->isget()){
            $this->error("提交方式必须为get");
        }
        $data = request()->get('data');
        if(empty($data)){
            $this->error('经纬度信息不存在');
        }
        return \Map::getStaticImage($data);
    }
}