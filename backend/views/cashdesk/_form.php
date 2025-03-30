<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model common\models\Cashdesk */
/* @var $form yii\widgets\ActiveForm */
?>

<?php
$this->registerJs(
    '$("document").ready(function(){
            $("#new_item").on("pjax:end", function() {
            $.pjax.reload({container:"#cashdesk"});  //Reload GridView
        });
    });'
);
?>

<fieldset class="form-fieldset">

    <?php Pjax::begin(['id' => 'new_item']) ?>
    <?php $form = ActiveForm::begin(['options' => ['data-pjax' => true]]); ?>

    <div class="row">
        <div class="col-lg-2">
            <?= $form->field($model, 'amount')->textInput(['type' => 'number', 'step' => '0.01', 'placeholder' => '-200.00']) ?>
        </div>
        <div class="col-lg-2">
            <?= $form->field($model, 'id_method')->dropDownList(\common\models\CashdeskMethod::getArray()) ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'note')->textInput(['maxlength' => true, 'placeholder' => '']) ?>
        </div>
        <div class="col-lg-1 pt-5 mt-1">
            <?= Html::submitButton('<i class="fa fa-save"></i>', ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
    <?php Pjax::end(); ?>

</fieldset>
