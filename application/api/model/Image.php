<?php
/**
 * Created by PhpStorm.
 * User: lxj
 * Date: 2019/9/28
 * Time: 22:17
 */

namespace app\api\model;


class Image extends BaseModel
{

    protected $hidden = ['id', 'from', 'create_time', 'update_time', 'delete_time'];
    protected $autoWriteTimestamp = true;

    public function getUrlAttr($value, $data)
    {
        return $this->imgPrefixUrl($value, $data);
    }

}