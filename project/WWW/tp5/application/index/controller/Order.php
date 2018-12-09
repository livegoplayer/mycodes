<?php
/**
 * Created by PhpStorm.
 * User: xjyplayer
 * Date: 2018/11/15
 * Time: 20:40
 */

namespace app\index\controller;

use think\Model;

class Order extends Base
{
    private $myModel;
    protected $dealModel;
    public function _initialize()
    {
        parent::_initialize();
        $this -> myModel = model(request()->controller());     //本控制器对应的模块model
        $this -> dealModel = model('common/Deal');
        if(!$this->isLogin()){
            $this->error('请先登录','user/login');
        }
    }

    public function confirm()
    {
        //验证传递方式
        if(!request()->isget()){
            $this->error("提交方式必须为get");
        }
        $data = request()->get();
        $deal = $this->dealModel->get($data['id']);
//        echo json_encode($deal);
        return $this -> fetch('',[
            'title' => '订单确认',
            'controller' => 'pay',
            'deal' => $deal,
            'count' => $data['count']
        ]);
    }

    public function index(){
        //验证传递方式
        if(!request()->isget()){
            $this->error("提交方式必须为get");
        }
        $data = request()->get();
//        return json_encode($data);
        //数据组装
        $user = $this->getLoginUser();
        if(empty($_SERVER['HTTP_REFERER'])){
            $this->error('请求来源不合法');
        };
        $data = [
            'out_trade_no' => setOrderNum(),
            'user_id' => $user->id,
            'username' => $user->username,
            'deal_id' => $data['id'],
            'deal_count' => $data['deal_count'],
            'total_price' => $data['total_price'],
            'referer' => $_SERVER['HTTP_REFERER']
        ];
        //数据入库
        $orderID = $this->myModel->add($data);
        if($orderID){
            $this->success('订单提交成功',url('pay/index',['id' => $orderID]));
        }
    }

}