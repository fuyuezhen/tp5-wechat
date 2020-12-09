<?php
namespace fuyuezhen\wxuser;

use fuyuezhen\wxuser\util\Cached;
use fuyuezhen\wxuser\config\UrlConfig;

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

    /** 
    * 构造函数
    * @author 小镇 <976066889@qq.com>
    * @param string $appid 开发者ID
    * @param string $secret 开发者密钥
    * @param string $scope 登陆方式
    * @created 2020-12-09
    * @return void
    */ 
    public function __construct($appid = '', $secret = '', $scope = '')
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
    }

    /**
     * 微信登录
     * @return array 微信用户信息
     */
    public function login()
    {
        // 获取code
        $this->getCode();
        
        echo $this->code;
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
        // $oldcode = Cached::getCode(); // code 缓存
        // 如果当前code 是失效的code,就会重新获取
        if(empty($this->code)){
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
        request()->withGet(['test222' => $this->state]);

        echo request()->get('test222');
        // echo $this->state;
        echo "<br>";
        return $this->code;
    }
}