<?php

namespace console\controllers;

use common\models\Order;
use common\models\Product;
use common\models\ProductInventoryHistory;
use common\models\ProductQuantity;
use yii\helpers\Console;

class CmdController extends  \yii\console\Controller
{
    public function init()
    {
        ini_set('memory_limit', '1024M');
        //date_default_timezone_set('Europe/Kiev');
        parent::init();
    }

    public function actionIndex()
    {
        $this->stdout("\n\ndone\r\n", Console::BOLD);
    }

    /**
     * php yii cmd/product-quantity
     *
     * @return void
     * @throws \yii\base\ErrorException
     */
    public function actionProductQuantity()
    {
        $cnt = 0;
        $products = Product::find()
            //->andWhere(['id_warehouse' => 34]) // Склад Основний
            ->orderBy('id ASC')
            //->limit(5)
            ->all();
        foreach ($products as $product) {
            $productQuantity = ProductQuantity::find()
                ->where(['id_product' => $product->id])
                ->andWhere(['id_warehouse' => $product->id_warehouse])
                ->one();
            if(!$productQuantity) {
                $productQuantity = new ProductQuantity();
                $productQuantity->id_product = $product->id;
                $productQuantity->id_warehouse = $product->id_warehouse;
            }
            $productQuantity->count = $product->count;
            $productQuantity->price = $product->price;
            if (!$productQuantity->save()) {
                throw new \yii\base\ErrorException(implode(PHP_EOL, $productQuantity->getFirstErrors()));
            }
            $cnt++;
        }

        $this->stdout("\n\ndone $cnt \r\n", Console::BOLD);
    }

    /**
     * php yii cmd/clear-dub
     *
     * @return void
     */
    public function actionClearDub()
    {
        $r = Product::replaceId(11255, 3588);
        var_dump($r);
        exit;

        $csvFile = file(\Yii::getAlias('@runtime') . '/dub.csv');
        $data = [];
        foreach ($csvFile as $line) {
            $data[] = str_getcsv($line, ';');
        }

        $cnt = 0;
        foreach ($data as $d) {
            [$id_brand, $upc] = $d;
            //echo "brand $id_brand, upc $upc \r\n";
            $productMain = Product::find()
                ->where(['id_brand' => $id_brand])
                ->andWhere(['upc' => $upc])
                ->andWhere(['id_warehouse' => 34])
                ->one();

            $productUsa = Product::find()
                ->where(['id_brand' => $id_brand])
                ->andWhere(['upc' => $upc])
                ->andWhere(['id_warehouse' => 30])
                ->one();

            if($productMain && $productUsa) {
                Product::replaceId($productMain->id, $productUsa->id);
                $cnt++;
            }

        }

        exit($cnt.' usa deleted.');
    }

    public function actionJoinWare()
    {
        $productQuantities = ProductQuantity::find()
            ->where(['id_warehouse' => 34])
            ->andWhere(['>', 'count', 0])
            ->all();

        $prcessed = 0;
        foreach ($productQuantities as $productQuantity) {
            if($product = $productQuantity->product) {
                $productQuantitySofia = $product->getQuantityWarehouse(35);
                //$productQuantitySofia->count += $productQuantity->count;

                // add to warehouse
                ProductInventoryHistory::add([
                    'id_product'    => $product->id,
                    'id_warehouse'  => $productQuantitySofia->id_warehouse,
                    'id_order'      => null,
                    'status_prev'   => null,
                    'status_new'    => null,
                    'quantity_prev' => $productQuantitySofia->count,
                    'quantity_new'  => $productQuantitySofia->count + $productQuantity->count,
                ]);
                $productQuantitySofia->updateAttributes([
                    'count'      => (int)$productQuantity->count + (int)$productQuantitySofia->count,
                    'price'      => (float)($productQuantitySofia->price ?: $productQuantity->price),
                    'updated_at' => gmdate('Y-m-d H:i:s'),
                ]);

                // remove from warehouse
                ProductInventoryHistory::add([
                    'id_product'    => $product->id,
                    'id_warehouse'  => $productQuantity->id_warehouse,
                    'id_order'      => null,
                    'status_prev'   => null,
                    'status_new'    => null,
                    'quantity_prev' => $productQuantity->count,
                    'quantity_new'  => 0,
                ]);
                $productQuantity->updateAttributes([
                    'count'      => 0,
                    'updated_at' => gmdate('Y-m-d H:i:s'),
                ]);
                $prcessed++;
            }
        }
        
        $this->stdout("\n\n$prcessed done\r\n", Console::BOLD);
    }

    public function actionOrderInventory()
    {
        $prcessed = 0;

        $orders = Order::find()->where(['IN', 'id', [4719, 4720, 4721]])->all();
        foreach ($orders as $order) {
            foreach ($order->orderProduct as $orderProduct) {
                $product = $orderProduct->product;
                $productQuantitySofia = $product->getQuantityWarehouse(35);

                // remove from warehouse
                ProductInventoryHistory::add([
                    'id_product'    => $product->id,
                    'id_warehouse'  => $productQuantitySofia->id_warehouse,
                    'id_order'      => $order->id,
                    'status_prev'   => null,
                    'status_new'    => null,
                    'quantity_prev' => $productQuantitySofia->count,
                    'quantity_new'  => $productQuantitySofia->count - $orderProduct->quantity,
                ]);
                $productQuantitySofia->updateAttributes([
                    'count'      => (int)$productQuantitySofia->count - $orderProduct->quantity,
                    'updated_at' => gmdate('Y-m-d H:i:s'),
                ]);
            }
        }

        $this->stdout("\n\n$prcessed done\r\n", Console::BOLD);
    }

}

/**
 * INSERT INTO `product_inventory_history` (`id`, `id_product`, `id_warehouse`, `id_order`, `id_user`, `status_prev`, `status_new`, `quantity_prev`, `quantity_new`, `created_at`, `updated_at`)
 * VALUES
 * (30410, 348, NULL, 4718, 2, 8, 11, 1, 0, '2024-05-29 16:42:22', NULL),
 * (30409, 697413, 35, NULL, 1362, NULL, NULL, 4, 6, '2024-05-29 09:09:17', NULL),
 * (30408, 700329, 35, NULL, 1362, NULL, NULL, 0, 2, '2024-05-29 08:51:32', NULL),
 * (30407, 700328, 35, NULL, 1362, NULL, NULL, 0, 2, '2024-05-29 08:49:14', NULL),
 * (30406, 697413, 35, NULL, 1362, NULL, NULL, NULL, 4, '2024-05-29 08:45:19', NULL),
 * (30405, 699818, 35, NULL, 1362, NULL, NULL, 2, 3, '2024-05-29 08:37:00', NULL),
 * (30404, 700327, 35, NULL, 1362, NULL, NULL, 0, 2, '2024-05-29 08:34:27', NULL),
 * (30403, 699760, 35, NULL, 1362, NULL, NULL, 6, 7, '2024-05-29 08:30:37', NULL),
 * (30402, 2957, 35, NULL, 1362, NULL, NULL, 8, 9, '2024-05-29 07:18:42', NULL),
 * (30401, 697528, 35, NULL, 1362, NULL, NULL, NULL, 1, '2024-05-29 07:18:04', NULL),
 * (30400, 696058, 35, NULL, 1362, NULL, NULL, 8, 9, '2024-05-29 07:17:03', NULL),
 * (30399, 4718, 35, NULL, 1362, NULL, NULL, NULL, 1, '2024-05-29 07:15:11', NULL),
 * (30398, 3270, NULL, 4719, 608, 8, 11, 0, 11, '2024-05-28 14:57:39', NULL),

 * (30397, 699680, NULL, 4721, 607, 8, 11, 3, 5, '2024-05-28 14:21:03', NULL),
 * (30396, 699416, NULL, 4721, 607, 8, 11, 2, 3, '2024-05-28 14:21:02', NULL),
 * (30395, 697540, NULL, 4721, 607, 8, 11, 8, 15, '2024-05-28 14:21:01', NULL),
 * (30394, 696099, NULL, 4721, 607, 8, 11, 12, 35, '2024-05-28 14:20:59', NULL),
 * (30393, 4244, NULL, 4721, 607, 8, 11, 3, 34, '2024-05-28 14:20:58', NULL),
 * (30392, 2835, NULL, 4721, 607, 8, 11, 1, 1, '2024-05-28 14:20:57', NULL),
 * (30391, 332, NULL, 4721, 607, 8, 11, 5, 4, '2024-05-28 14:20:56', NULL),
 * (30390, 266, NULL, 4721, 607, 8, 11, 5, 4, '2024-05-28 14:20:55', NULL),

 * (30389, 698849, NULL, 4720, 2, 8, 11, 2, 1, '2024-05-28 14:20:01', NULL),
 * (30388, 10458, NULL, 4720, 2, 8, 11, 1, 1, '2024-05-28 14:20:00', NULL),
 * (30387, 4198, NULL, 4720, 2, 8, 11, 38, 75, '2024-05-28 14:19:58', NULL),
 * (30386, 3006, NULL, 4720, 2, 8, 11, 128, 210, '2024-05-28 14:19:56', NULL),
 * (30385, 1647, NULL, 4720, 2, 8, 11, 18, 37, '2024-05-28 14:19:55', NULL),

 * (30384, 697704, NULL, 4719, 608, 10, 11, 1, 1, '2024-05-28 14:16:00', NULL),
 * (30383, 696999, NULL, 4719, 608, 8, 11, 1, 1, '2024-05-28 14:15:54', NULL),
 * (30382, 696856, NULL, 4719, 608, 8, 11, 1, 1, '2024-05-28 14:15:53', NULL),
 * (30381, 696843, NULL, 4719, 608, 8, 11, 5, 8, '2024-05-28 14:15:52', NULL),
 * (30380, 696799, NULL, 4719, 608, 8, 11, 5, 9, '2024-05-28 14:15:51', NULL),
 * (30379, 696282, NULL, 4719, 608, 13, 11, 3, 0, '2024-05-28 14:15:49', NULL),
 * (30378, 696110, NULL, 4719, 608, 8, 11, 3, 5, '2024-05-28 14:15:46', NULL),
 * (30377, 11688, NULL, 4719, 608, 8, 11, 2, 8, '2024-05-28 14:15:45', NULL),
 * (30376, 10874, NULL, 4719, 608, 8, 11, 1, 0, '2024-05-28 14:15:42', NULL),
 * (30375, 8700, NULL, 4719, 608, 8, 11, 7, 0, '2024-05-28 14:15:41', NULL),
 * (30374, 4376, NULL, 4719, 608, 8, 11, 8, 22, '2024-05-28 14:15:40', NULL),
 * (30373, 3548, NULL, 4719, 608, 8, 11, 4, 7, '2024-05-28 14:15:39', NULL),
 * (30372, 1422, NULL, 4719, 608, 8, 11, 6, 11, '2024-05-28 14:15:37', NULL),
 * (30371, 1079, NULL, 4719, 608, 8, 11, 4, 7, '2024-05-28 14:15:36', NULL),
 * (30370, 751, NULL, 4719, 608, 8, 11, 5, 9, '2024-05-28 14:15:35', NULL),
 * (30369, 332, NULL, 4719, 608, 8, 11, 3, 5, '2024-05-28 14:15:34', NULL),
 * (30368, 266, NULL, 4719, 608, 8, 11, 3, 5, '2024-05-28 14:15:33', NULL),
 * (30367, 118, NULL, 4719, 608, 8, 11, 10, 19, '2024-05-28 14:15:32', NULL);
 */
