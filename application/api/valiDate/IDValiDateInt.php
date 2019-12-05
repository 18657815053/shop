<?php
/**
 * Created by PhpStorm.
 * User: lxj
 * Date: 2019/9/27
 * Time: 10:00
 */

namespace app\api\valiDate;


class IDValiDateInt extends BaseValiDate
{
    protected $rule = [
        'id' => 'require|isPostiveInt',
    ];

    protected $message = [
        'id' => 'ID必需是正整数',
    ];

}