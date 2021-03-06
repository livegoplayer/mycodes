<?php
/**
 * 登录校验
 * User: xjyplayer
 * Date: 2018/11/27
 * Time: 14:25
 */

namespace app\api\controller;

use app\api\controller\Common;
use app\api\exception\APIException;
use app\api\lib\Aes;
use think\Log;

class AuthBase extends Common
{
    /**用户信息
     * @var
     */
    protected $user;

    protected $myModel;
    public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
        $this->myModel = model("common/User");
        if(!$this->isLogin()){
            throw new APIException("你没有登陆",400);
        }
    }

    /**判定是否登录
     * @return bool
     * @throws \Exception
     */
    private function isLogin()
    {
        $header = request()->header();
//        halt($header);
        //验证数据格式
        $validate = Validate('header');
        if(!$validate->scene('is_login')->check($header)){
            Log::write(__METHOD__ ."第".__LINE__."行".$validate->getError());
            return false;
        };
        //检查用户是否登录
        $token = (new Aes())->decrypt($header["access-user-token"]);
        try{
            $res = $this->myModel->get(["token" => $token]);
        }catch(\Exception $e){
            Log::write(__METHOD__ ."第".__LINE__."行".$e->getMessage());
            return false;
        }
        if($res){
            if($res["timeout"]>time()){
                $this->user=$res->toArray();
                return true;
            }else{
                Log::write(__METHOD__ ."第".__LINE__."行"."token过期");
                return false;
            }
        }else{
            Log::write(__METHOD__ ."第".__LINE__."行"."token无效".$token);
            return false;
        }
    }
}