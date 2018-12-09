<?php
/**
 * Created by PhpStorm.
 * User: xjyplayer
 * Date: 2018/11/20
 * Time: 14:25
 */

namespace app\common\model;

class News extends Base
{
    public function getNews($data = [])
    {
        $data["status"]= ["neq",config("code.status_delete")];
        $order = [
            "listorder",
            "id" => "desc"
        ];

        $res =  $this->where($data)
            ->order($order)
            ->paginate(5);
//        echo $this->getLastSql();
        return $res;
    }

    /**
     * 获取首页推荐的新闻
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getIsPositionNews()
    {
        $data = [
            "status" => 1,
           "is_position"  => 1,
        ];

        $order = [
            "listorder" => "desc",
            "read_count" => "desc",
            "create_time" => "desc"
        ];

        return $this->where($data)
            ->field($this->getField())
            ->order($order)
            ->select();
    }

    /**
     * 获取首页大图新闻
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getIsHeadFigureNews()
    {
        $data = [
            "status" => 1,
            "is_head_figure"  => 1,
        ];

        $order = [
            "listorder" => "desc",
            "read_count" => "desc",
            "create_time" => "desc"
        ];

        return $this->where($data)
            ->field($this->getField())
            ->order($order)
            ->select();
    }


    /**获取某一栏目的分页数据
     * @param $sdata  查询条件
     * @param $size   每页大小
     * @param int $from  查询的limit from参数
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getNewsByCondition($sdata, $size , $from = 0)
    {

        $sdata["status"] = 1;
        $order = [
            "listorder" => "desc",
            "read_count" => "desc",
            "create_time" => "desc",
        ];
        return $this->where($sdata)
            ->field($this->getField())
            ->limit($from,$size)
            ->order($order)
            ->select();
    }

    /**
     * 获取某一栏目的查询结果总数
     * @param $sdata
     * @return int|string
     * @throws \think\Exception
     */
    public function getNewsCountByCondition($sdata){
        $sdata["status"] = 1;
        return $this->where($sdata)
            ->count();
    }

    /**根据阅读数获取排行数据
     * @param int $num
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getRank($num=10)
    {
        $sdata["status"] = 1;
        $order = [
            "read_count" => "desc",
        ];
        return $this->where($sdata)
            ->field($this->getField())
            ->order($order)
            ->limit($num)
            ->select();
    }

    /**关于递增操作的封装
     * @param array|string $id
     * @param int $name
     * @param int $offset
     * @return Base|void
     * @throws \think\Exception
     */
    public function Inc($id ,$name,$offset = 1)
    {
        $this->where(["id" => $id])->setInc($name,$offset);
    }

    /**关于递减操作的封装
     * @param array|string $id
     * @param int $name
     * @param int $offset
     * @return Base|void
     * @throws \think\Exception
     */
    public function Dec($id ,$name,$offset = 1)
    {
        $this->where(["id" => $id])->setDec($name,$offset);
    }

    /**
     * 获取有效colum
     * @return array
     */
    private function getField(){
        return [
            "id",
            "catid",
            "image",
            "title",
            "read_count"
        ];
    }
}