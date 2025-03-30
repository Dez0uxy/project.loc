<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ActionLog */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="action-log-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'table_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_model')->textInput() ?>

    <?= $form->field($model, 'id_user')->textInput() ?>

    <?= $form->field($model, 'ipv4')->textInput() ?>

    <?= $form->field($model, 'action')->dropDownList(['create' => 'Create', 'view' => 'View', 'update' => 'Update', 'delete' => 'Delete', 'export' => 'Export', 'print' => 'Print',], ['prompt' => '']) ?>

    <?= $form->field($model, 'data')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
