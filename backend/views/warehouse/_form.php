<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Warehouse */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="warehouse-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-lg-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'region')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'delivery_time')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'delivery_price')->textInput() ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'delivery_terms')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <?= $form->field($model, 'extra_charge')->textInput() ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'currency')->dropDownList(\common\models\Currency::getArray()) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <?= $form->field($model, 'is_new')->dropDownList([1 => Yii::t('app','Так'), 0 => Yii::t('app','Ні')]) ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'status')->dropDownList($model::getStatusArray()) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-save"></i>', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
