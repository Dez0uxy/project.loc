<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CustomerSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="customer-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'email') ?>

    <?= $form->field($model, 'discount') ?>

    <?= $form->field($model, 'lastname') ?>

    <?= $form->field($model, 'firstname') ?>

    <?php // echo $form->field($model, 'middlename') ?>

    <?php // echo $form->field($model, 'birthdate') ?>

    <?php // echo $form->field($model, 'tel') ?>

    <?php // echo $form->field($model, 'tel2') ?>

    <?php // echo $form->field($model, 'company') ?>

    <?php // echo $form->field($model, 'address') ?>

    <?php // echo $form->field($model, 'city') ?>

    <?php // echo $form->field($model, 'region') ?>

    <?php // echo $form->field($model, 'automark') ?>

    <?php // echo $form->field($model, 'automodel') ?>

    <?php // echo $form->field($model, 'carrier') ?>

    <?php // echo $form->field($model, 'carrier_city') ?>

    <?php // echo $form->field($model, 'carrier_branch') ?>

    <?php // echo $form->field($model, 'carrier_tel') ?>

    <?php // echo $form->field($model, 'carrier_fio') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
