<?php
/**
 * Created by PhpStorm.
 * User: xjyplayer
 * Date: 2018/11/23
 * Time: 13:56
 */

namespace app\api\controller;

use app\api\lib\Aes;
use app\api\lib\IAuth;
use app\api\lib\Time;
use think\Cache;


class Test
{
    public function get()
    {
        $data = [
            "name" => "xjyplayer",
            "id" => 8,
            "time" => Time::getTime(config("app.time_stamp_length")),
            "offset" => 8
        ];
        $sign = IAuth::signCreate($data);
        return httpResult(config("code.result_ok"),"get测试方法",["sign" => $sign]);
    }

    public function update($id)
    {
        $data = request()->put();
        //        return json_encode($data);
        return httpResult(config("code.result_ok"),"put测试方法",["id" => $id,"data"=> $data],200);
    }

    public function delete($id)
    {
        $data = request()->delete();
        return httpResult(config("code.result_ok"),"get测试方法",["id" => $id,"data"=> $data],200);
    }

    public function post()
    {
        $header = request()->header();
        $data = request()->post();
        $sign = $header["sign"];
        $decrycode = IAuth::signParse($sign);
        if(Time::isTimeOut($decrycode["time"],config("app.sign_timeout"),$decrycode["offset"])){
            exception("时间超时");
        }
        if(Cache::get($sign)){
            return httpResult(config("code.result_ok"),"sign已经被占用");
        }
        Cache::set($sign,1,config("app.cache_timeout"));
        return httpResult(config("code.result_ok"),"get测试方法",["data"=> $data,"sign" => $sign,"encrycode" => $decrycode ],200);
    }

    public function save(){
        $data = request()->post();
        return httpResult(config("code.result_error"),"get测试方法",["data"=> $data],500);
    }
}

