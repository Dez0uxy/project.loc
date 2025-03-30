<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\OrderSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'id_manager') ?>

    <?= $form->field($model, 'id_customer') ?>

    <?= $form->field($model, 'c_fio') ?>

    <?= $form->field($model, 'c_email') ?>

    <?php // echo $form->field($model, 'c_tel') ?>

    <?php // echo $form->field($model, 'o_address') ?>

    <?php // echo $form->field($model, 'o_city') ?>

    <?php // echo $form->field($model, 'o_comments') ?>

    <?php // echo $form->field($model, 'o_payment') ?>

    <?php // echo $form->field($model, 'o_shipping') ?>

    <?php // echo $form->field($model, 'o_total') ?>

    <?php // echo $form->field($model, 'is_paid') ?>

    <?php // echo $form->field($model, 'ip') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
