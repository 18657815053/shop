<?php
/**
 * Created by PhpStorm.
 * User: lxj
 * Date: 2019/9/30
 * Time: 11:50
 */

namespace app\api\service;


use app\lib\enum\ScopeEnum;
use app\lib\exception\ForbiddenException;
use app\lib\exception\TokenException;
use think\Cache;
use think\Exception;
use think\Request;

class Token
{
    public static function generateToken()
    {
        //用3组字符串,进行md5加密
        //生成一个32位的随机字符串
        $randChars = getRandChars(32);
        //时间戳
        $timestamp = $_SERVER['REQUEST_TIME_FLOAT'];
        //盐
        $salt = config('secure.token_salt');
        return md5($randChars . $timestamp . $salt);
    }

    /*
     * 根据Token获取用户信息
     *@param $key 需要获取的内容  可选 openid,Uid,scope,session_key
     */
    public static function getCurrentTokenVar($key)
    {
        $token = Request::instance()
            ->header('token');
        $vars = Cache::get($token);
        if (!$vars) {
            throw new TokenException();
        }
        else {
            if (!is_array($vars)) {
                $vars = json_decode($vars, true);
            }
            if (array_key_exists($key, $vars)) {
                return $vars[$key];
            }
            else {
                throw new Exception('尝试获取的Token变量不存在');
            }
        }

    }

    public static function getCurrentUid()
    {
        $uid = self::getCurrentTokenVar('uid');
        return $uid;
    }

    /*
     * 用户及管理员权限   两者都可访问
     */
    public static function needPrimarySope()
    {
        $scope = self::getCurrentTokenVar('scope');
        if ($scope) {
            if ($scope >= ScopeEnum::User) {
                return true;
            }
            else {
                throw new ForbiddenException();
            }
        }
        else {
            throw new TokenException();
        }
    }

    /*
     * 用户权限   仅用户可访问
     */
    public static function needExclusiveScope()
    {
        $scope = self::getCurrentTokenVar('scope');
        if ($scope) {
            if ($scope == ScopeEnum::User) {
                return true;
            }
            else {
                throw new ForbiddenException();
            }
        }
        else {
            throw new TokenException();
        }
    }

}