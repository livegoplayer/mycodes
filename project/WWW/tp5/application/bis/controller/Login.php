<?php
/**
 * Created by PhpStorm.
 * User: xjyplayer
 * Date: 2018/11/11
 * Time: 20:37
 */

namespace app\bis\controller;


use think\Controller;

class Login extends Controller
{
    private $accountModel;
    public function _initialize()
    {
        $this -> accountModel = model('common/BisAccount');     //需要使用的model
    }

    public function index()
    {
        //验证传递方式
        if(!request()->isPost()){
            $account = session('bisAccount','','bis');
            if($account){
                $this->success("将为您直接定向到管理页面",config('__DOMAIN__').'bis/index');
            }

            return $this -> fetch();
        }

        $data = request()->post();
        //产生过hi获取条目信息
        $bisInfo = $this->accountModel->get(['username' => $data['username']]);
        //验证
        if(!$bisInfo || $bisInfo ->status != 1){
            $this->error('该账户不存在或者审核未通过');
        }
        if($bisInfo -> password != md5($data['password'].$bisInfo->code)){
            $this->error('密码错误');
        }

        $bisID = $bisInfo['id'];
        $timeData = [
            'last_login_time'  => time(),
        ];

        //更新登录时间
        $res = $this->accountModel->updateLastLoginTime($timeData,$bisID);

        session('bisAccount',$bisInfo,'bis');
        return $this->success("登录成功",url("index/index"));

    }

    public function logout(){
        session(null,'bis');
        $this->success('退出成功','login/index');
    }
}