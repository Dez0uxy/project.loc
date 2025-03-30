<?php

use common\models\OrderStatus;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\OrderStatusSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Статуси замовлень');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title"><?= Html::encode($this->title) ?></h1>
        </div>

        <div class="card card-lg">
            <div class="card-body">

                <div class="order-status-index">

                    <p>
                        <?= Html::a('<i class="fa fa-plus"></i>', ['create'], ['class' => 'btn btn-success']) ?>
                    </p>

                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel'  => $searchModel,
                        'columns'      => [
                            ['class' => 'yii\grid\SerialColumn'],

                            //'id',
                            [
                                'attribute' => 'type',
                                'content'   => function ($m) {
                                    return $m->type === OrderStatus::TYPE_ORDER ? Yii::t('app', 'Замовлення') : Yii::t('app', 'Товар');
                                },
                                'filter'    => [OrderStatus::TYPE_ORDER => Yii::t('app', 'Замовлення'), OrderStatus::TYPE_PRODUCT => Yii::t('app', 'Товар')]
                            ],
                            [
                                'attribute' => 'name',
                                'content'   => function ($m) {
                                    return Html::tag('span', $m->name, ['style' => 'color:' . $m->color]);
                                }
                            ],
                            [
                                'attribute' => 'color',
                                'content'   => function ($m) {
                                    return Html::tag('span', $m->color, ['style' => 'border-radius:3px;padding:3px;color:white;background:' . $m->color]);
                                }
                            ],
                            [
                                'class'         => ActionColumn::className(),
                                'urlCreator'    => function ($action, OrderStatus $model, $key, $index, $column) {
                                    return Url::toRoute([$action, 'id' => $model->id]);
                                },
                                'headerOptions' => ['style' => 'width: 80px;'],
                                'template'      => '{view}&nbsp;{update}',
                                'buttons'       => [
                                    'view'   => function ($url, $model, $key) {
                                        return Html::a('<i class="ti ti-eye"></i>', Url::to(['view', 'id' => $model->id]));
                                    },
                                    'update' => function ($url, $model, $key) {
                                        return Html::a('<i class="ti ti-pencil"></i>', Url::to(['update', 'id' => $model->id]));
                                    },
                                    'delete' => function ($url, $model, $key) {
                                        return Html::a('<i class="ti ti-trash"></i>', Url::to(['delete', 'id' => $model->id]),
                                            ['data' => ['confirm' => Yii::t('app', 'Ви впевнені?')]]);
                                    },
                                ],
                                'visibleButtons' => [
                                    'update' => function ($model) {
                                        return true;
                                    },
                                    'delete' => function ($model) {
                                        return Yii::$app->user->can('admin');
                                    },
                                ],
                            ],
                        ],
                    ]); ?>


                </div>
            </div>
        </div>
    </div>
</div>
