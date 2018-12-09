<?php
/**
 * Created by PhpStorm.
 * User: xjyplayer
 * Date: 2018/11/18
 * Time: 20:09
 */

namespace app\admin\controller;

use think\Controller;

class Base extends Controller
{
    /**分页相关变量
     * @var
     */
    protected $totalCount;
    protected $totalPages;
    protected $page;
    protected $size;
    protected $from;

    /**登陆相关变量
     * @var
     */
    private $account;

    public function _initialize()
    {
        if(!$this->isLogin()){
            $this->error("您还没有登录",'admin/login/index');
        }
        //传递用户信息
        $this->assign('adminUserInfo',$this->account);

    }

    public function isLogin(){
        if($this->getLoginUser()){
            return true;
        }
        return false;
    }

    public function getLoginUser(){
        if($this->account){
            return $this->account;
        }
        $this->account = session(config('admin.session_user_information'),"",config('admin.session_user_information_scope'));
        return $this->account;
    }


    /**
     *  根据传过来的id和status修改当前当前数据状态
     *  param $data = ['id' => $id , 'status' => $targetStatus]
     *  return true / false
     */
    public function status(){
        //验证传递方式
        if(!request()->isget()){
            $this->error("提交方式必须为get");
        }
        $data = request()->get();
        if(!is_numeric($data['id'])){
            return show(config("code.status_error"),"id不合法");
        }
        if(!isset($data['status'])){
            return show(config("code.status_error"),"没有传入状态");
        }
        if($data['status'] == config("code.status_greater")){
            return show(config("code.status_error"),"此状态不允许修改");
        }
        $model = request()->controller();
        try{
            $res = model($model)->upgrade($data);
        }catch(\Exception $e){
            return show(config("code.status_error"),$e->getMessage());
        }
        if($res){
            return show(config("code.status_ok"),"状态修改成功",["jump_url" => url("news/index")]);
        }else{
            return show(config("code.status_error"),"状态修改失败");
        }
    }

    /**初始化分页变量
     * @param $totalCount  需要传递一个条目总数
     */
    public function initPaginateParams($totalCount)
    {
        //这个方法可以得到get内容
        $data = request()->param();
        $this->page = !empty($data["page"]) ? $data["page"] : 1;
        $this->size = !empty($data["size"]) ? $data["size"] : config("paginate.list_rows");
        $this->from = ($this->page - 1) * $this->size;
        $this->totalCount = $totalCount;
        $this->totalPages = ceil($totalCount/$this->size);
    }

}
