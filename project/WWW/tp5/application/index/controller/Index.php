<?php
namespace app\index\controller;

use think\Model;

class Index extends Base
{
//    private $myModel;
//    public function _initialize()
//    {
//        $this -> myModel = model('common/Index');     //本控制器对应的模块model
//    }

    private $dealModel;

    public function _initialize()
    {
        parent::_initialize();
        $this->dealModel = model('common/Deal');
    }

    public function index()
    {
        $city = $this->city;
        $categorys = $this->categorys;
        //模仿一下$categorys的写法
        foreach($categorys as $key => $category){
            $recommend[$key] = [
                'name' => $category['name'],
                'deals' => $this->dealModel->getDealByCategoryID($key,$city['id']),
                'city_id' => $city['id'],
                'cate' => $category['cate']
            ];
        }

//        echo json_encode($recommend);exit;
        return $this -> fetch('',[
            'recommend' => $recommend,
        ]);
    }
}
