<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ProductSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-search">

    <?php $form = ActiveForm::begin([
        //'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php // echo  $form->field($model, 'id') ?>

    <?php // echo  $form->field($model, 'id_category') ?>

    <?php // echo  $form->field($model, 'id_brand') ?>

    <?php // echo  $form->field($model, 'id_warehouse') ?>

    <?php // echo  $form->field($model, 'id_image') ?>

    <?php // echo $form->field($model, 'name') ?>

    <?php // echo $form->field($model, 'url') ?>

    <?php echo $form->field($model, 'upc') ?>

    <?php // echo $form->field($model, 'count') ?>

    <?php // echo $form->field($model, 'price') ?>

    <?php // echo $form->field($model, 'weight') ?>

    <?php // echo $form->field($model, 'analog') ?>

    <?php // echo $form->field($model, 'applicable') ?>

    <?php // echo $form->field($model, 'is_new') ?>

    <?php // echo $form->field($model, 'extra_charge') ?>

    <?php // echo $form->field($model, 'currency') ?>

    <?php // echo $form->field($model, 'ware_place') ?>

    <?php // echo $form->field($model, 'note') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'meta_keywords') ?>

    <?php // echo $form->field($model, 'meta_description') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Знайти'), ['class' => 'btn btn-primary']) ?>
        <?php // echo  Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
