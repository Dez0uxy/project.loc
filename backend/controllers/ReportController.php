<?php

namespace backend\controllers;

use common\models\Order;
use common\models\OrderProduct;
use common\models\Vendor;
use yii\helpers\VarDumper;

class ReportController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionSales()
    {
        return $this->render('sales');
    }

    public function actionVendorProduct()
    {
        $vendors = Vendor::find()
            ->where(['status' => Vendor::STATUS_ACTIVE])
            ->all();

        $orders = Order::find()
            ->with('orderProduct')
            ->where(['status' => 2]) // in-progress
            ->all();

        $products = [];
        foreach ($orders as $order) {
            foreach ($order->orderProduct as $orderProduct) {
                if (($p = $orderProduct->product) && !in_array($orderProduct->status, [11, 12, 13, 14])) { // finished products
                    $products[$p->id_vendor][$order->id][] = $orderProduct;
                }
            }
        }
        //echo '<pre>'; var_dump($products); exit('</pre>');

        return $this->render('vendor-product', [
            'vendors'  => $vendors,
            'orders'   => $orders,
            'products' => $products,
        ]);
    }

    public function actionWarehouse()
    {
        return $this->render('warehouse');
    }

}
