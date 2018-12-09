#用户表
create table `ent_admin_user`(
  `id` int(11) unsigned not null AUTO_INCREMENT,
  `username` varchar(50) not null DEFAULT '',
  `password` char(32) not null DEFAULT '',
  `last_login_ip` varchar(30) not null DEFAULT '',
  `last_login_time` int(10) unsigned  not null DEFAULT 0,

  `listorder` int(8) unsigned not NULL DEFAULT 0,
  `status` tinyint(1) not null DEFAULT 1,
  `create_time` int(10) unsigned NOT NULL DEFAULT 0,
  `update_time` int(10) unsigned NOT NULL DEFAULT 0,

  PRIMARY KEY(`id`),
  KEY username(`username`),
  KEY create_time(`create_time`)
)ENGINE = innoDB AUTO_INCREMENT = 1 DEFAULT charset = utf8;

#新闻表
create table `ent_news`(
  `id` int(11) unsigned not null AUTO_INCREMENT,
  `title` varchar(100) not null default '',
  `small_title` varchar(20) not null default '',
  `catid` int(8) unsigned not null default 0,
  `image` varchar(255) NOT NULL default '',
  `content` text not null default '',
  `description` varchar(200) NOT NULL default '',
  `is_position` tinyint not null default 0 COMMENT '是否加载到新闻位上',
  `is_head_figure` tinyint not null default 0 COMMENT '是否加载到首页大图上',
  `is_allow_comments` tinyint not null default 0 COMMENT '是否允许评论',
  `source_type` tinyint not null default 0 COMMENT '新闻来源',
  `create_time` int(10) not null default 0 ,
  `update_time` int(10) not null default 0,
  `status` tinyint not null default 0,
  PRIMARY KEY (`id`),
  KEY title(`title`),
  KEY catid(`catid`),
  KEY create_time(`create_time`)
)ENGINE = innoDB AUTO_INCREMENT = 1 DEFAULT charset = utf8;

#版本
create table `ent_version`(
  `id` int(11) unsigned not null AUTO_INCREMENT,
  `version` int(8) unsigned not null DEFAULT 0 COMMENT '内部版本号',
  `version_code` char(20) not null DEFAULT '' COMMENT '外部版本号',
  `app_type` varchar(20) not null DEFAULT ''COMMENT 'app型号/手机型号',
  `is_force` tinyint(10) unsigned  not null DEFAULT 0 comment '是否强制更新',
  `apk_url` varchar(255) not null DEFAULT '' COMMENT 'apk升级地址',
  `upgrade_point` varchar(500) not null DEFAULT '' COMMENT '升级提示内容',

  `status` tinyint(1) not null DEFAULT 1,
  `create_time` int(10) unsigned NOT NULL DEFAULT 0,
  `update_time` int(10) unsigned NOT NULL DEFAULT 0,

  PRIMARY KEY(`id`),
  KEY version(`version`),
  KEY app_type(`app_type`)
)ENGINE = innoDB AUTO_INCREMENT = 1 DEFAULT charset = utf8;

#机型记录
create table `ent_active`(
  `id` int(11) unsigned not null AUTO_INCREMENT,
  `version` int(8) unsigned not null DEFAULT 0 COMMENT '内部版本号',
  `version_code` char(20) not null DEFAULT '' COMMENT '外部版本号',
  `app_type` varchar(20) not null DEFAULT ''COMMENT 'app型号/手机型号',
  `did` varchar(100) not null DEFAULT '' COMMENT '设备号',
  `create_time` int(10) unsigned NOT NULL DEFAULT 0,
  `update_time` int(10) unsigned NOT NULL DEFAULT 0,
  `model` varchar(100) not null DEFAULT '' COMMENT '机型',
  PRIMARY KEY(`id`),
  KEY version(`version`),
  KEY app_type(`app_type`)
)ENGINE = innoDB AUTO_INCREMENT = 1 DEFAULT charset = utf8;

#用户表
#会员表
CREATE TABLE `ent_user`(
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL DEFAULT '',
  `password` char(32) NOT NULL DEFAULT '',
  `code` varchar(10) NOT NULL DEFAULT '',
  `phone` varchar(20) NOT NULL DEFAULT '',
  `timeout` int(10) NOT NULL DEFAULT 0,
  `sex` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0是男，1是女',
  `token` varchar(100) NOT NULL DEFAULT '',
  `image` varchar(100) NOT NULL DEFAULT '',
  `signature` varchar(100) NOT NULL DEFAULT '' COMMENT '个性签名',
  `last_login_time` int(11) NOT NULL DEFAULT 0,

  `status` tinyint(1) NOT NULL DEFAULT 0,
  `create_time` int(11) NOT NULL DEFAULT 0,
  `update_time` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY username(`username`),
  UNIQUE KEY phone(`phone`)
)ENGINE = innoDB AUTO_INCREMENT = 1 DEFAULT charset = utf8;

#点赞关联表
CREATE TABLE `ent_user_news`(
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `news_id` int(11) unsigned NOT NULL DEFAULT 0,
  `user_id` int(11) unsigned NOT NULL DEFAULT 0,
  `create_time` int(11) NOT NULL DEFAULT 0,

  PRIMARY KEY (`id`),
  KEY new_id(`news_id`),
  KEY user_id(`user_id`)
)ENGINE = innoDB AUTO_INCREMENT = 1 DEFAULT charset = utf8;

#评论关联表
CREATE TABLE `ent_comments`(
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `news_id` int(11) unsigned NOT NULL DEFAULT 0,
  `user_id` int(11) unsigned NOT NULL DEFAULT 0,
  `content` varchar(300) not null DEFAULT '',
  `to_user_id`int(11) unsigned NOT NULL DEFAULT 0 COMMENT '回复用户',
  `parent_id` int(11) unsigned NOT NULL DEFAULT 0 COMMENT '评论id',

  `status` tinyint(1) NOT NULL DEFAULT 0,
  `create_time` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY new_id(`news_id`),
  KEY user_id(`user_id`)
)ENGINE = innoDB AUTO_INCREMENT = 1 DEFAULT charset = utf8;

