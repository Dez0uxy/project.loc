<?php

use common\components\FunctionHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->registerCss('
table.kv-grid-table tbody {
    font-size: 16px;
    font-weight: 600;
    color: #232526;
}
');

$this->title                   = Yii::t('app', 'Замовлення');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title"><?= Html::encode($this->title) ?></h1>
        </div>

        <div class="card card-lg">
            <div class="card-body">

                <div class="order-index">

                    <p>
                        <?= Html::a('<i class="fa fa-plus"></i>', ['create'], ['class' => 'btn btn-success']) ?>
                    </p>

                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel'  => $searchModel,
                        'rowOptions'   => function ($m) {
                            if ($m->status === 5) { // Виконаний
                                $total = (float)$m->total;
                                $sum = (float)$m->cashdeskSum;
                                if ($sum >= $total) { // fully paid
                                    return ['style' => 'background: #e2ffb0;'];
                                }
                                if ($sum > 0 && $total > $sum) { // partially paid
                                    return ['style' => 'background: #fff2b0;'];
                                }
                                if ((int)$sum === 0) { // not paid
                                    return ['style' => 'background: #ffb7b0;'];
                                }
                                return ['data-total' => $total .' - '.$sum];
                            }
                        },
                        'columns'      => [
                            //['class' => 'yii\grid\SerialColumn'],

                            [
                                'attribute'     => 'id',
                                'headerOptions' => ['style' => 'width:60px;'],
                                'content'       => function ($m) {
                                    return Html::a($m->num, ['view', 'id' => $m->id]);
                                },
                            ],
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
                            [
                                'attribute' => 'id_customer',
                                //'headerOptions' => ['style' => 'width:100px;'],
                                'content'   => function ($m) {
                                    return $m->customer ?
                                        Html::a($m->customer->name, ['customer/view', 'id' => $m->id_customer], ['class' => 'small font-weight-bold']) . '<br>' . \common\components\FunctionHelper::phoneNumberFormat($m->customer->tel) :
                                        Html::tag('span', $m->c_fio, ['class' => 'small font-weight-bold']);
                                },
                                'filter' => \common\models\Customer::getCustomerArray(),
                                'filterType'          => GridView::FILTER_SELECT2,
                                'filterWidgetOptions' => [
                                    'options'       => ['prompt' => '...', 'multiple' => false],
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                        'width'      => '100%'
                                    ],
                                ],
                            ],
//                            [
//                                'attribute'     => 'c_tel',
//                                'headerOptions' => ['style' => 'width:130px;'],
//                                'content'       => function ($m) {
//                                    return Html::tag('span', FunctionHelper::phoneNumberFormat($m->c_tel), ['class' => 'small font-weight-bold']);
//                                },
//                            ],
                            [
                                'attribute'     => 'o_shipping',
                                'headerOptions' => ['style' => 'width:170px;'],
                                'content'       => function ($m) {
                                    $content = '';
                                    switch ($m->o_shipping) {
                                        case 'нова пошта':
                                            $content = Yii::t('app', 'НП') . ': <b>' . $m->np_city . '</b> ' . $m->np_warehouse;
                                            //
                                            if ($npDocument = $m->npDocument) {
                                                $content .= '<br>' . Html::a($npDocument->TrackingNumber . ' &rarr;', 'https://novaposhta.ua/tracking/?cargo_number=' . $npDocument->TrackingNumber, ['target' => '_blank']);
                                            }

                                            break;
                                        case 'кур\'єр':
                                            $content = Yii::t('app', 'кур\'єр') . ': <b>' . $m->o_city . '</b> ' . $m->o_address;
                                            break;
                                        default:
                                            $content = Yii::t('app', 'самовивіз');
                                            break;
                                    }
                                    return $content;
                                },
                            ],
                            [
                                'attribute' => 'o_comments',
                                'format'    => 'html',
                                'content'   => function ($m) {
                                    return Html::tag('span', Yii::$app->formatter->asNtext($m->o_comments),
                                        ['class' => 'small font-weight-normal']);
                                },
                            ],
                            [
                                'attribute'      => 'o_payment',
                                'headerOptions'  => ['style' => 'width:100px;'],
                                'contentOptions' => ['style' => 'text-align:center;'],
                                'content'        => function ($m) {
                                    return Html::a('&nbsp;<i class="ti ti-receipt-2" style="font-size: 150%"></i>', '#', [
                                            'class'          => '',
                                            'data-bs-toggle' => 'modal',
                                            'data-bs-target' => '#modal-cashdesk',
                                            'onclick'        => '
                                        $("#cashdesk-id_order").val("' . $m->id . '");
                                        $("#modal-cashdesk label[for=\'cashdesk-id_order\']").html("Замовлення #' . $m->id . '");
                                        $("#cashdesk-amount").val("' . $m->o_total . '");
                                        ',
                                        ]) . '<br>' .
                                        Html::tag('span', Yii::$app->formatter->asCurrency($m->cashdeskSum), ['class' => 'text-muted font-weight-bold']);
                                },
                            ],
                            [
                                'attribute'     => 'o_total',
                                'headerOptions' => ['style' => 'width:100px;'],
                                'content'       => function ($m) {
                                    return Html::tag('span', Yii::$app->formatter->asCurrency($m->total), ['class' => 'font-weight-bold']);
                                },
                            ],
                            [
                                'attribute'     => 'status',
                                'format'        => 'raw',
                                'headerOptions' => ['style' => 'width:130px;'],
                                'content'       => static function ($m) {
                                    return Html::tag('span', $m->orderStatus->name, ['style' => 'font-weight:bold;color:'.$m->orderStatus->color]);

//                                    return Html::dropDownList('status', $m->status, \common\models\OrderStatus::getArray(), [
//                                        'style'    => 'background: ' . $m->orderStatus->color . ';color:#fff;border-radius:3px;padding:2px;width:130px;',
//                                        'title'    => $m->orderStatus->name,
//                                        'onchange' => '$.get("' . Url::to(['order/update-status', 'id' => $m->id]) . '&status="+$(this).val()).done(function( data ) { if(data.result) { toastr.success("' . Yii::t('app', 'збережено') . '")} else {toastr.error("' . Yii::t('app', 'Не збережено') . '")} });',
//                                    ]);
                                },
                                'filter'        => \common\models\OrderStatus::getArray(),
                            ],
                            [
                                'attribute'     => 'id_manager',
                                'headerOptions' => ['style' => 'width:100px;'],
                                'content'       => function ($m) {
                                    return $m->manager ? Html::tag('span', $m->manager->name, ['class' => 'small font-weight-bold']) :
                                        Html::tag('span', Yii::t('app', 'сайт'), ['class' => 'text-muted small']);
                                },
                                'filter'        => \common\models\User::getManagerArray(),
                            ],
                            [
                                'class'         => ActionColumn::className(),
                                'urlCreator'    => function ($action, \common\models\Order $model, $key, $index, $column) {
                                    return Url::toRoute([$action, 'id' => $model->id]);
                                },
                                'headerOptions' => ['style' => 'width: 80px;'],
                                'template'      => '{print}&nbsp;{view}&nbsp;{update}&nbsp;&nbsp;{delete}', // &nbsp;&nbsp;{delete}
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

                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-blur fade" id="modal-cashdesk" tabindex="-1" style="display: none;"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?= Yii::t('app', 'Внести Оплату') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?= $this->render('_cashdesk_form', [
                    'model' => new \common\models\Cashdesk(),
                ]) ?>
            </div>
            <div class="modal-footer">
                <button type="button" id="close__modal" class="btn btn-light me-auto"
                        data-bs-dismiss="modal"><?= Yii::t('app', 'Закрити') ?></button>
                </a>
            </div>
        </div>
    </div>
</div>
