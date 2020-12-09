<?php
namespace fuyuezhen\wxuser\config;
/** 
* 微信接口地址
* @author fuyuezhen <976066889@qq.com>
* @created 2020-12-09
*/ 
class UrlConfig{
    // 获取用户code地址
    const OAUTH_GETCODE_URL   = "https://open.weixin.qq.com/connect/oauth2/authorize?";
    // 获取OpenId 与 Token url
    const OAUTH_GETTOKEN_URL  = "https://api.weixin.qq.com/sns/oauth2/access_token?";
    // 拉取用户信息(需scope为 snsapi_userinfo)
    const SNSAPI_USERINFO_URL = "https://api.weixin.qq.com/sns/userinfo?";
    // 获取用户基本信息（包括UnionID机制）
    const BIN_USERINFO_URL    = "https://api.weixin.qq.com/cgi-bin/user/info?";
}
