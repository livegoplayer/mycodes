<?php
/**
 * Created by PhpStorm.
 * User: xjyplayer
 * Date: 2018/11/13
 * Time: 22:25
 */

namespace app\index\controller;

use think\Controller;

class User extends Base
{
    private $myModel;
    public function _initialize()
    {
        $this -> myModel = model('common/User');     //需要使用的model
    }

    public function index()
    {
        return $this -> fetch();
    }

    public function login(){
        if($this->isLogin()){
            $this->success('您已经登录,下面为您跳转到主页','index/index');
        }
        return $this ->fetch();
    }

    public function register(){
        //验证传递方式
        if(request()->isPost()){
            $data = request()->post();
            //校验
            //验证数据格式
            $validate = Validate('User');
            if(!$validate->scene('all')->check($data)){
                $this->error($validate->getError());
            };
            //数据封装
            $data['code'] = mt_rand(100,10000);
            $data['password'] = md5($data['password'].$data['code']);
            //数据入库
            try{
                $userID = $this->myModel->add($data);
            }catch(\Exception $e){
                $this->error($e->getMessage());
            }
            if($userID){
                $this->success("注册成功",'user/login');
            }else{
                $this->error("注册失败");
            }
        }

        return $this->fetch();
    }

    public function loginCheck()
    {
        //验证传递方式
        if(!request()->isPost()){
            $this->error("提交方式必须为post");
        }
        $data = request()->post();
        //验证数据格式
        $validate = Validate('common/User');
        if(!$validate->scene('login')->check($data)){
            $this->error($validate->getError());
        };
        //密码检测
        $sData = [
            'username' => $data['username']
        ];
        $userInfo = $this->myModel->get($sData);
        if(md5($data['password'].$userInfo->code) != $userInfo->password){
            $this->error("密码错误");
        }
        //用户登录成功
        session("userInfo",$userInfo,"user");
        //更新用户登录时间
        $newData = [
            'last_login_time' => time(),
            'id' => $userInfo->id
        ];
        try{
            $res = $this->myModel->upgrade($newData);
        }catch(\Exception $e){
            $this->error($e->getMessage());
        }
        //状态判断
        if($res){
            $this->success('登录成功','index/index');
        }else{
            $this->error("登录失败");
        }
    }

    public function logout()
    {
        session("userInfo",null,'user');
        $this->success('将为您定位到登录界面','user/login');
    }
}