<?php
/**
 * Created by PhpStorm.
 * User: xjyplayer
 * Date: 2018/11/27
 * Time: 20:59
 */

namespace app\common\model;

use think\Model;

class Comment extends Model
{
    /**
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

    /**返回满足条件的评论数
     * @param $sdata
     * @return int|string
     * @throws \think\Exception
     */
    public function getCountCommentByCondition($sdata){
        $sdata["status"] = 1;
        return $this->field("id")->where($sdata)->count();
    }

    /**获取分页的评论
     * @param $sdata
     * @param $from
     * @param $size
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getCommentByCondition($sdata,$from,$size)
    {
        $order = [
            "id" => "desc"
        ];

        $field = [
            "id",
            "content",
            "to_user_id",
            "parent_id",
            "user_id"
        ];

        $sdata["status"] = config("code.status_normal");

        return $this->field($field)
            ->where($sdata)
            ->order($order)
            ->limit($from,$size)
            ->select();
    }
}