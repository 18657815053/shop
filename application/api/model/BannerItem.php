<?php
/**
 * Created by PhpStorm.
 * User: lxj
 * Date: 2019/9/28
 * Time: 21:19
 */

namespace app\api\model;


class BannerItem extends BaseModel
{
    protected $hidden = ['id', 'banner_id', 'img_id', 'create_time', 'update_time', 'delete_time'];
    protected $autoWriteTimestamp = true;

    /*
     * 关联Image模型
     */
    public function images()
    {
        return $this->belongsTo('Image', 'img_id', 'id');
    }
}