<?php
/**
 * Created by PhpStorm.
 * User: lxj
 * Date: 2019/10/8
 * Time: 21:03
 */

namespace app\api\service;

use app\api\model\OrderProduct;
use app\api\model\Product as ProductModel;
use app\api\model\OrderProduct as OrderProductModel;
use app\api\model\Order as OrderModel;
use app\api\model\UserAddress;
use app\lib\exception\OrderException;
use app\lib\exception\UserException;
use think\Db;
use think\Exception;

class Order
{
    //客户端传过来的products参数
    protected $oProducts;
    //数据库查询出来的products
    protected $products;
    protected $uid;

    /*
     * 检测订单库存量  通过则创建订单   失败将订单返回
     */
    public function place($uid, $oProducts)
    {
        $this->oProducts = $oProducts;
        $this->products = $this->getProductsByOrder($oProducts);
        $this->uid = $uid;
        $status = $this->getOrderStatus();
        //库存量检测不通过
        if (!$status['pass']) {
            $status['order_id'] = -1;
            return $status;
        }

        //开始创建订单
        $snapOrder = $this->snapOrder($status);
        $result = $this->createOrder($snapOrder);
        $result['pass'] = true;

        return $result;
    }

    /*
     * 创建订单,将数据保存到数据库
     */
    private function createOrder($snapOrder)
    {
        Db::startTrans();
        try {
            $orderNo = $this->makeOrderNo();
            $order = new OrderModel();
            $order->order_no = $orderNo;
            $order->user_id = $this->uid;
            $order->total_price = $snapOrder['orderPrice'];
            $order->total_count = $snapOrder['totalCount'];
            $order->status = 1;
            $order->snap_name = $snapOrder['snapName'];
            $order->snap_img = $snapOrder['snapImg'];
            $order->snap_items = json_encode($snapOrder['pStatus']);
            $order->snap_address = $snapOrder['snapAddress'];
            $order->save();
            //将订单商品存到order_prodect
            $orderID = $order->id;
            $createTime = $order->create_time;
            foreach ($this->oProducts as &$value) {
                $value['order_id'] = $orderID;
            }
            $orderProduct = new OrderProductModel();
            $orderProduct->saveAll($this->oProducts);
            Db::commit();
            return [
                'order_no' => $orderNo,
                'order_id' => $orderID,
                'create_time' => $createTime,
            ];
        }
        catch (Exception $ex) {
            Db::rollback();
            throw $ex;
        }
    }

    /*
     * 生成订单快照
     */
    private function snapOrder($status)
    {
        $snap = [
            'orderPrice' => 0,
            'totalCount' => 0,
            'pStatus' => [],
            'snapAddress' => null,
            'snapName' => '',
            'snapImg' => '',
        ];

        $snap['orderPrice'] = $status['orderPrice'];
        $snap['totalCount'] = $status['totalCount'];
        $snap['pStatus'] = $status['pStatusArr'];
        $snap['snapAddress'] = json_encode($this->getUserAddress());
        $snap['snapName'] = $this->products[0]['name'];
        $snap['snapImg'] = $this->products[0]['main_img_url'];

        if (count($this->products) > 1) {
            $snap['snapName'] .= "等";
        }

        return $snap;
    }

    /*
     * 获取用户地址
     */
    private function getUserAddress()
    {
        $result = UserAddress::where('user_id', '=', $this->uid)
            ->find();
        if (!$result) {
            throw new UserException([
                'msg' => '用户地址不存在',
                'errorCode' => 60001,
            ]);
        }

        return $result->toArray();
    }

    /*
     * 获取订单状态
     */
    private function getOrderStatus()
    {
        $status = [
            'pass' => true,
            'totalCount' => 0,
            'orderPrice' => 0,
            'pStatusArr' => [],
        ];

        foreach ($this->oProducts as $oProduct) {
            $pStatus = $this->getProductStasus(
                $oProduct['product_id'], $oProduct['count'], $this->products
            );
            if (!$pStatus['haveStock']) {
                $status['pass'] = false;
            }
            $status['totalCount'] += $pStatus['count'];
            $status['orderPrice'] += $pStatus['totalPrice'];
            array_push($status['pStatusArr'], $pStatus);
        }

        return $status;
    }

    /*
     *获取订单中一个商品的状态
     */
    private function getProductStasus($oPID, $oCount, $products)
    {
        $pIndex = -1;

        $pStatus = [
            'id' => null,//商品id
            'haveStock' => false,//是否有库存
            'count' => 0,//本id商品数量
            'name' => '',//商品名称
            'totalPrice' => 0,//本id商品总价
        ];

        for ($i = 0; $i < count($products); $i++) {
            if ($oPID == $products[$i]['id']) {
                $pIndex = $i;
                break;
            }
        }

        if ($pIndex == -1) {
            throw new OrderException([
                'msg' => '订单中的商品不存在，可能已被删除',
                'errorCode' => 80001,
            ]);
        }
        else {
            $product = $products[$pIndex];
            $pStatus = [
                'id' => $product['id'],
                'haveStock' => false,
                'count' => $oCount,
                'name' => $product['name'],//商品名称
                'totalPrice' => $oCount * $product['price'],//本id商品总价
            ];
            if ($oCount <= $product['stock']) {
                $pStatus['haveStock'] = true;
            }
        }
        return $pStatus;
    }

    /*
     * 根据订单信息从数据库查询商品信息
     */
    private function getProductsByOrder($oProducts)
    {
        $IDs = [];
        foreach ($oProducts as $val) {
            array_push($IDs, $val['product_id']);
        }
        // 为了避免循环查询数据库
        $products = ProductModel::all($IDs)
            ->visible(['id', 'price', 'stock', 'name', 'main_img_url'])
            ->toArray();
        return $products;
    }

    /*
     * 生成订单号
     */
    public static function makeOrderNo()
    {
        $yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
        $orderSn =
            $yCode[intval(date('Y')) - 2019] . strtoupper(dechex(date('m'))) . date(
                'd') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf(
                '%02d', rand(0, 99));
        return $orderSn;
    }
}