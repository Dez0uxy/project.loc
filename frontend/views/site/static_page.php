<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model \common\models\StaticPage */

$this->title = empty($model->meta_title) ? $model->title : $model->meta_title;
$this->registerMetaTag(['name' => 'description', 'content' => $model->meta_description], 'description');
$this->registerMetaTag(['name' => 'keywords', 'content' => $model->meta_keywords], 'keywords');
$this->registerMetaTag(['property' => 'og:title', 'content' => $this->title], 'og:title');
$this->registerMetaTag(['property' => 'og:description', 'content' => $model->meta_description], 'og:description');
$this->registerMetaTag(['property' => 'og:url', 'content' => Url::to('', true)], 'og:url');

$this->registerMetaTag(['property' => 'og:url', 'content' => \yii\helpers\Url::to('', true)], 'og:url');
$this->registerMetaTag(['property' => 'og:image', 'content' => \yii\helpers\Url::to('/', true).'images/Main4.png'], 'og:image');
$this->registerMetaTag(['property' => 'og:image:type', 'content' => 'image/png'], 'og:image:type');
$this->registerMetaTag(['property' => 'og:image:width', 'content' => 483], 'og:image:width');
$this->registerMetaTag(['property' => 'og:image:height', 'content' => 292], 'og:image:height');

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content">
    <div class="static_pages">
        <h1><?= Html::encode($model->title) ?></h1>
        <?= $model->content ?>
    </div>
</div>
