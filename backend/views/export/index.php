<?php
/* @var $this yii\web\View */

/* @var $warehouses \common\models\Warehouse[] */

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

$this->title = Yii::t('app', 'Експорт прайс-листа');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="my-3 my-md-5">
    <div class="container">

        <div class="page-header">
            <h1 class="page-title"><?= Html::encode($this->title) ?></h1>
        </div>

        <div class="card card-lg">
            <div class="card-body">

                <div class="export-index">
                    <?php $form = ActiveForm::begin(); ?>

                    <div class="row">
                        <div class="col-lg-2">
                            <label class="font-weight-bold"><?= Yii::t('app', 'Склади') ?></label>
                            <?= Html::checkboxList('warehouse', array_keys($warehouses), $warehouses, ['separator' => '<br>']) ?>
                        </div>
                        <div class="col-lg-2">
                            <label class="font-weight-bold"><?= Yii::t('app', 'Націнка') ?>, %</label><br>
                            <?= Html::input('number', 'surcharge', 0, ['min' => 0, 'max' => '99']) ?>
                        </div>
                        <div class="col-lg-2">
                            <label class="font-weight-bold"><?= Yii::t('app', 'Валюта') ?></label><br>
                            <?= Html::dropDownList('currency', null, ['USD' => 'USD', 'UAH' => 'UAH']) ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?= Html::submitButton('<i class="fa fa-file-excel-o"></i> ' . Yii::t('app', 'Скачати'), ['class' => 'btn btn-success mt-4']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
