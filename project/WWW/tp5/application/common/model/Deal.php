<?php
/**
 * Created by PhpStorm.
 * User: xjyplayer
 * Date: 2018/11/13
 * Time: 0:01
 */

namespace app\common\model;

use think\Model;

class Deal extends Base
{
    public function getDealByBisID($bisID){
        $data = [
            'bis_id' => $bisID,
            'status' => 'in:0,1'
        ];

        $order = [
            'id' => 'desc'
        ];

        return $this->where($data)->order($order)->select();
    }

    public function getDealsBySdata($sdata,$status = 1){
        $data = $sdata;
        $data['status'] = $status;
        $order = [
            'id' => 'desc'
        ];
        $result = $this->where($data)->order($order)->paginate(5);
        return $result;
    }

    public function getDealsByStatus($status = 1)
    {
        $data = [
            'status' => 1
        ];

        $order = [
            'buy_count'  => 'desc'
        ];

        return $this->where($data)
            ->order($order)
            ->limit($limit)
            ->select();
    }


    /**
     * @param $categoryId
     * @param $cityID
     * @param int $limit
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getDealByCategoryID($categoryId, $cityID, $limit = 20)
    {
        $data = [
            'category_id' => $categoryId,
            'city_id' => $cityID,
            'end_time' => ['gt',time()],
            'status' => 1
        ];

        $order = [
           'buy_count'  => 'desc'
        ];

        return $this->where($data)
            ->order($order)
            ->limit($limit)
            ->select();
    }


    /**
     * @param $sdata
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function getDealsByOrderID($sdata)
    {
        if($sdata['category_id'] == $sdata['se_category_id']){
            $data[] = 'category_id='.$sdata['category_id'];
        }else{
            $data[] = 'find_in_set('.$sdata['se_category_id'].',se_category_id)';
        }
        $data[] = "city_id=".$sdata['city_id'];
        $data[] = 'status=1';
        $data[] = 'end_time > '.time();

        $order = [
            $sdata['order']  => $sdata['desc'] ? 'desc' : 'asc'
        ];

        $res =  $this->where(implode(' AND ',$data))
                     ->order($order)
                    ->paginate(30);
        return $res;
    }


}