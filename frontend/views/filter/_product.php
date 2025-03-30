<?php

/* @var $this yii\web\View */

/* @var $model \common\models\Product */

use yii\helpers\Html;
use yii\helpers\Url;

?>
<a href="<?= Url::to(['product/index', 'id' => $model->id, 'url' => $model->url]) ?>">
    <div class="frame">
        <span class="helper"></span>
        <?php if ($image = $model->image): ?>
            <?= Html::img(Yii::$app->urlManagerFrontEnd->createUrl('/') . 'images/resize/2/255x170/' . $image->id . '.' . $image->ext, [
                //'width' => '80%',
                'alt' => 'Придбати ' . Html::encode($model->name),
                'title' => 'Придбати ' . Html::encode($model->name),
            ]); ?>
        <?php else: ?>
            <?= Html::img('images/no-img.png', [
                'alt' => 'Придбати ' . Html::encode($model->name),
                'title' => 'Придбати ' . Html::encode($model->name),
            ]); ?>
        <?php endif; ?>
    </div>
    <span class="p-name"><?= Html::encode($model->name) ?></span>
</a>
<span class="p-brand"><?= $model->brand ? $model->brand->name : '' ?></span>
<span class="code"><?= Html::encode($model->upc) ?></span>
<span class="check"><?= $model->availability ?: 'В наявності' ?></span>
<span class="price"><?= Yii::$app->formatter->asCurrency($model->priceUah) ?></span>

<?php if ($model->count > 0): ?>
    <?php Html::a('Придбати', ['cart/add', 'id' => $model->id], ['class' => 'buy', 'data-pajx' => '0', 'style' => 'width:100% !important;']) ?>
<?php else: ?>
    <?php Html::a('Запросити під замовлення', ['site/contact', 'msg' => urlencode('Під замовлення артикул ' . $model->upc)], ['class' => 'buy', 'style' => 'width:100% !important;', 'data-pajx' => '0', 'rel' => 'nofollow']) ?>
<?php endif; ?>
