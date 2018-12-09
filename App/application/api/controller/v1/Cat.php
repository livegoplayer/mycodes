<?php
/**
 * Created by PhpStorm.
 * User: xjyplayer
 * Date: 2018/11/24
 * Time: 19:21
 */

namespace app\api\controller\v1;

use app\api\controller\Common;

class Cat extends Common
{
    public function read()
    {
        $cat = config("cat.lists");
        $result[] = [
            "catid" => 0,
            "catname" => "首页"
        ];
        foreach ($cat as $catid => $catname){
            $result[] =[
                "catid" => $catid,
                "catanme" => $catname,
            ];
        }

        return httpResult(config("code.result_ok"),"新闻信息",$result);
    }
}