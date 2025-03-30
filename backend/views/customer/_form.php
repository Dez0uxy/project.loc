<?php

use kartik\depdrop\DepDrop;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model common\models\Customer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="customer-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'lastname')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'firstname')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'middlename')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'tel')->widget(\yii\widgets\MaskedInput::className(), [
                'mask'    => '+99(999) 999-99-99',
                'options' => [
                    'placeholder' => '+38(099) 999-99-99'
                ],
            ]) ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'tel2')->widget(\yii\widgets\MaskedInput::className(), [
                'mask' => '+99(999) 999-99-99',
            ]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'region')->textInput() ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-3">
            <?= $form->field($model, 'company')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'automark')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'automodel')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'autovin')->textInput(['maxlength' => true]) ?>
        </div>
        
    </div>

    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'carrier')->dropDownList([
                Yii::t('app', 'нова пошта') => Yii::t('app', 'нова пошта'),
                Yii::t('app', 'кур\'єр')    => Yii::t('app', 'кур\'єр'),
                Yii::t('app', 'самовивіз')  => Yii::t('app', 'самоввивіз'),
            ]) ?>
        </div>
        <div class="col-lg-4">
            <?php
            // Top most parent
            echo $form->field($model, 'carrier_city')->widget(\kartik\select2\Select2::classname(), [
                'options'       => [
                    'multiple'    => false,
                    'placeholder' => Yii::t('app', 'Місто'),
                ],
                //'data' => ['Киев' => 'Киев', 'Днепр' => 'Днепр'],
                'pluginOptions' => [
                    'allowClear'         => false,
                    'minimumInputLength' => 3,
                    'tokenSeparators'    => [',', ''],
                    'ajax'               => [
                        'url'      => Url::to(['/nova-poshta/cities']),
                        'dataType' => 'json',
                        'delay'    => 250,
                        'data'     => new JsExpression('function(params) { return {q:params.term}; }')
                    ],
                ],
            ]); ?>
        </div>
        <div class="col-lg-4">
            <?php
            // Child level 1
            echo $form->field($model, 'carrier_branch')->widget(DepDrop::classname(), [
                'data'           => [],
                'options'        => ['placeholder' => ''],
                'type'           => DepDrop::TYPE_SELECT2,
                'select2Options' => ['pluginOptions' => ['allowClear' => false]],
                'pluginOptions'  => [
                    'depends'     => ['customer-carrier_city'],
                    'url'         => Url::to(['/nova-poshta/warehouses']),
                    'loadingText' => '...',
                ]
            ]); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'id_manager')->dropDownList(\common\models\User::getManagerArray()) ?>
        </div>
        <div class="col-lg-2">
            <?= $form->field($model, 'discount')->textInput(['type' => 'number']) ?>
        </div>
        <div class="col-lg-2">
            <?= $form->field($model, 'type')->dropDownList([
                $model::TYPE_RETAIL     => Yii::t('app','Роздрібний клієнт'),
                $model::TYPE_CARSERVICE => Yii::t('app','СТО/Автомагазин'),
                $model::TYPE_VIP        => Yii::t('app','VIP клієнт'),
            ]) ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'birthdate')->widget(\readly24\airdatepicker\DatePicker::class, [
                'options'       => ['autocomplete' => 'off'],
                'clientOptions' => [
                    'autoClose'      => true,
                    'dateFormat'     => 'yyyy-mm-dd',
                    'todayHighlight' => true,
                    //'language'       => Yii::$app->language === 'uk-UA' ? 'ua' : 'ru'
                ]
            ]) ?>
        </div>
    </div>


    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-save"></i>', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
