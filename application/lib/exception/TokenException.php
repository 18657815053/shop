<?php
/**
 * Created by PhpStorm.
 * User: lxj
 * Date: 2019/9/30
 * Time: 12:34
 */

namespace app\lib\exception;


class TokenException extends BaseException
{
    public $code = 401;
    public $msg = 'Toekn已过期或无效Token';
    public $errorCode = 10001;
}