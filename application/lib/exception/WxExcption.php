<?php
/**
 * Created by PhpStorm.
 * User: lxj
 * Date: 2019/9/29
 * Time: 22:42
 */

namespace app\lib\exception;


class WxExcption extends BaseException
{
    public $code = 400;
    public $msg = '调用微信服务器接口异常';
    public $errorCode = 999;
}