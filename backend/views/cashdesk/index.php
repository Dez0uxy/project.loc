<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CashdeskSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model \common\models\Cashdesk */

$this->title                   = Yii::t('app', 'Каса');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title"><?= Html::encode($this->title) ?></h1>
        </div>

        <div class="card card-lg">
            <div class="card-body">

                <div class="cashdesk-index">

                    <?= $this->render('_form',[
                        'model' => $model,
                    ]) ?>

                    <?php Pjax::begin(['id' => 'cashdesk']) ?>
                    <?= GridView::widget([
                        'dataProvider'     => $dataProvider,
                        'filterModel'      => $searchModel,
                        'showPageSummary'  => true,
                        'floatPageSummary' => true, // table page summary floats when you scroll
                        'rowOptions' => function($m){
                            return ['class' => $m->amount > 0 ? 'text-success' : 'text-danger'];
                        },
                        'columns'          => [
                            ['class' => 'yii\grid\SerialColumn'],

                            //'id',
                            [
                                'attribute' => 'id_user',
                                'format'    => 'raw',
                                'value'     => function ($model) {
                                    return is_object($model->user) ? Html::a($model->user->name, ['manager/view', 'id' => $model->id_user], ['data-pjax' => '0']) : Yii::t('cashdesk','Сайт');
                                },
                                //'filter'    => \app\models\Staff::getEmployeesArray(),
                            ],
                            [
                                'attribute' => 'id_order',
                                'format'    => 'raw',
                                'value'     => function ($model) {
                                    return is_object($model->order) ? Html::a($model->order->num, ['order/view', 'id' => $model->id_order], ['data-pjax' => '0']) : '-';
                                },
                                //'filter'    => \app\models\Staff::getEmployeesArray(),
                            ],
                            [
                                'attribute' => 'id_method',
                                'format'    => 'raw',
                                'value'     => function ($model) {
                                    return is_object($model->method) ? $model->method->name : '-';
                                },
                                'filter'    => \common\models\CashdeskMethod::getArray(),
                            ],
                            [
                                'attribute'   => 'amount',
                                'format'      => 'html',
                                'value'       => function ($m) {
                                    return $m->amount;
                                },
                                'pageSummary' => true,
                            ],
                            'note',
                            [
                                'attribute'           => 'created_at',
                                'headerOptions'       => ['style' => 'width:170px;'],
                                'content'             => function ($m) {
                                    return Yii::$app->formatter->asDatetime($m->created_at);
                                },
                                'filterType'          => GridView::FILTER_DATE,
                                'filterWidgetOptions' => [
                                    'model'         => $searchModel,
                                    'attribute'     => 'created_at',
                                    //'hideInput'                 => true,
                                    'convertFormat' => true,
                                    //'presetDropdown'            => false,
                                    //'defaultPresetValueOptions' => ['style' => 'display:none'],
                                    'pluginOptions' => [
                                        'opens'  => 'right',
                                        'locale' => ['format' => 'd.m.Y'],
                                    ],
                                ],
                            ],
                            //'updated_at',
                            [
                                'class'         => \kartik\grid\ActionColumn::className(),
                                'urlCreator'    => function ($action, \common\models\Cashdesk $model, $key, $index, $column) {
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
                    ]); ?>
                    <?php Pjax::end() ?>

                </div>
            </div>
        </div>
    </div>
</div>
