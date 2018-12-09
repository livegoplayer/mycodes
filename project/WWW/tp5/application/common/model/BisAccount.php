<?php
/**
 * Created by PhpStorm.
 * User: xjyplayer
 * Date: 2018/11/10
 * Time: 21:16
 */

namespace app\common\model;

class BisAccount extends Base
{

    public function updateLastLoginTime($data,$id){
        return $this->allowField(true)->save($data,['id' => $id]);
    }



}