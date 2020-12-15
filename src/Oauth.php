<?php
namespace fuyuezhen\wechat;

use fuyuezhen\wechat\util\Cached;
use fuyuezhen\wechat\util\Request;
use fuyuezhen\wechat\config\UrlConfig;

/** 
* 微信登录
* @author fuyuezhen <976066889@qq.com>
* @created 2020-12-09
*/ 
class Oauth
{
    // 开发者ID
    private $appid;  
    // 开发者密钥
    private $secret; 
    // 登陆方式：静默授权snsapi_base 或者 确认授权snsapi_userinfo
    private $scope = 'snsapi_base'; 
    // 微信登陆code
    private $code  = ''; 
    // 获取用户信息：0基础用户信息，1只获取OpenId
    private $userinfo_type  = 0; 

    /** 
    * 构造函数
    * @param string $appid   开发者ID
    * @param string $secret 开发者密钥
    * @param string $scope  登陆方式
    * @param string $userinfo_type 获取用户信息
    * @return void
    */ 
    public function __construct($appid = '', $secret = '', $scope = '', $userinfo_type = '')
    {
        if (!empty($appid)) {
            $this->appid   = $appid;
        }
        if (!empty($secret)) {
            $this->secret   = $secret;
        }
        if (!empty($scope)) {
            $this->scope   = $scope;
        }
        if (!empty($userinfo_type)) {
            $this->userinfo_type   = $userinfo_type;
        }
    }

    /**
     * 微信登录
     * @return array 微信用户信息
     */
    public function login()
    {
        // 获取code
        $this->getCode();
        // 获取openid
        $this->getOpenId();
        // 获取用户信息
        if (empty($this->userinfo_type)) {
            $userinfo = $this->getUserInfo();
        } else {
            $userinfo['openid'] = $this->openid;
        }
        // 清除code缓存
        // Cached::setCode(null);

        return $userinfo;
    }

    /**
     * 获取code
     * @return string
     */
    private function getCode()
    {
        // 读取微信返回的code
        $this->code  = request()->param('code', '');
        // 因为回调url只能放一个参数，所以用state存放参数，最后在格式化处理
        $this->state = request()->param('state', '');
        // code 缓存
        $oldcode = Cached::getCode(); 
        // 如果当前code 是失效的code,就会重新获取
        if (empty($this->code) || (!empty($oldcode) && $oldcode == $this->code)) {
            $options = [
                'appid'         => $this->appid,
                'redirect_uri'  => request()->baseUrl(true),
                'response_type' => 'code',
                'state'         => "123",
                'scope'         => $this->scope
            ];
            $url = UrlConfig::OAUTH_GETCODE_URL . http_build_query($options) . "#wechat_redirect";
            header('Location:' . $url);
            exit;
        }
        return $this->code;
    }

    /**
     * 获取用户OpenId
     * @return void
     */
    public function getOpenId()
    {        
        // 获取OpenId 与 token
        $options = [ 
            'appid'  => $this->appid, 
            'secret' => $this->secret, 
            'code'   => $this->code, 
            'grant_type'=>'authorization_code' 
        ];
        $url    = UrlConfig::OAUTH_GETTOKEN_URL . http_build_query($options);
        $result = Request::curl($url);
        // 设置code 缓存
        Cached::setCode($this->code);
        if(isset($result['errcode'])){
            // 登陆失败
            $this->jsAlert(json_encode($result));
        }
        $this->access_token = $result['access_token'];
        $this->openid       = $result['openid'];
        return $result;
    }

    /**
     * 获取用户信息
     * @return void
     */
    public function getUserInfo()
    {
        $options = [
            'access_token'  => $this->access_token,
            'openid'        => $this->openid,
            'lang'=>'zh_CN'
        ];

        $url    = UrlConfig::SNSAPI_USERINFO_URL . http_build_query($options);
        $result = Request::curl($url);
        if(isset($result['errcode'])){
            $this->jsAlert(\json_encode($result));
        }
        return $result;
    }

    /**
     * js弹窗
     * @param string $msg
     * @return void
     */
    function jsAlert($msg = '')
    {
        echo "<script>window.alert = function(name){
            var iframe = document.createElement('IFRAME');
            iframe.style.display='none';
            iframe.setAttribute('src', 'data:text/plain,');
            document.documentElement.appendChild(iframe);
            window.frames[0].window.alert(name);
            iframe.parentNode.removeChild(iframe);
        };alert('".$msg."');</script>";
        exit;
    }
}