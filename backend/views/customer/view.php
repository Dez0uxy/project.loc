<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Customer */
/* @var $orderSearchModel backend\models\OrderSearch */
/* @var $orderDataProvider yii\data\ActiveDataProvider */

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

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Кліенти'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title"><?= Html::encode($this->title) ?></h1>
        </div>

        <div class="card card-lg">
            <div class="card-body">

                <div class="customer-view">

                    <p>
                        <?= Html::a('+ <i class="fa fa-shopping-cart"></i>', ['order/create', 'id_customer' => $model->id], ['class' => 'btn btn-info mr-3']) ?>
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
                            'name',
                            [
                                'attribute' => 'tel',
                                'value' => \common\components\FunctionHelper::phoneNumberFormat($model->tel),
                                'visible' => !empty($model->tel),
                            ],
                            [
                                'attribute' => 'tel2',
                                'visible' => !empty($model->tel2),
                            ],
                            'email:email',
                            [
                                'attribute' => 'discount',
                                'value' => $model->discount .'%',
                            ],

                            [
                                'attribute' => 'birthdate',
                                'visible' => $model->birthdate !== null,
                            ],
                            [
                                'attribute' => 'company',
                                'visible' => !empty($model->company),
                            ],
                            [
                                'attribute' => 'address',
                                'visible' => !empty($model->address),
                            ],
                            [
                                'attribute' => 'city',
                                'visible' => !empty($model->city),
                            ],
                            [
                                'attribute' => 'region',
                                'visible' => !empty($model->region),
                            ],
                            [
                                'attribute' => 'automark',
                                'visible' => !empty($model->automark),
                            ],
                            [
                                'attribute' => 'automodel',
                                'visible' => !empty($model->automodel),
                            ],
                            [
                                'attribute' => 'autovin',
                                'visible' => !empty($model->autovin),
                            ],
                            [
                                'attribute' => 'carrier',
                                'visible' => !empty($model->carrier),
                            ],
                            [
                                'attribute' => 'carrier_city',
                                'visible' => !empty($model->carrier_city),
                            ],
                            [
                                'attribute' => 'carrier_branch',
                                'visible' => !empty($model->carrier_branch),
                            ],
                            [
                                'attribute' => 'carrier_tel',
                                'visible' => !empty($model->carrier_tel),
                            ],
                            [
                                'attribute' => 'carrier_fio',
                                'visible' => !empty($model->carrier_fio),
                            ],
                        ],
                    ]) ?>

                </div>

                <div class="order-view">
                    <h2 class="page-title pt-3"><?= Yii::t('app','Замовлення') ?></h2>

                    <?= GridView::widget([
                        'dataProvider' => $orderDataProvider,
                        'filterModel'  => $orderSearchModel,
                        'columns'      => [
                            ['class' => 'yii\grid\SerialColumn'],

                            [
                                'attribute'     => 'id',
                                'headerOptions' => ['style' => 'width:60px;'],
                                'content'       => function ($m) {
                                    return Html::a($m->num, ['order/view', 'id' => $m->id]);
                                }
                            ],
                            [
                                'attribute'     => 'id_manager',
                                'headerOptions' => ['style' => 'width:100px;'],
                                'content'       => function ($m) {
                                    return $m->manager ? Html::tag('span', $m->manager->name, ['class' => 'small']) :
                                        Html::tag('span', Yii::t('app','сайт'), ['class' => 'text-muted small']);
                                }
                            ],
                            //'c_email:email',
                            [
                                'attribute'     => 'c_tel',
                                'headerOptions' => ['style' => 'width:130px;'],
                                'content'       => function ($m) {
                                    return Html::tag('span', \common\components\FunctionHelper::phoneNumberFormat($m->c_tel), ['class' => 'small']);
                                }
                            ],
                            //'o_address:ntext',
                            //'o_city',
                            //'o_comments:ntext',
                            [
                                'attribute' => 'o_comments',
                                'format'    => 'html',
                                'content'   => function ($m) {
                                    return Html::tag('span', Yii::$app->formatter->asNtext($m->o_comments), ['class' => 'text-muted small lh-base']);
                                }
                            ],
                            [
                                'attribute'     => 'o_shipping',
                                'headerOptions' => ['style' => 'width:170px;'],
                                'content'       => function ($m) {
                                    $content = '';
                                    switch ($m->o_shipping) {
                                        case 'нова пошта':
                                            $content = Yii::t('app', 'НП') . ': <b>' . $m->np_city . '</b> ' . $m->np_warehouse;
                                            break;
                                        case 'кур\'єр':
                                            $content = Yii::t('app', 'кур\'єр') . ': <b>' . $m->o_city . '</b> ' . $m->o_address;
                                            break;
                                        default:
                                            $content = Yii::t('app', 'самовивіз');
                                            break;
                                    }
                                    return $content;
                                }
                            ],
                            [
                                'attribute'     => 'o_payment',
                                'headerOptions' => ['style' => 'width:100px;'],
                                'content'       => function ($m) {
                                    return Html::tag('span', Yii::$app->formatter->asCurrency($m->cashdeskSum), ['class' => 'text-muted font-weight-bold']);
                                    //return Html::tag('span', $m->o_payment, ['class' => 'font-weight-bold']);
                                }
                            ],
                            [
                                'attribute'     => 'o_total',
                                'headerOptions' => ['style' => 'width:100px;'],
                                'content'       => function ($m) {
                                    return Html::tag('span', Yii::$app->formatter->asCurrency($m->total), ['class' => 'font-weight-bold']);
                                }
                            ],
                            //'is_paid',
                            //'ip',
                            //'created_at:datetime',
                            [
                                'attribute' => 'created_at',
                                'headerOptions' => ['style' => 'width:170px;'],
                                'content'   => function ($m) {
                                    return Yii::$app->formatter->asDatetime($m->created_at);
                                },
                                'filterType'          => GridView::FILTER_DATE,
                                'filterWidgetOptions' => [
                                    'model'                     => $orderSearchModel,
                                    'attribute'                 => 'created_at',
                                    //'hideInput'                 => true,
                                    'convertFormat'             => true,
                                    //'presetDropdown'            => false,
                                    //'defaultPresetValueOptions' => ['style' => 'display:none'],
                                    'pluginOptions'             => [
                                        'opens'  => 'right',
                                        'locale' => ['format' => 'd.m.Y']
                                    ],
                                ],
                            ],
                            [
                                'attribute'     => 'status',
                                'format'        => 'raw',
                                'headerOptions' => ['style' => 'width:130px;'],
                                'content'       => static function ($m) {
                                    return Html::dropDownList('status', $m->status, \common\models\OrderStatus::getArray(), [
                                        'style'    => 'background: ' . $m->orderStatus->color . ';color:#fff;border-radius:3px;padding:2px;width:130px;',
                                        'title'    => $m->orderStatus->name,
                                        'onchange' => '$.get("' . Url::to(['order/update-status', 'id' => $m->id]) . '&status="+$(this).val()).done(function( data ) { if(data.result) { toastr.success("' . Yii::t('app', 'збережено') . '")} else {toastr.error("' . Yii::t('app', 'Не збережено') . '")} });'
                                    ]);
                                },
                                'filter'        => \common\models\OrderStatus::getArray(),
                            ],
                            [
                                'class'         => \kartik\grid\ActionColumn::className(),
                                'urlCreator'    => function ($action, \common\models\Order $model, $key, $index, $column) {
                                    return Url::toRoute([$action, 'id' => $model->id]);
                                },
                                'headerOptions' => ['style' => 'width: 80px;'],
                                'template'      => '{view}&nbsp;{update}&nbsp;&nbsp;{delete}',
                                'buttons'       => [
                                    'view'   => function ($url, $model, $key) {
                                        return Html::a('<i class="ti ti-eye"></i>', Url::to(['order/view', 'id' => $model->id]));
                                    },
                                    'update' => function ($url, $model, $key) {
                                        return Html::a('<i class="ti ti-pencil"></i>', Url::to(['order/update', 'id' => $model->id]));
                                    },
                                    'delete' => function ($url, $model, $key) {
                                        return Html::a('<i class="ti ti-trash"></i>', Url::to(['order/delete', 'id' => $model->id]),
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
