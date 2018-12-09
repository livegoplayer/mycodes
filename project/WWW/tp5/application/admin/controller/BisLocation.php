<?php
/**
 * Created by PhpStorm.
 * User: xjyplayer
 * Date: 2018/11/12
 * Time: 15:44
 */

namespace app\admin\controller;

use think\Controller;

class BisLocation extends Controller
{
    private $cityModel;
    private $categoryModel;
    private $locationModel;
    private $bisModel;

    public function _initialize()
    {
        $this -> cityModel = model('common/City');     //需要使用的model
        $this -> categoryModel = model('common/Category');
        $this->locationModel = model('common/BisLocation');
        $this->bisModel = model("common/Bis");
    }

    public function index()
    {
        $locations = $this->locationModel->getBisLocationByStatus(1);
        return $this -> fetch('',[
            'locations' => $locations
        ]);
    }

    public function apply()
    {
        $bisLocation = $this->locationModel->getBisLocationByStatus(0);
       // echo json_encode($bisLocation);

        return $this -> fetch('',[
            'bisLocation' => $bisLocation
        ]);
    }

    public function status(){
        //验证传递方式
        if(!request()->isget()){
            $this->error("提交方式必须为get");
        }
        $data = request()->get();
        $status = [
            'status' => $data['status']
        ];
        $res = $this->locationModel->save($status,['id' => $data['id']]);
        if($res){
            return $this->success("状态跟新成功");
        }else{
            return $this->error('状态更新失败');
        }
    }

    public function detail(){
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

    public function dellist(){
        $bisLocation = $this->locationModel->getBisLocationByStatus(-1);
        // echo json_encode($bisLocation);

        return $this -> fetch('',[
            'bisLocation' => $bisLocation
        ]);
    }

}