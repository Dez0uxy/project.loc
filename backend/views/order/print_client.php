<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Order */

$this->title = Yii::t('app', 'Замовлення') . ' #' . $model->num;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Замовлення'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="container-xl">
    <div class="card card-lg">
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <p class="h3"><?=Yii::t('app','Компанія')?></p>
                    <address>
                        Americancars.com.ua - Запчастини для Американських Автомобілів<br>
                        тел.097-233-11-90, 095-004-11-17<br>
                        https://americancars.com.ua/<br>
                        м.Київ, вул. Радищева 10
                    </address>
                </div>
                <div class="col-6 text-end">
                    <p class="h3"><?=Yii::t('app','Клієнт')?></p>
                    <address>
                        <?= $model->c_fio ?><br>
                        <?= $model->o_city ?><br>
                        <?= $model->o_address ?><br>
                        <?= $model->c_tel ?>
                    </address>
                </div>
                <div class="col-12 my-5">
                    <h1>
                        <?=Yii::t('app','Замовлення') ?> INV/
                        <?= Yii::$app->formatter->asDate($model->created_at, 'php:Ymd') ?>/
                        <?= $model->num ?>
                    </h1>
                </div>
            </div>
            <?php if ($products = $model->orderProduct): ?>
                <table class="table table-transparent table-responsive">
                    <thead>
                    <tr>
                        <th class="text-center" style="width: 1%">#</th>
                        <th><?= Yii::t('app', 'Виробник') ?></th>
                        <th><?= Yii::t('app', 'Товар') ?></th>
                        <th><?= Yii::t('app', 'Склад') ?></th>
                        <th class="text-center" style="width: 1%"><?= Yii::t('app', 'Кількість') ?></th>
                        <th class="text-end" style="width: 10%"><?= Yii::t('app', 'Ціна') ?></th>
                        <th class="text-end" style="width: 10%"><?= Yii::t('app', 'Сума') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $c = 1;
                    foreach ($products as $product): ?>
                        <?php /* @var \common\models\OrderProduct $product */ ?>
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
                                </p>
                            </td>
                            <td class="strong mb-1">
                                <?php if($warehouse = $product->warehouse): ?>
                                    <?= Html::encode($warehouse->alias) ?>
                                <?php endif;?>
                            </td>
                            <td class="text-center">
                                <?= $product->quantity ?>
                            </td>
                            <td class="text-end"><?= Yii::$app->formatter->asCurrency($product->price) ?></td>
                            <td class="text-end"><?= Yii::$app->formatter->asCurrency($product->quantity * $product->price) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="6" class="strong text-end"><?= Yii::t('app', 'Підсумок') ?></td>
                        <td class="text-end"><?= Yii::$app->formatter->asCurrency($model->total) ?></td>
                    </tr>
                    <tr>
                        <td colspan="6"
                            class="font-weight-bold text-uppercase text-end"><?= Yii::t('app', 'Загальна сума') ?></td>
                        <td class="font-weight-bold text-end"><?= Yii::$app->formatter->asCurrency($model->total) ?></td>
                    </tr>
                    </tbody>
                </table>
            <?php endif; ?>
            <p class="text-muted text-center mt-5">
                <?= Yii::t('app', 'Дякуємо за замовлення') ?>.<br>
                <?= Yii::t('app', 'З повагою') ?>, <?= Yii::$app->params['storeUrl'] ?>!
            </p>
        </div>
    </div>
</div>
