<?php
/**
 * Created by PhpStorm.
 * User: xjyplayer
 * Date: 2018/11/26
 * Time: 20:48
 */

namespace app\common\model;

use think\Model;

class User extends Base
{
    /**
     * param 需要添加的数据
     * return 该条数据添加完成之后的id 或者 报错
     */
    public function add($data){
        $data['status'] = config("code.status_normal");               //正常状态
        $this->allowField(true)->save($data);
        return $this->id;
        //返回id
    }

    /**
     * 利用带phone的数据进行更新
     */
    public function upgrade($date)
    {
        return $this->allowField(true)->save($date,['phone' => $date['phone']]);
    }

    /**根据id数组查找数据
     * @param $ids
     * @return User[]|false
     * @throws \think\exception\DbException
     */
    public function getUserByIds($ids)
    {
        $field = [
            "id",
            "username",
            "image",
        ];

        $data = [
            "status" =>1,
            "id" => ["in",$ids],
        ];

        return $this->field($field)
            ->where($data)
            ->select();
    }
}