<?php
/**
 * Created by PhpStorm.
 * User: lxj
 * Date: 2019/10/8
 * Time: 21:38
 */

namespace app\lib\exception;


class OrderException extends BaseException
{
    public $code = 404;
    public $msg = '订单不存在';
    public $errorCode = 80000;
}