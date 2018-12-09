<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use \think\Route;
//单项设置可以直接设置对应哪个方法
Route::get('test','api/test/get');
Route::put("test/:id",'api/test/update');
Route::delete("test/:id",'api/test/delete');
Route::post('test','api/test/post');
//news
//导航栏数据
Route::get("news/:ver/cat","api/:ver.cat/read");
//主页推荐
Route::get("news/:ver/index","api/:ver.index/index");
//排行
Route::get("news/:ver/rank","api/:ver.rank/read");
//app初始化
Route::get("news/:ver/init","api/:ver.version/read");
//手机验证码发送
Route::post("news/:ver/indentify","api/:ver.indentify/save");
//图片上传
Route::post("news/:ver/imageupload","api/:ver.image/save");
//用户名查重
Route::get("news/:ver/usernamecheck","api/:ver.user/checkUsername");
//用户登陆
Route::post("news/:ver/login","api/:ver.login/save");
//用户设置
Route::post('news/:ver/settings',"api/:ver.User/save");
//获取用户信息
Route::post('news/:ver/user',"api/:ver.User/read");
//修改用户信息
Route::put('news/:ver/userupdate',"api/:ver.User/update");
//点赞状态查询
Route::get('news/:ver/upvotecondition',"api/:ver.upvote/read");
//点赞数据查询
Route::get('news/:ver/getUpvote',"api/:ver.upvote/getUpvote");
//点赞或者取消点赞
Route::put('news/:ver/upvote',"api/:ver.upvote/update");
//评论
Route::post('news/:ver/comment',"api/:ver.comment/save");
//评论获得
Route::get("news/:ver/commentList","api/:ver.commentList/read");
//新闻详情页
Route::get("news/:ver/detail/:id","api/:ver.detail/read");
//栏目
Route::get("news/:ver/:catid","api/:ver.news/read");


