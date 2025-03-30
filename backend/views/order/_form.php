<?php

use kartik\depdrop\DepDrop;
use kartik\select2\Select2;
use kidzen\dynamicform\DynamicFormWidget;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model common\models\Order */
/* @var $customer common\models\Customer|bool */
/* @var $modelsProduct common\models\OrderProduct[] */
/* @var $form yii\widgets\ActiveForm */

$errorMsgReq = Yii::t('msg/layout', 'заповніть поле');
?>
<div class="order-form">

    <?php $form = ActiveForm::begin(['id' => 'order-form']); ?>

    <fieldset class="form-fieldset">

        <div class="row">
            <div class="col-lg-6">
                <?php if ($model->isNewRecord && !$customer): ?>

                    <?php
                    $formatCustomerJs = <<< 'JS'
var formatCustomerResult = function (data) {
    if (data.loading) {
        return '...';
    }

    var markup =
'<div class="row">' + 
    '<div class="col-sm-5 font-weight-bold">' + data.name + '</div>' +
    '<div class="col-sm-4 text-uppercase">' + data.tel + '</div>' +
    '<div class="col-sm-3">' + data.company + '</div>' +
'</div>';

    return '<div style="overflow:hidden;">' + markup + '</div>';
};
JS;
                    $this->registerJs($formatCustomerJs, \yii\web\View::POS_HEAD);
                    ?>

                    <?= $form->field($model, 'id_customer')->widget(Select2::classname(), [
                        'data'          => isset($data) ? $data : [],
                        'options'       => ['multiple' => false, 'class' => 'prod_select form-control'],
                        'pluginOptions' => [
                            'width'              => '100%',
                            'allowClear'         => false,
                            'minimumInputLength' => 3,
                            'ajax'               => [
                                'url'            => Url::to(['/customer/customer-list']),
                                'dataType'       => 'json',
                                'delay'          => 250,
                                'data'           => new JsExpression('function(params) { return {q:params.term, page: params.page}; }'),
                                'processResults' => new JsExpression('function (data, params) {return {results: data.results};}'),
                                'cache'          => true,
                            ],
                            'escapeMarkup'       => new JsExpression('function (markup) { return markup; }'),
                            'templateResult'     => new JsExpression('formatCustomerResult'),
                            'templateSelection'  => new JsExpression('function (data) {return data.text;}'),
                        ],
                        'pluginEvents'  => [
                            "select2:select" => new JsExpression('function (e) {if (e.params.data.id) window.location.href="?id_customer=" + e.params.data.id;}'),
                        ]
                    ])->label(Yii::t('app', 'Клієнт') . ' (' . Yii::t('app', 'буде створений якщо не вибрати') . ')');
                    ?>
                <?php else: ?>
                    <?= $form->field($model, 'id_customer')->dropDownList([$customer->id => $customer->name . ' ' . $customer->tel .
                        ($customer->discount ? ' (' . Yii::t('app', 'знижка') . ' ' . $customer->discount . '%)' : '')], [
                        'onchange' => $model->isNewRecord ? '' : 'if (this.value) window.location.href="?id_customer=" + this.value',
                        'disabled' => $model->isNewRecord,
                    ]) ?>
                <?php endif; ?>


            </div>
            <div class="col-lg-6">
                <?= $form->field($model, 'id_manager')->dropDownList(\common\models\User::getManagerArray()) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4">
                <?= $form->field($model, 'c_fio')->textInput(['maxlength' => true, 'placeholder' => 'Прізвище Ім\'я По батькові']) ?>
            </div>
            <div class="col-lg-4">
                <?= $form->field($model, 'c_email')->textInput(['maxlength' => true, 'placeholder' => 'user@mail.com']) ?>
            </div>
            <div class="col-lg-4">
                <?= $form->field($model, 'c_tel')->widget(\yii\widgets\MaskedInput::className(), [
                    'mask'    => '+99(999) 999-99-99',
                    'options' => [
                        'placeholder' => '+38(099) 999-99-99'
                    ],
                ]) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-3">
                <?= $form->field($model, 'o_shipping')->dropDownList([
                    Yii::t('app', 'нова пошта') => Yii::t('app', 'нова пошта'),
                    Yii::t('app', 'кур\'єр')    => Yii::t('app', 'кур\'єр'),
                    Yii::t('app', 'самовивіз')  => Yii::t('app', 'самоввивіз'),
                ]) ?>
            </div>
            <div class="col-lg-3">

                <div class="form-group group-order-np_city">
                    <label class="control-label"><?= Yii::t('app', 'Місто') ?>:</label>
                    <?php
                    // Top most parent
                    echo $form->field($model, 'np_city')->widget(Select2::classname(), [
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
                    ])->label(false);
                    ?>
                </div>

                <?= $form->field($model, 'o_city', ['options' => ['style' => 'display:none;']])
                    ->textInput(['maxlength' => true]) ?>

            </div>
            <div class="col-lg-6">

                <div class="form-group group-order-np_warehouse">
                    <label class="control-label"><?= Yii::t('app', 'Відділення') ?>:</label>
                    <?php
                    // Child level 1
                    echo $form->field($model, 'np_warehouse')->widget(DepDrop::classname(), [
                        'data'           => [],
                        'options'        => ['placeholder' => ''],
                        'type'           => DepDrop::TYPE_SELECT2,
                        'select2Options' => ['pluginOptions' => ['allowClear' => false]],
                        'pluginOptions'  => [
                            'depends'     => ['order-np_city'],
                            'url'         => Url::to(['/nova-poshta/warehouses']),
                            'loadingText' => '...',
                        ]
                    ])->label(false);
                    ?>
                </div>

                <?= $form->field($model, 'o_address', ['options' => ['style' => 'display:none;']])->textInput(['maxlength' => true]) ?>
            </div>

        </div>

        <div class="row">
            <div class="col-lg-3">
                <?= $form->field($model, 'o_payment')->dropDownList([
                    Yii::t('app', 'готівка')      => Yii::t('app', 'готівка'),
                    Yii::t('app', 'карта Приват') => Yii::t('app', 'карта Приват'),
                    Yii::t('app', 'карта Mono')   => Yii::t('app', 'карта Mono'),
                ]) ?>

            </div>
            <div class="col-lg-3">
                <?= $form->field($model, 'status')->dropDownList(\common\models\OrderStatus::getArray()) ?>
            </div>
            <div class="col-lg-6">
                <?= $form->field($model, 'o_comments')->textarea(['rows' => 3]) ?>

            </div>
        </div>

    </fieldset>

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
            'formId'          => 'order-form',
            'formFields'      => [
                'id_warehouse',
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
    '<div class="col-sm-4">' + data.name + ' #' + data.id + '</div>' +
    '<div class="col-sm-2">' + data.warehouse + ' <b class="small font-weight-bold">(' + data.count + ' шт.)</b></div>' +
    '<div class="col-sm-2 font-weight-bold"><nobr>' + data.priceFormatted + '</nobr></div>' +
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
                    echo Html::activeHiddenInput($modelProduct, "[{$i}]id_order");
                    $product = \common\models\Product::find()->andWhere(['id' => $modelProduct->id_product])->one();
                    $data = [$product->id => $product->brand->name . ' ' . $product->upc . ' ' . $product->name . ($modelProduct->warehouse ? ' '.$modelProduct->warehouse->name : '')];
                }
            ?>
            <div class="row product-item">
                <?= Html::activeHiddenInput($modelProduct, "[{$i}]id_warehouse") ?>
                <div class="col-lg-7">
                    <?= $form->field($modelProduct, "[{$i}]id_product")->widget(Select2::classname(), [
                        'data'          => $data ?? [],
                        'options'       => ['multiple' => false, 'class' => 'prod_select form-control'],
                        'pluginOptions' => [
                            'width'              => '100%',
                            'allowClear'         => false,
                            'minimumInputLength' => 3,
                            'ajax'               => [
                                'url'            => Url::to(['/product/product-list', 'discount' => $customer ? $customer->discount : 0]),
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
        <div class="pull-right">
            <button type="button" class="add-item btn btn-success btn-xs">
                <span class="fa fa-plus"></span></button>
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
            var wareId = selectId.replace('id_product', 'id_warehouse');
            $('#' + priceId).val(e.params.data.price);
            $('#' + wareId).val(e.params.data.id_warehouse);
            $('#' + quantityId).val(1);
        });
    }

    registerProdSelectEvent();

    $(".dynamicform_wrapper").on("beforeDelete", function (e, item) {
        //if (! confirm("Are you sure you want to delete this item?")) {
        //    return false;
        //}
        return true;
    });
    // beforeInsert for new product added by dynamicform
    $(".dynamicform_wrapper").on("beforeInsert", function (e, item) {
        //console.log(e);
        //console.log(item);
    });
    // afterInsert for new product added by dynamicform, register set price function for new select2 instance
    $(".dynamicform_wrapper").on("afterInsert", function (e, item) {
        //console.log("afterInsert");
        registerProdSelectEvent();
    });

    // shipping fields toggle

    function shippingNP() {
        $('.field-order-o_city').hide();
        $('.field-order-o_address').hide();
        $('.group-order-np_city').show();
        $('.group-order-np_warehouse').show();

        $('#order-form').yiiActiveForm('add', {
            id: 'order-np_city',
            name: 'np_city',
            container: '.field-order-np_city',
            input: '#order-np_city',
            error: '.help-block',
            validate: function (attribute, value, messages, deferred, form) {
                yii.validation.required(value, messages, {message: '<?= $errorMsgReq ?>'});
            }
        });
        $('#order-form').yiiActiveForm('add', {
            id: 'order-np_warehouse',
            name: 'np_warehouse',
            container: '.field-order-np_warehouse',
            input: '#order-np_warehouse',
            error: '.help-block',
            validate: function (attribute, value, messages, deferred, form) {
                yii.validation.required(value, messages, {message: '<?= $errorMsgReq ?>'});
            }
        });

        //$('#order-form').data('yiiActiveForm').submitting = true;
        //$('#order-form').yiiActiveForm('validate');
        //if ($('#order-form').find('.is-invalid').length) {
        $("#order-form").yiiActiveForm('remove', 'order-o_city');
        $("#order-form").yiiActiveForm('remove', 'order-o_address');
        //}
    }

    function shippingCourier() {
        $('.field-order-o_city').show();
        $('.field-order-o_address').show();
        $('#order-o_city').val('Київ');

        $('#order-form').yiiActiveForm('add', {
            id: 'order-o_city',
            name: 'o_city',
            container: '.field-order-o_city',
            input: '#order-o_city',
            error: '.help-block.help-block-error',
            validate: function (attribute, value, messages, deferred, form) {
                yii.validation.required(value, messages, {message: '<?= $errorMsgReq ?>'});
            }
        });
        $('#order-form').yiiActiveForm('add', {
            id: 'order-o_address',
            name: 'o_address',
            container: '.field-order-o_address',
            input: '#order-o_address',
            error: '.help-block.help-block-error',
            validate: function (attribute, value, messages, deferred, form) {
                yii.validation.required(value, messages, {message: '<?= $errorMsgReq ?>'});
            }
        });

        //$('#order-form').data('yiiActiveForm').submitting = true;
        //$('#order-form').yiiActiveForm('validate');
        //if ($('#order-form').find('.is-invalid').length) {
        $("#order-form").yiiActiveForm('remove', 'order-np_city');
        $("#order-form").yiiActiveForm('remove', 'order-np_warehouse');
        //}

        $('.group-order-np_city').hide();
        $('.group-order-np_warehouse').hide();
    }

    function shippingPickup() {
        //$('#order-form').data('yiiActiveForm').submitting = true;
        //$('#order-form').yiiActiveForm('validate');
        //if ($('#order-form').find('.is-invalid').length) {
        $("#order-form").yiiActiveForm('remove', 'order-o_city');
        $("#order-form").yiiActiveForm('remove', 'order-o_address');
        $("#order-form").yiiActiveForm('remove', 'order-np_city');
        $("#order-form").yiiActiveForm('remove', 'order-np_warehouse');
        //}

        $('.field-order-o_city').hide();
        $('.field-order-o_address').hide();
        $('.group-order-np_city').hide();
        $('.group-order-np_warehouse').hide();
    }

    $(document).ready(function () {

        <?php if($model->isNewRecord || $model->o_shipping === 'нова пошта'): ?>
        //shippingNP();
        <?php elseif($model->o_shipping === 'кур\'єр'): ?>
        //shippingCourier();
        <?php elseif($model->o_shipping === 'самовивіз'): ?>
        //shippingPickup();
        <?php endif; ?>

        $(document.body).on('change', '#order-o_shipping', function () {
            let val = $('#order-o_shipping').val();
            if (val == 'нова пошта') {
                shippingNP();
            } else if (val == 'кур\'єр') {
                shippingCourier();
            } else if (val == 'самовивіз') {
                shippingPickup();
            }
        });

        $('#order-form').on('beforeValidate', function (event, messages, deferreds) {
            console.log(event, messages, deferreds);

            let shipping = $('#order-o_shipping').val();
            if (shipping == 'нова пошта') {
                $("#order-form").yiiActiveForm('remove', 'order-o_city');
                $("#order-form").yiiActiveForm('remove', 'order-o_address');
            } else if (shipping == 'кур\'єр') {
                $("#order-form").yiiActiveForm('remove', 'order-np_city');
                $("#order-form").yiiActiveForm('remove', 'order-np_warehouse');

            } else if (shipping == 'самовивіз') {
                $("#order-form").yiiActiveForm('remove', 'order-o_city');
                $("#order-form").yiiActiveForm('remove', 'order-o_address');
                $("#order-form").yiiActiveForm('remove', 'order-np_city');
                $("#order-form").yiiActiveForm('remove', 'order-np_warehouse');
            }
        });

        // afterValidate
        $('#order-form').on('afterValidate', function (e, m, eattr) {
            e.preventDefault();
            if (eattr.length > 0) {
                console.log('not validated');
                console.log(eattr);
            } else {
                console.log('validated');
            }
        });
    });
</script>
