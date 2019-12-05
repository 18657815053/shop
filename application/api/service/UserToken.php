<?php
/**
 * Created by PhpStorm.
 * User: lxj
 * Date: 2019/9/29
 * Time: 21:45
 */

namespace app\api\service;


use app\api\model\User;
use app\lib\enum\ScopeEnum;
use app\lib\exception\TokenException;
use app\lib\exception\WxExcption;
use think\Exception;
use app\api\model\User as UserModel;

class UserToken extends Token
{
    protected $code;
    protected $appID;
    protected $appSecret;
    protected $loginUrl;

    /*
     * 构造函数
     * 构造loginUrl
     */
    function __construct($code)
    {
        $this->code = $code;
        $this->appID = config('wx.app_id');
        $this->appSecret = config('wx.app_secret');
        $this->loginUrl = sprintf(config('wx.login_url'),
            $this->appID, $this->appSecret, $this->code);
    }

    public function get()
    {
        $result = curl_get($this->loginUrl);
        $wxResult = json_decode($result, true);
        if (empty($wxResult)) {
            throw new Exception('获取session_key与openID时发生异常,微信内部错误');
        }
        else {
            $loginFail = array_key_exists('errcode', $wxResult);
            if ($loginFail) {
                //校验微信返回的数组是否有errcode
                $this->processLoginError($wxResult);
            }
            else {
                return $this->grantToken($wxResult);
            }
        }
    }

    /*
     * 生成Token令牌
     * @param array $wxResult 调用微信接口返回内容
     */
    private function grantToken($wxResult)
    {
        $openid = $wxResult['openid'];
        $user = UserModel::getByOpenID($openid);
        if ($user) {
            $uid = $user->id;
        }
        else {
            $uid = $this->newUser($openid);
        }
        $cachedValue = $this->prepareCachedValue($wxResult, $uid);
        $token = $this->saveToCache($cachedValue);

        return $token;
    }

    /*
     * 将cachedValue存入缓存
     */
    private function saveToCache($cachedValue)
    {
        $key = self::generateToken();
        $value = json_encode($cachedValue);
        $expire_time = config('setting.token_expire_time');

        $request = cache($key, $value, $expire_time);
        if (!$request) {
            throw new TokenException([
                'msg' => '服务器缓存异常',
                'errorCode' => 10005
            ]);
        }

        return $key;
    }


    /*
     * 将微信返回数组与user_id重构成一个数组
     */
    private function prepareCachedValue($wxResult, $uid)
    {
        $arr = $wxResult;
        $arr['uid'] = $uid;
        //scope=16 APP用户权限的数值
        $arr['scope'] = ScopeEnum::User;
        return $arr;
    }

    /*
     * 新增一条user记录
     */
    private function newUser($openid)
    {
        $user = UserModel::create([
            'openid' => $openid,
        ]);

        return $user->id;
    }

    /*
     * 调用微信接口异常抛出
     * @param array $wxResult 调用微信接口返回内容
     */
    private function processLoginError($wxResult)
    {
        throw new WxExcption([
            'msg' => $wxResult['errmsg'],
            'errorCode' => $wxResult['errcode'],
        ]);
    }
}