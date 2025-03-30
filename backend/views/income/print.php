<?php

use common\models\IncomeProduct;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Income */

$this->title = Yii::t('app', 'Прихід товару') . ' #' . $model->num;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Замовлення'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="container-xl">
    <div class="card card-lg">
        <div class="card-body">
            <div class="row">
                <div class="col-12 my-5">
                    <h1>
                        <?=Yii::t('app','Прихід товару') ?> INC/
                        <?= Yii::$app->formatter->asDate($model->created_at, 'php:Ymd') ?>/
                        <?= $model->num ?>
                    </h1>
                    <h3>
                        <?=Yii::t('app','Склад') ?>
                        <?= $model->warehouse->name ?>
                    </h3>
                </div>
            </div>
            <?php if ($products = $model->incomeProduct): ?>
                <table class="table table-transparent table-responsive">
                    <thead>
                    <tr>
                        <th class="text-center" style="width: 1%">#</th>
                        <th><?= Yii::t('app', 'Виробник') ?></th>
                        <th><?= Yii::t('app', 'Товар') ?></th>
                        <th class="text-center" style="width: 1%"><?= Yii::t('app', 'Кількість') ?></th>
                        <th class="text-end" style="width: 10%"><?= Yii::t('app', 'Ціна') ?></th>
                        <th class="text-end" style="width: 10%"><?= Yii::t('app', 'Сума') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $c = 1;
                    foreach ($products as $product): ?>
                        <?php /* @var \common\models\IncomeProduct $product */ ?>
                        <tr>
                            <td class="text-center"><?= $c++ ?></td>
                            <td class="strong mb-1">
                                <?php if($product->product && ($brand = $product->product->brand)): ?>
                                    <strong><?= Html::encode($brand->name) ?></strong>
                                <?php endif;?>
                            </td>
                            <td>
                                <p class="strong mb-1">
                                    <?= Html::encode($product->product_name) ?>
                                    <span class="text-muted"><?= Html::encode($product->upc) ?></span>
                                </p>
                            </td>
                            <td class="text-center">
                                <?= $product->quantity ?>
                            </td>
                            <td class="text-end"><?= Yii::$app->formatter->asCurrency($product->price, 'USD') ?></td>
                            <td class="text-end"><?= Yii::$app->formatter->asCurrency($product->quantity * $product->price, 'USD') ?></td>
                        </tr>
                    <?php endforeach; ?>

                    <tr>
                        <td colspan="3"
                            class="font-weight-bold text-uppercase text-end"><?= Yii::t('app', 'Загальна сума') ?></td>
                        <td class="text-center"><?= $model->totalQuantity ?></td>
                        <td class="text-end"></td>
                        <td class="font-weight-bold text-end"><?= Yii::$app->formatter->asCurrency($model->totalPrice, 'USD') ?></td>
                    </tr>
                    </tbody>
                </table>
            <?php endif; ?>
            <p class="text-muted text-center mt-5">
                <?= Yii::$app->formatter->asDate($model->created_at, 'php:d.m.Y H:i') ?><br>
                <?= Yii::$app->params['storeUrl'] ?>
            </p>
        </div>
    </div>
</div>
