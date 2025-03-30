<?php

use common\models\WarehousePlace;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\WarehousePlaceSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Місця на складі';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title"><?= Html::encode($this->title) ?></h1>
        </div>

        <div class="card card-lg">
            <div class="card-body">

                <div class="warehouse-place-index">

                    <h1><?= Html::encode($this->title) ?></h1>

                    <p>
                        <?= Html::a('<i class="fa fa-plus"></i>', ['create'], ['class' => 'btn btn-success']) ?>
                    </p>

                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $dataProvider->getTotalCount() > 0 ? $searchModel : null,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                            [
                                'attribute' => 'id_warehouse',
                                'content'   => static function ($m) {
                                    return $m->warehouse ? $m->warehouse->name : '-';
                                },
                                'filter'    => \common\models\Warehouse::getArray(),
                            ],
                            'name',
                            [
                                'class'         => \kartik\grid\ActionColumn::className(),
                                'urlCreator'    => static function ($action, \common\models\WarehousePlace $model, $key, $index, $column) {
                                    return Url::toRoute([$action, 'id' => $model->id]);
                                },
                                'headerOptions' => ['style' => 'width: 80px;'],
                                'template'      => '{update}&nbsp;{delete}',
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
                                        return Yii::$app->user->can('admin');
                                    },
                                    'delete' => function ($model) {
                                        return Yii::$app->user->can('delete');
                                    },
                                ],
                            ],
                        ],
                    ]) ?>

                </div>

            </div>
        </div>
    </div>
</div>
