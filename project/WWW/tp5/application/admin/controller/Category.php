<?php
namespace app\admin\controller;

use think\Controller;

class Category extends Controller
{
    private $categoryModel;
    public function _initialize()
    {
        $this -> categoryModel = model('common/Category');
    }

    public function index()
    {
        $parent_id = request()->get('parent_id',0,'intval');
        $categorys = $this -> categoryModel -> getFirstCategory($parent_id);
        return $this -> fetch('',
            ['categorys' => $categorys,]
        );
    }

    public function add(){                                        //这里控制下拉选项
        $categorys = $this->categoryModel -> getNormalFirstCategory();
        return $this->fetch('',[
            'categorys' => $categorys,
        ]);
    }

    public function status(){
        //验证传递方式
        if(!request()->isget()){
            $this->error("提交方式必须为get");
        }
        $data = request()->get();
        //验证数据格式
        $validate = Validate('Category');
        if(!$validate->scene('change_status')->check($data)){
            $this->error($validate->getError());
        };

        //修改数据
        $res = $this->categoryModel->categoryUpdate($data);
        //状态判断
        if($res){
            $this->success("状态更新成功");
        }else{
            $this->error("状态修改失败");
        }
    }

    public function save(){
        if(!request()->isPost()){
            $this->error("提交方式必须为post");
        }
        $data = request()->post();
        $validate = Validate('Category');
        if(!$validate->scene('save')->check($data)){
            $this->error($validate->getError());
        };
        //这里是修改列别所需要的方法
        if(!empty($data['id'])){
            if($this->categoryModel->categoryUpdate($data)){
                $this->success();
            }else{
                $this->error();
            }
        }
        //添加类别所需要用的方法
        if($this->categoryModel -> categoryAdd($data)){
            $this->success();
        }else{
            $this->error();
        }
    }

    public function edit($id = 0){
        if(intval($id) < 1){
            $this->error("参数不合法");
        }
        $category = $this->categoryModel -> get($id);                         //这个第一行显示
        $categorys = $this->categoryModel -> getNormalFirstCategory();          //这个第二行显示
        return $this->fetch('',
            [
                'category' => $category,
                'categorys' => $categorys
            ] );

    }

    public function listorder(){
        //接收验证
        if(!request()->isPost()){
            $this->error("提交方式必须为post");
        }
        $data = request()->post();
        //校验
        $validate = Validate('Category');
        if(!$validate->scene('order')->check($data)){
            $this->error($validate->getError());
        };
        //更新

        //刷新
        if($this->categoryModel->categoryUpdate($data)){
            $this->result($_SERVER['HTTP_REFERER'],1,'success');
        }else{
            $this->result($_SERVER['HTTP_REFERER'],1,'更新失败');
        }
    }



    public function delete(){
        //验证传递方式
        if(!request()->isget()){
            $this->error("提交方式必须为get");
        }
        $data = request()->get();

        //验证数据格式
        $validate = Validate('Category');
        if(!$validate->scene('delete_status')->check($data)){
            $this->error($validate->getError());
        };

        //修改数据
        $res = $this->categoryModel->categoryUpdate($data);
        //状态判断
        if($res){
            $this->success('条目删除成功');
        }else{
            $this->error('条目删除失败');
        }
    }


}
