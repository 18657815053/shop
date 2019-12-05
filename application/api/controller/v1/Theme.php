<?php
/**
 * Created by PhpStorm.
 * User: lxj
 * Date: 2019/9/29
 * Time: 13:42
 */

namespace app\api\controller\v1;

use app\api\model\Theme as ThemeModel;
use app\api\valiDate\IDStrValidate;
use app\api\valiDate\IDValiDateInt;
use app\lib\exception\ThemeException;

class Theme
{
    /*
     * 获取所有Theme主题
     * @url /api/v1/theme?ids=id1,id2,id3...
     * @http GET
     * @return theme模型数组
     */
    public function getSimpleList($ids)
    {
        (new IDStrValidate())->gocheck();

        $ids = explode(',', $ids);
        $result = ThemeModel::getThemeList($ids);
        if (!$result) {
            throw new ThemeException();
        }
        return $result;
    }

    /*
     * 根据id  theme_product中间表获取当前主题所有产品
     * @url /api/v1/theme/:id
     * @http GET
     * @param int $id 专题id
     * @return 一条theme的关联模型数组
     */
    public function getComplexOne($id)
    {
        (new IDValiDateInt())->gocheck();

        $result = ThemeModel::getThemeWithProduct($id);
        if (!$result) {
            throw new ThemeException();
        }

        return $result;
    }
}