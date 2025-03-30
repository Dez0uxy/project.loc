<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\WarehouseSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="warehouse-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'region') ?>

    <?= $form->field($model, 'delivery_time') ?>

    <?= $form->field($model, 'delivery_price') ?>

    <?php // echo $form->field($model, 'delivery_terms') ?>

    <?php // echo $form->field($model, 'extra_charge') ?>

    <?php // echo $form->field($model, 'currency') ?>

    <?php // echo $form->field($model, 'is_new') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
