<?php

/* @var $this yii\web\View */

/* @var $model \common\models\Product */

use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="grid_1_of_5 images_1_of_5">
    <a href="<?= Url::to(['product/index', 'id' => $model->id, 'url' => $model->url]) ?>">
        <?php if($image = $model->image): ?>
        <?= Html::img(Yii::$app->urlManagerFrontEnd->createUrl('/') . 'images/resize/1/200x200/' . $image->id.'.'.$image->ext, [
            //'width' => '80%',
            'alt' => 'Придбати ' . Html::encode($model->name),
            'title' => 'Придбати ' . Html::encode($model->name),
        ]); ?>
        <?php else: ?>
            <?= Html::img('/images/no-img.png', [
                'width' => '200',
                'alt' => 'Придбати ' . Html::encode($model->name),
                'title' => 'Придбати ' . Html::encode($model->name),
            ]); ?>
        <?php endif; ?>
    </a>
    <a href="<?= Url::to(['product/index', 'id' => $model->id, 'url' => $model->url]) ?>">
        <h3><?= Html::encode($model->name) ?></h3></a>
    <p><?= Html::encode($model->upc) ?></p>
    <h4><?= Yii::$app->formatter->asCurrency($model->priceUah) ?></h4>
    <div class="button">
        <span>
            <?php if($model->count > 0): ?>
                <?= Html::a('Придбати ', ['product/index', 'id' => $model->id, 'url' => $model->url], ['class' => 'buybtn', 'data-pajx' => '0']) ?>
            <?php else: ?>
                <?= Html::a('Під замовлення', ['product/index', 'id' => $model->id, 'url' => $model->url], ['class' => 'buybtn', 'data-pajx' => '0', 'rel' => 'nofollow']) ?>
            <?php endif; ?>
        </span>
    </div>
</div>
