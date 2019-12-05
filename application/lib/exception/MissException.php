<?php
/**
 * Created by PhpStorm.
 * User: lxj
 * Date: 2019/9/27
 * Time: 19:58
 */

namespace app\lib\exception;

/*
 * 数据不存在
 * 通常在查询的数据为空或不存在时返回给客户端
 */

class MissException extends BaseException
{
    public $code = 404;
    public $msg = '请求的数据不存在';
    public $errorCode = 10001;
}