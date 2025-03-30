<?php

use kartik\typeahead\TypeaheadBasic;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model common\models\FilterAuto */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="filter-auto-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <div class="row">
        <div class="col-lg-4">
            <?php if($model->id_product): ?>
                <?= $form->field($model, 'id_product')->dropdownList([$model->id_product => \common\models\Product::findOne($model->id_product)->name], ['disabled' => 'disabled']) ?>
            <?php else: ?>
            <?= $form->field($model, 'id_product')->widget(\kartik\select2\Select2::classname(), [
                //'data'          => isset($data) ? $data : [],
                'options'       => ['multiple' => false, 'class' => 'prod_select form-control'],
                'pluginOptions' => [
                    'width'              => '100%',
                    'allowClear'         => false,
                    'minimumInputLength' => 3,
                    'ajax'               => [
                        'url'            => Url::to(['/product/product-list']),
                        'dataType'       => 'json',
                        'delay'          => 250,
                        'data'           => new JsExpression('function(params) { return {q:params.term, page: params.page}; }'),
                        'processResults' => new JsExpression('function (data, params) {return {results: data.results};}'),
                        'cache'          => true,
                    ],
                    //'escapeMarkup'       => new JsExpression('function (markup) { return markup; }'),
                    //'templateResult'     => new JsExpression('formatResult'),
                    //'templateSelection'  => new JsExpression('function (data) {return data.text;}'),
                ],
                'pluginEvents'  => [
                    // moved to dynamicform afterInsert event at the bottom
                    //"select2:select" => new JsExpression($setPriceJs),
                ]
            ]) ?>
            <?php endif; ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'vendor')->widget(TypeaheadBasic::classname(), [
                'data'          => $model::getVendorArray(),
                'options'       => ['placeholder' => '...'],
                'pluginOptions' => ['highlight' => true, 'minLength' => 0],
            ]) ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'model')->widget(TypeaheadBasic::classname(), [
                'data'          => $model::getModelsArray(),
                'options'       => ['placeholder' => '...'],
                'pluginOptions' => ['highlight' => true, 'minLength' => 0],
            ]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <?= $form->field($model, 'year')->textInput(['maxlength' => true, 'placeholder' => '1996;1997;1998;1999;2000']) ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'engine')->textInput(['maxlength' => true, 'placeholder' => '2.4;3.3;3.8']) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-save"></i>', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
