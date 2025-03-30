<?php

/* @var $this yii\web\View */

/* @var $model \common\models\Product */

use yii\helpers\Html;
use yii\helpers\Url;

/**
<th><p>Фото</p></th>
<th><p>Наименование</p></th>
<th><p>Фирма производитель</p></th>
<th><p>Код запчасти</p></th>
<th><p>Регион</p></th>
<th><p>Срок поставки (дн.)</p></th>
<th><p>Наличие (шт.)</p></th>
<th><p>Склад</p></th>
<th><p>Цена (грн.)</p></th>
<th><p>&nbsp;</p></th>
 */
?>
<tr>
    <td class="text-center" style="padding:0;">
        <a href="<?= Url::to(['product/index', 'id' => $model->id, 'url' => $model->url]) ?>">
            <?php if($image = $model->image): ?>
                <?= Html::img(Yii::$app->urlManagerFrontEnd->createUrl('/') . 'images/resize/1/70x70/' . $image->id.'.'.$image->ext, [
                    //'width' => '50',
                    'title' => 'Придбати ' . Html::encode($model->name),
                    'alt'   => 'Придбати ' . Html::encode($model->name),
                ]); ?>
            <?php else: ?>
                <?= Html::img('/images/no-img.png', [
                    'width' => '70',
                    'title' => 'Придбати ' . Html::encode($model->name),
                    'alt'   => 'Придбати ' . Html::encode($model->name),
                ]); ?>
            <?php endif; ?>
        </a>
    </td>
    <td>
        <p>
            <a href="<?= Url::to(['product/index', 'id' => $model->id, 'url' => $model->url]) ?>">
                <?= Html::encode($model->name) ?></a>
        </p>
    </td>
    <td><p><?= $model->brand ? Html::encode($model->brand->name) : '' ?></p></td>
    <td><p><?= Html::encode($model->upc) ?></p></td>

    <td>
        <?php if($productQuantity = $model->productQuantity): ?>
        <table class="product_quantity table table-striped table-bordered" style="width: 100%;">
            <tr>
                <th>Регіон</th>
                <th>Термін поставки (дн.)</th>
                <th>Наявність (шт.)</th>
                <th>Склад</th>
                <th>Ціна (грн.)</th>
                <th></th>
            </tr>
            <?php foreach ($productQuantity as $pq): ?>
            <tr>
                <td><?= $pq->warehouse ? $pq->warehouse->region : '' ?></td>
                <td><?= $pq->warehouse ? $pq->warehouse->delivery_time : '' ?></td>
                <td><?= $pq->warehouse ? $pq->count : '' ?></td>
                <td><?= $pq->warehouse ? $pq->warehouse->alias : '' ?></td>
                <td><?= Yii::$app->formatter->asCurrency($pq->priceUah) ?></td>
                <td>
                    <?php if($pq->count > 0): ?>
                        <?= Html::a('<i class="fa fa-shopping-cart"></i>', ['cart/add', 'id' => $model->id, 'w' => $pq->id_warehouse], ['class' => 'btn btn-success', 'data-pajx' => '0']) ?>
                    <?php else: ?>
                        <?= Html::a('<i class="fa fa-shopping-cart"></i>', ['site/contact', 'msg' => urlencode('Під замовлення артикул '.$model->upc)], ['class' => 'btn btn-danger', 'data-pajx' => '0', 'rel' => 'nofollow']) ?>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </td>

</tr>
