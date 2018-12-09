<?php
/**
 * Created by PhpStorm.
 * User: xjyplayer
 * Date: 2018/11/9
 * Time: 15:50
 */

namespace app\api\controller;

use think\Controller;

class Image extends Controller
{
//    private $categoryModel;
//    public function _initialize()
//    {
//        $this -> categoryModel = model('');     //需要使用的model
//    }

    public function upload(){
        $file = $this->request -> file('file');
        $path = 'upload';
        $info = $file -> move($path);
        if($info){
            return show(true,'success',DS.$info->getPathname());
        }else{
            return show(false,'upload_error');
        }
    }
}