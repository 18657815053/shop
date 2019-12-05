<?php
/**
 * Created by PhpStorm.
 * User: lxj
 * Date: 2019/10/8
 * Time: 20:43
 */

namespace app\api\valiDate;


use app\lib\exception\ParameterException;

class OrderPlace extends BaseValiDate
{
    protected $rule = [
        'products' => 'checkProducts',
    ];

    protected $singRule = [
        'product_id' => 'require|isPostiveInt',
        'count' => 'require|isPostiveInt',
    ];

    protected function checkProducts($value, $rule = '', $data = '', $field = '')
    {
        if (!is_array($value)) {
            throw new ParameterException([
                'msg' => '商品参数不正确',
            ]);
        }
        if (empty($value)) {
            throw new ParameterException([
                'msg' => '商品列表不存在',
            ]);
        }

        foreach ($value as $key => $val) {
            $this->checkProductDetail($val);
        }

        return true;
    }

    protected function checkProductDetail($vaule)
    {
        $validate = new BaseValiDate($this->singRule);
        $result = $validate->check($vaule);
        if (!$result) {
            echo $result;
            throw new ParameterException([
                'msg' => '商品参数错误',
            ]);
        }
    }
}