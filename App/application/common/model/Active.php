<?php
/**
 * Created by PhpStorm.
 * User: xjyplayer
 * Date: 2018/11/26
 * Time: 14:09
 */

namespace app\common\model;

use think\Model;

class Active extends Model
{
    /*
     * 重写的add
     * param 需要添加的数据
     * return 该条数据添加完成之后的id 或者 报错
     */
    public function add($data){
        $this->allowField(true)->save($data);
        return $this->id;
        //返回id
    }
}