<?php
/**
 * Created by PhpStorm.
 * User: lxj
 * Date: 2019/10/8
 * Time: 23:35
 */

namespace app\api\model;


class Order extends BaseModel
{
    protected $hidden = ['id', 'create_time', 'update_time', 'delete_time'];
    protected $autoWriteTimestamp = true;
}