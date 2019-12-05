<?php
/**
 * Created by PhpStorm.
 * User: lxj
 * Date: 2019/9/29
 * Time: 17:41
 */

namespace app\api\controller\v1;


use app\api\valiDate\IDValiDateInt;
use app\api\valiDate\RecentProductLimit;
use app\api\model\Product as ProductModel;
use app\lib\exception\ProductException;

class Product
{
    /*
     * 从商品表获取最新的limit条记录数
     * @url /api/v1/product/recent?limit=
     * @http GET
     * @param int $limit
     * @return 指定数量的商品模型数组
     */
    public function getRecent($limit = 15)
    {
        (new RecentProductLimit())->gocheck();

        $result = ProductModel::getRecentProduct($limit);
        if (!$result) {
            throw new ProductException();
        }

        return $result;
    }

    /*
     * 根据分类id获取所有当前分类商品
     * @url /api/product/by_category/:id
     * @http GET
     * @param int $id 商品分类id
     * @return 当前分类商品模型数组
     */
    public function getAllInCategory($id)
    {
        (new IDValiDateInt())->gocheck();

        $result = ProductModel::getProductByCategoryID($id);
        if (!$result) {
            throw new ProductException();
        }
        return $result;
    }

    /*
     * 根据ID获取一条商品信息
     * @url /api/product/:id
     * @http GET
     * @param int $id 商品id
     * @return 当前商品信息模型数组
     */
    public function getOne($id)
    {
        (new IDValiDateInt())->gocheck();

        $result = ProductModel::getProductByID($id);
        if (!$result) {
            throw new ProductException();
        }
        return $result;

    }
}