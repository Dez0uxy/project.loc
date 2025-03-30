<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Category;
use common\models\Warehouse;

/** @var yii\web\View $this */
/** @var common\models\Product $model */
/** @var yii\widgets\ActiveForm $form */

$this->title = Yii::t('app', 'Створити');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Товари'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div style="display: flex; justify-content: center; margin-top: 20px;">

    <div style="width: 1600px; max-width: 100%; border: 1px solid #ddd; padding: 20px; border-radius: 5px; background-color: #f9f9f9;">
        <div class="product-create">

            <h1><?= Html::encode($this->title) ?></h1>


            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'upc')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'applicable')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'id_warehouse')->dropDownList(\common\models\Warehouse::getArray()) ?>
            
            <?= $form->field($model, 'image_path')->fileInput() ?>

            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Зберегти'), ['class' => 'btn btn-success']) ?>
            </div>
            

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>