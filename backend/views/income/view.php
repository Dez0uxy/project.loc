<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Income */

$this->title = Yii::t('app', 'Прихід') . ' #' . $model->formatNum . ' ' .
    Yii::t('app', 'від') . ' ' . Yii::$app->formatter->asDatetime($model->created_at);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Прихід товару'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title"><?= Html::encode($this->title) ?></h1>
        </div>

        <div class="card card-lg">
            <div class="card-body">

                <div class="income-view">

                    <p class="text-right">
                        <?php Html::a('<i class="fa fa-edit"></i>', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                        <?php if(Yii::$app->user->can('delete')): ?>
                            <?= Html::a('<i class="fa fa-trash"></i>', ['delete', 'id' => $model->id], [
                                'class' => 'btn btn-danger',
                                'data'  => [
                                    'confirm' => Yii::t('app', 'Ви впевнені?'),
                                    'method'  => 'post',
                                ],
                            ]) ?>
                        <?php endif; ?>
                    </p>

                    <?= DetailView::widget([
                        'model'      => $model,
                        'attributes' => [
                            [
                                'attribute' => 'num',
                                'value'     => $model->formatNum,
                                'visible'   => $model->num,
                            ],
                            [
                                'attribute' => 'id_vendor',
                                'value'     => $model->vendor ? $model->vendor->name : '',
                                'visible'   => $model->id_vendor,
                            ],
                            [
                                'attribute' => 'id_warehouse',
                                'value'     => $model->warehouse ? $model->warehouse->name : '',
                                'visible'   => $model->id_warehouse,
                            ],
                            [
                                'attribute' => 'created_at',
                                'format'    => 'datetime',
                                'visible'   => $model->created_at,
                            ],
                        ],
                    ]) ?>


                    <?php if ($products = $model->incomeProduct): ?>
                        <label class="form-label"><?= Yii::t('app', 'Товари') ?></label>
                        <div class="card">
                            <div class="table-responsive">
                                <table class="table table-vcenter card-table">
                                    <thead>
                                    <tr>
                                        <th><?= Yii::t('app', 'Назва') ?></th>
                                        <th><?= Yii::t('app', 'Артикул') ?></th>
                                        <th class="text-center"><?= Yii::t('app', 'Ціна') ?></th>
                                        <th class="text-center"><?= Yii::t('app', 'Кількість') ?></th>
                                        <th class="text-center"><?= Yii::t('app', 'Сума') ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($products as $product): ?>
                                        <?php /* @var \common\models\IncomeProduct $product */ ?>
                                        <tr>
                                            <td>
                                                <div>
                                                    <?php if ($productModel = $product->product): ?>
                                                        <strong><?= Html::encode($productModel->brand->name) ?></strong>
                                                    <?php endif; ?>
                                                    <?= Html::encode($product->product_name) ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-muted"><?= Html::encode($product->upc) ?></div>
                                            </td>
                                            <td class="text-muted text-center">
                                                <?= Yii::$app->formatter->asCurrency($product->price, 'USD') ?>
                                            </td>
                                            <td class="text-center">
                                                <?= $product->quantity ?>
                                            </td>
                                            <td class="text-center">
                                                <?= Yii::$app->formatter->asCurrency($product->quantity * $product->price, 'USD') ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</div>
