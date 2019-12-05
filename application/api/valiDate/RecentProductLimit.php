<?php
/**
 * Created by PhpStorm.
 * User: lxj
 * Date: 2019/9/29
 * Time: 17:46
 */

namespace app\api\valiDate;


class RecentProductLimit extends BaseValiDate
{
    protected $rule = [
        'limit' => 'isPostiveInt|between:1,10'
    ];
}