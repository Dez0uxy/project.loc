<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\FilterAutoTemplate */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="filter-auto-template-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-lg-3">
            <?= $form->field($model, 'vendor')->widget(\kartik\typeahead\TypeaheadBasic::classname(), [
                'data'          => $model::getVendorArray(),
                'options'       => ['placeholder' => '...'],
                'pluginOptions' => ['highlight' => true, 'minLength' => 0],
            ]) ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'model')->textInput(['maxlength' => true, 'placeholder' => '...']) ?>
        </div>

        <div class="col-lg-3">
            <?= $form->field($model, 'year')->textInput(['maxlength' => true, 'placeholder' => '1996;1997;1998;1999;2000']) ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'engine')->textInput(['maxlength' => true, 'placeholder' => '2.4;3.3;3.8']) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-save"></i>', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
