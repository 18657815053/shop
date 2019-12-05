<?php
/**
 * Created by PhpStorm.
 * User: lxj
 * Date: 2019/9/27
 * Time: 18:44
 */

namespace app\api\model;


class Banner extends BaseModel
{
    protected $hidden = ['create_time', 'update_time', 'delete_time'];
    protected $autoWriteTimestamp = true;

    /*
     * 关联BannerItem模型
     */
    public function items()
    {
        return $this->hasMany('BannerItem', 'banner_id', 'id');
    }


    /*根据banner id 获取banner信息
     * @id int
     * return
     */
    public static function getBannerByID($id)
    {
        $result = self::with(['items.images'])->find($id);

        return $result;
    }
}