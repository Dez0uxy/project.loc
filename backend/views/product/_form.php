<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Product */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <?php if ($model->id_image > 0 && file_exists(Yii::getAlias('@frontend/web/images/originals/').$model->id_image . '.'.$model->image->ext)): ?>
            <?php
            $pluginOptions  = [
                'showCaption' => false,
                'showRemove'  => false,
                'showUpload'  => false,
                'browseClass' => 'btn btn-primary btn-block',
                'browseIcon'  => '<i class="ti ti-camera-plus"></i> ',
                'browseLabel' => Yii::t('app','Фото'),
            ];
            $pluginOptions2 = [
                'initialPreview'       => [
                    Yii::$app->urlManagerFrontEnd->createUrl('/') .
                    '/images/originals/' . $model->id_image . '.'.$model->image->ext,
                ],
                'initialPreviewAsData' => true,
                'initialCaption'       => 'Фото',
                'initialPreviewConfig' => [
                    [
                        'caption' => '/images/originals/' . $model->id_image . '.'.$model->image->ext,
                        'size' => filesize(Yii::getAlias('@frontend/web/images/originals/').$model->id_image . '.'.$model->image->ext),
                        'url' => 'image-delete?id='.$model->id,
                        'key' => '1',
                    ],
                ],
            ];
            echo \kartik\file\FileInput::widget([
                'name'          => 'image',
                'pluginOptions' => array_merge($pluginOptions, $pluginOptions2),
                'options'       => ['accept' => 'image/*']
            ]);
            ?>
        <?php endif; ?>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <?= \delikatesnsk\treedropdown\DropdownTreeWidget::widget([
                'id'          => 'categoryList',
                'form'        => $form,
                'model'       => $model,
                'attribute'   => 'id_category',
                'label'       => $model->getAttributeLabel('id_category'),
                'multiSelect' => false,
                'searchPanel' => [
                    'visible'             => true, //show or hide search panel
                    'label'               => \Yii::t('app', 'Пошук'), //title for search panel
                    'placeholder'         => '',  //search input placeholder text
                    'searchCaseSensivity' => false //searching text inside dropdown
                ],
                'rootNode'    => [
                    'visible' => false,
                    'label'   => \Yii::t('app', 'Категорія')
                ],
                'expand'      => false,
                'items'       => \common\models\Category::getComboTree(),
            ]);
            ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'id_brand')
                ->dropDownList([null => '...'] + \common\models\Brand::getArray())
                ->label($model->getAttributeLabel('id_brand') . ' ' . Html::a('+ &rarr;', ['brand/create'], ['target' => '_blank'])) ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'id_warehouse')->dropDownList(\common\models\Warehouse::getArray()) ?>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'upc')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'id_vendor')->dropDownList(\common\models\Vendor::getArray()) ?>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-4">
            <?php $d = $model->isNewRecord ? [] : ['disabled' => 'disabled']; ?>
            <?= $form->field($model, 'price')->textInput($d) ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'currency')->dropDownList(['USD' => 'USD', 'EUR' => 'EUR', 'UAH' => 'UAH']) ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'is_new')->dropDownList([1 => Yii::t('app','так'), 0 => Yii::t('app','ні')]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'weight')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'count_min')->textInput(['type' => 'number']) ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'count_max')->textInput(['type' => 'number']) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <?= $form->field($model, 'analog')->textarea(['rows' => 6]) ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'applicable')->textarea(['rows' => 6]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'meta_keywords')->textarea(['rows' => 6]) ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'meta_description')->textarea(['rows' => 6]) ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
        </div>
    </div>

    <div class="row">
        <!--div class="col-lg-3">
            <?php $form->field($model, 'ware_place')->textInput(['maxlength' => true]) ?>
        </div-->
        <div class="col-lg-6">
            <?= $form->field($model, 'note')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'prom_export')->dropDownList([null => '', '1' => 'експортувати']) ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'status')->dropDownList($model::getStatusArray()) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-save"></i>', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
