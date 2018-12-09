<?php
/**
 * Created by PhpStorm.
 * User: xjyplayer
 * Date: 2018/11/5
 * Time: 16:14
 */

namespace app\admin\controller;

use think\Controller;

class City extends Controller
{
    private $cityModel;
    public function _initialize()
    {
        $this -> cityModel = model('common/City');     //需要使用的model
    }

    public function index()
    {
        //验证传递方式
        if(!request()->isget()){
            $this->error("提交方式必须为get");
        }
        $parent_id = request()->get('parent_id','0','intval');
        $categorys = $this -> cityModel -> getOneLevelCity($parent_id);
        return $this -> fetch('',
            ['categorys' => $categorys]
        );
    }

    public function add(){                                        //这里控制下拉选项
        $categorys = $this->cityModel -> getNormalFirstLevel();
        return $this->fetch('',[
            'categorys' => $categorys
        ]);
    }

    public function save(){
        if(!request()->isPost()){
            $this->error("提交方式必须为post");
        }
        $data = request()->post();
        $validate = Validate('city');
        if(!$validate->scene('save')->check($data)){
            $this->error($validate->getError());
        };
        //这里是修改列别所需要的方法
        if(!empty($data['id'])){
            if($this->cityModel->cityUpdate($data)){
                $this->success();
            }else{
                $this->error();
            }
        }
        //添加类别所需要用的方法
        if($this->cityModel -> cityAdd($data)){
            $this->success();
        }else{
            $this->error();
        }
    }

    public function listorder(){
        //接收验证
        if(!request()->isPost()){
            $this->error("提交方式必须为post");
        }
        $data = request()->post();
        //校验
        $validate = Validate('city');
        if(!$validate->scene('order')->check($data)){
            $this->error($validate->getError());
        };
        //更新

        //刷新
        if($this->cityModel->cityUpdate($data)){
            $this->result($_SERVER['HTTP_REFERER'],1,'success');
        }else{
            $this->result($_SERVER['HTTP_REFERER'],1,'更新失败');
        }

    }

    public function edit($id = 0){
        if(intval($id) < 1){
            $this->error("参数不合法");
        }
        $category = $this->cityModel -> get($id);                         //这个第一行显示
        $categorys = $this->cityModel -> getNormalFirstLevel();          //这个第二行显示
        return $this->fetch('',
            [
                'category' => $category,
                'categorys' => $categorys
            ] );

    }

    public function status(){
        //验证传递方式
        if(!request()->isget()){
            $this->error("提交方式必须为get");
        }
        $data = request()->get();
        //验证数据格式
        $validate = Validate('city');
        if(!$validate->scene('change_status')->check($data)){
            $this->error($validate->getError());
        };

        //修改数据
        $res = $this->cityModel->cityUpdate($data);
        //状态判断
        if($res){
            $this->success("状态更新成功");
        }else{
            $this->error("状态修改失败");
        }

    }

    public function delete(){
        //验证传递方式
        if(!request()->isget()){
            $this->error("提交方式必须为get");
        }
        $data = request()->get();

        //验证数据格式
        $validate = Validate('city');
        if(!$validate->scene('delete_status')->check($data)){
            $this->error($validate->getError());
        };

        //修改数据
        $res = $this->cityModel->cityUpdate($data);
        //状态判断
        if($res){
            $this->success('条目删除成功');
        }else{
            $this->error('条目删除失败');
        }
    }

}
