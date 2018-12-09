<?php
/**
 * Created by PhpStorm.
 * User: xjyplayer
 * Date: 2018/11/10
 * Time: 18:19
 */

namespace app\common\model;

use think\migration\command\migrate\Status;

class BisLocation extends Base
{
    public function getBisLocationByBisID($bisID){
        $data = [
            'bis_id' => $bisID,
            'status' => 'in:0,1',

        ];

        $order = [
            'create_time' => 'desc'
        ];

        return $this->where($data)
            ->order($order)
            ->select();
    }

    public function getBisLocationByStatus($status){
        $order = [
            'id' => 'desc'
        ];

        $data = [
            'status' => $status,
            'is_main' => 'neq:1'
        ];

        return $this->where($data)
            ->order($order)
            ->paginate(10);
    }

    public function getLocationByBisID($bisID){
        $data = [
            'bis_id' => $bisID,
            'status' => '1'
        ];

        $order = [
            'create_time' => 'desc'
        ];

        return $this->where($data)
            ->order($order)
            ->select();
    }


}