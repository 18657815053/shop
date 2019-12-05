<?php
/**
 * Created by PhpStorm.
 * User: lxj
 * Date: 2019/9/30
 * Time: 14:02
 */

namespace app\api\model;


class ProductProperty extends BaseModel
{
    protected $hidden = ['id', 'product_id', 'create_time', 'delete_time', 'update_time'];
    protected $autoWriteTimestamp = true;
}