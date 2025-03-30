<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\NpInternetDocument */

$this->title                   = $model->TrackingNumber;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Експрес-накладні'), 'url' => ['index']];
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

                <div class="np-internet-document-view">

                    <p>
                        <?php Html::a('<i class="fa fa-edit"></i>', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                        <?php Html::a('<i class="fa fa-trash"></i>', ['delete', 'id' => $model->id], [
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
                            [
                                'attribute' => 'id_order',
                                'format'    => 'html',
                                'value'     => Html::a('Замовлення #' . $model->id_order . ' &rarr;', ['order/view', 'id' => $model->id_order]),
                                'visible'   => $model->id_order,
                            ],
                            [
                                'attribute' => 'TrackingNumber',
                                'format'    => 'raw',
                                'value'     => Html::a($model->TrackingNumber . ' &rarr;', 'https://novaposhta.ua/tracking/?cargo_number=' . $model->TrackingNumber, ['target' => '_blank']),
                                'visible'   => $model->TrackingNumber,
                            ],
                            [
                                'attribute' => 'CostOnSite',
                                'value'     => Yii::$app->formatter->asCurrency($model->CostOnSite),
                                'visible'   => $model->CostOnSite,
                            ],
                            [
                                'attribute' => 'EstimatedDeliveryDate',
                                'visible'   => $model->EstimatedDeliveryDate,
                            ],
                            //                            [
                            //                                'attribute' => 'Ref',
                            //                                'visible'   => $model->Ref,
                            //                            ],
                            //                            [
                            //                                'attribute' => 'TypeDocument',
                            //                                'visible'   => $model->TypeDocument,
                            //                            ],
                            [
                                'attribute' => 'senderFirstName',
                                'visible'   => $model->senderFirstName,
                            ],
                            //                            [
                            //                                'attribute' => 'senderMiddleName',
                            //                                'visible'   => $model->senderMiddleName,
                            //                            ],
                            //
                            //                            [
                            //                                'attribute' => 'senderLastName',
                            //                                'visible'   => $model->senderLastName,
                            //                            ],
                            [
                                'attribute' => 'senderDescription',
                                'visible'   => $model->senderDescription,
                            ],
                            [
                                'attribute' => 'senderPhone',
                                'visible'   => $model->senderPhone,
                            ],
                            [
                                'attribute' => 'senderCity',
                                'visible'   => $model->senderCity,
                            ],
                            [
                                'attribute' => 'senderRegion',
                                'visible'   => $model->senderRegion,
                            ],
                            [
                                'attribute' => 'senderCitySender',
                                'visible'   => $model->senderCitySender,
                            ],
                            [
                                'attribute' => 'senderSenderAddress',
                                'visible'   => $model->senderSenderAddress,
                            ],
                            [
                                'attribute' => 'senderWarehouse',
                                'visible'   => $model->senderWarehouse,
                            ],
                            [
                                'attribute' => 'recipientFirstName',
                                'visible'   => $model->recipientFirstName,
                            ],
                            [
                                'attribute' => 'recipientMiddleName',
                                'visible'   => $model->recipientMiddleName,
                            ],
                            [
                                'attribute' => 'recipientLastName',
                                'visible'   => $model->recipientLastName,
                            ],
                            [
                                'attribute' => 'recipientPhone',
                                'visible'   => $model->recipientPhone,
                            ],
                            [
                                'attribute' => 'recipientCity',
                                'visible'   => $model->recipientCity,
                            ],
                            //                            [
                            //                                'attribute' => 'recipientCityRef',
                            //                                'visible'   => $model->recipientCityRef,
                            //                            ],
                            [
                                'attribute' => 'recipientRegion',
                                'visible'   => $model->recipientRegion,
                            ],
                            [
                                'attribute' => 'recipientWarehouse',
                                'visible'   => $model->recipientWarehouse,
                            ],
                            //                            [
                            //                                'attribute' => 'recipientWarehouseRef',
                            //                                'visible'   => $model->recipientWarehouseRef,
                            //                            ],
                            [
                                'attribute' => 'ServiceType',
                                'visible'   => $model->ServiceType,
                            ],
                            [
                                'attribute' => 'PaymentMethod',
                                'visible'   => $model->PaymentMethod,
                            ],
                            [
                                'attribute' => 'PayerType',
                                'visible'   => $model->PayerType,
                            ],
                            [
                                'attribute' => 'Cost',
                                'visible'   => $model->Cost,
                            ],
                            [
                                'attribute' => 'SeatsAmount',
                                'visible'   => $model->SeatsAmount,
                            ],
                            [
                                'attribute' => 'Description',
                                'visible'   => $model->Description,
                            ],
                            [
                                'attribute' => 'CargoType',
                                'visible'   => $model->CargoType,
                            ],
                            [
                                'attribute' => 'Weight',
                                'visible'   => $model->Weight,
                            ],
                            [
                                'attribute' => 'VolumeGeneral',
                                'visible'   => $model->VolumeGeneral,
                            ],
                            [
                                'attribute' => 'BackDelivery_PayerType',
                                'visible'   => $model->BackDelivery_PayerType,
                            ],
                            [
                                'attribute' => 'BackDelivery_CargoType',
                                'visible'   => $model->BackDelivery_CargoType,
                            ],
                            [
                                'attribute' => 'BackDelivery_RedeliveryString',
                                'visible'   => $model->BackDelivery_RedeliveryString,
                            ],
                            [
                                'attribute' => 'status',
                                'visible'   => $model->status,
                            ],
                            [
                                'attribute' => 'created_at',
                                'format'    => 'datetime',
                                'visible'   => $model->created_at,
                            ],
                            [
                                'attribute' => 'updated_at',
                                'format'    => 'datetime',
                                'visible'   => $model->updated_at,
                            ],
                        ],
                    ]) ?>

                </div>
            </div>
        </div>
    </div>
</div>
