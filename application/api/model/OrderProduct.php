<?php
/**
 * Created by PhpStorm.
 * User: lxj
 * Date: 2019/10/8
 * Time: 23:53
 */

namespace app\api\model;


class OrderProduct extends BaseModel
{
    protected $hidden = ['create_time', 'update_time', 'delete_time'];
    protected $autoWriteTimestamp = true;
}