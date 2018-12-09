<?php
/**
 * Created by PhpStorm.
 * User: xjyplayer
 * Date: 2018/11/3
 * Time: 17:28
 */

namespace app\common\model;


use think\Model;

class Category extends Model
{

    public function categoryAdd($data){
        $data['status'] = 1;
        return $this->save($data);
    }

    public function categoryUpdate($data)
    {
        return $this->save($data,['id' => $data['id']]);
    }

    public function getNormalFirstCategory()
    {
        $data = [
            'status' => '1',
            'parent_id' => '0'
        ];

        $order = [
            'id' => 'desc',
        ];

        return $this -> where($data)
            -> order($order)
            -> select();

    }

    public function getFirstCategory($parent_id = 0){
        $data = [
            'status' => ['neq','-1'],
            'parent_id' => $parent_id
        ];

        $order = [
            'listorder' => 'desc',
            'id' => 'desc'
        ];

        return $this -> where($data)
            -> order($order)
            -> paginate(5);
    }

    public function getOneLevelCategory($parent_id = 0){
        $data = [
            'status' => ['eq','1'],
            'parent_id' => $parent_id
        ];

        $order = [
            'listorder' => 'desc',
            'id' => 'desc'
        ];

        return $this -> where($data)
            -> order($order)
            -> select();
    }

    public function getLimitCategorysByListorder()
    {
        $data = [
            'status' => ['eq','1'],
            'parent_id' => 0
        ];

        $order = [
            'listorder' => 'desc',
            'id' => 'desc'
        ];

        return $this -> where($data)
            -> order($order)
            ->limit(5)
            ->select();
    }




}