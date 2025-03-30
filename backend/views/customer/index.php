<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CustomerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Кліенти');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="my-3 my-md-5">
    <div class="container">

        <div class="page-header">
            <h1 class="page-title"><?= Html::encode($this->title) ?></h1>
        </div>

        <div class="card card-lg">
            <div class="card-body">

                <div class="customer-index">

                    <p>
                        <?= Html::a('<i class="fa fa-plus"></i>', ['create'], ['class' => 'btn btn-success']) ?>
                    </p>

                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel'  => $searchModel,
                        'columns'      => [
                            ['class'   => 'yii\grid\SerialColumn'],

                            //'id',
                            [
                                'attribute' => 'tel',
                                'content'   => static function ($m) {
                                    return \common\components\FunctionHelper::phoneNumberFormat($m->tel);
                                },
                            ],
                            'email:email',
                            //'discount',
                            [
                                'attribute' => 'lastname',
                                'content'   => static function ($m) {
                                    return Html::a($m->name, ['customer/view', 'id' => $m->id]);
                                },
                            ],
                            //'birthdate',
                            //'tel2',
                            'company',
                            //'address',
                            'city',
                            //'region',
                            //'automark',
                            //'automodel',
                            //'carrier',
                            //'carrier_city',
                            //'carrier_branch',
                            //'carrier_tel',
                            //'carrier_fio',
                            [
                                'class'         => ActionColumn::className(),
                                'urlCreator'    => function ($action, \common\models\Customer $model, $key, $index, $column) {
                                    return Url::toRoute([$action, 'id' => $model->id]);
                                },
                                'headerOptions' => ['style' => 'width: 40px;'],
                                'template'      => '{order}&nbsp;{view}&nbsp;{update}',
                                'buttons'       => [
                                    'order'  => function ($url, $model, $key) {
                                        return Html::a('<i class="ti ti-shopping-cart"></i>', Url::to(['order/create', 'id_customer' => $model->id]), ['class' => 'text-success']);
                                    },
                                    'view'   => function ($url, $model, $key) {
                                        return Html::a('<i class="ti ti-eye"></i>', Url::to(['view', 'id' => $model->id]), ['class' => 'text-info']);
                                    },
                                    'update' => function ($url, $model, $key) {
                                        return Html::a('<i class="ti ti-pencil"></i>', Url::to(['update', 'id' => $model->id]), ['class' => 'text-primary']);
                                    },
                                    'delete' => function ($url, $model, $key) {
                                        return Html::a('<i class="ti ti-trash"></i>', Url::to(['delete', 'id' => $model->id]),
                                            ['data' => ['confirm' => Yii::t('app', 'Ви впевнені?')], 'class' => 'text-danger']);
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
