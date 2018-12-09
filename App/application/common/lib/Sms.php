<?php
/**短信验证码和验证模块
 * Created by PhpStorm.
 * User: xjyplayer
 * Date: 2018/11/26
 * Time: 17:20
 */

namespace app\common\lib;

use Aliyun\Api\Sms\Request\V20170525\SendSmsRequest;
use Aliyun\Core\Profile\DefaultProfile;
use Aliyun\Core\DefaultAcsClient;
use Aliyun\Core\Config;
use think\Cache;
use think\Log;

//加载区域节点配置
Config::load();

class Sms
{
    /**
     * 系统参数
     */
    private static $acsClient;
    /**验证码
     * @var
     */
    private static $code;
    /**模板代码
     * @var
     */
    private static $templateCode;
    /**公钥和密钥
     * @var
     */
    private static $ak;
    private static $sk;
    /**签名名称
     * @var
     */
    private static $signName;
    /**验证失效时间（缓存失效时间）
     * @var
     */
    private static $identify_time;

    /**
     * 在这里配置参数
     */
    private static function initParams(){
        static::$code = mt_rand(100000,999999);
        static::$ak = config("aliyun.ak");
        static::$sk = config("aliyun.sk");
        static::$signName = config("aliyun.signName");
        static::$templateCode = config("aliyun.templateCode");
        static::$identify_time = config("aliyun.identify_time");
    }

    /**发送短信验证码
     * @param $phone
     * @return mixed
     * @throws \Exception
     */
    public static function sendMsg($phone)
    {
        static::initParams();
        // 初始化SendSmsRequest实例用于设置发送短信的参数
        try{
            $request = new SendSmsRequest();

            //可选-启用https协议
            //$request->setProtocol("https");

            // 必填，设置短信接收号码
            $request->setPhoneNumbers($phone);

            // 必填，设置签名名称，应严格按"签名名称"填写，请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/sign
            $request->setSignName(static::$signName);

            // 必填，设置模板CODE，应严格按"模板CODE"填写, 请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/template
            $request->setTemplateCode(static::$templateCode);

            // 可选，设置模板参数, 假如模板中存在变量需要替换则为必填项
            $request->setTemplateParam(json_encode(array(  // 短信模板中字段的值
                "code"=>static::$code,
            ), JSON_UNESCAPED_UNICODE));

            // 可选，设置流水号
            $request->setOutId("yourOutId");

            // 选填，上行短信扩展码（扩展码字段控制在7位或以下，无特殊需求用户请忽略此字段）
            $request->setSmsUpExtendCode("1234567");

            // 发起访问请求
            $acsResponse = static::getAcsClient()->getAcsResponse($request);
        }catch(\Exception $e){
            Exception($e->getFile().$e->getLine().$e->getMessage());
        }

        if($acsResponse->Code == "OK"){
            static::saveCode($phone,static::$code);
            return true;
        }
        Log::write(__METHOD__ ."第".__LINE__."行".json_encode($acsResponse));
        return false;
    }

    /**验证验证码是否正确
     * @param $phone
     * @param $code
     * @return bool
     */
    public static function check($phone,$code){
        if(empty($phone)){
            return false;
        }
        if(Cache::get($phone) == $code){
            return true;
        }else{
            return false;
        }
    }



    /**写入缓存
     * @param $phone
     * @param $code
     */
    private static function saveCode($phone,$code){
        Cache::set($phone,$code,static::$identify_time);
    }


    /**获取授权服务
     * @return mixed
     */
    private static function getAcsClient() {
        //产品名称:云通信短信服务API产品,开发者无需替换
        $product = "Dysmsapi";

        //产品域名,开发者无需替换
        $domain = "dysmsapi.aliyuncs.com";

        // TODO 此处需要替换成开发者自己的AK (https://ak-console.aliyun.com/)
        $accessKeyId = static::$ak; // AccessKeyId

        $accessKeySecret = static::$sk; // AccessKeySecret

        // 暂时不支持多Region
        $region = "cn-hangzhou";

        // 服务结点
        $endPointName = "cn-hangzhou";


        if(static::$acsClient == null) {

            //初始化acsClient,暂不支持region化
            $profile = DefaultProfile::getProfile($region, $accessKeyId, $accessKeySecret);

            // 增加服务结点
            DefaultProfile::addEndpoint($endPointName, $region, $product, $domain);

            // 初始化AcsClient用于发起请求
            static::$acsClient = new DefaultAcsClient($profile);
        }
        return static::$acsClient;
    }
}
