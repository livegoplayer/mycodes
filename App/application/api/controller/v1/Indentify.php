<?php
/**
 * Created by PhpStorm.
 * User: xjyplayer
 * Date: 2018/11/26
 * Time: 20:34
 */

namespace app\api\controller\v1;

use Aliyun\Core\Regions\EndpointConfig;
use app\api\controller\Common;
use app\api\exception\APIException;
use app\common\lib\Sms;


class Indentify extends Common
{
    /**发送验证码
     * @return array
     * @throws APIException
     */
    public function save()
    {
        //验证传递方式
        if(!request()->isPost()){
            throw new APIException("数据提交方式错误",403);
        }
        $data = request()->post();
        //验证数据格式
        $validate = Validate('User');
        if(!$validate->scene('phone_add')->check($data)){
            return httpResult(config("app.result_error"),$validate->getError(),$data,403);
        };
        //发送验证码
        $res = Sms::sendMsg($data["phone"]);
        if($res == true) {
            return show(config("app.reault_ok"), "发送成功",[],201);
        }else{
            throw new APIException("发送失败",404);
        }
    }


}