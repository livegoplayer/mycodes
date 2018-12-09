<?php
/**
 * Created by PhpStorm.
 * User: xjyplayer
 * Date: 2018/11/14
 * Time: 0:48
 */

namespace app\index\controller;

use think\Controller;

class Base extends Controller
{
    protected $account;
    protected $city;                          //默认定位
    protected $categorys;                     //推荐相关
    protected $features;                      //首页大图以及边图
    /*
     * 需要用到的model
     */
    protected $cityModel;
    protected $categoryModel;
    protected $featuredModel;
//    /*
//     *  根据传过来的id和status修改当前当前数据状态
//     *  param $data = ['id' => $id , 'status' => $targetStatus]
//     *  return true / false
//     */
//    public function status(){
//        //验证传递方式
//        if(!request()->isget()){
//            $this->error("提交方式必须为get");
//        }
//        $data = request()->get();
//        if(!is_numeric($data['id'])){
//            $this->error("id不合法");
//        }
//        if(!empty($data['status'])){
//            $this->error('没有传入状态');
//        }
//
//        $res = $this->myModel->upgrade($data);
//        if($res){
//            $this->success("状态跟新成功");
//        }else{
//            $this->error('状态更新失败');
//        }
//    }

    public function _initialize()
    {
        /*
         * header逻辑
         */
        //传递选择城市列表
        $this->cityModel = model('common/City');
        $citys = $this->cityModel->getNormalFirstLevel();
        if($this->isLogin()) {
            $user = $this->getLoginUser();
        }else{
            $user = null;
        }
        $this->assign('citys',$citys);
        //更新默认显示的city值
        $this->getCity($citys);
        $this->assign('city',$this->city);
        //更新的登录状况
        if($this->isLogin()){
            $user = $this->getLoginUser();
        }
        $this->assign("user",$user);
        /*
         * nav逻辑
         */
        $this->categoryModel = model('common/Category');
        $this->getCategory();
        $this->assign('categorys' , $this->categorys);
        /*
         * 主页大图featured逻辑
         */
        $this->featuredModel = model('common/Featured');
        $this->getFeatures();
        $this->assign('features',$this->features);
        /*
         * 传递当前控制器名称用来引入不同的css
         */
        $this->assign('controller', strtolower(request()->controller()));
        /*
         * 传递不同的标题用来显示
         */
        $this->assign('title' ,'o2o团购网');
    }

    public function getCategory()
    {
        //获取listorder排序前五名的category
        $firstCats = $this->categoryModel->getLimitCategorysByListorder();
        //组装需要的数组

        foreach($firstCats as $category) {
            $cates = $this->categoryModel->getOneLevelCategory($category->id);
            $Categoryss[$category->id] = [
                    'name' => $category->name,
                    'cate'=> $cates
            ];
        }
        $this->categorys  = $Categoryss;
    }

    public function getFeatures()
    {
        $this->features = $this->featuredModel->getAll();
    }

    public function getCity($citys)
    {
        //验证传递方式


        foreach($citys as $city){
            $city = $city->toArray();
            if($city['is_default'] == 1){
                $default_uname = $city['uname'];
            }
            $default_uname = empty($default_uname) ? "Xianghai" : $default_uname;
        }

        $city = null;
        if(request()->isget()){
            $city = request()->get('city');
        }

        //默认城市显示逻辑
        if(empty($city) && session("city_uname",'','header')){
            $cityuname = session('city_uname','','header');
        }elseif(!empty($city)){
            $cityuname = $city;
        }else{
            $cityuname = $default_uname;
        }
        //获取默认城市具体情况
        $sdata = [
            'uname' => $cityuname
        ];
        $this->city = $this -> cityModel ->get($sdata);
        session('city_uname',$cityuname,'header');
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
        $this->account = session('userInfo','','user');
        return $this->account;
    }


}