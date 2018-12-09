<?php
/**
 * Created by PhpStorm.
 * User: xjyplayer
 * Date: 2018/11/19
 * Time: 19:08
 */

namespace app\api\controller;

use think\Model;

class Validate extends Base
{
    protected $myModel;

    public function _initialize()
    {
        $this->myModel = model('common/AdminUser');
    }
    public function index()
    {
        return $this -> fetch();
    }

    /*
     * status = -1表示用户名出错
     */
    public function username()
    {
        //验证传递方式
        if(!request()->isPost()){
            $this->error("提交方式必须为post");
        }
        $data = request()->post();
        $username = trim($data['username']);
//        halt($data);
        //如果没有任何输入或者删除了所有
        if(empty($username)){
            return show(-1,"请输入用户名");
        }
        //判断首字母
        $match = '/^[a-zA-Z].*/';
        if(!preg_match($match,$username)){
            return show(-1,"用户名必须以字母开头");
        }
        //判断长度
        if(strlen($username)<6 || strlen($username)>16){
            return show(-1,"用户名长度必须在6到16位");
        }
        //判断格式
        if (!preg_match('/^\w+$/i', $username)) {
            return show(-1,"用户名只能包含下划线、字母和数字");
        }
        //判断是否唯一
        $adminUserInfo = $this->myModel->get(['username' => $username]);
        if(!empty($adminUserInfo)){
            return show(-1,"用户名已存在");
        }
        return show(0,"符合要求");
    }

    public function password()
    {
        //验证传递方式
        if(!request()->isPost()){
            $this->error("提交方式必须为post");
        }
        $data = request()->post();
        $password = $data['password'];
        //如果没有输入密码
        if(empty($password)){
            return show(-2,"请输入密码");
        }
        //判断长度
        if(strlen($password)<6 || strlen($password)>15){
            return show(-2,"密码长度必须在6到15位");
        }
        //todo
        //判断格式(强密码) 必须包含小写、大写和数字的组合
        $str = '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*$/';
        if(!preg_match($str, $password)){
            return show(-2,"密码必须至少包含、大写字母、小写字母和数字");
        }
        return show(0,"符合要求");
    }

    public function repassword()
    {
        //验证传递方式
        if(!request()->isPost()){
            $this->error("提交方式必须为post");
        }
        $data = request()->post();
        //判断是否和密码箱等
        if($data['password']==$data['repassword']){
            return show(0,"符合要求",$data);
        }else{
            return show(-3,"必须和密码一致",$data);
        }
    }


}