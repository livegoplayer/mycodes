<?php
/**
 * Created by PhpStorm.
 * User: xjyplayer
 * Date: 2018/11/5
 * Time: 16:15
 */

namespace app\common\model;

use think\Model;

class City extends Model
{

    public function cityAdd($data){
        $data['status'] = 1;
        return $this->save($data);
    }

    public function cityUpdate($date)
    {
        return $this->save($date,['id' => intval($date['id'])]);
    }

    public function getNormalFirstLevel()
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

    public function getOneLevelCity($parent_id = 0){
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

    public function getOneLevelCitysByParentID($parent_id = 0)
    {
        $data = [
            'status' => '1',
            'parent_id' => $parent_id
        ];

        $order = [
            'id' => 'desc',
        ];

        return $this -> where($data)
            -> order($order)
            -> select();

    }


}