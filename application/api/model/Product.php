<?php
/**
 * Created by PhpStorm.
 * User: lxj
 * Date: 2019/9/29
 * Time: 13:44
 */

namespace app\api\model;


class Product extends BaseModel
{
    protected $hidden = ['category_id', 'from', 'pivot', 'create_time', 'update_time', 'delete_time'];
    protected $autoWriteTimestamp = true;

    public function getMainImgUrlAttr($value, $data)
    {
        return $this->imgPrefixUrl($value, $data);
    }

    /*
    * 关联ProductImage模型
    * 属于一对多
    */
    public function imgs()
    {
        return $this->hasMany('ProductImage', 'product_id', 'id');
    }

    /*
     * 关联ProductProperty模型
     * 属于一对多
     */
    public function properties()
    {
        return $this->hasMany('ProductProperty', 'product_id', 'id');
    }

    public static function getProductByCategoryID($categoryID)
    {
        $result = self::where('category_id', '=', $categoryID)
            ->select();
        return $result;
    }

    public static function getRecentProduct($limit)
    {
        $result = self::limit($limit)
            ->order('create_time desc')
            ->select();
        return $result;
    }


    public static function getProductByID($id)
    {
        $result = self::with([
            'imgs' => function ($query) {
                $query->with(['images'])
                    ->order('order', 'asc');
            }
        ])
            ->with(['properties'])
            ->find($id);

        return $result;
    }
}