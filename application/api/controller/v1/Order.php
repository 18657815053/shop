<?php
/**
 * Created by PhpStorm.
 * User: lxj
 * Date: 2019/10/8
 * Time: 19:51
 */

namespace app\api\controller\v1;

use app\api\controller\BaseController;
use app\api\service\Token as TokenService;
use app\api\valiDate\OrderPlace;
use app\api\service\Order as OrderService;

class Order extends BaseController
{
    protected $beforeActionList = [
        'checkExclusiveScope' => ['only' => 'placeOrder']
    ];

    public function placeOrder()
    {
        (new OrderPlace())->gocheck();
        $products = input('post.products/a');

        $uid = TokenService::getCurrentUid();

        $order = new OrderService();
        $result = $order->place($uid, $products);

        return $result;
    }
}