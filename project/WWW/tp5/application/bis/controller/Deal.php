<?php
/**
 * Created by PhpStorm.
 * User: xjyplayer
 * Date: 2018/11/13
 * Time: 0:00
 */

namespace app\bis\controller;

class Deal extends Base
{
    private $cityModel;
    private $categoryModel;
    private $bisModel;
    private $locationModel;
    private $dealModel;

    public function _initialize()
    {
        $this -> cityModel = model('common/City');     //需要使用的model
        $this -> categoryModel = model('common/Category');
        $this->bisModel = model('common/Bis');
        $this->locationModel = model('common/BisLocation');
        $this->dealModel = model('common/Deal');
    }

    public function index()
    {
        $bisID = $this->getLoginUser()->bis_id;
        $deals = $this->dealModel->getDealByBisID($bisID);
        $firstLevelCitys = $this->cityModel ->getNormalFirstLevel();
        $firstLevelCategorys = $this->categoryModel ->getNormalFirstCategory();
        return $this -> fetch('',[
            'firstLevelCitys' => $firstLevelCitys,
            'firstLevelCategorys' => $firstLevelCategorys,
            'deals' => $deals
        ]);
    }

    public function add(){
        //验证传递方式
        if(request()->isPost()){
            //验证数据
            $data = request()->post();
//            return json_encode($data);
            $dealData = $this->parseDealData($data);
            //添加
            $dealID = $this->dealModel->add($dealData);
            if($dealID){
                return $this->success("提交成功");
            }else{
                return $this->error("提交失败");
            }


        }
        $bisID = $this->getLoginUser()->bis_id;
        if(empty($bisID)){
            $this->error("找不到id");
        }
//        echo json_encode($bisID);exit;
        $locations = $this->locationModel ->getLocationByBisID($bisID);
        $firstLevelCitys = $this->cityModel ->getNormalFirstLevel();
        $firstLevelCategorys = $this->categoryModel ->getNormalFirstCategory();
        return $this -> fetch('',[
            'firstLevelCitys' => $firstLevelCitys,
            'firstLevelCategorys' => $firstLevelCategorys,
            'locations' => $locations,
        ]);
    }

    public function status(){
        //验证传递方式
        if(!request()->isget()){
            $this->error("提交方式必须为get");
        }
        $data = request()->get();
        $res = $this->dealModel->upgrade($data);
        if($res){
            $this->success("状态更新成功");
        }else{
            $this->error("状态更新失败");
        }
    }

    public function edit(){
        //验证传递方式
//        if(!request()->isPost()){
//            $this->error("提交方式必须为post");
//            $data = request()->post();
//        }

        $dealID = request()->get("id");
        $bisID = $this->getLoginUser()->bis_id;
        $deal = $this->dealModel->get($dealID);
        $locations = $this->locationModel ->getLocationByBisID($bisID);
        $firstLevelCitys = $this->cityModel ->getNormalFirstLevel();
        $firstLevelCategorys = $this->categoryModel ->getNormalFirstCategory();
        return $this -> fetch('',[
            'firstLevelCitys' => $firstLevelCitys,
            'firstLevelCategorys' => $firstLevelCategorys,
            'locations' => $locations,
            'deal' => $deal
        ]);
    }

    protected function parseDealData($data)
    {
        //验证数据格式
        $validate = Validate('common/Deal');
        if(!$validate->scene('all')->check($data)){
            $this->error($validate->getError());
        };
        $bisID = $this->getLoginUser()->bis_id;
        $bisAccountID = $this->getLoginUser()->id;
        if(!$bisID){
            $this->error('获取ID失败');
        }
        /*
         * 团购信息封装
         */
        $locations = implode('|',$data["locations"]);
        $categorys = implode("|",$data['se_category_id']);
        /*
         * 获取第一个门店的地理位置信息
         */
        $locationID = $data['locations'][0];
//        echo $locationID;exit;
        $lnglat = $this->locationModel->get($locationID);
        if(empty($lnglat)){
            $this->error("获取门店信息失败");
        }
        /*
         * 获取店家的账号ID
         */
        $accountID =
        $dealData = [
            'name' => $data['name'],
            'category_id' => $data['category_id'] ,
            'se_category_id' => $categorys ,
            'bis_id' => $bisID,
            'location_ids'=> $locations,
            'image' => $data['image'],
            'description' => empty($data['description']) ? "" : $data['description'],
            'start_time' => strtotime($data['start_time']),
            'end_time' => strtotime($data['end_time']),
            'origin_price' => $data['origin_price'],
            'current_price' => $data['current_price'],
            'coupons_start_price' => strtotime($data['coupons_begin_time']),
            'coupons_end_price' => strtotime($data['coupons_end_time']),
            'city_id' => $data['city_id'],
            'se_city_id' => $data['se_city_id'],
            'buy_count' => $data['current_price'],
            'total_count' => $data['total_count'],
            'xpoint' => $lnglat->xpoint,                                  //第一个门店的地理位置信息
            'ypoint' => $lnglat->ypoint,
            'bis_count_id' => $bisAccountID,
            'balance_price' =>empty($data['balance_price']) ? '':$data['balance_price'],
            'notes' => empty($data['notes']) ? '': $data['notes'],
        ];

        return $dealData;

    }





}