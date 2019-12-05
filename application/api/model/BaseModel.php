<?php
/**
 * Created by PhpStorm.
 * User: lxj
 * Date: 2019/9/29
 * Time: 12:46
 */

namespace app\api\model;


use think\Model;

/*
 * 模型基类
 */

class BaseModel extends Model
{
    protected function imgPrefixUrl($value, $data)
    {
        $result = $value;
        if ($data['from'] == 1) {
            $result = config('setting.img_prefix') . $value;
        }

        return $result;
    }

}