<?php
/**
 * Created by PhpStorm.
 * User: xjyplayer
 * Date: 2018/11/25
 * Time: 18:09
 */

namespace app\admin\controller;

class Version extends Base
{
    protected $myModel;
    public function _initialize()
    {
        parent::_initialize();
        $this->myModel = model("common/Version");
    }

    public function add()
    {
        //验证传递方式
        if(request()->isPost()){
            $data = request()->post();
            if(empty($data)){
                return show(config("code.status_error"),"提交数据错误");
            }
            //验证数据格式
//            $validate = Validate('Version');
//            if(!$validate->scene('add')->check($data)){
//                return show(config("code.status_error"),$validate->getError());
//            };
            //组装数据
            //数据无需组装
            //数据入库
            try{
                $res = $this->myModel->add($data);
            }catch(\Exception $e){
                return show(config("code.status_error"),$e->getMessage());
            }
            //结果处理
            if(!$res){
                return show(config("code.status_error"),"插入错误");
            }
            $resultData["jump_url"] = url("Version/add");
            return show(config("code.status_ok"),"插入成功",$resultData);
        }
        return $this->fetch();
    }

    public function edit()
    {

        return $this->fetch();
    }

    public function index()
    {



        //获取条目总数
        try{
            $versionCount = $this->myModel->getVersionCountByCondition();
        }catch(\Exception $e){
            Exception($e->getMessage());
        }
        //初始化分页信息
        parent::initPaginateParams($versionCount);
        //获取条目
        try{
            $versions = $this->myModel->getVersionsByCondition([],$this->from,$this->size);
        }catch(\Exception $e){
            Exception($e->getMessage());
        }

        return $this->fetch("",[
            "versionInfo" => $versions,
            "totalCount" => $this->totalCount,
            "totalPage" => $this->totalPages,
            "page" => $this->page
        ]);
    }

}