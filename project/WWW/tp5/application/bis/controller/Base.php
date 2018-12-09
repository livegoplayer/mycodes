<?php
/**
 * Created by PhpStorm.
 * User: xjyplayer
 * Date: 2018/11/11
 * Time: 23:59
 */

namespace app\bis\controller;

use think\Controller;

class Base extends Controller
{
    private $account;

    public function _initialize()
    {
        if(!$this->isLogin()){
            $this->error("您还没有登录",config('__DOMAIN__')."bis/login");
        }
    }

    public function isLogin(){
        if($this->getLoginUser()){
            return true;
        }
        return false;
    }

    public function getLoginUser(){
        if($this->account){
            return $this->account;
        }
        $this->account = session('bisAccount','','bis');
        return $this->account;
    }

}
