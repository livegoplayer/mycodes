<?php
/**
 * Created by PhpStorm.
 * User: xjyplayer
 * Date: 2018/11/13
 * Time: 14:46
 */

namespace app\admin\controller;

use think\Controller;

class Deal extends Base
{
    private $myModel;
    private $categoryModel;
    private $cityModel;
    public function _initialize()
    {
        $this -> myModel = model('common/Deal');     //需要使用的model
        $this->categoryModel = model('common/Category');
        $this->cityModel = model('common/City');
    }

    public function index()
    {
        //验证传递方式
        $data = request()->get();
//        echo json_encode($data);
        /*
         * 封装数据
         */
        $sdata = $this->parseSearchData($data);
        /*
         * 查询获得符合条件的值
         */
        $deals = $this->myModel->getDealsBySdata($sdata);
        /*
         * 城市名映射和种类名映射
         */
        $categorys = $this->categoryModel->getNormalFirstCategory();
        $citys = $this->cityModel->getNormalFirstLevel();
        $cityArray = [];
        $categoryArray = [];
        foreach ($citys as $city){
            $cityArray[$city->id] = $city->name;
        }
        foreach ($categorys as $category){
            $categoryArray[$category->id] = $category->name;
        }

        /*
         * 传递需要的数据
         */


        return $this -> fetch('',[
            'deals' => $deals,
            'citys' => $citys,
            'categorys' => $categorys,
            'start_time' => empty($data['start_time']) ? '': $data['start_time'],
            'end_time' => empty($data['end_time']) ? '': $data['end_time'],
            'name' => empty($data['name']) ? '': $data['name'],
            'category_id' => empty($data['category_id']) ? '': $data['category_id'],
            'city_id' => empty($data['city_id']) ? '': $data['city_id'],
            'cityArray' => $cityArray,
            'categoryArray' => $categoryArray
        ]);
    }

    public function apply(){
        //验证传递方式
        $data = request()->get();
//        echo json_encode($data);
        /*
         * 封装数据
         */
        $sdata = $this->parseSearchData($data);

        /*
         * 查询获得符合条件的值
         */
        $deals = $this->myModel->getDealsBySdata($sdata,0);
        /*
         * 城市名映射和种类名映射
         */
        $categorys = $this->categoryModel->getNormalFirstCategory();
        $citys = $this->cityModel->getNormalFirstLevel();
        $cityArray = [];
        $categoryArray = [];
        foreach ($citys as $city){
            $cityArray[$city->id] = $city->name;
        }
        foreach ($categorys as $category){
            $categoryArray[$category->id] = $category->name;
        }

        /*
         * 传递需要的数据
         */


        return $this -> fetch('',[
            'deals' => $deals,
            'citys' => $citys,
            'categorys' => $categorys,
            'start_time' => empty($data['start_time']) ? '': $data['start_time'],
            'end_time' => empty($data['end_time']) ? '': $data['end_time'],
            'name' => empty($data['name']) ? '': $data['name'],
            'category_id' => empty($data['category_id']) ? '': $data['category_id'],
            'city_id' => empty($data['city_id']) ? '': $data['city_id'],
            'cityArray' => $cityArray,
            'categoryArray' => $categoryArray
        ]);
    }

    public function parseSearchData($data){
        $sdata = [];
        if(!empty($data['start_time']) && !empty($data['end_time']) &&
            strtotime($data['start_time'] ) < strtotime($data['end_time'])){

            $sdata['start_time'] = [
                ['gt',$data['start_time']],
                ['lt',$data['end_time']]
            ];

            $sdata['end_time'] = [
                ['gt',$data['start_time']],
                ['lt',$data['end_time']]
            ];
        }elseif (!empty($data['start_time'])){
            $sdata['start_time'] = [
                ['gt',$data['start_time']],
                ['lt',$data['end_time']]
            ];
        }elseif (!empty($data['end_time'])){
            $sdata['end_time'] = [
                ['gt',$data['start_time']],
                ['lt',$data['end_time']]
            ];
        }

        if(!empty($data['name'])){
            $sdata['name'] = ['like','%'.$data['name'].'%'];
        }

        if(!empty($data['category_id'])){
            $sdata['category_id'] = $data['category_id'];
        }
        if(!empty($data['city_id'])){
            $sdata['city_id'] = $data['city_id'];
        }


        return $sdata;
    }

}