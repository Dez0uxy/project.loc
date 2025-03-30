<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model common\models\Product */
/* @var $modelFilterAuto common\models\FilterAuto */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->registerCss('
.table th {
    font-size: 16px;
    font-weight: 600;
    color: #232526;
}
.table td {
    font-size: 18px;
    font-weight: 700;
    color: #232526;
}
');

$this->title                   = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Товари'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="my-3 my-md-5">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <div class="container">
        <div class="page-header">
            <h1 class="page-title"><?= Html::encode($this->title) ?></h1>
        </div>

        <?= \backend\widgets\Alert::widget() ?>
        <div class="card card-lg">
            <div class="card-body">

                <div class="product-view">

                    <p>
                        <?= Html::a('<i class="fa fa-edit"></i>', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('<i class="fa fa-trash"></i>', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger',
                            'data'  => [
                                'confirm' => Yii::t('app', 'Ви впевнені?'),
                                'method'  => 'post',
                            ],
                        ]) ?>
                    </p>

                    <?= DetailView::widget([
                        'model'      => $model,
                        'attributes' => [
                            [
                                'attribute' => 'name',
                                'visible'   => $model->name,
                            ],
                            [
                                'attribute' => 'id_category',
                                'visible'   => $model->id_category,
                                'value'     => $model->category ? $model->category->name : '-',
                            ],
                            [
                                'attribute' => 'id_brand',
                                'visible'   => $model->id_brand,
                                'value'     => $model->brand ? $model->brand->name : '-',
                            ],
//                            [
//                                'attribute' => 'id_warehouse',
//                                'visible'   => $model->id_warehouse,
//                                'value'     => $model->warehouse ? $model->warehouse->name : '-',
//                            ],
                            [
                                'attribute' => 'id_image',
                                'format'    => 'html',
                                'visible'   => $model->id_image,
                                'value'     => ($image = $model->image) ?
                                    Html::img(Yii::$app->urlManagerFrontEnd->createUrl('/') . 'images/resize/1/200x200/' . $image->id . '.' . $image->ext)
                                    : '-',
                            ],
                            [
                                'attribute' => 'url',
                                'format'    => 'html',
                                'visible'   => $model->url,
                                'value'     => Html::a(Yii::$app->urlManagerFrontEnd->createUrl(['product/index', 'id' => $model->id, 'url' => $model->url]), Yii::$app->urlManagerFrontEnd->createUrl(['product/index', 'id' => $model->id, 'url' => $model->url])),
                            ],
                            [
                                'attribute' => 'upc',
                                'visible'   => $model->upc,
                            ],
//                            [
//                                'attribute' => 'count',
//                                'visible'   => $model->count,
//                            ],
//                            [
//                                'attribute' => 'price',
//                                'visible'   => $model->price,
//                                'value'     => Yii::$app->formatter->asCurrency($model->price, $model->currency),
//                            ],
                            [
                                'attribute' => 'weight',
                                'visible'   => $model->weight,
                            ],
                            [
                                'attribute' => 'analog',
                                'visible'   => $model->analog,
                            ],
                            [
                                'attribute' => 'applicable',
                                'visible'   => $model->applicable,
                            ],
                            [
                                'attribute' => 'is_new',
                                'visible'   => $model->is_new,
                                'value'     => $model->is_new ? Yii::t('app', 'так') : Yii::t('app', 'ні'),
                            ],
                            [
                                'attribute' => 'currency',
                                'visible'   => $model->currency,
                            ],
                            [
                                'attribute' => 'ware_place',
                                'visible'   => $model->ware_place,
                            ],
                            [
                                'attribute' => 'note',
                                'visible'   => $model->note,
                            ],
                            [
                                'attribute' => 'description', 
                                'format'    => 'ntext',
                                'visible'   => $model->description,
                            ],
                            [
                                'attribute' => 'meta_keywords',
                                'visible'   => $model->meta_keywords,
                            ],
                            [
                                'attribute' => 'meta_description',
                                'visible'   => $model->meta_description,
                            ],
                            [
                                'attribute' => 'status',
                                'visible'   => $model->status,
                                'value'     => $model->statusName,
                            ],
                            [
                                'attribute' => 'prom_export',
                                'visible'   => $model->prom_export,
                                'value'     => $model->prom_export ? 'так' : 'ні',
                            ],
                        ],
                    ]) ?>

                    <h2 class="pt-5">Склад Наявність Ціна</h2>
                    <?php if ($productQuantity = $model->productQuantity): ?>
                        <table class="product_quantity table table-striped table-bordered" style="width: 100%;">
                            <tr>
                                <th>Склад</th>
                                <th>Місце</th>
                                <th>Наявність (шт.)</th>
                                <th>Ціна (грн.)</th>
                                <th>&rarr;</th>
                            </tr>
                            <?php foreach ($productQuantity as $pq): ?>
                                <tr>
                                    <td><?= $pq->warehouse ? $pq->warehouse->alias : '' ?></td>
                                    <td><?= $pq->warehousePlace ? $pq->warehousePlace->name : '' ?></td>
                                    <td><?= $pq->warehouse ? $pq->count : '' ?></td>
                                    <td><?= Yii::$app->formatter->asCurrency($pq->priceUah) ?></td>
                                    <td style="white-space: nowrap;">
                                        <div style="display: flex; gap: 5px; flex-wrap: wrap;">
                                            <?= Html::a(Yii::t('app', 'Перемістити'), ['product-inventory/move', 'id' => $pq->id], ['class' => 'btn btn-success']) ?>
                    
                                            <?php if ($pq->count == 0 && count($productQuantity) > 1): ?>
                                                <?= Html::a(Yii::t('app', 'Видалити склад'), ['delete-quantity', 'id' => $pq->id], ['class' => 'btn btn-danger']) ?>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    <?php endif; ?>



                    <h2 class="pt-5">Застосування до авто</h2>
                    <?= $this->render('/filter-auto/_form_template',[
                        'model' => $modelFilterAuto,
                    ]) ?>
                    
                    <?php Pjax::begin(['id' => 'applicability']) ?>
                    <?= \kartik\grid\GridView::widget([
                        'dataProvider' => $dataProvider,
                        'columns'      => [
                            ['class' => 'yii\grid\SerialColumn'],
                            
                            [
                                'attribute' => 'vendor',
                            ],
                            [
                                'attribute' => 'model',
                            ],
                            'year',
                            'engine',
                            [
                                'class'         => \kartik\grid\ActionColumn::className(),
                                'urlCreator'    => function ($action, \common\models\FilterAuto $model, $key, $index, $column) {
                                    return Url::toRoute([$action, 'id' => $model->id]);
                                },
                                'headerOptions' => ['style' => 'width: 80px;'],
                                'template'      => '{delete}',
                                'buttons'       => [
                                    'view'   => function ($url, $model, $key) {
                                        return Html::a('<i class="ti ti-eye"></i>', Url::to(['view', 'id' => $model->id]));
                                    },
                                    'update' => function ($url, $model, $key) {
                                        return Html::a('<i class="ti ti-pencil"></i>', Url::to(['update', 'id' => $model->id]));
                                    },
                                    'delete' => function ($url, $model, $key) {
                                        return Html::a('<i class="ti ti-trash"></i>', Url::to(['filter-auto/delete', 'id' => $model->id]),
                                            [
                                                'onclick' => "if (confirm('Видалити?')) {
                                                      $.ajax('/filter-auto/delete?id=".$model->id."', {
                                                          type: 'GET'
                                                      }).done(function(data) {
                                                           $.pjax.reload({container: '#applicability'});
                                                      });
                                                  }
                                                  return false;
                                                  "
                                            ]);
                                    },
                                ],
                            ],
                        ],
                    ]); ?>
                    <?php Pjax::end() ?>

                </div>
            </div>
        </div>
    </div>
</div>
