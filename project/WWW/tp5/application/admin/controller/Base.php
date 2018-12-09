<?php
/**
 * Created by PhpStorm.
 * User: xjyplayer
 * Date: 2018/11/13
 * Time: 23:30
 */

namespace app\admin\controller;

use think\Controller;

class Base extends Controller
{
    private $myModel;
    /*
     *  根据传过来的id和status修改当前当前数据状态
     *  param $data = ['id' => $id , 'status' => $targetStatus]
     *  return true / false
     */
    public function status(){
        //验证传递方式
        if(!request()->isget()){
            $this->error("提交方式必须为get");
        }
        $data = request()->get();
        if(!is_numeric($data['id'])){
            $this->error("id不合法");
        }
        if(empty($data['status'])){
            $this->error('没有传入状态');
        }
        $model = request()->controller();
        $res = model($model)->upgrade($data);
        if($res){
            $this->success("状态更新成功");
        }else{
            $this->error('状态更新失败');
        }
    }
}