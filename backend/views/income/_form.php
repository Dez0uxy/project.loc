<?php

use kidzen\dynamicform\DynamicFormWidget;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model common\models\Income */
/* @var $modelsProduct common\models\IncomeProduct[] */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="income-form">

    <?php $form = ActiveForm::begin(['id' => 'income-form']); ?>

    <div class="row">
        <div class="col-lg-2">
            <?= $form->field($model, 'num')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-5">
            <?= $form->field($model, 'id_vendor')->dropDownList(\common\models\Vendor::getArray()) ?>
        </div>
        <div class="col-lg-5">
            <?= $form->field($model, 'id_warehouse')->dropDownList(\common\models\Warehouse::getArray()) ?>
        </div>
    </div>

    <fieldset class="form-fieldset">
        <label class="form-label"><?= Yii::t('app', 'Товари') ?></label>

        <?php
        DynamicFormWidget::begin([
            'widgetContainer' => 'dynamicform_wrapper',
            'widgetBody'      => '.container-items',
            'widgetItem'      => '.product-item',
            'limit'           => 100,
            'min'             => 1,
            'insertButton'    => '.add-item',
            'deleteButton'    => '.remove-item',
            'model'           => $modelsProduct[0],
            'formId'          => 'income-form',
            'formFields'      => [
                'id_product',
                'price',
                'quantity',
            ],
        ]); ?>

        <?php
        $formatJs = <<< 'JS'
var formatResult = function (data) {
    if (data.loading) {
        return '...';
    }

    var markup =
'<div class="row">' + 
    '<div class="col-sm-2 font-weight-bold">' + data.brand + '</div>' +
    '<div class="col-sm-2 text-uppercase">' + data.upc + '</div>' +
    '<div class="col-sm-4">' + data.name + '</div>' +
    '<div class="col-sm-3">' + data.warehouse + ' <span class="text-muted small lh-base">(' + data.count + ' шт.)</span></div>' +
    '<div class="col-sm-1 font-weight-bold"><nobr>' + data.priceOrigFormatted + '</nobr></div>' +
'</div>';

    return '<div style="overflow:hidden;">' + markup + '</div>';
};
JS;
        // Register the formatting script
        $this->registerJs($formatJs, \yii\web\View::POS_HEAD);
        ?>

        <div class="pull-right">
            <button type="button" class="add-item btn btn-success btn-xs">
                <span class="fa fa-plus"></span></button>
        </div>
        <div class="container-items">
            <?php foreach ($modelsProduct as $i => $modelProduct): ?>
                <?php
                // necessary for update action.
                if (!$modelProduct->isNewRecord) {
                    echo Html::activeHiddenInput($modelProduct, "[{$i}]id");
                    echo Html::activeHiddenInput($modelProduct, "[{$i}]id_income");
                    $product = \common\models\Product::find()->andWhere(['id' => $modelProduct->id_product])->one();
                    $data = [$product->id => $product->brand->name . ' ' . $product->upc . ' ' . $product->name];
                }
                ?>
            <div class="row product-item">
                <div class="col-lg-7">
                    <?= $form->field($modelProduct, "[{$i}]id_product")->widget(\kartik\select2\Select2::classname(), [
                        'data'          => isset($data) ? $data : [],
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
                            'escapeMarkup'       => new JsExpression('function (markup) { return markup; }'),
                            'templateResult'     => new JsExpression('formatResult'),
                            'templateSelection'  => new JsExpression('function (data) {return data.text;}'),
                        ],
                        'pluginEvents'  => [
                            // moved to dynamicform afterInsert event at the bottom
                            //"select2:select" => new JsExpression($setPriceJs),
                        ]
                    ]);
                    ?>
                </div>
                <div class="col-lg-2">
                    <?= $form->field($modelProduct, "[{$i}]price")->textInput(['type' => 'number', 'step' => '0.01', 'placeholder' => '0.00']) ?>
                </div>
                <div class="col-lg-2">
                    <?= $form->field($modelProduct, "[{$i}]quantity")->textInput(['type' => 'number', 'placeholder' => '1']) ?>
                </div>
                <div class="col-lg-1">
                    <button type="button" class="remove-item btn btn-danger btn-xs">
                        <span class="fa fa-minus"></span></button>
                </div>
            </div>
            
            <?php endforeach; ?>
        </div>

        <?php DynamicFormWidget::end(); ?>
    </fieldset>

    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-save"></i>', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
    function registerProdSelectEvent() {
        jQuery('.prod_select').on('select2:select', function (e) {
            var selectId = e.delegateTarget.id;
            var priceId = selectId.replace('id_product', 'price');
            var quantityId = selectId.replace('id_product', 'quantity');
            $('#' + priceId).val(e.params.data.priceOrig);
            $('#' + quantityId).val(1);
        });
    }
    registerProdSelectEvent();

    $(".dynamicform_wrapper").on("beforeDelete", function(e, item) {
        //if (! confirm("Are you sure you want to delete this item?")) {
        //    return false;
        //}
        return true;
    });
    // beforeInsert for new product added by dynamicform
    $(".dynamicform_wrapper").on("beforeInsert", function(e, item) {
        //console.log(e);
        //console.log(item);
    });
    // afterInsert for new product added by dynamicform, register set price function for new select2 instance
    $(".dynamicform_wrapper").on("afterInsert", function(e, item) {
        //console.log("afterInsert");
        registerProdSelectEvent();
    });
</script>
