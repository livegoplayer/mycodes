<?php
/**
 * Created by PhpStorm.
 * User: xjyplayer
 * Date: 2018/11/22
 * Time: 22:15
 */

namespace app\api\exception;

require_once ("APIException.php");
use think\exception\Handle;
use Exception;

class APIExceptionHandle extends Handle
{

    /**
     * 重写的异常处理方法
     * @param Exception $e  出现的异常
     * @return \think\Response|\think\response\Json  返回数据的格式
     */
    public function render(Exception $e)
    {
        //启用调试模式
        if(config("app_debug") == true){
            return parent::render($e);
        }
        //自定义异常逻辑
        if($e instanceof APIException){
            $message = $e->getMsg();
            $httpcode = $e->getHttpcode();
            $status = $e->getStatus();
            $data = $e->getDataArray();
            return httpResult($status,$message,$data,$httpcode);
        }
        //默认内部异常
        return httpResult(config('code.result_error'),$e->getMessage(),[],500);
    }
}











