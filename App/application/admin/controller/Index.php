<?php
/**
 * Created by PhpStorm.
 * User: xjyplayer
 * Date: 2018/11/18
 * Time: 20:17
 */

namespace app\admin\controller;

class Index extends Base
{
    public function index()
    {

        return $this->fetch();
    }

    public function welcome()
    {
        return '欢迎';
    }
}