<?php

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ProductQuantity */

$this->title = Yii::t('app','Перемістити') . ' товар ' . $model->product->name  . ' з ' . $model->warehouse->name;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Товари'), 'url' => ['/product/index']];
$this->params['breadcrumbs'][] = ['label' => $model->product->name, 'url' => ['/product/view', 'id' => $model->id_product]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title"><?= Html::encode($this->title) ?></h1>
        </div>

        <div class="card card-lg">
            <div class="card-body">

                <div class="product-inventory-move">

                    <?= Yii::t('app','Перемістити') ?> <?= Yii::t('app','товар') ?>
                    <b class="text-primary"><?= $model->product->name ?></b>
                    <?= Yii::t('app','зі складу') ?>
                    <b class="text-azure"><?= $model->warehouse->name ?></b>
                    <?= Yii::t('app','на') ?> &darr;

                    <?= Html::beginForm(['move', 'id' => $model->id], 'post', ['id' => 'product-inventory-move__form']) ?>

                    <div class="row mt-2 mb-2">
                        <div class="col-lg-2">
                            <?php $warehouseArray = \common\models\Warehouse::getArray(); unset($warehouseArray[$model->warehouse->id]); ?>
                            <?= Html::dropDownList('id_warehouse', null, $warehouseArray, ['class' => 'form-control'])?>
                        </div>
                        <div class="col-lg-2">
                            <?= Html::input('number', 'count', $model->count, ['min' => 0, 'max' => $model->count, 'class' => 'form-control'])?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?= Html::submitButton('<i class="fa fa-save"></i>', ['class' => 'btn btn-success']) ?>
                    </div>

                    <?= Html::endForm() ?>

                </div>
            </div>
        </div>
    </div>
</div>
