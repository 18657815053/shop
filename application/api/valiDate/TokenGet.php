<?php
/**
 * Created by PhpStorm.
 * User: lxj
 * Date: 2019/9/29
 * Time: 21:19
 */

namespace app\api\valiDate;


class TokenGet extends BaseValiDate
{
    protected $rule = [
        'code' => 'require|isNotEmpty'
    ];
    protected $message = [
        'code' => '请正确传入code',
    ];
}