<?php
/**
 * Created by PhpStorm.
 * User: xjyplayer
 * Date: 2018/11/15
 * Time: 21:50
 */

namespace app\admin\controller;

class User extends Base
{
    private $myModel;
    public function _initialize()
    {
        $this -> myModel = model(request()->controller());     //本控制器对应的模块model
    }

    public function index()
    {
        $user = $this->myModel->getUserByStatus(1);
        return $this -> fetch('',[
            'user' => $user
        ]);
    }

    public function dellist()
    {
        $user = $this->myModel->getUserByStatus(-1);
        return $this -> fetch('',[
            'user' => $user
        ]);
    }
}