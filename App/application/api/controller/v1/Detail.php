<?php
/**
 * Created by PhpStorm.
 * User: xjyplayer
 * Date: 2018/11/25
 * Time: 16:26
 */

namespace app\api\controller\v1;

use app\api\controller\Common;
use app\api\exception\APIException;


class Detail extends Common
{
    protected $myModel;
    public function _initialize()
    {
        parent::_initialize();
        $this->myModel = model("common/News");
    }

    public function read($id)
    {
        if(empty($id) || !is_numeric($id)){
            new APIException("请传入正确的id",403);
        }
        try{
            $newInfo = $this->myModel->get($id);
        }catch(\Exception $e){
            Exception($e->getMessage());
        }
        //验证新闻是否存在
        if(empty($newInfo) || $newInfo["status"] != config('code.status_normal')){
            new APIException("该新闻飞到了火星",404);
        }
        //阅读数递增
        $this->myModel->Inc($id,"read_count");
        //解析新闻种类
        $newInfo = $this->parseCatid($newInfo);
        //封装回传数据
        $data = [
            "id" => $id,
            "newsInfo" => $newInfo
        ];
        return httpResult(config("app.result_ok"),"新闻详情",$data);
    }
}