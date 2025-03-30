<?php
/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = Yii::t('app', 'Продажі');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Звіти'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title"><?= Html::encode($this->title) ?></h1>
        </div>

        <div class="card card-lg">
            <div class="card-body">
            </div>
        </div>
    </div>
</div>