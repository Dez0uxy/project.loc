<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\FilterAutoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = 'Filter Autos';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile('@web/js/jquery.min.js');
?>'
<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title"><?= Html::encode($this->title) ?></h1>
        </div>

        <div class="card card-lg">
            <div class="card-body">

                <div class="filter-auto-index">

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
                                'attribute' => 'id_product',
                                //'headerOptions' => ['style' => 'width:100px;'],
                                'content'   => function ($m) {
                                    return $m->product ?
                                        Html::a($m->product->name, ['product/view', 'id' => $m->id_product], ['class' => 'small text-primary']) . ' ' . $m->product->upc :
                                        $m->id_product;
                                },
                            ],
                            [
                                'attribute' => 'vendor',
                                'filter' => \common\models\FilterAuto::getVendorArray()
                            ],
                            [
                                'attribute' => 'model',
                                'filter' => \common\models\FilterAuto::getModelsArray()
                            ],
                            'year',
                            'engine',
                            [
                                'class'         => ActionColumn::className(),
                                'urlCreator'    => function ($action, \common\models\FilterAuto $model, $key, $index, $column) {
                                    return Url::toRoute([$action, 'id' => $model->id]);
                                },
                                'headerOptions' => ['style' => 'width: 80px;'],
                                'template'      => '{view}&nbsp;{update}&nbsp;&nbsp;{delete}',
                                'buttons'       => [
                                    'view'   => function ($url, $model, $key) {
                                        return Html::a('<i class="ti ti-eye"></i>', Url::to(['view', 'id' => $model->id]));
                                    },
                                    'update' => function ($url, $model, $key) {
                                        return Html::a('<i class="ti ti-pencil"></i>', Url::to(['update', 'id' => $model->id]));
                                    },
                                    'delete' => function ($url, $model, $key) {
                                        return Html::a('<i class="ti ti-trash"></i>', Url::to(['delete', 'id' => $model->id]),
                                            ['data' => ['confirm' => 'Ви впевнені?']]);
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
