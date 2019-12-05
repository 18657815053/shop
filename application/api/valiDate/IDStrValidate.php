<?php
/**
 * Created by PhpStorm.
 * User: lxj
 * Date: 2019/9/29
 * Time: 14:22
 */

namespace app\api\valiDate;


class IDStrValidate extends BaseValiDate
{
    protected $rule = [
        'ids' => 'require|isIDStr'
    ];

    protected $message = [
        'ids' => 'ids参数必须是以逗号分隔的正整数'
    ];

    protected function isIDStr($value, $rule = '', $data = '', $field = '')
    {
        $arr = explode(',', $value);
        if (empty($arr)) {
            return false;
        }

        foreach ($arr as $val) {
            if (!$this->isPostiveInt($val)) {
                //判断是否为正整型
                return false;
            }
        }

        return true;
    }

}