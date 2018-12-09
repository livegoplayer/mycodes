<?php
/**
 * Created by PhpStorm.
 * User: xjyplayer
 * Date: 2018/11/6
 * Time: 10:48
 */
namespace app\admin\controller;
//use \PHPMailer\PHPMailer\Email;
use think\Controller;
class Test extends Controller
{

    public function index()
    {
        echo $this->sendMsg();
        return $this -> fetch();
    }

    public function staticImage(){
        $src = \Map::getStaticImage('北京昌平沙河地铁');
        return $src;
    }

    public function sendMsg(){
        $sendee_email = '2532917800@qq.com';
        $sendee_name = 'xjyplayer';
        $msg = '问候';
        if(\phpmailer\Email::sendMsg($sendee_email,$sendee_name,$msg)){
            return '邮件发送成功！';
        }else{
            return '邮件发送失败';
        }
    }
}