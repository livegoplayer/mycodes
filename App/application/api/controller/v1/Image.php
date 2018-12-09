<?php
/**图片上传相关接口,只返回图片接口，并未保存入数据库
 * Created by PhpStorm.
 * User: xjyplayer
 * Date: 2018/11/27
 * Time: 15:48
 */

namespace app\api\controller\v1;

use app\api\controller\AuthBase;
use app\common\lib\Upload;

class Image extends AuthBase
{
    protected $myModel;
    public function _initialize()
    {
        parent::_initialize();
    }

    public function save()
    {
        $image = Upload::image();
        return httpResult(config("app.result_ok"),"图片地址",$image,201);
    }
}