<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\VinRequest */

$this->title = Yii::t('app', 'Створити');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'VIN Запити'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title"><?= Html::encode($this->title) ?></h1>
        </div>

        <div class="card card-lg">
            <div class="card-body">
                <div class="vin-request-create">

                    <?= $this->render('_form', [
                        'model' => $model,
                    ]) ?>

                </div>
            </div>
        </div>
    </div>
</div>
