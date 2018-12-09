<?php
/**
 * Created by PhpStorm.
 * User: xjyplayer
 * Date: 2018/11/9
 * Time: 15:50
 */

namespace app\api\controller;

use think\Controller;
use app\common\lib\Upload;

class Image extends Controller
{
    public function upload(){
        try{
            $img_url = Upload::image();
        }catch(\Exception $e){
            return show(config('code.status_error'),"上传失败");
        }
        if(empty($img_url)){
            return show(config('code.status_error'),"上传失败");
        }
        return show(config('code.status_ok'),"上传成功",$img_url);
    }
}