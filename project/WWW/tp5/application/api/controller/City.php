<?php
/**
 * Created by PhpStorm.
 * User: xjyplayer
 * Date: 2018/11/7
 * Time: 21:47
 */

namespace app\api\controller;

use think\Controller;

class City extends Controller
{
    private $cityModel;
    public function _initialize()
    {
        $this -> cityModel = model('common/City');     //需要使用的model
    }

    public function getSecondLevelCity(){
        //验证传递方式
        if(!request()->isPost()){
            $this->error("提交方式必须为post");
        }
        $id = request()->post("parent_id");
        if(!$id){
            $this->error("id不合法");
        }

        $secondLevelCitys = $this->cityModel->getOneLevelCitysByParentID($id);
        if(!$secondLevelCitys) {
            return show(0, "error");
        }else{
            return show(1, "success", $secondLevelCitys);
        }

    }
}