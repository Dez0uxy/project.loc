<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\NpInternetDocument */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="np-internet-document-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'TrackingNumber')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'senderFirstName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'senderMiddleName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'senderLastName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'senderDescription')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'senderPhone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'senderCity')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'senderRegion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'senderCitySender')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'senderSenderAddress')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'senderWarehouse')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'recipientFirstName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'recipientMiddleName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'recipientLastName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'recipientPhone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'recipientCity')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'recipientRegion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'recipientWarehouse')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'DateTime')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ServiceType')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PaymentMethod')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Cost')->textInput() ?>

    <?= $form->field($model, 'SeatsAmount')->textInput() ?>

    <?= $form->field($model, 'Description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CargoType')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Weight')->textInput() ?>

    <?= $form->field($model, 'VolumeGeneral')->textInput() ?>

    <?= $form->field($model, 'BackDelivery_PayerType')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'BackDelivery_CargoType')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'BackDelivery_RedeliveryString')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-save"></i>', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
