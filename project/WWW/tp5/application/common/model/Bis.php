<?php
/**
 * Created by PhpStorm.
 * User: xjyplayer
 * Date: 2018/11/3
 * Time: 17:28
 */

namespace app\common\model;


class Bis extends Base
{
    public function getBisByStatus($status = 0){
        $order = [
            'id' => 'desc'
        ];

        $data = [
            'status' => $status,
        ];

        return $this->where($data)
            ->order($order)
            ->paginate(10);

    }

}