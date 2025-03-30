<?php

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model common\models\Cashdesk */
/* @var $form yii\widgets\ActiveForm */


$this->registerJs(
    '$("document").ready(function(){
            $("#cashdesk_item").on("pjax:end", function() {
            $("#close__modal").trigger("click");
            toastr.success("' . Yii::t('app', 'Збережено') . '");
        });
    });'
);


?>
<?php Pjax::begin(['id' => 'cashdesk_item', 'enablePushState' => false]) ?>
<?php $form = ActiveForm::begin([
    'action'  => ['/cashdesk/create'],
    'options' => ['data-pjax' => true],

]); ?>

<div class="row">
    <div class="col-lg-11">
        <?= $form->field($model, 'id_order')->hiddenInput() ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-11">
        <?= $form->field($model, 'amount')->textInput(['type' => 'number', 'step' => '0.01', 'placeholder' => '200.00']) ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-11">
        <?= $form->field($model, 'id_method')->dropDownList(\common\models\CashdeskMethod::getArray()) ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-11">
        <?= $form->field($model, 'note')->textInput(['maxlength' => true, 'placeholder' => '']) ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-6 pt-5 mt-1">
        <?= Html::submitButton('<i class="fa fa-save"></i>', ['class' => 'btn btn-success']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>
<?php Pjax::end(); ?>
