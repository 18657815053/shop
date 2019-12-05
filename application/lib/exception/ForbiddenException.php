<?php
/**
 * Created by PhpStorm.
 * User: lxj
 * Date: 2019/10/8
 * Time: 18:56
 */

namespace app\lib\exception;


class ForbiddenException extends BaseException
{
    public $code = 403;
    public $msg = '权限不够';
    public $errorCode = 10001;
}