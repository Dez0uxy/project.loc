<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Order */

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

$this->title                   = Yii::t('app', 'Замовлення') . ' #' . $model->num;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Замовлення'), 'url' => ['index']];
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

                <div class="order-view">

                    <p>
                        <?= Html::a('<i class="fa fa-print"></i>', ['print', 'id' => $model->id], ['class' => 'btn btn-info mr-3', 'target' => '_blank']) ?>
                        <?= Html::a('<i class="fa fa-file-contract"></i>', ['print', 'id' => $model->id, 'v' => 'client'], ['class' => 'btn btn-indigo mr-3', 'target' => '_blank']) ?>
                        <?= Html::a('<i class="fa fa-file-pdf"></i>', ['pdf', 'id' => $model->id], ['class' => 'btn btn-cyan mr-3']) ?>
                        <?php if ($model->o_shipping === 'нова пошта'): ?>
                            <?php if ($npDocument = $model->npDocument): ?>
                                <?= Html::a('<i class="fa fa-up-down-left-right"></i>',
                                    ['np-internet-document/view', 'id' => $npDocument->id], ['class' => 'btn btn-danger mr-3']) ?>
                            <?php else: ?>
                                <?= Html::a('<i class="fa fa-truck"></i>',
                                    ['nova-poshta/internet-document', 'id_order' => $model->id], ['class' => 'btn btn-warning mr-3', 'title' => Yii::t('app','Створити Накладну')]) ?>
                            <?php endif; ?>
                        <?php endif; ?>

                        <?= Html::a('<i class="fa fa-edit"></i>', ['update', 'id' => $model->id], ['class' => 'btn btn-primary ml-3']) ?>

                        <?php if (Yii::$app->user->id === 1): ?>
                            <?= Html::a('<i class="fa fa-trash"></i>', ['delete', 'id' => $model->id], [
                                'class' => 'btn btn-danger',
                                'data'  => [
                                    'confirm' => Yii::t('app', 'Ви впевнені?'),
                                    'method'  => 'post',
                                ],
                            ]) ?>
                        <?php endif; ?>

                    </p>

                    <div class="row">
                        <?php if ($npDocument = $model->npDocument): ?>

                            <div class="col-lg-5">
                                <?= DetailView::widget([
                                    'model'      => $npDocument,
                                    'attributes' => [
                                        [
                                            'attribute' => 'TrackingNumber',
                                            'format'    => 'raw',
                                            'value'     => Html::a($npDocument->TrackingNumber . ' &rarr;', 'https://novaposhta.ua/tracking/?cargo_number=' . $npDocument->TrackingNumber, ['target' => '_blank']),
                                            'visible'   => $npDocument->TrackingNumber,
                                        ],
                                        [
                                            'attribute' => 'CostOnSite',
                                            'value'     => Yii::$app->formatter->asCurrency($npDocument->CostOnSite),
                                            'visible'   => $npDocument->CostOnSite,
                                        ],
                                        [
                                            'attribute' => 'EstimatedDeliveryDate',
                                            'visible'   => $npDocument->EstimatedDeliveryDate,
                                        ],
                                        [
                                            'attribute' => 'SeatsAmount',
                                            'visible'   => $npDocument->SeatsAmount,
                                        ],
                                        [
                                            'attribute' => 'Weight',
                                            'visible'   => $npDocument->Weight,
                                        ],

                                        [
                                            'attribute' => 'BackDelivery_PayerType',
                                            'visible'   => $npDocument->BackDelivery_PayerType,
                                        ],
                                        [
                                            'attribute' => 'BackDelivery_CargoType',
                                            'visible'   => $npDocument->BackDelivery_CargoType,
                                        ],
                                        [
                                            'attribute' => 'BackDelivery_RedeliveryString',
                                            'visible'   => $npDocument->BackDelivery_RedeliveryString,
                                        ],
                                        [
                                            'attribute' => 'created_at',
                                            'format'    => 'datetime',
                                            'visible'   => $npDocument->created_at,
                                        ],
                                        [
                                            'label'  => Yii::t('app', 'Видалити Накладну'),
                                            'format' => 'raw',
                                            'value'  => Html::a('<i class="fa fa-trash"></i>', ['nova-poshta/internet-document-delete', 'id' => $npDocument->id], [
                                                'class' => 'btn btn-danger',
                                                'data'  => [
                                                    'confirm' => Yii::t('app', 'Ви впевнені?'),
                                                    'method'  => 'post',
                                                ],
                                            ]),

                                        ],
                                    ],
                                ]) ?>
                            </div>

                        <?php endif; ?>

                        <div class="col-lg-7">
                            <?= DetailView::widget([
                                'model'      => $model,
                                'attributes' => [
                                    [
                                        'attribute' => 'id_manager',
                                        'visible'   => $model->id_manager,
                                        'value'     => $model->manager ? $model->manager->name : Yii::t('app', 'сайт'),
                                    ],

                                    [
                                        'attribute' => 'id_customer',
                                        'visible'   => $model->id_customer,
                                        'format'    => 'raw',
                                        'value'     => $model->customer ?
                                            Html::a($model->customer->name . '&nbsp;<i class="ti ti-browser"></i>', '#', [
                                                'class'          => '',
                                                'data-bs-toggle' => 'modal',
                                                'data-bs-target' => '#modal-customer',
                                            ]) : '',
                                    ],
                                    [
                                        'attribute' => 'c_fio',
                                        'visible'   => $model->c_fio,
                                    ],
                                    [
                                        'attribute' => 'c_email',
                                        'format'    => 'email',
                                        'visible'   => $model->c_email,
                                    ],
                                    [
                                        'attribute' => 'c_tel',
                                        'value'     => \common\components\FunctionHelper::phoneNumberFormat($model->c_tel),
                                        'visible'   => $model->c_tel,
                                    ],
                                    [
                                        'attribute' => 'o_address',
                                        'format'    => 'ntext',
                                        'visible'   => !empty($model->o_address),
                                    ],
                                    [
                                        'attribute' => 'o_city',
                                        'visible'   => !empty($model->o_city),
                                    ],
                                    [
                                        'attribute' => 'o_comments',
                                        'format'    => 'ntext',
                                        'visible'   => $model->o_comments,
                                    ],
                                    [
                                        'attribute' => 'o_payment',
                                        'visible'   => $model->o_payment,
                                    ],
                                    [
                                        'attribute' => 'o_shipping',
                                        'visible'   => $model->o_shipping,
                                    ],
                                    [
                                        'attribute' => 'np_city',
                                        'visible'   => $model->np_city,
                                    ],
                                    [
                                        'attribute' => 'np_warehouse',
                                        'visible'   => $model->np_warehouse,
                                    ],
                                    [
                                        'attribute' => 'o_total',
                                        'visible'   => $model->o_total,
                                    ],
                                    [
                                        'attribute' => 'is_paid',
                                        'visible'   => $model->is_paid,
                                    ],
                                    [
                                        'attribute' => 'ip',
                                        'visible'   => $model->ip,
                                    ],
                                    [
                                        'attribute' => 'status',
                                        'value'     => $model->orderStatus ? $model->orderStatus->name : '',
                                    ],
                                ],
                            ]) ?>
                        </div>
                    </div>

                    <?php if ($customer = $model->customer): ?>
                        <?php /* @var \common\models\Customer $customer */ ?>
                        <div class="modal modal-blur fade" id="modal-customer" tabindex="-1" style="display: none;"
                             aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title"><?= $customer->name ?></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <?= DetailView::widget([
                                            'model'      => $customer,
                                            'attributes' => [
                                                'email:email',
                                                [
                                                    'attribute' => 'discount',
                                                    'value'     => $customer->discount . '%',
                                                ],
                                                'name',
                                                [
                                                    'attribute' => 'birthdate',
                                                    'visible'   => $customer->birthdate !== null,
                                                ],
                                                [
                                                    'attribute' => 'tel',
                                                    'format'    => 'raw',
                                                    'value'     => Html::a($customer->tel, 'tel:' . $customer->tel),
                                                    'visible'   => $customer->tel,
                                                ],
                                                [
                                                    'attribute' => 'tel2',
                                                    'format'    => 'raw',
                                                    'value'     => Html::a($customer->tel2, 'tel:' . $customer->tel2),
                                                    'visible'   => $customer->tel2,
                                                ],
                                                [
                                                    'attribute' => 'company',
                                                    'visible'   => $customer->company,
                                                ],
                                                [
                                                    'attribute' => 'address',
                                                    'visible'   => $customer->address,
                                                ],
                                                [
                                                    'attribute' => 'city',
                                                    'visible'   => $customer->city,
                                                ],
                                                [
                                                    'attribute' => 'region',
                                                    'visible'   => $customer->region,
                                                ],
                                                [
                                                    'attribute' => 'automark',
                                                    'visible'   => $customer->automark,
                                                ],
                                                [
                                                    'attribute' => 'automodel',
                                                    'visible'   => $customer->automodel,
                                                ],
                                                [
                                                    'attribute' => 'carrier',
                                                    'visible'   => $customer->carrier,
                                                ],
                                                [
                                                    'attribute' => 'carrier_city',
                                                    'visible'   => $customer->carrier_city,
                                                ],
                                                [
                                                    'attribute' => 'carrier_branch',
                                                    'visible'   => $customer->carrier_branch,
                                                ],
                                                [
                                                    'attribute' => 'carrier_tel',
                                                    'visible'   => $customer->carrier_tel,
                                                ],
                                                [
                                                    'attribute' => 'carrier_fio',
                                                    'visible'   => $customer->carrier_fio,
                                                ],
                                            ],
                                        ]) ?>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn me-auto"
                                                data-bs-dismiss="modal"><?= Yii::t('app', 'Закрити') ?></button>
                                        <a href="<?= \yii\helpers\Url::to(['order/create', 'id_customer' => $customer->id]) ?>"
                                           class="btn btn-primary">
                                            <?= Yii::t('app', 'Створити замовлення') ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ($products = $model->orderProduct): ?>
                        <label class="form-label"><?= Yii::t('app', 'Товари') ?></label>
                        <div class="card">
                            <div class="table-responsive">
                                <table class="table table-bordered table-vcenter card-table">
                                    <thead>
                                    <tr>
                                        <th><?= Yii::t('app', 'Бренд') ?></th>
                                        <th><?= Yii::t('app', 'Назва') ?></th>
                                        <th><?= Yii::t('app', 'Артикул') ?></th>
                                        <th class="text-center"><?= Yii::t('app', 'Ціна') ?></th>
                                        <th class="text-center"><?= Yii::t('app', 'Кількість') ?></th>
                                        <th class="text-center"><?= Yii::t('app', 'Сума') ?></th>
                                        <th class="text-center"><?= Yii::t('app', 'Склад') ?></th>
                                        <th class="text-center"><?= Yii::t('app', 'Статус') ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($products as $product): ?>
                                        <?php /* @var \common\models\OrderProduct $product */ ?>
                                        <tr>
                                            <td>
                                                <div>
                                                    <?php if ($productModel = $product->product): ?>
                                                        <strong><?= Html::encode($productModel->brand->name) ?></strong>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <?= Html::a(Html::encode($product->product_name), ['product/view', 'id' => $product->id_product]) ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-muted"><?= Html::encode($product->upc) ?></div>
                                            </td>
                                            <td class="text-muted text-center">
                                                <?= Yii::$app->formatter->asCurrency($product->price) ?>
                                            </td>
                                            <td class="text-center">
                                                <?= $product->quantity ?>
                                            </td>
                                            <td class="text-center">
                                                <strong><?= Yii::$app->formatter->asCurrency($product->quantity * $product->price) ?></strong>
                                            </td>
                                            <td class="text-center">
                                                <?= $product->warehouse ? Html::encode($product->warehouse->name) : '' ?>
                                            </td>
                                            <td class="text-center">
                                                <div class="mb-3">
                                                    <?= Html::dropDownList('status', $product->status, $product->getAvailableStatusArray(), [
                                                        'class'    => 'form-select is-valid',
                                                        'data-id'  => $product->id,
                                                        'onchange' => '$.get("' . \yii\helpers\Url::to(['order/product-status', 'id' => $product->id]) . '&status="+$(this).val()).done(function( data ) { if(data.result) { toastr.success(data.newStatus)} else {toastr.error("' . Yii::t('app', 'Не збережено') . '")} });',
                                                        'style'    => 'background: ' . $product->orderStatus->color . ';color:#fff;border-radius:3px;padding:2px;',
                                                    ]) ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    <?php endif; ?>

                    <?php if ($payments = $model->cashdesk): ?>
                        <label class="form-label"><?= Yii::t('app', 'Оплати') ?></label>
                        <div class="card">
                            <div class="table-responsive">
                                <table class="table table-bordered table-vcenter card-table">
                                    <thead>
                                    <tr>
                                        <th><?= Yii::t('app', 'Менеджер') ?></th>
                                        <th><?= Yii::t('app', 'Метод оплати') ?></th>
                                        <th class="text-center"><?= Yii::t('app', 'Сума') ?></th>
                                        <th class="text-center"><?= Yii::t('app', 'Примітка') ?></th>
                                        <th class="text-center"><?= Yii::t('app', 'Дата') ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($payments as $payment): ?>
                                        <?php /* @var \common\models\Cashdesk $payment */ ?>
                                        <tr>
                                            <td>
                                                <div>
                                                    <?= $payment->user ? Html::encode($payment->user->name) : '?' ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-muted"><?= is_object($payment->method) ? $payment->method->name : '-' ?></div>
                                            </td>
                                            <td class="text-muted text-center">
                                                <?= Yii::$app->formatter->asCurrency($payment->amount) ?>
                                            </td>
                                            <td class="text-center">
                                                <?= $payment->note ?>
                                            </td>
                                            <td class="text-center">
                                                <strong><?= Yii::$app->formatter->asDatetime($payment->created_at) ?></strong>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</div>
