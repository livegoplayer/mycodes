<?php
/**
 * Created by PhpStorm.
 * User: xjyplayer
 * Date: 2018/11/25
 * Time: 18:11
 */

namespace app\common\model;


class Version extends Base
{
    /**重写add，改变默认状态
     * @param $data
     * @return mixed
     */
    public function add($data){
        $data['status'] = config("code.status_normal");
        $this->allowField(true)->save($data);
        return $this->id;
        //返回id
    }

    /**获取特定的版本号信息
     * @param $sdata
     * @param int $from
     * @param int $size
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getVersionsByCondition($sdata = [],$from = 0,$size = 5)
    {
        $sdata["status"] = 1;

        $order = [
            "create_time" => "desc"
        ];

        return $this->where($sdata)
            ->order($order)
            ->limit($from,$size)
            ->select();
    }

    /**
     * 获取版本总数目
     * @param array $sdata
     * @return int|string
     * @throws \think\Exception
     */
    public function getVersionCountByCondition($sdata = [])
    {
        $sdata["status"] = 1;

        return $this->where($sdata)
            ->count();
    }

    /**根据app_type获取最新版本信息
     * @param $app_type
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getLastVersionByAppType($app_type)
    {
        $data = [
            "app_type" => $app_type,
            "status" => 1
        ];

        $order = [
            "id" => "desc"
        ];

        return $this->where($data)
            ->order($order)
            ->limit(1)
            ->select();
    }
}