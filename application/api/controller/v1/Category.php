<?php
/**
 * Created by PhpStorm.
 * User: lxj
 * Date: 2019/9/29
 * Time: 18:44
 */

namespace app\api\controller\v1;

use app\api\model\Category as CategoryModel;
use app\lib\exception\CategoryException;

class Category
{
    public function getAllCategory()
    {
        $result = CategoryModel::getCategory();
        if (!$result) {
            throw new CategoryException();
        }
        return $result;
    }
}