 CREATE TABLE `tp_wechat` (
  `wechat_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `subscribe` tinyint(1) DEFAULT '0' COMMENT '是否关注',
  `openid` varchar(255) NOT NULL COMMENT '用户OpenID',
  `code` varchar(255) DEFAULT NULL COMMENT '加密字符',
  `device` text COMMENT '设备',
  `client_ip` varchar(255) DEFAULT NULL COMMENT 'IP',
  `client_id_ddress` varchar(255) DEFAULT NULL COMMENT '根据ip获得访客所在地地名',
  `get_browser` varchar(200) DEFAULT NULL COMMENT '获得访客浏览器类型',
  `get_lang` varchar(200) DEFAULT NULL COMMENT '获得访客浏览器语言',
  `nickname` varchar(255) DEFAULT NULL COMMENT '昵称',
  `nickname_base64` varchar(255) DEFAULT NULL,
  `sex` tinyint(1) unsigned DEFAULT NULL COMMENT '1男，2女，0未知',
  `language` varchar(255) DEFAULT NULL COMMENT '语言',
  `city` varchar(255) DEFAULT NULL COMMENT '城市',
  `province` varchar(255) DEFAULT NULL COMMENT '国家',
  `country` varchar(255) DEFAULT NULL COMMENT '省份',
  `headimgurl` text COMMENT '头像',
  `headimgurl_wechat` text COMMENT '微信头像',
  `subscribe_time` int(10) unsigned DEFAULT NULL COMMENT '关注时间',
  `privilege` text COMMENT '用户特权信息，json 数组',
  `remark` varchar(255) DEFAULT NULL COMMENT '公众号对粉丝备注',
  `groupid` int(10) unsigned DEFAULT NULL COMMENT '分组ID',
  `subscribe_scene` varchar(100) DEFAULT NULL,
  `qr_scene` int(11) DEFAULT NULL,
  `qr_scene_str` varchar(100) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  `delete_time` datetime DEFAULT NULL COMMENT '软删除：null正常',
  PRIMARY KEY (`wechat_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='微信用户表';