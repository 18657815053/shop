<?php
/**
 * Created by PhpStorm.
 * User: lxj
 * Date: 2019/9/29
 * Time: 13:44
 */

namespace app\api\model;


class Theme extends BaseModel
{
    protected $hidden = ['topic_img_id', 'head_img_id', 'create_time', 'update_time', 'delete_time'];
    protected $autoWriteTimestamp = true;

    /*
    * topic_img_id关联Image模型
    */
    public function topicImg()
    {
        return $this->belongsTo('Image', 'topic_img_id', 'id');
    }

    /*
    * head_img_id关联Image模型
    */
    public function headImg()
    {
        return $this->belongsTo('Image', 'head_img_id', 'id');
    }

    /*
     * theme_product.product_id关联Product模型
     * 属于多对多
     */

    public function products()
    {
        return $this->belongsToMany('Product', 'theme_product', 'product_id', 'theme_id');
    }

    /*
     * 获取theme专题列表
     */
    public static function getThemeList($ids)
    {
        $result = self::with(['topicImg', 'headImg'])->select($ids);

        return $result;
    }

    public static function getThemeWithProduct($id)
    {
        $result = self::with(['products', 'topicImg', 'headImg'])->find($id);

        return $result;
    }
}