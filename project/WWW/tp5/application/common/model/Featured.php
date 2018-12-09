<?php
/**
 * Created by PhpStorm.
 * User: xjyplayer
 * Date: 2018/11/13
 * Time: 19:28
 */

namespace app\common\model;

use think\Model;

class Featured extends Base
{
    public function getFeaturesByType($type){
        $data = [
            'type' => $type
        ];

        $order = [
            'id' => 'desc'
        ];

        return $this->where($data)
            ->order($order)
            ->paginate(5);
    }

    public function getAll(){
        return $this->select();
    }
}