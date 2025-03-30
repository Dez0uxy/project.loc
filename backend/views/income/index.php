<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\IncomeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Прихід товару');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title"><?= Html::encode($this->title) ?></h1>
        </div>

        <div class="card card-lg">
            <div class="card-body">

                <!--div class="text-center">
                    <span class="badge bg-orange" style="font-size: 85%;">
                        Працює в тестовому режимі, кількість товарів не змінюється.
                    </span>
                    <span class="badge bg-cyan" style="font-size: 85%;">
                        Перевірте, чи правильно працює форма.
                    </span>
                </div-->

                <div class="income-index">

                    <p>
                        <?= Html::a('<i class="fa fa-plus"></i>', ['create'], ['class' => 'btn btn-success']) ?>
                    </p>

                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel'  => $searchModel,
                        'columns'      => [
                            ['class' => 'yii\grid\SerialColumn'],

                            [
                                'attribute'     => 'id',
                                'headerOptions' => ['style' => 'width:95px;'],
                                'content'       => function ($m) {
                                    return $m->formatNum;
                                }
                            ],
//                            [
//                                'attribute'     => 'num',
//                                'headerOptions' => ['style' => 'width:60px;'],
//                                'content'       => function ($m) {
//                                    return $m->num;
//                                }
//                            ],
                            [
                                'attribute'     => 'id_vendor',
                                //'headerOptions' => ['style' => 'width:100px;'],
                                'content'       => function ($m) {
                                    return $m->vendor ? Html::tag('span', $m->vendor->name, ['class' => 'small']) : '';
                                }
                            ],
                            [
                                'attribute'     => 'id_warehouse',
                                //'headerOptions' => ['style' => 'width:100px;'],
                                'content'       => function ($m) {
                                    return $m->warehouse ? Html::tag('span', $m->warehouse->name, ['class' => 'small']) : '';
                                }
                            ],
                            'incomeProductCount',
                            'created_at:datetime',
                            //'updated_at',
                            [
                                'class'         => ActionColumn::className(),
                                'urlCreator'    => function ($action, \common\models\Income $model, $key, $index, $column) {
                                    return Url::toRoute([$action, 'id' => $model->id]);
                                },
                                'headerOptions' => ['style' => 'width: 80px;'],
                                'template'      => '{print}&nbsp;&nbsp;{view}&nbsp;&nbsp;{delete}',
                                'buttons'       => [
                                    'print'   => function ($url, $model, $key) {
                                        return Html::a('<i class="ti ti-printer"></i>', Url::to(['print', 'id' => $model->id]));
                                    },
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
                            ],
                        ],
                    ]); ?>

                </div>
            </div>
        </div>
    </div>
</div>
