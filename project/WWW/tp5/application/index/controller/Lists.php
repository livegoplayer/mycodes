<?php
/**
 * Created by PhpStorm.
 * User: xjyplayer
 * Date: 2018/11/15
 * Time: 13:56
 */

namespace app\index\controller;

use think\Model;

class Lists extends Base
{
    protected $myModel;
    protected $dealModel;
    public function _initialize()
    {
        parent::_initialize();
        $this -> myModel = model('common/Category');     //本控制器对应的模块model
        $this->dealModel = model('common/Deal');
    }

    public function index()
    {
        //验证传递方式
        if(!request()->isget()){
            $this->error("提交方式必须为get");
        }
        $data = request()->get();
        $id = $data['id'];
        //获得所选分类信息
        try{
            $selected = $this->myModel->get($id);
            $firstCategorys = $this->myModel->getNormalFirstCategory();
        }catch(\Exception $e){
            $this->error($e->getMessage());
        }
//        echo json_encode($firstCategorys);exit;
        $selected_id = $selected->id;
        //处理选中状态
        if(empty($selected)){                   //选中全部
            $parent_category = '0';
            $title = "全部";
        } elseif($selected -> parent_id == 0){  //选中父类
            $parent_category = $selected->id;
        }else{
            $parent_category = $selected->parent_id; //选中子类
        }
        //子类列表
        try{
            $second_category = $this->myModel->getOneLevelCategory($parent_category);
        }catch(\Exception $e){
            $this->error($e->getMessage());
        }
        if(empty($second_category)){
            $this->error("没有相关子类信息");
        }
        //根据排序信息得到$deals或者不依赖排序信息
        $order = array_key_exists('order',$data) ? $data['order'] : config('lists_order.0');
        $cityID = $this->city->id;
        if($order!= config("list_order.3")){
            $desc = false;
        }else{
            $desc = true;
        }

        try{
            $sdata  = [
                'se_category_id' => $selected_id,
                'category_id' => $parent_category,
                'city_id' => $cityID,
                'order' => $order,
                'desc' => $desc
            ];

            $deals = $this->dealModel->getDealsByOrderID($sdata);

        }catch(\Exception $e){
            $this->error($e->getMessage());
        }

        return $this -> fetch('',[
            'parent_category_id' => $parent_category,
            'first_categorys' => $firstCategorys,
            'title' => empty($title) ? $selected->name : $title,
            'controller' => strtolower(request()->controller()),
            'second_categorys' => $second_category,
            'selected_id' => $selected_id,
            'deals' => $deals,
            'order' => $order
        ]);
    }
}