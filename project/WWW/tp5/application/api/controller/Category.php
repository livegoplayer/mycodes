<?php
/**
 * Created by PhpStorm.
 * User: xjyplayer
 * Date: 2018/11/8
 * Time: 15:02
 */

namespace app\api\controller;

use think\Controller;

class Category extends Controller
{
    private $categoryModel;
    public function _initialize()
    {
        $this -> categoryModel = model('common/Category');     //需要使用的model
    }

    public function getSecondLevelCategory(){
        //验证传递方式
        if(!request()->isPost()){
            $this->error("提交方式必须为post");
        }
        $id = request()->post("parent_id");
        if(!$id ){
            $this ->error("id不合法");
        }
        $secondLevelCategorys = $this->categoryModel->getOneLevelCategory($id);
        if(!$secondLevelCategorys){
            return show(0,"没有子集");
        }else{
            return show(1,"sucess",$secondLevelCategorys);
        }
    }
}