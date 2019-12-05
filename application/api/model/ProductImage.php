<?php
/**
 * Created by PhpStorm.
 * User: lxj
 * Date: 2019/9/30
 * Time: 13:48
 */

namespace app\api\model;


class ProductImage extends BaseModel
{
    protected $hidden = ['product_id', 'create_time', 'delete_time', 'update_time'];
    protected $autoWriteTimestamp = true;

    /*
    * product_image.img_id关联Image模型
    * 属于一对一
    */
    public function images()
    {
        return $this->belongsTo('Image', 'img_id', 'id');
    }
}