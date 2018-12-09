<?php
/**
 * Created by PhpStorm.
 * User: xjyplayer
 * Date: 2018/11/11
 * Time: 12:35
 */

namespace app\admin\controller;

use think\Controller;

class Bis extends Controller
{
    private $cityModel;
    private $categoryModel;
    private $bisModel;
    private $locationModel;
    private $accountModel;

    public function _initialize()
    {
        $this -> cityModel = model('common/City');     //需要使用的model
        $this -> categoryModel = model('common/Category');
        $this->bisModel = model('common/Bis');
        $this->locationModel = model('common/BisLocation');
        $this->accountModel = model('common/BisAccount');
    }

    public function apply()
    {
        $bis = $this->bisModel->getBisByStatus(0);
//        echo json_encode($bis);
        return $this -> fetch('',[
            'bis' => $bis
        ]);
    }

    public function status()
    {
        //验证传递方式
        if(!request()->isget()){
            $this->error("提交方式必须为get");
        }
        $data = request()->get();
        //验证数据格式
        $validate = Validate('common/Bis');
        if(!$validate->scene('statusChange')->check($data)){
            $this->error($validate->getError());
        };
        $status = $data['status'];

        //修改数据状态
        $bisRes = $this->bisModel->upgrade($data);
        $locationRes = $this->locationModel->save(['status' => $status ],['bis_id' => $data['id'],'is_main' => 1]);
        $accountRes = $this->accountModel->save(['status' => $status ],['bis_id' => $data['id'],'is_main' => 1]);

        if($bisRes || $locationRes || $accountRes ){
            $this->success("状态更新成功");
        }else{
            $this->error("状态更新失败");
        }
    }

    public function detail(){
        //验证传递方式
        if(!request()->isget()){
            $this->error("提交方式必须为get");
        }
        $bisID = request()->get('id');
        //验证数据类型
        if(empty($bisID)){
            $this->error("商户ID不正确");
        }
        //获取页面需要的信息
        $cityInfo = $this->cityModel->getNormalFirstLevel();
        $categoryInfo = $this->categoryModel->getNormalFirstCategory();
        $bisInfo = $this->bisModel->get($bisID);
        $locationInfo = $this->locationModel ->get(['bis_id' => $bisID,'is_main' => 1]);
        $accountInfo = $this->accountModel ->get(['bis_id' => $bisID,'is_main' => 1]);

        return $this->fetch('',[
            'citys' => $cityInfo,
            'categorys' => $categoryInfo,
            'bisInfo' => $bisInfo,
            'locationInfo' => $locationInfo,
            'accountInfo' => $accountInfo
        ]);
    }

    public function dellist(){
        $bis = $this->bisModel->getBisByStatus(-1);
//        echo json_encode($bis);
        return $this -> fetch('',[
            'bis' => $bis
        ]);
    }

    public function index(){
        $bis = $this->bisModel->getBisByStatus(1);
//        echo json_encode($bis);
        return $this -> fetch('',[
            'bis' => $bis
        ]);
    }

}