<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\Order */

if (!isset($model)) {
    throw new \yii\web\NotFoundHttpException(Yii::t('app', 'Замовлення не знайдено.'));
}

$this->title = Yii::t('app', 'Замовлення') . ' №' . $model->num;
\yii\web\YiiAsset::register($this);
?>

<div class="content">
    <div class="static_pages">
        <h1 class="page-title"><?= Html::encode($this->title) ?></h1> 
    </div>

    <div class="card-body">
        <div class="order">
            <?php if ($products = $model->orderProduct): ?>
                <label class="form-label"><?= Yii::t('app', 'Товари') ?></label>
                
                <?= GridView::widget([
                    'dataProvider' => new \yii\data\ArrayDataProvider([
                        'allModels' => $products,
                        'pagination' => false,
                    ]),
                    'columns' => [
                        [
                            'attribute' => 'brand',
                            'header' => Yii::t('app', 'Бренд'),
                            'value' => fn($product) => Html::encode($product->product->brand->name),
                        ],
                        [
                            'attribute' => 'product_name',
                            'header' => Yii::t('app', 'Назва'),
                            'format' => 'raw',
                            'value' => fn($product) => Html::a(Html::encode($product->product_name), ['/product', 'id' => $product->id_product]),
                        ],
                        [
                            'attribute' => 'upc',
                            'header' => Yii::t('app', 'Артикул'),
                            'value' => fn($product) => Html::encode($product->upc),
                        ],
                        [
                            'attribute' => 'price',
                            'header' => Yii::t('app', 'Ціна'),
                            'value' => fn($product) => Yii::$app->formatter->asCurrency($product->price),
                        ],
                        [
                            'attribute' => 'quantity',
                            'header' => Yii::t('app', 'Кількість'),
                            'value' => fn($product) => $product->quantity,
                        ],
                        [
                            'header' => Yii::t('app', 'Сума'),
                            'value' => fn($product) => Yii::$app->formatter->asCurrency($product->quantity * $product->price),
                        ],
                        [
                            'attribute' => 'warehouse',
                            'header' => Yii::t('app', 'Склад'),
                            'value' => fn($product) => $product->warehouse ? Html::encode($product->warehouse->alias) : '',
                        ],
                    ],
                ]); ?>

                <div class="total-sum">
                    <strong><?= Yii::t('app', 'Сумарна вартість: ') ?><?= Yii::$app->formatter->asCurrency(array_sum(array_map(fn($product) => $product->quantity * $product->price, $products))) ?></strong>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

