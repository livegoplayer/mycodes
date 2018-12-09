<?php
/**
 * Created by PhpStorm.
 * User: xjyplayer
 * Date: 2018/11/11
 * Time: 22:36
 */

namespace app\bis\controller;


class Index extends Base
{
//    private $categoryModel;
////    public function _initialize()
////    {
////        $this -> categoryModel = model('');     //需要使用的model
////    }

    public function index()
    {
        return $this -> fetch();
    }
}