<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\NpInternetDocument */

$this->title = Yii::t('app', 'Редагування: {name}', [
    'name' => $model->TrackingNumber,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Експрес-накладні'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Редагування');
?>
<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title"><?= Html::encode($this->title) ?></h1>
        </div>

        <div class="card card-lg">
            <div class="card-body">

                <div class="np-internet-document-update">

                    <?= $this->render('_form', [
                        'model' => $model,
                    ]) ?>

                </div>
            </div>
        </div>
    </div>
</div>
