<?php
/**
 * Created by PhpStorm.
 * User: lxj
 * Date: 2019/10/8
 * Time: 17:17
 */

namespace app\api\model;


class UserAddress extends BaseModel
{
    protected $hidden = ['id', 'user_id', 'create_time', 'update_time', 'delete_time'];
    protected $autoWriteTimestamp = true;
}