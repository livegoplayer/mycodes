<?php
/**
 * Created by PhpStorm.
 * User: xjyplayer
 * Date: 2018/11/20
 * Time: 14:09
 */

namespace app\admin\controller;

class News extends Base
{
    private $myModel;
    private $cat;
    public function _initialize()
    {
        $this -> myModel = model(request()->controller());     //本控制器对应的模块model
        $this->cat = config("cat.lists");
    }

    public function index()
    {
        //验证传递方式
        if(request()->isget()){
            $data = request()->get();
        }
        //数据无需验证
        //组装数据
        $whereData = [];
        if(!empty($data["catid"])){
            $whereData["catid"] = $data["catid"];
        }
        if(!empty($data["start_time"])&&!empty($data["end_time"])&& strtotime($data["start_time"]) < strtotime($data["end_time"])){
            $whereData["create_time"] = ['between',[strtotime($data['start_time']),strtotime($data['end_time'])]];
        }elseif(!empty($data['start_time'])){
            $whereData['create_time'] = ['gt',strtotime($data['start_time'])];

        }elseif(!empty($data["end_time"])){
            $whereData["create_time"] = ["lt",strtotime($data["end_time"])];
        }
        if(!empty($data["title"])){
            $whereData["title"] = ["like","%".$data["title"]."%"];
        }
        try{
            $news= $this->myModel->getNews($whereData);
        }catch(\Exception $e){
            $this->error($e->getMessage());
        }
        return $this -> fetch("",[
            "news" => $news,
            "cat" => $this->cat,
            "data" => $data,
        ]);
    }

    public function add()
    {
        //验证传递方式
        if(request()->isPost()){
            $data = request()->post();
            if(empty($data)){
                show(config("code.status_error"),"数据为空");
            }
            //验证
            //验证数据格式
            $validate = Validate('News');
            if(!$validate->scene('add')->check($data)){
                return show(config("code.status_error"),$validate->getError());
            };
            //数据入库
            try{
                $res = $this->myModel->add($data);
            }catch(\Exception $e) {
                return show(config("code.status_error"), "提交失败");
            }
            return show(config("code.status_ok"), "提交成功",["jump_url" => url('news/index')]);
        }else {

            return $this->fetch('', [
                "cat" => $this->cat
            ]);
        }
    }

    public function edit(){
        //验证传递方式
        if(request()->ispost()){
            $id = request()->get("id");
            if(empty($id)){
                return show(config("code.status_error"),"id不能为空");
            }
            try{
                $newsInfo = $this->myModel->get($id);
            }catch(\Exception $e){
                return show(config("code.status_error"),$e->getMessage());
            }
            if(empty($newsInfo)){
                return show(config("code.status_error"),"条目信息不存在");
            }
            return show(config("code.status_ok"));
        }else{
            $id = request()->get("id");
            try{
                $newsInfo = $this->myModel->get($id);
            }catch(\Exception $e){
                return show(config("code.status_ok"),$e->getMessage());
            }
            return $this->fetch("",[
                'newInfo' => $newsInfo,
                'cat' =>$this->cat,
            ]);
        }


    }
}