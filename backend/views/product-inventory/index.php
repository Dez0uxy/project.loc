<?php

use kartik\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProductInventoryHistorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = Yii::t('app', 'Історія інвентаризації товарів');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title"><?= Html::encode($this->title) ?></h1>
        </div>

        <div class="card card-lg">
            <div class="card-body">

                <div class="product-inventory-history-index">

                    <p>
                        <?php Html::a('<i class="fa fa-plus"></i>', ['create'], ['class' => 'btn btn-success']) ?>
                    </p>

                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel'  => $searchModel,
                        'columns'      => [
                            ['class' => 'yii\grid\SerialColumn'],
                            
                            [
                                'attribute' => 'product',
                                //'value' => 'product.name'
                                'content'   => static function ($m) {
                                    return $m->product ?
                                        Html::a($m->product->name, ['product/view', 'id' => $m->id_product], ['class' => 'small text-primary']). ' ' . $m->product->upc :
                                        $m->id_product;
                                },
                            ],
                            [
                                'attribute' => 'id_warehouse',
                                'content'   => static function ($m) {
                                    return $m->warehouse ? $m->warehouse->name : '';
                                },
                            ],
                            [
                                'attribute' => 'id_order',
                                //'headerOptions' => ['style' => 'width:100px;'],
                                'content'   => static function ($m) {
                                    return $m->order ?
                                        Html::a($m->order->name, ['order/view', 'id' => $m->id_order], ['class' => 'small text-primary']) :
                                        $m->id_order;
                                },
                            ],
                            [
                                'attribute' => 'id_user',
                                //'headerOptions' => ['style' => 'width:100px;'],
                                'content'   => static function ($m) {
                                    return $m->user ?
                                        Html::a($m->user->name, ['manager/view', 'id' => $m->id_user], ['class' => 'small font-weight-bold']) :
                                        $m->id_user;
                                },
                            ],
                            [
                                'attribute' => 'status_prev',
                                //'headerOptions' => ['style' => 'width:100px;'],
                                'content'   => static function ($m) {
                                    return ($status = \common\models\OrderStatus::findOne($m->status_prev)) ?
                                        Html::tag('span', $status->name, ['class' => 'badge badge-info']) :
                                        Html::tag('span', Yii::t('app', 'Прихід товару'), ['class' => 'badge badge-warning']);
                                },
                            ],
                            [
                                'attribute' => 'status_new',
                                //'headerOptions' => ['style' => 'width:100px;'],
                                'content'   => static function ($m) {
                                    return ($status = \common\models\OrderStatus::findOne($m->status_new)) ?
                                        Html::tag('span', $status->name, ['class' => 'badge badge-success']) :
                                        $m->status_new;
                                },
                            ],
                            'quantity_prev',
                            'quantity_new',
                            [
                                'class'               => \kartik\grid\DataColumn::class,
                                'attribute'           => 'created_at',
                                'headerOptions'       => ['style' => 'width:170px;'],
                                'content'             => function ($m) {
                                    return Yii::$app->formatter->asDatetime($m->created_at);
                                },
                                'filterType'          => GridView::FILTER_DATE,
                                'filterWidgetOptions' => [
                                    'model'         => $searchModel,
                                    'attribute'     => 'created_at',
                                    'convertFormat' => true,
                                    'pluginOptions' => [
                                        'opens'  => 'right',
                                        'locale' => ['format' => 'd.m.Y'],
                                    ],
                                ],
                            ],
                        ],
                    ]); ?>


                </div>
            </div>
        </div>
    </div>
</div>
