<?php
/**
 * Created by PhpStorm.
 * User: xjyplayer
 * Date: 2018/11/27
 * Time: 19:31
 */

namespace app\common\model;

use think\Model;

class UserNews extends Model
{
    /**
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