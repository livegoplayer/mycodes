<?php
/**
 * 使用的时候需要trycatch
 * User: xjyplayer
 * Date: 2018/11/20
 * Time: 18:46
 */

namespace app\common\lib;

/**
 *  引入鉴权相关类
 */
use Qiniu\Auth;
/**
 * 引入上传相关类
 */
use Qiniu\Storage\UploadManager;
/**
 *  引入域名配置
 */
use Qiniu\Zone;
use Qiniu\config;

/**
 *  图片相关封装
 */
class Upload
{
    //图片上传相关逻辑
    public static function image()
    {
        //验证传递方式
        if(empty($_FILES['file']['tmp_name'])){
            exception("文件不合法",404);
        }
        //得到临时文件路径
        $img = $_FILES['file']['tmp_name'];
        //得到原文件名
        $img_org = $_FILES['file']['name'];
        //得到扩展名
        $array = explode('.',$img_org);
        $ext = end($array);
        /**
         * 第一步定义鉴权类
         */
        $accessKey = config('qiniu.ak');
        $secretKey = config('qiniu.sk');
        $auth = new Auth($accessKey, $secretKey);
        /**
         * 第二步生成上传token(上传凭证),绑定上传空间
         */
        $bucket = config('qiniu.bucket');
        $token = $auth->uploadToken($bucket);
        /**
         * 第三步生成上传管理对象，进行上传处理动作
         */
        //这两句在命名空间正确填写的时候不需要，但是错误填写的时候需要用来调试，最好加上
        $zone = Zone::zone0();
        $config = new Config($zone);
        $uploadMgr = new UploadManager($config);
        //定义保存的文件名，尽量不要重复
        $key = date("Y").date("m").substr(md5($img),0,5).date('YmdHis').mt_rand(10000,99999).".".$ext;
        $res = $uploadMgr->putFile($token,$key,$img);
        /**
         *  第四部处理返回结果
         */
        $img_url = null;
        if(!empty($res[0]["key"])) {
            $img_url = config('qiniu.url') . DS . $res[0]["key"];
        }
        return $img_url;
    }
}


















