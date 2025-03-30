<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php \delikatesnsk\treedropdown\DropdownTreeWidget::widget([
        'id'          => 'parentList',
        'form'        => $form,
        'model'       => $model,
        'attribute'   => 'id_parent',
        'label'       => $model->getAttributeLabel('id_parent'),
        'multiSelect' => false,
        'searchPanel' => [
            'visible'             => true, //show or hide search panel
            'label'               => \Yii::t('app', 'Пошук'), //title for search panel
            'placeholder'         => '',  //search input placeholder text
            'searchCaseSensivity' => false //searching text inside dropdown
        ],
        'rootNode'    => [
            'visible' => false,
            'label'   => \Yii::t('app', 'Батьківська категорія')
        ],
        'expand'      => false,
        'items'       => $model::getComboTree(),
    ]);
    ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList($model::getStatusArray()) ?>

    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-save"></i>', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
