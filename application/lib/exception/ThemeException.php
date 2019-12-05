<?php
/**
 * Created by PhpStorm.
 * User: lxj
 * Date: 2019/9/29
 * Time: 16:16
 */

namespace app\lib\exception;


class ThemeException extends BaseException
{
    public $code = 404;
    public $msg = '请求的主题不存在,请检查ID';
    public $errorCode = 30000;
}