<?php
/**
 * Created by PhpStorm.
 * User: xjyplayer
 * Date: 2018/11/16
 * Time: 0:01
 */

namespace app\index\controller;


class Pay extends Base
{
//    private $myModel;
//    public function _initialize()
//    {
//        $this -> myModel = model(request()->controller());     //本控制器对应的模块model
//    }

    public function index()
    {
        //验证传递方式
        if(!request()->isget()){
            $this->error("提交方式必须为get");
        }
        $data = request()->get();
                return json_encode($data);
//        return $this -> fetch();
    }
}