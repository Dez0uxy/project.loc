<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = Yii::t('msg/layout', 'Доступ не дозволено');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <?= Yii::t('msg/layout', 'У вас недостатньо прав для доступу до цього розділу') ?>
    </div>

</div>
