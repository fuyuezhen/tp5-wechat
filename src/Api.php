<?php
namespace fuyuezhen\wechat;

use fuyuezhen\wechat\util\Cached;
use fuyuezhen\wechat\util\Request;
use fuyuezhen\wechat\config\UrlConfig;

/** 
* 微信Api
* @author fuyuezhen <976066889@qq.com>
* @created 2020-12-10
*/ 
class Api
{
    /**
     * 获取用户信息
     * @return void
     */
    public static function getUserInfo($openid, $access_token)
    {
        $options = [
            'access_token'  => $access_token,
            'openid'        => $openid,
            'lang'=>'zh_CN'
        ];

        $url  = UrlConfig::BIN_USERINFO_URL . http_build_query($options);
        $info = Request::curl($url);
        if(isset($info['errcode'])){
            jsAlert(\json_encode($info), false);
        }
        return $info;
    }
}