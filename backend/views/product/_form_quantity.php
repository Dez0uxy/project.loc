<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ProductQuantity */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-quantity-form">

    <?php $form = ActiveForm::begin([
        'action' => ['update-quantity'],
        'method' => 'post',
        'options' => ['data-pjax' => true],
    ]); ?>

    <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>

    <p class="badge bg-azure">Склад <?= $model->warehouse->name ?></p>

    <div class="row">
        <div class="col-lg-2">
            <?= $form->field($model, 'count')->textInput([
                'type' => 'number',
                'disabled' => $model->isNewRecord ? false : true,
            ]) ?>
        </div>
        <div class="col-lg-2">
            <?= $form->field($model, 'price')->textInput() ?>
        </div>
        <div class="col-lg-2">
            <?= $form->field($model, 'id_warehouse_place')->dropDownList([null => ''] + $model->warehouse->getWarePlaces()) ?>
        </div>
        <div class="col-lg-2 d-flex align-items-end">
            <?php if (\common\models\ProductQuantity::find()->where(['id_product' => $model->id_warehouse])->count()): ?>
                <?= Html::a('Видалити склад', ['delete-quantity', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data-confirm' => 'Ви впевнені, що хочете видалити цей запис?',
                    'data-method' => 'post',
                ]) ?>
            <?php else: ?>
                <button class="btn btn-secondary" disabled></button>
            <?php endif; ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>