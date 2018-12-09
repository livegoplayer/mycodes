#生活服务分类表
CREATE TABLE `o2o_category`(
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `parent_id` int(10) unsigned NOT NULL DEFAULT 0,
  `listorder` int(8) unsigned NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `create_time` int(11) NOT NULL DEFAULT 0,
  `update_time` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY parent_id(`parent_id`)
)ENGINE = innoDB AUTO_INCREMENT = 1 DEFAULT charset = utf8;

#城市表
CREATE TABLE `o2o_city`(
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `uname` varchar(50) NOT NULL DEFAULT '',
  `parent_id` int(10) unsigned NOT NULL DEFAULT 0,
  `listorder` int(8) unsigned NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `create_time` int(11) NOT NULL DEFAULT 0,
  `update_time` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY parent_id(`parent_id`),
  UNIQUE KEY uname(`uname`)
)ENGINE = innoDB AUTO_INCREMENT = 1 DEFAULT charset = utf8;

#商圈表
CREATE TABLE `o2o_area`(
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `city_id` int(11) unsigned NOT NULL DEFAULT 0,
  `parent_id` int(10) unsigned NOT NULL DEFAULT 0,
  `listorder` int(8) unsigned NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `create_time` int(11) NOT NULL DEFAULT 0,
  `update_time` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY parent_id(`parent_id`),
  UNIQUE KEY city_id(`city_id`)
)ENGINE = innoDB AUTO_INCREMENT = 1 DEFAULT charset = utf8;

#商户表
CREATE TABLE `o2o_bis`(
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `email` varchar(50) NOT NULL DEFAULT '',
  `logo` varchar(255) NOT NULL DEFAULT '',
  `licence_logo` varchar(255) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `city_id` int(11) unsigned NOT NULL DEFAULT 0,
  `city_path` varchar(50) NOT NULL DEFAULT '',
  `bank_info` varchar(50) NOT NULL DEFAULT '',
  `bank_name` varchar(50) NOT NULL DEFAULT '',
  `bank_user` varchar(50) NOT NULL DEFAULT '',
  `faren` varchar(50) NOT NULL DEFAULT '',
  `faren_tel` varchar(50) NOT NULL DEFAULT '',
  `money` decimal(20,2) NOT NULL DEFAULT 0.00,
  `listorder` int(8) unsigned NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `create_time` int(11) NOT NULL DEFAULT 0,
  `update_time` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY name(`name`)
)ENGINE = innoDB AUTO_INCREMENT = 1 DEFAULT charset = utf8;

#商户账号表
CREATE TABLE o2o_bis_account(
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL DEFAULT '',
  `password` char(32) NOT NULL DEFAULT '',
  `code` varchar(10) NOT NULL DEFAULT '',
  `bis_id` int(11) unsigned NOT NULL DEFAULT 0,
  `last_login_ip` varchar(20) NOT NULL DEFAULT '',
  `last_login_time` int(11) NOT NULL DEFAULT 0,
  `is_main` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `listorder` int(8) unsigned NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `create_time` int(11) NOT NULL DEFAULT 0,
  `update_time` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY bis_id(`bis_id`),
  KEY username('username')
)ENGINE = innoDB AUTO_INCREMENT = 1 DEFAULT charset = utf8;

#商户门店表
CREATE TABLE `o2o_bis_location`(
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `logo` varchar(255) NOT NULL DEFAULT '',
  `address` text NOT NULL,
  `tel` varchar(20) NOT NULL DEFAULT '',
  `contract` varchar(20) NOT NULL DEFAULT '',
  `city-id` int(11) unsigned NOT NULL DEFAULT 0,
  `city_path` varchar(50) NOT NULL DEFAULT '',
  `xpoint` varchar(20) NOT NULL DEFAULT '',
  `ypoint` varchar(20) NOT NULL DEFAULT '',
  `bis_id` int(11) unsigned NOT NULL DEFAULT 0,
  `content` text NOT NULL,     #门店介绍
  `is_main` tinyint(1) unsigned NOT NULL DEFAULT 0 COMMENT '是否为总店',
  `category_id` int(11) unsigned NOT NULL DEFAULT 0,
  `category_path` varchar(50)  NOT NULL DEFAULT '',
  `preview` varchar() NOT NULL DEFAULT '',
  `listorder` int(8) unsigned NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `create_time` int(11) NOT NULL DEFAULT 0,
  `update_time` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY bis_id(`bis_id`),
  KEY category_id(category_id),
  KEY name(`name`)
)ENGINE = innoDB AUTO_INCREMENT = 1 DEFAULT charset = utf8;

#团购商品表
CREATE TABLE `o2o_deal`(
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '',
  `category_id` int(11) unsigned NOT NULL DEFAULT 0,
  `se_category_id` char(40)  NOT NULL DEFAULT '',
  `bis_id` int(11) unsigned NOT NULL DEFAULT 0,
  `location_ids` varchar(100) NOT NULL DEFAULT '',
  `image` varchar(100) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `start_time` int(11) NOT NULL DEFAULT 0,
  `end_time` int(11) NOT NULL DEFAULT 0,
  `origin_price` decimal(20,2) NOT NULL DEFAULT 0.00,
  `current_price` decimal(20,2) NOT NULL DEFAULT 0.00,
  `coupons_start_price` decimal(20,2) NOT NULL DEFAULT 0.00 COMMENT   '团购优惠券相关开始时间',
  `coupons_end_price` decimal(20,2) NOT NULL DEFAULT 0.00 COMMENT '团购优惠券相关结束时间',
  `city_id` int(11) unsigned NOT NULL DEFAULT 0,
  `se_city_id`  char(40) NOT NULL DEFAULT '',
  `buy_count` int(11) unsigned NOT NULL DEFAULT 0,
  `total_count` int(11) unsigned NOT NULL DEFAULT 0,
  `xpoint` varchar(20) NOT NULL DEFAULT '',
  `ypoint` varchar(20) NOT NULL DEFAULT '',
  `bis_count_id` int(11) unsigned NOT NULL DEFAULT 0,
  `balance_price` decimal(20,2) NOT NULL DEFAULT 0.00,
  `notes` text NOT NULL,
  `listorder` int(8) unsigned NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `create_time` int(11) NOT NULL DEFAULT 0,
  `update_time` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY category_id(`category_id`),
  KEY se_category_id(`se_category_id`),
  KEY city_id(`city_id`),
  KEY start_time(`start_time`),
  KEY end_time(`end_time`),
  KEY create_time(`create_time`)
)ENGINE = innoDB AUTO_INCREMENT = 1 DEFAULT charset = utf8;

#会员表
CREATE TABLE `o2o_user`(
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL DEFAULT '',
  `password` char(32) NOT NULL DEFAULT '',
  `email`  varchar(30) NOT NULL DEFAULT '',
  `code` varchar(10) NOT NULL DEFAULT '',
  `mobile` varchar(20) NOT NULL DEFAULT '',
  `last_login_ip` varchar(20) NOT NULL DEFAULT '',
  `last_login_time` int(11) NOT NULL DEFAULT 0,
  `listorder` int(8) unsigned NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `create_time` int(11) NOT NULL DEFAULT 0,
  `update_time` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY username(`username`),
  UNIQUE KEY email(`email`)
)ENGINE = innoDB AUTO_INCREMENT = 1 DEFAULT charset = utf8;

#推荐位表
CREATE TABLE `o2o_featured`(
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(20) NOT NULL DEFAULT 0,
  `title`  varchar(30) NOT NULL DEFAULT '',
  `image`  varchar(255) NOT NULL DEFAULT '',
  `url`  varchar(255) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL,
  `listorder` int(8) unsigned NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `create_time` int(11) NOT NULL DEFAULT 0,
  `update_time` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
)ENGINE = innoDB AUTO_INCREMENT = 1 DEFAULT charset = utf8;

#订单表
CREATE TABLE `o2o_order`(
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `out_trade_no` varchar(100) NOT NULL DEFAULT '' COMMENT '订单编号',
  `transaction_id` varchar(100) NOT NULL DEFAULT '' COMMENT '支付单号',
  `user_id` int(11) unsigned NOT NULL DEFAULT 0,
  `username` varchar(20) NOT NULL DEFAULT '' ,
  `pay_time` varchar(20) NOT NULL DEFAULT '',
  `payment_id` tinyint(1) NOT NULL DEFAULT 1 COMMENT '支付方式 1代表微信支付 2代表支付宝支付',
  `deal_id` int(11) unsigned NOT NULL DEFAULT 0 ,
  `deal_count` int(11) unsigned NOT NULL DEFAULT 0,
  `pay_status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '支付状态 0代表待支付 1代表已支付 2支付失败 ',
  `total_price` decimal(20,2) NOT NULL DEFAULT 0.00 COMMENT '支付总额',
  `pay_amount` decimal(20,2) NOT NULL DEFAULT 0.00 COMMENT '微信支付总额',
  `referer` varchar(255) NOT NULL DEFAULT '' COMMENT '订单来路',
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '默认给1',
  `create_time` int(11) NOT NULL DEFAULT 0,
  `update_time` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `out_trade_no`(`out_trade_no`),
  KEY `user_id`(`user_id`),
  KEY `create_time`(`create_time`)
)ENGINE = innoDB AUTO_INCREMENT = 1 DEFAULT charset = utf8;