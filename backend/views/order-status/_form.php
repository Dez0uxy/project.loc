<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\OrderStatus */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-status-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-lg-6">
            <?= $form->field($model, 'type')->dropDownList([
                $model::TYPE_ORDER   => Yii::t('app', 'Замовлення'),
                $model::TYPE_PRODUCT => Yii::t('app', 'Товар')
            ]) ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <?= $form->field($model, 'color')->widget(\kartik\color\ColorInput::classname(), [
        'options'   => ['placeholder' => '...'],
        'useNative' => false,
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-save"></i>', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
