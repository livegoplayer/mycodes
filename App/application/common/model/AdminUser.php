<?php
/**
 * Created by PhpStorm.
 * User: xjyplayer
 * Date: 2018/11/19
 * Time: 11:54
 */

namespace app\common\model;

use think\Model;

class AdminUser extends Base
{
    /*
     * 重写的add
     * param 需要添加的数据
     * return 该条数据添加完成之后的id 或者 报错
     */
    public function add($data){
        $data['status'] = 1;               //待审核状态
        $this->allowField(true)->save($data);
        return $this->id;
        //返回id
    }

    /*
     * 获取所有的管理员
     */
    public function getAdminList()
    {
        $order = [
            'listorder' => "desc",
            'status' => 'desc',
        ];
        return $this->order($order)->paginate(5);
    }

}