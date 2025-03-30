<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ProductInventoryHistorySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-inventory-history-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'id_product') ?>

    <?= $form->field($model, 'id_order') ?>

    <?= $form->field($model, 'id_user') ?>

    <?= $form->field($model, 'status_prev') ?>

    <?php // echo $form->field($model, 'status_new') ?>

    <?php // echo $form->field($model, 'quantity_prev') ?>

    <?php // echo $form->field($model, 'quantity_new') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
