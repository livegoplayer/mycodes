<?php
/**
 * Created by PhpStorm.
 * User: xjyplayer
 * Date: 2018/11/12
 * Time: 12:54
 */

namespace app\bis\controller;

use think\Controller;

class Location extends Base
{
    private $locationModel;
    private $cityModel;
    private $categoryModel;
    public function _initialize()
    {
        $this -> locationModel = model('common/BisLocation');     //需要使用的model
        $this->cityModel = model('common/City');
        $this->categoryModel = model('common/Category');
    }

    public function index()
    {
        $bisID = $this->getLoginUser()->bis_id;
        if(empty($bisID)){
            $this->error("ID错误");
        }
        $locations = $this->locationModel->getBisLocationByBisID($bisID);
        return $this -> fetch('',[
            'locations' => $locations
        ]);
    }

    public function add(){
        //验证传递方式
        if(request()->isPost()){
            //验证数据
            $data = request()->post();
            $locationData = $this->parseLocationData($data);
            //添加
            $locationID = $this->locationModel->add($locationData);

            if($locationID){
                return $this->success("提交成功");
            }else{
                return $this->error("提交失败");
            }

        }

        $firstLevelCategorys = $this->categoryModel ->getNormalFirstCategory();
        $firstLevelCitys = $this->cityModel ->getNormalFirstLevel();
        return $this->fetch('',[
            'firstLevelCitys' => $firstLevelCitys,
            'firstLevelCategorys' => $firstLevelCategorys
        ]);
    }

    public function del(){
        //验证传递方式
        if(!request()->isget()){
            $this->error("提交方式必须为get");
        }
        $data = request()->get();
        $locationID = $data['id'];
        $locationData = [
            'status' => -1
        ];

        $res  = $this->locationModel->save($locationData,['id' => $locationID]);
        if($res){
            $this->success("下架成功");
        }else{
            $this->error("下架失败");
        }
    }

    public function edit(){
        //验证传递方式
        if(request()->ispost()){
            $data = $this->request->post();
            $locationData = $this->parseLocationData($data);
            /*
             * 更新数据
             */
            $res = $this->locationModel->save($locationData,['id'=>$data['location_id']]);
            if($res){
                $this->success("更新数据成功");
            }else{
                $this->error("更新失败");
            }
        }


        $locationID = request()->get('id');
        if(empty($locationID)){
            $this->error("没有这条记录");
        }

        $locationInfo = $this->locationModel->get($locationID);
        if(empty($locationInfo)){
            $this->error('没有这条记录');
        }
        $firstLevelCategorys = $this->categoryModel ->getNormalFirstCategory();
        $firstLevelCitys = $this->cityModel ->getNormalFirstLevel();
        return $this->fetch('',[
            'locationInfo' => $locationInfo,
            'firstLevelCitys' => $firstLevelCitys,
            'firstLevelCategorys' => $firstLevelCategorys
        ]);

    }

    /*
     *  把传过来的表单数据处理成数据库数据字段
     */
    protected function parseLocationData($data){
        $validate = validate('common/Bis');
        if(!$validate->scene('bis_location')->check($data)){
            $this->error($validate->getError());
        };
        $bisID = $this->getLoginUser()->bis_id;
        if(!$bisID){
            $this->error('获取你的ID失败');
        }
        /*
         * 门店信息入库
         */
        //规范化数据
        //获取经纬度
        $lnglat = \Map::getLngLat($data['address']);
        //经纬度校验
        if(empty($lnglat)
            || $lnglat['status'] != 0               //返回不成功
            || $lnglat['result']['precise'] != 1    //不是靳准匹配
        ){
            $this->error('地址解析错误');
        }
        /*
         * 二级分类
         */
        $cate = '';
        if($data['se_category_id']){
            $cate = '|';
            $cate .= implode('|',$data['se_category_id']);
        }
        $locationData = [
            'name' => $data['name'],
            'logo' => $data['logo'],
            'address' => $data['address'],
            'tel' => $data['tel'],
            'contract' => $data['contract'],
            'city_id' => $data['city_id'],
            'city_path'   => empty($data['se_city_id']) ? $data['city_id'] : $data['city_id'].",".$data['se_city_id'],
            'xpoint' => empty($lnglat['result']['location']['lng']) ? '' : $lnglat['result']['location']['lng'],
            'ypoint' => empty($lnglat['result']['location']['lat']) ? '' : $lnglat['result']['location']['lat'],
            'bis_id' => $bisID,
            'content' => empty($data['content']) ? '' : $data['content'],
            'is_main' => 0,
            'api_address' => '',
            'category_id' => $data['category_id'],
            'category_path' => $data['category_id'].$cate,
            'preview' => $data['open_time'],
        ];
        return $locationData;
    }
}