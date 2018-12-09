<?php
/**
 * Created by PhpStorm.
 * User: xjyplayer
 * Date: 2018/11/24
 * Time: 18:36
 */
namespace app\api\controller;

use app\api\exception\APIException;
use app\api\lib\IAuth;
use think\Cache;
use think\Controller;
use app\api\lib\Time;

class Common extends Controller
{
    /**分页相关变量
     * @var
     */
    protected $totalCount;
    protected $totalPages;
    protected $page;
    protected $size;
    protected $from;
    /**
     * 存放对应的model
     */
    protected $myModel;

    /**初始化header头验证
     * @throws APIException
     */
    public function _initialize()
    {
        //验证header
        if(config("app_debug" ) == false){
            $header = request()->header();
            if(!isset($header["sign"])){
                throw new APIException("请提交签名",403);
            }
            $sign = $header["sign"];
            //判断sign的唯一性
            if(Cache::get($sign)){
                throw new APIException("sign已存在",400);
            }
            //解析sign数据
            $decrycode = IAuth::signParse($sign);
            //数字校验
            if(!(isset($decrycode["time"]) && isset($decrycode["offset"]))){
                throw new APIException("请提交正确的签名",403);
            }
            //判断sign是否过期
            if(Time::isTimeOut($decrycode["time"],config("app.sign_timeout"),$decrycode["offset"])){
                throw new APIException("sign过期",400);
            }
            //缓存sign保证唯一型
            Cache::set($sign,1,config("app.cache_timeout"));
        }
    }

    /**
     * 批量转换$data中的新闻种类为文字
     * @param $data 可以是一维数组，也可以是二维数组
     * @return array
     */
    public function parseCatid($data)
    {
        if(empty($data)){
            return [];
        }
        $newCatList = config("cat.lists");
        if (isset($data["catid"])){
            $data["catname"] = $newCatList[$data["catid"]];
        }else {
            foreach ($data as $key => $news) {
                if (isset($news["catid"])) {
                    $news["catname"] = $newCatList[$news["catid"]];
                }
            }
        }
        return $data;
    }

    /**初始化分页变量
     * @param $totalCount  需要传递一个新闻条目总数
     */
    public function initPaginateParams($totalCount)
    {
        //这个方法可以得到get内容
        $data = request()->param();
        $this->page = !empty($data["page"]) ? $data["page"] : 1;
        $this->size = !empty($data["size"]) ? $data["size"] : config("paginate.list_rows");
        $this->from = ($this->page - 1) * $this->size;
        $this->totalCount = $totalCount;
        $this->totalPages = ceil($totalCount/$this->size);
    }

    /**app初始化监测版本号
     * @return \think\response\Json
     * @throws \Exception
     */
    public function init(){
        $header = request()->header();
        //数据校验
        //验证数据格式
        $validate = Validate('Header');
        if(!$validate->scene('version')->check($header)){
            Exception($validate->getError());
        };
        $app_type = $header["app-type"];
        try{
            $VersionInfo = $this->myModel->getLastVersionByAppType($app_type);
        }catch(\Exception $e){
            Exception($e->getMessage());
        }
        if(empty($VersionInfo)){
            throw new APIException("app版本号错误",403);
        }

        //处理逻辑 2表示需要强制更新
        if(empty($VersionInfo[0]->is_force)){
            Exception("数据提取失败");
        }
        $VersionInfo[0]->is_update = $VersionInfo[0]->is_force == 1 ? 2:1;
        if($header["version"] == $VersionInfo[0]->is_force){
            $VersionInfo[0]->is_update = 0;
        }
        //顺带记录一下用户的机型
        $data = [
            "version" => $header["version"],
            "app_type" => $header["app-type"],
            "did" => $header["did"],
            "model" => $header["model"]
        ];
        try{
            model("common/Active")->add($data);
        }catch(\Exception $e){
            Exception($e->getMessage());
        }
        return httpResult(config("app.result_ok"),"版本号信息",$VersionInfo);
    }

}
