<?php
/**
 * Created by PhpStorm.
 * User: xjyplayer
 * Date: 2018/11/18
 * Time: 21:42
 */

namespace app\admin\controller;


class AdminUser extends Base
{
    private $myModel;
    public function _initialize()
    {
        parent::_initialize();
        $this -> myModel = model(request()->controller());     //本控制器对应的模块model
    }

    public function add()
    {
        //验证传递方式
        if(request()->isPost()){
            $data = request()->post();
            //验证数据格式
            $validate = Validate('common/AdminUser');
            if(!$validate->scene("add")->check($data)){
                $this->error($validate->getError());
            };
            //数据组装
            $code = mt_rand(1000,10000);
            $adminUserInfo = [
                'username' => $data['username'],
                'code' => $code,
                'password' => md5($data['password'].$code)
            ];
            //数据入库
            $addID = $this->myModel->add($adminUserInfo);
            //状态判断
            if($addID){
                $this->success('数据插入成功');
            }else{
                $this->error('数据插入失败');
            }
        }
        //        return json_encode($data);

        return $this->fetch();
    }

    public function index()
    {
        try{
            $adminUserInfo = $this->myModel->getAdminList();
        }catch(\Exception $e){
            $this->error($e->getMessage());
        }
        return $this->fetch('',[
            'adminUserInfo' => $adminUserInfo
        ]);
    }

}