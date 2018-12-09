<?php
/**
 * Created by PhpStorm.
 * User: xjyplayer
 * Date: 2018/11/13
 * Time: 23:20
 */

namespace app\common\model;


class User extends Base{
    public function getUserByStatus($status = 1)
    {
        $data = [
            'status' => $status,
        ];

        $order = [
            'id' => 'desc',
        ];

        return $this -> where($data)
            -> order($order)
            -> paginate(5);
    }
}

