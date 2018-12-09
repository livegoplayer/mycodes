<?php
/**
 * Created by PhpStorm.
 * User: xjyplayer
 * Date: 2018/11/10
 * Time: 22:30
 */

namespace app\common\model;

use think\Model;

class Base extends Model
{
    /*
     * param 需要添加的数据
     * return 该条数据添加完成之后的id 或者 报错
     */
    public function add($data){
        $data['status'] = 0;               //待审核状态
        $this->allowField(true)->save($data);
        return $this->id;
        //返回id
    }

    /*
     * 利用带id的数据进行更新
     */
    public function upgrade($date)
    {
        return $this->allowField(true)->save($date,['id' => intval($date['id'])]);
    }


}