<?php
/**
 * Created by PhpStorm.
 * User: xjyplayer
 * Date: 2018/11/13
 * Time: 17:43
 */

namespace app\admin\controller;

use think\Controller;

class Featured extends Controller
{
    private $featuredModel;
    public function _initialize()
    {
        $this -> featuredModel = model('Featured');     //需要使用的model
    }

    public function index()
    {
        $featured_type = config('featured.featured_type');
        //验证传递方式
        $type = request()->get("type");
        //搜索条件封装
        if(!empty($type)){
            $features = $this->featuredModel->getFeaturesByType($type);
        }else{
            $features = $this->featuredModel->paginate(5);
        }

        return $this -> fetch('',[
            'features' => $features,
            'types' => $featured_type,

        ]);
    }

    public function status(){
        //验证传递方式
        if(!request()->isget()){
            $this->error("提交方式必须为get");
        }
        $data = request()->get();
        $res = $this->featuredModel->upgrade($data);
        if($res){
            $this->success("状态更新成功");
        }else{
            $this->error("状态更新失败");
        }
    }

    public function add(){
        //验证传递方式
        if(request()->isPost()){
            $data = request()->post();
            //数据校验
            //验证数据格式
            $validate = Validate('common/Featured');
            if(!$validate->scene('all')->check($data)){
                $this->error($validate->getError());
            };
            //数据不用封装
            //数据入库
            $FeaturedID = $this->featuredModel->add($data);
            if(!$FeaturedID){
                $this->error("提交失败");
            }else {
                $this->success("提交成功");
            }
        }

        $featured_type = config('featured.featured_type');
        return $this->fetch('',[
            'types' => $featured_type
        ]);
    }

}