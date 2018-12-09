<?php
/**
 * Created by PhpStorm.
 * User: xjyplayer
 * Date: 2018/11/9
 * Time: 15:13
 */

namespace app\bis\controller;

use think\Controller;

class Register extends Controller
{
    private $cityModel;
    private $categoryModel;
    private $bisModel;
    private $locationModel;
    private $accountModel;

    public function _initialize()
    {
        $this -> cityModel = model('common/City');     //需要使用的model
        $this -> categoryModel = model('common/Category');
        $this->bisModel = model('common/Bis');
        $this->locationModel = model('common/BisLocation');
        $this->accountModel = model('common/BisAccount');
    }

    public function index()
    {
        $firstLevelCitys = $this->cityModel ->getNormalFirstLevel();
        $firstLevelCategorys = $this->categoryModel ->getNormalFirstCategory();
        return $this -> fetch('',[
            'firstLevelCitys' => $firstLevelCitys,
            'firstLevelCategorys' => $firstLevelCategorys
        ]);
    }

    public function add(){
        //验证传递方式
        if(!request()->isPost()){
            $this->error("提交方式必须为post");
        }
        $data = request()->post();
        //验证数据内容
        $validate = validate('bis');
        if(!$validate -> scene('basic') ->check($data)){
            $this->error($validate->getError());
        }else if(!$validate -> scene('home') ->check($data)){
            $this->error($validate->getError());
        }else if(!$validate -> scene('user') ->check($data)){
            $this->error($validate->getError());
        }
        //规范化数据
        //获取经纬度
        $lnglat = \Map::getLngLat($data['address']);
        //经纬度校验
        if(empty($lnglat)
            || $lnglat['status'] != 0               //返回不成功
            || $lnglat['result']['precise'] != 1    //不是靳准匹配
        ){
            $this->error('地址解析错误');
        }


        //基本信息入库
        $bisdata = [
            'name' => $data['name'],
            'email' => $data['email'],
            'logo' => $data['logo'],
            'licence_logo' => $data['licence_logo'],
            'description' => empty($data['description']) ? '' : $data['description'],
            'city_id' => $data['city_id'],
            'city_path'   => empty($data['se_city_id']) ? $data['city_id'] : $data['city_id'].",".$data['se_city_id'],
            'bank_info'  =>  $data['bank_info'],
            'bank_user'  =>  $data['bank_user'],
            'bank_name' => $data['bank_name'],
            'faren' => $data['faren'],
            'faren_tel' => $data['faren_tel'],
        ];
        $bisID = $this->bisModel->add($bisdata);
        //总店信息入库
//        return json_encode($data);

        $cate = '';
        if(!empty($data['se_category_id'])){
            $cate = '|';
            $cate .= implode('|',$data['se_category_id']);
        }

        $locationData = [
            'name' => $data['name'],
            'logo' => $data['logo'],
            'address' => $data['address'],
            'tel' => $data['tel'],
            'contract' => $data['contract'],
            'city_id' => $data['city_id'],
            'city_path'   => empty($data['se_city_id']) ? $data['city_id'] : $data['city_id'].",".$data['se_city_id'],
            'xpoint' => empty($lnglat['result']['location']['lng']) ? '' : $lnglat['result']['location']['lng'],
            'ypoint' => empty($lnglat['result']['location']['lat']) ? '' : $lnglat['result']['location']['lat'],
            'bis_id' => $bisID,
            'content' => empty($data['content']) ? '' : $data['content'],
            'is_main' => 1,
            'api_address' => '',
            'category_id' => $data['category_id'],
            'category_path' => $data['category_id'].$cate,
            'preview' => $data['open_time'],
        ];

        $locationID = $this->locationModel->add($locationData);

        /*
         *  账号入库
         */
        $code = mt_rand(100,1000);
        $userData = [
            'username' => $data['username'],
            'password' => md5($data['password'].$code),
            'code' => $code,
            'bis_id' => $bisID,
            'is_main' => 1,
        ];

        $userID = $this-> accountModel ->add($userData);

        if($bisID && $locationID && $userID == false){
            $this->error('申请失败');
        }

        //发送邮件
        $url = request()->domain().url('bis/register/waiting',['id' => $bisID]);
        $title = 'o2o申请通知';
        $content =  '您提交的链接需等待审核,您可以通过点击链接'.'<a href = "'.$url.'" target = "_blank" >查看链接</a> 查看审核状态';
        $sendee_email = $data['email'];
        $res = \phpmailer\Email::sendMsg($sendee_email,$title,$content);
        if($res === true){
            $this->success("提交成功，请去邮箱查看" , url('register/waiting',['id' => $bisID]));
        }else if($res){
            $this->error($res);
        }else{
            $this->error('邮件发送错误');
        }
    }

    public function waiting(){
        //验证传递方式
        if(!request()->isget()){
            $this->error("提交方式必须为get");
        }
        $bis_id = request()->get('id');
        $bisInfo = $this->bisModel ->get($bis_id);
        return $this->fetch(
            '',
            ['bisInfo' => $bisInfo]
        );
    }

}