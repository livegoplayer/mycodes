<?php
/**
 * Created by PhpStorm.
 * User: xjyplayer
 * Date: 2018/11/28
 * Time: 14:51
 */

namespace app\api\controller\v1;

use app\api\controller\Common;

class CommentList extends Common
{
    public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub

    }

    public function read()
    {
        $data = request()->get();
        //验证数据
        if(!isset($data["id"])){
            return httpResult(config("app.result_error"),"新闻id为空",[],403);
        }
        //获取总页数
        $sdata = [
            "news_id" => $data["id"],
        ];
        //查询分页信息
        try{
            $totalCount = model("common/Comment")->getCountCommentByCondition($sdata);
            //初始化分页信息
            $this->initPaginateParams($totalCount);
            $commentInfo = model("common/Comment")->getCommentByCondition($sdata,$this->from,$this->size);
        }catch(\Exception $e){
            Exception($e->getFile().$e->getLine().$e->getMessage());
        }
        if(empty($commentInfo)){
            return httpResult(config("app.result_error"),"暂无评论信息",[],404);
        }
        //获取user信息头像等
        $userids = [];
        foreach ($commentInfo as $comment){
            if(!empty($comment["to_user_id"])){
                $userids[] = $comment["to_user_id"];
            }
            if(!empty($comment["user_id"]) ){
                $userids[] = $comment["user_id"];
            }
        }
        $userids = array_unique($userids);

        $userInfo = model("common/User")->getUserByIds($userids);
        foreach($userInfo as $user){
            $userNames[$user["id"]] = $user["username"];
            $userImages[$user["id"]] = $user["image"];
        }
        $userNames[0] = "";
        $userImages[0] = "";
        //组装返回信息


        foreach ($commentInfo as $comment){
            $comment["username"] = $userNames[$comment["user_id"]];
            $comment["tousername"] = $userNames[$comment["to_user_id"]];
            $comment["userImage"] = $userImages[$comment["user_id"]];
        }
        $data = [
            "page" => $this->page,
            "size" => $this->size,
            "commentInfo" => $commentInfo
        ];
        return httpResult(config("app.result_error"),"评论信息",$data);
    }
}