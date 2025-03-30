<?php

/** @var yii\web\View $this */
/** @var common\models\News $news */

use yii\helpers\Html;

$this->title = $news->title;
$this->params['breadcrumbs'][] = ['label' => 'Новини', 'url' => ['site/news']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div style="width: 90%; margin: 0 auto; padding: 20px; background-color: #f9f9f9; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
    <h1 style="text-align: center; font-size: 28px; margin-bottom: 20px; color: #333;">
        <?= Html::encode($news->title) ?>
    </h1>

    <?php if (!empty($news->image)): ?>
        <div style="text-align: center; margin-bottom: 20px;">
            <img src="<?= Yii::getAlias('@web') . '/' . Html::encode($news->image) ?>" 
                 alt="<?= Html::encode($news->title) ?>" 
                 style="max-width: 100%; height: auto; border-radius: 8px;">
        </div>
    <?php endif; ?>

    <div style="font-size: 25px; color: #666; line-height: 1.6;">
        <?= nl2br(Html::encode($news->content)) ?>
    </div>

    <p style="text-align: right; font-size: 14px; color: #aaa; margin-top: 20px;">
        Опубліковано: <?= Yii::$app->formatter->asDate($news->date, 'long') ?>
    </p>

    <div style="margin-top: 30px; text-align: center;">
        <a href="<?= \yii\helpers\Url::to(['site/news']) ?>" 
           style="text-decoration: none; padding: 10px 20px; background-color: #0260AF; color: white; border-radius: 20px; font-weight: bold;">
            Повернутися до новин
        </a>
    </div>
</div>