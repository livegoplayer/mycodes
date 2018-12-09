<?php
/**
 * Created by PhpStorm.
 * User: xjyplayer
 * Date: 2018/11/19
 * Time: 12:57
 */

namespace app\admin\controller;

use think\Controller;

class Login extends Controller
{
    private $myModel;

    public function loginCheck()
    {
        $this->myModel=model("common/AdminUser");
        //验证传递方式
        if(!request()->isPost()){
            $this->error("提交方式必须为post");
        }
        $data = request()->post();
        //验证数据格式
        $validate = Validate('common/AdminUser');
        if(!$validate->scene('login')->check($data)){
            $this->error($validate->getError());
        };
        //查找用户是否存在
        $username = $data['username'];
        try{
            $adminUserInfo = $this->myModel->get(['username' => $username]);
        }catch(\Exception $e){
            $this->error($e->getMessage());
        }

        if(empty($adminUserInfo)){
            $this->error("用户名不存在");
        }
        //判断密码是否正确
        $password = md5($data['password'].$adminUserInfo['code']);
        if($password != $adminUserInfo['password']){
            $this->error("密码错误");
        }
        try{
            $udata = [
                "id" => $adminUserInfo["id"],
                "last_login_time" => time(),
                "last_login_ip" => request()->ip()
            ];
            $this->myModel->upgrade($udata);
        }catch(\Exception $e){
            $this->error($e->getMessage());
        }
        session(config('admin.session_user_information'),$adminUserInfo,config('admin.session_user_information_scope'));
        $this->redirect("index/index");
    }

    public function logout()
    {
        session(config('admin.session_user_information'),null,config('admin.session_user_information_scope'));
        $this->redirect('login/index');
    }

    public function index()
    {
        return $this -> fetch();
    }

}