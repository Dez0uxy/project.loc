<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\NpInternetDocumentSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="np-internet-document-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'TrackingNumber') ?>

    <?= $form->field($model, 'senderFirstName') ?>

    <?= $form->field($model, 'senderMiddleName') ?>

    <?= $form->field($model, 'senderLastName') ?>

    <?php // echo $form->field($model, 'senderDescription') ?>

    <?php // echo $form->field($model, 'senderPhone') ?>

    <?php // echo $form->field($model, 'senderCity') ?>

    <?php // echo $form->field($model, 'senderRegion') ?>

    <?php // echo $form->field($model, 'senderCitySender') ?>

    <?php // echo $form->field($model, 'senderSenderAddress') ?>

    <?php // echo $form->field($model, 'senderWarehouse') ?>

    <?php // echo $form->field($model, 'recipientFirstName') ?>

    <?php // echo $form->field($model, 'recipientMiddleName') ?>

    <?php // echo $form->field($model, 'recipientLastName') ?>

    <?php // echo $form->field($model, 'recipientPhone') ?>

    <?php // echo $form->field($model, 'recipientCity') ?>

    <?php // echo $form->field($model, 'recipientRegion') ?>

    <?php // echo $form->field($model, 'recipientWarehouse') ?>

    <?php // echo $form->field($model, 'DateTime') ?>

    <?php // echo $form->field($model, 'ServiceType') ?>

    <?php // echo $form->field($model, 'PaymentMethod') ?>

    <?php // echo $form->field($model, 'Cost') ?>

    <?php // echo $form->field($model, 'SeatsAmount') ?>

    <?php // echo $form->field($model, 'Description') ?>

    <?php // echo $form->field($model, 'CargoType') ?>

    <?php // echo $form->field($model, 'Weight') ?>

    <?php // echo $form->field($model, 'VolumeGeneral') ?>

    <?php // echo $form->field($model, 'BackDelivery_PayerType') ?>

    <?php // echo $form->field($model, 'BackDelivery_CargoType') ?>

    <?php // echo $form->field($model, 'BackDelivery_RedeliveryString') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
