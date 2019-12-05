<?php
/**
 * Created by PhpStorm.
 * User: lxj
 * Date: 2019/9/27
 * Time: 9:27
 */

namespace app\api\controller\v1;


use app\api\valiDate\IDValiDateInt;
use app\api\valiDate\TestValiDate;
use app\api\model\Banner as BannerModel;
use app\lib\exception\BannerException;

class Banner
{
    /*
     * 获取banner信息
     * @url /api/v1/banner/:id
     * @http GET
     * @param int $id 轮播图id
     * @return banner模型数组
     */
    public function getBanner($id)
    {
        (new IDValiDateInt())->gocheck();

        $result = BannerModel::getBannerByID($id);
        if (!$result) {
            throw new BannerException();
        }

        return $result;
    }
}