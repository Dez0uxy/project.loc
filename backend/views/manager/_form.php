<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \backend\models\ManagerForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-lg-6">
            <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'placeholder' => 'user@mail.com']) ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'tel')->widget(\yii\widgets\MaskedInput::className(), [
                'mask'    => '+99(999) 999-99-99',
                'options' => [
                    'placeholder' => '+38(099) 999-99-99'
                ],
            ]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <?= $form->field($model, 'lastname')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'firstname')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'secret']) ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'status')->dropDownList(\common\models\User::getStatusArray()) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-save"></i>', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
