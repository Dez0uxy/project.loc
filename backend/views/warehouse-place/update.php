<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\WarehousePlace $model */

$this->title = 'Редагування: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Місця на складі', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редагування';
?>
<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title"><?= Html::encode($this->title) ?></h1>
        </div>

        <div class="card card-lg">
            <div class="card-body">
                <div class="warehouse-place-update">

                    <?= $this->render('_form', [
                        'model' => $model,
                    ]) ?>

                </div>
            </div>
        </div>
    </div>
</div>
