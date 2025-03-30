<?php

use \yii\helpers\Html;
use yii\helpers\Url;
use common\models\Settings;

/* @var $this yii\web\View */
/* @var $products common\models\Product[] */
/* @var $total int */

//$this->registerJsFile('https://use.fontawesome.com/8c48cc88d3.js');
$this->registerCssFile('@web/fontawesome/css/all.min.css', ['depends' => [\frontend\assets\AppAsset::className()]]);

$this->title                   = 'Кошик';
$this->params['breadcrumbs'][] = $this->title;
$this->registerMetaTag(['name' => 'robots', 'content' => 'noindex'], 'robots');
?>
<div class="content">
    <div class="static_pages">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>

    <?php if (Yii::$app->session->hasFlash('error')): ?>
        <div class="alert alert-danger">
            <?= Yii::$app->session->getFlash('error') ?>
        </div>
    <?php endif; ?>

    <?php if(\Yii::$app->cart->getCount()): ?>
        <table style="border: none; width: 100%;" class="table">
            <thead>
            <tr style="background:#2cace3;color:#fff;font-weight:bold;">
                <td>Бренд</td>
                <td>Назва</td>
                <td>Артикул</td>
                <td>Склад</td>
                <td>Кількість</td>
                <td>Сума</td>
                <td>Видалити</td>
            </tr>
            </thead>

            <?php foreach ($products as $product): ?>
                <tr style="background:#fff;">
                    <td><b style="font-weight: 700;"><?= $product->brand ? Html::encode($product->brand->name) : '' ?></b></td>
                    <td>
                        <?= Html::a($product->name, ['product/index', 'id' => $product->id, 'url' => $product->url]) ?>
                    </td>
                    <td><?= $product->upc ?></td>
                    <td><?= $product->costWarehouseId ? \common\models\Warehouse::findOne($product->costWarehouseId)->name : '' ?></td>
                    <td>
                        <div class="amount">
                            <?php
                                $pq = $product->getQuantityWarehouse($product->costWarehouseId);
                                $isMaxQuantity = $product->getQuantity() >= $pq->count;
                            ?>

                            <a href="<?= Url::to(['cart/update', 'id' => $product->getId(), 'quantity' => $product->getQuantity() + 1, 'w' => $product->costWarehouseId]) ?>"
                               class="<?= $isMaxQuantity ? 'disabled' : '' ?>"
                               style="<?= $isMaxQuantity ? 'pointer-events: none; color: grey;' : '' ?>">
                                <i class="fa fa-plus"></i>
                            </a>
                            <div class="numbr">
                                <?= $product->getQuantity() ?>
                            </div>
                            <a href="<?= Url::to(['cart/update', 'id' => $product->getId(), 'quantity' => $product->getQuantity() - 1, 'w' => $product->costWarehouseId]) ?>">
                                <i class="fa fa-minus"></i>
                            </a>
                        </div>
                    </td>
                    <td><?= Yii::$app->formatter->asCurrency($product->finalPrice, 'UAH') ?></td>
                    <td><a href="<?= Url::to(['cart/remove', 'id' => $product->getId()]) ?>">видалити</a></td>
                </tr>

            <?php endforeach ?>

            <tr style="background:#fff;font-weight:bold;">
                <td colspan="4">Усього:</td>
                <td>
                    <div class="pl-4" style="padding-left: 40px;"><?= Yii::$app->cart->getCount() ?> шт.</div>
                </td>
                <td><?= Yii::$app->cart->getCost(true)  ?> грн.</td>
                <td>
                    <a href="<?= Url::to(['cart/order']) ?>" class="btn btn-success buy">Оформити замовлення</a>
                </td>
            </tr>
        </table>

    <?php else:?>
        <br><br><br>
        <div class="text-center">У кошику немає товарів</div>
        <br><br><br><br><br><br><br><br><br>
    <?php endif;?>

</div>
