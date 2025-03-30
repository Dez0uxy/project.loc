<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \backend\models\ManagerForm */
/* @var $customer common\models\Customer */

$this->title = Yii::t('app', 'Редагування: {name}', [
    'name' => $customer->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Менеджери'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $customer->name, 'url' => ['view', 'id' => $customer->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Редагування');
?>
<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title"><?= Html::encode($this->title) ?></h1>
        </div>

        <div class="card card-lg">
            <div class="card-body">

                <div class="user-update">

                    <?= $this->render('_form', [
                        'model' => $model,
                    ]) ?>

                </div>
            </div>
        </div>
    </div>
</div>
