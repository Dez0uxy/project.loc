<?php

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\NpInternetDocument */
/* @var $order common\models\Order */

$this->title = Yii::t('app', 'Створити накладну');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Замовлення') . ' #' . $order->num, 'url' => ['order/view', 'id' => $order->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title"><?= Html::encode($this->title) ?></h1>

            <img src="/images/np.png" height="35" alt="Нова Пошта" style="margin-left: auto;">
        </div>

        <div class="card card-lg">
            <div class="card-body">
                <div class="np-create">

                    <div class="np-internet-document-form">

                        <?php $form = ActiveForm::begin(); ?>

                        <fieldset class="form-fieldset">
                            <label class="form-label"><?= Yii::t('app', 'Відправник') ?></label>

                            <!--div class="row">
                                <div class="col-lg-4">
                                    <?= $form->field($model, 'senderLastName')->textInput(['maxlength' => true]) ?>
                                </div>
                                <div class="col-lg-4">
                                    <?= $form->field($model, 'senderFirstName')->textInput(['maxlength' => true]) ?>
                                </div>
                                <div class="col-lg-4">
                                    <?= $form->field($model, 'senderMiddleName')->textInput(['maxlength' => true]) ?>
                                </div>
                            </div-->

                            <div class="row">
                                <!--div class="col-lg-3">
                                    <?= $form->field($model, 'senderCity')
                                        ->textInput(['maxlength' => true]) ?>
                                </div>
                                <div class="col-lg-3">
                                    <?= $form->field($model, 'senderRegion')->textInput(['maxlength' => true]) ?>
                                </div-->
                                <div class="col-lg-5">
                                    <?= $form->field($model, 'senderWarehouse')
                                        ->dropdownList([
                                                '9d74afbe-ed7d-11e4-8a92-005056887b8d' => 'Відділення №327 (до 30 кг): бульв. Вацлава Гавела, 47/15',
                                                'a90d901f-ed7e-11e4-8a92-005056887b8d' => 'Відділення №330 (до 30 кг): просп. Леся Курбаса, 9г',
                                        ]) ?>
                                </div>
                                <!--div class="col-lg-3">
                                    <?= $form->field($model, 'senderPhone')->textInput(['maxlength' => true]) ?>
                                </div-->
                            </div>
                        </fieldset>

                        <fieldset class="form-fieldset">
                            <label class="form-label"><?= Yii::t('app', 'Отримувач') ?></label>

                            <div class="row">
                                <div class="col-lg-4">
                                    <?= $form->field($model, 'recipientLastName')->textInput(['maxlength' => true]) ?>
                                </div>
                                <div class="col-lg-4">
                                    <?= $form->field($model, 'recipientFirstName')->textInput(['maxlength' => true]) ?>
                                </div>
                                <div class="col-lg-4">
                                    <?= $form->field($model, 'recipientMiddleName')->textInput(['maxlength' => true]) ?>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3">
                                    <?= $form->field($model, 'recipientCity')->textInput(['disabled' => true]) ?>
                                </div>
                                <div class="col-lg-2">
                                    <?= $form->field($model, 'recipientRegion')->textInput(['disabled' => true]) ?>
                                </div>
                                <div class="col-lg-5">
                                    <?= $form->field($model, 'recipientWarehouse')->textInput(['disabled' => true]) ?>
                                </div>
                                <div class="col-lg-2">
                                    <?= $form->field($model, 'recipientPhone')->textInput(['maxlength' => true]) ?>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset class="form-fieldset">
                            <label class="form-label"><?= Yii::t('app', 'Відправлення') ?></label>

                            <div class="row">
                                <!--div class="col-lg-3">
                                    <?= $form->field($model, 'ServiceType')->dropdownList([
                                        'DoorsDoors'         => 'DoorsDoors',
                                        'DoorsWarehouse'     => 'DoorsWarehouse',
                                        'WarehouseWarehouse' => 'WarehouseWarehouse',
                                        'WarehouseDoors'     => 'WarehouseDoors',
                                    ]) ?>
                                </div>
                                <div class="col-lg-3">
                                    <?= $form->field($model, 'PayerType')->dropdownList([
                                        'Sender'      => 'Sender',
                                        'Recipient'   => 'Recipient',
                                        'ThirdPerson' => 'ThirdPerson',
                                    ]) ?>
                                </div>
                                <div class="col-lg-3">
                                    <?= $form->field($model, 'PaymentMethod')->textInput(['maxlength' => true]) ?>
                                </div-->
                            </div>

                            <div class="row">
                                <div class="col-lg-1">
                                    <?= $form->field($model, 'SeatsAmount')->textInput(['type' => 'number']) ?>
                                </div>
                                <div class="col-lg-5">
                                    <?= $form->field($model, 'Description')->textInput(['maxlength' => true]) ?>
                                </div>
                                <div class="col-lg-2">
                                    <?= $form->field($model, 'Weight')->textInput(['placeholder' => '0.2']) ?>
                                </div>
                                <div class="col-lg-2">
                                    <?= $form->field($model, 'VolumeGeneral')->textInput(['placeholder' => '0.5']) ?>
                                </div>
                                <div class="col-lg-2">
                                    <?= $form->field($model, 'Cost')->textInput() ?>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset class="form-fieldset">
                            <label class="form-label"><?= Yii::t('app', 'Зворотня доставка') ?></label>

                            <div class="row">
                                <!--div class="col-lg-4">
                                    <?= $form->field($model, 'BackDelivery_PayerType')->dropdownList([
                                        ''            => '',
                                        'Sender'      => 'Sender',
                                        'Recipient'   => 'Recipient',
                                        'ThirdPerson' => 'ThirdPerson',
                                    ]) ?>
                                </div>
                                <div class="col-lg-4">
                                    <?= $form->field($model, 'BackDelivery_CargoType')->textInput(['maxlength' => true]) ?>
                                </div-->
                                <div class="col-lg-2">
                                    <?= $form->field($model, 'BackDelivery_RedeliveryString')
                                        ->textInput(['type' => 'number', 'step' => '0.01', 'placeholder' => '']) ?>
                                </div>
                            </div>
                        </fieldset>

                        <div class="form-group">
                            <?= Html::submitButton('<i class="fa fa-save"></i>', ['class' => 'btn btn-success']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>

                    </div>


                </div>
            </div>
        </div>
    </div>
</div>
