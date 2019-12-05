<?php
/**
 * Created by PhpStorm.
 * User: lxj
 * Date: 2019/9/29
 * Time: 18:48
 */

namespace app\api\model;


class Category extends BaseModel
{
    protected $hidden = ['create_time', 'update_time', 'delete_time'];
    protected $autoWriteTimestamp = true;

    public function image()
    {
        return $this->belongsTo('Image', 'topic_img_id', 'id');
    }

    public static function getCategory()
    {
        $result = self::with(['image'])->select();

        return $result;
    }
}