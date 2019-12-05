<?php
/**
 * Created by PhpStorm.
 * User: lxj
 * Date: 2019/9/27
 * Time: 19:53
 */

namespace app\lib\exception;


use think\Exception;

/*
 * 异常处理基类
 */

class BaseException extends Exception
{
    public $code = 400;//Http状态码 200,404,500
    public $msg = '参数错误';//具体错误信息
    public $errorCode = 10000;//自定义状态码

    public function __construct($params = [])
    {
        if (!is_array($params)) {
            return;
        }
        if (array_key_exists('code', $params)) {
            $this->code = $params['code'];
        }
        if (array_key_exists('msg', $params)) {
            $this->msg = $params['msg'];
        }
        if (array_key_exists('errorCode', $params)) {
            $this->errorCode = $params['errorCode'];
        }
    }
}