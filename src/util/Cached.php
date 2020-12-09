<?php
namespace fuyuezhen\wxuser\util;

/** 
* 缓存类
* @author fuyuezhen <976066889@qq.com>
* @created 2020-12-09
*/ 
class Cached
{
    // 微信code 凭证 缓存，防止code失效后刷新页面出错
    const OAUTH_CODE_SESSION     = "OAUTH_CODE_SESSION";

    // 微信信息 缓存
    const WECHAT_SESSION_SESSION = "WECHAT_SESSION_SESSION";

    /**
     * ============================================================ 微信信息 ===========================================================
     */
    /**
     * 设置微信信息缓存
     * @param string $value 缓存内容
     * @return void
     */
    public static function setSessionInfo($value){
        self::setSession(self::WECHAT_SESSION_SESSION, $value);
    }

    /**
     * 获取微信信息缓存
     * @return array
     */
    public static function getSessionInfo(){
        return self::getSession(self::WECHAT_SESSION_SESSION);
    }

    /**
     * ============================================================ 微信登陆 code ===========================================================
     */
    /**
     * 设置微信 code 凭证缓存
     * @param string $value 缓存内容
     * @return void
     */
    public static function setCode($value){
        self::setSession(self::OAUTH_CODE_SESSION, $value);
    }

    /**
     * 获取微信 code 凭证缓存
     * @return string
     */
    public static function getCode(){
        return self::getSession(self::OAUTH_CODE_SESSION);
    }

    /**
     * ============================================================ Session缓存 ===========================================================
     */
    /**
     * 获取Session缓存
     * @param [type] $key
     * @return void
     */
    public static function getSession($key)
    {
        return Session::get($key.$this->appid);
    }
    /**
     * 设置Session缓存
     * @param [type] $key
     * @param [type] $value
     * @return void
     */
    public static function setSession($key, $value)
    {
        return Session::set($key.$this->appid, $value);
    }
}