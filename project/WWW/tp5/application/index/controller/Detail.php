<?php
/**
 * Created by PhpStorm.
 * User: xjyplayer
 * Date: 2018/11/14
 * Time: 23:36
 */

namespace app\index\controller;

use think\Model;

class Detail extends Base
{
    protected $myModel;
    protected $locationModel;
    protected $bisModel;
    public function _initialize()
    {
        parent::_initialize();
        $this -> myModel = model('common/Deal');     //本控制器对应的模块model
        $this->categorys = model('common/Category');
        $this->locationModel = model('common/BisLocation');
        $this->bisModel = model('common/Bis');
    }

    public function index()
    {
        //验证传递方式
        if(!request()->isget()){
            $this->error("提交方式必须为get");
        }
        $id = request()->get('id');
        try{
            $deal = $this->myModel->get($id);
        }catch(\Exception $e){
            $this->error($e->getMessage());
        }
        //验证商品状态
        if(!$deal || $deal->status != 1){
            $this->error("此商品不存在");
        }

        //获取商品类别名和id
        try{
            $category = $this->categoryModel->get($deal->category_id);

        }catch(\Exception $e){
            $this->error($e->getMessage());
        }
        $categoryName = $category->name;
        $categoryID = $category->id;

        //获取所有门店名字
        $locationArray = explode('|',$deal->location_ids);
        try{
            foreach ($locationArray as $location_id){
                $locations[] = $this->locationModel->get($location_id);
            }
        }catch(\Exception $e){
            $this->error($e->getMessage());
        }

        /*
         * 获取开始时间
         */
        $dtime = $deal->start_time - time();
        if($dtime > 0){
            $flag = 1;
        }else{
            $flag = 0;
        }
        //计算天小时和秒
        $day = floor($dtime/(3600*24));
        $hour = floor($dtime%(3600*24)/3600);
        $min = floor($dtime%3600/60);
        $second = $dtime%60;
        $leftTime = $day."天".$hour."小时".$min."分钟".$second."秒";
        //        return json_encode($locations);
        //获取商家信息
        try{
            $bisInfo = $this->bisModel->get($deal->bis_id);
        }catch(\Exception $e){
            $this->error($e->getMessage());
        }
        return $this -> fetch('',[
            'title' => $deal->name,
            'locations' => $locations,
            'category_name' => $categoryName,
            'category_id' => $categoryID,
            'deal' => $deal,
            'flag' => $flag,
            'left_time' => $leftTime,
            'location' => $locations[0]->xpoint.','.$locations[0]->ypoint,
            'bis_description' => $bisInfo->description
        ]);
    }
}